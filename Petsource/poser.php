<?php
//classes

use Dompdf\Dompdf;

include_once("Classes/Profile.php");
require_once('dompdf/autoload.inc.php');
use Dompdf\Options;
session_start();

// Store data in session variables
$username = $_SESSION["username"];                            
$password = $_SESSION["password"];
$profile = unserialize($_SESSION["profile"]);
if (DBController::isUser($username, $password) && isset($_GET["petid"])) {
    $pet = $profile->getPet($_GET["petid"]);
    if (is_null($pet)) {
        header("Location: login.php");
    } else {
        //ob_start();
        include("Classes/Templates/lostpet.php");
        /*$output = ob_get_clean();
        //echo $output;

        //use Dompdf\Dompdf;
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $contxt = stream_context_create([ 
            'ssl' => [ 
                'verify_peer' => FALSE, 
                'verify_peer_name' => FALSE,
                'allow_self_signed'=> TRUE
            ] 
        ]);
        $document = new Dompdf($options);
        $document->setHttpContext($contxt);
        $document->loadHtml($output);
        $document->setPaper('A4', 'portrait');
        $document->render();
        $document->stream("Pet Flyer", array("Attachment"=>0));*/

    }
} else {
    echo('<h1>Not logged in</h1>');
    header("Location: login.php");
}