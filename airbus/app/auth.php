<?php
session_start();

include_once 'Database.php';

$data = $_POST;

$email = $data['email'];
$password = $data['password'];
$result = [];
header('Content-Type: application/json');

if (!$email || !$password) {
    $result['success'] = false;
    echo json_encode([
        'success' => false,
        'message' => 'Заполнены не все обязательные поля',
    ]);
    return;
}

$database = new Database();
if (!$userData = $database->findForAuth($email, md5($password))) {
    echo json_encode([
        'success' => false,
        'message' => 'Указаны неверные данные',
    ]);
    return;
}
list($_SESSION['id'], $_SESSION['name']) = $userData;
echo json_encode([
    'success' => true,
    'message' => 'Авторизация успешна',
]);
return;
