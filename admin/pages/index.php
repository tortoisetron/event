<?php
include('header.php');
?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Events List
      </h1>
      <ol class="breadcrumb">
        <!-- <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li> -->
        <li class="active">Events List</li>
      </ol>
    </section>
    <div class="text-right" style="margin: 10px 20px 20px 0;">
      <a href="add_event.php" class="btn btn-success"><i class="fa fa-calendar"></i> Add Event</a>
    </div>

    <!-- Main content -->
    <section class="content">

      <!-- Default box --> 
      <div class="box">
        <div class="box-body">
            <div class="box box-primary">
            <!-- /.box-header -->
            <div class="box-body">
              <?php include('../../msgbox.php');?>
              <?php 
              $sql = "SELECT * FROM tbl_movie ORDER BY movie_id DESC";
              $result = mysqli_query($con, $sql);
              if(mysqli_num_rows($result) > 0) { ?>
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Event Name</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Image</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while($row = mysqli_fetch_array($result)) {
                  ?>
                  <tr>
                    <td><?php echo $row['movie_name']; ?></td>
                    <td><?php echo substr($row['desc'], 0, 100); ?>...</td>
                    <td><?php echo $row['release_date']; ?></td>
                    <td><img src="../../<?php echo $row['image']; ?>" width="100"></td>
                    <td>
                      <a href="edit_event.php?id=<?php echo $row['movie_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                      <a href="seat-arrangement.php?theater_id=<?php echo $row['movie_id']; ?>&action=edit" class="btn btn-info btn-sm">Manage Seats</a>
                      <button onclick="deleteEvent(<?php echo $row['movie_id']; ?>)" class="btn btn-danger btn-sm">
                        <i class="fa fa-trash"></i> Delete
                      </button>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
              <?php } else { ?>
                <div class="text-center" style="padding: 50px 0;">
                  <i class="fa fa-calendar fa-5x text-muted" style="margin-bottom: 20px;"></i>
                  <h3 class="text-muted">No Events Found</h3>
                  <p class="text-muted">There are no events in the system yet.</p>
                  <a href="add_event.php" class="btn btn-primary btn-lg" style="margin-top: 20px;">
                    <i class="fa fa-plus"></i> Add Your First Event
                  </a>
                </div>
              <?php } ?>
            </div>
          </div>
        </div> 
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <?php
include('footer.php');
?>
<script>
function deleteEvent(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.location.href = 'delete_event.php?id=' + id;
        }
    });
}
</script>