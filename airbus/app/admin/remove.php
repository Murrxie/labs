<?php
include_once '../Database.php';

session_start();
header('Content-Type: application/json');

$result = [
    'success' => true,
    'message' => 'Билет успешно удален',
];

if ($_SESSION['name'] !== 'admin@mail.ru') {
    echo json_encode([
        'success' => false,
        'message' => 'Удаление доступно только администратору',
    ]);
    return;
}

if (!$id = $_POST['id']) {
    echo json_encode([
        'success' => false,
        'message' => 'Укажите ID билета'
    ]);
    return;
}

$database = new Database();
try {
    $database->removeTicket($id);
} catch (Exception $e) {
    $result['success'] = false;
    $result['message'] = $e->getMessage();
}
echo json_encode($result);
