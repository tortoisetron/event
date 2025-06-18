<?php
include('header.php');
include('../../config.php');

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    
    // Delete the event
    $query = "DELETE FROM tbl_movie WHERE movie_id = '$id'";
    
    if (mysqli_query($con, $query)) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Event deleted successfully!',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                document.location.href = 'index.php';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error deleting event: " . mysqli_error($con) . "',
                showConfirmButton: true
            }).then(function() {
                document.location.href = 'index.php';
            });
        </script>";
    }
} else {
    header('Location: index.php');
    exit();
}
?> 