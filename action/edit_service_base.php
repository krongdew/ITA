<?php
include 'connect.php'; // เพิ่มไฟล์เชื่อมต่อฐานข้อมูล

// ตรวจสอบการส่งข้อมูลแบบ POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // ดึงข้อมูลจากฟอร์ม
        $serviceID = $_POST['ID'];
        $serviceName = $_POST['service_name'];
        $serviceDetail = $_POST['service_detail'];
        $service_ea = $_POST['service_ea'];
        $serviceAccess = $_POST['service_Access'];
        $serviceStatus = isset($_POST['service_status']) ? 1 : 0; // ตรวจสอบว่า checkbox ถูกติ๊กหรือไม่


        // อัปเดตข้อมูลในตาราง sa_services
        $sqlUpdateService = "UPDATE sa_services SET service_name = :serviceName, service_detail = :serviceDetail, service_Access = :serviceAccess, service_status = :serviceStatus, service_ea = :service_ea WHERE ID = :serviceID";
        $stmtUpdateService = $conn->prepare($sqlUpdateService);
        $stmtUpdateService->bindParam(':serviceID', $serviceID, PDO::PARAM_INT);
        $stmtUpdateService->bindParam(':serviceName', $serviceName, PDO::PARAM_STR);
        $stmtUpdateService->bindParam(':serviceDetail', $serviceDetail, PDO::PARAM_STR);
        $stmtUpdateService->bindParam(':serviceAccess', $serviceAccess, PDO::PARAM_INT);
        $stmtUpdateService->bindParam(':serviceStatus', $serviceStatus, PDO::PARAM_INT);
        $stmtUpdateService->bindParam(':service_ea', $service_ea, PDO::PARAM_STR); // นำเข้า service_ea เพิ่มเข้าไปในคำสั่ง SQL
        $stmtUpdateService->execute();
        


        // ตรวจสอบว่ามีข้อมูลบริการย่อยใหม่ที่เพิ่มเข้ามาหรือไม่
        if (isset($_POST['subservice_name']) && is_array($_POST['subservice_name'])) {
            foreach ($_POST['subservice_name'] as $key => $subserviceName) {
                // ดึงข้อมูลจากฟอร์มสำหรับบริการย่อย
                $subserviceID = $_POST['subservice_ID'][$key]; // ถ้ามี ID แสดงว่าเป็นการแก้ไขข้อมูลเดิม
                $subserviceName = $_POST['subservice_name'][$key];
                $subserviceDetail = $_POST['subservice_detail'][$key];
                $sub_ea = $_POST['sub_ea'][$key];
                $subserviceAccess = $_POST['subservice_Access'][$key];
                $subserviceStatus = $_POST['subservice_status'][$key];

                // ตรวจสอบว่าเป็นการแก้ไขหรือเพิ่มข้อมูลใหม่
                if (!empty($subserviceID)) {
                    // อัปเดตข้อมูลบริการย่อยในตาราง sa_subservices
                    $sqlUpdateSubservice = "UPDATE sa_subservices SET subservice_name = :subserviceName, subservice_detail = :subserviceDetail, sub_ea = :sub_ea, subservice_Access = :subserviceAccess, subservice_status = :subserviceStatus WHERE ID = :subserviceID";
                    $stmtUpdateSubservice = $conn->prepare($sqlUpdateSubservice);
                    $stmtUpdateSubservice->bindParam(':subserviceID', $subserviceID, PDO::PARAM_INT);
                    $stmtUpdateSubservice->bindParam(':subserviceName', $subserviceName, PDO::PARAM_STR);
                    $stmtUpdateSubservice->bindParam(':subserviceDetail', $subserviceDetail, PDO::PARAM_STR);
                    $stmtUpdateSubservice->bindParam(':sub_ea', $sub_ea, PDO::PARAM_STR);
                    $stmtUpdateSubservice->bindParam(':subserviceAccess', $subserviceAccess, PDO::PARAM_INT);
                    $stmtUpdateSubservice->bindParam(':subserviceStatus', $subserviceStatus, PDO::PARAM_INT);
                    $stmtUpdateSubservice->execute();
                } else {
                    // เพิ่มข้อมูลบริการย่อยใหม่ลงในตาราง sa_subservices
                    $sqlInsertSubservice = "INSERT INTO sa_subservices (service_id, subservice_name, subservice_detail, sub_ea, subservice_Access, subservice_status) VALUES (:serviceID, :subserviceName, :subserviceDetail,:sub_ea, :subserviceAccess, :subserviceStatus)";
                    $stmtInsertSubservice = $conn->prepare($sqlInsertSubservice);
                    $stmtInsertSubservice->bindParam(':serviceID', $serviceID, PDO::PARAM_INT);
                    $stmtInsertSubservice->bindParam(':subserviceName', $subserviceName, PDO::PARAM_STR);
                    $stmtInsertSubservice->bindParam(':subserviceDetail', $subserviceDetail, PDO::PARAM_STR);
                    $stmtInsertSubservice->bindParam(':sub_ea', $sub_ea, PDO::PARAM_STR);
                    $stmtInsertSubservice->bindParam(':subserviceAccess', $subserviceAccess, PDO::PARAM_INT);
                    $stmtInsertSubservice->bindParam(':subserviceStatus', $subserviceStatus, PDO::PARAM_INT);
                    $stmtInsertSubservice->execute();
                }
            }
        }

        // ส่งกลับไปยังหน้าแก้ไขบริการหลักหลังจากบันทึกข้อมูลเรียบร้อย
        // header("Location: ../pages/edit_service.php?ID=" . $serviceID);
        // ทำการ redirect ไปที่หน้า pages/edit_user.php?ID=$ID
        echo "<script>alert('อัพเดทข้อมูลสำเร็จ')</script>";
        echo '<script>window.location.href = "../pages/services.php";</script>';
        exit();
    } catch (PDOException $e) {
        // echo "Connection failed: " . $e->getMessage();
    }
} else {
    // ถ้าไม่ได้ส่งข้อมูลแบบ POST จะ redirect กลับไปหน้าแรกหรือหน้าอื่น ๆ ตามที่คุณต้องการ
    echo "<script>alert('Invalid request!')</script>";
    echo '<script>window.location.href = "../pages/services.php";</script>';
    exit();
}
