<?php
session_start();
require_once __DIR__ . '/../src/IntegrationRegisLogin.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['name']) || !isset($input['email']) || !isset($input['password'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit;
}

$result = registerAndLogin($input['name'], $input['email'], $input['password']);

if ($result['success']) {
    echo json_encode([
        'success' => true,
        'message' => $result['message'],
        'redirect_to' => '/dashboard.php'
    ]);
} else {
    http_response_code(400);
    echo json_encode($result);
}
?>