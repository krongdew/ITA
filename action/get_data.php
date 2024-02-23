<?php
// Include database connection
include('connect.php');

// Initialize response array
$response = array();

// Check if the request is sent using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve search parameters from POST data
    $searchName = $_POST['searchByName'] ?? '';
    $searchDate = $_POST['searchDate'] ?? '';
    $startDate = $_POST['startDate'] ?? '';
    $endDate = $_POST['endDate'] ?? '';
    $monthInput = $_POST['monthInput'] ?? '';
    
    $service_id = isset($_POST['service_id']) ? $_POST['service_id'] : null;
    
    // Prepare SQL statement
    $sql = "SELECT sa_number_of_people.*, sa_subservices.subservice_name  FROM sa_number_of_people JOIN sa_subservices ON sa_number_of_people.subservice_id = sa_subservices.ID WHERE sa_number_of_people.service_id = $service_id";

    // Append conditions based on search parameters
    if (!empty($searchName)) {
        $sql .= " AND sa_subservices.subservice_name LIKE '%$searchName%'";
    }
    if (!empty($searchDate)) {
        $sql .= " AND sa_number_of_people.Date = :searchDate";
    }
    if (!empty($startDate)) {
        $sql .= " AND sa_number_of_people.Date >= :startDate";
    }
    if (!empty($endDate)) {
        $sql .= " AND sa_number_of_people.Date <= :endDate";
    }
    if (!empty($monthInput)) {
        $sql .= " AND DATE_FORMAT(sa_number_of_people.Date, '%Y-%m') = :monthInput";
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    if (!empty($searchDate)) {
        $stmt->bindParam(':searchDate', $searchDate);
    }
    if (!empty($startDate)) {
        $stmt->bindParam(':startDate', $startDate);
    }
    if (!empty($endDate)) {
        $stmt->bindParam(':endDate', $endDate);
    }
    if (!empty($monthInput)) {
        $stmt->bindParam(':monthInput', $monthInput);
    }

    // Execute SQL query
    $stmt->execute();

    // Fetch data as associative array
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return data as JSON
    echo json_encode($data);
} else {
    // Return error message if request method is not POST
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
}
?>
