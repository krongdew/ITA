<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $unitId = $_POST['unit_id'];
  $unitName = $_POST['unit_name'];
  $departmentId = $_POST['department_id'];

  // ทำการอัปเดตข้อมูลในตาราง sa_unit
  $stmt = $conn->prepare("UPDATE sa_unit SET unit_name = ?, department_id = ? WHERE ID = ?");
  $stmt->execute([$unitName, $departmentId, $unitId]);

  if ($stmt->rowCount() > 0) {
    // บันทึกสำเร็จ
    // echo json_encode(['success' => true, 'data' => $_POST]);
    echo json_encode(['status' => 'success']);
  } else {
    // บันทึกไม่สำเร็จ
    echo json_encode(['status' => 'error']);
  }
}
?>
