<?php
session_start();
include('../../../config.php');

if ($_SESSION && $_POST) {
    $show_id       = isset($_POST['show_id']) ? intval($_POST['show_id']) : 0;
    $theater_id    = isset($_POST['theater_id']) ? intval($_POST['theater_id']) : 0;
    $seatNameArray = $_POST['getseatname'] ?? [];
    $seatIdArray   = $_POST['getseatid'] ?? [];
    $forLoop       = count($seatIdArray);

    if ($show_id <= 0 || $theater_id < 0 || $forLoop == 0) {
        die("Invalid input received.");
    }

    $stmt = mysqli_prepare($con, "INSERT INTO charges (fk_show_id, td_id, seat_name, charges) VALUES (?, ?, ?, ?)");

    if (!$stmt) {
        die("SQL Prepare Error: " . mysqli_error($con));
    }

    for ($i = 0; $i < $forLoop; $i++) {
        $tdidArr = explode('.', $seatIdArray[$i]);
        if (count($tdidArr) !== 2) {
            continue;
        }

        $tdid      = $seatIdArray[$i];
        $seatname  = $seatNameArray[$i];
        $rowNum    = $tdidArr[0];
        $chargeKey = 'charges' . $rowNum;
        $charges   = isset($_POST[$chargeKey]) ? $_POST[$chargeKey] : '';

        mysqli_stmt_bind_param($stmt, 'isss', $show_id, $tdid, $seatname, $charges);
        if (!mysqli_stmt_execute($stmt)) {
            error_log("Insert failed for seat $seatname: " . mysqli_error($con));
        }
    }

    mysqli_stmt_close($stmt);

    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Charges Saved</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Charges Saved!',
            text: 'Seat charges have been stored successfully.',
            confirmButtonText: 'OK',
            timer: 2000,
            timerProgressBar: true
        }).then(() => {
            window.location.href = '../add-booking.php';
        });
        </script>
    </body>
    </html>";
    exit;
}
?>
