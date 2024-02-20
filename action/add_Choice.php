<?php
// Include your database connection or configuration file here
// For example, include 'db_connection.php';
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form
    $Assessment_ID = $_POST['Assessment_ID'];
    $choice_name = $_POST['choice_name'];
  

    try {
        // Include your database connection or configuration file here
        // For example, include 'db_connection.php';
        // $conn = new PDO("mysql:host=localhost;dbname=your_database_name", "your_username", "your_password");
        // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Start a transaction
        $conn->beginTransaction();

        // Insert data into sa_services table
        $sql = "INSERT INTO sa_choice_name (Assessment_ID, choice_name) 
                VALUES (:Assessment_ID, :choice_name)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':Assessment_ID', $Assessment_ID);
        $stmt->bindParam(':choice_name', $choice_name);
        $stmt->execute();

        // Get the ID of the last inserted row
        $choice_id = $conn->lastInsertId();

        // Insert data into sa_subservices table
        if (isset($_POST['choice_item'])) {
            $choice_items = $_POST['choice_item'];
          

            foreach ($choice_items as $key => $choice_item) {
                $sql = "INSERT INTO sa_choice_item (choice_id, choice_item) 
                        VALUES (:choice_id, :choice_item)";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':choice_id', $choice_id);
                $stmt->bindParam(':choice_item', $choice_item);
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
