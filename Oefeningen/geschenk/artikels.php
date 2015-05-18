<?php

    session_start();

    function __autoload( $classname )
    {
        require_once( $classname . '.php' );
    }

    try
    {
        $db = new PDO('mysql:host=localhost;dbname=Geschenk', 'root', '');
        $artikel = array();
        
        $message    =   Message::getMessage();
        $gebruikersnaam  =    $_SESSION['registratie']['gebruikersnaam'];
        $gebruikers_type = $_SESSION['gebruikers']['type'];

        $query  =   'SELECT *
                    FROM producten
                    ';

    $statement = $db->prepare($query);
    $statement->execute();

    while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
    {
        $artikel[] =   $row; 
    }

    var_dump($artikel);

        
        if ($gebruikers_type === 'Gebruiker') 
        {
            $userExistsError = new Message( "error", "U hebt geen bevoegdheid om op deze pagina te komen." ); 
            header('location: dashboard.php');
        }

        if (!isset($_COOKIE['authenticated'])) 
        {
            header('location: index.php');
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

            <h2>Artikels</h2>

             <p>U bent ingelogd als "<?= $gebruikersnaam ?>" (<?= $gebruikers_type ?>) | <a href="logout.php">Uitloggen</a> </p>
             <p>Terug naar <a href="dashboard.php">dashboard</a>.</p>

            <?php if ( $message ): ?>
                <div class="modal <?= $message['type'] ?>">
                    <?= $message['text'] ?>
                </div>
            <?php endif ?>

                <form action="<?= $_SERVER[ 'PHP_SELF' ] ?>" method="POST">
                    <button class="nieuwartikel" type="submit" id="nieuw_artikel" name="nieuw_artikel">Nieuw artikel toevoegen</button>
                </form>

            
            <div class="links">
                <?php foreach ($artikel as $key => $value): ?>
                    <form action="<?= $_SERVER[ 'PHP_SELF' ] ?>" method="POST">
                        <input type="hidden" name="id" id="id_edit" value="<?= $value['id'] ?>">
                        <h3>Titel: <?= $value['titel'] ?></h3>     
                            
                        <ul>
                            <li><b>Artikel: </b><?= $value['artikel'] ?></li>
                            <li><b>Kernwoorden: </b><?= $value['kernwoorden'] ?></li>
                            <li><b>Datum: </b><?= $value['datum'] ?></li>
                        </ul>    
                            <?php if ($gebruikers_type === 'Webmaster'): ?>
                                <button type="submit" id="confirm-edit" name="confirm-edit" value="<?= $value['id'] ?>">Wijzigen</button>
                                <button type="submit" id="confirm-verwijder" name="confirm-verwijder" value="<?= $value['id'] ?>">Verwijderen</button>
                            <?php endif ?>
                    </form>
                <?php endforeach ?>
            </div>

            <?php if (empty($artikel)): ?>
                <p>Geen artikels gevonden</p>
            <?php endif ?>
            <div class="rechts">
                <?php if (isset($_POST['confirm-edit'])): ?>
                    <?php foreach ($artikel_bewerk as $key => $value): ?>
                        <div class="formulier"> 
                            <h3>Bewerken</h3>
        
                            <form action="<?= $_SERVER[ 'PHP_SELF' ] ?>" method="POST">
                                <input type="hidden" name="id_edit" id="id_edit" value="<?= $value['id'] ?>">
            
                                <label for="titel_edit">Titel:</label>
                                    <input type="text" name="titel_edit" id="titel_edit" value="<?= $value['titel'] ?>">
            
                                <label for="artikel_edit">Artikel: </label>
                                    <input type="text" name="artikel_edit" id="artikel_edit" value="<?= $value['artikel'] ?>">
            
                                <label for="kernwoorden_edit">Kernwoorden:</label>
                                    <input type="text" name="kernwoorden_edit" id="kernwoorden_edit" value="<?= $value['kernwoorden'] ?>">
            
                                <input type="submit" name="wijzigen_artikel" value="Wijzigen">
                            </form> 
                        </div>
                    <?php endforeach ?>
                <?php endif ?>

                <?php if (isset($_POST['nieuw_artikel'])): ?>
                    <div class="formulier"> 
                        <h3>Nieuw artikel toevoegen</h3>

                        <form action="<?= $_SERVER[ 'PHP_SELF' ] ?>" method="POST">
                            <label for="titel">Titel: </label>
                                <input type="text" id="titel" name="titel">

                            <label for="artikel">Artikel: </label>
                                <input type="text" id="artikel" name="artikel">

                            <label for="kernwoorden">Kernwoorden: </label>
                                <input type="text" id="kernwoorden" name="kernwoorden">

                            <input type="submit" name="toevoegen" value="toevoegen">
                        </form>
                    </div>
                <?php endif ?>
            </div>
        </section>        
    </body>
</html>