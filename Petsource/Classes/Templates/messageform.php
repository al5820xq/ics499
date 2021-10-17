<div class="small-container2">
    <div class="col-1"> 
        <h1 class="title">Message Owner?</h1>
        <?php echo $petSentence; ?>
        <br>
    </div>    

</div>
<div class="small-container2">

<form action="sent.php" method="post">
    <div class="form-group">
        <label>Pet ID</label>
        <textarea class="messageBox" name="message">Dear owner, </textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Send" name="send">
    </div>
</form>
</div>