<?php
include_once 'Database.php';
session_start();
header('Content-Type: application/json');

$data = $_POST;

if (!$count = $data['count']) {
    $count = 1;
}

if (!$_SESSION['name']) {
    echo json_encode([
        'success' => false,
        'message' => 'Для покупки билетов необходимо авторизоваться',
    ]);
    return;
}

if (!$id = $data['id']) {
    echo json_encode([
        'success' => false,
        'message' => 'Отсутствует идентификатор билета'
    ]);
    return;
}

$db = new Database();
if (!$db->bookTickets($id, $count)) {
    echo json_encode([
        'success' => false,
        'message' => 'Не удалось купить'
    ]);
    return;
}

echo json_encode([
    'success' => false,
    'message' => 'Покупка успешна'
]);
return;
