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
    <title>CONWOC | Meine Posts</title>
  </head>
  <body>
    <?php // NOTE: Navigation einbinden
    include_once 'vorgaben/header.php'; ?>

    <?php // NOTE: Inhaltsbereich ?>
    <div class="wrapper">
      <div class="container">

        <?php
          // NOTE: wird geprüft ob eine Lösch anfrage vorhanden ist
          if (isset($_GET['delete'])) {

            $deleteID = $_GET['delete'];

            // NOTE: Post wird gelöscht
            $statement = $pdo->prepare("DELETE FROM posts WHERE ID = :postID AND userID = :userID");
            $statement->execute(array('postID' => $deleteID,
                                      'userID' => $user));
          }

         ?>

        <div class="card-columns">

          <?php
            // NOTE: Eigene Posts werden ausgelesen, neuste Zuerst
            $sql = "SELECT * FROM posts WHERE userID = $user ORDER BY zeit DESC";
            foreach ($pdo->query($sql) as $row) {

           ?>

          <div class="card p-3">
            <blockquote class="blockquote mb-0 card-body">
              <p><?php echo $row['post']; ?></p>
              <footer class="blockquote-footer">
                <small class="text-muted">
                    <?php
                      // NOTE: Aktuelle Zeit wird erfasst und formatiert
                      date_default_timezone_set("Europe/Berlin");
                      $timestamp = time();
                      $datumA = date("d.m.Y",$timestamp);

                      // NOTE: Zeit des Posts wird formatiert
                      $datum = date("d.m.Y", strtotime($row['zeit']));
                      $zeit = date("H:i", strtotime($row['zeit']));

                      // NOTE: Wenn der Post am selben Tag war, wird die Zeit angezeigt, ansonsten das Datum
                      if ($datum !== $datumA) {
                        echo "gepostet am <cite title=\"Source Title\">" . $datum . " | ";
                      }else {
                        echo "gepostet um <cite title=\"Source Title\">" . $zeit . " | ";
                      }

                     ?>
                  </cite>
                </small>
                <small><a href="?delete=<?php echo $row['ID']; ?>" class="text-danger">Löschen</a></small>
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
