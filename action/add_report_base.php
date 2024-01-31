<?php
// Include the database connection file
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $service_id = $_POST['service_id'];
    $date = $_POST['Date'];
    $timestamp = date('Y-m-d H:i:s');

    // Check if data already exists for the given service_id and date
    $checkSql = "SELECT COUNT(*) as count FROM sa_number_of_people WHERE service_id = :service_id AND Date = :date";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bindParam(':service_id', $service_id);
    $checkStmt->bindParam(':date', $date);
    $checkStmt->execute();
    $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        // Redirect back to the form page with an error message
        echo "<script>alert('ไม่สามารถบันทึกข้อมูลได้ เนื่องจากท่านได้บันทึกข้อมูลในวันนี้ไปแล้ว')</script>";
        echo '<script>window.location.href = "../pages/add_report.php?ID='.$service_id.'";</script>';
        exit();
    }

    // Prepare the SQL statement for inserting data
    $insertSql = "INSERT INTO sa_number_of_people (service_id, subservice_id, number_people, Date, timestamp) VALUES (:service_id, :subservice_id, :number_people, :date, :timestamp)";

    try {
        // Use prepared statements to prevent SQL injection
        $insertStmt = $conn->prepare($insertSql);

        // Loop through submitted data
        foreach ($_POST['number_people'] as $subservice_id => $number_people) {
            // Bind parameters
            $insertStmt->bindParam(':service_id', $service_id);
            $insertStmt->bindParam(':subservice_id', $subservice_id);
            $insertStmt->bindParam(':number_people', $number_people);
            $insertStmt->bindParam(':date', $date);
            $insertStmt->bindParam(':timestamp', $timestamp);

            // Execute the statement
            $insertStmt->execute();
        }

        // Redirect to the display_report page with success message
        echo "<script>alert('เพิ่มจำนวนผู้ใช้สำเร็จ')</script>";
        echo '<script>window.location.href = "../pages/add_report.php?ID='.$service_id.'";</script>';
        exit();
    } catch (PDOException $e) {
        // Redirect back to the form page with an error message
        echo "<script>alert('ไม่สามารถเพิ่มจำนวนผู้ใช้ได้')</script>";
        echo '<script>window.location.href = "../pages/add_report.php";</script>';
        exit();
    }
} else {
    // Redirect to the form page if accessed without submitting the form
    header("Location: ../pages/add_report.php");
    exit();
}
?>
