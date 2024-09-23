<?php
session_start();
include '../action/connect.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['UserType'] !== "admin") {
    // ถ้าไม่มี session user แสดงว่ายังไม่ได้ Login
    header("Location:/index.php");
    
}

// ดึงข้อมูลผู้ใช้จาก session
$user = $_SESSION['user'];

// ดึงข้อมูลผู้ใช้จาก session


?>
<!DOCTYPE html>
<html lang="th">

<head>
<meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/Mahidol_U.png">
  <link rel="icon" type="image/png" href="../assets/img/Mahidol_U.png">

  <title>
    ระบบ ITA
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <!-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> -->
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
  <?php include '../action/connect.php';

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
            <h6>เพิ่ม / ลบ /แก้ไข fixed Choice</h6>
            <br>
            <button class="badge badge-sm bg-gradient-success" style="border: 0px;" onMouseOver="this.style.color='red'" onMouseOut="this.style.color='white'" id="button-service" onclick="toggleAddForm()">เพิ่ม fixed Choice</button>
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
                            <p class="mb-0">เพิ่ม fixed Choice สำหรับแบบประเมิน</p>

                          </div>
                        </div>
                        <div class="card-body">
                          <p class="text-uppercase text-sm"><b>ข้อมูลของ Choice</b></p>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="example-text-input" class="form-control-label">ชื่อเรียกของ Choice : </label>
                                <input class="form-control" type="hidden" name="Assessment_ID" value="0" required>
                                <input class="form-control" type="text" name="choice_name" placeholder="ชื่อเรียกของ Choice" required>
                              </div>
                              

                            </div>


                            

                            <div class="col-md-12">
                              <div class="form-group">
                                <span for="example-text-input" class="form-control-label">รายละเอียดของ Choice :</span><br>
                                <!-- สร้าง input สำหรับรับค่าบริการย่อย -->
                                <div class="form-group">
                                  <table id="subservices">
                                    <thead>
                                      <tr>
                                        <th style="font-size: smaller; padding:10px">Choice</th>
                                        
                                      </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                  </table>
                                  <br>
                                  <button type="button" id="addrow" class="saveBtn" style="font-size: small;" onclick="addRow()">+เพิ่ม Choice </button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <br>
                          <button type="submit" class="btn btn-primary btn-sm ms-auto">เพิ่ม Fixed Choice</button>
                          <button type="reset" class="btn btn-primary btn-sm ms-auto" onclick="toggleAddForm()">Cancel</button>
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
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Choice ID</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ชื่อเรียกของ Choice</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Choice</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">วันที่เพิ่ม</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                
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
  <script>
    function toggleAddForm() {
      var addFormDiv = document.getElementById('add-form');

      // Check if the form is already visible
      if (addFormDiv.style.display === 'none' || addFormDiv.style.display === '') {
        // Show the form
        addFormDiv.style.display = 'block';
      } else {
        // Hide the form
        addFormDiv.style.display = 'none';
      }

      // Return false to prevent the default behavior of the button
      return false;
    }
  </script>
  <script>
  
    // ฟังก์ชันเพิ่มแถวในตาราง
    function addRow() {
      // ดึงตารางมา
      var table = document.getElementById("subservices");

      // สร้างแถวใหม่
      var newRow = table.insertRow(table.rows.length);

      // สร้างเซลล์ในแถว
      var cell1 = newRow.insertCell(0);
      var cell2 = newRow.insertCell(1);
    

      // เพิ่ม HTML ลงในเซลล์
      cell1.innerHTML = '<input class="form-control" type="text" name="choice_item[]" placeholder="Choice" required>';
      // สร้างปุ่มลบใน cell5
      cell2.innerHTML = '<button type="button" class="delBtn" onclick="deleteRow(this)" style="font-size: small;" >ลบแถว</button>';

    }

    // ฟังก์ชันลบแถว
    function deleteRow(row) {
      var index = row.parentNode.parentNode.rowIndex;
      document.getElementById("subservices").deleteRow(index);
    }
  </script>


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
          url: '../action/add_Choice.php',
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
   
      var userdepartment = <?php echo $user['department']; ?>
      
     
          var table = $('#myTable').DataTable({
            responsive: true,
            dom: 'lBfrtip',
            columns: [{
                data: "column1",
                title: "Column 1"
              },
              {
                data: "column2",
                title: "Column 2"
              },
              {
                data: "column3",
                title: "Column 3"
              },
              {
                data: "column4",
                title: "Column 4"
              },
              {
                data: "column5",
                title: "Column 5"
              },
              {
                data: "column5",
                title: "Column 5"
              },
              {
                data: "column5",
                title: "Column 5"
              },
              // เพิ่มคอลัมน์ตามต้องการ
            ],
            buttons: [
              'copyHtml5',
              'excelHtml5',
              {
                extend: 'pdfHtml5',
                exportOptions: {
                  columns: [0, 1, 2, 3,4,5] // ระบุคอลัมน์ที่จะ export (index 0, 1, 2)
                },
                customize: function(doc) {
                  doc.defaultStyle.font = 'thaiFont'; // หรือใช้ชื่อ font ที่คุณต้องการ
                  doc.defaultStyle.fontSize = 16; // ตั้งค่าขนาดตัวอักษรที่นี่ (เป็นตัวเลข)

                  // ... รายละเอียดอื่น ๆ

                }
              }
            ],
            "autoWidth": false,
            "lengthMenu": [10, 25, 50, 75, 100],
            "pageLength": 10,
            "serverSide": true,
            "ajax": {
              "url": "../action/get_choice_server.php",
              "type": "POST",
              "dataType": "json",
              data:{
                userdepartment: userdepartment
              }
            },
            "columns": [{
                "data": null,
                "render": function(data, type, row, meta) {
                  return meta.settings._iDisplayStart + meta.row + 1;
                }
              },
              {
                "data": "ID",
              },
             
             
             
              {
                "data": "Assessment_ID",
              },
              {
                "data": "choice_name",
              },

              {
                "data": null,
                "render": function(data, type, row) {
                  return '<a href="../pages/edit_choice.php?ID=' + data.ID + '"><button class="btn btn-link text-dark px-3 mb-0"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</button></a>  <button class="delBtn"><i class="far fa-trash-alt me-2" aria-hidden="true"></i>Delete</button>';
                },
                "orderable": false
              }
              ,

              
            ],
            order: [
              [0, 'asc'],
            ],
          });
        }, 
    );

      
      // Event listener สำหรับปุ่ม Delete
      $('#myTable').on('click', '.delBtn', function() {
        var data = $('#myTable').DataTable().row($(this).parents('tr')).data();
        var choiceID = data.ID;

        // แสดง SweetAlert 2 สำหรับยืนยันการลบ
        Swal.fire({
          title: 'คุณต้องการลบ Choice หรือไม่?',
          text: "ลบ Choice นี้และตัวเลือกทั้งหมด",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'ใช่, ลบ!'
        }).then((result) => {
          if (result.isConfirmed) {
            // ทำการลบในฐานข้อมูลด้วย Ajax
            $.ajax({
              url: '../action/delete_choice.php',
              type: 'POST',
              data: {
                choiceID: choiceID
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

  </script>


</body>

</html>