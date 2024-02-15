<?php
include 'connect.php';

$columns = array('ID', 'service_id', 'subservice_id', 'number_people', 'Date');

$query = "SELECT * FROM sa_number_of_people WHERE 1";

if(isset($_POST["service_id"])) {
    $serviceID = $_POST["service_id"];
    $query .= " AND service_id = :service_id";
}
if(isset($_POST["filter_date"])) {
    $query .= " AND Date = :filter_date";
} elseif(isset($_POST["filter_month_year"])) {
    $filterMonthYear = $_POST["filter_month_year"];
    $query .= " AND MONTH(Date) = MONTH(:filter_month_year) AND YEAR(Date) = YEAR(:filter_month_year)";
} elseif(isset($_POST["filter_start_date"]) && isset($_POST["filter_end_date"])) {
    $query .= " AND Date BETWEEN :filter_start_date AND :filter_end_date";
}

$statement = $conn->prepare($query);

if(isset($_POST["service_id"])) {
    $statement->bindParam(':service_id', $serviceID);
}
if(isset($_POST["filter_date"])) {
    $statement->bindParam(':filter_date', $_POST["filter_date"]);
} elseif(isset($_POST["filter_month_year"])) {
    $statement->bindParam(':filter_month_year', $filterMonthYear);
} elseif(isset($_POST["filter_start_date"]) && isset($_POST["filter_end_date"])) {
    $statement->bindParam(':filter_start_date', $_POST["filter_start_date"]);
    $statement->bindParam(':filter_end_date', $_POST["filter_end_date"]);
}

$statement->execute();
$result = $statement->fetchAll();

$data = array();
foreach($result as $row) {
    $sub_array = array();
    $sub_array[] = $row['ID'];
    $sub_array[] = $row['service_id'];
    $sub_array[] = $row['subservice_id'];
    $sub_array[] = $row['number_people'];
    $sub_array[] = $row['Date'];
    $data[] = $sub_array;
}
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;


$output = array(
    "draw"    => $draw,
    "recordsTotal"  =>  $statement->rowCount(),
    "recordsFiltered" => get_total_all_records(),
    "data"    => $data
);


echo json_encode($output);

function get_total_all_records() {
    include 'connect.php';
    $statement = $conn->prepare("SELECT * FROM sa_number_of_people");
    $statement->execute();
    return $statement->rowCount();
}
?>
