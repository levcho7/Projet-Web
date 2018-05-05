<?php // login.php
  require_once 'header.php';
  echo "<div class='main'><h3>Merci d'entrer vos donn&eacutees personnelles pour rentrer</h3>";
  $error = $user = $pass = "";

  if (isset($_POST['user']))
  {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    
    if ($user == "" || $pass == "")
        $error = "Tous les champs n'ont pas &eacutet&eacute remplis<br>";
    else
    {
      $result = queryMySQL("SELECT user,pass FROM members
        WHERE user='$user' AND pass='$pass'");

      if ($result->num_rows == 0)
      {
        $error = "<span class='error'>Identifiant/mot de passe 
                  invalide</span><br><br>";
      }
      else
      {
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
        die("Vous etes maintenant connect&eacute. Merci de <a href='members.php?view=$user'>" .
            " cliquer ici</a> pour continuer.<br><br>");
      }
    }
  }

  echo <<<_END
    <form method='post' action='login.php'>$error
    <span class='fieldname'>Identifiant</span><input type='text'
      maxlength='16' name='user' value='$user'><br>
    <span class='fieldname'>Code</span><input type='password'
      maxlength='16' name='pass' value='$pass'>
_END;
?>

    <br>
    <span class='fieldname'>&nbsp;</span>
    <input type='submit' value='Se connecter'>
    </form><br></div>
  </body>
</html>
