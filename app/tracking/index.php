<?php
  session_start();

  include_once("../../core/repositories/database.php");
  include_once("../../core/repositories/record.php");

  $control_no = $_GET["control_no"];

  $obj = new Record();
  $tracks = $obj->getTrackByControlNo($control_no);

  if ($tracks == null) {
    $_SESSION["toastr"] = array("type" => "error", "message" => "Invalid control number!");
    header("location: ../../index.php");
  }

  // Time Elapsed String -- Not functioning properly. For future reference if needed.
  // function time_elapsed_string($datetime, $full = false) {
  //   $now = new DateTime;
  //   $ago = new DateTime($datetime);
  //   $diff = $now->diff($ago);

  //   $diff->w = floor($diff->d / 7);
  //   $diff->d -= $diff->w * 7;

  //   $string = array(
  //     "y" => "year",
  //     "m" => "month",
  //     "w" => "week",
  //     "d" => "day",
  //     "h" => "hour",
  //     "i" => "minute",
  //     "s" => "second",
  //   );
  //   foreach ($string as $k => &$v) {
  //     if ($diff->$k) {
  //       $v = $diff->$k . " " . $v . ($diff->$k > 1 ? "s" : "");
  //     } else {
  //       unset($string[$k]);
  //     }
  //   }

  //   if (!$full) $string = array_slice($string, 0, 1);
  //   return $string ? implode(", ", $string) . " ago" : "just now";
  // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Receiving Routing and Mailing - Highschool</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
  <!-- Custom style -->
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="hold-transition tracking-index-page">
  <div class="tracking-index-box">
    <div class="row justify-content-md-center">
      <div class="col-md-12">
        <div class="timeline mt-5">
          <?php
            $date = "";
            foreach ($tracks as $item) {
              if ($date != $item["date"]) {
                $date = $item["date"];

                echo "
                <div class='time-label'>
                  <span class='bg-primary'>" . date("F j, Y", strtotime($item["date"])) . "</span>
                </div>";
              }

              echo "
              <div>
                <div class='timeline-item'>
                  <div class='timeline-header'>
                    <div class='d-flex'>";
              
              if ($item["section"] == "") {
                echo "<span class='mr-auto badge'>" . $item["office_code"] . "</span>";
              } else {
                echo "<span class='mr-auto badge'>" . $item["office_code"] . " | " . $item["section_code"] . "</span>";
              }

              switch ($item["status"]) {
                case "Open":
                  echo "<span class='badge badge-pill bg-cyan' style='width: 80px;'>" . $item["status"] . "<span>";
                  break;
                case "In Progress":
                  echo "<span class='badge badge-pill bg-green' style='width: 80px;'>$item[status]</span>";
                  break;
                case "Received":
                  echo "<span class='badge badge-pill bg-teal' style='width: 80px;'>$item[status]</span>";
                  break;
                case "Forwarded":
                  echo "<span class='badge badge-pill bg-purple' style='width: 80px;'>$item[status]</span>";
                  break;
                case "Returned":
                  echo "<span class='badge badge-pill bg-pink' style='width: 80px;'>$item[status]</span>";
                  break;
                case "In Review":
                  echo "<span class='badge badge-pill bg-indigo' style='width: 80px;'>$item[status]</span>";
                  break;
                case "For Release":
                  echo "<span class='badge badge-pill bg-blue' style='width: 80px;'>$item[status]</span>";
                  break;
                case "Released":
                  echo "<span class='badge badge-pill bg-dark' style='width: 80px;'>$item[status]</span>";
                  break;
                case "On Hold":
                  echo "<span class='badge badge-pill bg-red' style='width: 80px;'>$item[status]</span>";
                  break;
                case "Cancelled":
                  echo "<span class='badge badge-pill bg-gray' style='width: 80px;'>$item[status]</span>";
                  break;
              }

              echo "
                    </div>
                  </div>
                  <div class='timeline-body'>
                    <div class='d-flex flex-column'>
                      <p class='mb-0'>" . $item["remarks"] . "</p>
                    </div>
                  </div>
                  <div class='timeline-footer'>
                    <div class='d-flex'>
                      <span class='badge'>" . date("h:i A", strtotime($item["time"])) . "</span>
                    </div>
                  </div>
                </div>
              </div>";
            }
          ?>
          <div>
            <i class="fas fa-clock bg-gray"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-md-center">
      <div class="col-sm-2">
        <button class="btn btn-block btn-primary" onclick="history.back()">Go Back</button>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Toastr -->
  <script src="../../plugins/toastr/toastr.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../assets/js/adminlte.min.js"></script>
</body>
</html>