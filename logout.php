<?php
// NOTE: Cookie wird auf eine Minus Zeit gestellt, also gelöscht
setcookie("username","",time() - 3600);

header("Location: login.php" );
 ?>
