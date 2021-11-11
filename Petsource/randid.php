<?php
require_once "Classes/DBController.php";
$id = DBController::newPetID();
echo($id);
echo(DBController::isPet($id) ? 'true' : 'false');
echo(DBController::isPet("15t83Ib9LW") ? 'true' : 'false');
echo(DBController::isPet("15t83Ib9lW") ? 'true' : 'false');
?>