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

// Step 1: Get all batch_ids for this vehicle
$stmt = $conn->prepare("SELECT batch_id FROM reading_batches WHERE vehicle_id = ?");
$stmt->bind_param("i", $vehicleId);
$stmt->execute();
$result = $stmt->get_result();

$batchIds = [];
while ($row = $result->fetch_assoc()) {
    $batchIds[] = $row['batch_id'];
}
$stmt->close();

if (empty($batchIds)) {
    http_response_code(404);
    echo json_encode(['error' => 'No batches found for this vehicle']);
    exit;
}

// Step 2: Get predictions for these batch_ids, ordered by prediction_id DESC, limited to 10
$placeholders = implode(',', array_fill(0, count($batchIds), '?'));
$types = str_repeat('i', count($batchIds));
$query = "SELECT batch_id, binary_classification, trouble_code_category, remaining_lifetime_hours 
          FROM predictions 
          WHERE batch_id IN ($placeholders) 
          ORDER BY prediction_id DESC 
          LIMIT 10";

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$batchIds);
$stmt->execute();
$result = $stmt->get_result();

$predictions = [];
while ($row = $result->fetch_assoc()) {
    $predictions[] = [
        'batch_id' => $row['batch_id'],
        'car_health' => ($row['binary_classification'] === 'normal') ? 'Normal' : 'Issue',
        'predicted_dtc' => $row['trouble_code_category'],
        'remaining_useful_life' => $row['remaining_lifetime_hours']
    ];
}

if (!empty($predictions)) {
    echo json_encode($predictions);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'No predictions found for this vehicle']);
}

$stmt->close();
