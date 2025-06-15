	<?php include('header.php');?>
	</div>
	<div class="content">
		<div class="wrap">
			<div class="content-top">
				<center><h1 style="color:#555;">(Upcoming Events)</h1></center>
				
				<div class="row">
    <?php
    $today = date("Y-m-d");
    $qry2 = mysqli_query($con, "SELECT * FROM tbl_movie");
    while ($m = mysqli_fetch_array($qry2)) {
    ?>
        <div class="col-lg-4 col-md-6 col-sm-12" style="margin-bottom: 20px;">
            <div class="card" style="box-shadow:0 2px 8px #eee; border-radius:8px; overflow:hidden; height:100%;">
                <img src="<?php echo $m['image']; ?>" alt="<?php echo htmlspecialchars($m['movie_name']); ?>" class="img-responsive" style="width:100%; height:180px; object-fit:cover;">
                <div class="card-body" style="padding:15px;">
                    <h4 style="font-size:18px; font-weight:bold; color:#333; margin-bottom:10px;"><?php echo htmlspecialchars($m['movie_name']); ?></h4>
                    <div style="font-size:14px; color:#666; margin-bottom:10px; min-height:40px;">
                        <?php echo mb_strimwidth(strip_tags($m['desc']), 0, 60, '...'); ?>
                    </div>
                    <a href="about.php?id=<?php echo $m['movie_id']; ?>" class="btn btn-primary btn-sm" style="width:100%;">View Details</a>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>
					<div class="clear"></div>		
				</div>
				<?php include('footer.php');?>