<?php
include('header.php');
?>
<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Assigned Events List</h1>
    <ol class="breadcrumb">
      <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Assigned Events List</li>
    </ol>
  </section>

  <div class="text-right" style="margin: 10px 20px 20px 0;">
    <a href="assign-show.php" class="btn btn-success"><i class="fa fa-calendar"></i> Assign Event</a>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="box">
      <div class="box-body">
        <div class="box box-primary">
          <div class="box-body">
            <?php
              $sql = "
                SELECT 
                  assign_show.show_id,
                  assign_show.date,
                  assign_show.movie_id,
                  assign_show.start_time,
                  assign_show.end_time,
                  tbl_movie.movie_name,
                  tbl_movie.desc,
                  tbl_movie.image
                FROM assign_show
                JOIN tbl_movie ON assign_show.movie_id = tbl_movie.movie_id
                ORDER BY assign_show.show_id DESC
              ";
              $result = mysqli_query($con, $sql);

              if (mysqli_num_rows($result) > 0) {
                include('../../msgbox.php');
            ?>
            <table id="eventTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Event Name</th>
                  <th>Description</th>
                  <th>Date & Time</th>
                  <th>Image</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              <?php while ($row = mysqli_fetch_array($result)) { ?>
                <tr>
                  <td><?php echo htmlspecialchars($row['movie_name']); ?></td>
                  <td><?php echo substr(strip_tags($row['desc']), 0, 100); ?>...</td>
                  <td>
                    <?php echo date('d/m/y', strtotime($row['date'])); ?><br>
                    <small><?php echo date('h:i A', strtotime($row['start_time'])); ?> 
                    <?php if ($row['end_time']) echo "to " . date('h:i A', strtotime($row['end_time'])); ?></small>
                  </td>
                  <td><img src="../../<?php echo $row['image']; ?>" width="100"></td>
                  <td>
                    <a href="edit_assign_show.php?id=<?php echo $row['show_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="assign_charges.php?event_id=<?php echo $row['movie_id']; ?>&show_id=<?php echo $row['show_id']; ?>" class="btn btn-info btn-sm">Assign Charges</a>
                    <button onclick="deleteEvent(<?php echo $row['show_id']; ?>)" class="btn btn-danger btn-sm">Delete</button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
            <?php } else { ?>
              <div class="text-center" style="padding: 50px 0;">
                <i class="fa fa-calendar fa-5x text-muted" style="margin-bottom: 20px;"></i>
                <h3 class="text-muted">No Events Found</h3>
                <p class="text-muted">There are no assigned events in the system yet.</p>
                <a href="assign-show.php" class="btn btn-primary btn-lg" style="margin-top: 20px;">
                  <i class="fa fa-plus"></i> Assign Your First Event
                </a>
              </div>
            <?php } ?>
          </div>
        </div>
      </div> 
    </div>
  </section>
</div>

<?php include('footer.php'); ?>

<script>
function deleteEvent(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "This event will be permanently deleted!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = 'process/delete_assigned_event.php?id=' + id;
    }
  });
}

$(document).ready(function () {
  $('#eventTable').DataTable();
});
</script>
