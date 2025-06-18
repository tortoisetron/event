<?php
// session_start();
include('../../config.php');
include('header.php'); // AdminLTE header
// include('sidebar.php'); // AdminLTE sidebar (if available)

$show_id  = isset($_REQUEST['show_id']) ? intval($_REQUEST['show_id']) : 0;
$event_id = isset($_REQUEST['event_id']) ? intval($_REQUEST['event_id']) : 0;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header -->
  <section class="content-header">
    <h1>Assign Charges to Seats</h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Assign Charges</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="box box-primary">
      <div class="box-body">

<?php
$tdIdArray = [];
$seatNameArray = [];
$tdArray = [];
$trArray = [];

$sql = "SELECT * FROM seats WHERE fk_theater_id = '$event_id'";
$result = mysqli_query($con, $sql);

if (!$result) {
    echo "<div class='alert alert-danger'>SQL ERROR: " . mysqli_error($con) . "</div>";
} elseif (mysqli_num_rows($result) === 0) {
    echo "<div class='alert alert-warning'>No seats found for the selected theater.</div>";
} else {
    $_SESSION['show_id'] = $show_id;

    while ($row = mysqli_fetch_array($result)) {
        $idExplode = explode('.', $row['td_id']);

        if (count($idExplode) === 2 && is_numeric($idExplode[0]) && is_numeric($idExplode[1])) {
            $trArray[] = intval($idExplode[0]);
            $tdArray[] = intval($idExplode[1]);
            $tdIdArray[] = $row['td_id'];
            $seatNameArray[] = $row['seat_name'];
        }
    }

    if (!empty($trArray) && !empty($tdArray)) {
        $maxTr = max($trArray);
        $maxTd = max($tdArray);
        $colSpan = $maxTd + 2;

        echo "<form method='post' action='process/save_assign_charges.php'>";
        echo "<input type='hidden' name='show_id' value='$show_id'>";
        echo "<input type='hidden' name='theater_id' value='$event_id'>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered'>";

        for ($i = 1; $i <= $maxTr; $i++) {
            echo "<tr>";
            $flag = false;

            for ($j = 1; $j <= $maxTd; $j++) {
                $matchId = $i . '.' . $j;
                $found = false;

                foreach ($tdIdArray as $index => $tdId) {
                    if ($matchId === $tdId) {
                        $seatname = $seatNameArray[$index];
                        echo "<td id='$matchId' title='$seatname'>
                                $seatname<br/>
                                <img src='../images/unavailable.png' class='img-responsive' style='width:20px;' />
                              </td>";
                        echo "<input type='hidden' name='getseatname[]' value='$seatname'>";
                        echo "<input type='hidden' name='getseatid[]' value='$matchId'>";
                        $found = true;
                        $flag = true;
                        break;
                    }
                }

                if (!$found) {
                    echo "<td></td>";
                }
            }

            if ($flag) {
                echo "<td><input type='text' name='charges$i' id='charges$i' class='form-control input-sm' placeholder='Enter Charges'></td>";
            } else {
                echo "<td></td>";
            }

            echo "</tr>";
        }

        echo "<tr><td colspan='$colSpan' class='text-right'><button type='submit' class='btn btn-success'>Submit</button></td></tr>";
        echo "</table>";
        echo "</div>";
        echo "</form>";
    } else {
        echo "<div class='alert alert-warning'>No valid seat layout found (invalid td_id values).</div>";
    }
}
?>

      </div>
    </div>
  </section>
</div>

<?php include('footer.php'); ?>
