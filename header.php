
<?php // header.php
  session_start();

  echo "<!DOCTYPE html>\n<html><head>".
  
		"<a  href='http://ece.fr'>ECE PARIS</a><br />";
		
	

  require_once 'functions.php';

  $userstr = ' (Spectateur)';

  if (isset($_SESSION['user']))
  {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = " ($user)";
  }
  else $loggedin = FALSE;

  echo "<title>$appname$userstr</title><link rel='stylesheet' " .
       "href='styles.css' type='text/css'>"                     .
       "</head><body><center><canvas id='logo' width='624' "    .
       "height='96'>$appname</canvas></center>"             .
       "<div class='appname'>$appname$userstr</div>"                   .
       "<script src='javascript.js'></script>";


  if ($loggedin)
  {
    echo "<br ><ul class='menu'>" .
         "<li><a href='members.php?view=$user'>Accueil</a></li>" .
         "<li><a href='members.php'>Membres</a></li>"         .
         "<li><a href='friends.php'>Followers</a></li>"         .
         "<li><a href='messages.php'>Messages</a></li>"       .
         "<li><a href='profile.php'>Profil</a></li>"    .
         "<li><a href='logout.php'>Se D&eacuteconnecter</a></li></ul><br>";
  }
  else
  {
    echo ("<br><ul class='menu'>" .
          "<li><a href='index.php'>Accueil</a></li>"                .
          "<li><a href='signup.php'>S'inscrire</a></li>"            .
          "<li><a href='login.php'>Se connecter</a></li></ul><br>"     .
          "<span class='info'>&#8658; Vous devez &ecirctre connect&eacute pour " .
          "voir cette page.</span><br><br>");
  }
?>
