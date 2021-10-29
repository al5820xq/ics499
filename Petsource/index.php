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
			<?php
			include("Classes/DBController.php");
			$maxID = DBController::maxPetID();
			$display = 0;
			while ($display < 4) {
				$petID = rand(1, $maxID);
				$pet = DBController::getPet($petID);
				if (!is_null($pet)) {
					$display++;
					$name = $pet->getName();
					$picture = $pet->imgsrc();
					include("Classes/Templates/featurepet.php");
				}
			}
			?>
		</div>
		
		
	</div>
<?php
include("Classes/Templates/footer.html");
?>