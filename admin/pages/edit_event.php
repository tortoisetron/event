<?php
include('header.php');
include('../../config.php');
include('../../form.php');
$frm = new formBuilder;

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$event = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tbl_movie WHERE movie_id='$id'"));
if (!$event) {
    echo '<div class="alert alert-danger">Event not found.</div>';
    include('footer.php');
    exit;
}
?>
<link rel="stylesheet" href="../../validation/dist/css/bootstrapValidator.css"/>
<script type="text/javascript" src="../../validation/dist/js/bootstrapValidator.js"></script>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Edit Event</h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
      <li class="active">Edit Event</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-body">
        <form action="process_edit_event.php" method="post" enctype="multipart/form-data" id="form1">
          <input type="hidden" name="id" value="<?php echo $event['movie_id']; ?>">
          <div class="form-group">
            <label class="control-label">Event Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($event['movie_name']); ?>"/>
            <?php $frm->validate("name",array("required","label"=>"Event Name")); ?>
          </div>
          <div class="form-group">
            <label class="control-label">Event Description</label>
            <textarea name="desc" class="form-control"><?php echo htmlspecialchars($event['desc']); ?></textarea>
            <?php $frm->validate("desc",array("required","label"=>"Description")); ?>
          </div>
          <div class="form-group">
            <label class="control-label">Event Date</label>
            <input type="date" name="rdate" class="form-control" value="<?php echo $event['release_date']; ?>"/>
            <?php $frm->validate("rdate",array("required","label"=>"Event Date")); ?>
          </div>
          <div class="form-group">
            <label class="control-label">Event Image</label>
            <input type="file" name="image" class="form-control"/>
            <img src="../../<?php echo $event['image']; ?>" alt="Current Image" style="max-width:100px; margin-top:10px;"/>
            <input type="hidden" name="old_image" value="<?php echo $event['image']; ?>">
            <?php $frm->validate("image",array("label"=>"Image")); ?>
          </div>
          <div class="form-group">
            <label class="control-label">Event Video URL</label>
            <input type="text" name="video" class="form-control" value="<?php echo htmlspecialchars($event['video_url']); ?>"/>
            <?php $frm->validate("video",array("label"=>"Video URL","max"=>"500")); ?>
          </div>
          <div class="form-group">
            <button class="btn btn-primary">Update Event</button>
            <a href="index.php" class="btn btn-default">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>
<script>
<?php $frm->applyvalidations("form1");?>
</script>
<?php include('footer.php'); ?> 