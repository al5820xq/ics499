<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<?php
include("Classes/Templates/style.php");
include("Classes/Templates/header.html");
?>

<!---------- Featured Categories ---------->
<div class="categories">
	<div class="small-container">
		<div class="row">
			<h1 class="title">Welcome to PetSource!</h1>
		</div>
		<p class="w3-large w3-center">So when your pets get lost, they have the best chance to find their way home.</p>
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
			$pet = DBController::getPetByID($petID);
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
