<?php
include '../action/connect.php';



$key = getenv('ENCRYPTION_KEY');

// Function to encrypt data
function encryptData($data, $key)
{
    $cipher = "aes-256-cbc";
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $encrypted = openssl_encrypt($data, $cipher, $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

// Check if 'approve' button is clicked
if (isset($_POST['approve'])) {
    // Get AssessmentID from POST
    $AssessmentID = $_POST['AssessmentID'];
    $ApproverUserID = $_POST['ApproverUserID'];
    
    // Generate URL for assessment form and encrypt only in the URL part
    $encryptedAssessmentID = encryptData($AssessmentID, $key);
    $assessmentURL = "http://localhost:8080/pages/assessment_form.php?Assessment=" . urlencode($encryptedAssessmentID);

    // Update ApprovalStatus in sa_assessment table to 'Approved'
    $updateSql = "UPDATE sa_assessment SET ApprovalStatus = 'Approved', AssessmentStatus = 'online', ApproverUserID = ?, AssessmentURL = ? WHERE AssessmentID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bindParam(1, $ApproverUserID, PDO::PARAM_INT);
    $updateStmt->bindParam(2, $assessmentURL, PDO::PARAM_STR);
    $updateStmt->bindParam(3, $AssessmentID, PDO::PARAM_INT);
   
    $updateStmt->execute();

    // Redirect to Evaluation.php or any other page after processing
    header("Location: ../pages/assessment.php");
    exit();
} 

if (isset($_POST['reject'])) {
     // Get AssessmentID from POST
    $AssessmentID = $_POST['AssessmentID'];
    $ApproverUserID = $_POST['ApproverUserID'];
    
      // Update ApprovalStatus in sa_assessment table to 'Approved'
    $updateSql = "UPDATE sa_assessment SET ApprovalStatus = 'Reject', AssessmentStatus = 'รอแก้ไขข้อคำถาม', ApproverUserID = ? WHERE AssessmentID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bindParam(1, $ApproverUserID, PDO::PARAM_INT);
    $updateStmt->bindParam(2, $AssessmentID, PDO::PARAM_INT);
    $updateStmt->execute();

    // Redirect to Evaluation.php or any other page after processing
    header("Location: ../pages/assessment.php");
    exit();
} else {
    // If 'approve' button is not clicked, redirect back to Evaluation.php or any other page
    header("Location: ../pages/assessment.php");
    exit();
}


?>
