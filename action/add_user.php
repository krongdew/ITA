<?php
session_start();
include 'connect.php';

// Key for encryption
// include 'config.php';
// $key = $config['encryption_key'];
$key = getenv('ENCRYPTION_KEY');

// Function to encrypt data
function encryptData($data, $key)
{
    $cipher = "aes-256-cbc";
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $encrypted = openssl_encrypt($data, $cipher, $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

// ตรวจสอบ CSRF Token
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // รับข้อมูลจากฟอร์ม
    $Username = $_POST['Username'];
    $ConfirmPassword = $_POST['ConfirmPassword'];
    $department_id = $_POST['department_id'];
    $position = $_POST['position'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $Password = $_POST['Password'];
    $name_surname = $_POST['name_surname'];
    $unit_id = $_POST['unit_id'];
    $position_c = $_POST['position_c'];
    $email_other = $_POST['email_other'];
    $tell = $_POST['tell'];
    $UserType = $_POST['UserType'];
    $image = $_POST['image'];



    // ตรวจสอบว่า Password และ ConfirmPassword ตรงกันหรือไม่
    if ($Password != $ConfirmPassword) {
        echo "Error: Password and ConfirmPassword do not match";
        exit;
    }


    // เข้ารหัสรหัสผ่านด้วย password_hash
    $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

    // ตรวจสอบว่า Username ไม่ซ้ำกับที่มีอยู่ในฐานข้อมูล
    $checkUsernameSQL = "SELECT COUNT(*) FROM sa_users WHERE Username = ?";
    $checkUsernameStmt = $conn->prepare($checkUsernameSQL);
    $checkUsernameStmt->bindParam(1, $Username);
    $checkUsernameStmt->execute();
    $existingUsernameCount = $checkUsernameStmt->fetchColumn();

    if ($existingUsernameCount > 0) {
        echo "Error: Username is already taken";
        exit;
    }


    // ตรวจสอบรหัสผ่าน
    if (password_verify($ConfirmPassword, $hashedPassword)) {

        
        // Password ถูกต้อง
        // เข้ารหัสข้อมูล
        $hashedNameSurname = encryptData($name_surname, $key);
        $hashedEmail = encryptData($email, $key);
        $hashedEmailOther = encryptData($email_other, $key);
        $hashedTell = encryptData($tell, $key);
        // จะใช้ฟังก์ชัน encryptData ที่ได้แสดงให้เห็นในตัวอย่างก่อนหน้านี้
        // เตรียมคำสั่ง SQL ด้วย prepared statement
        $sql = "INSERT INTO sa_users (Username, Password, name_surname, department, unit, position, position_c, email, email_other, tell, phone, image, UserType) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            // สร้าง prepared statement
            $stmt = $conn->prepare($sql);

            // ผูกค่าพารามิเตอร์
            $stmt->bindParam(1, $Username);
            $stmt->bindParam(2, $hashedPassword);
            $stmt->bindParam(3, $hashedNameSurname);
            $stmt->bindParam(4, $department_id);
            $stmt->bindParam(5, $unit_id);
            $stmt->bindParam(6, $position);
            $stmt->bindParam(7, $position_c);
            $stmt->bindParam(8, $hashedEmail);
            $stmt->bindParam(9, $hashedEmailOther);
            $stmt->bindParam(10, $hashedTell);
            $stmt->bindParam(11, $phone);
            $stmt->bindParam(12, $image);
            $stmt->bindParam(13, $UserType);

            // ทำการเพิ่มข้อมูล
            $stmt->execute();

            // ส่งค่า "success" กลับไปยัง jQuery/Ajax
            echo json_encode(['status' => 'success']);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Error: Password and ConfirmPassword do not match";
        exit;
    }
}
$conn = null;
