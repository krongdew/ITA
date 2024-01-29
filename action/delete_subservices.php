<?php
include 'connect.php'; // เพิ่มไฟล์เชื่อมต่อฐานข้อมูล

// ตรวจสอบการส่งข้อมูลแบบ POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // รับค่า ID ที่ต้องการลบ
        $subservicesID = $_POST['subservicesID'];

        // ทำการลบข้อมูลในตาราง sa_subservices
        $sqlDeleteSubservices = "DELETE FROM sa_subservices WHERE ID = :subservicesID";
        $stmtDeleteSubservices = $conn->prepare($sqlDeleteSubservices);
        $stmtDeleteSubservices->bindParam(':subservicesID', $subservicesID, PDO::PARAM_INT);
        $stmtDeleteSubservices->execute();

        // ส่งคำตอบกลับในรูปแบบ JSON สำหรับการจัดการกับ Swal.fire ใน JavaScript
        $response = ['status' => 'success'];
        echo json_encode($response);
    } catch (PDOException $e) {
        // กรณีเกิดข้อผิดพลาดในการลบ
        $response = ['status' => 'error'];
        echo json_encode($response);
    }
} else {
    // กรณีไม่ได้ส่งข้อมูลแบบ POST
    $response = ['status' => 'error'];
    echo json_encode($response);
}
?>
