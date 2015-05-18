<?php

    session_start();

    function __autoload( $classname )
    {
        require_once( $classname . '.php' );
    }

    try
    {
        $db = new PDO('mysql:host=localhost;dbname=phpoefening030', 'root', '');
       
        $message    =   Message::getMessage();
        $email  =    $_SESSION['registratie']['email'];
        $gebruikers_type = $_SESSION['gebruikers']['type'];

        
        
        if (isset($_POST['wijzigen_gebruiker'])) 
        { 
        $update_artikel    =   'UPDATE users
                                SET     email       =   :email,
                                        password       =   :password
                                WHERE id     =   :id';
        $statement = $db->prepare( $update_artikel );
        
        $statement->bindValue(":id", $_POST['id']);
        $statement->bindValue(":email", $_POST['email']);                      
        $statement->bindValue(":password", $_POST['password']); 

        $gedaan = $statement->execute( );
        if ($gedaan) 
        {
            $bewerk = new Message( "success", "De database is bewerkt." );
            header('location: gegevens.php');
        }
        else
        {
            $bewerk = new Message( "error", "De database is niet bewerkt. Probeer opnieuw" ); 
            header('location: gegevens.php');
            
        }
        

        if (!isset($_COOKIE['authenticated'])) 
        {
            header('location: index.php');
        }
    }
    }

    catch ( PDOException $e )
    {
        $bericht    =   'Er ging iets mis bij het inladen van de database: "' . $e->getMessage().'"';
    }

?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Oplossing CRUD: CMS</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body class="web-backend-opdracht">
        
        <section class="body">
            
            <h1>Oplossing CRUD: CMS</h1>

            <h2>Gegevens</h2>

            <p>U bent ingelogd als "<?= $email ?>" (<?= $gebruikers_type ?>) | <a href="logout.php">Uitloggen</a> </p>

            <?php if ( $message ): ?>
                <div class="modal <?= $message['type'] ?>">
                    <?= $message['text'] ?>
                </div>
            <?php endif ?>

            <p>Terug naar <a href="dashboard.php">dashboard</a>.</p>

            <h3>Mijn gegevens aanpassen</h3>
            
            <form action="<?= $_SERVER[ 'PHP_SELF' ] ?>" method="POST">
                <input type="hidden" name="id" id="id" >
            
                <label for="email">E-mailadres:</label>
                    <input type="text" name="email" id="email">
            
                <label for="password">Wachtwoord: </label>
                    <input type="password" name="password" id="password">

                <input type="submit" name="wijzigen_gebruiker" value="Wijzigen">
                </form>

        </section>
        
    </body>
</html>