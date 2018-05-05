<?php // index.php
  require_once 'header.php';

  echo "<br><span class='main'>Bienvenue sur $appname,";

  if ($loggedin) echo " $user, vous êtes connect&eacutes.";
  else           echo ' <p style="text-indent:2em"> Inscrivez-vous s-il-vous pla&icirct et/ou connectez-vous pour rejoindre.';
  
  echo '<br><br>';
  
  //youtube
  function PIPHP_EmbedYouTubeVideo($id, $width, $height, $hq,
$full, $auto)
{
if ($hq == 1) $q = "&ap=%2526fmt%3D18";
else $q = "";
return <<<_END
<object width="$width" height="$height">
<param name="movie"
value="http://www.youtube.com/v/$id&fs=1&autoplay=$auto$q">
</param>
<param name="allowFullScreen" value="true"></param>
<param name="allowscriptaccess" value="always"></param>
<embed src="http://www.youtube.com/v/$id&fs=1&autoplay=$auto$q"
type="application/x-shockwave-flash"
allowscriptaccess="always" allowfullscreen="true"
width="$width" height="$height"></embed></object>
_END;
}

echo PIPHP_EmbedYouTubeVideo("XnBPK1VfQ_A", 700, 300, 1, 1, 0);
  
  
  //copyright
function PIPHP_RollingCopyright($message, $year)
{
return "$message &copy;$year-" . date("Y");
}
  echo '<p style="text-indent:2em">'.
  PIPHP_RollingCopyright("Tous droits r&eacuteserv&eacutes", 2018);
  
  
  ///////compteur///////
  function PIPHP_HitCounter($filename, $action)
{
$data = getenv("REMOTE_ADDR") .
getenv("HTTP_USER_AGENT") . "\n";
switch ($action)
{
case "reset":
$fp = fopen($filename, "w");
if (flock($fp, LOCK_EX))
;
flock($fp, LOCK_UN);
fclose($fp);
return;
case "add":
$fp = fopen($filename, "a+");
if (flock($fp, LOCK_EX))
fwrite($fp, $data);
flock($fp, LOCK_UN);
fclose($fp);
return;
case "get":
$fp = fopen($filename, "r");
if (flock($fp, LOCK_EX))
$file = fread($fp, filesize($filename) - 1);
flock($fp, LOCK_UN);
fclose($fp);
$lines = explode("\n", $file);
$raw = count($lines);
$unique = count(array_unique($lines));
return array($raw, $unique);
case "delete":
unlink($filename);
return;
}
}
  
  
  PIPHP_HitCounter("counter.txt", "add");
  $result = PIPHP_HitCounter("counter.txt", "get");
  echo " Visiteurs : $result[0] / Unique : $result[1]";
  
  
  
  
?>

    </span><br><br>
  </body>
</html>
