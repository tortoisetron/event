<?php
session_start();
include('../../config.php');

$id = intval($_POST['id']);
$name = mysqli_real_escape_string($con, $_POST['name']);
$desc = mysqli_real_escape_string($con, $_POST['desc']);
$rdate = mysqli_real_escape_string($con, $_POST['rdate']);
$video = mysqli_real_escape_string($con, $_POST['video']);
$old_image = mysqli_real_escape_string($con, $_POST['old_image']);

// Handle image upload
if (!empty($_FILES['image']['name'])) {
    $target_dir = "../../images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $flname = "images/" . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
} else {
    $flname = $old_image;
}

$sql = "UPDATE tbl_movie SET movie_name='$name', `desc`='$desc', release_date='$rdate', image='$flname', video_url='$video' WHERE movie_id='$id'";

if (mysqli_query($con, $sql)) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Event updated successfully!',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {
            window.location.href = 'index.php';
        });
    </script>";
} else {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Error updating event: " . mysqli_error($con) . "',
            showConfirmButton: true
        }).then(function() {
            window.location.href = 'edit_event.php?id=" . $id . "';
        });
    </script>";
}
?> 