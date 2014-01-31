<?php
/*
* home.php 
* Description: example file for displaying latest posts and topics
* by battye (for phpBB.com MOD Team)
* September 29, 2009
*/

define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : 'phpBB3/';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'includes/bbcode.' . $phpEx);
include($phpbb_root_path . 'includes/functions_display.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup('viewforum');
/* create_where_clauses( int[] gen_id, String type )
* This function outputs an SQL WHERE statement for use when grabbing 
* posts and topics */

function create_where_clauses($gen_id, $type)
{
global $db, $auth;

    $size_gen_id = sizeof($gen_id);

        switch($type)
        {
            case 'forum':
                $type = 'forum_id';
                break;
            case 'topic':
                $type = 'topic_id';
                break;
            default:
                trigger_error('No type defined');
        }

    // Set $out_where to nothing, this will be used of the gen_id
    // size is empty, in other words "grab from anywhere" with
    // no restrictions
    $out_where = '';

    if( $size_gen_id > 0 )
    {
    // Get a list of all forums the user has permissions to read
    $auth_f_read = array_keys($auth->acl_getf('f_read', true));

        if( $type == 'topic_id' )
        {
            $sql     = 'SELECT topic_id FROM ' . TOPICS_TABLE . '
                        WHERE ' .  $db->sql_in_set('topic_id', $gen_id) . '
                        AND ' .  $db->sql_in_set('forum_id', $auth_f_read);

            $result     = $db->sql_query($sql);

                while( $row = $db->sql_fetchrow($result) )
                {
                        // Create an array with all acceptable topic ids
                        $topic_id_list[] = $row['topic_id'];
                }

            unset($gen_id);

            $gen_id = $topic_id_list;
            $size_gen_id = sizeof($gen_id);
        }

    $j = 0;    

        for( $i = 0; $i < $size_gen_id; $i++ )
        {
        $id_check = (int) $gen_id[$i];

            // If the type is topic, all checks have been made and the query can start to be built
            if( $type == 'topic_id' )
            {
                $out_where .= ($j == 0) ? 'WHERE ' . $type . ' = ' . $id_check . ' ' : 'OR ' . $type . ' = ' . $id_check . ' ';
            }

            // If the type is forum, do the check to make sure the user has read permissions
            else if( $type == 'forum_id' && $auth->acl_get('f_read', $id_check) )
            {
                $out_where .= ($j == 0) ? 'WHERE ' . $type . ' = ' . $id_check . ' ' : 'OR ' . $type . ' = ' . $id_check . ' ';
            }    

        $j++;
        }
    }

    if( $out_where == '' && $size_gen_id > 0 )
    {
        trigger_error('A list of topics/forums has not been created');
    }

    return $out_where;
}
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
	    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function(){
		//$('#recent_content').load('ticker.html');
		$('#wiki_content').load('wiki_ticker.html');
		});
		</script>
    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="main.css" rel="stylesheet">

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
          <a class="navbar-brand" href="index.html">Scioly.org</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
			<li class="active"><a href="#">Home</a></li>
            <li><a href="phpBB3/index.php">Forums</a></li>
            <li><a href="wiki">Wiki</a></li>
            <li><a href="wiki/index.php/2014_Test_Exchange">Test Exchange</a></li>
            <li><a href="#">Image Gallery</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">
		<div class="centered">
				<div class="Slideshow">
						<div id="sliderFrame">
								<div id="slider">
									<a href="http://www.menucool.com/javascript-image-slider" target="_blank">
										<img src="images/image1.jpg" />
									</a>
								   <img src="images/image2.JPG" />
									<img src="images/image3.JPG"  />
									<img src="images/image4.JPG"/>
									<img src="images/image5.jpg" />
								</div>
						</div>
				</div>
		</div>
			<!--<div class="links_bar">
					<ul>
						<li><a href="forums"><img src="http://www.scioly.org/phpBB3/styles/skyblue2/theme/images/forums_icon.png"/> Forums</a></li>
						<li><a href="wiki"><img src="http://www.scioly.org/phpBB3/styles/skyblue2/theme/images/wiki_icon.png"/> Wiki</a></li>
						<li><a href="test_ex"><img src="http://www.scioly.org/phpBB3/styles/skyblue2/theme/images/testex_miz.png"/> Test Exchange</a></li>
						<li><a href="gallery"><img src="http://www.scioly.org/phpBB3/styles/skyblue2/theme/images/imagegal_icon.png"/> Image Gallery</a></li>
					</ul>
				
				
				</div>-->
		<div class="lower_side">
				<div class="Recent_Posts">
					<h2>Recent Posts</h2><br/>
					<?php
$search_limit = 5;

    //$forum_id = array(1,50);
    $forum_id_where = create_where_clauses($forum_id, 'forum');

    //$topic_id = array(20, 50);
    $topic_id_where = create_where_clauses($topic_id, 'topic');
$posts_ary = array(
        'SELECT'    => 'p.*, t.*, u.username, u.user_colour',
    
        'FROM'      => array(
            POSTS_TABLE     => 'p',
        ),
    
        'LEFT_JOIN' => array(
            array(
                'FROM'  => array(USERS_TABLE => 'u'),
                'ON'    => 'u.user_id = p.poster_id'
            ),
            array(
                'FROM'  => array(TOPICS_TABLE => 't'),
                'ON'    => 'p.topic_id = t.topic_id'
            ),
        ),
    
        'WHERE'     => $db->sql_in_set('t.forum_id', array_keys($auth->acl_getf('f_read', true))) . '
                        AND t.topic_status <> ' . ITEM_MOVED . '
                         AND t.topic_approved = 1',
    
        'ORDER_BY'  => 'p.post_id DESC',
    );
    
    $posts = $db->sql_build_query('SELECT', $posts_ary);

   $posts_result = $db->sql_query_limit($posts, $search_limit);

      while( $posts_row = $db->sql_fetchrow($posts_result) )
      {
         $topic_title       = $posts_row['topic_title'];
         $post_author       = get_username_string('full', $posts_row['poster_id'], $posts_row['username'], $posts_row['user_colour']);
         $post_date          = $user->format_date($posts_row['post_time']);
         $post_link       = append_sid("{$phpbb_root_path}viewtopic.$phpEx", 'f=' . $posts_row['forum_id'] . '&amp;t=' . $posts_row['topic_id'] . '&amp;p=' . $posts_row['post_id']) . '#p' . $posts_row['post_id'];

         $post_text = nl2br($posts_row['post_text']);

         $bbcode = new bbcode(base64_encode($bbcode_bitfield));         
         $bbcode->bbcode_second_pass($post_text, $posts_row['bbcode_uid'], $posts_row['bbcode_bitfield']);

         $post_text = smiley_text($post_text);
		 echo $post_author.' posted in <a href="'.$post_link.'">'.censor_text($topic_title).'</a><br/>';
         /*$template->assign_block_vars('announcements', array(
         'TOPIC_TITLE'       => censor_text($topic_title),
         'POST_AUTHOR'       => $post_author,
         'POST_DATE'       => $post_date,
         'POST_LINK'       => $post_link,
         'POST_TEXT'         => censor_text($post_text),
         ));*/
      }
      
      ?>

					<div id="recent_content"></div>
				
				</div>
				<div class="wiki_edits">
					<h2>Recent Wiki Edits</h2>
					<div id="wiki_content"></div>
				</div>
		</div>
		<div class="links_bar">
					<ul>
						<li><a href="phpBB3/index.php"><img src="http://www.scioly.org/phpBB3/styles/skyblue2/theme/images/forums_icon.png"/> Forums</a></li>
						<li><a href="wiki"><img src="http://www.scioly.org/phpBB3/styles/skyblue2/theme/images/wiki_icon.png"/> Wiki</a></li>
						<li><a href="wiki/index.php/2014_Test_Exchange"><img src="http://www.scioly.org/phpBB3/styles/skyblue2/theme/images/testex_miz.png"/> Test Exchange</a></li>
						<li><a href="#"><img src="http://www.scioly.org/phpBB3/styles/skyblue2/theme/images/imagegal_icon.png"/> Image Gallery</a></li>
					</ul>
				
				
				</div>
	</div><!-- /.container -->



  </body>
</html>
