<?php
/*
 *  Author  :   Golay Brian
 *  Class   :   P4B
 *  Date    :   2021/01/28
 *  Desc.   :   publish post page
*/
require_once("./controllers/edit_controller.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="assets/css/facebook.css" rel="stylesheet">
    <title>M152 - Infobook - Edit</title>
</head>

<body>

    <div class="wrapper">
        <div class="box">
            <div class="row row-offcanvas row-offcanvas-left">


                <!-- main right col -->
                <div class="column col-sm-10 col-xs-11" id="main">
                    <?php require_once('assets/php/nav.php'); ?>


                    <div class="padding">
                        <div class="full col-sm-9">

                            <!-- content -->
                            <div class="row">

                                <!-- main col left -->
                                <div class="col-sm-5">

                                </div>

                                <!-- main col right -->
                                <div class="col-sm-7">
                                    <div id="loading"></div>
                                    <div id="Error"></div>
                                    <div id="userContent"><?php
                                                            echo (displayPost($id));
                                                            ?></div>
                                </div>
                            </div>
                            <!--/row-->

                            <div class="well">
                                <div class="col-sm-7">

                                </div>
                                <form method="post" class="form-horizontal" role="form" action="./index.php?page=uploadEdit&id=<?= $id ?>" enctype="multipart/form-data">
                                    <h4>What's New</h4>
                                    <div class="form-group" style="padding:14px;">
                                        <textarea name="msg" class="form-control" placeholder="Change the text..."></textarea>
                                    </div>
                                    <button name="action" class="btn btn-primary pull-right" type="submit" value="send">Publish</button>

                                    <ul class="list-inline">
                                        <!-- Image tag -->
                                        <li>
                                            <input type="file" files name="media[]" multiple accept=".png, .gif, .jpg, .jpeg, .mp4, .webm, .mp3, .wav, .ogg">(.gif,.png,.jpeg,.jpg,.mp4,.webm,.mp3,.wav,.ogg only)
                                        </li>
                                        <li>
                                            <div class="preview">
                                                <p>
                                                <p>
                                            </div>
                                        </li>
                                    </ul>
                                </form>
                            </div>


                        </div><!-- /col-9 -->
                    </div><!-- /padding -->




                </div>
            </div>

            <!--browse modal-->
            <div id="browseModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">�</button>
                            Update Status
                        </div>
                        <div class="modal-body">
                            <form class="form center-block">
                                <div class="form-group">
                                    <textarea class="form-control input-lg" autofocus="" placeholder="What do you want to share?"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <div>
                                <button class="btn btn-primary btn-sm" style="background-color : #003827" data-dismiss="modal" aria-hidden="true">Post</button>
                                <ul class="pull-left list-inline">
                                    <li><a href=""><i class="glyphicon glyphicon-upload"></i></a></li>
                                    <li><a href=""><i class="glyphicon glyphicon-camera"></i></a></li>
                                    <li><a href=""><i class="glyphicon glyphicon-map-marker"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Code pour le Javascript --->
            <script type="text/javascript">
                function deleteJS(idToDelete) {
                    var loadingDiv = document.getElementById("loading");
                    var userContentDiv = document.getElementById("userContent");
                    var errorDiv = document.getElementById("Error");
                    var idPoste = document.getElementById("idPoste").value;
                    
                    if (idToDelete == null) {
                        errorDiv.innerHTML = "Error";
                        return;
                    } else {
                        loadingDiv.innerHTML = "<img src='./assets/img/loading.gif' alt='loading'>";
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                loadingDiv.innerHTML = ""
                                userContentDiv.innerHTML = this.responseText;
                            }
                        };
                        xmlhttp.open("GET", "index.php?page=ajax&idImg=" + idToDelete + "&IdPoste=" + idPoste, true);
                        xmlhttp.send();
                    }
                }
            </script>
        </div>
    </div>
</body>

</html>