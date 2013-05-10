<?php
/* ==========================================================
 * AnubisApp v1.0.0
 * http://anubisapp.com
 * ==========================================================
 *
 * @author     Matthew Evans - https://github.com/add1ct3dd
 * @author     Tristan van Bokkem - https://github.com/tristanvanbokkem
 * @copyright  2013 AnubisApp Team
 * ========================================================== */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>AnubisApp - A cgminer monitoring and configuration tool.</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
    <link href="assets/css/anubisapp.css" rel="stylesheet">
    <!--[if IE]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div id="wrap">
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="index.php">AnubisApp</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <?php
                            $pages = array(
                                "Home" => "index.php",
                                "Configuration" => "config.php",
                                "FAQ" => "faq.php",
                                "Contact/Donate" => "contact.php");

                            $page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

                            foreach ($pages as $key => $value)
                            {
                                if  ($value == $page)
                                {
                                    $selected = "class='active'";
                                }
                                else if ($page == 'allgpus.php')
                                {
                                    if ($value == 'index.php')
                                    {
                                        $selected = "class='active'";
                                    }
                                    else
                                    {
                                        $selected = "";
                                    }
                                }
                                else
                                {
                                    $selected = "";
                                }
                                echo "<li ".$selected."><a href='".$value."'>".$key."</a></li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>