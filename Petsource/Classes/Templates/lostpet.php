<?php
function convertDefault() {
    $opciones_ssl=array(
        "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
        ),
        );
    $img_path = "Classes/Templates/images/defaultpet.jpg";
    $extencion = pathinfo($img_path, PATHINFO_EXTENSION);
    $data = file_get_contents($img_path, false, stream_context_create($opciones_ssl));
    $img_base_64 = base64_encode($data);
    return 'data:image/'  . $extencion . ';base64,' . $img_base_64;
}
?>
<html>
    <style>
        h1{
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            font-size: 800%;
            font-stretch: ultra-expanded;
            text-align: center;
            margin-bottom: 5mm;
            margin-top: 0;
        }
        .center {
            text-align: center;
        }
        .center img{
            display: block;
            height: 90mm;
        }
        h3{
            font-family: sans-serif;
            font-stretch: ultra-expanded;
            text-align: left;
            font-size: 9mm;
            margin-top: 1;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        h4{
            font-family: sans-serif;
            font-stretch: ultra-expanded;
            text-align: left;
            font-size: 7mm;
            margin-top: 0;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .text{
            display: block;
            margin-top: 0mm;
            margin-left: auto;
            margin-right: auto;
            width: 70%;
        }
        h2{
            font-family: sans-serif;
            font-stretch: ultra-expanded;
            text-align: center;
            font-size: 9mm;
            margin-top: 0;
            margin-bottom: 0;
            padding-bottom: 0;
        }
    </style>
    <h1>Lost <?php echo $animal; ?></h1>
        <div class="center">
            <img src="<?php echo ($pet->imgsrc() == "Classes/Templates/images/defaultpet.png") ? convertDefault() : $pet->imgsrc(); ?>">
        </div>
        
    <div class="text">
        <h3>Name: <?php echo $name; ?></h3>
        <h3>Color: <?php echo $color; ?></h3>
        <h3>Lives In: <?php echo $location; ?></h3>
        <hr>
        <h4>Description: If you see Spot please call me. Spot is a very calm dog and is only a puppy.</h4>
        <hr>
        <h2><?php echo $phone; ?></h2>
        <h2><?php echo $email; ?></h2>
    </div>
    
</html>