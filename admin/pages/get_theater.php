<?php
session_start();
include('../../config.php');

$sql = "SELECT * FROM tbl_movie WHERE status = 0 ORDER BY movie_id DESC";
$stmt = mysqli_prepare($con, $sql);
if (!$stmt) {
    die("Error preparing query: " . mysqli_error($con));
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

echo "<option value=''>Select Event</option>";
while ($row = mysqli_fetch_array($result)) {
    echo "<option value='" . htmlspecialchars($row['movie_id']) . "'>" . htmlspecialchars($row['movie_name']) . "</option>";
}
?>
