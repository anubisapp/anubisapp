<?php
require("config.inc.php");
require("func.inc.php");

$dbh = anubis_db_connect();

if (isset($_POST['saveconf'])) {
    $error = false;
    $fieldList = array('updatetime', 'yellowtemp', 'maxtemp', 'yellowrejects', 'maxrejects', 'yellowdiscards', 'maxdiscards', 'yellowstales', 'maxstales', 'yellowgetfails', 'maxgetfails', 'yellowremfails', 'maxremfails', 'yellowfan', 'maxfan', 'yellowgessper', 'maxgessper', 'yellowavgmhper', 'email');
	$updstring = "";

    foreach ($fieldList as $field) {
        if (!empty($_POST[$field])) {
            $updstring .= $field." = ".$dbh->quote($_POST[$field]).", ";
        } else {
            $error = true;
            $errored[] = $field;
        }
    }

    if (!$error) {
        
        $updstring = substr($updstring,0,-2);
        $updstring = "UPDATE configuration SET ".$updstring."";
        $updcr = $dbh->query($updstring);
        
        if (db_error()) {
            $message = '<strong>Error</strong> Could not save the configuration settings.';
            $type = 'alert-error';
        } else {
            $message = '<strong>Success!</strong> Your configuration has been updated successfully.';
            $type = 'alert-success';
        }
    } else {
        $errorFields = implode(", ", $errored);
        $message = '<strong>Error!</strong> Please fill in '.$errorFields.'.';
        $type = 'alert-error';
    }
}

$configq = $dbh->query('SELECT * FROM configuration');
db_error();

$config = $configq->fetch(PDO::FETCH_OBJ);

?>

<?php include ('head.inc.php'); ?>

    <div class="container">
        <div class="page-header">
            <?php 
                if (isset($_POST['saveconf'])) 
                    echo alert($message, $type); 
            ?>
            <div class="row-fluid">
                <div class="left">
                    <h1>Configuration</h1>
                </div>
            </div>
        </div>

		<form id="save" name="save" action="config.php" method="post" class="form-horizontal">
            <div class="row-fluid">
                <div class="span6">
                    <h4>General</h4>
                    <hr>
                    <div class="control-group">
                        <label class="control-label" for="updatetime">Refresh Rate (seconds)</label>
                        <div class="controls">
                            <input type="text" name="updatetime" class="input-mini" placeholder="5" value="<?php echo $config->updatetime?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="email">Notification Address</label>
                        <div class="controls">
                            <input type="text" name="email" placeholder="some@email.com" value="<?php echo $config->email?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="yellowtemp">GPU Temperature</label>
                        <div class="controls">
                            <div class="input-append">
                                <input type="text" name="yellowtemp" class="input-mini" placeholder="80" value="<?php echo $config->yellowtemp?>">
                                <span class="add-on">&deg;C</span>
                            </div>
                            <div class="input-append">
                                <input type="text" name="maxtemp" class="input-mini" placeholder="85" value="<?php echo $config->maxtemp?>">
                                <span class="add-on">&deg;C</span>
                            </div>
                        </div>
                    </div>
                    <h4>Efficiency</h4>
                    <hr>
                    <div class="control-group">
                        <label class="control-label" for="yellowgessper">min. % of desired 5s MH/s</label>
                        <div class="controls">
                            <div class="input-append">
                                <input type="text" name="yellowgessper" class="input-mini" placeholder="95" value="<?php echo $config->yellowgessper?>">              
                                <span class="add-on">%</span>
                            </div>
                            <div class="input-append">
                                <input type="text" name="maxgessper" class="input-mini" placeholder="90" value="<?php echo $config->maxgessper?>">             
                                <span class="add-on">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="yellowavgmhper">min. % of desired average MH/s</label>
                        <div class="controls">
                            <div class="input-append">
                                <input type="text" name="yellowavgmhper" class="input-mini" placeholder="95" value="<?php echo $config->yellowavgmhper?>">              
                                <span class="add-on">%</span>
                            </div>
                            <div class="input-append">
                                <input type="text" name="maxavgmhper" class="input-mini" placeholder="90" value="<?php echo $config->maxavgmhper?>">
                                <span class="add-on">%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <h4>Pool</h4>
                    <hr>
                    <div class="control-group">
                        <label class="control-label" for="yellowrejects">Rejected Shares</label>
                        <div class="controls">
                            <div class="input-append">
                                <input type="text" name="yellowrejects" class="input-mini" placeholder="1" value="<?php echo $config->yellowrejects?>">
                                <span class="add-on">%</span>
                            </div>
                            <div class="input-append">
                                <input type="text" name="maxrejects" class="input-mini" placeholder="2" value="<?php echo $config->maxrejects?>">
                                <span class="add-on">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="yellowdisacrds">Discarded Shares</label>
                        <div class="controls">
                            <div class="input-append">
                                <input type="text" name="yellowdiscards" class="input-mini" placeholder="30" value="<?php echo $config->yellowdiscards?>">
                                <span class="add-on">%</span>
                            </div>
                            <div class="input-append">
                                <input type="text" name="maxdiscards" class="input-mini" placeholder="40" value="<?php echo $config->maxdiscards?>">
                                <span class="add-on">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="yellowstales">Stale Shares</label>
                        <div class="controls">
                            <div class="input-append">
                                <input type="text" name="yellowstales" class="input-mini" placeholder="7" value="<?php echo $config->yellowstales?>">
                                <span class="add-on">%</span>
                            </div>
                            <div class="input-append">
                                <input type="text" name="maxstales" class="input-mini" placeholder="10" value="<?php echo $config->maxstales?>">
                                <span class="add-on">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="yellowgetfails">Getwork Fails</label>
                        <div class="controls">
                            <div class="input-append">
                                <input type="text" name="yellowgetfails" class="input-mini" placeholder="1" value="<?php echo $config->yellowgetfails?>">
                                <span class="add-on">%</span>
                            </div>
                            <div class="input-append">
                                <input type="text" name="maxgetfails" class="input-mini" placeholder="2" value="<?php echo $config->maxgetfails?>">
                                <span class="add-on">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="yellowremfails">REM Fails</label>
                        <div class="controls">
                            <div class="input-append">
                                <input type="text" name="yellowremfails" class="input-mini" placeholder="1" value="<?php echo $config->yellowremfails?>">
                                <span class="add-on">%</span>
                            </div>
                            <div class="input-append">
                                <input type="text" name="maxremfails" class="input-mini" placeholder="2" value="<?php echo $config->maxremfails?>">       
                                <span class="add-on">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="yellowfan">Fan %</label>
                        <div class="controls">
                            <div class="input-append">
                                <input type="text" name="yellowfan" class="input-mini" placeholder="85" value="<?php echo $config->yellowfan?>">                
                                <span class="add-on">%</span>
                            </div>
                            <div class="input-append">
                                <input type="text" name="maxfan" class="input-mini" placeholder="90" value="<?php echo $config->maxfan?>">            
                                <span class="add-on">%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary pull-right" name="saveconf">Save Changes</button>
            </div>
		</form>
    </div>
    <div id="push"></div>
</div>

<?php include("footer.inc.php"); ?>

</body>
</html>