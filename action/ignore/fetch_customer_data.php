<?php
include 'connect.php';

function getServiceName($serviceId)
{
    global $conn;

    $sql = "SELECT service_name FROM sa_services WHERE ID = :service_id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':service_id', $serviceId);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ? $result['service_name'] : null;
}

function getMonthName($monthNumber)
{
    $monthNames = [
        1 => 'Jan',
        2 => 'Feb',
        3 => 'Mar',
        4 => 'Apr',
        5 => 'May',
        6 => 'Jun',
        7 => 'Jul',
        8 => 'Aug',
        9 => 'Sep',
        10 => 'Oct',
        11 => 'Nov',
        12 => 'Dec',
    ];

    return isset($monthNames[$monthNumber]) ? $monthNames[$monthNumber] : '';
}

// Check if POST variables exist
$yearFilter = isset($_POST['yearFilter']) ? $_POST['yearFilter'] : null;
$startMonthFilter = isset($_POST['startMonthFilter']) ? $_POST['startMonthFilter'] : null;
$endMonthFilter = isset($_POST['endMonthFilter']) ? $_POST['endMonthFilter'] : null;

// Set Content-Type header
header('Content-Type: application/json');

// Convert months to YYYY-MM format
if ($startMonthFilter != "") {
    $startMonthFilter .= "-01";
}

if ($endMonthFilter != "") {
    $endMonthFilter .= "-01";
}

$sql = "SELECT service_id, 
               SUM(number_people) as total_number_people, 
               MONTH(Date) as month,
               YEAR(Date) as year
        FROM sa_number_of_people 
        WHERE 1";

if ($yearFilter != "") {
    $sql .= " AND YEAR(Date) = :yearFilter";
}

if ($startMonthFilter != "" && $endMonthFilter != "") {
    $sql .= " AND Date BETWEEN :startMonthFilter AND :endMonthFilter";
}

$sql .= " GROUP BY service_id, MONTH(Date), YEAR(Date) ORDER BY YEAR(Date), MONTH(Date)";

try {
    $stmt = $conn->prepare($sql);

    // Bind parameters
    if ($yearFilter != "") {
        $stmt->bindParam(':yearFilter', $yearFilter, PDO::PARAM_STR);
    }

    if ($startMonthFilter != "" && $endMonthFilter != "") {
        $stmt->bindParam(':startMonthFilter', $startMonthFilter, PDO::PARAM_STR);
        $stmt->bindParam(':endMonthFilter', $endMonthFilter, PDO::PARAM_STR);
    }

    $stmt->execute();

    $data = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $row['service_name'] = getServiceName($row['service_id']);
        $row['month'] = getMonthName($row['month']) . '-' . $row['year'];
        $data[] = $row;
    }

    // Send JSON response
    echo json_encode(array("data" => $data));
} catch (PDOException $e) {
    // Log any exceptions
    error_log('PDOException: ' . $e->getMessage());
    echo json_encode(array("error" => "An error occurred while fetching data."));
}
?>
