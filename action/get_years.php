<?php
// get_years.php
include 'connect.php';

$sql = "SELECT DISTINCT YEAR(Date) as year FROM sa_number_of_people ORDER BY YEAR(Date) DESC";
$stmt = $conn->query($sql);

$years = $stmt->fetchAll(PDO::FETCH_COLUMN);
echo json_encode($years);
?>
