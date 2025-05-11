<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'User not logged in']);
    header('Location: ../login.php');
    exit;
}
// Check if the user has the required role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'dvla') {
    http_response_code(403);
    echo json_encode(['error' => 'User does not have permission']);
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Details | CatalyticGreat+</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <header>
        <div class="container header-container">
            <a href="index.php" class="logo">Catalytic<span>Great+</span></a>
            <button class="menu-toggle mobile-menu-button" aria-label="Toggle Menu">
                <i class="fas fa-bars"></i>
            </button>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="carmuse.php">CarMuse</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <!-- Vehicle Search -->
        <section class="search-container">
            <form id="search-form">
                <div class="search-input-group">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="vin-search" class="search-input"
                        placeholder="Enter license plate number (e.g. GR-224-23))" autocomplete="off">
                </div>
            </form>
        </section>

        <!-- Vehicle Info Section with Graphic and Balloons -->
        <section>
            <h2 class="vehicle-title mb-3">Vehicle: Loading...</h2>
            <div class="vehicle-info-container">
                <div class="vehicle-graphic-container">
                    <!-- Vehicle Graphic -->
                    <svg class="vehicle-graphic" viewBox="0 0 512 256" xmlns="http://www.w3.org/2000/svg">
                        <!-- Car body -->
                        <path
                            d="M30,180 L90,180 C90,180 110,140 170,140 L320,140 C380,140 400,180 400,180 L480,180 L480,200 L30,200 Z"
                            fill="#7E69AB" />
                        <!-- Car top -->
                        <path d="M130,140 L170,80 L320,80 L360,140 L130,140 Z" fill="#9b87f5" />
                        <!-- Windows -->
                        <path d="M140,140 L175,90 L315,90 L350,140 Z" fill="#c8e6ff" />
                        <!-- Wheels -->
                        <circle cx="120" cy="200" r="30" fill="#333" />
                        <circle cx="120" cy="200" r="15" fill="#666" />
                        <circle cx="390" cy="200" r="30" fill="#333" />
                        <circle cx="390" cy="200" r="15" fill="#666" />
                        <!-- Car details -->
                        <rect x="380" y="155" width="20" height="10" fill="#ff5555" />
                        <rect x="30" y="155" width="20" height="10" fill="#ffaa55" />
                    </svg>

                    <!-- Stats Balloons -->
                    <div class="stats-container">
                        <div class="stat-balloon health" data-stat="health">
                            <div class="stat-title">Catalyst Health</div>
                            <div class="stat-value">Loading...</div>
                        </div>

                        <div class="stat-balloon lifetime" data-stat="lifetime">
                            <div class="stat-title">Remaining Lifetime</div>
                            <div class="stat-value">Loading...</div>
                        </div>

 

                        <div class="stat-balloon warmups" data-stat="warmups">
                            <div class="stat-title">Warm-up Count</div>
                            <div class="stat-value">Loading...</div>
                        </div>

                        <div class="stat-balloon temperature" data-stat="temperature">
                            <div class="stat-title">Engine Temp Range</div>
                            <div class="stat-value">Loading...</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tabs Section -->
        <section class="tabs-container">
            <div class="tabs-header">
                <button class="tab-btn active" data-tab="readings-tab">Reading Batches</button>
                <button class="tab-btn" data-tab="predictions-tab">Predictions History</button>
                <button class="tab-btn" data-tab="access-tab">Access Logs</button>
                    <button class="tab-btn"           data-tab="charts-tab">Charts</button>

            </div>

            <!-- Tab Content -->
            <div id="readings-tab" class="tab-content active">
                <h3 class="mb-3">Reading Batches</h3>
                <p class="mb-2">Chronological list of all data batches collected for this vehicle:</p>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Batch ID</th>
                            <th>PIDs Included</th>
                            <th>Submitted By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="readings-list">
                        <!-- Data will be loaded here -->
                    </tbody>
                </table>
            </div>

            <div id="predictions-tab" class="tab-content">
                <h3 class="mb-3">Predictions History</h3>
                <p class="mb-2">Timeline of vehicle's health status and predictions:</p>
                <div class="charts-container mb-4" style="display: grid; grid-gap:2rem; grid-template-columns: repeat(auto-fit,minmax(200px,1fr));">
            
        </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Health Status</th>
                            <th>Days Until Failure</th>
                            <th>Trouble Category (click to find out more)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="predictions-list">
                        <!-- Data will be loaded here -->
                    </tbody>
                </table>
            </div>

            <div id="access-tab" class="tab-content">
                <h3 class="mb-3">Access Logs</h3>
                <p class="mb-2">Records of mechanic or system access events for this vehicle:</p>
                <div class="mb-3">
                    <label class="inline-flex items-center" style="display: inline-flex; align-items: center;">
                        <input type="checkbox" id="failed-access-toggle" style="margin-right: 0.5rem;">
                        <span>Show only failed access attempts</span>
                    </label>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>Mechanic ID</th>
                            <th>Access Method</th>
                            <th>Action</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="access-list">
                        <!-- Data will be loaded here -->
                    </tbody>
                </table>
            </div>

<div id="charts-tab" class="tab-content">
  <h3 class="mb-3">Charts Overview</h3>
  <div class="charts-grid">
    <div class="chart-card">
      <h4>Catalyst Health</h4>
      <canvas id="healthChart"></canvas>
      <div class="chart-legend">
    <div><span class="legend-marker issue"></span>Issue (0)</div>
    <div><span class="legend-marker normal"></span>Normal (1)</div>
  </div>
    </div>
    <div class="chart-card">
      <h4>Trouble Code Category</h4>
      <canvas id="dtcChart"></canvas>
    </div>
    <div class="chart-card">
      <h4>Remaining Useful Life (days)</h4>
      <canvas id="lifetimeChart"></canvas>
    </div>
  </div>
</div>

        </section>
    </main>

    <!-- Detail Panel (Sidebar) -->
    <div class="detail-panel">
        <div class="panel-header">
            <h2 class="panel-title">Stat Detail</h2>
            <button class="close-panel">&times;</button>
        </div>
        <div class="panel-content">
            <!-- Content will be loaded dynamically -->
        </div>
    </div>

    <footer
        style="background-color: var(--dark-gray); color: var(--white); padding: 2rem 0; margin-top: 2rem; text-align: center;">
        <div class="container">
            <p>&copy; 2025 CatalyticGreat+ | DVLA Vehicle Dashboard</p>
        </div>
    </footer>

    <script src="https://cdn.gpteng.co/gptengineer.js" type="module"></script>
    <script src="scripts.js"></script>
</body>

</html>