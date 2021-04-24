<?php

include_once 'Database.php';
header('Content-Type: application/json');
$data = $_POST;

$db = new Database();
$result = $db->findTickets($data);
echo json_encode($result);

