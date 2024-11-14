<?php

session_start();
if (!isset($_SESSION['accountId'])) {
    header("Location: index.php");
    exit();
}

include 'fetchname.php'; 

$host = 'localhost';  
$username = 'root';  
$password = '';      
$dbname = 'bcp_sms3_ems'; 

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "
    SELECT 
        MONTH(date_booked) AS month,
        COUNT(id) AS booking_count,
        SUM(attendees) AS total_attendees
    FROM bcp_sms3_event_history
    WHERE YEAR(date_booked) = YEAR(CURRENT_DATE)
    GROUP BY MONTH(date_booked)
    ORDER BY MONTH(date_booked);
";

$result = $conn->query($sql);

$bookingCounts = [];
$attendeeCounts = [];
$months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

for ($i = 0; $i < 12; $i++) {
    $bookingCounts[$i] = 0;
    $attendeeCounts[$i] = 0;
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $monthIndex = $row['month'] - 1; 
        $bookingCounts[$monthIndex] = $row['booking_count'];
        $attendeeCounts[$monthIndex] = $row['total_attendees'];
    }
}

$conn->close();

$bookingCountsJson = json_encode($bookingCounts);
$attendeeCountsJson = json_encode($attendeeCounts);
?>


<script>
  const bookingCounts = <?php echo json_encode($bookingCounts); ?>;
</script>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Event Management System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="assets/img/bcp logo.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.0.0/main.css' rel='stylesheet' />
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.0.0/main.min.js'></script>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
</head>
<body>
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/default profile.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo htmlspecialchars($fullname); ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <span>Administrator</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="index.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

   
    <ul class="sidebar-nav" id="sidebar-nav">
    <div class="logo-container" style="text-align: center; margin-bottom: 10px;">
    <img src="assets/img/bcp logo.png" alt="Logo" style="width: 100px; height: auto;">
</div>

      <hr class="sidebar-divider">

              <li class="nav-heading">Event Management System</li>

              <li class="nav-item">
              <a class="nav-link collapsed" data-bs-target="#system-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-calendar4-event"></i><span>Event Management</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="system-nav" class="nav-content collapse show " data-bs-parent="#sidebar-nav">
                <li>
                <li>
                <a href="eventdash.php" class="active">
                    <i class="bi bi-circle"></i><span>Report and Analytics</span>
                </a>
                </li>
                <a href="calendar.php" >
                    <i class="bi bi-circle"></i><span>Events Calendar</span>
                </a>
                </li>
                <li>
                <a href="tables-data.php">
                    <i class="bi bi-circle"></i><span>Event Bookings</span>
                </a>
                </li>
                <li>
                <a href="history-data.php">
                    <i class="bi bi-circle"></i><span>History</span>
                </a>
                </li>
              
      <hr class="sidebar-divider">
  </aside><!-- End Sidebar-->
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="col-12">
  <div class="card">
    <div class="filter">
      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <li class="dropdown-header text-start">
          <h6>Filter</h6>
        </li>
        <li><a class="dropdown-item" href="#">Today</a></li>
        <li><a class="dropdown-item" href="#">This Month</a></li>
        <li><a class="dropdown-item" href="#">This Year</a></li>
      </ul>
    </div>

    <div class="card-body">
      <h5 class="card-title">Reports <span>/ Monthly Bookings</span></h5>
      <div id="reportsChart"></div>

      <div id="reportsChart"></div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    new ApexCharts(document.querySelector("#reportsChart"), {
      series: [
        {
          name: 'Bookings',
          data: <?php echo $bookingCountsJson; ?>,
        },
        {
          name: 'Attendees',
          data: <?php echo $attendeeCountsJson; ?>, 
        }
      ],
      chart: {
        height: 350,
        type: 'line',  
        toolbar: {
          show: false
        },
      },
      colors: ['#4154f1', '#ff5733'], 
      dataLabels: {
        enabled: true, 
      },
      stroke: {
        width: 3, 
        curve: 'smooth', 
      },
      xaxis: {
        categories: <?php echo json_encode($months); ?>, 
        title: {
          text: 'Months', 
        },
      },
      yaxis: {
        title: {
          text: 'Number of Bookings / Attendees',
        },
      },
      tooltip: {
        y: {
          formatter: function (val, opts) {
            if (opts.seriesIndex === 0) { 
              return val + " booking"; 
            } else {
              return val + " people"; 
            }
          }
        },
      }
    }).render();
  });
</script>




    </div>
  </div>
</div>

    </div>

  </div>
</div><!-- End Reports -->

  </main><!-- End #main -->
  
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/js/main.js"></script>
  <script>
   fetch('/BCP-EventManagement/dashboard_data.php')
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {

    document.getElementById('today-count').textContent = data.todayEvent.event_title || 'No event today';
    document.getElementById('today-increase').textContent = data.todayEvent.attendees || 0;

    document.getElementById('month-count').textContent = data.monthData.event_count || 0;
    document.getElementById('month-increase').textContent = data.monthData.total_attendees || 0;

    document.getElementById('year-count').textContent = data.yearData.event_count || 0;
    document.getElementById('year-increase').textContent = data.yearData.total_attendees || 0;
  })
  .catch(error => console.error('Error fetching data:', error));

</script>


</body>
</html>