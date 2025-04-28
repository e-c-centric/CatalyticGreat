<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../');
    exit();
} elseif ($_SESSION['role'] !== 'dvla') {
    header('Location: ../');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CatalyticGreat+ | DVLA Vehicle Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <section class="search-container">
            <h1 class="text-center mb-3">DVLA Vehicle Catalyst Dashboard</h1>
            <p class="text-center mb-3">Enter a license plate number to view detailed catalyst health
                information</p>

            <form id="search-form">
                <div class="search-input-group">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="vin-search" class="search-input"
                        placeholder="Enter license plate number (e.g., GC-2245-25)" autocomplete="off">
                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </section>

        <section class="mt-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Recent Activity</h2>
                </div>
                <p class="mb-2">The following vehicles have had recent catalyst readings or updates:</p>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>VIN</th>
                            <th>Update Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="recent-vehicles">
                        <!-- Dynamic recent vehicles will be inserted here by JS -->
                    </tbody>
                </table>
            </div>
        </section>

        <section class="mt-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Quick Stats</h2>
                </div>
                <div class="grid-container"
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 1rem;">
                    <div class="stat-card"
                        style="background-color: rgba(126, 105, 171, 0.1); padding: 1rem; border-radius: 5px; text-align: center;">
                        <i class="fas fa-car mb-2" style="font-size: 2rem; color: var(--primary-purple);"></i>
                        <h3>Total Vehicles</h3>
                        <p style="font-size: 1.5rem; font-weight: 600;">_</p>
                    </div>
                    <div class="stat-card"
                        style="background-color: rgba(30, 174, 219, 0.1); padding: 1rem; border-radius: 5px; text-align: center;">
                        <i class="fas fa-check-circle mb-2" style="font-size: 2rem; color: var(--accent-blue);"></i>
                        <h3>Healthy Catalysts</h3>
                        <p style="font-size: 1.5rem; font-weight: 600;">_</p>
                    </div>
                    <div class="stat-card"
                        style="background-color: rgba(220, 53, 69, 0.1); padding: 1rem; border-radius: 5px; text-align: center;">
                        <i class="fas fa-exclamation-triangle mb-2" style="font-size: 2rem; color: var(--danger);"></i>
                        <h3>Catalyst Issues</h3>
                        <p style="font-size: 1.5rem; font-weight: 600;">_</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

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