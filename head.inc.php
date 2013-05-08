<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Anubis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
<link rel="icon" href="favicon.ico" />
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
<style type="text/css">
          /* Sticky footer styles
      -------------------------------------------------- */

      html,
      body {
        height: 100%;
        /* The html and body elements cannot have any padding or margin. */
      }

      /* Wrapper for page content to push down footer */
      #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        /* Negative indent footer by it's height */
        margin: 0 auto -60px;
      }

      /* Set the fixed height of the footer here */
      #push,
      #footer {
        height: 60px;
      }
      #footer {
        background-color: #f5f5f5;
      }

      /* Lastly, apply responsive CSS fixes as necessary */
      @media (max-width: 767px) {
        #footer {
          margin-left: -20px;
          margin-right: -20px;
          padding-left: 20px;
          padding-right: 20px;
        }
      }
    
      .container .credit {
        margin: 20px 0;
      }
</style>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="wrap">
    <div class="container">
        <div class="masthead">
            <h3 class="muted">Anubis</h3>
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="container">
                        <ul class="nav">        
                            <?php
                            $pages = array("Home" => "index.php",
                                         "Read-Only" => "read-only/index.php",
                                         "Accounts" => "accounts.php",
                                         "Configuration" => "config.php",
                                         "FAQ" => "faq.php",
                                         "Contact/Donate" => "contact.php");
                            
                                    $page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
                            
                                  foreach ($pages as $key => $value)
                                  {
                                    if  ($value == $page) {
                                        $selected = "class='active'";
                                    } else {
                                        $selected = "";
                                    }
                            
                                    echo "<li ".$selected."><a href='".$value."'>".$key."</a></li>";
                                  }
                            ?>
                        </ul>
                    </div>
                </div>
            </div><!-- /.navbar -->
        </div>
        <div class="row-fluid">    