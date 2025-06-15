<?php
    session_start();
    include('../../config.php');
    extract($_POST);
    
    $target_dir = "../../images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    
    $flname="images/".basename($_FILES["image"]["name"]);
    
    mysqli_query($con,"insert into tbl_movie values(NULL,'".$_SESSION['theatre']."','$name','','$desc','$rdate','$flname','$video','0')");
    
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    
    // Get the ID of the newly created event
    $event_id = mysqli_insert_id($con);
    
    $_SESSION['success']="Event Added Successfully";
    // header('location:index.php');
    // Redirect to seat arrangement page with the new event ID
    header('location:seat-arrangement.php?theater_id='.$event_id.'&action=add');
?> 