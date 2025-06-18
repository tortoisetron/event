<?php include('header.php'); ?>
<link rel="stylesheet" href="../../validation/dist/css/bootstrapValidator.css"/>
<script type="text/javascript" src="../../validation/dist/js/bootstrapValidator.js"></script>

<!-- jQuery UI Datepicker & Timepicker Addon -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css"/>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>


<?php
    include('../../form.php');
    $frm = new formBuilder;
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Assign Show</h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Assign Show</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">
                <form action="process/save_assign_show.php" method="post" enctype="multipart/form-data" id="form1" onsubmit="return validation();">

                    <div class="form-group">
                        <label class="control-label">Select Event</label>
                        <select id='th2' name='th2' class="form-control">
                            <option value="">Select Event</option>

                            <?php
                            $sql = "SELECT * FROM tbl_movie ORDER BY movie_id DESC";
                            $result = mysqli_query($con, $sql);
                            if (!$result) {
                                die("Error fetching events: " . mysqli_error($con));
                            }
                            while($row = mysqli_fetch_array($result)) {
                                $event_id = $row['movie_id'];
                                $event_name = $row['movie_name'];
                                echo "<option value='$event_id'>".htmlspecialchars($event_name)."</option>";
                            }
                            ?>

                        </select>
                        <?php $frm->validate("th2", array("required", "label" => "Event")); ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Select Date</label>
                        <input type="text" id="datepicker" name="rdate" class="form-control" value="<?php echo date('Y-m-d'); ?>"/>
                        <?php $frm->validate("rdate", array("required", "label" => "Event Date")); ?>
                    </div>


                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Start Time</label>
                                <input type="time" class="form-control timepicker" name="start_time" id="start_time" value="<?php echo $data['start_time'] ?>" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">End Time</label>
                                <input type="time" class="form-control timepicker" name="end_time" id="end_time" value="<?php echo $data['end_time'] ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success">Assign Show</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- Apply validations -->
<script><?php $frm->applyvalidations("form1"); ?></script>

<!-- Script -->
<script>
$(document).ready(function() {
    $('#datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 0,
        changeMonth: true,
        changeYear: true
    });

    $('#th2').select2();
});
</script>
