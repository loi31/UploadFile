<?php
error_reporting(0);

$array = [
    "success" => "true",
    "message" => "Dosyaları görebiliceğinimi zannettin güzel kardeşim 😉"
];

header('Content-Type: application/json');
echo json_encode($array);
?>