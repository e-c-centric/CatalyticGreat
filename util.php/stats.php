<?php
header('Content-Type: application/json');


require_once '../settings/config.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}
// Check if the user has the required role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'dvla') {
    echo json_encode(['error' => 'User does not have permission']);
    exit;
}

function systemStats()
{
    global $conn;

    $stats = [];

    $numVehiclesStmt = $conn->prepare("SELECT COUNT(DISTINCT vehicle_id) FROM reading_batches");
    $numVehiclesStmt->execute();
    $numVehiclesStmt->bind_result($numVehicles);
    $numVehiclesStmt->fetch();
    $numVehiclesStmt->close();
    $stats['numVehicles'] = $numVehicles;

    $numHealthyCatalystsStmt = $conn->prepare("SELECT COUNT(DISTINCT vehicle_id) from predictions join reading_batches on predictions.batch_id = reading_batches.batch_id where predictions.binary_classification = 'normal'");
    $numHealthyCatalystsStmt->execute();
    $numHealthyCatalystsStmt->bind_result($numHealthyCatalysts);
    $numHealthyCatalystsStmt->fetch();
    $numHealthyCatalystsStmt->close();
    $stats['numHealthyCatalysts'] = $numHealthyCatalysts;

    $numUnhealthyCatalystsStmt = $conn->prepare("SELECT COUNT(DISTINCT vehicle_id) from predictions join reading_batches on predictions.batch_id = reading_batches.batch_id where predictions.binary_classification = 'issue'");
    $numUnhealthyCatalystsStmt->execute();
    $numUnhealthyCatalystsStmt->bind_result($numUnhealthyCatalysts);
    $numUnhealthyCatalystsStmt->fetch();
    $numUnhealthyCatalystsStmt->close();
    $stats['numUnhealthyCatalysts'] = $numUnhealthyCatalysts;

    return $stats;
}

echo json_encode(systemStats());
