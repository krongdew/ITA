<?php
// เชื่อมต่อกับฐานข้อมูล
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่า servicesID ที่ต้องการลบ
    $servicesID = $_POST['servicesID'];

    // ตรวจสอบว่า servicesID ถูกส่งมาหรือไม่
    if (isset($servicesID)) {
        // ลบ record ในตาราง sa_subservices ที่มี service_id ตรงกับ servicesID
        $deleteSubservicesSql = "DELETE FROM sa_subservices WHERE service_id = :servicesID";
        $deleteSubservicesStmt = $conn->prepare($deleteSubservicesSql);
        $deleteSubservicesStmt->bindParam(':servicesID', $servicesID, PDO::PARAM_INT);
        $deleteSubservicesStmt->execute();

        // ลบ record ในตาราง sa_services ที่มี ID ตรงกับ servicesID
        $deleteServicesSql = "DELETE FROM sa_services WHERE ID = :servicesID";
        $deleteServicesStmt = $conn->prepare($deleteServicesSql);
        $deleteServicesStmt->bindParam(':servicesID', $servicesID, PDO::PARAM_INT);
        $deleteServicesStmt->execute();

        // ส่ง JSON response กลับไป
        echo json_encode(['status' => 'success']);
    } else {
        // ถ้าไม่มี servicesID ถูกส่งมา
        echo json_encode(['status' => 'error', 'message' => 'Missing servicesID']);
    }
}
?>
