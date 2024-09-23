<?php
include 'connect.php';

// ตรวจสอบว่ามีข้อมูลที่ถูกส่งมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    try {   
        $assessmentID = $_POST['AssessmentID'];
        $assessmentName = $_POST['AssessmentName'];

        // // ตรวจสอบว่า AssessmentID มีอยู่ในตาราง sa_assessment หรือไม่
        // $checkAssessmentStmt = $conn->prepare("SELECT COUNT(*) FROM sa_assessment WHERE AssessmentID = :AssessmentID");
        // $checkAssessmentStmt->bindParam(':AssessmentID', $assessmentID, PDO::PARAM_INT);
        // $checkAssessmentStmt->execute();
        // $assessmentExists = $checkAssessmentStmt->fetchColumn();

        // if ($assessmentExists == 0) {
        //     throw new Exception("AssessmentID ที่ระบุไม่มีอยู่ในตาราง sa_assessment");
        // }

        // เตรียมคำสั่ง SQL สำหรับ UPDATE ชื่อแบบประเมิน
        $updateAssessmentStmt = $conn->prepare("UPDATE sa_assessment SET AssessmentName = :AssessmentName, AssessmentStatus = 'แก้ไขแบบประเมินแล้ว รอตรวจสอบ' WHERE AssessmentID = :AssessmentID");
        $updateAssessmentStmt->bindParam(':AssessmentID', $assessmentID, PDO::PARAM_INT);
        $updateAssessmentStmt->bindParam(':AssessmentName', $assessmentName, PDO::PARAM_STR);
        $updateAssessmentStmt->execute();

        // เตรียมคำสั่ง SQL สำหรับ INSERT และ UPDATE ข้อมูลคำถาม
        
        // วนลูปเพื่อบันทึกข้อมูลจากฟอร์ม
        if (isset($_POST['QuestionText']) && is_array($_POST['QuestionText']) && is_array($_POST['assessmentID'])) {
            foreach ($_POST['QuestionText'] as $key => $QuestionText) {
                // รับข้อมูลจากฟอร์ม
                $questionID = isset($_POST['QuestionID'][$key]) ? $_POST['QuestionID'][$key] : null;
                $questionText = $_POST['QuestionText'][$key];
                $questionOrder = $_POST['QuestionOrder'][$key];
                $questionType = $_POST['QuestionType'][$key];
                $choiceID = isset($_POST['chioce_id'][$key]) ? $_POST['chioce_id'][$key] : 0;
                $assessmentID = $_POST['assessmentID'][$key];

                // Debug: แสดงค่าแต่ละตัวแปร
                echo "Key: $key, AssessmentID:$assessmentID,  QuestionID: $questionID, QuestionText: $questionText, QuestionOrder: $questionOrder, QuestionType: $questionType, ChoiceID: $choiceID<br>";

                if (!empty($questionID)) {
                    // ดึงค่า chioce_id ปัจจุบันจากฐานข้อมูล
                    $currentChoiceStmt = $conn->prepare("SELECT chioce_id FROM sa_question WHERE QuestionID = :QuestionID");
                    $currentChoiceStmt->bindParam(':QuestionID', $questionID, PDO::PARAM_INT);
                    $currentChoiceStmt->execute();
                    $currentChoice = $currentChoiceStmt->fetchColumn();
                    
                    var_dump($currentChoice);

                    // ตรวจสอบว่า chioce_id ปัจจุบันกับค่าใหม่ตรงกันหรือไม่
                    if ($currentChoice != $choiceID) {
                        // เป็นการแก้ไขข้อมูลคำถามเมื่อ chioce_id เปลี่ยนแปลง
                        $updateStmt = $conn->prepare("UPDATE sa_question SET QuestionText = :QuestionText, QuestionOrder = :QuestionOrder, QuestionType = :QuestionType, chioce_id = :choiceID WHERE QuestionID = :QuestionID");

                        $updateStmt->bindParam(':QuestionID', $questionID, PDO::PARAM_INT);
                        $updateStmt->bindParam(':QuestionText', $questionText, PDO::PARAM_STR);
                        $updateStmt->bindParam(':QuestionOrder', $questionOrder, PDO::PARAM_INT);
                        $updateStmt->bindParam(':QuestionType', $questionType, PDO::PARAM_STR);
                        $updateStmt->bindParam(':choiceID', $choiceID, PDO::PARAM_INT);
                        
                        $updateStmt->execute();
                    }
                    
                } else {
                    // เป็นการเพิ่มข้อมูลใหม่คำถาม
                    
                    
                    $insertStmt = $conn->prepare("INSERT INTO sa_question (AssessmentID, QuestionText, QuestionOrder, QuestionType, chioce_id) VALUES (:assessmentID, :QuestionText, :QuestionOrder, :QuestionType, :ChoiceID)");
                    $insertStmt->bindParam(':assessmentID', $assessmentID, PDO::PARAM_INT);
                    $insertStmt->bindParam(':QuestionText', $questionText, PDO::PARAM_STR);
                    $insertStmt->bindParam(':QuestionOrder', $questionOrder, PDO::PARAM_INT);
                    $insertStmt->bindParam(':QuestionType', $questionType, PDO::PARAM_STR);
                    $insertStmt->bindParam(':ChoiceID', $choiceID, PDO::PARAM_INT);  
                    $insertStmt->execute();
                }
            }
        }

        // สำเร็จ
        echo "<script>alert('แก้ไขและเพิ่มข้อคำถามสำเร็จ')</script>";
        // echo '<script>window.location.href = "../pages/assessment.php";</script>';
        exit();
        
    } catch (Exception $e) {
        // เกิดข้อผิดพลาด
        echo "การบันทึกข้อมูลล้มเหลว: " . $e->getMessage();
    }
} else {
    // ไม่มีข้อมูลที่ถูกส่งมา
    echo "ไม่พบข้อมูลที่จะบันทึก";
    exit();
}
?>
