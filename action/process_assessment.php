<?php

// เชื่อมต่อฐานข้อมูล
include 'connect.php';

// ตรวจสอบว่ามีการส่ง AssessmentID มาหรือไม่
if (isset($_POST['AssessmentID']) && !empty($_POST['AssessmentID'])) {
    // เก็บ AssessmentID จากข้อมูลที่ส่งมาในตัวแปร
    $AssessmentID = $_POST['AssessmentID'];
    $service_id = $_POST['service_id'];

    // บันทึกข้อมูลลงในตาราง sa_respondent
    $insertRespondentSql = "INSERT INTO sa_respondent (AssessmentID,service_id, SubmissionDate) VALUES (?,?, NOW())";
    $insertRespondentStmt = $conn->prepare($insertRespondentSql);
    $insertRespondentStmt->bindParam(1, $AssessmentID, PDO::PARAM_INT);
    $insertRespondentStmt->bindParam(2, $service_id, PDO::PARAM_INT);
    $insertRespondentStmt->execute();

    // ดึง RespondentID ของผู้ตอบที่เพิ่งถูกเพิ่มเข้าไป
    $respondentID = $conn->lastInsertId();

    // วนลูปผ่านแต่ละคำถามเพื่อบันทึกข้อมูลในตาราง sa_response
    foreach ($_POST as $key => $value) {
        // ตรวจสอบว่าคีย์มีคำว่า QuestionAns หรือไม่
        if (strpos($key, 'QuestionAns') !== false) {
            $questionID = substr($key, 11); // ดึง QuestionID จากคีย์
            $questionTypeKey = 'QuestionType' . $questionID; // สร้างคีย์สำหรับ QuestionType

            // ตรวจสอบว่ามีคีย์ QuestionType หรือไม่
            if (isset($_POST[$questionTypeKey])) {
                $questionType = $_POST[$questionTypeKey]; // ดึงค่า QuestionType
                
                // กำหนดคอลัมน์ที่จะบันทึกข้อมูลตามประเภทของคำถาม
                switch ($questionType) {
                    case 'Rate':
                        $insertResponseSql = "INSERT INTO sa_response (RespondentID, QuestionID, Rating) VALUES (?, ?, ?)";
                        $insertResponseStmt = $conn->prepare($insertResponseSql);
                        $insertResponseStmt->bindParam(1, $respondentID, PDO::PARAM_INT);
                        $insertResponseStmt->bindParam(2, $questionID, PDO::PARAM_INT);
                        $insertResponseStmt->bindParam(3, $value, PDO::PARAM_INT);
                        $insertResponseStmt->execute();
                        break;
                    case 'Choice':
                        $insertResponseSql = "INSERT INTO sa_response (RespondentID, QuestionID, Choices) VALUES (?, ?, ?)";
                        $insertResponseStmt = $conn->prepare($insertResponseSql);
                        $insertResponseStmt->bindParam(1, $respondentID, PDO::PARAM_INT);
                        $insertResponseStmt->bindParam(2, $questionID, PDO::PARAM_INT);
                        $insertResponseStmt->bindParam(3, $value, PDO::PARAM_STR);
                        $insertResponseStmt->execute();
                        break;
                    case 'Date':
                        $insertResponseSql = "INSERT INTO sa_response (RespondentID, QuestionID, Date) VALUES (?, ?, ?)";
                        $insertResponseStmt = $conn->prepare($insertResponseSql);
                        $insertResponseStmt->bindParam(1, $respondentID, PDO::PARAM_INT);
                        $insertResponseStmt->bindParam(2, $questionID, PDO::PARAM_INT);
                        $insertResponseStmt->bindParam(3, $value, PDO::PARAM_STR);
                        $insertResponseStmt->execute();
                        break;
                    case 'Ans':
                        $insertResponseSql = "INSERT INTO sa_response (RespondentID, QuestionID, Comment) VALUES (?, ?, ?)";
                        $insertResponseStmt = $conn->prepare($insertResponseSql);
                        $insertResponseStmt->bindParam(1, $respondentID, PDO::PARAM_INT);
                        $insertResponseStmt->bindParam(2, $questionID, PDO::PARAM_INT);
                        $insertResponseStmt->bindParam(3, $value, PDO::PARAM_STR);
                        $insertResponseStmt->execute();
                        break;
                    case 'Service':
                        $insertResponseSql = "INSERT INTO sa_response (RespondentID, QuestionID, Service) VALUES (?, ?, ?)";
                        $insertResponseStmt = $conn->prepare($insertResponseSql);
                        $insertResponseStmt->bindParam(1, $respondentID, PDO::PARAM_INT);
                        $insertResponseStmt->bindParam(2, $questionID, PDO::PARAM_INT);
                        $insertResponseStmt->bindParam(3, $value, PDO::PARAM_STR);
                        $insertResponseStmt->execute();
                        break;
                    default:
                        echo "ไม่พบประเภทคำถาม: $questionType";
                        break;
                }
            } else {
                echo "ไม่พบคีย์ QuestionType สำหรับ QuestionID: $questionID";
            }
        }
    }
    
    // ส่งกลับไปยังหน้าที่ต้องการหลังจากการประมวลผลเสร็จสิ้น
    echo '<script>window.location.href = "../success.php";</script>';
    exit();
} else {
    // หากไม่มี AssessmentID ที่ส่งมาหรือว่างเปล่า แสดงข้อความผิดพลาด
    echo "ข้อผิดพลาด: ไม่ได้รับ AssessmentID";
}

?>
