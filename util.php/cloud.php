<?php

function sendVehicleData(
    $vin,
    $engine_power,
    $engine_coolant_temp,
    $engine_load,
    $engine_rpm,
    $air_intake_temp,
    $speed,
    $short_term_fuel_trim_bank_1,
    $throttle_pos,
    $timing_advance
) {
    // URL of the deployed cloud function
    $url = "https://us-central1-tidal-discovery-455813-e2.cloudfunctions.net/process_vehicle_data";

    // Prepare input data
    $input_data = [
        "data" => [
            ["VIN", $vin], //vin
            ["ENGINE_POWER", $engine_power], //ECU voltage * Absolute Engine Load
            ["ENGINE_COOLANT_TEMP", $engine_coolant_temp], //Coolant Temperature
            ["ENGINE_LOAD", $engine_load], // Calculated Load Value
            ["ENGINE_RPM", $engine_rpm], //Engine RPM
            ["AIR_INTAKE_TEMP", $air_intake_temp], //Intake Air Temperature
            ["SPEED", $speed], //Vehicle Speed
            ["SHORT TERM FUEL TRIM BANK 1", $short_term_fuel_trim_bank_1], //Short Term Fuel Trim (Bank 1)
            ["THROTTLE_POS", $throttle_pos], //Absolute Throttle Position
            ["TIMING_ADVANCE", $timing_advance] //Timing Advance (Cyl. #1)
        ]
    ];

    // Initialize cURL session
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input_data));

    // Execute cURL request and get the response
    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Close cURL session
    curl_close($ch);

    // Handle the response
    if ($http_status === 200) {
        return json_encode(json_decode($response, true), JSON_PRETTY_PRINT);
    } else {
        return json_encode([
            'error' => true,
            'http_status' => $http_status,
            'response' => $response
        ]);
    }
}