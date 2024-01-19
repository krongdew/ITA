<?php
include 'connect.php'; // เรียกใช้ไฟล์เชื่อมต่อกับฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบว่ามีการส่งข้อมูลมาจากฟอร์มหรือไม่
   
        // ดึงข้อมูลจากฟอร์ม
        $username = $_POST['username'];
        $department_id = $_POST['department_id'];
        $position = $_POST['position'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $name_surname = $_POST['name_surname'];
        $position_c = $_POST['position_c'];
        $email_other = $_POST['email_other'];
        $tell = $_POST['tell'];

        // ตรวจสอบการอัปโหลดไฟล์รูปภาพ
        if ($_FILES['image']['error'] == 0) {
            $image = '../upload/' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
        } else {
            // ใช้รูปภาพเดิมถ้าไม่ได้อัปโหลดใหม่
            $image = $user['image'];
        }

        // เตรียมคำสั่ง SQL สำหรับการอัปเดตข้อมูล
        $sql = "UPDATE sa_users SET
            department = :department_id,
            position = :position,
            email = :email,
            phone = :phone,
            image = :image,
            name_surname = :name_surname,
            position_c = :position_c,
            email_other = :email_other,
            tell = :tell
            WHERE Username = :username";

        // ใช้ Prepared Statement
        $stmt = $conn->prepare($sql);

        // กำหนดค่าพารามิเตอร์
        $stmt->bindParam(':department_id', $department_id);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':name_surname', $name_surname);
        $stmt->bindParam(':position_c', $position_c);
        $stmt->bindParam(':email_other', $email_other);
        $stmt->bindParam(':tell', $tell);
        $stmt->bindParam(':username', $username);

        // ทำการอัปเดตข้อมูล
        if ($stmt->execute()) {
            // อัปเดตข้อมูลสำเร็จ
            echo "User information updated successfully!";
        } else {
            // มีปัญหาในการอัปเดตข้อมูล
            echo "Error updating user information!";
        }
    
    }else {
    // ไม่ใช่การส่งข้อมูลแบบ POST
    echo "Invalid request!";
}
?>
