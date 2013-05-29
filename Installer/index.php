<!Doctype html>
<html>
    <!--
        
    -->
    <head>
        <title>AnubisApp Installer</title>
        <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
        <script src="js/installer.js"></script>
    </head>
    
    <body>
    
        <div class="container">
            <div class="row">
                <div class="span12">
                        <h1>AnubisApp Installer</h1>
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
                        <div class="nav">    
                            <button class="btn btn-primary" id="btnDBCreate">Create Database</button>
                            <button class="btn btn-primary" id="btnDBUpdate">Upgrade Database</button>
                        </div>
                        <div id="result">
                        </div>
                </div>
            </div>
        </div>
        
    </body>
    
</html>