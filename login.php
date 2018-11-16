<?php
// NOTE: DB verbindung einbinden
include_once 'vorgaben/db.php';

// NOTE: Wird überprüft ob ein Submit ausgeführt wurde
if(isset($_GET['login'])) {
    // NOTE: Variabeln werden übergeben
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    // NOTE: wird überprüft, ob angmeldet bleiben aktiviert ist
    if (isset($_POST['angemeldet'])) {
      $angemeldet = $_POST['angemeldet'];
    }

    // NOTE: Wird in der Tabelle User nach der E-Mail gesucht
    $statement = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();

    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
      // NOTE: Wenn angemeldet aktiviert ist, wird ein cookie erstellt (ca. 30 Tage)
      if (isset($angemeldet)) {
        setcookie("username",$user['ID'],time()+(86400 * 30));
      }else{
        setcookie("username",$user['ID'],0);
      }
      // NOTE: Session mit Login Zeit Punkt wird gesatrtet, für anzahl Posts seid Login
      session_start();
      date_default_timezone_set("Europe/Berlin");
      $zeit_login = time();
      $_SESSION['zeit_login'] = $zeit_login;

      // NOTE: ohne Fehlermeldung, wird man zur Startseite weitergeleidet
      header("Location: index.php" );
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }

}
?>
<!doctype html>
<html lang="de">
  <head>
    <?php //einbinden von CSS und Metatacks
    include_once 'vorgaben/head.php'; ?>
    <title>CONWOC | Login</title>
  </head>
  <body>

    <?php // NOTE: Inhaltsbereich ?>
    <div class="wrapper">
      <div class="container text-center">

        <div class="row">
          <div class="col"></div>
          <div class="col-6">
            <form action="?login=1" method="post">
              <img class="mb-4" src="pics/logo.png" alt="" width="72" height="72">
              <h1 class="h3 mb-3 font-weight-normal">Bitte Anmelden</h1>
                <?php
                // NOTE: Meldung bei Fehlgeschlagenem Login
                if(isset($errorMessage)) {
                    echo $errorMessage;
                } ?>
              <div class="form-group">
                <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="E-Mail">
              </div>
              <div class="form-group">
                <input name="passwort" type="password" class="form-control" id="exampleInputPassword1" placeholder="Passwort">
              </div>
              <div class="form-group form-check">
                <input name="angemeldet" type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Angemeldet bleiben</label>
              </div>
              <button type="submit" class="btn btn-primary">Anmelden</button>
              <p>Registrieren Sie sich <a href="registrieren.php">hier</a>.</p>
            </form>
          </div>
          <div class="col"></div>
        </div>


      </div>
    </div>
    <?php // NOTE: Inhatlsbereich beendet ?>

  </body>
</html>
