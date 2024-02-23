<?php
// Include the database connection file
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Get service_id and date from the AJAX request
$service_id = $_POST['service_id'];
$date = $_POST['date'];

try {
    // Check if the selected date already exists for the given service_id
    $sql = "SELECT COUNT(*) as count FROM sa_number_of_people WHERE service_id = :service_id AND Date = :date";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':service_id', $service_id);
    $stmt->bindParam(':date', $date);
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Send response based on the count
    if ($result['count'] > 0) {
        echo 'duplicate';
    } else {
        echo 'not_duplicate';
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
}
?>
