<?php
include('header.php');
include('../../config.php');

// Fetch all agents
$query = "SELECT * FROM tbl_users ORDER BY created_at DESC";
$result = mysqli_query($con, $query);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Agent Management
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <!-- <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li> -->
            <li class="active">Agent Management</li>
        </ol>
    </section>
    <div class="text-right" style="margin: 10px 20px 20px 0;">
      <a href="add_agent.php" class="btn btn-success"><i class="fa fa-users"></i> Add Agent</a>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!-- <div class="box-header">
                        <h3 class="box-title">Agent List</h3>
                        <div class="box-tools">
                            <a href="add_agent.php" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Add New Agent
                            </a>
                        </div>
                    </div> -->
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php if(mysqli_num_rows($result) > 0) { ?>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['age']; ?></td>
                                        <td><?php echo $row['gender']; ?></td>
                                        <td><?php echo $row['mobile_number']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo date('d-m-Y H:i', strtotime($row['created_at'])); ?></td>
                                        <td>
                                            <a href="edit_agent.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <button onclick="deleteAgent(<?php echo $row['id']; ?>)" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <div class="text-center" style="padding: 50px 0;">
                                <i class="fa fa-users fa-5x text-muted" style="margin-bottom: 20px;"></i>
                                <h3 class="text-muted">No Agents Found</h3>
                                <p class="text-muted">There are no agents in the system yet.</p>
                                <a href="add_agent.php" class="btn btn-primary btn-lg" style="margin-top: 20px;">
                                    <i class="fa fa-plus"></i> Add Your First Agent
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include('footer.php'); ?>

<!-- DataTables -->
<link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>

<script>
$(function () {
    $("#example1").DataTable();
});

function deleteAgent(id) {
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
            document.location.href = 'delete_agent.php?id=' + id;
        }
    });
}
</script> 