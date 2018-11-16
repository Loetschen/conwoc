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
    <title>CONWOC | Meine Freunde</title>
  </head>
  <body>
    <?php // NOTE: Navigation einbinden
    include_once 'vorgaben/header.php'; ?>

    <?php // NOTE: Inhaltsbereich ?>
    <div class="wrapper">
      <div class="container">

        <?php

          // NOTE: wird geprüft ob eine Lösch anfrage gestartet wurde
          if (isset($_GET['delete'])) {
            $freundID = $_GET['delete'];

            // NOTE: Freund wird gelöscht
            $statement = $pdo->prepare("DELETE FROM freunde WHERE freund_von = ?");
            $statement->execute(array($freundID));
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
                // NOTE: Left Join von Freunde auf User, Name des Freundes werden abgerufen
                $sql = "SELECT * FROM freunde LEFT JOIN user ON freunde.freund_von = user.ID WHERE freunde.nutzer = $user ORDER BY user.user_name ASC";
                foreach ($pdo->query($sql) as $row){

             ?>

            <tr>
              <th scope="row"><a href="profil_freund.php?freund=<?php echo $row['ID']; ?>" class="text-dark"><?php echo $row['user_name']; ?></a></th>
              <td><?php echo $row['vorname']; ?></td>
              <td><?php echo $row['nachname']; ?></td>
              <td><a class="btn btn-secondary" href="<?php echo "?delete=" . $row['ID']; ?>" role="button">Entfernen</a></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>

      </div>
    </div>
    <?php // NOTE: Inhatlsbereich beendet ?>

    <?php // NOTE: Footer einbinden
    include_once 'vorgaben/footer.php';?>
  </body>
</html>
