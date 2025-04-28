<?php

require_once 'util.php/cloud.php';
// upload.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Max-Age: 86400'); // 24 hours

require_once 'settings/config.php';

// Helper function to get CSV row by description
function getRowByDescription($rows, $desc)
{
    foreach ($rows as $row) {
        if (isset($row[1]) && trim($row[1]) === $desc) {
            return $row;
        }
    }
    return null;
}

// Define allowed request method and file
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['csv_file']['tmp_name'];
        $fileName = basename($_FILES['csv_file']['name']);
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        if (strtolower($fileExtension) !== 'csv') {
            http_response_code(400);
            echo "Only CSV files are allowed.";
            exit;
        }

        // Read CSV into array
        $rows = [];
        if (($handle = fopen($fileTmpPath, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                $rows[] = $data;
            }
            fclose($handle);
        } else {
            http_response_code(500);
            echo "Failed to read uploaded file.";
            exit;
        }

        // Find VIN and USER_ID
        $vinRow = getRowByDescription($rows, 'Vehicle identification number');
        $userIdRow = getRowByDescription($rows, 'Logged in user ID');
        $vin = isset($vinRow[2]) ? preg_replace('/[^A-Za-z0-9]/', '', $vinRow[2]) : null;
        $user_id = $userIdRow[2] ?? null;

        // Logging
        $logFile = 'uploads/upload.log';
        $logMsg = sprintf(
            "[%s] File received: %s, Size: %d bytes, VIN: %s, USER_ID: %s\n",
            date('Y-m-d H:i:s'),
            $fileName,
            filesize($fileTmpPath),
            $vin ?: 'MISSING',
            $user_id ?: 'MISSING'
        );
        file_put_contents($logFile, $logMsg, FILE_APPEND);


        if (!$vin || !$user_id) {
            http_response_code(401);
            echo "Unauthorized access: VIN or USER_ID missing.";
            exit;
        }

        // Respond quickly to user
        echo json_encode("File received successfully. Processing in background.");

        // Process in background (fire-and-forget)
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
        ignore_user_abort(true);
        set_time_limit(0);

        // Remove header row
        $header = array_shift($rows);

        // Prepare statements
        $pidStmt = $conn->prepare("SELECT pid FROM pids WHERE field_name = ?");
        $insertPidStmt = $conn->prepare("INSERT INTO pids (field_name, units) VALUES (?, ?)");
        $vehicleStmt = $conn->prepare("SELECT vehicle_id FROM vehicles WHERE vin = ?");
        $insertVehicleStmt = $conn->prepare("INSERT INTO vehicles (user_id, vin) VALUES (?, ?)");
        $insertBatchStmt = $conn->prepare("INSERT INTO reading_batches (user_id, vehicle_id) VALUES (?, ?)");
        $insertValueStmt = $conn->prepare("INSERT INTO reading_values (batch_id, pid, value) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE value=VALUES(value)");

        // Get or insert vehicle
        $vehicle_id = null;
        $vehicleStmt->bind_param('s', $vin);
        $vehicleStmt->execute();
        $vehicleStmt->bind_result($vehicle_id);
        if (!$vehicleStmt->fetch()) {
            // $vehicleStmt->close();
            $insertVehicleStmt->bind_param('is', $user_id, $vin);
            $insertVehicleStmt->execute();
            $vehicle_id = $insertVehicleStmt->insert_id;
        }
        $vehicleStmt->close();

        // Insert batch
        $insertBatchStmt->bind_param('ii', $user_id, $vehicle_id);
        $insertBatchStmt->execute();
        $batch_id = $insertBatchStmt->insert_id;

        // Process each row except VIN and USER_ID
        foreach ($rows as $row) {
            if (count($row) < 4) continue;
            $desc = trim($row[1]);
            if ($desc === 'Vehicle identification number' || $desc === 'Logged in user ID') continue;

            // Get or insert PID
            $pid = null;
            $pidStmt->bind_param('s', $desc);
            $pidStmt->execute();
            $pidStmt->bind_result($pid);
            if (!$pidStmt->fetch()) {
                $pidStmt->free_result();
                $units = !empty($row[3]) ? $row[3] : null;
                $insertPidStmt->bind_param('ss', $desc, $units);
                $insertPidStmt->execute();
                $pid = $insertPidStmt->insert_id;
            }
            $pidStmt->free_result(); // Reset for next iteration

            // Insert value
            $value = $row[2] !== '' ? $row[2] : null;
            if ($value === null) {
                $insertValueStmt->bind_param('iis', $batch_id, $pid, $value);
            } else {
                $insertValueStmt->bind_param('iid', $batch_id, $pid, $value);
            }
            $insertValueStmt->execute();
        }

        // Clean up
        @unlink($fileTmpPath);

        $desired_pids = ["ECU voltage", "Absolute Engine Load", "Coolant Temperature", "Calculated Load Value", "Engine RPM", "Intake Air Temperature", "Vehicle Speed", "Short Term Fuel Trim (Bank 1)", "Absolute Throttle Position", "Timing Advance (Cyl. #1)"];

        $getPidStmt = $conn->prepare("SELECT pid FROM pids WHERE field_name IN (" . implode(',', array_fill(0, count($desired_pids), '?')) . ")");
        $getPidStmt->bind_param(str_repeat('s', count($desired_pids)), ...$desired_pids);
        $getPidStmt->execute();
        $getPidStmt->bind_result($pid);
        $pids = [];
        while ($getPidStmt->fetch()) {
            $pids[] = $pid;
        }
        $getPidStmt->close();

        $getSpecificValuesStmt = $conn->prepare("SELECT value FROM reading_values WHERE batch_id = ? AND pid IN (" . implode(',', array_fill(0, count($pids), '?')) . ")");
        $getSpecificValuesStmt->bind_param('i' . str_repeat('i', count($pids)), $batch_id, ...$pids);
        $getSpecificValuesStmt->execute();
        $getSpecificValuesStmt->bind_result($value);
        $values = [];
        while ($getSpecificValuesStmt->fetch()) {
            $values[] = $value;
        }
        $getSpecificValuesStmt->close();

        $cloud_output = sendVehicleData(
            $vin,
            $values[0], // ECU voltage
            $values[1], // Absolute Engine Load
            $values[2], // Coolant Temperature
            $values[3], // Calculated Load Value
            $values[4], // Engine RPM
            $values[5], // Intake Air Temperature
            $values[6], // Vehicle Speed
            $values[7], // Short Term Fuel Trim (Bank 1)
            $values[8], // Absolute Throttle Position
            $values[9]  // Timing Advance (Cyl. #1)
        );
        $cloud_output = json_decode($cloud_output, true);
        if (isset($cloud_output['error'])) {
            $logMsg = sprintf(
                "[%s] Cloud function error: %s\n",
                date('Y-m-d H:i:s'),
                $cloud_output['error']
            );
            file_put_contents($logFile, $logMsg, FILE_APPEND);
        } else {
            $logMsg = sprintf(
                "[%s] Cloud function response: %s\n",
                date('Y-m-d H:i:s'),
                json_encode($cloud_output, JSON_PRETTY_PRINT)
            );
            file_put_contents($logFile, $logMsg, FILE_APPEND);

            $predictionInsertStmt = $conn->prepare("INSERT INTO predictions (batch_id, binary_classification, trouble_code_category, vehicle_hours, remaining_lifetime_hours) VALUES (?, ?, ?, ?, ?)");
            $predictionInsertStmt->bind_param(
                'isidd',
                $batch_id,                                 // i: integer
                $cloud_output['BinaryClassification'],     // s: string
                $cloud_output['TroubleCodeCategory'],      // i: integer
                $cloud_output['PredictedHours'],           // d: double (float)
                $cloud_output['RemainingLifetimeHours']    // d: double (float)
            );
            $predictionInsertStmt->execute();
            $prediction_id = $predictionInsertStmt->insert_id;
            $predictionInsertStmt->close();
            $logMsg = sprintf(
                "[%s] Prediction ID: %d\n",
                date('Y-m-d H:i:s'),
                $prediction_id
            );
            file_put_contents($logFile, $logMsg, FILE_APPEND);
        }


        // Close statements
        $pidStmt->close();
        $insertPidStmt->close();
        $insertVehicleStmt->close();
        $insertBatchStmt->close();
        $insertValueStmt->close();
        $conn->close();

        exit;
    } else {
        http_response_code(400);
        echo "No file uploaded or there was an upload error.";
    }
} else {
    http_response_code(405);
    echo "Invalid request method.";
}
