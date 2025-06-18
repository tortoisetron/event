<?php
session_start();
include '../../../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movie_id = mysqli_real_escape_string($con, $_POST['th2']);
    $date     = mysqli_real_escape_string($con, $_POST['rdate']);

    // Parse and validate start time
    $start_input = trim($_POST['start_time']);
    $start_obj   = DateTime::createFromFormat('H:i', $start_input); // 24-hour format
    $start_time  = $start_obj ? $start_obj->format('H:i:s') : null;

    // Parse and validate end time (optional)
    $end_input = trim($_POST['end_time']);
    $end_time  = null;
    if (!empty($end_input)) {
        $end_obj  = DateTime::createFromFormat('H:i', $end_input); // 24-hour format
        $end_time = $end_obj ? $end_obj->format('H:i:s') : null;
    }


    if (!$start_time) {
        die("Invalid start time format.");
    }

    // Check for time conflict
    $conflictSql = "
        SELECT * FROM assign_show
        WHERE date = ?
          AND (
              (start_time <= ? AND (end_time IS NULL OR end_time > ?)) OR
              (? <= start_time AND ? > start_time)
          )
    ";
    $conflictStmt = mysqli_prepare($con, $conflictSql);
    mysqli_stmt_bind_param($conflictStmt, "sssss", $date, $start_time, $start_time, $start_time, $end_time);
    mysqli_stmt_execute($conflictStmt);
    $conflictResult = mysqli_stmt_get_result($conflictStmt);

    if (mysqli_num_rows($conflictResult) > 0) {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Show Conflict</title>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Conflict Detected',
                text: 'Show timing conflicts with an existing show. Please choose a different time slot.',
                confirmButtonText: 'Go Back'
            }).then(() => {
                window.history.back();
            });
        </script>
        </body>
        </html>";
        exit;
    }

    // Insert the show
    $insertSql = "INSERT INTO assign_show (movie_id, date, start_time, end_time) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $insertSql);
    mysqli_stmt_bind_param($stmt, "isss", $movie_id, $date, $start_time, $end_time);

    if (mysqli_stmt_execute($stmt)) {
        $insertId = mysqli_insert_id($con);

        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Assign Show</title>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Show assigned successfully!',
                timer: 2000,
                showConfirmButton: false
            }).then(function() {
                window.location.href = '../assign_charges.php?event_id={$movie_id}&show_id={$insertId}';
            });
        </script>
        </body>
        </html>";
        exit;
    } else {
        die("Insert failed: " . mysqli_error($con));
    }
}

mysqli_close($con);
?>
