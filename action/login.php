<?php
session_start();
include '../action/connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบว่ามีการส่งข้อมูลมาจากฟอร์มหรือไม่
    if (isset($_POST['Username']) && isset($_POST['Password'])) {
        // ดึงข้อมูลจากฟอร์ม
        $username = $_POST['Username'];
        $password = $_POST['Password'];
        
        
        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
try {
  // เตรียมคำสั่ง SQL
  $stmt = $conn->prepare("SELECT * FROM sa_users WHERE Username = :username");
  $stmt->bindParam(':username', $username);
  $stmt->execute();

  // ดึงข้อมูลผู้ใช้
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

// ตรวจสอบว่ามีผู้ใช้หรือไม่
if (!$user) {
  // ไม่พบผู้ใช้
  echo "Invalid username or password!";
} else {
  // ตรวจสอบรหัสผ่าน
  $password = $_POST['Password'];  // ตัวแปร $Password ต้องถูกใช้ตรงกับชื่อ input ในฟอร์ม
  if (password_verify($password, $user['Password'])) {
      // รหัสผ่านถูกต้อง
      // ทำสิ่งที่คุณต้องการหลังจากการล็อกอินสำเร็จ

      // เช่น ทำการเริ่ม Session
      

      // กำหนดค่า Session หรือทำสิ่งอื่น ๆ ตามที่ต้องการ
      $_SESSION['user'] = $user;
    //   $_SESSION['name_surname'] = $name_surname;
    //   $_SESSION['ID'] = $userid;
    //   $_SESSION['UserType'] = $usertype;

      // หลังจากที่ตรวจสอบรหัสผ่านแล้ว
      // ทำการ redirect หรือส่งข้อมูลตามที่คุณต้องการ
      // header("Location: http://localhost:8080/pages/dashboard.php");
      echo '<script>window.location.href = "../pages/dashboard.php";</script>';
      exit;
  } else {
      // รหัสผ่านไม่ถูกต้อง
      echo '<script>alert("Username หรือ password ไม่ถูกต้อง!")</script>';
      echo '<script>window.location.href = "../index.php";</script>';
  }
}
    }
  }
?>