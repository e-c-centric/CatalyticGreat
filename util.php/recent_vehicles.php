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
function getRecentVehicles($limit = 3)
{
    global $conn;

    $stmt = $conn->prepare("SELECT v.vin, r.recorded_at, p.binary_classification FROM reading_batches r
    JOIN vehicles v on v.vehicle_id = r.vehicle_id
    RIGHT JOIN predictions p ON r.batch_id = p.batch_id
    INNER JOIN (
    SELECT vehicle_id, MAX(recorded_at) AS max_recorded_at
    FROM reading_batches
    GROUP BY vehicle_id) 
    latest ON r.vehicle_id = latest.vehicle_id AND r.recorded_at = latest.max_recorded_at
    ORDER BY r.recorded_at DESC
    LIMIT ?");
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $stmt->bind_result($vehicleId, $recordedAt, $binaryClassification);
    $vehicles = [];
    while ($stmt->fetch()) {
        $vehicles[] = [
            'vehicle_id' => $vehicleId,
            'recorded_at' => $recordedAt,
            'binary_classification' => $binaryClassification
        ];
    }
    $stmt->close();
    return $vehicles;
}
$recentVehicles = getRecentVehicles();
echo json_encode($recentVehicles);
