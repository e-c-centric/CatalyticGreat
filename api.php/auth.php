<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=UTF-8');

require_once '../settings/config.php';

session_start(); // Start the session

// Allowed roles
$allowed_roles = ['driver', 'mechanic', 'dvla', 'epa'];

$action = $_REQUEST['action'] ?? null;

if ($action == 'register') {
    $name = trim($_POST['name'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $phone_number = trim($_POST['phone_number'] ?? '');
    $role = trim($_POST['role'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validate inputs
    if (empty($name) || empty($email) || empty($phone_number) || empty($role) || empty($password)) {
        echo json_encode(array("status" => "error", "message" => "All fields are required."));
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(array("status" => "error", "message" => "Invalid email format."));
        exit;
    }

    if (!in_array($role, $allowed_roles)) {
        echo json_encode(array("status" => "error", "message" => "Invalid role."));
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, phone_number, role, password) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sssss", $name, $email, $phone_number, $role, $hashed_password);

        if ($stmt->execute()) {
            echo json_encode(array("status" => "success", "message" => "User registered successfully."));
        } else {
            echo json_encode(array("status" => "error", "message" => "Error: " . $stmt->error));
        }

        $stmt->close();
    } else {
        echo json_encode(array("status" => "error", "message" => "Error preparing statement: " . $conn->error));
    }
} elseif ($action == 'login') {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    // Validate inputs
    if (empty($email) || empty($password)) {
        echo json_encode(array("status" => "error", "message" => "Email and password are required."));
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(array("status" => "error", "message" => "Invalid email format."));
        exit;
    }

    $stmt = $conn->prepare("SELECT user_id, role, password FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $role, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                // Set session variables
                $_SESSION['user_id'] = $user_id;
                $_SESSION['role'] = $role;

                echo json_encode(array(
                    "status" => "success",
                    "message" => "Login successful.",
                    "user_id" => $user_id,
                    "role" => $role
                ));
            } else {
                echo json_encode(array("status" => "error", "message" => "Invalid password."));
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "User not found."));
        }

        $stmt->close();
    } else {
        echo json_encode(array("status" => "error", "message" => "Error preparing statement: " . $conn->error));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid action."));
}
