
<?php
include 'connect.php';

// ตรวจสอบว่ามีข้อมูลที่ถูกส่งมาหรือไม่
if (isset($_POST['AssessmentID']) && isset($_POST['QuestionText']) && isset($_POST['QuestionOrder']) && isset($_POST['QuestionType'])) {
    try {
        // เตรียมคำสั่ง SQL สำหรับ INSERT ข้อมูลคำถาม
        $stmt = $conn->prepare("INSERT INTO sa_question (AssessmentID, QuestionText, QuestionOrder, QuestionType, chioce_id) VALUES (:AssessmentID, :QuestionText, :QuestionOrder, :QuestionType, :ChoiceID)");

        // เตรียมคำสั่ง SQL สำหรับ UPDATE คอลัมน์ AssessmentStatus
        $updateStmt = $conn->prepare("UPDATE sa_assessment SET AssessmentStatus = 'สร้างข้อคำถามแล้ว รออนุมัติ' WHERE AssessmentID = :AssessmentID");

        // วนลูปเพื่อบันทึกข้อมูลจากฟอร์ม
        foreach ($_POST['AssessmentID'] as $key => $assessmentID) {
            // ดึงข้อมูลจากฟอร์ม
            $QuestionText = $_POST['QuestionText'][$key];
            $QuestionOrder = $_POST['QuestionOrder'][$key];
            $QuestionType = $_POST['QuestionType'][$key];
            $ChoiceID = $_POST['chioce_id'][$key];
            
            // ผูกค่าตัวแปรกับพารามิเตอร์ในคำสั่ง SQL สำหรับ INSERT
            $stmt->bindParam(':AssessmentID', $assessmentID);
            $stmt->bindParam(':QuestionText', $QuestionText);
            $stmt->bindParam(':QuestionOrder', $QuestionOrder);
            $stmt->bindParam(':QuestionType', $QuestionType);
            $stmt->bindParam(':ChoiceID', $ChoiceID);

            // ทำการ execute คำสั่ง SQL สำหรับ INSERT
            $stmt->execute();

            // ผูกค่าตัวแปรกับพารามิเตอร์ในคำสั่ง SQL สำหรับ UPDATE
            $updateStmt->bindParam(':AssessmentID', $assessmentID);

            // ทำการ execute คำสั่ง SQL สำหรับ UPDATE
            $updateStmt->execute();

            // // แสดงผลลัพธ์ของการบันทึกข้อมูล
            // echo "บันทึกข้อมูลคำถามรอบที่ {$key} เรียบร้อยแล้ว<br>";
            // echo "ค่าของ chioce_id ที่ถูกบันทึก: {$_POST['chioce_id'][$key]}<br>";
        }

        // สำเร็จ
        echo "<script>alert('บันทึกข้อคำถามแล้ว')</script>";
        echo '<script>window.location.href = "../pages/assessment.php";</script>';
        
    } catch (PDOException $e) {
        // เกิดข้อผิดพลาด
        echo "การบันทึกข้อมูลล้มเหลว: " . $e->getMessage();
    }
} else {
    // ไม่มีข้อมูลที่ถูกส่งมา
    echo "ไม่พบข้อมูลที่จะบันทึก";
}


// include 'connect.php';

// // ตรวจสอบว่ามีข้อมูลที่ถูกส่งมาหรือไม่
// if (isset($_POST['AssessmentID']) && isset($_POST['QuestionText']) && isset($_POST['QuestionOrder']) && isset($_POST['QuestionType'])) {
//     try {
//         // เตรียมคำสั่ง SQL สำหรับ INSERT ข้อมูลคำถาม
//         $stmt = $conn->prepare("INSERT INTO sa_question (AssessmentID, QuestionText, QuestionOrder, QuestionType, chioce_id) VALUES (:AssessmentID, :QuestionText, :QuestionOrder, :QuestionType, :ChoiceID)");

//         // เตรียมคำสั่ง SQL สำหรับ UPDATE คอลัมน์ AssessmentStatus
//         $updateStmt = $conn->prepare("UPDATE sa_assessment SET AssessmentStatus = 'สร้างข้อคำถามแล้ว รออนุมัติ' WHERE AssessmentID = :AssessmentID");

//         // วนลูปเพื่อบันทึกข้อมูลจากฟอร์ม
//         foreach ($_POST['AssessmentID'] as $key => $assessmentID) {
//             // ดึงข้อมูลจากฟอร์ม
//             $QuestionText = $_POST['QuestionText'][$key];
//             $QuestionOrder = $_POST['QuestionOrder'][$key];
//             $QuestionType = $_POST['QuestionType'][$key];

//             // ตรวจสอบว่าเป็น Choice หรือไม่
            
//                 if ($QuestionType == 'Choice') {                
//                     $ChoiceID = $_POST['chioce_id'][$key];
//                 }else {
//                     $ChoiceID = 0;
//                 }
            
            
//             // ผูกค่าตัวแปรกับพารามิเตอร์ในคำสั่ง SQL สำหรับ INSERT
//             $stmt->bindParam(':AssessmentID', $assessmentID);
//             $stmt->bindParam(':QuestionText', $QuestionText);
//             $stmt->bindParam(':QuestionOrder', $QuestionOrder);
//             $stmt->bindParam(':QuestionType', $QuestionType);
//             $stmt->bindParam(':ChoiceID', $ChoiceID);

//             // ทำการ execute คำสั่ง SQL สำหรับ INSERT
//             $stmt->execute();

//             // ผูกค่าตัวแปรกับพารามิเตอร์ในคำสั่ง SQL สำหรับ UPDATE
//             $updateStmt->bindParam(':AssessmentID', $assessmentID);

//             // ทำการ execute คำสั่ง SQL สำหรับ UPDATE
//             $updateStmt->execute();
//         }

//         // สำเร็จ
//         echo "<script>alert('บันทึกข้อคำถามแล้ว')</script>";
//         // echo '<script>window.location.href = "../pages/assessment.php";</script>';
//     } catch (PDOException $e) {
//         // เกิดข้อผิดพลาด
//         echo "การบันทึกข้อมูลล้มเหลว: " . $e->getMessage();
//     }
// } else {
//     // ไม่มีข้อมูลที่ถูกส่งมา
//     echo "ไม่พบข้อมูลที่จะบันทึก";
// }
?>
