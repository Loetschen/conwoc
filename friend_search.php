<?php
// NOTE: Datenbank verbindung wird eingebettet
include_once 'vorgaben/db.php';
// NOTE: Login Check wird eingepettet
include_once 'vorgaben/login_check.php';
?>
<!doctype html>
<html lang="de">
  <head>
    <?php //einbinden von CSS und Metatacks
    include_once 'vorgaben/head.php'; ?>
    <title>CONWOC | Freunde suchen</title>
  </head>
  <body>
    <?php // NOTE: Navigation einbinden
    include_once 'vorgaben/header.php'; ?>

    <?php // NOTE: Inhaltsbereich ?>
    <div class="wrapper">
      <div class="container">

        <?php
          // NOTE: Wird geprüft ob ein Spieler hinzugefügt werden will
          if (isset($_GET['add'])) {
            // NOTE: ausgangslage für Fehlermeldung False
            $error = false;
            // NOTE: Get mit der ID wird übergeben
            $add = $_GET['add'];

            // NOTE: Wird geprüft ob man bereits befreundet ist
            $statement = $pdo->prepare("SELECT * FROM freunde WHERE nutzer = :nutzer AND freund_von = :freund_von");
            $result = $statement->execute(array('nutzer' => $user,
                                                'freund_von' => $add));
            $user_test = $statement->fetch();

            // NOTE: Anzeige wenn man bereits befreundet ist, Fhler Meldung wird auf True gewechselt
            if($user_test !== false) {
                echo "Ihr seid bereits befreundet!";
                $error = true;
            }

            // NOTE: Wenn Fehlermeldung negativ, Freund wird hinzugefügt
            if (!$error) {
              $statement = $pdo->prepare("INSERT INTO freunde (nutzer, freund_von) VALUES (:nutzer, :freund_von)");
              $statement->execute(array('nutzer' => $user,
                                        'freund_von' => $add));
            }
          }

         ?>

        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">User Name</th>
              <th scope="col">Vorname</th>
              <th scope="col">Nachname</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>

            <?php
              // NOTE: Wird geprüft ob eine Eingabe erfolgt ist
              if (isset($_POST['suche'])) {
                // NOTE: Such eingabe wird übergeben
                $suche = $_POST['suche'];
                // NOTE: Es wird gesucht ob die Eingabe im Usernamen, Vor oder Nachmanem vorhanden ist
                $sql = "SELECT * FROM user WHERE user_name LIKE '%$suche%' OR vorname LIKE '%$suche%' OR nachname LIKE '%$suche%' ORDER BY user_name ASC";
              }else
              // NOTE: Wenn nicht, werden alle Nutzer angezeigt
              {
                $sql = "SELECT * FROM user";
              }
              // NOTE: die Ergebnisse werden ausgegeben
              foreach ($pdo->query($sql) as $row) {
                $freundID = $row['ID'];
                // NOTE: Test, damit man selber nicht angezeigt wird
                if ($user !== $freundID) {

             ?>

            <tr>
              <th scope="row"><a href="profil_freund.php?freund=<?php echo $row['ID']; ?>" class="text-dark"><?php echo $row['user_name']; ?></a></th>
              <td><?php echo $row['vorname']; ?></td>
              <td><?php echo $row['nachname']; ?></td>
              <td><a class="btn btn-primary" href="<?php echo "?add=" . $row['ID']; ?>" role="button">Hinzufügen</a></td>
            </tr>
          <?php } } ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php // NOTE: Inhatlsbereich beendet ?>

    <?php // NOTE: Footer einbinden
    include_once 'vorgaben/footer.php';?>
  </body>
</html>
