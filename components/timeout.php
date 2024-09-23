<?php

// ตรวจสอบว่ามีการล็อกอินอยู่หรือไม่ และตรวจสอบเวลา session timeout
if (isset($_SESSION['user']) && isset($_SESSION['login_time'])) {
    $login_time = $_SESSION['login_time'];
    $timeout = 3 * 60 * 60; // 3 ชั่วโมงในหน่วยวินาที
    if (time() - $login_time > $timeout) {
        // ถ้าเวลา session เกิน timeout ให้ทำการลบ session และเรียกใช้งานหน้า login.php เพื่อล็อกเอาต์
        session_unset();
        session_destroy();
        header("Location: https://saservice.mahidol.ac.th/index.php");
        exit;
    }
}
?>