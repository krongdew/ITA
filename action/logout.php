<?php
// เริ่ม Session
session_start();

// ลบทั้งหมดของ Session ที่มีสร้างขึ้น
session_unset();

// ทำลาย Session
session_destroy();

// ส่งกลับไปหน้า Login หรือหน้าอื่นๆ ตามที่คุณต้องการ
header("Location: http://localhost:8080/index.php");
exit;
?>
