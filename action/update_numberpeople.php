<?php
include 'connect.php';

if(isset($_POST['number_peopleID']) && isset($_POST['editedData'])) {
    $number_peopleID = $_POST['number_peopleID'];
    $editedData = $_POST['editedData'];

    // Update data in the database
    $stmt = $conn->prepare("UPDATE sa_number_of_people SET number_people = :number_people WHERE id = :number_peopleID");
    $stmt->bindParam(':number_people', $editedData['number_people'], PDO::PARAM_STR);
   
    $stmt->bindParam(':number_peopleID', $number_peopleID, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
} else {
    echo json_encode(['status' => 'errorID']);
}
?>