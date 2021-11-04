<div class="small-container2">
    <div class="col-1"> 
        <h1 class="title">Pet Search</h1>
        <p>Please enter the pet ID you wish to search.</p><br>
    </div>    

</div>
<div class="small-container2">

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
    <div class="form-group">
        <label>Pet ID</label>
        <input type="text" name="petid" class="form-control" value="<?php echo $petid; ?>">
        <p class="input_error"><?php echo $petid_err; ?></p>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Search">
    </div>
</form>
</div>