<?php
// เริ่ม Session
session_start();

// ลบทั้งหมดของ Session ที่มีสร้างขึ้น
session_unset();

// ทำลาย Session
session_destroy();

// ส่งกลับไปหน้า Login หรือหน้าอื่นๆ ตามที่คุณต้องการ
header("Location: http://10.41.147.3/index.php");
exit;
?>
