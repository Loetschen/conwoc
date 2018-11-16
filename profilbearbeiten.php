<?php
// NOTE: Datenbank verbindung wird eingebettet
include_once 'vorgaben/db.php';
// NOTE: Login Check wird eingepettet
include_once 'vorgaben/login_check.php';

// NOTE: Es wird geprüft ob ein Profil beareitung vorhanden ist
if(isset($_GET['update'])) {
    $error = false;
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $hg = $_POST['hg'];
    $bio = $_POST['bio'];

    // NOTE: Die User Daten werden neu abgespeichert
    if(!$error) {

        $statement = $pdo->prepare("UPDATE user SET vorname = :vorname_neu, nachname = :nachname_neu, profilbild = :profilbild_neu, bio = :bio_neu WHERE id = :id");
        $result = $statement->execute(array('vorname_neu' => $vorname,
                                            'nachname_neu' => $nachname,
                                            'id' => $user,
                                            'profilbild_neu' => $hg,
                                            'bio_neu' => $bio));

        if($result) {
            header("Location: myprofil.php" );
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    }
}

?>
<!doctype html>
<html lang="de">
  <head>
    <?php //einbinden von CSS und Metatacks
    include_once 'vorgaben/head.php'; ?>
    <title>CONWOC | Profil bearbeiten</title>
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
            <form action="?update=1" method="post">
              <h1 class="h3 mb-3 font-weight-normal">Sie können nun Ihr Konto bearbeiten</h1>

              <?php

                // NOTE: Die Nutzerdaten werden ausgelesesn
                $sql = "SELECT * FROM user WHERE ID = $user";
                foreach ($pdo->query($sql) as $row) {

               ?>

              <div class="form-group">
                  <label for="exampleInputEmail1">Vorname</label>
                  <input name="vorname" class="form-control" type="text" placeholder="Vorname" value="<?php echo $row['vorname'] ?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Nachname</label>
                  <input name="nachname" class="form-control" type="text" placeholder="Nachname" value="<?php echo $row['nachname'] ?>">
                </div>
                <div class="form-group">
                  <script>
                    // NOTE: es wird die Anzhal Zeichen für die Beschreibung gezählt
                    function countChar(val) {
                      var len = val.value.length;
                      if (len >= 500) {
                        val.value = val.value.substring(0, 500);
                      } else {
                        $('#charNum').text(500 - len);
                      }
                    };
                  </script>

                  <label for="exampleInputEmail1">Wählen Sie ihren Hintergrund</label>
                  <select class="form-control" name="hg">
                    <option selected disabled>Wähle deinen Hintergrund</option>
                    <option value="">Keinen</option>
                    <option value="wasser">Wasser</option>
                    <option value="holz">Holz</option>
                    <option value="schnee">Schnee</option>
                    <option value="feuer">Feuer</option>
                    <option value="grass">Grass</option>
                  </select>
                  <br>
                  <label for="exampleInputEmail1">Geben Sie hier Ihre Biografie ein</label>
                    <textarea name="bio" class="form-control" id="message-text" maxlength="500" placeholder="Biografie" onkeyup="countChar(this)" rows="5" ><?php echo $row['bio'] ?></textarea>
                    <p id="charNum"></p>
                </div>
                <button type="submit" class="btn btn-primary">Updaten</button>
                <a class="btn btn-secondary" href="myprofil.php" role="button">Abbrechen</a>
                <a class="btn btn-danger" href="delete_profil.php" role="button">Profil Löschen</a>
              <?php } ?>
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
