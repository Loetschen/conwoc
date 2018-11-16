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
    <title>CONWOC | Layout</title>
  </head>
  <body>
    <?php // NOTE: Navigation einbinden
    include_once 'vorgaben/header.php'; ?>

    <?php // NOTE: Inhaltsbereich ?>
    <div class="wrapper">
      <div class="container">
        <div class="jumbotron">
          <div class="container">
            <h1 class="display-4">Über uns</h1>
            <p class="lead">Wer reitet so spät durch Nacht und Wind?
                            Es ist der Vater mit seinem Kind.
                            Er hat den Knaben wohl in dem Arm,
                            Er faßt ihn sicher, er hält ihn warm.
                            Mein Sohn, was birgst du so bang dein Gesicht?
                            Siehst Vater, du den Erlkönig nicht!
                            Den Erlenkönig mit Kron' und Schweif?
                            Mein Sohn, es ist ein Nebelstreif.
                            Du liebes Kind, komm geh' mit mir!
                            Gar schöne Spiele, spiel ich mit dir,
                            Manch bunte Blumen sind an dem Strand,
                            Meine Mutter hat manch gülden Gewand.
                            Mein Vater, mein Vater, und hörest du nicht,
                            Was Erlenkönig mir leise verspricht?
                            Sei ruhig, bleibe ruhig, mein Kind,
                            In dürren Blättern säuselt der Wind.</p>
          </div>
        </div>
      </div>
    </div>
    <?php // NOTE: Inhatlsbereich beendet ?>

    <?php // NOTE: Footer einbinden
    include_once 'vorgaben/footer.php';?>
  </body>
</html>
