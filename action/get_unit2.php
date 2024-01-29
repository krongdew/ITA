<?php
// Include your database connection or configuration file here
// For example, include 'db_connection.php';

include 'connect.php';

// ตรวจสอบว่ามีการส่งค่า department_id มาหรือไม่
if (isset($_POST['department_id'])) {
    $departmentId = $_POST['department_id'];

    // Include your database connection or configuration file here
    // For example, include 'db_connection.php';
    try {
      

        // คำสั่ง SQL สำหรับดึงข้อมูล unit ตาม department_id
        $sql = "SELECT ID, unit_name FROM sa_unit WHERE department_id = :departmentId";

        // ใช้ Prepared Statement
        $stmt = $conn->prepare($sql);

        // Bind parameter
        $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);

        // ประมวลผลคำสั่ง SQL
        $stmt->execute();

        // ดึงผลลัพธ์
        $units = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (count($units) > 0) {
            // สร้างตัวเลือกของ unit
            // $options = '<option value="">ชื่อหน่วย</option>';
            foreach ($units as $unit) {
                $options .= '<option value="' . $unit['ID'] . '">' . $unit['unit_name'] . '</option>';
            }

            // ส่งผลลัพธ์กลับไปให้ JavaScript
            echo $options;
        } else {
            echo '<option value="">ไม่พบหน่วย</option>';
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} else {
    echo '<option value="">ไม่พบข้อมูล</option>';
}
?>
