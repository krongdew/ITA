<?php
include 'connect.php';

try {
    // // สร้างการเชื่อมต่อ PDO
    // $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // // เซ็ตโหมดของ PDO เป็น Exception
    // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // คำสั่ง SQL สำหรับดึงข้อมูล department
    $sql = "SELECT ID, department_name FROM sa_department";
    
    // ใช้ Prepared Statement
    $stmt = $conn->prepare($sql);
    
    // ประมวลผลคำสั่ง SQL
    $stmt->execute();
    
    // ดึงผลลัพธ์
    $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // ตรวจสอบว่ามีข้อมูลหรือไม่
    if (count($departments) > 0) {
        echo '<select name="department_id" class="form-select" required onchange="getUnits(this.value)">';
        foreach ($departments as $department) {
            echo '<option value="' . $department['ID'] . '">' . $department['department_name'] . '</option>';
        }
        echo '</select>';
    } else {
        echo '<p>No departments found</p>';
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn = null;
?>
