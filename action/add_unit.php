<?php
session_start();
include 'connect.php';
    
// ตรวจสอบ CSRF Token
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // รับข้อมูลจากฟอร์ม
    $unitName = $_POST['unit_name'];
    $department_id = $_POST['department_id'];
    $unit_memo = $_POST['unit_memo'];

    // เตรียมคำสั่ง SQL ด้วย prepared statement
    $sql = "INSERT INTO sa_unit (unit_name, department_id, memo) 
            VALUES (?, ?, ?)";

    try {
        // สร้าง prepared statement
        $stmt = $conn->prepare($sql);

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(1, $unitName);
        $stmt->bindParam(2, $department_id);
        $stmt->bindParam(3, $unit_memo);

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
