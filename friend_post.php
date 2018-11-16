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
    <title>CONWOC | Posts von Freunden</title>
  </head>
  <body>
    <?php // NOTE: Navigation einbinden
    include_once 'vorgaben/header.php'; ?>

    <?php // NOTE: Inhaltsbereich ?>
    <div class="wrapper">
      <div class="container">

        <?php // NOTE: Posts anzeige ?>

        <div class="abstand"></div>

        <div class="card-columns">

          <?php
            /*NOTE: Abfrage mit Left Join
                    1. User ID des Posterstellers wird in der Freunde Tabelle gesucht
                    2. User ID des Posterstellers wird in der User gesucht, für die Anzeie des Namens
                    3. Es wird geürüft ob der Nutzer mit dem Postersteller befreundet ist
                    4. Post werden angezeigt, neuste zuerst
            */
            $sql = "SELECT * FROM posts LEFT JOIN freunde ON posts.userID = freunde.freund_von
                                       LEFT JOIN user ON posts.userID = user.ID
                                       WHERE freunde.nutzer = $user ORDER BY posts.zeit DESC";

            foreach ($pdo->query($sql) as $row){

           ?>

          <div class="card p-3">
            <blockquote class="blockquote mb-0 card-body">
              <p><?php
                // NOTE: Inhalt des Post wird angezeigt
                echo $row['post'];
               ?></p>
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
                        echo "gepostet am <cite title=\"Source Title\">" . $datum . " | " . "<a href=\"profil_freund.php?freund=" . $row['ID'] . " \" class=\"text-info\">" . $row['user_name'] . "</a>";
                      }else {
                        echo "gepostet um <cite title=\"Source Title\">" . $zeit . " | " . "<a href=\"profil_freund.php?freund=" . $row['ID'] . " class=\"text-info\">" . $row['user_name'] . "</a>";
                      }

                     ?>
                  </cite>
                </small>
              </footer>
            </blockquote>
          </div>

        <?php }  ?>

        </div>

        <?php // NOTE: Posts anzeige beendet?>

      </div>
    </div>
    <?php // NOTE: Inhatlsbereich beendet ?>

    <?php // NOTE: Footer einbinden
    include_once 'vorgaben/footer.php';?>
  </body>
</html>
