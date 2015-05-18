<?php

	session_start();

    function __autoload( $classname )
    {
        require_once( $classname . '.php' );
    }

    $db = new PDO('mysql:host=localhost;dbname=Geschenk', 'root', '');
    $gebruikersnaam  =    $_SESSION['registratie']['gebruikersnaam'];
    $bestellen   =   'bestellen.php';
    $message    =   Message::getMessage();
    $gebruikers_type = $_SESSION['gebruikers']['type'];

    $query  =   'SELECT *
    				FROM personeel
    					INNER JOIN geschenken ON personeel.id = geschenken.personeel_id 
    					INNER JOIN producten on geschenken.product_id = producten.product_id
    				WHERE gebruikersnaam = "'. $gebruikersnaam.'"';

    $statement = $db->prepare($query);
    $statement->execute();

    while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
    {
        $personeel[] =   $row; 
    }

    $query  =   'SELECT*
				FROM producten';

    $statement = $db->prepare($query);
    $statement->execute();
    while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
    {
        $producten[] =   $row; 
    }

    $query  =   'SELECT *
                	FROM personeel
                	WHERE gebruikersnaam = "'. $gebruikersnaam.'"';

    $statement = $db->prepare($query);
    $statement->execute();

    while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
    {
        $gebruikers[] =   $row; 
    }

    if (isset($_POST['bestellen']))
    {
        var_dump($gebruikers);
        $voornaam  =   $_POST['voornaam'];
        $familienaam = $_POST['familienaam'];
        $email  =   $_POST['email'];
        $product = $_POST['product'];
        $id = $_POST['id'];

        if (!isset($_POST['product'])) 
        {
            $userExistsError = new Message( "error", "U hebt geen product gekozen." ); 
            header('location: ' . $bestellen );
        }

        elseif ($personeel[0]['personeel_id'] === $id) 
        {
            $bestelling_wijzigen = 'UPDATE geschenken
                                    SET  product_id       =   :product_id
                                    WHERE personeel_id = :gebruikersnaam
                                    LIMIT 1';

            $statement = $db->prepare( $bestelling_wijzigen );
            
            $statement->bindValue(":product_id", $_POST['product']);                      
            $statement->bindValue(":gebruikersnaam", $_POST['id']);


            $statement->execute( );

	     	$registrationSuccess = new Message("success", "Uw bestelling werd aangepast.");
            header('location: dashboard.php');
        }

        else
        {
        	$nieuwe_bestelling   =   'INSERT INTO geschenken (product_id, :personeel_id)
                                                    VALUES (personeel_id, :personeel_id) ';

            $statement  =   $db->prepare($nieuwe_bestelling);

            $statement->bindValue(':product_id', $_POST['product']);
            $statement->bindValue(':personeel_id', $_POST['id']);

            $statement->execute( );

            $registrationSuccess = new Message("success", "Uw bestelling is geplaatst");
            header('location: dashboard.php');

        }
    }

    if (!isset($_COOKIE['authenticated'])) 
        {
            header('location: index.php');
        }
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Geschenken</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body class="web-backend-opdracht">
        
        <section class="body">
            
            <h1>Geschenken</h1>

            <h2>Bestellen</h2>

            <p>U bent ingelogd als "<?= $gebruikersnaam ?>" (<?= $gebruikers_type ?>) | <a href="logout.php">Uitloggen</a> </p>
            <p>Terug naar <a href="dashboard.php">dashboard</a>.</p>
            
            <?php if ( $message ): ?>
                <div class="modal <?= $message['type'] ?>">
                    <?= $message['text'] ?>
                </div>
            <?php endif ?>

            <form method="POST" action="bestellen.php">
            	<input type="hidden" name="id" id="id" value="<?= $gebruikers[0]['id'] ?>">
            	<label for="voornaam">Voornaam:</label>
            		<input type="text" name="voornaam" id="voornaam" value="<?= $gebruikers[0]['voornaam'] ?>">

            	<label for="familienaam">Familienaam:</label>
            		<input type="text" name="familienaam" id="familienaam" value="<?= $gebruikers[0]['familienaam'] ?>">

            	<label for="email">E-mailadres:</label>
            		<input type="text" name="email" id="email" value="<?= $gebruikers[0]['email'] ?>">

				<?php foreach ($producten as $value): ?>
					<label for="product"><?= $value['product_naam'] ?></label>
						<input type="radio" name="product" value="<?= $value['product_id'] ?>">
				<?php endforeach ?>
            		<label for="product"></label>
            			
				<input type="submit" name="bestellen" value="bestellen" id="bestellen">

            </form>

        </section>
        
    </body>
</html>
