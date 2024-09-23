<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่า id, oldPassword, newPassword, ConfirmPassword จาก Ajax
    $id = $_POST['id'];
    $adminPassword = $_POST['adminPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // ตรวจสอบว่ารหัสผ่านใหม่ตรงกับรหัสผ่านยืนยันหรือไม่
    if ($newPassword !== $confirmPassword) {
        echo "error_confirm";
        exit();
    }
    

    // ตรวจสอบว่า adminpassword ถูกต้องหรือไม่
    $sql_admin = "SELECT Password, UserType FROM sa_users WHERE UserType = 'admin'";
    $stmt_admin = $conn->prepare($sql_admin);
    $stmt_admin->execute();
    $adminRow = $stmt_admin->fetch(PDO::FETCH_ASSOC);

    if (!$adminRow || !password_verify($adminPassword, $adminRow['Password'])) {
        echo "error_admin_password";
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
