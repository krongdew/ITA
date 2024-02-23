<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่า id, oldPassword, newPassword, ConfirmPassword จาก Ajax
    $id = $_POST['id'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // ตรวจสอบว่ารหัสผ่านใหม่ตรงกับรหัสผ่านเก่าหรือไม่
    if ($oldPassword === $newPassword) {
        echo "error_same_password";
        exit();
    }

    // ตรวจสอบว่ารหัสผ่านใหม่ตรงกับรหัสผ่านยืนยันหรือไม่
    if ($newPassword !== $confirmPassword) {
        echo "error_confirm";
        exit();
    }

    // ตรวจสอบว่ารหัสผ่านเก่าถูกต้องหรือไม่
    $sql = "SELECT Password FROM sa_users WHERE ID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row || !password_verify($oldPassword, $row['Password'])) {
        echo "error_old_password";
        exit();
    }
       
    // เข้ารหัสรหัสผ่านใหม่
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // อัพเดทรหัสผ่านใหม่ในฐานข้อมูล
    $sql_update = "UPDATE sa_users SET Password = :newPassword WHERE ID = :id";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bindParam(':newPassword', $hashedPassword);
    $stmt_update->bindParam(':id', $id);

    if ($stmt_update->execute()) {
        echo "success";
    } else {
        echo "error_update";
    }
}

?>
