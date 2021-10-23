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
<div class="small-container2">
    <div class="col-1"> 
        <h1 class="title">Message Owner?</h1>
        <?php echo $petSentence; ?>
        <img src="<?php echo $guest->getImg(); ?>" width="100%">
        <br>
    </div>    
</div>

<div class="small-container2">
<form action="sent.php" method="post">
    <div class="form-group">
        <label>Message</label> 
        <br>
        <textarea class="messageBox" name="message">Dear owner, </textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Send" name="send">
    </div>
</form>
</div>