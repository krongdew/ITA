<?php
// เชื่อมต่อกับฐานข้อมูล
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่า servicesID ที่ต้องการลบ
    $servicesID = $_POST['servicesID'];

    // ตรวจสอบว่า servicesID ถูกส่งมาหรือไม่
    if (isset($servicesID)) {
        error_log("Received servicesID: " . $servicesID); // แสดงผลค่า servicesID ใน log file

        try {
            // เริ่มการ transaction
            $conn->beginTransaction();

            // ตรวจสอบว่ามี service นี้ใน sa_services หรือไม่
            $checkServiceSql = "SELECT COUNT(*) FROM sa_services WHERE ID = :servicesID";
            $checkServiceStmt = $conn->prepare($checkServiceSql);
            $checkServiceStmt->bindParam(':servicesID', $servicesID, PDO::PARAM_INT);
            $checkServiceStmt->execute();
            $serviceExists = $checkServiceStmt->fetchColumn();

            if ($serviceExists > 0) {
                // ตรวจสอบว่ามีข้อมูลใน sa_respondent โดยใช้ servicesID ที่ column service_id หรือไม่
                $checkRespondentSql = "SELECT RespondentID FROM sa_respondent WHERE service_id = :servicesID";
                $checkRespondentStmt = $conn->prepare($checkRespondentSql);
                $checkRespondentStmt->bindParam(':servicesID', $servicesID, PDO::PARAM_INT);
                $checkRespondentStmt->execute();
                $respondents = $checkRespondentStmt->fetchAll(PDO::FETCH_COLUMN, 0);

                if (count($respondents) > 0) {
                    // ถ้ามีข้อมูลใน sa_respondent, ลบข้อมูลใน sa_response2 ที่มี RespondentID ตรงกัน
                    $deleteResponsesSql = "DELETE FROM sa_response2 WHERE RespondentID IN (" . implode(',', array_fill(0, count($respondents), '?')) . ")";
                    $deleteResponsesStmt = $conn->prepare($deleteResponsesSql);
                    foreach ($respondents as $index => $respondentID) {
                        $deleteResponsesStmt->bindValue(($index + 1), $respondentID, PDO::PARAM_INT);
                    }
                    $deleteResponsesStmt->execute();

                    // ลบข้อมูลใน sa_respondent ที่มี service_id ตรงกับ servicesID
                    $deleteRespondentSql = "DELETE FROM sa_respondent WHERE service_id = :servicesID";
                    $deleteRespondentStmt = $conn->prepare($deleteRespondentSql);
                    $deleteRespondentStmt->bindParam(':servicesID', $servicesID, PDO::PARAM_INT);
                    $deleteRespondentStmt->execute();
                }

                // ลบ record ในตาราง sa_subservices ที่มี service_id ตรงกับ servicesID
                $deleteSubservicesSql = "DELETE FROM sa_subservices WHERE service_id = :servicesID";
                $deleteSubservicesStmt = $conn->prepare($deleteSubservicesSql);
                $deleteSubservicesStmt->bindParam(':servicesID', $servicesID, PDO::PARAM_INT);
                $deleteSubservicesStmt->execute();

                // ตรวจสอบว่ามีการลบใน sa_subservices สำเร็จหรือไม่
                $rowsAffected = $deleteSubservicesStmt->rowCount();

                // ไม่ว่าจะลบสำเร็จหรือไม่มีแถวที่ตรงกัน
                if ($rowsAffected > 0 || $rowsAffected === 0) {
                    // ลบ record ในตาราง sa_services ที่มี ID ตรงกับ servicesID
                    $deleteServicesSql = "DELETE FROM sa_services WHERE ID = :servicesID";
                    $deleteServicesStmt = $conn->prepare($deleteServicesSql);
                    $deleteServicesStmt->bindParam(':servicesID', $servicesID, PDO::PARAM_INT);
                    $deleteServicesStmt->execute();

                    // ตรวจสอบว่ามีการลบใน sa_services สำเร็จหรือไม่
                    if ($deleteServicesStmt->rowCount() > 0) {
                        // ถ้าสำเร็จ, ยืนยันการ transaction
                        $conn->commit();
                        echo json_encode(['status' => 'success']);
                    } else {
                        // ถ้าไม่สำเร็จ, แสดงข้อผิดพลาด SQL และยกเลิกการ transaction
                        $conn->rollBack();
                        $errorInfo = $deleteServicesStmt->errorInfo();
                        echo json_encode(['status' => 'error', 'message' => 'Failed to delete from sa_services', 'error' => $errorInfo]);
                    }
                } else {
                    // ถ้าลบใน sa_subservices ไม่สำเร็จ, แสดงข้อผิดพลาด SQL และยกเลิกการ transaction
                    $conn->rollBack();
                    $errorInfo = $deleteSubservicesStmt->errorInfo();
                    echo json_encode(['status' => 'error', 'message' => 'Failed to delete from sa_subservices', 'error' => $errorInfo]);
                }
            } else {
                // ถ้าไม่มีบริการนี้ใน sa_services
                echo json_encode(['status' => 'error', 'message' => 'Service not found', 'servicesID' => $servicesID]);
            }
        } catch (Exception $e) {
            // ถ้ามีข้อผิดพลาด, ยกเลิกการ transaction และส่ง error response
            $conn->rollBack();
            echo json_encode(['status' => 'error', 'message' => 'Transaction failed: ' . $e->getMessage()]);
        }
    } else {
        // ถ้าไม่มี servicesID ถูกส่งมา
        echo json_encode(['status' => 'error', 'message' => 'Missing servicesID']);
    }
}

?>