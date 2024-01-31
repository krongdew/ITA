<?php
include 'connect.php';

if(isset($_POST['number_peopleID'])) {
    $number_peopleID = $_POST['number_peopleID'];
    $stmt = $conn->prepare("DELETE FROM sa_number_of_people WHERE id = :number_peopleID");
    $stmt->bindParam(':number_peopleID', $number_peopleID, PDO::PARAM_INT);
    $stmt->execute();
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>



