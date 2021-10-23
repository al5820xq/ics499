    <hr>
	<div class="row">
		<div class="col-4">
        <h4>Animal Type: <?php echo $this->animal; ?></h4>
        <h5>Name: <?php echo $this->name; ?></h5>
        <h5>Color: <?php echo $this->color; ?></h5>
        <h5>ID: <?php echo strval($this->petID); ?></h5>
		</div>
		<div class="col-4">
            <img src="<?php echo $this->imgsrc(); ?>" width="50mm">
		</div>
		<div class="col-4">
            <img src="<?php echo $this->qrsrc(); ?>" width="50mm">
		</div>
		<div class="col-4">
			<h3><a href="poster.php?petid=<?php echo $this->petID; ?>">Missing Pet</a></h3>
			<h3><a href="search.php?petid=<?php echo $this->petID; ?>">Not Ready Yet</a></h3>
		</div>
	</div>