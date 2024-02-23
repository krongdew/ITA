<?php
include 'connect.php';

// Function to decrypt data
$key = getenv('ENCRYPTION_KEY');

function decryptData($data, $key)
{
    $cipher = "aes-256-cbc";
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่า Username และอีเมล์จากหน้า index.php
    $username = $_POST['Username'];
    $email = $_POST['email'];

    // ค้นหาข้อมูลผู้ใช้จากฐานข้อมูล
    $sql = "SELECT * FROM sa_users WHERE Username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // ตรวจสอบว่ามีข้อมูลผู้ใช้หรือไม่
    if ($row) {
        // ถอดรหัส email จากฐานข้อมูล
        $decryptedEmail = decryptData($row['email'], $key);

        // เปรียบเทียบ email ที่ถอดรหัสมากับ email ที่รับมาจาก POST
        if ($email === $decryptedEmail) {
            // สร้าง token สำหรับลิงก์การเปลี่ยนรหัสผ่าน
            $token = bin2hex(random_bytes(32)); // สร้าง token ใหม่

            // เข้ารหัส token
            $hashedToken = password_hash($token, PASSWORD_DEFAULT);

            // บันทึก token ที่เข้ารหัสแล้วลงในฐานข้อมูล
            $sql_token = "INSERT INTO password_reset (Username, Token, ExpiryDate) VALUES (:username, :token, DATE_ADD(NOW(), INTERVAL 1 HOUR))";
            $stmt_token = $conn->prepare($sql_token);
            $stmt_token->bindParam(':username', $username);
            $stmt_token->bindParam(':token', $hashedToken); // บันทึก token ที่เข้ารหัสแล้ว
            $stmt_token->execute();

            // ส่งอีเมล์ไปยังผู้ใช้เพื่อเปลี่ยนรหัสผ่าน
            $to = $email;
            $subject = "Reset Your Password";
            $message = "Please click the following link to reset your password: <a href='http://localhost:8080/reset_password.php?token=$hashedToken'>Reset Password</a>";
            $headers = "From: webmaster@example.com" . "\r\n" .
                "Content-type: text/html; charset=UTF-8" . "\r\n";

            // Send email using SMTP
            $smtp_host = "localhost"; // SMTP Server ของ MailHog
            $smtp_port = 1025; // พอร์ต SMTP ของ MailHog
            
            mail($to, $subject, $message, $headers);

            // ส่งข้อความสำเร็จกลับไปยังหน้า index.php
            echo "success";
        } else {
            // ไม่พบข้อมูลผู้ใช้ ส่งข้อความ error กลับไปยังหน้า index.php
            echo "ไม่พบชื่อผู้ใช้หรืออีเมล์ที่ระบุ";
        }
    }
}
