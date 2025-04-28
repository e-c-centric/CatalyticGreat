<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=UTF-8');

require_once '../settings/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['user_id']) || !isset($_POST['vin'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing user_id or vin']);
        exit;
    }

    $user_id = $_POST['user_id'];
    $vin = $_POST['vin'];

    $stmt = $conn->prepare("INSERT INTO vehicles (user_id, vin) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $vin);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Vehicle added successfully', 'vehicle_id' => $stmt->insert_id]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to add vehicle']);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
