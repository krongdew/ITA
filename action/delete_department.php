<?php
include 'connect.php';

if(isset($_POST['departmentID'])) {
    $departmentID = $_POST['departmentID'];
    $stmt = $conn->prepare("DELETE FROM sa_department WHERE id = :departmentID");
    $stmt->bindParam(':departmentID', $departmentID, PDO::PARAM_INT);
    $stmt->execute();
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>



