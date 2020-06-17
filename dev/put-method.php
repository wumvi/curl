<?php
$putData = fopen("php://input", "r");
$data = fgets($putData);
echo 'r=', $_SERVER['REQUEST_METHOD'], ' ', $data;
