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
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'mechanic') {
    echo json_encode(['error' => 'User does not have permission']);
    exit;
}

function systemStats()
{
    global $conn;
    $userId = $_SESSION['user_id'];

    $stats = [];

    // Only count vehicles where this user has submitted a batch
    $numVehiclesStmt = $conn->prepare("SELECT COUNT(DISTINCT vehicle_id) FROM reading_batches WHERE user_id = ?");
    $numVehiclesStmt->bind_param("i", $userId);
    $numVehiclesStmt->execute();
    $numVehiclesStmt->bind_result($numVehicles);
    $numVehiclesStmt->fetch();
    $numVehiclesStmt->close();
    $stats['numVehicles'] = $numVehicles;

    $numHealthyCatalystsStmt = $conn->prepare(
        "SELECT COUNT(DISTINCT rb.vehicle_id)
         FROM predictions p
         JOIN reading_batches rb ON p.batch_id = rb.batch_id
         WHERE p.binary_classification = 'normal' AND rb.user_id = ?"
    );
    $numHealthyCatalystsStmt->bind_param("i", $userId);
    $numHealthyCatalystsStmt->execute();
    $numHealthyCatalystsStmt->bind_result($numHealthyCatalysts);
    $numHealthyCatalystsStmt->fetch();
    $numHealthyCatalystsStmt->close();
    $stats['numHealthyCatalysts'] = $numHealthyCatalysts;

    $numUnhealthyCatalystsStmt = $conn->prepare(
        "SELECT COUNT(DISTINCT rb.vehicle_id)
         FROM predictions p
         JOIN reading_batches rb ON p.batch_id = rb.batch_id
         WHERE p.binary_classification = 'issue' AND rb.user_id = ?"
    );
    $numUnhealthyCatalystsStmt->bind_param("i", $userId);
    $numUnhealthyCatalystsStmt->execute();
    $numUnhealthyCatalystsStmt->bind_result($numUnhealthyCatalysts);
    $numUnhealthyCatalystsStmt->fetch();
    $numUnhealthyCatalystsStmt->close();
    $stats['numUnhealthyCatalysts'] = $numUnhealthyCatalysts;

    return $stats;
}

echo json_encode(systemStats());