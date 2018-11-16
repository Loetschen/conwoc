<?php
// NOTE: Datenbank verbindung wird eingebettet
include_once 'vorgaben/db.php';
// NOTE: Login Check wird eingepettet
include_once 'vorgaben/login_check.php';

// NOTE: Session für die anzahl Posts seit Anmeldung wird gestartet
session_start();
// NOTE: Session wird gelessen
$zeit100 = $_SESSION['zeit_login'];

// NOTE: DB wird nach allen einträgen durchsucht, welche neuer sind als Session Zeitpunkt
$zeit101 = $pdo->prepare("SELECT * FROM posts WHERE zeit >= FROM_UNIXTIME($zeit100)");
$zeit101->execute();
// NOTE: Ergebnisse werden gezählt
$anzahl_posts = $zeit101->rowCount();
?>
<!doctype html>
<html lang="de">
  <head>
    <?php //einbinden von CSS und Metatacks
    include_once 'vorgaben/head.php'; ?>
    <title>CONWOC | Home</title>
  </head>
  <body>
    <?php // NOTE: Navigation einbinden
    include_once 'vorgaben/header.php'; ?>

    <?php // NOTE: Inhaltsbereich ?>

    <script>
      // NOTE: Javascript zum zählen der Zeichen im Post
      function countChar(val) {
        var len = val.value.length;
        if (len >= 500) {
          val.value = val.value.substring(0, 500);
        } else {
          $('#charNum').text(500 - len);
        }
      };
    </script>

    <div class="wrapper">
      <div class="container">

        <?php // NOTE: Neuer Post ?>
          <div class="neuer_post position-fixed">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" >Neuer Post</button>
          </div>
        <?php
          // NOTE: Prüfung ob ein Post zum Hochladen vorhanden ist
          if (isset($_GET['post'])) {

          // NOTE: Post variable wird übergeben
          $text = $_POST['text'];

          // NOTE: Post wird in DB eingetragen
          $statement = $pdo->prepare("INSERT INTO posts (userID, post) VALUES (:user, :post)");
          $statement->execute(array('user' => $user,
                                    'post' => $text));

          }

         ?>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Neuer Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="?post=1" method="post">
                  <div class="form-group">
                    <textarea name="text" class="form-control" id="message-text" maxlength="500" onkeyup="countChar(this)" rows="5"></textarea>
                  </div>
              </div>
              <div class="modal-footer">
                <p id="charNum"></p>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Schliessen</button>
                <button type="submit" class="btn btn-primary">Posten</button>
              </form>
              </div>
            </div>
          </div>
        </div>

        <?php // NOTE: Neuer Post beendet ?>
        <?php // NOTE: Posts anzeige ?>

        <div class="abstand"></div>
        <p><?php echo "Anzahl neuer Posts seid Anmeldung: " . $anzahl_posts; ?></p>
        <br>

        <div class="card-columns">

          <?php

            // NOTE: Alle Posts auslessen, neuste zuerst
            $sql = "SELECT * FROM posts ORDER BY zeit DESC";
            foreach ($pdo->query($sql) as $row) {

           ?>

          <div class="card p-3">
            <blockquote class="blockquote mb-0 card-body">
              <p><?php // NOTE: Inhalt des Post wird angezeigt
              echo $row['post']; ?></p>
              <footer class="blockquote-footer">
                <small class="text-muted">
                    <?php

                      // NOTE: Aktuelles Datum wird erfasst und formatiert
                      date_default_timezone_set("Europe/Berlin");
                      $timestamp = time();
                      $datumA = date("d.m.Y",$timestamp);

                      // NOTE: Datum und Zeit des Posts erden formatiert
                      $datum = date("d.m.Y", strtotime($row['zeit']));
                      $zeit = date("H:i", strtotime($row['zeit']));

                      // NOTE: Wenn Post heute erfasst, Zeit wird angezeigt, ansonsten Zeit
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

        <?php // NOTE: Posts anzeige beendet?>

      </div>
    </div>
    <?php // NOTE: Inhatlsbereich beendet ?>

    <?php // NOTE: Footer einbinden
    include_once 'vorgaben/footer.php';?>
  </body>
</html>
