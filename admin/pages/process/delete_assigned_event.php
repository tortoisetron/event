<?php
session_start();
include('../../../config.php'); // adjust path if needed

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>
        alert('Invalid ID');
        window.location.href = '../assigned_show.php';
    </script>";
    exit;
}

$show_id = intval($_GET['id']);


$query = "DELETE FROM assign_show WHERE show_id = '$show_id'";
if (mysqli_query($con, $query)) {
    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: 'Assigned event has been deleted.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = '../assigned_show.php';
            });
        </script>
    </body>
    </html>";
} else {
    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to delete: " . mysqli_error($con) . "',
                confirmButtonText: 'Back'
            }).then(() => {
                window.location.href = '../assigned_show.php';
            });
        </script>
    </body>
    </html>";
}
?>
