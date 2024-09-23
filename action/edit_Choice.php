<?php
// Include your database connection or configuration file here
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form
    $Assessment_ID = $_POST['Assessment_ID'];
    $choice_name = $_POST['choice_name'];
    $choice_id = $_POST['choice_id']; // Assuming you get the ID of the choice name record

    try {
        // Start a transaction
        $conn->beginTransaction();

        // Update data in sa_choice_name table
        $sql = "UPDATE sa_choice_name 
                SET choice_name = :choice_name 
                WHERE ID = :choice_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':choice_id', $choice_id);
        $stmt->bindParam(':choice_name', $choice_name);
        $stmt->execute();

        // Update or insert data in sa_choice_item table
        if (isset($_POST['choice_item'])) {
            $choice_items = $_POST['choice_item'];
            $item_ids = $_POST['subservice_ID']; // Assuming you get the item_ids from the form as well

            foreach ($choice_items as $key => $choice_item) {
                $item_id = $item_ids[$key]; // Get corresponding item_id

                if (!empty($item_id)) {
                    // Update existing choice item
                    $sql = "UPDATE sa_choice_item 
                            SET choice_item = :choice_item 
                            WHERE ID = :item_id";

                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':choice_item', $choice_item);
                    $stmt->bindParam(':item_id', $item_id);
                } else {
                    // Insert new choice item
                    $sql = "INSERT INTO sa_choice_item (choice_id, choice_item) 
                            VALUES (:choice_id, :choice_item)";

                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':choice_id', $choice_id);
                    $stmt->bindParam(':choice_item', $choice_item);
                }

                $stmt->execute();
            }
        }

        // Commit the transaction
        $conn->commit();

        
        // Redirect to the edit page with the choice ID
         // Redirect with alert message
         echo "<script>
         alert('Data updated successfully');
         window.location.href = '../pages/edit_choice.php?ID=$choice_id';
       </script>";
       
        
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
