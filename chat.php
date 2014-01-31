<?php
echo '<META HTTP-EQUIV=Refresh CONTENT=".01; URL=mibbit.php">';
$phpEx = 'php'; // Added to define the variable as the appropriate extension, no extension.inc file in phpBB3
define('IN_PHPBB', true);
$phpbb_root_path = './phpBB3/'; // set this as the path to your phpBB installation
// include($phpbb_root_path . 'extension.inc'); // This is no longer valid. phpBB3 no longer utilizes extension.inc
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/functions_user.'.$phpEx);


//
// Start session management
//
$user->session_begin();
$auth->acl($user->data);
$userdata = $user->data;

//
// End session management
//

function is_valid_nickname($nickname)
{
        if($nickname != '')
        {
                for($i = 0, $maxi = strlen($nickname); $i < $maxi; $i++)
                {
                        $code = ord($nickname[$i]);
                        if( !(($i > 0 && ( $code == 45 || ($code >= 48 && $code <= 57) )) || ($code >= 65 && $code <= 125)) ) break;
                }
                return ($i == $maxi);
        }
}

if($user->data['user_id'] != ANONYMOUS)
{
        $nickname = is_valid_nickname($user->data['username']) ? $user->data['username'] : '';
}
else
{
        $nickname = '';
}

if( !is_valid_nickname($nickname) )
{
        $nickname = 'SciOly_Gue|'.chr(mt_rand(65, 90)).chr(mt_rand(97, 122)).chr(mt_rand(97, 122));
}

$uri = 'http://embed.mibbit.com/?nick='.$nickname
.'&settings=02adeedfac534dcdac2fc3cc3f007a5c'
.'&server=irc.chat4all.net:6667'
.'&chatOutputShowTimes=true'
.'&channel=%23scioly'
//.'&channel=%23scioly,%23scioly.trivia'
.'&noServerNotices=true'
.'&noServerMotd=true'
.'&focusNewJoins=false'

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">
	<link href="themes/1/js-image-slider.css" rel="stylesheet" type="text/css" />
    <script src="themes/1/js-image-slider.js" type="text/javascript"></script>
    <link href="generic.css" rel="stylesheet" type="text/css" />
    <title>Scioly.org</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.css" rel="stylesheet">
    <link href="main.css" rel="stylesheet">
      <style>
          body{
      overflow:hidden;
          }
      </style>
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html"><img
          src="logo-white.png" height="50px" width="170px"</img></a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
			<li ><a href="index.html">Home</a></li>
            <li><a href="phpBB3/index.php">Forums</a></li>
            <li><a href="wiki">Wiki</a></li>
            <li><a href="wiki/index.php/2014_Test_Exchange">Test Exchange</a></li>
            <li class="active"><a href="chat.html">Chat</a></li>
            <li><a href="#">Image Gallery</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
<?php
echo "<iframe src=\"https://kiwiirc.com/client/irc.chat4all.net/?nick=".$nickname."#scioly\" style=\"border:0; width:100%; min-height: 90%; height:550px; .tabs{background-color:#FFF;}\"></iframe>";
?>
