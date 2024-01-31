<?php
session_start();
include '../action/connect.php';

if (!isset($_SESSION['user'])) {
  // ถ้าไม่มี session user แสดงว่ายังไม่ได้ Login
  header("Location: http://localhost:8080/index.php");
}

// ดึงข้อมูลผู้ใช้จาก session
$user = $_SESSION['user'];

// ดึงข้อมูลผู้ใช้จาก session


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">

  <title>
    ระบบ ITA
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@500&family=Kanit&family=Mitr:wght@300&display=swap" rel="stylesheet">
  <!-- เพิ่ม link ไปยัง SweetAlert2 CSS ตรงนี้ -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <!-- เพิ่ม link ไปยัง SweetAlert2 JavaScript ตรงนี้ -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <!-- datatables -->
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

  <link rel="stylesheet" href="../assets/DataTables/datatables.css" />
  <link rel="stylesheet" href="../assets/DataTables/Responsive-2.5.0/css/responsive.dataTables.css" />
  <link rel="stylesheet" href="../assets/DataTables/Buttons-2.4.2/css/buttons.dataTables.css" />

  <script src="../assets/DataTables/datatables.js"></script>
  <script src="../assets/DataTables/Responsive-2.5.0/js/dataTables.responsive.js"></script>

  <script src="../assets/DataTables/Buttons-2.4.2/js/dataTables.buttons.min.js"></script>
  <script src="../assets/DataTables/Buttons-2.4.2/js/dataTables.buttons.js"></script>
  <script src="../assets/DataTables/Buttons-2.4.2/js/buttons.html5.min.js"></script>

  <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <!-- <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
  <!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script> -->
  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.css"> -->
  <!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.js"></script> -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;700&display=swap">
  <script src="../pages/vfs_fonts.js"></script>
</head>
<style>
  body {
    font-family: 'Mitr', sans-serif;
  }

  .editBtn {
    background-color: #fca400;
    color: white;
    border-radius: 10px;
    border: 0px;
    padding: 4px;
  }

  .delBtn {
    background-color: #ff3a24;
    color: white;
    border-radius: 10px;
    border: 0px;
    padding: 4px;
  }

  .saveBtn {
    background-color: #009103;
    color: white;
    border-radius: 10px;
    border: 0px;
    padding: 4px;
  }

  .buttons-html5 {
    font-size: 12px;
    /* ปรับขนาดตามที่คุณต้องการ */
    padding: 6px 10px;
    /* ปรับขนาดตามที่คุณต้องการ */
  }

  label {
    margin-right: 20px;
  }

  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked+.slider {
    background-color: #2196F3;
  }

  input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }
</style>

<body class="g-sidenav-show   bg-gray-100">
  <?php  // เรียกใช้ Sidebar ตาม UserType
  if ($user['UserType'] === "admin") {

    include '../components/sidebar_admin.php';
  } else {
    include '../components/sidebar.php';
  }
  ?>
  <?php include '../components/navbar.php' ?>
  <? include '../action/connect.php';

  // ใช้ PDO เพื่อดึงข้อมูลจากฐานข้อมูล
  // $sql = "SELECT * FROM sa_department";
  // $stmt = $conn->prepare($sql);
  // $stmt->execute();
  ?>

  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">

        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>รายงานสถิติจำนวนผู้เข้าใช้บริการ</h6>
            <br>
            <!-- <button class="badge badge-sm bg-gradient-success" style="border: 0px;" onMouseOver="this.style.color='red'" onMouseOut="this.style.color='white'" id="button-service" onclick="toggleAddForm()">เพิ่ม Services</button> -->
            <!-- <button class="badge badge-sm bg-gradient-warning" style="border: 0px;" onMouseOver="this.style.color='red'" onMouseOut="this.style.color='white'" id="button-service" onclick="toggleAddForm()">สร้างแบบประเมินความพึงพอใจ</button> -->
          </div>

          <div class="card-body px-0 pt-0 pb-2">
            <div id="add-form" style="display: none;">
              <form method="post" action="../action/add_service.php">
                <div class="container-fluid py-4">
                  <div class="row">
                    <div class="col-md-8">
                      <div class="card">
                        <div class="card-header pb-0">
                          <div class="d-flex align-items-center">
                            <p class="mb-0">เพิ่มบริการ (Services) ของกองกิจการนักศึกษา</p>

                          </div>
                        </div>

                      </div>
                    </div>

                  </div>

              </form>
            </div>
          </div>
        </div>

        <div style="padding: 20px;">
          <table id="myTable" class="table align-items-center mb-0">
            <thead>
              <tr>

                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ชื่อบริการ</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">หน่วยนับ</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ม.ค.</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ก.พ.</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">มี.ค.</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">เม.ย.</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">พ.ค.</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">มิ.ย.</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ก.ค.</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ส.ค.</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ก.ย.</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ต.ต.</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">พ.ย.</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ธ.ค.</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>

      </div>
    </div>

    <?php include '../components/footer.php' ?>
  </div>
  </main>

  <?php include '../components/setting.php'; ?>
  <!--   Core JS Files   -->
  <?php include '../components/script.php'; ?>




  <!-- ส่วนที่เพิ่มเข้าไป -->
  <script>
    function updatedata() {
      $('#myTable').DataTable().ajax.reload();
    }


    $(document).ready(function() {
      // ให้ฟังก์ชันทำงานเมื่อมีการกด submit ฟอร์ม
      $('form').submit(function(e) {
        e.preventDefault(); // ป้องกันให้ฟอร์ม submit ตามปกติ

        // ทำการส่งข้อมูลไปยังไฟล์ PHP ตาม URL ที่ระบุใน action
        $.ajax({
          type: 'POST',
          url: '../action/add_services.php',
          data: $(this).serialize(), // เพิ่ม CSRF Token ในข้อมูลที่ส่ง
          success: function(response) {
            // เมื่อเพิ่มข้อมูลเสร็จสิ้น, แสดง popup box
            Swal.fire({
              icon: 'success',
              title: 'บันทึกข้อมูลสำเร็จ',
              showConfirmButton: false,
              timer: 1500,

            }).then(function() {

              // ล้างข้อมูลในฟอร์ม (ตรวจสอบว่าเขียนไว้ถูกหรือไม่)
              $('form')[0].reset();

              // เรียกใช้ฟังก์ชัน updatedata() เพื่อรีเฟรชตาราง
              updatedata();
            });
          },
          error: function(error) {
            // กรณีเกิดข้อผิดพลาด
            Swal.fire({
              icon: 'error',
              title: 'เกิดข้อผิดพลาด',
              text: 'ไม่สามารถบันทึกข้อมูลได้'
            });
          }
        });
      });
    });
  </script>

  <script>
    pdfMake.fonts = {
      thaiFont: {
        normal: 'THSarabun.ttf',
        bold: 'THSarabun-Bold.ttf',
        italics: 'THSarabun-Italic.ttf',
        bolditalics: 'THSarabun-BoldItalic.ttf'
      }
    };



    $(document).ready(function() {
    var table;
    var globalDepartmentData;

    $.ajax({
        url: "../action/get_service_data.php",
        type: "GET",
        dataType: "json",
        success: function(response) {
            globalDepartmentData = response;
            var table = $('#myTable').DataTable({
                responsive: true,
                dom: 'lBfrtip',
                columns: [
                    { data: "service_id", visible: false,
                      render: function(data) {
                                        // ให้หาข้อมูล department_name จาก globalDepartmentData แล้วแสดง
                                        var serviceData = globalDepartmentData.find(function(dep) {
                                            return dep.ID === data;
                                           
                                        });
                                        return serviceData ? serviceData.service_name : '';
                                    }, 
                      
                    },
                    { data: "subservice_id" },
                    { data: 'Jan' },
                    { data: 'Feb' },
                    { data: 'Mar' },
                    { data: 'Apr' },
                    { data: 'May' },
                    { data: 'Jun' },
                    { data: 'Jul' },
                    { data: 'Aug' },
                    { data: 'Sep' },
                    { data: 'Oct' },
                    { data: 'Nov' },
                    { data: 'Dec' }
                ],
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
                        },
                        customize: function(doc) {
                            doc.defaultStyle.font = 'thaiFont';
                            doc.defaultStyle.fontSize = 16;
                        }
                    }
                ],
                autoWidth: false,
                lengthMenu: [10, 25, 50, 75, 100],
                pageLength: 10,
                serverSide: true,
                ajax: {
                    url: "../action/get_report_server.php",
                    type: "POST",
                    dataType: "json",
                },
                drawCallback: function(settings) {
                    var api = this.api();
                    var rows = api.rows({ page: 'current' }).nodes();
                    var lastServiceId = null;

                    api.column(0, { page: 'current' }).data().each(function(serviceId, i) {
                        if (lastServiceId !== serviceId) {
                            $(rows).eq(i).before(
                                '<tr class="group"><td colspan="14">service_id=' + serviceId + '</td></tr>'
                            );
                            lastServiceId = serviceId;
                        }
                    });
                }
            });
        },
    });



      // Event listener สำหรับปุ่ม Delete
      $('#myTable').on('click', '.delBtn', function() {
        var data = $('#myTable').DataTable().row($(this).parents('tr')).data();
        var servicesID = data.ID;

        // แสดง SweetAlert 2 สำหรับยืนยันการลบ
        Swal.fire({
          title: 'คุณต้องการลบข้อมูลหรือไม่?',
          text: "หากคุณลบที่นี่ จะลบทั้งบริการหลักและบริการย่อยทั้งหมด",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'ใช่, ลบ!'
        }).then((result) => {
          if (result.isConfirmed) {
            // ทำการลบในฐานข้อมูลด้วย Ajax
            $.ajax({
              url: '../action/delete_services.php',
              type: 'POST',
              data: {
                servicesID: servicesID
              },
              dataType: 'json', // รับข้อมูลเป็น JSON
              success: function(response) {
                if (response.status === 'success') {

                  Swal.fire(
                    'ลบข้อมูลเรียบร้อย!',
                    'ข้อมูลถูกลบออกจากระบบแล้ว.',
                    'success'
                  ).then((result) => {
                    if (result.isConfirmed) {
                      // ทำการ reload ข้อมูล
                      $('#myTable').DataTable().ajax.reload();
                    }
                  });
                } else {
                  Swal.fire(
                    'เกิดข้อผิดพลาด!',
                    'เกิดข้อผิดพลาดในการลบข้อมูล.',
                    'error'
                  );
                }
              }
            });
          }
        });
      });
    });
  </script>


</body>

</html>