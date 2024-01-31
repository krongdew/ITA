<?php
include 'connect.php';

if(isset($_POST['AssessmentID'])) {
    $AssessmentID = $_POST['AssessmentID'];
    $stmt = $conn->prepare("DELETE FROM sa_assessment WHERE AssessmentID = :AssessmentID");
    $stmt->bindParam(':AssessmentID', $AssessmentID, PDO::PARAM_INT);
    $stmt->execute();
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>



