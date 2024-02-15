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

                        <!-- <button class="badge badge-sm bg-gradient-success" style="border: 0px;" onMouseOver="this.style.color='red'" onMouseOut="this.style.color='white'" id="button-service" onclick="toggleAddForm()">เพิ่ม Services</button> -->
                        <!-- <button class="badge badge-sm bg-gradient-warning" style="border: 0px;" onMouseOver="this.style.color='red'" onMouseOut="this.style.color='white'" id="button-service" onclick="toggleAddForm()">สร้างแบบประเมินความพึงพอใจ</button> -->
                    </div>


                    <div style="padding: 20px;">

                        <div>
                            <label for="filter_date">Filter by Date:</label>
                            <input type="date" id="filter_date">
                            <button onclick="filterData()">Filter</button>
                        </div>
                        <div>
                            <label for="filter_month_year">Filter by Month:</label>
                            <input type="month" id="filter_month_year">
                            <button onclick="filterMonthly()">Filter</button>
                        </div>
                        <div>
                            <label for="filter_start_date">Filter by Week:</label>
                            <input type="date" id="filter_start_date">
                            <label for="filter_end_date">to</label>
                            <input type="date" id="filter_end_date">
                            <button onclick="filterWeekly()">Filter</button>
                        </div>
                        <div>
                            <label for="service_id">Service ID:</label>
                            <input type="text" id="service_id">
                            <button onclick="filterDetailed()">Filter</button>

                        </div>


                        <table id="report_table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Service ID</th>
                                    <th>Subservice ID</th>
                                    <th>Number of People</th>
                                    <th>Date</th>
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
            $(document).ready(function() {
                $('#report_table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "../action/fetch_numberp_data.php"
                },
                
                );
            });

            function filterData() {
                var filterDate = $('#filter_date').val();
                $('#report_table').DataTable().destroy();
                $('#report_table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "../action/fetch_numberp_data.php",
                        type: "POST",
                        data: {
                            filter_date: filterDate,
                            draw: 1 // เพิ่ม draw ให้ส่งค่าเสมอ
                        }
                    }
                });
            }

            function filterMonthly() {
                var filterMonthYear = $('#filter_month_year').val();
                $('#report_table').DataTable().destroy();
                $('#report_table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "../action/fetch_numberp_data.php",
                        type: "POST",
                        data: {
                            filter_month_year: filterMonthYear,
                            draw: 1 // เพิ่ม draw ให้ส่งค่าเสมอ
                        }
                    }
                });
            }

            function filterWeekly() {
                var filterStartDate = $('#filter_start_date').val();
                var filterEndDate = $('#filter_end_date').val();
                $('#report_table').DataTable().destroy();
                $('#report_table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "../action/fetch_numberp_data.php",
                        type: "POST",
                        data: {
                            filter_start_date: filterStartDate,
                            filter_end_date: filterEndDate,
                            draw: 1 // เพิ่ม draw ให้ส่งค่าเสมอ
                        }
                    }
                });
            }

            function filterDetailed() {
                var serviceID = $('#service_id').val();
                var filterDate = $('#filter_date').val();
                var filterMonthYear = $('#filter_month_year').val();
                var filterStartDate = $('#filter_start_date').val();
                var filterEndDate = $('#filter_end_date').val();

                $('#report_table').DataTable().destroy();
                $('#report_table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "../action/fetch_numberp_data.php",
                        type: "POST",
                        data: {
                            service_id: serviceID,
                            filter_date: filterDate,
                            filter_month_year: filterMonthYear,
                            filter_start_date: filterStartDate,
                            filter_end_date: filterEndDate,
                            draw: 1 // เพิ่ม draw ให้ส่งค่าเสมอ
                        }
                    }
                });
            }
        </script>