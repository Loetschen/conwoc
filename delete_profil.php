<?php
// NOTE: Datenbank verbindung wird eingebettet
include_once 'vorgaben/db.php';
// NOTE: Login Check wird eingepettet
include_once 'vorgaben/login_check.php';

// NOTE: Post in Variabeln
  if(isset($_GET['delete'])) {

      //NOTE: konto wird gelöscht
      if(!$error) {
          $statement = $pdo->prepare("DELETE FROM user WHERE ID = :id");
          $result = $statement->execute(array('id' => $user));

          // NOTE: Ausgabe bei erfolgreichem löschen
          if($result) {
              setcookie("username","",time() - 3600);
              header("Location: login.php" );
              $showFormular = false;
          } else {
              echo 'Beim Löschen ist leider ein Fehler aufgetreten<br>';
          }
      }
  }

  // NOTE: Falls man den Account nicht löscht, kehrt man zur Profil Seite zurück
  if (isset($_GET['abbrechen'])) {
    header("Location: myprofil.php" );
  }
?>
<!doctype html>
<html lang="de">
  <head>
    <?php //einbinden von CSS und Metatacks
    include_once 'vorgaben/head.php'; ?>
    <title>CONWOC | Layout</title>
  </head>
  <body>
    <?php // NOTE: Navigation einbinden
    include_once 'vorgaben/header.php'; ?>

    <?php // NOTE: Inhaltsbereich ?>
    <div class="wrapper">
      <div class="container">
        <div class="row">
          <div class="col"></div>
          <div class="col-6">
            <p> Sind Sie sicher das Sie ihr Profil Löschen wohlen?</p>
              <form action="?delete=1" method="post" class="float">
                <button type="submit" class="btn btn-danger">Ja</button>
              </form>
              <form action="?abbrechen=1" method="post" class="abstand2">
                <button type="submit" class="btn btn-primary">Nein</button>
              </form>
          </div>
          <div class="col"></div>
        </div>
      </div>
    </div>
    <?php // NOTE: Inhatlsbereich beendet ?>

    <?php // NOTE: Footer einbinden
    include_once 'vorgaben/footer.php';?>
  </body>
</html>
