<?php

include_once '../Database.php';

session_start();
header('Content-Type: application/json');

if (!$id = $_POST['id']) {
    echo json_encode([]);
    return;
}
$database = new Database();
echo json_encode($database->findAirports($id));
