<?php
// get_years.php
include 'connect.php';

$selectedYear = isset($_POST['selectedYear']) ? intval($_POST['selectedYear']) : date('Y');

$startYear = $selectedYear - 1;
$endYear = $selectedYear;

$sql = "SELECT DISTINCT YEAR(Date) as year FROM sa_number_of_people WHERE YEAR(Date) BETWEEN :start_year AND :end_year";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':start_year', $startYear);
$stmt->bindParam(':end_year', $endYear);
$stmt->execute();

$years = $stmt->fetchAll(PDO::FETCH_COLUMN);
echo json_encode($years);
?>


