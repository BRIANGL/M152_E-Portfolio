<?php
/*
 *	Author	:	Golay Brian
 *	Class	:	P4B
 *	Date	:	2021/01/28
 *	Desc.	:	index page
*/


use M152\sql\UserDAO;

// variable page qui va etre utile pour rediriger les liens
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);

if ($page == null) {
    header('location: index.php?page=homepage');
}

if (isset($page)) {

    switch ($page) {
        case 'homepage':
            require("./pages/index.php");
            break;
        case 'upload':
            require("./pages/upload.php");
            break;
        case 'post':
            require("./pages/post.php");
            break;
        case 'delete':
            require("./pages/delete.php");
            break;
        case 'edit':
            require("./pages/edit.php");
            break;
        case 'uploadEdit':
            require("./pages/uploadEdit.php");
            break;
    }
} else {
    require("./pages/index.php");
}
