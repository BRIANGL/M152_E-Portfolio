<?php
/*
 *  Author  :   Golay Brian
 *  Class   :   P4B
 *  Date    :   2021/01/28
 *  Desc.   :   publish post page
 *  @TO-DO  :   Gestion des fichiers type audio/video
*/
require_once("./controllers/post_controller.php");
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
    <title>M152 - Infobook - Post</title>
</head>
<body>

<div class="wrapper">
	<div class="box">
		<div class="row row-offcanvas row-offcanvas-left">
			
			<!-- main right col -->
			<div class="column col-sm-10 col-xs-11" id="main">
				<?php require_once('assets/php/nav.php'); ?>
                <div class="well"> 
	            	<form method="post" class="form-horizontal" role="form" action="./index.php?page=upload" enctype="multipart/form-data">
	            	    <h4>What's New</h4>
	            	    <div class="form-group" style="padding:14px;">
	            	        <textarea name="msg" class="form-control" placeholder="Write something..."></textarea>
	            	    </div>
                        <button name="action" class="btn btn-primary pull-right" type="submit" value="send">Publish</button>
                        
                        <ul class="list-inline">
                            <!-- Image tag -->
                            <li>
                                <input type="file" files name="media[]" multiple accept=".png, .gif, .jpg, .jpeg">(.gif,.png,.jpeg,.jpg only)
                            </li>
                            <li><div class="preview"><p>No files currently selected for upload<p></div></li>
                        </ul>
	            	</form>
	            </div>
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
	    				<ul class="pull-left list-inline"><li><a href=""><i class="glyphicon glyphicon-upload"></i></a></li><li><a href=""><i class="glyphicon glyphicon-camera"></i></a></li><li><a href=""><i class="glyphicon glyphicon-map-marker"></i></a></li></ul>
	    	  		</div>	
	      		</div>
  	    	</div>
  	    </div>
    </div>
<!-- Code pour le Javascript --->
<script type="text/javascript">

    // modal
	$(document).ready(function() {
		$('[data-toggle=offcanvas]').click(function() {
			$(this).toggleClass('visible-xs text-center');
			$(this).find('i').toggleClass('glyphicon-chevron-right glyphicon-chevron-left');
			$('.row-offcanvas').toggleClass('active');
			$('#lg-menu').toggleClass('hidden-xs').toggleClass('visible-xs');
			$('#xs-menu').toggleClass('visible-xs').toggleClass('hidden-xs');
			$('#btnShow').toggle();
		});
	});

    var input = document.querySelector('input');
    var preview = document.querySelector('.preview');

    var fileTypes = [
        'image/jpeg',
        'image/pjpeg',
        'image/png'
    ];
    

    // Input type file

    function validFileType(file) {
        for(var i = 0; i < fileTypes.length; i++) {
            if(file.type === fileTypes[i]) {
              return true;
            }
        }
        return false;
    }

    function returnFileSize(number) {
        if(number < 1024) {
            return number + 'bytes';
        } else if(number >= 1024 && number < 1048576) {
            return (number/1024).toFixed(1) + 'KB';
        } else if(number >= 1048576) {
            return (number/1048576).toFixed(1) + 'MB';
        }
    }

    function updateImageDisplay() {
        while (preview.firstChild) {
            preview.removeChild(preview.firstChild);
        }
        var currentFiles = input.files;
        if (currentFiles.length === 0) {
            var para = document.createElement('p');
            para.textContent = 'No files selected for upload';
            preview.appendChlild(para);
        } else {
            var list = document.createElement('ol');
            preview.appendChild(list);
            for (let i = 0; i < array.length; i++) {
                var item = document.createElement('li');
                var para = document.createElement('p');
                if (validFileType(currentFiles[i])) {
                    para.textContent = 'File name' + currentFiles[i].name + ', file size ' + returnFileSize(currentFiles[i].size) + '.';
                    var image = document.createElement('img');
                    image.src = window.URL.createObjectURL(currentFiles[i].name + ': Not a valid file type. Update your selection.');
                    item.appendChild(image);
                    item.appendChild(para);
                } else {
                    para.textContent = 'File name ' + currentFiles[i].name + ': Not a valid file type. Update your selection.';
                    item.appendChild(para);
                }
                item.appendChild(item);
            }
        }
    }
    input.addEventListener('change', updateImageDisplay);
    
$(document).ready(function() {
		$('[data-toggle=offcanvas]').click(function() {
			$(this).toggleClass('visible-xs text-center');
			$(this).find('i').toggleClass('glyphicon-chevron-right glyphicon-chevron-left');
			$('.row-offcanvas').toggleClass('active');
			$('#lg-menu').toggleClass('hidden-xs').toggleClass('visible-xs');
			$('#xs-menu').toggleClass('visible-xs').toggleClass('hidden-xs');
			$('#btnShow').toggle();
		});
	});
</script>
</div>
</div>
</body>
</html>