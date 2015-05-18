<?php

	session_start();

    function __autoload( $classname )
    {
        require_once( $classname . '.php' );
    }

    $db = new PDO('mysql:host=localhost;dbname=personeelsfeest', 'root', '');
    $mail  =    $_SESSION['registratie']['mail'];
    $bestellen   =   'bestellen.php';
    $message    =   Message::getMessage();
    $gebruikers_type = $_SESSION['gebruikers']['type'];

    $query  =   "SELECT*
				FROM gerechten
                WHERE type = 'voorgerecht'";

    $statement = $db->prepare($query);
    $statement->execute();
    while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
    {
        $voorgerecht[] =   $row; 
    }

    $query  =   "SELECT*
                FROM gerechten
                WHERE type = 'hoofdgerecht'";

    $statement = $db->prepare($query);
    $statement->execute();
    while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
    {
        $hoofdgerecht[] =   $row; 
    }

    $query  =   "SELECT*
                FROM gerechten
                WHERE type = 'dessert'";

    $statement = $db->prepare($query);
    $statement->execute();
    while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
    {
        $dessert[] =   $row; 
    }

    $query  =   'SELECT *
                    FROM personeel
                    WHERE mailadres = "'. $mail.'"';

    $statement = $db->prepare($query);
    $statement->execute();

    while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
    {
        $gebruiker[] =   $row; 
    }

    if (isset($_POST['bestellen']))
    {
        $voornaam  =   $_POST['voornaam'];
        $familienaam = $_POST['familienaam'];
        $email  =   $_POST['email'];
        $voorgerecht = $_POST['voorgerecht'];
        $hoofdgerecht = $_POST['hoofdgerecht'];
        $dessert = $_POST['dessert'];
        $id = $_POST['id'];

        if ((!isset($_POST['voorgerecht'])) && (!isset($_POST['hoofdgerecht'])) && (!isset($_POST['dessert']))) 
        {
            $userExistsError = new Message( "error", "Kies een voorgerecht, hoofdgerecht en dessert." ); 
            header('location: ' . $bestellen );
        }

        elseif ($gebruiker[0]['id'] === $id) 
        {
            $bestelling_wijzigen = 'UPDATE menukeuze
                                    SET voorgerecht = :voorgerecht,
                                        hoofdgerecht = :hoofdgerecht,
                                        dessert     = :dessert
                                    WHERE id_personeel = :id_personeel
                                    LIMIT 1';

            $statement = $db->prepare( $bestelling_wijzigen );
            
            $statement->bindValue(':id_personeel', $_POST['id']);
            $statement->bindValue(':voorgerecht', $_POST['voorgerecht']);
            $statement->bindValue(':hoofdgerecht', $_POST['hoofdgerecht']);
            $statement->bindValue(':dessert', $_POST['dessert']);


            $statement->execute( );

            $registrationSuccess = new Message("success", "Uw bestelling werd aangepast.");
            header('location: dashboard.php');
        }

        else
        {
        	$nieuwe_bestelling   =   'INSERT INTO menukeuze (id_personeel, voorgerecht, hoofdgerecht, dessert)
                                                    VALUES (:id_personeel, :voorgerecht, :hoofdgerecht, :dessert) ';

            $statement  =   $db->prepare($nieuwe_bestelling);

            $statement->bindValue(':id_personeel', $_POST['id']);
            $statement->bindValue(':voorgerecht', $_POST['voorgerecht']);
            $statement->bindValue(':hoofdgerecht', $_POST['hoofdgerecht']);
            $statement->bindValue(':dessert', $_POST['dessert']);

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
        <title>Bestellen - Personeelsfeest</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body class="web-backend-opdracht">
        
        <section class="body">
            
            <h1>Personeelsfeest</h1>

            <h2>Bestellen</h2>

             <p>U bent ingelogd als "<?= $gebruiker[0]['voornaam'] ?> <?= $gebruiker[0]['familienaam'] ?>" (<?= $gebruikers_type ?>) | <a href="logout.php">Uitloggen</a> </p>
            <p>Terug naar <a href="dashboard.php">dashboard</a>.</p>
            
            <?php if ( $message ): ?>
                <div class="modal <?= $message['type'] ?>">
                    <?= $message['text'] ?>
                </div>
            <?php endif ?>

            <form method="POST" action="bestellen.php">
            	<input type="hidden" name="id" id="id" value="<?= $gebruiker[0]['id'] ?>">
            	<label for="voornaam">Voornaam:</label>

            		<input type="text" name="voornaam" id="voornaam" value="<?= $gebruiker[0]['voornaam'] ?>">

            	<label for="familienaam">Familienaam:</label>
            		<input type="text" name="familienaam" id="familienaam" value="<?= $gebruiker[0]['familienaam'] ?>">

            	<label for="email">E-mailadres:</label>
            		<input type="text" name="email" id="email" value="<?= $gebruiker[0]['mailadres'] ?>">


				<label for="voorgerecht">Voorgerecht:</label>
                    <select name="voorgerecht">
                         <?php foreach ($voorgerecht as $value): ?>
                            <option value="<?= $value['naam_gerecht'] ?>"><?= $value['naam_gerecht'] ?></option>
                        <?php endforeach ?>
                    </select>
  

                <label for="hoofdgerecht">Hoofdgerecht:</label>
                    <select name="hoofdgerecht">
                         <?php foreach ($hoofdgerecht as $value): ?>
                            <option value="<?= $value['naam_gerecht'] ?>"><?= $value['naam_gerecht'] ?></option>
                        <?php endforeach ?>
                    </select>



                <label for="dessert">Dessert:</label>
                    <select name="dessert">
                         <?php foreach ($dessert as $value): ?>
                            <option value="<?= $value['naam_gerecht'] ?>"><?= $value['naam_gerecht'] ?></option>
                        <?php endforeach ?>
                    </select>



				<input type="submit" name="bestellen" value="bestellen" id="bestellen">

            </form>

        </section>
        
    </body>
</html>
