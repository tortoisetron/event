<?php
include('header.php');
include('../../config.php');

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    
    // Delete the agent
    $query = "DELETE FROM tbl_users WHERE id = '$id'";
    
    if (mysqli_query($con, $query)) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Agent deleted successfully!',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                document.location.href = 'agent.php';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error deleting agent: " . mysqli_error($con) . "',
                showConfirmButton: true
            }).then(function() {
                document.location.href = 'agent.php';
            });
        </script>";
    }
} else {
    header('Location: agent.php');
    exit();
}
?> 