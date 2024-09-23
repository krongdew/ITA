<?php
include 'connect.php';

$key = getenv('ENCRYPTION_KEY');

// Function to decrypt data
function decryptData($data, $key) {
    $cipher = "aes-256-cbc";
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);
}

// ดึงข้อมูลจากตาราง sa_department
$stmt = $conn->prepare("SELECT ID, name_surname FROM sa_users");
$stmt->execute();
$userData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ถอดรหัสคอลัมน์ name_surname
foreach ($userData as &$user) {
    $user['name_surname'] = decryptData($user['name_surname'], $key);
}

// ส่งออกข้อมูลเป็น JSON
// header('Content-Type: application/json');
echo json_encode($userData);



?>