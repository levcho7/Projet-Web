<?php // logout.php
  require_once 'header.php';

  if (isset($_SESSION['user']))
  {
    destroySession();
    echo "<div class='main'>Vous avez ete d&eacuteconnect&eacute. Merci de " .
         "<a href='index.php'> cliquer ici</a> pour rafra&icircchir la page.";
  }
  else echo "<div class='main'><br>" .
            "Vous ne pouvez pas vous deconnecter car vous ne vous etes pas connecte";
?>

    <br><br></div>
  </body>
</html>
