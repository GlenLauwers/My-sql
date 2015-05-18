<?php
    
  $bericht     = '';
  $bieren_array = array();
  $kolom_naam   = array();
  $kolom_naam[] = 'biernummer';


  try
  {
    $db = new PDO('mysql:host=localhost;dbname=bootstrap', 'root', '');
    $bericht  = 'Connectie is gelukt.';

    $query  =   "SELECT *
                    FROM TABLE 2";

        $statement  =   $db->prepare($query);
        $statement->execute( );

        for ( $fieldNumber = 0; $fieldNumber < $statement->columnCount(); ++$fieldNumber )
        {
            $naam[]   =   $statement->getColumnMeta( $fieldNumber );
        }

        while( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
        {
            $lijst[] =   $row;
        }


  }

  catch ( PDOException $e )
  {
    $bericht  = 'Er ging iets mis bij het inladen van de database: ' . $e->getMessage();
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Keywords" content="" />
    <title>Werknemers</title>

    <!-- Style -->

  </head>
  <body>
    <h1>Werknemers</h1>
    <p><?= $bericht ?></p>

    <table>
          <thead>
              <tr>
                  <?php foreach ($naam as $naam): ?>
                      <th><?= $naam ?></th>
                  <?php endforeach ?>
                  <th></th>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($lijst as $key => $werknemer): ?>
                  <tr>
                      <td><?= ++$key ?></td>
                      <?php foreach ($werknemer as $value): ?>
                          <td><?= $value ?></td>
                      <?php endforeach ?>
                  </tr>
              <?php endforeach ?>                        
          </tbody>       
      </table>
  </body>
</html>