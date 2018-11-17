<?php
include_once 'vorgaben/db.php';
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

          if (isset($_GET['add'])) {
            $error = false;
            $add = $_GET['add'];

/*            $statement = $pdo->prepare("SELECT * FROM freunde WHERE nutzer = :nutzer");
            $result = $statement->execute(array('nutzer' => $user));
            $user = $statement->fetch();

            if($user !== false) {
                echo "Ihr seid bereits befreundet!";
                $error = true;
            }*/

            if (!$error) {
              $statement = $pdo->prepare("INSERT INTO freunde (nutzer, freund_von) VALUES (:nutzer, :freund_von)");
              $statement->execute(array('nutzer' => $user,
                                        'freund_von' => $add));
              }
          }

          if (isset($_GET['delete'])) {
            $del = $_GET['delete'];

            $statement = $pdo->prepare("DELETE FROM freunde WHERE freund_von = ?");
            $statement->execute(array($del));
          }

         ?>

        <table class="table table-striped" id="freunde">
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
              if (isset($_POST['suche'])) {
                $suche = $_POST['suche'];
                $sql = "SELECT * FROM user WHERE user_name LIKE '%$suche%'
                                              OR vorname LIKE '%$suche%'
                                              OR nachname LIKE '%$suche%' ORDER BY user_name ASC";
              }else {
                $sql = "SELECT * FROM user";
              }

              $db = "SELECT * FROM freunde WHERE nutzer = $user";

              foreach ($pdo->query($sql) as $row) {
                $freundID = $row['ID'];
                if ($user !== $freundID) {

                  foreach ($pdo->query($db) as $row2) {
                    if ($freundID == $row2['freund_von'] AND $user == $row2['nutzer']) {

                      ?>
                      <tr>
                        <th scope="row"><?php echo $row['user_name']; ?></th>
                        <td><?php echo $row['vorname']; ?></td>
                        <td><?php echo $row['nachname']; ?></td>
                        <td><a class="btn btn-secondary" href="<?php echo "?delete=" . $row['ID']; ?>" role="button">Entfernen</a></td>
                      </tr>
                      <?php
                    }else{
                  ?>
                      <tr>
                        <th scope="row"><?php echo $row['user_name']; ?></th>
                        <td><?php echo $row['vorname']; ?></td>
                        <td><?php echo $row['nachname']; ?></td>
                        <td><a class="btn btn-primary" href="<?php echo "?add=" . $row['ID']; ?>" role="button">Hinzufügen</a></td>
                      </tr>
            <?php } } } } ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php // NOTE: Inhatlsbereich beendet ?>

    <?php // NOTE: Footer einbinden
    include_once 'vorgaben/footer.php';?>
  </body>
</html>
