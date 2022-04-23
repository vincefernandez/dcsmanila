<?php
  session_start();

  if (!isset($_SESSION["account_id"]) || empty($_SESSION["account_id"])) {
    header("location: ../login.php");
    exit();
  }

  include_once("../../core/repositories/database.php");
  include_once("../../core/repositories/queuing.php");

  $obj = new Queuing();
  $elemWaitingQueues = $obj->getQueues(1, 1);
  $elemNowServingQueues = $obj->getQueues(1, 2);
  $hsWaitingQueues = $obj->getQueues(2, 1);
  $hsNowServingQueues = $obj->getQueues(2, 2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Queuing</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
  <!-- Custom style -->
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="hold-transition sidebar-mini" onload="startTime()">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include("../../app/components/navbar.php"); ?>
    <!-- Sidebar -->
    <?php include("../../app/components/sidebar.php"); ?>

    <!-- Content -->
    <div class="content-wrapper">
      <!-- Header -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Queuing</h1>
            </div>
            <div class="col-sm-1 offset-sm-5">
              <h4 id="clock" class="text-right m-0 mt-2"></h4>
            </div>
          </div>
        </div>
      </div>

      <!-- Main -->
      <div class="content">
        <div class="container-fluid">
          <form action="#" method="post">
            <div class="row">
              <div class="col-md-6 d-flex">
                <div class="card flex-fill" style="min-height: 730px;">
                  <div class="card-header p-0">
                    <div class="text-center rounded-top bg-blue p-1">
                      <h2 class="text-light m-0">ELEMENTARY</h2>
                    </div>
                    <div class="row">
                      <div class="col-md-6 pr-0">
                        <div class="text-center bg-yellow p-1">
                          <h3 class="text-light m-0">WAITING</h3>
                        </div>
                      </div>
                      <div class="col-md-6 pl-0">
                        <div class="text-center bg-green p-1">
                          <h3 class="text-light m-0">NOW SERVING</h3>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="row">
                      <div class="col-md-6 pr-0">
                        <ul class="list-group">
                          <?php
                            foreach ($elemWaitingQueues as $item) {
                              echo "
                                <li class='list-group-item text-center' style='border: none;'>
                                  <span class='display-4'>" . $item["queue_no"] . "</span>
                                </li>";
                            }
                          ?>
                        </ul>
                      </div>
                      <div class="col-md-6 pl-0">
                        <ul class="list-group">
                          <?php
                            foreach ($elemNowServingQueues as $item) {
                              echo "
                                <li class='list-group-item text-center' style='border: none;'>
                                  <span class='display-4'>" . $item["queue_no"] . "</span>
                                </li>";
                            }
                          ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 d-flex">
              <div class="card flex-fill" style="min-height: 730px;">
                  <div class="card-header p-0">
                    <div class="text-center rounded-top bg-blue p-1">
                      <h2 class="text-light m-0">HIGHSCHOOL</h2>
                    </div>
                    <div class="row">
                      <div class="col-md-6 pr-0">
                        <div class="text-center bg-yellow p-1">
                          <h3 class="text-light m-0">WAITING</h3>
                        </div>
                      </div>
                      <div class="col-md-6 pl-0">
                        <div class="text-center bg-green p-1">
                          <h3 class="text-light m-0">NOW SERVING</h3>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="row">
                      <div class="col-md-6 pr-0">
                        <ul class="list-group">
                          <?php
                            foreach ($hsWaitingQueues as $item) {
                              echo "
                                <li class='list-group-item text-center' style='border: none;'>
                                  <span class='display-4'>" . $item["queue_no"] . "</span>
                                </li>";
                            }
                          ?>
                        </ul>
                      </div>
                      <div class="col-md-6 pl-0">
                        <ul class="list-group">
                          <?php
                            foreach ($hsNowServingQueues as $item) {
                              echo "
                                <li class='list-group-item text-center' style='border: none;'>
                                  <span class='display-4'>" . $item["queue_no"] . "</span>
                                </li>";
                            }
                          ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <?php include("../../app/components/footer.php"); ?>

    <!-- Refreshes page every 5 seconds -->
    <meta http-equiv="refresh" content="5">
  </div>

  <!-- jQuery -->
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../assets/js/adminlte.min.js"></script>
  <!-- Page specific script -->
  <script>
    function startTime() {
      const today = new Date();
      let hours = today.getHours();
      let minutes = today.getMinutes();
      let seconds = today.getSeconds();
      var ampm = hours >= 12 ? "PM" : "AM";
      hours = hours % 12;
      hours = hours ? hours : 12;
      hours = checkTime(hours);
      minutes = checkTime(minutes);
      seconds = checkTime(seconds);
      document.getElementById("clock").innerHTML =  hours + ":" + minutes + ":" + seconds + " " + ampm;
      setTimeout(startTime, 1000);
    }

    function checkTime(i) {
      if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
      return i;
    }
  </script>
</body>
</html>