<?php

require_once 'Database.php';

$db = new Database();
return $db->getCities();
