<?php
    session_start();
    include('../../config.php');
    extract($_POST);
    
    $target_dir = "../../images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    
    $flname="images/".basename($_FILES["image"]["name"]);
    
    if (mysqli_query($con,"insert into tbl_movie values(NULL,'".$_SESSION['theatre']."','$name','','$desc','$rdate','$flname','$video','0')")) {
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        
        // Get the ID of the newly created event
        $event_id = mysqli_insert_id($con);
        
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Event added successfully!',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = 'seat-arrangement.php?theater_id=".$event_id."&action=add';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error adding event: " . mysqli_error($con) . "',
                showConfirmButton: true
            }).then(function() {
                window.location.href = 'add_event.php';
            });
        </script>";
    }
?> 