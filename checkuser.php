<?php // checkuser.php
  require_once 'functions.php';

  if (isset($_POST['user']))
  {
    $user   = sanitizeString($_POST['user']);
    $result = queryMysql("SELECT * FROM members WHERE user='$user'");

    if ($result->num_rows)
      echo  "<span class='taken'>&nbsp;&#x2718; " .
            "Cet identifiant est d&eacutej&agrave pris</span>";
    else
      echo "<span class='available'>&nbsp;&#x2714; " .
           "Cet identifiant est disponible</span>";
  }
?>
