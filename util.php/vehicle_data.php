<?php
header('Content-Type: application/json');

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

if (!isset($_REQUEST['vin'])) {
    echo json_encode(['error' => 'VIN not provided']);
    exit;
}

$vin = $_REQUEST['vin'];
$vin = preg_replace('/[^A-Za-z0-9]/', '', $vin);

$stmt = $conn->prepare("SELECT 
    JSON_OBJECT(
        'batch_id', rb.batch_id,
        'recorded_at', rb.recorded_at,
        'user_name', u.name,
        'number_of_pids', COUNT(DISTINCT rv.pid),
        'predictions', JSON_OBJECT(
            'binary_classification', pr.binary_classification,
            'trouble_code_category', pr.trouble_code_category,
            'vehicle_hours', pr.vehicle_hours,
            'remaining_lifetime_hours', pr.remaining_lifetime_hours
        ),
        'readings', JSON_ARRAYAGG(
            JSON_OBJECT(
                'pid', rv.pid,
                'field_name', p.field_name,
                'value', rv.value,
                'units', p.units
            )
        )
    ) AS batch_data
FROM 
    vehicles v
JOIN 
    reading_batches rb ON v.vehicle_id = rb.vehicle_id
JOIN 
    users u ON rb.user_id = u.user_id
JOIN 
    reading_values rv ON rb.batch_id = rv.batch_id
JOIN 
    pids p ON rv.pid = p.pid
JOIN 
    predictions pr ON rb.batch_id = pr.batch_id
WHERE 
    v.vin = ?
GROUP BY 
    rb.batch_id, rb.recorded_at, u.name, pr.binary_classification, pr.trouble_code_category, pr.vehicle_hours, pr.remaining_lifetime_hours
ORDER BY 
    rb.recorded_at DESC;
");

$stmt->bind_param("s", $vin); // Safely bind the VIN parameter
$stmt->execute();
$stmt->bind_result($batch_data);

$results = [];
while ($stmt->fetch()) {
    $results[] = json_decode($batch_data, true); // Decode JSON to convert to an array
}

$stmt->close();

if ($results) {
    echo json_encode($results); // Return multiple batches as a JSON array
} else {
    echo json_encode(['error' => 'No data found for the provided VIN']);
}
