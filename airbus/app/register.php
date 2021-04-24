<?php

include_once 'Database.php';
header('Content-Type: application/json');

$data = $_POST;

$email = $data['email'];
$password = $data['password'];

$result = [
    'success' => true,
    'message' => 'Вы успешно зарегистрированы'
];

if (!$email || !$password) {
    $result['success'] = false;
    $result['message'] = 'Заполнены не все обязательные поля';
    echo json_encode($result);
    return;
}

$database = new Database();
try {
    $database->register($email, $password);
} catch (Exception $e) {
    $result['success'] = false;
    $result['message'] = $e->getMessage();
}
echo json_encode($result);
