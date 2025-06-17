<?php
include('header.php');
include('../../config.php');

if (!isset($_GET['id'])) {
    header('Location: agent.php');
    exit();
}

$id = mysqli_real_escape_string($con, $_GET['id']);
$query = "SELECT * FROM tbl_users WHERE id = '$id'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) == 0) {
    header('Location: agent.php');
    exit();
}

$agent = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $age = mysqli_real_escape_string($con, $_POST['age']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    
    // Check if email already exists for other users
    $check_email = mysqli_query($con, "SELECT * FROM tbl_users WHERE email = '$email' AND id != '$id'");
    if (mysqli_num_rows($check_email) > 0) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Email already exists!',
                showConfirmButton: true
            });
        </script>";
    } else {
        $query = "UPDATE tbl_users SET 
                 name = '$name',
                 age = '$age',
                 gender = '$gender',
                 mobile_number = '$mobile',
                 email = '$email'";
        
        // Update password only if provided
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $query .= ", password = '$password'";
        }
        
        $query .= " WHERE id = '$id'";
        
        if (mysqli_query($con, $query)) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Agent updated successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location = 'agent.php';
                });
            </script>";
            exit();
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Error updating agent: " . mysqli_error($con) . "',
                    showConfirmButton: true
                });
            </script>";
        }
    }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Agent
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="agent.php">Agent Management</a></li>
            <li class="active">Edit Agent</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Agent</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="POST" id="editAgentForm">
                        <div class="box-body">
                            <?php if(isset($error)) { ?>
                                <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php } ?>
                            
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $agent['name']; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="number" class="form-control" id="age" name="age" min="18" max="100" value="<?php echo $agent['age']; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" <?php echo ($agent['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo ($agent['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                    <option value="Other" <?php echo ($agent['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="mobile">Mobile Number</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $agent['mobile_number']; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $agent['email']; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="password">New Password (leave blank to keep current)</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="agent.php" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include('footer.php'); ?>

<script>
$(document).ready(function() {
    $('#editAgentForm').bootstrapValidator({
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'Name is required'
                    }
                }
            },
            age: {
                validators: {
                    notEmpty: {
                        message: 'Age is required'
                    },
                    between: {
                        min: 18,
                        max: 100,
                        message: 'Age must be between 18 and 100'
                    }
                }
            },
            gender: {
                validators: {
                    notEmpty: {
                        message: 'Gender is required'
                    }
                }
            },
            mobile: {
                validators: {
                    notEmpty: {
                        message: 'Mobile number is required'
                    },
                    regexp: {
                        regexp: /^[0-9]{10}$/,
                        message: 'Please enter a valid 10-digit mobile number'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'Email is required'
                    },
                    emailAddress: {
                        message: 'Please enter a valid email address'
                    }
                }
            },
            password: {
                validators: {
                    stringLength: {
                        min: 6,
                        message: 'Password must be at least 6 characters long'
                    }
                }
            }
        }
    });
});
</script> 