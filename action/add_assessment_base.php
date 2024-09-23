<?php
session_start();
include 'connect.php';

// ตรวจสอบ CSRF Token
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // รับข้อมูลจากฟอร์ม
    $AssessmentName = $_POST['AssessmentName'];
    $service_id = $_POST['service_id'];
    $CreatorUserID = $_POST['CreatorUserID'];
    $ApprovalStatus = "ยังไม่อนุมัติ";
    $AssessmentStatus = "รอสร้างข้อคำถาม";

    // ตรวจสอบว่ามีการเลือกบริการย่อยหรือไม่
    if (!empty($_POST['selected_subservice'])) {
        $subservice_id = $_POST['selected_subservice'];
    } else {
        $subservice_id = NULL; // ใช้ NULL แทนค่าที่ไม่ถูกต้อง
    }

    // เตรียมคำสั่ง SQL ด้วย prepared statement
    $sql = "INSERT INTO sa_assessment (AssessmentName, CreatorUserID, ApprovalStatus, service_id, subservice_id, AssessmentStatus) 
            VALUES (?, ?, ?, ?, ?, ?)";

    try {
        // สร้าง prepared statement
        $stmt = $conn->prepare($sql);

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(1, $AssessmentName);
        $stmt->bindParam(2, $CreatorUserID);
        $stmt->bindParam(3, $ApprovalStatus);
        $stmt->bindParam(4, $service_id);
        $stmt->bindParam(5, $subservice_id, PDO::PARAM_INT); // กำหนดเป็น INT
        $stmt->bindParam(6, $AssessmentStatus);

        // ทำการเพิ่มข้อมูล
        $stmt->execute();

        echo "<script>alert('สร้างแบบประเมินสำเร็จ')</script>";
        echo '<script>window.location.href = "../pages/assessment.php";</script>';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// ปิดการเชื่อมต่อ
$conn = null;
?>
