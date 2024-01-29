<?php
// Include your database connection or configuration file here
// For example, include 'db_connection.php';
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form
    $service_name = $_POST['service_name'];
    $service_detail = $_POST['service_detail'];
    $service_status = isset($_POST['service_status']) ? 1 : 0; // Check if the checkbox is checked
    $service_Access = $_POST['department_id'];
    $created_by = "admin"; // You can customize the value
    $updated_by = "admin"; // You can customize the value

    try {
        // Include your database connection or configuration file here
        // For example, include 'db_connection.php';
        // $conn = new PDO("mysql:host=localhost;dbname=your_database_name", "your_username", "your_password");
        // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Start a transaction
        $conn->beginTransaction();

        // Insert data into sa_services table
        $sql = "INSERT INTO sa_services (service_name, service_detail, service_status, service_Access, created_by, updated_by) 
                VALUES (:service_name, :service_detail, :service_status, :service_Access, :created_by, :updated_by)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':service_name', $service_name);
        $stmt->bindParam(':service_detail', $service_detail);
        $stmt->bindParam(':service_status', $service_status);
        $stmt->bindParam(':service_Access', $service_Access);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->bindParam(':updated_by', $updated_by);
        $stmt->execute();

        // Get the ID of the last inserted row
        $service_id = $conn->lastInsertId();

        // Insert data into sa_subservices table
        if (isset($_POST['subservice_name'])) {
            $subservice_names = $_POST['subservice_name'];
            $subservice_details = $_POST['subservice_detail'];
            $subservice_statuses = $_POST['subservice_status'];
            $subservice_Accesses = $_POST['subservice_Access'];
            $created_ats = date('Y-m-d H:i:s');

            foreach ($subservice_names as $key => $subservice_name) {
                $sql = "INSERT INTO sa_subservices (service_id, subservice_name, subservice_detail, subservice_status, subservice_Access, created_at, created_by, updated_by) 
                        VALUES (:service_id, :subservice_name, :subservice_detail, :subservice_status, :subservice_Access, :created_at, :created_by, :updated_by)";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':service_id', $service_id);
                $stmt->bindParam(':subservice_name', $subservice_name);
                $stmt->bindParam(':subservice_detail', $subservice_details[$key]);
                $stmt->bindParam(':subservice_status', $subservice_statuses[$key]);
                $stmt->bindParam(':subservice_Access', $subservice_Accesses[$key]);
                $stmt->bindParam(':created_at', $created_ats);
                $stmt->bindParam(':created_by', $created_by);
                $stmt->bindParam(':updated_by', $updated_by);
                $stmt->execute();
            }
        }

        // Commit the transaction
        $conn->commit();

        echo "Data inserted successfully";
    } catch (PDOException $e) {
        // Rollback the transaction in case of error
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the database connection
        $conn = null;
    }
} else {
    echo "Invalid request method";
}
?>
