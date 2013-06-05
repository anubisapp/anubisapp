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
                <h2>Database details</h2>
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
            
            <div id="panel-2" class="hidden">    
                <p id="installTxt"></p>
                <button class="btn btn-primary" id="btnDBCreate" onclick="createDatabase()">Create Database</button>
                <button class="btn btn-primary" id="btnDBUpdate" onClick="updateTables()">Upgrade Database</button>
            </div>
            
            <div id="panel-3" class="hidden">
                <h2>Not yet implemented</h2>
                <h2>Installation Complete</h2>
                <ul>
                    <li>Check if installation was successful</li>
                    <li>Save Database details to config.php</li>
                    <li>Delete installer folder? or prompt for user to delete it?</li>
                </ul>
            </div>
            
            <button class="btn btn-primary" id="btnPrev">Previous</button>
            <button class="btn btn-primary" id="btnNext">Next</button>
            <div id="result"></div>
        </div>
        
    </body>
    
</html>