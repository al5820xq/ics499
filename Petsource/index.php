<?php
include("Classes/Templates/style.php");
include("Classes/Templates/header.html");
?>

<!---------- Featured Categories ---------->
    <div class="categories">
		<div class="small-container">
			<div class="row">
				<h1 class="title">Welcome to PetSource!</h1>
				<p>Where you can keep track of your pet's vital information, and feel comfortable knowing that in the unfortunate event that your animal goes missing, there is a way for someone to contact you!</p>
			</div>
		</div>
		
	</div>

<!-------- Featured Products --------->
	<div class="small-container">
		<h2 class="title">Featured Pets</h2>
		<div class="row">
			<div class="col-4">
				<img src="images/dog1.jpg">
				<h4>Frank</h4>
			</div>
			<div class="col-4">
				<img src="images/cat1.jpg">
				<h4>Ms. Fluffles</h4>

			</div>
			<div class="col-4">
				<img src="images/hhog1.jpg">
				<h4>Spike</h4>

			</div>
			<div class="col-4">
				<img src="images/dog2.jpg">
				<h4>Bingo</h4>

			</div>
		</div>
		
		
	</div>
<?php
include("Classes/Templates/footer.html");
?>