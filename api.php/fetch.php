<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=UTF-8');

require_once '../settings/config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['user_id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing user_id']);
        exit;
    }

    $user_id = $_POST['user_id'];

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT vehicle_id, vin FROM vehicles WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $vehicles = [];
    while ($row = $result->fetch_assoc()) {
        $vehicles[] = $row;
    }

    if (empty($vehicles)) {
        http_response_code(404);
        echo json_encode(['message' => 'No vehicles found for this user.']);
    } else {
        echo json_encode(['vehicles' => $vehicles]);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
