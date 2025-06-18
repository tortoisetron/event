<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../../../config.php');

$show_id    = $_POST['show_id'];
$event_id   = $_POST['th2'];
$rdate      = $_POST['rdate'];
$start_time = $_POST['start_time'];
$end_time   = $_POST['end_time'];

$query = "UPDATE assign_show SET 
            movie_id = '$event_id',
            date = '$rdate',
            start_time = '$start_time',
            end_time = '$end_time'
          WHERE show_id = '$show_id'";

if (mysqli_query($con, $query)) {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Show Updated</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: 'Show details updated successfully.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = '../assigned_show.php?success=1';
            });
        </script>
    </body>
    </html>";
} else {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Update Failed</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Update Failed',
                text: 'Error: " . addslashes(mysqli_error($con)) . "',
                confirmButtonText: 'Go Back'
            }).then(() => {
                window.history.back();
            });
        </script>
    </body>
    </html>";
}
?>
