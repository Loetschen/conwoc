<?php
// NOTE: DB Verbindung wird eingebunden
include_once 'vorgaben/db.php';
?>

<!doctype html>
<html lang="de">
  <head>
    <?php //einbinden von CSS und Metatacks
    include_once 'vorgaben/head.php'; ?>
    <title>CONWOC | Registieren</title>
  </head>
  <body>

    <?php
      $showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll

      if(isset($_GET['register'])) {
          $error = false;
          $vorname = $_POST['vorname'];
          $nachname = $_POST['nachname'];
          $username = $_POST['username'];
          $email = $_POST['email'];
          $passwort = $_POST['passwort'];
          $passwort2 = $_POST['passwort2'];

          // NOTE: Es wird geprüft, ob es eine Echte E-Mail ist
          if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
              $error = true;
          }

          // NOTE: Es wird geprüft ob ein Passwort vorhanden ist
          if(strlen($passwort) == 0) {
              echo 'Bitte ein Passwort angeben<br>';
              $error = true;
          }

          // NOTE: Es wird geprüft ob die Passwörter übereinstimmen
          if($passwort != $passwort2) {
              echo 'Die Passwörter müssen übereinstimmen<br>';
              $error = true;
          }

          //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
          if(!$error) {
              $statement = $pdo->prepare("SELECT * FROM user WHERE email = :email");
              $result = $statement->execute(array('email' => $email));
              $user = $statement->fetch();

              if($user !== false) {
                  echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
                  $error = true;
              }
          }

          if(!$error) {
              // NOTE: Es wird geprüft ob der Nutzername bereits vorhanden ist
              $statement = $pdo->prepare("SELECT * FROM user WHERE user_name = :user_name");
              $result = $statement->execute(array('user_name' => $username));
              $user = $statement->fetch();

              if($user !== false) {
                  echo 'Dieser Benutzername ist bereits vergeben<br>';
                  $error = true;
              }
          }

          //Keine Fehler, wir können den Nutzer registrieren
          if(!$error) {
              $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);

              // NOTE: Benutzer wird registriert
              $statement = $pdo->prepare("INSERT INTO user (email, passwort, vorname, nachname, user_name) VALUES (:email, :passwort, :vorname, :nachname, :user_name)");
              $result = $statement->execute(array('email' => $email,
                                                  'passwort' => $passwort_hash,
                                                  'vorname' => $vorname,
                                                  'nachname' => $nachname,
                                                  'user_name' => $username));

              if($result) {
                  echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
                  $showFormular = false;
              } else {
                  echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
              }
          }
      }

      if($showFormular) {
      ?>

    <?php // NOTE: Inhaltsbereich ?>
    <div class="wrapper">
      <div class="container text-center">

        <div class="row">
          <div class="col"></div>
          <div class="col-6">
            <form action="?register=1" method="post">
              <img class="mb-4" src="pics/logo.png" alt="" width="72" height="72">
              <h1 class="h3 mb-3 font-weight-normal">Bitte Registieren Sie sich</h1>
              <div class="form-group">
                  <input name="vorname" class="form-control" type="text" placeholder="Vorname">
                </div>
                <div class="form-group">
                  <input name="nachname" class="form-control" type="text" placeholder="Nachname">
                </div>
                <div class="form-group">
                  <input name="username" class="form-control" type="text" placeholder="Benutzer Name">
                </div>
                <div class="form-group">
                  <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
                <div class="form-group">
                  <input name="passwort" type="password" class="form-control" id="exampleInputPassword1" placeholder="Passwort">
                </div>
                <div class="form-group">
                  <input name="passwort2" type="password" class="form-control" id="exampleInputPassword1" placeholder="Passwort wiederholen">
                </div>
                <button type="submit" class="btn btn-primary">Registrieren</button>
            </form>
          </div>
          <div class="col"></div>
        </div>


      </div>
      <?php } ?>
    </div>
    <?php // NOTE: Inhatlsbereich beendet ?>

  </body>
</html>
