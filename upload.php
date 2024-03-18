<?php

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$base_dir = "dosyalar/";
$unique_dir = generateRandomString();
$target_dir = $base_dir . $unique_dir . "/";
$filename = basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . $filename;

$response = array();

if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true); // Dizin yoksa oluştur
}

// Yüklenen dosyayı taşı
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    // /dosyalar/ içindeki index.php'yi yeni dizine kopyala
    copy('dosyalar/index.php', $target_dir . 'index.php');

    // Sadece belirli dosyanın indirilmesini zorla
    $htaccessContent = "<Files \"" . $filename . "\">
    ForceType application/octet-stream
    Header set Content-Disposition attachment
</Files>";

    file_put_contents($target_dir . '.htaccess', $htaccessContent);

    $response["success"] = "true";
    $response["file_link"] = "localhost/dosyalar/" . $unique_dir . "/" . $filename;
} else {
    $response["success"] = "false";
    $response["error_msg"] = "Sorry, there was an error uploading your file.";
}

header('Content-Type: application/json');
echo json_encode($response);
?>