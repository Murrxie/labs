<?php

include_once '../Database.php';

session_start();
header('Content-Type: application/json');

$data = $_POST;

$database = new Database();

$response = [
    'success' => true,
    'message' => 'Билет успешно создан',
];

try {
    $database->createTicket($data);
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = 'Не удалось создать билет';
}
echo json_encode($response);
