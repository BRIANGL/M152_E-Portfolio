<?php
/*
 *	Author	:	Golay Brian
 *	Class	:	P4B
 *	Date	:	2021/01/28
 *	Desc.	:	index page
  *	@todo Add the displaying function for posts
*/

require_once("./sql/postDAO.php");
require_once("./sql/mediaDAO.php");

use M152\sql\mediaDAO;
use M152\sql\postDAO;

// useless now
function display() {
    $display = '';

    $data = postDAO::readAll_post();
    $media= mediaDAO::readAll_media();
    $display = "";
    $tmp_name = "";
    $tmp_type = "";
    // list all the authorised extension
    $extensions = array("image" => array('.png', '.gif', '.jpg', '.jpeg'),
    "video" => array('.mp4', '.webm'),
    "audio" => array('.mp3', 'wav', 'ogg'));

    foreach ($data as $num ) {
        $display .= '<div class="panel panel-default">';
        foreach ($num as $key => $value) {
            switch ($key) {
                case 'idPost':
                    foreach ($media as $num_) {
                        foreach ($num_ as $key_ => $value_) {
                            switch ($key_) {
                                case 'typeMedia':
                                    $tmp_type = $value_;
                                    break;
                                    
                                case 'nameMedia':
                                    $tmp_name = $value_;
                                    break;
                                    
                                case 'idPost':
                                    if ($value_ == $value) {
                                        if (in_array($tmp_type, $extensions['image'])) {
                                            # image
                                            $display .= "<p><img name=\"".$tmp_name."\"". "src=\"./upload/" . $tmp_name . $tmp_type . "\" class=\"img-circle pull-right\"></p>";
                                        } else if (in_array($tmp_type, $extensions['video'])) {
                                            # video
                                            $display .= '<video preload="metadata" width="320" height="240" controls loop>
                                                <source src="./upload/'.$tmp_name.$tmp_type.'" type="video/mp4">
                                                Your browser does not support the video tag.
                                                </video>
                                            <li><p><strong>Note: </strong>The video tag is not supported in Internet Explorer 8 and earlier versions.</p></li>';
                                        } else if (in_array($tmp_type, $extensions['audio'])) {
                                            # audio
                                            $display .= '<li><audio controls preload="metadata">
                                            <source src="./upload/'.$tmp_name.$tmp_type.'" type="audio/'.$tmp_type.'">
                                            Your browser does not support the audio element.
                                            </audio></li>';
                                        }
                                    }
                                    break;
                            }
                        }
                    }
                    '<div class=\"panel-body\"><p><img src="assets/img/150x150.gif" class="img-circle pull-right"></p>';
                    break;

                case 'Txt_Commentaire':
                    $display .= "<div class=\"panel-body\"><p>" . $value . "</p>";
                    break;

                case 'Dttm_Creation':
                    $display .= "<div class=\"panel-heading\"><p = class=\"pull-right\">" . $value . "</p></div></div>";
                    break;

                case 'Dttm_Modification':
                    $display .= "<div class=\"panel-footer\">" . (($value != NULL) ? $value : "") . "</div>";
                    break;
            }
        }
        $display .= "</div>";
    }
    return $display;
}


function displayPost() {
    $display = '';

    $data = postDAO::readAll_post();
    $media= mediaDAO::readAll_media();
    $display = "";
    $tmp_name = "";
    $tmp_ext = "";
    $tmp_path = "";
    // list all the authorised extension
    $extensions = array("image" => array('png', 'gif', 'jpg', 'jpeg'),
    "video" => array('mp4', 'webm'),
    "audio" => array('mp3', 'wav', 'ogg', 'x-wav'));
    foreach ($data as $num ) {
        $display .= '<div class="panel panel-default">';
        foreach ($num as $key => $value) {
            switch ($key) {
                case 'idMedia':
                    foreach ($media as $num_) {
                        foreach ($num_ as $key_ => $value_) {
                            switch ($key_) {
                                case 'extension':
                                    $tmp_ext = $value_;
                                    break;
                                case 'nameMedia':
                                    $tmp_name = $value_;
                                    break;
                                case 'pathImg':
                                    $tmp_path = $value_;
                                    break;
                                case 'idPost':
                                    if ($value_ == $value) {
                                        if (in_array($tmp_ext, $extensions['image'])) {
                                            # image
                                            $display .= "<div class='panel-thumbnail'><img name='" . $tmp_name . "' src='" . $tmp_path . "' class='img-responsive'></div>";
                                        } else if (in_array($tmp_ext, $extensions['video'])) {
                                            # video
                                            $display .= '<video preload="metadata" width="320" height="240" controls loop>
                                                <source src="./'.$tmp_path.'" type="video/mp4">
                                                Your browser does not support the video tag.
                                                </video>
                                            <li><p><strong>Note: </strong>The video tag is not supported in Internet Explorer 8 and earlier versions.</p></li>';
                                        } else if (in_array($tmp_ext, $extensions['audio'])) {
                                            # audio
                                            $display .= '<li><audio controls preload="metadata">
                                            <source src="./'.$tmp_path.'" type="audio/'.$tmp_ext.'">
                                            Your browser does not support the audio element.
                                            </audio></li>';
                                        }
                                    }
                                    break;
                            }
                        }
                    }
                    break;

                case 'commentaire':
                    
                    $display .= "<div class=\"panel-body\"><p class=\"lead\">" . $value . "</p>";
                    break;

                case 'dateCreation':
                    $display .= "<p class=\"pull-left\"><p>45 Followers, 13 Posts</p><img src=\"assets/img/uFp_tsTJboUY7kue5XAsGAs28.png\" height=\"28px\" width=\"28px\"></p><p class=\"pull-right\">" . $value . "</p><a alt='Edit'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                    <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                  </svg></a><a alt='remove' style='margin-left: 1%;'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle' viewBox='0 0 16 16'>
                  <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                  <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                </svg></a>";
                    break;

                case 'dateModifiaction':
                    $display .= "<p>" . (($value != NULL) ? $value : "") . "</p>";
                    break;
                    $display .= "</div>";
            }
            
        }
        $display .= "</div></div>";
    }
    return $display;
}

function showWelcome(){
    echo "<h2>WELCOME</h2>";
}

/// template of posts
function showTemplate()
{
?>
    <div class="panel panel-default">
        <div class="panel-thumbnail"><img src="assets/img/bg_5.jpg" class="img-responsive"></div>
        <div class="panel-body">
            <p class="lead">Super Blog</p>
            <p>45 Followers, 13 Posts</p>
            <p><img src="assets/img/uFp_tsTJboUY7kue5XAsGAs28.png" height="28px" width="28px"></p>
        </div>
    </div>
<?php
}
?>