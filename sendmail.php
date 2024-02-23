<?php
phpinfo();
?>
<?php
include './action/connect.php';
// Email configuration
$to = "recipient@example.com";
$subject = "Reset Your Password";
$message = "Please click the following link to reset your password: <a href='http://example.com/reset_password.php?token=abc123'>Reset Password</a>";
$headers = "From: sender@example.com\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";

// Send email using SMTP
$smtp_host = "localhost"; // SMTP Server ของ MailHog
$smtp_port = 1025; // พอร์ต SMTP ของ MailHog

// Send email
if (mail($to, $subject, $message, $headers, "-f sender@example.com")) {
    echo "Email sent successfully!";
} else {
    echo "Failed to send email!";
}
?>
