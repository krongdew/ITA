
<?php
include 'connect.php'; // เรียกใช้ไฟล์เชื่อมต่อกับฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบว่ามีการส่งข้อมูลมาจากฟอร์มหรือไม่
    if (isset($_POST['ID'])) {
        // ดึงข้อมูลจากฟอร์ม
        $ID = $_POST['ID'];
        $department_id = $_POST['department_id'];
        $position = $_POST['position'];
        $unit = $_POST['unit_id'];
        $unit_old_id = $_POST['unit_old_id'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $name_surname = $_POST['name_surname'];
        $position_c = $_POST['position_c'];
        $email_other = $_POST['email_other'];
        $tell = $_POST['tell'];

        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
        try {
            // เตรียมคำสั่ง SQL
            $stmt = $conn->prepare("SELECT * FROM sa_users WHERE ID = :userID");
            $stmt->bindParam(':userID', $ID);
            $stmt->execute();

            // ดึงข้อมูลผู้ใช้
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        if (!$user) {
            // ไม่พบข้อมูลผู้ใช้
            echo "User not found!";
            exit;
        } else {
            // ตรวจสอบการอัปโหลดไฟล์รูปภาพ
            if ($_FILES['image']['error'] == 0) {
                $image = '../upload/' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], $image);
            } else {
                // ใช้รูปภาพเดิมถ้าไม่ได้อัปโหลดใหม่
                $image = $user['image'];
            }
            if($unit == '') {
                $units = $unit_old_id;
            }else{
                $units = $unit;
            }
            
            

            // เตรียมคำสั่ง SQL สำหรับการอัปเดตข้อมูล
            $sql = "UPDATE sa_users SET
                department = :department_id,
                position = :position,
                unit = :units,
                email = :email,
                phone = :phone,
                image = :image,
                name_surname = :name_surname,
                position_c = :position_c,
                email_other = :email_other,
                tell = :tell
                WHERE ID = :ID";

            // ใช้ Prepared Statement
            $stmt = $conn->prepare($sql);

            // กำหนดค่าพารามิเตอร์
            $stmt->bindParam(':department_id', $department_id);
            $stmt->bindParam(':position', $position);
            $stmt->bindParam(':units', $units);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':name_surname', $name_surname);
            $stmt->bindParam(':position_c', $position_c);
            $stmt->bindParam(':email_other', $email_other);
            $stmt->bindParam(':tell', $tell);
            $stmt->bindParam(':ID', $ID);

            // ทำการอัปเดตข้อมูล
            if ($stmt->execute()) {
               
                // ทำการ redirect ไปที่หน้า pages/edit_user.php?ID=$ID
                echo "<script>alert('อัพเดทข้อมูลสำเร็จ')</script>";
                echo '<script>window.location.href = "../pages/edit_user.php?ID=' . $ID . '";</script>';
                exit;
            } else {
                // มีปัญหาในการอัปเดตข้อมูล
                
                echo "<script>alert('Error updating user information!')</script>";
                echo '<script>window.location.href = "../pages/edit_user.php?ID=' . $ID . '";</script>';
            }
        }
    } else {
        // ไม่มี ID ที่ส่งมาจากฟอร์ม
       
        echo "<script>alert('Invalid request!')</script>";
        echo '<script>window.location.href = "../pages/user.php";</script>';
    }
} else {
    // ไม่ใช่การส่งข้อมูลแบบ POST
    echo "<script>alert('Invalid request!')</script>";
    echo '<script>window.location.href = "../pages/user.php";</script>';
}
?>
