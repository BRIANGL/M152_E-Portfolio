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
                    $display .= "<p class=\"pull-left\"><p>45 Followers, 13 Posts</p><img src=\"assets/img/uFp_tsTJboUY7kue5XAsGAs28.png\" height=\"28px\" width=\"28px\"></p><p = class=\"pull-right\">" . $value . "</p>";
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
            <p class="lead">`Txt_Commentaire`</p>
            <p>45 Followers, 13 Posts</p>
            <p><img src="assets/img/uFp_tsTJboUY7kue5XAsGAs28.png" height="28px" width="28px"></p>
        </div>
    </div>
<?php
}
?>