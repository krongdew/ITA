<?php
session_start();
include 'connect.php';
    
// ตรวจสอบ CSRF Token
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // รับข้อมูลจากฟอร์ม
    $departmentName = $_POST['department_name'];
    $ownerName = $_POST['owner_name'];
    $departmentMemo = $_POST['department_memo'];

    // เตรียมคำสั่ง SQL ด้วย prepared statement
    $sql = "INSERT INTO sa_department (department_name, owner_name, department_memo) 
            VALUES (?, ?, ?)";

    try {
        // สร้าง prepared statement
        $stmt = $conn->prepare($sql);

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(1, $departmentName);
        $stmt->bindParam(2, $ownerName);
        $stmt->bindParam(3, $departmentMemo);

        // ทำการเพิ่มข้อมูล
        $stmt->execute();

        echo "Record added successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// ปิดการเชื่อมต่อ
$conn = null;
?>
