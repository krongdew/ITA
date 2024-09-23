<?php

// เชื่อมต่อฐานข้อมูล
include 'connect.php';

// ตรวจสอบว่ามีการส่ง AssessmentID มาหรือไม่
if (isset($_POST['AssessmentID']) && !empty($_POST['AssessmentID'])) {
    // เก็บ AssessmentID จากข้อมูลที่ส่งมาในตัวแปร
    $AssessmentID = $_POST['AssessmentID'];
    $service_id = $_POST['service_id'];
    $subservice_id = $_POST['subservice_id'];
    
    
    if($subservice_id != 0) {

    // บันทึกข้อมูลลงในตาราง sa_respondent
    $insertRespondentSql = "INSERT INTO sa_respondent (AssessmentID, service_id, subservice_id, SubmissionDate) VALUES (?,?,?, NOW())";
    $insertRespondentStmt = $conn->prepare($insertRespondentSql);
    $insertRespondentStmt->bindParam(1, $AssessmentID, PDO::PARAM_INT);
    $insertRespondentStmt->bindParam(2, $service_id, PDO::PARAM_INT);
    $insertRespondentStmt->bindParam(3, $subservice_id, PDO::PARAM_INT);
    $insertRespondentStmt->execute();
    
    }else {
       // บันทึกข้อมูลลงในตาราง sa_respondent
    $insertRespondentSql = "INSERT INTO sa_respondent (AssessmentID, service_id, SubmissionDate) VALUES (?,?, NOW())";
    $insertRespondentStmt = $conn->prepare($insertRespondentSql);
    $insertRespondentStmt->bindParam(1, $AssessmentID, PDO::PARAM_INT);
    $insertRespondentStmt->bindParam(2, $service_id, PDO::PARAM_INT);
    $insertRespondentStmt->execute();
     
    }
    
    // ดึง RespondentID ของผู้ตอบที่เพิ่งถูกเพิ่มเข้าไป
    $respondentID = $conn->lastInsertId();

    // สร้างอาร์เรย์เพื่อเก็บข้อมูลคำตอบ
    $responses = [];

    // วนลูปผ่านแต่ละคำถามเพื่อบันทึกข้อมูลในรูปแบบ JSON
    foreach ($_POST as $key => $value) {
        // ตรวจสอบว่าคีย์มีคำว่า QuestionAns หรือไม่
        if (strpos($key, 'QuestionAns') !== false) {
            $questionID = substr($key, 11); // ดึง QuestionID จากคีย์
            $questionTypeKey = 'QuestionType' . $questionID; // สร้างคีย์สำหรับ QuestionType

            // ตรวจสอบว่ามีคีย์ QuestionType หรือไม่
            if (isset($_POST[$questionTypeKey])) {
                $questionType = $_POST[$questionTypeKey]; // ดึงค่า QuestionType
                
                // เพิ่มคำตอบลงในอาร์เรย์
                $responses[] = [
                    'QuestionID' => $questionID,
                    'QuestionType' => $questionType,
                    'Answer' => $value
                ];
            }
        }
    }

    // แปลงอาร์เรย์คำตอบเป็น JSON
    $responsesJson = json_encode($responses);

    // บันทึกข้อมูล JSON ลงในตาราง sa_response
    $insertResponseSql = "INSERT INTO sa_response2 (RespondentID, Responses, timestamp) VALUES (?, ?, Now())";
    $insertResponseStmt = $conn->prepare($insertResponseSql);
    $insertResponseStmt->bindParam(1, $respondentID, PDO::PARAM_INT);
    $insertResponseStmt->bindParam(2, $responsesJson, PDO::PARAM_STR);
    $insertResponseStmt->execute();

    // ส่งกลับไปยังหน้าที่ต้องการหลังจากการประมวลผลเสร็จสิ้น
    echo '<script>window.location.href = "../pages/success.php";</script>';
    exit();
} else {
    // หากไม่มี AssessmentID ที่ส่งมาหรือว่างเปล่า แสดงข้อความผิดพลาด
    echo "ข้อผิดพลาด: ไม่ได้รับ AssessmentID";
}

?>
