<?php
include('header.php');
include('../../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $age = mysqli_real_escape_string($con, $_POST['age']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check_email = mysqli_query($con, "SELECT * FROM tbl_users WHERE email = '$email'");
    if (mysqli_num_rows($check_email) > 0) {
        $error = "Email already exists!";
    } else {
        $query = "INSERT INTO tbl_users (name, age, gender, mobile_number, email, password) 
                 VALUES ('$name', '$age', '$gender', '$mobile', '$email', '$password')";
        
        if (mysqli_query($con, $query)) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Agent added successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = 'agent.php';
                });
            </script>";
        } else {
            $error = "Error adding agent: " . mysqli_error($con);
        }
    }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add New Agent
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="agent.php">Agent Management</a></li>
            <li class="active">Add Agent</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add New Agent</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="POST" id="addAgentForm">
                        <div class="box-body">
                            <?php if(isset($error)) { ?>
                                <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php } ?>
                            
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="number" class="form-control" id="age" name="age" min="18" max="100" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="mobile">Mobile Number</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
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
    $('#addAgentForm').bootstrapValidator({
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
                    notEmpty: {
                        message: 'Password is required'
                    },
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