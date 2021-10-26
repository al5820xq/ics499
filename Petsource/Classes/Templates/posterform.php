<style>
    .messageBox {
    	width: 100%;
    	height: 150px;
    	padding: 12px 20px;
    	box-sizing: border-box;
    	border: 2px solid #ccc;
    	border-radius: 8px;
    	background-color: #f8f8f8;
    	font-size: 16px;
    	resize: none;
    }
</style>
<h1 class="title">Lost Pet Poster Builder</h1>
<div class="small-container2">
    <h1>Lost <?php echo $animal; ?></h1>
        <div class="center">
            <img src="<?php echo $pet->imgsrc(); ?>">
        </div>
        
    <div class="col-2">
        <h3>Name: <?php echo $name; ?></h3>
        <h3>Color: <?php echo $color; ?></h3>
        <h3>Lives In: <?php echo $location; ?></h3>
        <hr>
        <h4>Description: ...</h4>
        <hr>
        <h2><?php echo $phone; ?></h2>
        <h2><?php echo $email; ?></h2>
    </div>
</div>


<form action="poster.php?petid=<?php echo $_GET['petid']; ?>" method="post">
    <div class="form-group">
        <label>Description</label> 
        <br>
        <textarea class="messageBox" name="description">If you see <?php echo $name; ?> </textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Build" name="build">
    </div>
</form>