<?php


  $berichten    =   array();
  $titel        =   'Aanmelden - bootstrap';
  $toegevoegd = '';
  var_dump($_POST);

  include('header.php');
  
  if ((isset($_POST['verstuur']))) 
  {
  
  	$email  =   $_POST['user_name'];
  	$wachtwoord = $_POST['password'];
	
  	$_SESSION['registratie']['gebruikersnaam']  =   $email;
  	$_SESSION['registratie']['password']   		=   $wachtwoord;

  	$query  =   "SELECT *
  	             FROM gebruikers_bootstrap ";
	
  	$statement = $db->prepare( $query );
  	$statement->execute( );

  	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
  	{
  	  $gebruikers[]   = $row;
  	}
  	var_dump($gebruikers);

   }

?>

<h1><?= $titel ?></h1>
<div class="col-md-7">
  <h2>Ben je al lid?</h2>

  <form name="login" method="post" action="<?= $_SERVER['PHP_SELF']?>">
    <fieldset>
      <div class="form-group">
        <label class="col-md-2 control-label" for="gebruikersnaam">Gebruikersnaam</label>
        <div class="col-md-9">
          <input class="form-control" type="text" name="user_name" value="">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label" for="wachtwoord">Wachtwoord</label>
        <div class="col-md-9">
          <input class="form-control" type="password" name="password" value="">
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-12 text-left">
          <button class="btn btn-primary" type="submit" name="verstuur">Inloggen</button>
        </div>
      </div>
    </fieldset>
  </form>
</div>
  

<div class="col-md-5">
  <h2>Bent u nieuw op deze site?</h2>
  <div>
    <p>Laat je dan <a href="registreren.php">hier</a> registreren.</p>
  </div>
 
  </div>
</div>
</div>



<?php include('footer.php') ?>

