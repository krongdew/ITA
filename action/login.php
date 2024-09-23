<?php
header_remove("X-Powered-By");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header_remove("Server");
session_start();
include '../action/connect.php';
include '../action/csrf_token.php'; // เรียกใช้งานไฟล์ที่มีฟังก์ชัน CSRF token

// ตรวจสอบ CSRF token
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบว่ามีค่า CSRF token หรือไม่
    if (!isset($_POST['csrf_token'])) {
        // CSRF token ไม่ถูกส่งมา
        echo "CSRF token is missing!";
        exit;
    }

    $submitted_token = $_POST['csrf_token'];
    if (!checkCsrfToken($submitted_token)) {
        // CSRF token ไม่ถูกต้อง
        echo "CSRF token validation failed!";
        exit;
    }
// Key for encryption
$key = getenv('ENCRYPTION_KEY');

// Function to decrypt data
function decryptData($data, $key)
{
  $cipher = "aes-256-cbc";
  list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
  return openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);
}

// Function to write log
// function writeLog($message)
// {
//   $logFile = "./log/login_logs.txt";
//   $timestamp = date('Y-m-d H:i:s');
//   $ip_address = $_SERVER['REMOTE_ADDR'];
//   // แปลงเวลาปัจจุบันเป็นเวลาของประเทศไทย
//   $thai_timestamp = gmdate('Y-m-d H:i:s', strtotime('+7 hours')); // +7 หมายถึงอัตราที่กำหนดในการแปลงไทย
//   $logMessage = "$thai_timestamp - IP: $ip_address - $message\n";
//   file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
// }
// Function to write log into database
function writeLog($message)
{
    include '../action/connect.php'; // เรียกใช้งานไฟล์เชื่อมต่อฐานข้อมูล

    // แปลงเวลาปัจจุบันเป็นเวลาของประเทศไทย
    $thai_timestamp = gmdate('Y-m-d H:i:s', strtotime('+7 hours')); // +7 หมายถึงอัตราที่กำหนดในการแปลงไทย

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO login_logs (timestamp, ip_address, message) VALUES (:timestamp, :ip_address, :message)");

    // Bind parameters
    $stmt->bindParam(':timestamp', $thai_timestamp);
    $stmt->bindParam(':ip_address', $_SERVER['REMOTE_ADDR']);
    $stmt->bindParam(':message', $message);

    // Execute the statement
    $stmt->execute();
}


// Check if there is any previous login attempts for this IP
if (!isset($_SESSION['login_attempts']) || !is_array($_SESSION['login_attempts'])) {
  $_SESSION['login_attempts'] = array();
}

if (!isset($_SESSION['login_attempts'][$_SERVER['REMOTE_ADDR']])) {
  $_SESSION['login_attempts'][$_SERVER['REMOTE_ADDR']] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['Username']) && isset($_POST['Password'])) {
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    
    try {
      $stmt = $conn->prepare("SELECT * FROM sa_users WHERE Username = :username");
      $stmt->bindParam(':username', $username);
      $stmt->execute();

      $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      $_SESSION['error_message'] = "Connection failed: " . $e->getMessage();
      header("Location: ../index.php");
      exit;
    }

    if (!$user) {
      $_SESSION['login_attempts'][$_SERVER['REMOTE_ADDR']]++;
      $_SESSION['error_message'] = "Invalid username or password!";
      writeLog("Failed login attempt with username: $username from IP: {$_SERVER['REMOTE_ADDR']}");
    
      if ($_SESSION['login_attempts'][$_SERVER['REMOTE_ADDR']] >= 5) {
        $_SESSION['next_login_time'][$_SERVER['REMOTE_ADDR']] = time() + 300; // 5 minutes in seconds
        $_SESSION['error_message'] = "You have exceeded the maximum login attempts. Please try again after 5 minutes.";
        header("Location: ../index.php");
        exit;
      } else {
        header("Location: ../index.php");
        exit;
      }
    } else {
      if (password_verify($password, $user['Password'])) {
        
        $_SESSION['user'] = $user;
        $_SESSION['login_time'] = time();
        $_SESSION['user']['name_surname'] = decryptData($_SESSION['user']['name_surname'], $key);
        $_SESSION['user']['email'] = decryptData($_SESSION['user']['email'], $key);
        $_SESSION['user']['email_other'] = decryptData($_SESSION['user']['email_other'], $key);
        $_SESSION['user']['tell'] = decryptData($_SESSION['user']['tell'], $key);

        // Reset login attempts on successful login
        unset($_SESSION['login_attempts'][$_SERVER['REMOTE_ADDR']]);
        unset($_SESSION['next_login_time'][$_SERVER['REMOTE_ADDR']]);

        writeLog("Successful login by user with ID: {$user['ID']} from IP: {$_SERVER['REMOTE_ADDR']}");

        echo '<script>window.location.href = "../pages/dashboard.php";</script>';
        exit;
      } else {
        $_SESSION['login_attempts'][$_SERVER['REMOTE_ADDR']]++;
        $_SESSION['error_message'] = "Username or password is incorrect!";
        writeLog("Failed login attempt with username: $username from IP: {$_SERVER['REMOTE_ADDR']}");

        if ($_SESSION['login_attempts'][$_SERVER['REMOTE_ADDR']] >= 5) {
          $_SESSION['next_login_time'][$_SERVER['REMOTE_ADDR']] = time() + 300; // 5 minutes in seconds
          $_SESSION['error_message'] = "You have exceeded the maximum login attempts. Please try again after 5 minutes.";
          header("Location: ../index.php");
          exit;
        } else {
          header("Location: ../index.php");
          exit;
        }
      }
    }
  }
}
}
?>
