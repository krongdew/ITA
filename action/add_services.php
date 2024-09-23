<?php
// Include your database connection or configuration file here
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form
    $service_name = $_POST['service_name'];
    $service_detail = $_POST['service_detail'];
    $service_status = isset($_POST['service_status']) ? 1 : 0; // Check if the checkbox is checked
    $main_service_Access = isset($_POST['department_id']) ? $_POST['department_id'] : null;
    $service_ea = $_POST['service_ea'];
    $created_by = $_POST['created_by'];
    $updated_by = "none";

    try {
        // Start a transaction
        $conn->beginTransaction();

        // Insert data into sa_services table
        $sql = "INSERT INTO sa_services (service_name, service_detail, service_status, service_Access, service_ea, created_by, updated_by) 
                VALUES (:service_name, :service_detail, :service_status, :service_Access, :service_ea, :created_by, :updated_by)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':service_name', $service_name);
        $stmt->bindParam(':service_detail', $service_detail);
        $stmt->bindParam(':service_status', $service_status);
        $stmt->bindParam(':service_Access', $main_service_Access); // Bind using the main_service_Access
        $stmt->bindParam(':service_ea', $service_ea);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->bindParam(':updated_by', $updated_by);
        $stmt->execute();

        // Get the ID of the last inserted row
        $service_id = $conn->lastInsertId();

        // Insert data into sa_subservices table
        if (isset($_POST['subservice_name'])) {
            $subservice_names = $_POST['subservice_name'];
            $sub_ea = $_POST['sub_ea'];
            $subservice_details = $_POST['subservice_detail'];
            $subservice_statuses = $_POST['subservice_status'];
            $subservice_Accesses = $_POST['subservice_Access']; // Use for subservices
            $created_ats = date('Y-m-d H:i:s');

            
                foreach ($subservice_names as $key => $subservice_name) {
                    echo "Subservice Access: " . (isset($subservice_Accesses[$key]) ? $subservice_Accesses[$key] : "Not set") . "<br>";
                    
                    $subservice_Access = isset($subservice_Accesses[$key]) ? $subservice_Accesses[$key] : null;
            
                $sql = "INSERT INTO sa_subservices (service_id, subservice_name, sub_ea, subservice_detail, subservice_status, `service_Access`, subservice_Access, created_at, created_by, updated_by) 
                VALUES (:service_id, :subservice_name, :sub_ea, :subservice_detail, :subservice_status, :service_Access, :subservice_Access, :created_at, :created_by, :updated_by)";
            
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':service_id', $service_id);
                $stmt->bindParam(':subservice_name', $subservice_name);
                $stmt->bindParam(':sub_ea', $sub_ea[$key]);
                $stmt->bindParam(':subservice_detail', $subservice_details[$key]);
                $stmt->bindParam(':subservice_status', $subservice_statuses[$key]);
                $stmt->bindParam(':service_Access', $main_service_Access); // Bind using the main_service_Access
                $stmt->bindParam(':subservice_Access', $subservice_Access);
                $stmt->bindParam(':created_at', $created_ats);
                $stmt->bindParam(':created_by', $created_by);
                $stmt->bindParam(':updated_by', $updated_by);
                $stmt->execute();
            }
        }

        // Commit the transaction
        $conn->commit();

        echo "Data inserted successfully";
        // Debugging statements
        echo "main_service_Access: " . $main_service_Access . "<br>";

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