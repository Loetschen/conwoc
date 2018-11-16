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
    <title>CONWOC | Mein Profil</title>
  </head>
  <body>
    <?php // NOTE: Navigation einbinden
    include_once 'vorgaben/header.php'; ?>

    <?php // NOTE: Inhaltsbereich ?>
    <div class="wrapper">
      <div class="container">

        <?php

        // NOTE: Wird geprüft ob eine Freundschaft angefragt wurde
        if (isset($_GET['add'])) {
          $error = false;
          $add = $_GET['add'];

          // NOTE: Es wird geprüft, ob man schon befreundet ist
          $statement = $pdo->prepare("SELECT * FROM freunde WHERE nutzer = :nutzer AND freund_von = :freund_von");
          $result = $statement->execute(array('nutzer' => $user,
                                              'freund_von' => $add));
          $user_test = $statement->fetch();

          if($user_test !== false) {
              // NOTE: Fehlermeldung, wenn man bereits befreundet ist
              echo "Ihr seid bereits befreundet!";
              $error = true;
          }

          if (!$error) {
            // NOTE: Freund wird hinzugefügt
            $statement = $pdo->prepare("INSERT INTO freunde (nutzer, freund_von) VALUES (:nutzer, :freund_von)");
            $statement->execute(array('nutzer' => $user,
                                      'freund_von' => $add));
          }
        }

          if (isset($_GET['freund'])) {

            $freundID = $_GET['freund'];

            // NOTE: Es werden die Daten des anderen Benutzers ausgelesen
            $sql = "SELECT * FROM user WHERE ID = $freundID";
            foreach ($pdo->query($sql) as $row) {
         ?>

         <style>
          .jumbotron{
            background-image: url(pics/hg/<?php echo $row['profilbild']; ?>.jpg);
          }

         </style>

        <div class="jumbotron">
          <h1 class="display-4">Profil von <?php echo $row['vorname']?></h1>
          <p class="lead"><?php echo $row['bio'] ?></p>
          <hr class="my-4">
          <?php

          // NOTE: Es werden die Personen gezählt, die mit ihm befreundet sind
          $statement = $pdo->prepare("SELECT * FROM freunde WHERE nutzer = ?");
          $statement->execute(array($freundID));
          $abonniert = $statement->rowCount();

          // NOTE: Es werden die Personen gezählt, mit denen er befreundet ist
          $statement = $pdo->prepare("SELECT * FROM freunde WHERE freund_von = ?");
          $statement->execute(array($freundID));
          $abonnenten = $statement->rowCount();


          ?>
          <h6>Abonniert: <span class="badge badge-secondary"><?php echo $abonniert; ?></span> | Abonnenten: <span class="badge badge-secondary"><?php echo $abonnenten; ?></span></h6>
          <a class="btn btn-primary btn-lg" href="?add=<?php echo $row['ID']; ?>&freund=<?php echo $row['ID']; ?>" role="button" style="margin-top:1em;">Hinzufügen</a>
        </div>



      <div style="margin-top:1em"></div>
      <h3>Posts von <?php echo $row['vorname']; ?></h3>
      <div style="margin-top:1em"></div>

        <?php } }?>

      <div class="card-columns">

        <?php

          // NOTE: Es werden die Posts von der anderen Perosn ausgelesen, neuste zuerst
          $sql = "SELECT * FROM posts WHERE userID = $freundID ORDER BY zeit DESC";
          foreach ($pdo->query($sql) as $row) {

         ?>

        <div class="card p-3">
          <blockquote class="blockquote mb-0 card-body">
            <p><?php echo $row['post']; ?></p>
            <footer class="blockquote-footer">
              <small class="text-muted">
                  <?php
                    // NOTE: aktuelles Datum wird abgefragt und formatiert
                    date_default_timezone_set("Europe/Berlin");
                    $timestamp = time();
                    $datumA = date("d.m.Y",$timestamp);

                    // NOTE:Datum und Zeit des Posts werden formatiert
                    $datum = date("d.m.Y", strtotime($row['zeit']));
                    $zeit = date("H:i", strtotime($row['zeit']));

                    // NOTE: Wenn Post Datum dem aktuellen enstpricht, wird die Zeit angezeigt, ansonsten das Datum
                    if ($datum !== $datumA) {
                      echo "gepostet am <cite title=\"Source Title\">" . $datum;
                    }else {
                      echo "gepostet um <cite title=\"Source Title\">" . $zeit;
                    }

                   ?>
                </cite>
              </small>
            </footer>
          </blockquote>
        </div>

      <?php } ?>

      </div>

      </div>
    </div>
    <?php // NOTE: Inhatlsbereich beendet ?>

    <?php // NOTE: Footer einbinden
    include_once 'vorgaben/footer.php';?>
  </body>
</html>
