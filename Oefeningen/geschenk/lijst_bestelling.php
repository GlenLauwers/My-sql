<?php

	session_start();

    function __autoload( $classname )
    {
        require_once( $classname . '.php' );
    }

    $db = new PDO('mysql:host=localhost;dbname=Geschenk', 'root', '');
    $gebruikersnaam  =    $_SESSION['registratie']['gebruikersnaam'];
    $gebruikers_type = '';
    
    $message    =   Message::getMessage();
    $gebruikers_type = $_SESSION['gebruikers']['type'];

    $query  =   'SELECT personeel.gebruikersnaam, personeel.voornaam, personeel.familienaam, personeel.email, producten.product_naam
    				FROM personeel
    					INNER JOIN geschenken ON personeel.id = geschenken.personeel_id 
    					INNER JOIN producten on geschenken.product_id = producten.product_id
    				';

    $statement = $db->prepare($query);
    $statement->execute();

    while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
    {
        $personeel[] =   $row; 
    }



    if ($gebruikers_type === 'Gebruiker') 
    {
    	$userExistsError = new Message( "error", "U hebt geen bevoegdheid om op deze pagina te komen." ); 
    	header('location: dashboard.php');
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

            <p>U bent ingelogd als "<?= $gebruikersnaam ?>" (<?= $gebruikers_type ?>) | <a href="logout.php">Uitloggen</a> </p>
            <p>Terug naar <a href="dashboard.php">dashboard</a>.</p>

            <?php if ( $message ): ?>
                <div class="modal <?= $message['type'] ?>">
                    <?= $message['text'] ?>
                </div>
            <?php endif ?>

            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <table>
                    <thead>
                        <tr>
                            <th>Gebruikersnaam</th>
                            <th>Voornaam</th>
                            <th>Familienaam</th>
                            <th>E-mailadres</th>
                            <th>Product</th>
                        </tr>
                    </thead>
        
                    <tbody>
                        <?php foreach ($personeel as $key => $value): ?>
                            <tr>
                            	<?php foreach ($value as $key => $value): ?>
                            		<td><?= $value ?></td>
                            	<?php endforeach ?>    
                            </tr>
                        <?php endforeach ?>                        
                    </tbody>       
                </table>
            </form>
        
        </section>
        
    </body>
</html>