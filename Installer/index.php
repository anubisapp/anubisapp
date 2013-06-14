<!Doctype html>
<html>
    <head>
        <title>AnubisApp Installer</title>
        <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
        <script src="js/installer.js"></script>
        <style>
        .hidden {
            display: none;   
        }   
        .navbuttons {
            margin: 3px 0px 3px 0px;
        }
        </style>
    </head>
    
    <body>
    
        <div class="container">
            <h1>AnubisApp Installer</h1>
            <div class="row">
                <div class="span12" id="cp">

                </div>
            </div>
            
            <div id="panel-1" class="hidden">
                <p>
                    Welcome to the anubisapp installer.
                </p>
                <p>
                    To begin installing or upgrading anubisapp click next.
                </p>
            </div>
            
            <div id="panel-2" class="hidden">
                <h2>User authentication</h2>
                <p>
                    please enter a username and password, this will be used to login to anubisapp.
                </p>
                <form>
                    <fieldset>
                        <label>Username</label>
                        <input type="text" placeholder="username" id="txt_loginname" />
                        <label>Password</label>
                        <input type="password" placeholder="password" id="txt_loginpassword" />
                    </fieldset>
                </form>
            </div>
            
            <div id="panel-3" class="hidden">
                <h2>Database details</h2>
                    <p>Please enter the details so we can connect to your database</p>
                    <p>If you have not changed your database login details then the default values should work.</p>
                    <div id="panel">
                        <form>
                            <fieldset>
                                <label>MySQL User</label>
                                <input type="text" placeholder="root" id="txt_username" value="root" />
                                <label>MySQL Password</label>
                                <input type="password" placeholder="" id="txt_pass" value="" />
                                <label>MySQL Database Name</label>
                                <input type="text" placeholder="anubis" id="txt_db" value="anubis" />
                                <label>Database Host</label>
                                <input type="text" placeholder="localhost" id="txt_host" value="localhost" />
                            </fieldset>
                        </form>                            
                    </div>
            </div>
            
            <div id="panel-4" class="hidden">    
                <p id="installTxt"></p>
                <button class="btn btn-primary" id="btnDBCreate" onclick="createDatabase()">Create Database</button>
                <button class="btn btn-primary" id="btnDBUpdate" onClick="updateTables()">Upgrade Database</button>
            </div>
            
            <div id="panel-5" class="hidden">
                <h2>Installation Complete</h2>
                <p>
                    Anubis app has finished installing, your database connection details have been written to config.inc.php.
                </p>
                <p>
                    Please delete the installer folder from the root folder of your anubisapp.
                </p>
            </div>
            
            <div class="navbuttons">
                <button class="btn btn-primary" id="btnPrev">Previous</button>
                <button class="btn btn-primary" id="btnNext">Next</button>
            </div>
            <div id="result"></div>
        </div>
        
    </body>
    
</html>