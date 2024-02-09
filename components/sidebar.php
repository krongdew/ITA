<?php
// ดึงข้อมูล URL ปัจจุบัน
$current_page = basename($_SERVER['PHP_SELF']);
?>
<style>


.sub-menu {
  display: none;
    position: relative;
    top: 100%;
    left: 0;
    z-index: 1;
    list-style-type: none;
    animation: fadeIn 0.3s ease forwards; /* เพิ่ม animation */
}
.nav-link{
    cursor: pointer;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px); /* เริ่มต้นจากการเลื่อนขึ้นไปเล็กน้อย */
    }
    to {
        opacity: 1;
        transform: translateY(0); /* สิ้นสุดที่ตำแหน่งปกติ */
    }
}



</style>

<div class="min-height-300 bg-primary position-absolute w-100"></div>
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="">
      <img src="../assets/img/Mahidol_U.png" class="navbar-brand-img h-100" alt="main_logo">
      <span class="ms-1 font-weight-bold">SAITA Management</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>" href="../pages/dashboard.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo ($current_page == 'services.php') ? 'active' : ''; ?>" href="../pages/services.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <!-- <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i> -->
            <i class="fa-solid fa-hand-holding-heart text-warning text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">จัดการบริการ</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo ($current_page == 'assessment.php') ? 'active' : ''; ?>" href="../pages/assessment.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-check-to-slot text-success text-sm opacity-10"></i>

          </div>
          <span class="nav-link-text ms-1">จัดการแบบประเมิน</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo ($current_page == 'report.php') ? 'active' : ''; ?>" href="../pages/report.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-user-plus text-info text-sm opacity-10"></i>

          </div>
          <span class="nav-link-text ms-1">เพิ่มจำนวนผู้เข้าใช้บริการ</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" onclick="toggleSubMenu()">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-scroll text-primary text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">รายงานผล</span>
    </a>
    <ul id="subMenu" class="sub-menu">
        <li class="nav-item">
        <a class="nav-link <?php echo ($current_page == 'display_report.php') ? 'active' : ''; ?>" href="../pages/display_report.php?active_menu=display_report">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-calendar-days text-info opacity-10" style="font-size: smaller;"></i>
                   
                </div>
                <span class="nav-link-text ms-1" style="font-size: smaller;">รายงานตามปีปฏิทิน</span>
            </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php echo ($current_page == 'display_reportyear.php') ? 'active' : ''; ?>" href="../pages/display_reportyear.php?active_menu=display_report">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa-regular fa-calendar text-warning opacity-10" style="font-size: smaller;"></i>
                    
                </div>
                <span class="nav-link-text ms-1" style="font-size: smaller;">รายงานตามปีงบประมาณ</span>
            </a>
        </li>
          <!-- เพิ่มเมนูย่อยเพิ่มเติมตามต้องการ -->
        </ul>
        </li>
      <!-- <li class="nav-item">
          <a class="nav-link " href="./pages/rtl.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-world-2 text-danger text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">RTL</span>
          </a>
        </li> -->
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo ($current_page == 'profile.php') ? 'active' : ''; ?>" href="../pages/profile.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Profile</span>
        </a>
      </li>
      <!-- <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'user.php') ? 'active' : ''; ?>" href="../pages/user.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-copy-04 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Users management</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'system.php') ? 'active' : ''; ?>" href="../pages/system.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-copy-04 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">System management</span>
          </a>
        </li> -->

      <!-- <li class="nav-item">
          <a class="nav-link " href="./pages/sign-up.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-collection text-info text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Sign Up</span>
          </a>
        </li> -->
    </ul>
  </div>
  <!-- <div class="sidenav-footer mx-3 ">
      <div class="card card-plain shadow-none" id="sidenavCard">
        <img class="w-50 mx-auto" src="./assets/img/illustrations/icon-documentation.svg" alt="sidebar_illustration">
        <div class="card-body text-center p-3 w-100 pt-0">
          <div class="docs-info">
            <h6 class="mb-0">Need help?</h6>
            <p class="text-xs font-weight-bold mb-0">Please check our docs</p>
          </div>
        </div>
      </div>
      <a href="https://www.creative-tim.com/learning-lab/bootstrap/license/argon-dashboard" target="_blank" class="btn btn-dark btn-sm w-100 mb-3">Documentation</a>
      <a class="btn btn-primary btn-sm mb-0 w-100" href="https://www.creative-tim.com/product/argon-dashboard-pro?ref=sidebarfree" type="button">Upgrade to pro</a>
    </div> -->
</aside>
<main class="main-content position-relative border-radius-lg ">
<script>
  function toggleSubMenu() {
    var subMenu = document.getElementById('subMenu');
    if (subMenu.style.display === 'none' || subMenu.style.display === '') {
        subMenu.style.display = 'block';
    } else {
        subMenu.style.display = 'none';
    }
}
</script>