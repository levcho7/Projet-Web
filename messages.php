<?php // messages.php
  require_once 'header.php';

  if (!$loggedin) die();

  if (isset($_GET['view'])) $view = sanitizeString($_GET['view']);
  else                      $view = $user;

  if (isset($_POST['text']))
  {
    $text = sanitizeString($_POST['text']);

    if ($text != "")
    {
      $pm   = substr(sanitizeString($_POST['pm']),0,1);
	  $pm2=substr(sanitizeString($_POST['pm2']),0,1);
      $time = time();
      queryMysql("INSERT INTO messages VALUES(NULL, '$user',
        '$view', '$pm', $time, '$text','$pm2')");
    }
  }

  if ($view != "")
  {
    if ($view == $user) $name1 = $name2 = "Vos";
    else
    {
      $name1 = "<a href='members.php?view=$view'>$view</a>";
      $name2 = "$view";
    }

    echo "<div class='main'><h3>$name1 Messages</h3>";
    showProfile($view);
    
    echo <<<_END
      <form method='post' action='messages.php?view=$view'>
      Ecrivez ici pour laisser un message :<br>
      <textarea name='text' cols='40' rows='3'></textarea><br>
      Public<input type='radio' name='pm' value='0' checked='checked'>
      Priv&eacute<input type='radio' name='pm' value='1'>
      <input type='submit' value='Poster un message'></form><br>
_END;

    if (isset($_GET['erase']))
    {
      $erase = sanitizeString($_GET['erase']);
      queryMysql("DELETE FROM messages WHERE id=$erase AND recip='$user'");
    }
    
    $query  = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC";
    $result = queryMysql($query);
    $num    = $result->num_rows;
    
    for ($j = 0 ; $j < $num ; ++$j)
    {
      $row = $result->fetch_array(MYSQLI_ASSOC);

      if ($row['pm'] == 0 || $row['auth'] == $user || $row['recip'] == $user)
      {
        echo date('m.d.y H:i:s :', $row['time']);
        echo " <a href='messages.php?view=" . $row['auth'] . "'>" . $row['auth']. "</a> ";

        if ($row['pm'] == 0)
          echo "a &eacutecrit: &quot;" . $row['message'] . "&quot; ";
        else
          echo "a chuchot&eacute: <span class='whisper'>&quot;" .
            $row['message']. "&quot;</span> ";

        if ($row['recip'] == $user)
          echo "[<a href='messages.php?view=$view" .
               "&erase=" . $row['id'] . "'>effacer</a>]";

			   
			   
        echo "<br>";
      }
    }
  }

  if (!$num) echo "<br><span class='info'>Pas encore de messages</span><br><br>";
  /////
  
	 
	//echo "Vous pouvez supprimer un utilisateur";
	
	/////
  echo "<br><a class='button' href='messages.php?view=$view'>Rafra&icircchir les messages</a>";
?>

    </div><br>
  </body>
</html>
