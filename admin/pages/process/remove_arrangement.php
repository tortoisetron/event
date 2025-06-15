<?php
session_start();
include('../../../config.php');

if(isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    
    // Delete all seats for this event
    $sql = "DELETE FROM seats WHERE fk_theater_id = '$event_id'";
    $result = mysqli_query($con, $sql);
    
    if($result) {
        $_SESSION['success'] = "Seat arrangement has been removed successfully!";
    } else {
        $_SESSION['error'] = "Error removing seat arrangement!";
    }
    
    // Redirect back to seat arrangement page
    header("Location: ../seat-arrangement.php?theater_id=" . $event_id . "&action=edit");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
?> 