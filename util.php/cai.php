<?php
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

require_once '../settings/config.php';

function call_nlp_cloud_function($phase, $question, $query_results = null)
{
    $url = "https://us-central1-tidal-discovery-455813-e2.cloudfunctions.net/process_nlp_query";

    $payload = [
        "phase" => $phase,
        "question" => $question
    ];
    if ($phase == 2 && $query_results !== null) {
        $payload["query_results"] = $query_results;
    }

    $json_payload = json_encode($payload);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json_payload)
    ]);

    $result = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $decoded = json_decode($result, true);

    return [
        "status_code" => $httpcode,
        "response" => $decoded
    ];
}

header('Content-Type: application/json');

// Only require the question from POST
if (!isset($_POST['question'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing question']);
    exit;
}

$question = $_POST['question'];

// Phase 1: Get SQL from cloud function
$cloudResult1 = call_nlp_cloud_function(1, $question);

if (
    isset($cloudResult1['response']['sql_query']) &&
    !empty($cloudResult1['response']['sql_query'])
) {
    $sql = $cloudResult1['response']['sql_query'];

    // Run the SQL query
    $result = $conn->query($sql);
    if ($result === false) {
        echo json_encode([
            'error' => 'SQL Error',
            'sql' => $sql,
            'details' => $conn->error
        ]);
        exit;
    }

    // Fetch all results as associative arrays
    $queryResults = [];
    while ($row = $result->fetch_assoc()) {
        $queryResults[] = $row;
    }

    // Phase 2: Get analysis from cloud function
    $cloudResult2 = call_nlp_cloud_function(2, $question, $queryResults);

    if (isset($cloudResult2['response']['analysis'])) {
        echo json_encode([
            'analysis' => $cloudResult2['response']['analysis']
        ]);
        exit;
    } else {
        echo json_encode($cloudResult2['response']);
        exit;
    }
} else {
    // No SQL returned
    echo json_encode($cloudResult1);
    exit;
}