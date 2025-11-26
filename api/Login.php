<?php
session_start();
require_once __DIR__ . '/../src/login.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['email']) || !isset($input['password'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email/password tidak diberikan']);
    exit;
}

$login = new Login();
$result = $login->authenticate($input['email'], $input['password']);

if ($result === "Login berhasil") {
    echo json_encode([
        'success' => true,
        'message' => $result,
        'redirect_to' => '/dashboard.php'
    ]);
} else {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => $result]);
}
?>