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
          // NOTE: Eigene Nutzer Daten werden ausgelesen
          $sql = "SELECT * FROM user WHERE ID = $user";
          foreach ($pdo->query($sql) as $row) {

         ?>
         <style>
          .jumbotron{
            background-image: url(pics/hg/<?php echo $row['profilbild']; ?>.jpg);
          }

         </style>

        <div class="jumbotron">
          <h1 class="display-4">Hallo, <?php echo $row['vorname']?></h1>
          <p class="lead"><?php echo $row['bio'] ?></p>
          <hr class="my-4">
          <?php
          // NOTE: Es werden die Nutzer gezählt, welche man als Freunde hat
          $statement = $pdo->prepare("SELECT * FROM freunde WHERE nutzer = ?");
          $statement->execute(array($user));
          $abonniert = $statement->rowCount();

          // NOTE: Es werden die Nutzer gezählt, di mit einem selber befreundet sind
          $statement = $pdo->prepare("SELECT * FROM freunde WHERE freund_von = ?");
          $statement->execute(array($user));
          $abonnenten = $statement->rowCount();


          ?>
          <h6>Abonniert: <span class="badge badge-secondary"><?php echo $abonniert; ?></span> | Abonnenten: <span class="badge badge-secondary"><?php echo $abonnenten; ?></span></h6>
          <a class="btn btn-primary btn-lg" href="profilbearbeiten.php" role="button" style="margin-top:1em;">Profil bearbeiten</a>
        </div>

        <?php } ?>

      </div>
    </div>
    <?php // NOTE: Inhatlsbereich beendet ?>

    <?php // NOTE: Footer einbinden
    include_once 'vorgaben/footer.php';?>
  </body>
</html>
