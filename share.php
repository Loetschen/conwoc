<?php
include_once 'vorgaben/db.php';
include_once 'vorgaben/login_check.php';
?>
<!doctype html>
<html lang="de">
  <head>
    <?php //einbinden von CSS und Metatacks
    include_once 'vorgaben/head.php'; ?>
    <title>CONWOC | Share</title>
  </head>
  <body>
    <?php // NOTE: Navigation einbinden
    include_once 'vorgaben/header.php'; ?>

    <?php // NOTE: Inhaltsbereich ?>

    <?php
    // NOTE: Wird geprüft ob eine Share anfrage besteht
    if (isset($_GET['share'])) {
      $error = false;

      if(!filter_var($_POST['adresse'], FILTER_VALIDATE_EMAIL)) {
        $error = true;
      }

      // NOTE: Variabeln für die E-Mail werden gesetz
      $adresse = $_POST['adresse'];
      $betreff = "Sieh dir mal CONWOC an!!";
      $nachricht = "Habe diese neue Seite names CONWOC endteckt.
                    Habe schon meine ersten Posts verfasst und folge mir am besten direkt

                    Die Webseite findest du unter conwoc.com.";
      // NOTE: E-Mail wird gesendet
      mail($adresse, $betreff, $nachricht, "From: Absender <info@conwoc.com>");



      if ($error == true) {
        $meldung = "<p><b>Bitte eine gültige E-Mail-Adresse eingeben</b></p>";
      }else {
        $meldung = "<p><b>Einladung wurde versendet</b></p>";
      }
    }
     ?>

    <div class="wrapper">
      <div class="container">
        <form action="?share=1" method="post">
            <label for="exampleFormControlInput1">An wenn möchtest du CONWOC senden?</label>
            <?php if (isset($meldung)) {echo $meldung;} ?>
            <input class="form-control form-control-lg" type="text" placeholder="E-Mail Adresse" name="adresse">
            <br>
            <button type="submit" class="btn btn-primary">Senden</button>
        </form>
        <br>
        <br>

        <?php // NOTE: für Share Buttons, externes JS ?>
        <div class="sharethis-inline-share-buttons"></div>

      </div>
    </div>
    <?php // NOTE: Inhatlsbereich beendet ?>

    <?php // NOTE: Footer einbinden
    include_once 'vorgaben/footer.php';?>
  </body>
</html>
