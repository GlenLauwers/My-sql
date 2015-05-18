<?php
	$titel        =   'Registreren - bootstrap';
	$registratieformulier   =   'registreren.php';

	include('header.php');

	if (isset($_POST['opslaan'])) 
	{
		$gebruikersnaam  = $_POST['gebruikersnaam'];
        $wachtwoord 	 = $_POST['wachtwoord'];
        $email 			 = $_POST['email'];

        $_SESSION['registratie']['email']        =   $gebruikersnaam;
        $_SESSION['registratie']['wachtwoord']   =   $wachtwoord;

        $isEmail    =   filter_var( $email, FILTER_VALIDATE_EMAIL );

        if (!$isEmail)
        {
            $emailError = new Message( "error", "Dit is geen geldig e-mailadres. Vul een geldig e-mailadres in." ); 
            header('location: ' . $registratieformulier );
        }
        if (empty($email)) 
        {
            $emailError = new Message( "error", "Er is geen E-mailadres ingevuld." ); 
            header('location: ' . $registratieformulier );
        }
        if (empty($wachtwoord)) 
        {
            $emailError = new Message( "error", "Er is geen wachtwoord ingevuld." ); 
            header('location: ' . $registratieformulier );
        }
        if ((empty($wachtwoord)) && (empty($email))) 
        {
            $emailError = new Message( "error", "Vul je gegevens in." ); 
            header('location: ' . $registratieformulier );
        }
        
        else
        { 
            $query  =   'SELECT *
                            FROM gebruikers_bootstrap
                            WHERE gebruikersnaam = "'. $gebruikersnaam.'"';
            $statement = $db->prepare($query);
            $statement->execute();
            while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
            {
                $gebruikers[] =   $row; 
            }

            if ($gebruikers[0]['gebruikersnaam'] === $gebruikersnaam) 
            {
                $userExistsError = new Message( "error", "De gebruiker komt reeds voor in onze database." ); 
                header('location: ' . $registratieformulier );
            }
            /*else
            {
                $hashed_wachtwoord =   hash( 'sha512', $wachtwoord );
                $nieuwe_gebruiker   =   'INSERT INTO gebruikers_bootstrap (email, password, user_type, last_login)
                                        VALUES (:email, :password, 2, NOW()) ';
                $statement  =   $db->prepare($nieuwe_gebruiker);
   
                $statement->bindValue(':email', $email);
                $statement->bindValue(':password', $hashed_wachtwoord);
                $statement->execute( );
                $registrationSuccess = new Message("success", "Welkom, u bent vanaf nu geregistreerd in onze app.");
                header('location: dashboard.php');
                $hashedEmail    =   hash( 'sha512', $email );
                $cookieValue    =   $email . '##' . $hashedEmail;
                $cookie =   setcookie( 'authenticated', $cookieValue, time() + 3600 );
             }*/

		}
	}


?>

<h1><?= $titel ?></h1>

<?php if ( $message ): ?>
                <div class="modal <?= $message['type'] ?>">
                    <?= $message['text'] ?>
                </div>
            <?php endif ?>

<div id="registratieformulier">
      <form method="post" action="<?= $_SERVER['PHP_SELF']?>" name="formulier" onsubmit="return (valideren())">
        <div class="row">
          <div class="col-md-6"><p>Voornaam:<br>
            <input class="form-control" type="text" name="voornaam" style="width: 100%"></p>
          </div>

          <div class="col-md-6"><p>Familienaam:<br>
            <input class="form-control" type="text" name="familienaam" style="width: 100%"></p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6"><p>Email:<br>
            <input class="form-control" type="text" name="email" style="width: 100%"></p>
          </div>

          <div class="col-md-6"><p>Gebruikersnaam:<br>
            <input class="form-control" type="text" name="gebruikersnaam" style="width: 100%"></p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6"><p>Wachtwoord:<br>
            <input class="form-control" type="password" name="wachtwoord" style="width: 100%"></p>
          </div>
        </div>

        <div class="col-md-6">
          <input class="btn btn-primary" type="submit" name="opslaan" value="Opslaan">  
        </div>
       </div>
    </form>
	
</form>