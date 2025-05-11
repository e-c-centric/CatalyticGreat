document.addEventListener('DOMContentLoaded', function () {

    // Recent vehicles
    fetch('../util.php/recent_vehicles.php')
        .then(response => response.json())
        .then(data => {
            const recentVehiclesTbody = document.getElementById('recent-vehicles');
            if (!recentVehiclesTbody) return;

            if (data.length === 0) {
                recentVehiclesTbody.innerHTML = `<tr><td colspan="4">No recent vehicles found.</td></tr>`;
            } else {
                recentVehiclesTbody.innerHTML = data.map(vehicle => `
                <tr>
                    <td>${vehicle.vehicle_id}</td>
                    <td>${new Date(vehicle.recorded_at).toLocaleString()}</td>
                    <td>
                        <span class="${vehicle.binary_classification === 'normal' ? 'text-success' : 'text-danger'}">
                            ${vehicle.binary_classification === 'normal' ? 'Healthy' : 'Issue'}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-outline btn-sm" onclick="loadVehicle('${vehicle.vehicle_id}')">View</button>
                    </td>
                </tr>
            `).join('');
            }
        })
        .catch(err => {
            console.error('Failed to fetch recent vehicles:', err);
        });

    // Stats
    fetch('../util.php/stats.php')
        .then(response => response.json())
        .then(data => {
            document.querySelectorAll('.stat-card h3').forEach((el, idx) => {
                if (el.textContent.includes('Total Vehicles')) {
                    el.nextElementSibling.textContent = data.numVehicles;
                }
                if (el.textContent.includes('Healthy Catalysts')) {
                    el.nextElementSibling.textContent = data.numHealthyCatalysts;
                }
                if (el.textContent.includes('Catalyst Issues')) {
                    el.nextElementSibling.textContent = data.numUnhealthyCatalysts;
                }
            });
        })
        .catch(err => {
            console.error('Failed to fetch stats:', err);
        });

    // Search form handler
    const searchForm = document.getElementById('search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const vinInput = document.getElementById('vin-search');
            let searchValue = vinInput.value.trim().toUpperCase();
            searchValue = searchValue.replace(/[^A-Za-z0-9]/g, '');

            if (searchValue === '') {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter a valid VIN',
                    icon: 'error',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#7E69AB'
                });
                return;
            }

            localStorage.setItem('selectedVin', searchValue);
            window.location.href = 'vehicle-info.php';
        });
    }

    // Load vehicle info if on vehicle info page
    const vehicleInfoContainer = document.querySelector('.vehicle-info-container');
    if (vehicleInfoContainer) {
        const selectedVin = localStorage.getItem('selectedVin');
        if (selectedVin) {
            fetch(`../util.php/vehicle_data.php?vin=${encodeURIComponent(selectedVin)}`)
                .then(response => response.json())
                .then(batches => {
                    if (!Array.isArray(batches) || batches.length === 0) {
                        Swal.fire({
                            title: 'Vehicle Not Found',
                            text: 'No data found for this VIN.',
                            icon: 'warning',
                            confirmButtonText: 'Back',
                            confirmButtonColor: '#7E69AB'
                        }).then(() => {
                            window.location.href = 'index.php';
                        });
                        return;
                    }
                    loadVehicleInfo(batches, selectedVin);
                })
                .catch(() => {
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to fetch vehicle data.',
                        icon: 'error',
                        confirmButtonText: 'Back',
                        confirmButtonColor: '#7E69AB'
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                });
        } else {
            window.location.href = 'index.php';
        }
    }

    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-btn');
    if (tabButtons.length > 0) {
        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
                this.classList.add('active');
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    }

    // Stat balloon click handler
    const statBalloons = document.querySelectorAll('.stat-balloon');
    if (statBalloons.length > 0) {
        statBalloons.forEach(balloon => {
            balloon.addEventListener('click', function () {
                const statType = this.getAttribute('data-stat');
                const selectedVin = localStorage.getItem('selectedVin');
                // You may want to show stat details for the latest batch
                // This is left as an exercise for your UI
            });
        });
    }

    // // CarMuse functionality if on carmuse page
    // const carmuseForm = document.getElementById('carmuse-form');
    // if (carmuseForm) {
    //     carmuseForm.addEventListener('submit', function (e) {
    //         e.preventDefault();
    //         const queryInput = document.getElementById('carmuse-input');
    //         const query = queryInput.value.trim();

    //         if (query === '') {
    //             Swal.fire({
    //                 title: 'Empty Query',
    //                 text: 'Please enter a question or search term',
    //                 icon: 'warning',
    //                 confirmButtonText: 'Ok',
    //                 confirmButtonColor: '#7E69AB'
    //             });
    //             return;
    //         }

    //         document.getElementById('carmuse-spinner').style.display = 'block';
    //         setTimeout(() => {
    //             document.getElementById('carmuse-spinner').style.display = 'none';
    //             processCarmuseQuery(query);
    //         }, 1000);
    //     });
    // }

    // Close panel button
    const closePanel = document.querySelector('.close-panel');
    if (closePanel) {
        closePanel.addEventListener('click', function () {
            document.querySelector('.detail-panel').classList.remove('open');
        });
    }

    // Functions to handle vehicle info
    function loadVehicleInfo(batches, vin) {
        // Use the latest batch for summary stats
        const latest = batches[0];

        document.querySelector('.vehicle-title').textContent = `Vehicle: ${vin}`;

        const health = latest.predictions?.binary_classification === 'normal' ? 'Healthy' : 'Issue Detected';
        const healthClass = latest.predictions?.binary_classification === 'normal' ? 'text-success' : 'text-danger';
        document.querySelector('.health .stat-value').textContent = health;
        document.querySelector('.health .stat-value').className = `stat-value ${healthClass}`;

        document.querySelector('.lifetime .stat-value').textContent =
            latest.predictions?.remaining_lifetime_hours !== undefined
                ? `${Math.round(latest.predictions.remaining_lifetime_hours / 24).toLocaleString()} days`
                : 'N/A';

        // 

        // Find warm-ups and temperature from latest batch
        let warmups = null, tempRange = null;
        if (Array.isArray(latest.readings)) {
            const warmupReading = latest.readings.find(r => r.field_name && r.field_name.toLowerCase().includes('warm-up'));
            warmups = warmupReading ? warmupReading.value : 'N/A';

            const catTemps = latest.readings
                .filter(r => r.field_name && r.field_name.toLowerCase().includes('cat temperature'))
                .map(r => r.value)
                .filter(v => typeof v === 'number');
            if (catTemps.length > 0) {
                const minTemp = Math.min(...catTemps);
                const maxTemp = Math.max(...catTemps);
                tempRange = `${Math.round(minTemp)}-${Math.round(maxTemp)}°C`;
            }
        }
        document.querySelector('.warmups .stat-value').textContent = warmups !== null ? warmups : 'N/A';
        document.querySelector('.temperature .stat-value').textContent = tempRange || 'N/A';

        // Populate Reading Batches table
        const readingsList = document.getElementById('readings-list');
        readingsList.innerHTML = '';
        batches.forEach(batch => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${batch.batch_id || ''}</td>
                <td>${batch.number_of_pids || (batch.readings ? batch.readings.length : '')}</td>
                <td>${batch.user_name || ''}</td>
                <td>
                    <button class="btn btn-outline btn-sm view-batch-btn" data-batch-id="${batch.batch_id}">
                        View Data
                    </button>
                </td>
            `;
            readingsList.appendChild(row);
        });

        // Add event listeners to batch view buttons
        document.querySelectorAll('.view-batch-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const batchId = this.getAttribute('data-batch-id');
                const batch = batches.find(b => b.batch_id == batchId);
                if (batch) showBatchDetail(batch);
            });
        });

        const categoryCodeMap = {
            0: 'P0133',
            1: 'C0300',
            2: 'P0079P2004P3000',
            3: 'P0078U1004P3000',
            4: 'P0079C1004P3000',
            5: 'P007EP2036P18F0',
            6: 'P007EP2036P18D0',
            7: 'P007FP2036P18D0',
            8: 'P0079P1004P3000',
            9: 'P007EP2036P18E0',
            10: 'P007FP2036P18E0',
            11: 'P0078B0004P3000',
            12: 'P007FP2036P18F0'
        };

        // Populate Predictions table (show all batches' predictions)
        const predictionsList = document.getElementById('predictions-list');
        predictionsList.innerHTML = '';
        batches.forEach(batch => {
            if (!batch.predictions) return;

            const health = batch.predictions.binary_classification === 'normal'
                ? 'Healthy'
                : 'Issue Detected';
            const healthClass = batch.predictions.binary_classification === 'normal'
                ? 'text-success'
                : 'text-danger';

            const catNum = batch.predictions.trouble_code_category;
            let troubleDisplay;
            if (catNum === 13) {
                troubleDisplay = 'No DTC Detected';
            } else if (categoryCodeMap.hasOwnProperty(catNum)) {
                const code = categoryCodeMap[catNum];
                troubleDisplay = `<a href="#" class="dtc-chat-link" data-code="${code}">${code}</a>`;
            } else {
                troubleDisplay = catNum ?? 'N/A';
            }

            const predRow = document.createElement('tr');
            predRow.innerHTML = `
            <td class="${healthClass}">${health}</td>
            <td>${batch.predictions.remaining_lifetime_hours !== undefined
                    ? Math.round(batch.predictions.remaining_lifetime_hours / 24).toLocaleString() + ' days'
                    : 'N/A'
                }</td>
            <td>${troubleDisplay}</td>
            <td>
                <button class="btn btn-outline btn-sm view-prediction-btn" data-batch-id="${batch.batch_id}">
                    Details
                </button>
            </td>
        `;
            predictionsList.appendChild(predRow);
        });

        document.querySelectorAll('.dtc-chat-link').forEach(el => {
            el.addEventListener('click', e => {
                e.preventDefault();
                const code = el.dataset.code;
                const prompt = `I am staff at DVLA. I am checking how fit for purpose this vehicle is. Explain the diagnostic trouble code that follows, stating it is roadworthy, and any recommendations you have: ${code}`;
                const url =
                    'https://chat.openai.com/?model=gpt-4&prompt=' +
                    encodeURIComponent(prompt);
                window.open(url, '_blank');
            });
        });

        // Add event listeners to prediction view buttons
        document.querySelectorAll('.view-prediction-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const batchId = this.getAttribute('data-batch-id');
                const batch = batches.find(b => b.batch_id == batchId);
                if (batch) showPredictionDetail(batch.predictions, batch);
            });
        });

        renderPredictionCharts(batches);

        // Access logs tab (not available in backend data)
        const accessList = document.getElementById('access-list');
        accessList.innerHTML = `<tr><td colspan="5">No access logs available.</td></tr>`;
    }

    // Show all readings for the batch in the detail panel
    function showBatchDetail(batch) {
        const panel = document.querySelector('.detail-panel');
        const panelTitle = panel.querySelector('.panel-title');
        const panelContent = panel.querySelector('.panel-content');

        panelTitle.textContent = `Batch: ${batch.batch_id}`;
        let contentHtml = `
            <h3 class="mb-2">Reading Batch ${batch.batch_id}</h3>
            <p class="mb-2">Date: ${batch.recorded_at ? new Date(batch.recorded_at).toLocaleString() : ''}</p>
            <p class="mb-2">Submitted by: ${batch.user_name || ''}</p>
            <p class="mb-3">Total PIDs: ${batch.number_of_pids || (batch.readings ? batch.readings.length : '')}</p>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>PID</th>
                        <th>Field Name</th>
                        <th>Value</th>
                        <th>Units</th>
                    </tr>
                </thead>
                <tbody>
        `;
        if (Array.isArray(batch.readings)) {
            batch.readings.forEach(reading => {
                contentHtml += `
                    <tr>
                        <td>${reading.pid}</td>
                        <td>${reading.field_name}</td>
                        <td>${reading.value}</td>
                        <td>${reading.units || ''}</td>
                    </tr>
                `;
            });
        }
        contentHtml += `
                </tbody>
            </table>
        `;
        panelContent.innerHTML = contentHtml;
        panel.classList.add('open');
    }

    // Show prediction details (customize as needed)
    function showPredictionDetail(prediction, batch) {
        const panel = document.querySelector('.detail-panel');
        const panelTitle = panel.querySelector('.panel-title');
        const panelContent = panel.querySelector('.panel-content');

        panelTitle.textContent = `Prediction: ${batch.recorded_at ? new Date(batch.recorded_at).toLocaleDateString() : ''}`;

        const healthStatus = prediction.binary_classification === 'normal' ? 'Healthy' : 'Issue Detected';
        const healthClass = prediction.binary_classification === 'normal' ? 'text-success' : 'text-danger';

        let contentHtml = `
            <h3 class="mb-2">Prediction Details</h3>
            <div class="card mb-3">
                <p><strong>Health Status:</strong> <span class="${healthClass}">${healthStatus}</span></p>
                <p><strong>Remaining Lifetime:</strong> ${prediction.remaining_lifetime_hours !== undefined ? Math.round(prediction.remaining_lifetime_hours / 24).toLocaleString() + ' days' : 'N/A'}</p>
                <p><strong>Trouble Category:</strong> ${prediction.trouble_code_category ?? 'N/A'}</p>
            </div>
        `;
        panelContent.innerHTML = contentHtml;
        panel.classList.add('open');
    }

    // Utility functions
    function formatTimestamp(timestamp) {
        const date = new Date(timestamp);
        return date.toLocaleString();
    }

    const carmuseForm = document.getElementById('carmuse-form');
    const carmuseInput = document.getElementById('carmuse-input');
    const carmuseSpinner = document.getElementById('carmuse-spinner');
    const carmuseResults = document.getElementById('carmuse-results');
    const recentKey = 'carmuse_recent_queries';

    // Load recent queries from localStorage
    function loadRecentQueries() {
        let recent = JSON.parse(localStorage.getItem(recentKey) || '[]');
        const tbody = document.querySelector('.card tbody');
        tbody.innerHTML = '';
        if (recent.length === 0) {
            tbody.innerHTML = '<tr><td colspan="3">No recent queries.</td></tr>';
        } else {
            recent.slice().reverse().forEach(q => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${q.timestamp}</td>
                    <td>${q.query}</td>
                    <td><button class="btn btn-outline btn-sm run-again-btn">Run Again</button></td>
                `;
                tr.querySelector('.run-again-btn').addEventListener('click', function () {
                    carmuseInput.value = q.query;
                    carmuseForm.dispatchEvent(new Event('submit'));
                });
                tbody.appendChild(tr);
            });
        }
    }

    // Save a query to localStorage
    function saveQuery(query) {
        let recent = JSON.parse(localStorage.getItem(recentKey) || '[]');
        // Remove duplicates
        recent = recent.filter(q => q.query !== query);
        // Add new query
        recent.push({
            query,
            timestamp: new Date().toISOString().slice(0, 16).replace('T', ' ')
        });
        // Keep only last 10
        if (recent.length > 10) recent = recent.slice(-10);
        localStorage.setItem(recentKey, JSON.stringify(recent));
        loadRecentQueries();
    }

    // Show analysis result
    function showAnalysis(analysis) {
        carmuseResults.innerHTML = `
            <div class="carmuse-result">
                <div class="carmuse-answer" style="white-space:pre-wrap;">${marked.parse(analysis)}</div>
            </div>
        `;
    }

    // Handle form submit
    if (carmuseForm) {
        carmuseForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const query = carmuseInput.value.trim();
            if (!query) return;

            carmuseSpinner.style.display = 'block';
            fetch('../util.php/cai.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ question: query })
            })
                .then(res => res.json())
                .then(data => {
                    carmuseSpinner.style.display = 'none';
                    if (data.analysis) {
                        showAnalysis(data.analysis);
                        saveQuery(query);
                    } else if (data.error) {
                        carmuseResults.innerHTML = `<div class="carmuse-result"><p class="carmuse-answer text-danger">${data.error}</p></div>`;
                    } else {
                        carmuseResults.innerHTML = `<div class="carmuse-result"><p class="carmuse-answer text-danger">No analysis returned.</p></div>`;
                    }
                })
                .catch(() => {
                    carmuseSpinner.style.display = 'none';
                    carmuseResults.innerHTML = `<div class="carmuse-result"><p class="carmuse-answer text-danger">An error occurred. Please try again.</p></div>`;
                });
        });
    }

    // On page load
    loadRecentQueries();
});

// Function to load a vehicle from CarMuse page or "View" button
function loadVehicle(vin) {
    vin = vin.replace(/[^A-Za-z0-9]/g, '');
    localStorage.setItem('selectedVin', vin);
    window.location.href = 'vehicle-info.php';
}

function renderPredictionCharts(batches) {
    // sort oldest→newest, keep last 100
    batches.sort((a, b) => new Date(a.recorded_at) - new Date(b.recorded_at));
    const recent = batches.slice(-100);

    // data arrays
    const idx = recent.map((_, i) => i + 1);
    const health = recent.map(b => b.predictions?.binary_classification === 'normal' ? 1 : 0);
    const dtc = recent.map(b => b.predictions?.trouble_code_category ?? null);
    const lifetime = recent.map(b => b.predictions?.remaining_lifetime_hours !== undefined
        ? Math.round(b.predictions.remaining_lifetime_hours / 24)
        : null);

    // common opts
    const common = {
        maintainAspectRatio: false,
        scales: {
            x: { display: false },
            y: { grid: { color: '#eee' } }
        },
        plugins: {
            legend: { display: false },
            tooltip: { enabled: true },
            title: { display: true, text: '' }
        }
    };

    // 1) Health (step area)

    new Chart('healthChart', {
        type: 'bar',
        data: {
            labels: recent.map((_, i) => i + 1),
            datasets: [{
                data: health,
                backgroundColor: health.map(v => v === 1
                    ? 'var(--success)'
                    : 'var(--danger)')
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                x: { display: false },
                y: { min: 0, max: 1, ticks: { stepSize: 1, callback: v => v }, grid: { color: '#eee' } }
            },
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true },
                title: { display: true, text: 'Catalyst Health' }
            }
        }
    });

    // 2) DTC (stepped line)
    new Chart('dtcChart', {
        type: 'line',
        data: {
            labels: idx, datasets: [{
                data: dtc,
                borderColor: '#ffc107',
                backgroundColor: 'rgba(255,193,7,0.2)',
                fill: true,
                stepped: 'middle',
                pointRadius: 3
            }]
        },
        options: {
            ...common,
            scales: {
                x: common.scales.x,
                y: { min: 0, max: 13, ticks: { stepSize: 1 }, grid: { color: '#eee' } }
            },
            plugins: {
                ...common.plugins,
                title: { text: 'Trouble Code Category (0–13)' }
            }
        }
    });

    // 3) Lifetime (smooth line)
    new Chart('lifetimeChart', {
        type: 'line',
        data: {
            labels: idx, datasets: [{
                data: lifetime,
                borderColor: '#1EAEDB',
                backgroundColor: 'rgba(30,174,219,0.2)',
                fill: true,
                tension: 0.4,
                pointRadius: 2
            }]
        },
        options: {
            ...common,
            scales: {
                x: common.scales.x,
                y: { beginAtZero: true, grid: { color: '#eee' } }
            },
            plugins: {
                ...common.plugins,
                title: { text: 'Remaining Useful Life (days)' }
            }
        }
    });
}