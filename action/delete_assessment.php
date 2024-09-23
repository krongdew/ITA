<?php
include 'connect.php';

if (isset($_POST['AssessmentID'])) {
    try {
        $conn->beginTransaction();

        $AssessmentID = $_POST['AssessmentID'];

        // ลบข้อมูลที่เกี่ยวข้องในตาราง sa_response2 ผ่านการอ้างอิง RespondentID
        $stmt0 = $conn->prepare("
            DELETE sa_response2
            FROM sa_response2
            INNER JOIN sa_respondent ON sa_response2.RespondentID = sa_respondent.RespondentID
            WHERE sa_respondent.AssessmentID = :AssessmentID
        ");
        $stmt0->bindParam(':AssessmentID', $AssessmentID, PDO::PARAM_INT);
        $stmt0->execute();

        // ลบข้อมูลที่เกี่ยวข้องในตาราง sa_respondent
        $stmt1 = $conn->prepare("DELETE FROM sa_respondent WHERE AssessmentID = :AssessmentID");
        $stmt1->bindParam(':AssessmentID', $AssessmentID, PDO::PARAM_INT);
        $stmt1->execute();

        // ลบข้อมูลที่เกี่ยวข้องในตาราง sa_question
        $stmt2 = $conn->prepare("DELETE FROM sa_question WHERE AssessmentID = :AssessmentID");
        $stmt2->bindParam(':AssessmentID', $AssessmentID, PDO::PARAM_INT);
        $stmt2->execute();

        // ลบข้อมูลในตาราง sa_assessment
        $stmt3 = $conn->prepare("DELETE FROM sa_assessment WHERE AssessmentID = :AssessmentID");
        $stmt3->bindParam(':AssessmentID', $AssessmentID, PDO::PARAM_INT);
        $stmt3->execute();

        $conn->commit();
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        $conn->rollBack();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'AssessmentID is not set']);
}
?>
