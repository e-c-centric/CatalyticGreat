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
    <title>CarMuse | CatalyticGreat+</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
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
        <div class="carmuse-container">
            <h1 class="text-center mb-3">CarMuse</h1>
            <p class="text-center mb-4">Ask questions about vehicles in natural language</p>

            <form id="carmuse-form">
                <div class="carmuse-search">
                    <input type="text" id="carmuse-input" class="carmuse-input"
                        placeholder="e.g., 'Show me the cars with engine issues reported in the last 7 days'"
                        autocomplete="off">
                    <button type="submit" class="carmuse-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <div class="spinner" id="carmuse-spinner"></div>

            <div id="carmuse-results">
                <!-- Results will appear here -->
                <div class="carmuse-result">
                    <p class="carmuse-answer">Welcome to CarMuse! Ask a question about vehicles to get started.</p>
                    <p>Try questions like:</p>
                    <ul style="list-style-type: disc; margin-left: 1.5rem; margin-top: 0.5rem;">
                        <li>"What is the catalyst health of vehicle GX224-24"</li>
                        <li>"Show me the cars with engine issues reported in the last 7 days"</li>
                        <li>"How many warm-ups has vehicle testtrial123 had?"</li>
                    </ul>
                </div>
            </div>

            <div class="text-center mt-4">
                <h3 class="mb-2">Recent Queries</h3>
                <div class="card">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Query</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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