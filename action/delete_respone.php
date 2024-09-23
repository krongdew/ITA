<?php
// Enable detailed error reporting
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include 'connect.php';

if (isset($_POST['AssessmentID'])) {
    try {
        $conn->beginTransaction();

        $AssessmentID = $_POST['AssessmentID'];
        $deleteDate = isset($_POST['deleteDate']) ? $_POST['deleteDate'] : null;

        if ($deleteDate) {
            echo "Deleting records for AssessmentID: $AssessmentID and Date: $deleteDate<br>";

            // Delete records from sa_response2 based on date and AssessmentID
            $deleteStmt0 = $conn->prepare("
                DELETE sa_response2
                FROM sa_response2
                INNER JOIN sa_respondent ON sa_response2.RespondentID = sa_respondent.RespondentID
                WHERE sa_respondent.AssessmentID = :AssessmentID
                AND JSON_UNQUOTE(JSON_EXTRACT(sa_response2.Responses, '$[1].Answer')) = :deleteDate
            ");
            $deleteStmt0->bindParam(':AssessmentID', $AssessmentID, PDO::PARAM_INT);
            $deleteStmt0->bindParam(':deleteDate', $deleteDate, PDO::PARAM_STR);
            if (!$deleteStmt0->execute()) {
                throw new Exception("Error deleting records in sa_response2: " . implode(" ", $deleteStmt0->errorInfo()));
            }

            // Fetch RespondentIDs that match the selected date
            $fetchStmt = $conn->prepare("
                SELECT sa_respondent.RespondentID
                FROM sa_respondent
                WHERE sa_respondent.AssessmentID = :AssessmentID
                AND DATE(sa_respondent.SubmissionDate) = :deleteDate
            ");
            $fetchStmt->bindParam(':AssessmentID', $AssessmentID, PDO::PARAM_INT);
            $fetchStmt->bindParam(':deleteDate', $deleteDate, PDO::PARAM_STR);
            $fetchStmt->execute();
            $respondentIDs = $fetchStmt->fetchAll(PDO::FETCH_COLUMN, 0);

            if (count($respondentIDs) > 0) {
                // Delete records from sa_respondent based on AssessmentID and deleteDate
                $deleteStmt1 = $conn->prepare("
                    DELETE FROM sa_respondent
                    WHERE AssessmentID = :AssessmentID
                    AND DATE(SubmissionDate) = :deleteDate
                ");
                $deleteStmt1->bindParam(':AssessmentID', $AssessmentID, PDO::PARAM_INT);
                $deleteStmt1->bindParam(':deleteDate', $deleteDate, PDO::PARAM_STR);
                if (!$deleteStmt1->execute()) {
                    throw new Exception("Error deleting records in sa_respondent: " . implode(" ", $deleteStmt1->errorInfo()));
                }
            } else {
                echo "No matching RespondentID found for the specified date.<br>";
            }
        } else {
            echo "Deleting all records for AssessmentID: $AssessmentID<br>";

            // Delete all related records in sa_response2
            $deleteStmt0 = $conn->prepare("
                DELETE sa_response2
                FROM sa_response2
                INNER JOIN sa_respondent ON sa_response2.RespondentID = sa_respondent.RespondentID
                WHERE sa_respondent.AssessmentID = :AssessmentID
            ");
            $deleteStmt0->bindParam(':AssessmentID', $AssessmentID, PDO::PARAM_INT);
            if (!$deleteStmt0->execute()) {
                throw new Exception("Error deleting all records in sa_response2: " . implode(" ", $deleteStmt0->errorInfo()));
            }

            // Delete all related records in sa_respondent
            $deleteStmt1 = $conn->prepare("DELETE FROM sa_respondent WHERE AssessmentID = :AssessmentID");
            $deleteStmt1->bindParam(':AssessmentID', $AssessmentID, PDO::PARAM_INT);
            if (!$deleteStmt1->execute()) {
                throw new Exception("Error deleting all records in sa_respondent: " . implode(" ", $deleteStmt1->errorInfo()));
            }
        }

        $conn->commit();

        echo "<script>alert('ลบข้อมูลผลการประเมินแล้ว')</script>";
        echo '<script>window.location.href = "../pages/assessment.php";</script>';
    } catch (Exception $e) {
        $conn->rollBack();
        echo "<script>alert('Error: " . $e->getMessage() . "')</script>";
    }
} else {
    echo "<script>alert('Error: AssessmentID is not set')</script>";
}
?>
