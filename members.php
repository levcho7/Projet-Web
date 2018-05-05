<?php // members.php
  require_once 'header.php';

  if (!$loggedin) die();

  echo "<div class='main'>";

  if (isset($_GET['view']))
  {
    $view = sanitizeString($_GET['view']);
    
    if ($view == $user) $name = "votre";
    else                $name = "$view";
    
    echo "<h3>$name profil</h3>";
    showProfile($view);
    echo "<a class='button' href='messages.php?view=$view'>" .
         "Voir $name messagerie</a><br><br>";
    die("</div></body></html>");
  }

  if (isset($_GET['add']))
  {
    $add = sanitizeString($_GET['add']);

    $result = queryMysql("SELECT * FROM friends WHERE user='$add' AND friend='$user'");
    if (!$result->num_rows)
      queryMysql("INSERT INTO friends VALUES ('$add', '$user')");
  }
  elseif (isset($_GET['remove']))
  {
    $remove = sanitizeString($_GET['remove']);
    queryMysql("DELETE FROM friends WHERE user='$remove' AND friend='$user'");
  }

  $result = queryMysql("SELECT user FROM members ORDER BY user");
  $num    = $result->num_rows;
  
  //membres en ligne
  
    function PIPHP_UsersOnline($datafile, $seconds)
{
$ip = getenv("REMOTE_ADDR") .
getenv("HTTP_USER_AGENT");
$out = "";
$online = 1;
if (file_exists($datafile))
{
$users = explode("\n",
rtrim(file_get_contents($datafile)));
foreach($users as $user)
{
list($usertime, $userip) = explode('|', $user);
if ((time() - $usertime) < $seconds &&
$userip != $ip)
{
$out .= $usertime . '|' . $userip . "\n";
++$online;
}
}
}
$out .= time() . '|' . $ip . "\n";
file_put_contents($datafile, $out);
return $online;
}
echo "Membres connect&eacutes : " . PIPHP_UsersOnline('users.txt', 300);
///////////
  echo "<h3>Autres membres</h3><ul>";

  for ($j = 0 ; $j < $num ; ++$j)
  {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if ($row['user'] == $user) continue;
    
    echo "<li><a href='members.php?view=" .
      $row['user'] . "'>" . $row['user'] . "</a>";
    $follow = "follow";

    $result1 = queryMysql("SELECT * FROM friends WHERE
      user='" . $row['user'] . "' AND friend='$user'");
    $t1      = $result1->num_rows;
    $result1 = queryMysql("SELECT * FROM friends WHERE
      user='$user' AND friend='" . $row['user'] . "'");
    $t2      = $result1->num_rows;

    if (($t1 + $t2) > 1) echo " &harr; est un ami mutuel";
    elseif ($t1)         echo " &larr; vous suivez";
    elseif ($t2)       { echo " &rarr; vous suis";
      $follow = "accepter"; }
    
    if (!$t1) echo " [<a href='members.php?add="   .$row['user'] . "'>$follow</a>]";
    else      echo " [<a href='members.php?remove=".$row['user'] . "'>ne plus suivre</a>]";
  }
?>

    </ul></div>
  </body>
</html>
