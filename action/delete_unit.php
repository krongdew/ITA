<?php
include 'connect.php';

if(isset($_POST['unitID'])) {
    $unitID = $_POST['unitID'];
    $stmt = $conn->prepare("DELETE FROM sa_unit WHERE id = :unitID");
    $stmt->bindParam(':unitID', $unitID, PDO::PARAM_INT);
    $stmt->execute();
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>



