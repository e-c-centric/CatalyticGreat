<?php

header('Content-Type: application/json');

require_once '../settings/config.php';

// --- Logging ---
$logFile = 'api.log';
$logData = [
    'datetime' => date('Y-m-d H:i:s'),
    'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
    'endpoint' => $_SERVER['REQUEST_URI'] ?? 'unknown',
    'params' => $_REQUEST,
];
file_put_contents($logFile, json_encode($logData) . PHP_EOL, FILE_APPEND);
// --- End Logging ---

if (!isset($_REQUEST['vehicle_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Vehicle ID not provided']);
    exit;
}

$vehicleId = intval($_REQUEST['vehicle_id']);

// Get the latest batch_id for this vehicle
$stmt = $conn->prepare("SELECT batch_id FROM reading_batches WHERE vehicle_id = ? ORDER BY recorded_at DESC LIMIT 1");
$stmt->bind_param("i", $vehicleId);
$stmt->execute();
$stmt->bind_result($batchId);
if (!$stmt->fetch()) {
    http_response_code(404);
    echo json_encode(['error' => 'No batch found for this vehicle']);
    exit;
}
$stmt->close();

// Get the latest prediction for this batch
$stmt = $conn->prepare("SELECT binary_classification, trouble_code_category, remaining_lifetime_hours FROM predictions WHERE batch_id = ? ORDER BY prediction_id DESC LIMIT 1");
$stmt->bind_param("i", $batchId);
$stmt->execute();
$stmt->bind_result($carHealth, $dtc, $rul);
if ($stmt->fetch()) {
    echo json_encode([
        'car_health' => ($carHealth === 'normal') ? 'Normal' : 'Issue',
        'predicted_dtc' => $dtc,
        'remaining_useful_life' => $rul
    ]);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'No prediction found for this vehicle']);
}
$stmt->close();
