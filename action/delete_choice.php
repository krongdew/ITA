<?php
include 'connect.php';

if(isset($_POST['choiceID'])) {
    $choiceID = $_POST['choiceID'];
    $stmt = $conn->prepare("DELETE FROM sa_choice_name WHERE ID = :choiceID");
    $stmt->bindParam(':choiceID', $choiceID, PDO::PARAM_INT);
    $stmt->execute();
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>



