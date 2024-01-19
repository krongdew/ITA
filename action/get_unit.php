<?php
include 'connect.php';

try {
    // ตรวจสอบว่ามีค่า department_id ที่ถูกส่งมาหรือไม่
   
    if (isset($_GET['department_id'])) {
        $department_id = $_GET['department_id'];

        // คำสั่ง SQL สำหรับดึงข้อมูล unit ที่ตรงกับ department_id
        $sql = "SELECT ID, unit_name FROM sa_unit WHERE department_id = :department_id";

        // ใช้ Prepared Statement
        $stmt = $conn->prepare($sql);

        // Bind parameter
        $stmt->bindParam(':department_id', $department_id, PDO::PARAM_INT);

        // ประมวลผลคำสั่ง SQL
        $stmt->execute();

        // ดึงผลลัพธ์
        $units = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (count($units) > 0) {
            echo '<select name="unit_id" class="form-select" required>';
            foreach ($units as $unit) {
                echo '<option value="' . $unit['ID'] . '">' . $unit['unit_name'] . '</option>';
            }
            echo '</select>';
        } else {
            echo '<p>No Unit found</p>';
        }
    } else {
        echo '<p>Department ID not provided</p>';
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn = null;
?>
