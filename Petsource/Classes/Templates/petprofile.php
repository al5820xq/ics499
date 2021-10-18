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
			<h3>options</h3>
		</div>
	</div>