<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Super</title>
        <?php
        global $siteRoot;
        echo '<link rel="stylesheet" href="' . $siteRoot . 'static/lib/bootstrap-3.3.7-dist/css/bootstrap.min.css">';
        echo '<link rel="stylesheet" href="' . $siteRoot . 'static/lib/bootstrap-validator/css/bootstrapValidator.css">';
        echo '<link rel="stylesheet" href="' . $siteRoot . 'static/css/style.css">';
        echo '<link rel="stylesheet" href="' . $siteRoot . 'static/lib/jquery.dataTables.css">';
        echo '<script src="' . $siteRoot . 'static/lib/jquery-3.2.1.min.js"></script>';
        echo '<script src="' . $siteRoot . 'static/lib/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>';
        echo '<script src="' . $siteRoot . 'static/lib/bootstrap-validator/bootstrapValidator.js"></script>';
        echo '<script src="' . $siteRoot . 'static/lib/jquery.dataTables.js"></script>';
        echo '<script src="' . $siteRoot . 'static/js/common.js"></script>';
        ?>
    </head>
    <body>
        <div id="header" class="container">
            <div class="logo col-md-4">
                <a href="<?php echo $siteRoot . 'admin'; ?>">
                    <img src="<?php echo $siteRoot . 'static/images/logo.png'; ?>" alt="Super" />
                </a>
            </div>
            <?php
            if (isLoggedIn()) {
                global $docRoot;
                include_once $docRoot . 'commonFiles/globalLinks.php';
                include_once $docRoot . 'commonFiles/menubar/mainMenu.php';
            }
            ?>
        </div>

        <div id="body" class="container">
