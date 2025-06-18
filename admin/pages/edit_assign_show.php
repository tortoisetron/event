<?php
    // session_start();
    include '../../config.php';
    include 'header.php';

    include '../../form.php';
    $frm = new formBuilder;

    // Get the existing show ID
    $show_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Fetch existing record
    $query  = "SELECT * FROM assign_show WHERE show_id = '$show_id'";
    $result = mysqli_query($con, $query);
    if (! $result || mysqli_num_rows($result) === 0) {
        die("Invalid Show ID or data not found.");
    }

    $data = mysqli_fetch_assoc($result);
?>

<link rel="stylesheet" href="../../validation/dist/css/bootstrapValidator.css"/>
<script type="text/javascript" src="../../validation/dist/js/bootstrapValidator.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css"/>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Assigned Show</h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Edit Show</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">
                <form action="process/update_assign_show.php" method="post" enctype="multipart/form-data" id="form1">

                    <input type="hidden" name="show_id" value="<?php echo $data['show_id'] ?>">

                    <div class="form-group">
                        <label class="control-label">Select Event</label>
                        <select id="th2" name="th2" class="form-control">
                            <option value="">Select Event</option>
                            <?php
                                $sql    = "SELECT * FROM tbl_movie ORDER BY movie_id DESC";
                                $result = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                    $selected = ($row['movie_id'] == $data['movie_id']) ? "selected" : "";
                                    echo "<option value='{$row['movie_id']}' $selected>" . htmlspecialchars($row['movie_name']) . "</option>";
                                }
                            ?>
                        </select>
                        <?php $frm->validate("th2", ["required", "label" => "Event"]); ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Select Date</label>
                        <input type="text" id="datepicker" name="rdate" class="form-control" value="<?php echo isset($data['date']) ? date('Y-m-d', strtotime($data['date'])) : '' ?>"/>
                        <?php $frm->validate("rdate", ["required", "label" => "Event Date"]); ?>
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
                <button class="btn btn-primary">Update Show</button>
            </div>
        </form>
    </div>
        </div>
    </section>
</div>

<script><?php $frm->applyvalidations("form1"); ?></script>

<script>
$(document).ready(function() {
    $('#datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 0,
        changeMonth: true,
        changeYear: true
    });

    // $('.timepicker').timepicker({
    //     timeFormat: 'hh:mm TT',
    //     interval: 15,
    //     dropdown: true,
    //     scrollbar: true
    // });

    $('#th2').select2();
});
</script>
