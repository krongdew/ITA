<?php
include 'connect.php';

if(isset($_POST['userID'])) {
    $userID = $_POST['userID'];
   
    $stmt = $conn->prepare("DELETE FROM sa_users WHERE id = :userID");
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>



