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

    <style type="text/css">
    html,
    body {
        height: 100%;
    }

    #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        margin: 0 auto -60px;
    }

    #push, #footer {
        height: 60px;
    }
    #footer {
        background-color: #f5f5f5;
    }

    @media (max-width: 767px) {
        #footer {
            margin-left: -20px;
            margin-right: -20px;
            padding-left: 20px;
            padding-right: 20px;
        }
    }
    #wrap > .container {
        padding-top: 60px;
    }
    .container .credit {
        margin: 20px 0;
    }

    code {
        font-size: 80%;
    }

    .left {
        float: left !important;
    }
    .right{
        float: right !important;
    }
    </style>

    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-responsive.min.css" rel="stylesheet">
    <!--[if IE]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
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
                                "Accounts" => "accounts.php",
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