<?php
include('header.php');
include('../../config.php');

$id=$_SESSION['id'];
$event_id = $_REQUEST['theater_id'];
$action = $_REQUEST['action'];

$sql = "select * from tbl_movie where movie_id = '$event_id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$td_idArray = array('a');
$seat_nameArray = array('a');

if($action == 'edit')
{
	$sql1 = "select * from seats where fk_theater_id = '$event_id'";
	$result1 = mysqli_query($con, $sql1);
	$rescnt = mysqli_num_rows($result1);
	if($rescnt > 0)
	{
		$sql3 = "select * from seats where fk_theater_id = '$event_id'";
		$result3 = mysqli_query($con, $sql3);
		while($row3 = mysqli_fetch_array($result3))
		{
			array_push($td_idArray,$row3['td_id']);
			array_push($seat_nameArray,$row3['seat_name']);
		}
	}
}
?>
<!-- Add this style block -->
<style>
#adminSeatArrange {
  border-collapse: collapse;
  width: 100%;
  table-layout: fixed;
  background: #fff;
}

#adminSeatArrange td, #adminSeatArrange th, .config-table td, .config-table th {
  border: 1px solid #666;
  /* width: 28px;
  height: 28px; */
  text-align: center;
  vertical-align: middle;
  padding: 0;
  box-sizing: border-box;
}

#adminSeatArrange img {
  width: 17px;
  height: 17px;
  display: block;
  margin: 0 auto;
}

#adminSeatArrange tr:first-child td,
#adminSeatArrange td:first-child {
  background: #f8f8f8;
  font-weight: bold;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Seat Arrangement for Event: <?php echo $row['movie_name']; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Seat Arrangement</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <div class="row">
            <div class="col-md-2">
              <form>
                <table cellpadding="5" style="margin-bottom: 20px;" class="table border-dark table-sm config-table">
                  <tr>
                    <td style='width:100px;'>Row from</td>
                    <td>
                      <select id='row_from' name='row_from' class="form-control input-sm">
                        <option value=''></option>
                        <?php for($i = 1;$i<41;$i++) { echo"<option>$i</option>"; } ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td style='width:100px;'>Row To</td>
                    <td>
                      <select id='row_to' name='row_to' class="form-control input-sm">
                        <option value=''></option>
                        <?php for($j = 1;$j<41;$j++) { echo"<option>$j</option>"; } ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td style='width:100px;'>Column from</td>
                    <td>
                      <select id='col_from' name='col_from' class="form-control input-sm">
                        <option value=''></option>
                        <?php for($i = 1;$i<41;$i++) { echo"<option>$i</option>"; } ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td style='width:100px;'>Column To</td>
                    <td>
                      <select id='col_to' name='col_to' class="form-control input-sm">
                        <option value=''></option>
                        <?php for($j = 1;$j<41;$j++) { echo"<option>$j</option>"; } ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Start seat no</td>
                    <td>
                      <select id='seat_no' name='seat_no' class="form-control input-sm">
                        <option value=''></option>
                        <?php for($i = 0;$i<41;$i++) { echo"<option value='$i'>$i</option>"; } ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Seat no order</td>
                    <td>
                      <select id='seatNOrder' name='seatNOrder' class="form-control input-sm">
                        <option value=''></option>
                        <option value='i'>Increase</option>
                        <option value='d'>Decrease</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Start Seat name</td>
                    <td>
                      <select id='seat_name' name='seat_name' class="form-control input-sm">
                        <option value=''></option>
                        <?php $namearray = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'); $stcnt = count($namearray); for($i = 0;$i<$stcnt;$i++) { echo"<option value='$namearray[$i]'>$namearray[$i]</option>"; } ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Seat name order</td>
                    <td>
                      <select id='seatNmOrder' name='seatNmOrder' class="form-control input-sm">
                        <option value=''></option>
                        <option value='i'>Increase</option>
                        <option value='d'>Decrease</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td colspan='2'>
                      <input type='button' name='btn' id='btn' value='Save' class='btn btn-primary btn-sm' style="width:100%;margin-bottom:5px;" onclick="make_arrangement()" />
                    </td>
                  </tr>
                  <tr>
                    <td colspan='2'><input type='button' value='Submit Arrangement' class='btn btn-default btn-sm' style="width:100%;" onclick="save_arrangement()" /></td>
                  </tr>
                  <tr>
                    <td colspan='2'><input type='button' id='removeBtn' value='Remove Arrangement' class='btn btn-danger btn-sm' style="width:100%;" onclick="remove_arrangement()" <?php echo ($action != 'edit' && $rescnt == 0) ? 'disabled' : ''; ?> /></td>
                  </tr>
                </table>
              </form>
            </div>
            <div class="col-md-10">
              <div style="overflow-x:auto; max-width:100%;">
                <table class="table table-bordered table-sm" id="adminSeatArrange" style="background:#fff;">
                  <?php
                  for($i = 0; $i<41; $i++) {
                    echo"<tr>";
                    for($j = 0; $j<41; $j++) {
                      if($i == 0 || $j == 0) {
                        if($i ==0 && $j == 0) {
                          echo"<td style='border:1px solid #666;'>0</td>";
                        } else if($i == 0) {
                          echo"<td style='border:1px solid #666;'>$j</td>";
                        } else if($j == 0) {
                          echo"<td style='border:1px solid #666;'>$i</td>";
                        }
                      } else {
                        $matchId = $i.'.'.$j;
                        $flag = false;
                        for($m=0; $m<count($td_idArray); $m++) {
                          if($matchId === $td_idArray[$m]) {
                            $seatname = $seat_nameArray[$m];
                            echo"<td id='$matchId' title='$seatname'><img src='../images/unavailable.png' class='$seatname' /></td>";
                            $flag = true;
                          }
                        }
                        if(!$flag) {
                          echo"<td id='$matchId'></td>";
                        }
                      }
                    }
                    echo"</tr>";
                  }
                  ?>
                </table>
              </div>
              <div class='take_arrangement' id='take_arrangement' style='display:hidden;'></div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>
<script type="text/javascript" src="../js/jquery.js"></script>
<script>
// Track if there is a client-side arrangement
window.hasClientArrangement = false;

// Enable/disable remove button
function updateRemoveBtnState() {
    var btn = document.getElementById('removeBtn');
    // Enable if there is client-side arrangement or DB arrangement
    if (window.hasClientArrangement || <?php echo ($rescnt > 0 ? 'true' : 'false'); ?>) {
        btn.disabled = false;
    } else {
        btn.disabled = true;
    }
}

function make_arrangement()
{
    var flag = true;
    var row_from = parseInt($('#row_from').val());
    var row_to = parseInt($('#row_to').val());
    var col_from = parseInt($('#col_from').val());
    var col_to = parseInt($('#col_to').val());
    var seat_no = $('#seat_no').val();
    var seat_name = $('#seat_name').val();
    var noOrder = $('#seatNOrder').val();
    var nameOrder = $('#seatNmOrder').val();

    if(isNaN(row_from)) {
        alert('Please select row from');
        return false;
    }
    if(isNaN(row_to)) {
        alert('Please select row to');
        return false;
    }
    if(isNaN(col_from)) {
        alert('Please select column from');
        return false;
    }
    if(isNaN(col_to)) {
        alert('Please select column to');
        return false;
    }

    // for loop for rows
    for(var i = row_from; i <= row_to; i++)
    {
        // for loop for columns
        var seat_no_local = seat_no;
        var seat_name_local = seat_name;
        if(seat_name_local != '')
        {
            seatarray = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
            seatcnt = seatarray.length;
            getIndex = seatarray.indexOf(seat_name_local);
        }
        else
        {
            seat_name_local = '';
        }

        for(var j = col_from; j <= col_to; j++)
        {
            if(flag)
            {
                // alert("You have selected Row-"+row_from+"-"+row_to+"& Column-"+col_from+"-"+col_to);
            }
            flag = false;
            var tdid = i + '.' + j;

            getSeatName = seat_name_local + "" + seat_no_local;

            document.getElementById(tdid).innerHTML = "<img title='" + getSeatName + "' src='../images/unavailable.png' class='" + getSeatName + "' />";

            var tdtitle = getSeatName;
            $('#' + tdid).attr('title', tdtitle);

            if(noOrder == 'i')
            {
                if(seat_no_local != '')
                {
                    seat_no_local++;
                }
                else
                {
                    seat_no_local = '';
                }
            }
            else if(noOrder == 'd')
            {
                if(seat_no_local != '')
                {
                    seat_no_local--;
                }
                else
                {
                    seat_no_local = '';
                }
            }
        }
        if(nameOrder == 'i')
        {
            if(seat_name_local != '')
            {
                getIndex++;
                seat_name_local = seatarray[getIndex];
            }
            else
            {
                seat_name_local = '';
            }
        }
        else if(nameOrder == 'd')
        {
            if(seat_name_local != '')
            {
                getIndex--;
                seat_name_local = seatarray[getIndex];
            }
            else
            {
                seat_name_local = '';
            }
        }
    }
    // Set client arrangement flag if you use the previous solution
    window.hasClientArrangement = true;
    updateRemoveBtnState && updateRemoveBtnState();
}
</script>
<script>
function save_arrangement(){
	td_element = $('#adminSeatArrange td img');
	var td_cnt = $('#adminSeatArrange td img').length;
	var myForm = "<form name='arrangement_form' id='arrangement_form' method='post' action='process/save_arrangement.php'>";
	for(i = 0; i<td_cnt; i++)
	{
		getTdId = $('#adminSeatArrange td img:eq('+i+')').closest('td').attr('id');
		getSeatname = $('#adminSeatArrange td img:eq('+i+')').attr('class');
		myForm = myForm + "<input type='hidden' name='tdId[]' value='"+getTdId+"'>";
		myForm = myForm + "<input type='hidden' name='seatName[]' value='"+getSeatname+"'>";
		
	}
	myForm = myForm + "<input type='hidden' name='event_id' value='<?php echo $event_id?>'>";
	myForm = myForm + "<input type='hidden' name='action' value='<?php echo $action?>'>";
	myForm = myForm + "<input type='submit' name='submit_arrangement' id='submit_arrangement' value='submit_arrangement'>";
	myForm = myForm + "</form>";
	
	document.getElementById('take_arrangement').innerHTML = myForm;
	document.forms['arrangement_form'].submit();
	// After arrangement is submitted, reset the flag
	window.hasClientArrangement = false;
	updateRemoveBtnState();
}
</script>
<script>
function remove_arrangement() {
    if (window.hasClientArrangement) {
        // Clear the table (client-side only)
        $('#adminSeatArrange td').each(function() {
            var id = $(this).attr('id');
            if (id && id.indexOf('.') !== -1) {
                $(this).html('');
                $(this).removeAttr('title');
            }
        });
        window.hasClientArrangement = false;
        updateRemoveBtnState();
    } else {
        // No client-side arrangement, do DB removal
        if(confirm('Are you sure you want to remove all seat arrangements?')) {
            var myForm = "<form name='remove_arrangement_form' id='remove_arrangement_form' method='post' action='process/remove_arrangement.php'>";
            myForm = myForm + "<input type='hidden' name='event_id' value='<?php echo $event_id?>'>";
            myForm = myForm + "<input type='submit' name='submit_remove' id='submit_remove' value='submit_remove'>";
            myForm = myForm + "</form>";
            document.getElementById('take_arrangement').innerHTML = myForm;
            document.forms['remove_arrangement_form'].submit();
        }
    }
}
</script>
<script>
// On page load, set the button state
window.onload = updateRemoveBtnState;
</script>
<?php
include('footer.php');
?>