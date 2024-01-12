<?php
$servername = "db";
$username = "admin_dew";
$password = "Dew@0875350828#";
$dbname = "SA_ITA";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // เซ็ตการแสดงผลข้อผิดพลาดในรูปแบบ Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // เซ็ต CharSet เป็น utf8mb4
    $conn->exec("SET CHARACTER SET utf8mb4");
    // echo "Connected successfully"; 
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

