<?php
// ดึงข้อมูล URL ปัจจุบัน
$current_page = basename($_SERVER['PHP_SELF']);
// กำหนดชื่อที่ต้องการแสดง
$custom_page_names = array(
  'dashboard.php' => 'Dashboard',
  'services.php' => 'จัดการบริการ',
  'assessment.php' => 'จัดการแบบประเมิน',
  'report.php' => 'เพิ่มจำนวนผู้ใช้บริการ',
  'display_report.php' => 'รายงานผล',
  'profile.php' => 'Profile',
  'user.php' => 'จัดการผู้ใช้ระบบ',
  'system.php' => 'System',
  'edit_service.php' => 'แก้ไขบริการ',
  'add_question.php' => 'สร้างข้อคำถาม',
  'add_report.php' => 'บันทึกจำนวนผู้เข้าใช้บริการ',
  'add_assessment.php' => 'สร้างแบบประเมินความพึงพอใจ',
  'department.php' => 'จัดการหน่วยงาน',
  'unit.php' => 'จัดการหน่วย',
  'edit_user.php' => 'แก้ไขผู้ใช้งานระบบ',
  'display_reportyear.php' => 'รายงานตามปีงบประมาณ',
  'change_password.php' => 'เปลี่ยน password',
  'reset_password_admin.php' => 'Reset password'
);

// ตรวจสอบว่า $current_page มีอยู่ใน $custom_page_names หรือไม่
if (array_key_exists($current_page, $custom_page_names)) {
  $display_page_name = $custom_page_names[$current_page];
} else {
  // หากไม่พบใน $custom_page_names ให้ใช้ $current_page เดิม
  $display_page_name = $current_page;
  $display_page_name_up = $current_page;
}
?>

<?php $department =  $user['department']; 

if($department == 0){
  
  $display_page_name .= ' Admin';
  
}else{
// ดึงข้อมูลจากตาราง sa_department
try {
  
$stmt = $conn->prepare("SELECT ID, department_name FROM sa_department WHERE ID = :department");
$stmt->bindParam(':department', $department);
$stmt->execute();
$departmentData = $stmt->fetch(PDO::FETCH_ASSOC);

if($departmentData){

  $display_page_name .= '  ' .$departmentData['department_name'];
} else {
  echo '<p>No Department found</p>';
}
} catch (PDOException $e) {
echo "Connection failed: " . $e->getMessage();
}
}

?>
 <!-- Navbar -->
 <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
      <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page"><?php echo $display_page_name; ?></li>
    </ol>
    <h6 class="font-weight-bolder text-white mb-0" id="display_name"><?php echo $display_page_name; ?></h6>
</nav>

        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <!-- <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" class="form-control" placeholder="Type here...">
            </div> -->
          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span id="logoutButton" class="d-sm-inline d-none"><?php echo $user['name_surname']; ?>  &nbsp;  <a href="../action/logout.php"><button class="badge badge-sm bg-gradient-primary" style="border-color: white;">ออกจากระบบ</button></a> </span>
              </a>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bell cursor-pointer"></i>
              </a>
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                       
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">ยังไม่มีการแจ้งเตือน</span> 
                        </h6>
                        <!-- <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          13 minutes ago
                        </p> -->
                      </div>
                    </div>
                  </a>
                </li>
                <li class="mb-2">
                  <!-- <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New album</span> by Travis Scott
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          1 day
                        </p>
                      </div>
                    </div>
                  </a> -->
                </li>
                <li>
                  <!-- <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                          <title>credit-card</title>
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                              <g transform="translate(1716.000000, 291.000000)">
                                <g transform="translate(453.000000, 454.000000)">
                                  <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                  <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                </g>
                              </g>
                            </g>
                          </g>
                        </svg>
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          Payment successfully completed
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          2 days
                        </p>
                      </div>
                    </div> -->
                  <!-- </a> -->
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <!-- <script>
    // เลือกปุ่ม LOGOUT ด้วย ID
    var logoutButton = document.getElementById('logoutButton');

    // เพิ่ม Event Listener สำหรับการคลิก
    logoutButton.addEventListener('click', function() {
        // ทำการ redirect หลังจากล็อคเอาท์
        window.location.href = '../action/logout.php'; // เปลี่ยนเส้นทางไปยังไฟล์ที่มีโค้ด logout ที่เราได้เขียนไว้ก่อนหน้านี้
    });
</script> -->