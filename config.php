<?php
require("config.inc.php");

$dbh = anubis_db_connect();

if (isset($_POST['saveconf'])) {
	$updstring = "";

	if (isset($_POST['updatetime'])) {
		$updatetime = $dbh->quote($_POST['updatetime']);
		$updstring = $updstring . " updatetime = $updatetime, ";
	}

	if (isset($_POST['yellowtemp'])) {
		$yellowtemp = $dbh->quote($_POST['yellowtemp']);
		$updstring = $updstring . " yellowtemp = $yellowtemp, ";
	}

	if (isset($_POST['maxtemp'])) {
		$maxtemp = $dbh->quote($_POST['maxtemp']);
		$updstring = $updstring . " maxtemp = $maxtemp, ";
	}

	if (isset($_POST['yellowrejects'])) {
		$yellowrejects = $dbh->quote($_POST['yellowrejects']);
		$updstring = $updstring . " yellowrejects = $yellowrejects, ";
	}

	if (isset($_POST['maxrejects'])) {
		$maxrejects = $dbh->quote($_POST['maxrejects']);
		$updstring = $updstring . " maxrejects = $maxrejects, ";
	}

	if (isset($_POST['yellowdiscards'])) {
		$yellowdiscards = $dbh->quote($_POST['yellowdiscards']);
		$updstring = $updstring . " yellowdiscards = $yellowdiscards, ";
	}

	if (isset($_POST['maxdiscards'])) {
		$maxdiscards = $dbh->quote($_POST['maxdiscards']);
		$updstring = $updstring . " maxdiscards = $maxdiscards, ";
	}

	if (isset($_POST['yellowstales'])) {
		$yellowstales = $dbh->quote($_POST['yellowstales']);
		$updstring = $updstring . " yellowstales = $yellowstales, ";
	}
	
	if (isset($_POST['maxstales'])) {
		$maxstales = $dbh->quote($_POST['maxstales']);
		$updstring = $updstring . " maxstales = $maxstales, ";
	}

	if (isset($_POST['yellowgetfails'])) {
		$yellowgetfails = $dbh->quote($_POST['yellowgetfails']);
		$updstring = $updstring . " yellowgetfails = $yellowgetfails, ";
	}

	if (isset($_POST['maxgetfails'])) {
		$maxgetfails = $dbh->quote($_POST['maxgetfails']);
		$updstring = $updstring . " maxgetfails = $maxgetfails, ";
	}

	if (isset($_POST['yellowremfails'])) {
		$yellowremfails = $dbh->quote($_POST['yellowremfails']);
		$updstring = $updstring . " yellowremfails = $yellowremfails, ";
	}

	if (isset($_POST['maxremfails'])) {
		$maxremfails = $dbh->quote($_POST['maxremfails']);
		$updstring = $updstring . " maxremfails = $maxremfails, ";
	}

	if (isset($_POST['yellowfan'])) {
		$yellowfan = $dbh->quote($_POST['yellowfan']);
		$updstring = $updstring . " yellowfan = $yellowfan, ";
	}	

	if (isset($_POST['maxfan'])) {
		$maxfan = $dbh->quote($_POST['maxfan']);
		$updstring = $updstring . " maxfan = $maxfan, ";
	}

	if (isset($_POST['yellowgessper'])) {
		$yellowgessper = $dbh->quote($_POST['yellowgessper']);
		$updstring = $updstring . " yellowgessper = $yellowgessper, ";
	}

	if (isset($_POST['maxgessper'])) {
		$maxgessper = $dbh->quote($_POST['maxgessper']);
		$updstring = $updstring . " maxgessper = $maxgessper, ";
	}

	if (isset($_POST['yellowavgmhper'])) {
		$yellowavgmhper = $dbh->quote($_POST['yellowavgmhper']);
		$updstring = $updstring . " yellowavgmhper = $yellowavgmhper, ";
	}

	if (isset($_POST['email'])) {
		$email = $dbh->quote($_POST['email']);
		$updstring = $updstring . " email = $email, ";
	}
		
	$updstring = substr($updstring,0,-2);
	
	$updstring = "UPDATE configuration SET ".$updstring."";
	$updcr = $dbh->query($updstring);
	if (!db_error())
      $updated = 1;

	//echo "Final Updstring: $updstring !";

}

$configq = $dbh->query('SELECT * FROM configuration');
db_error();

$config = $configq->fetch(PDO::FETCH_OBJ);

?>
<?php include ('head.inc.php'); ?>
<div>
<h3>Configuration</h3>
</div

<?php
if (isset($updated) && $updated == 1)
echo "<b>Configuration updated !</b>";

?>

<form id="save" name="save" action="config.php" method="post">
<table class="acuity" summary="Hostsummary" align="center">
    <thead>
    	<tr>
    		<th scope="col" class="rounded-company">Value</th>
        	<th scope="col" class="rounded-company">Yellow</th>
            <th scope="col" class="rounded-q1">Red</th>

        </tr>
        <tr>
        <td class="blue">Hashrate Update Timer (seconds)</td>
        <td><input type="text" class="input-mini" name="updatetime" value="<?php echo $config->updatetime?>"></td>
        </tr>
        <tr>
        <td class="blue">GPU Temperature</td>
        <td><input type="text" class="input-mini" name="yellowtemp" value="<?php echo $config->yellowtemp?>"></td>
        <td><input type="text" class="input-mini" name="maxtemp" value="<?php echo $config->maxtemp?>"></td>
        </tr>
        <tr>
        <td class="blue">Rejects</td>
        <td><input type="text" class="input-mini" name="yellowrejects" value="<?php echo $config->yellowrejects?>"></td>
        <td><input type="text" class="input-mini" name="maxrejects" value="<?php echo $config->maxrejects?>"></td>        
        </tr>
        <tr>
        <td class="blue">Discards</td>
        <td><input type="text" class="input-mini" name="yellowdiscards" value="<?php echo $config->yellowdiscards?>"></td>
        <td><input type="text" class="input-mini" name="maxdiscards" value="<?php echo $config->maxdiscards?>"></td>        
        </tr>
        <tr>
        <td class="blue">Stales</td>
        <td><input type="text" class="input-mini" name="yellowstales" value="<?php echo $config->yellowstales?>"></td>
        <td><input type="text" class="input-mini" name="maxstales" value="<?php echo $config->maxstales?>"></td>        
        </tr>
        <tr>
        <td class="blue">Get Fails</td>
        <td><input type="text" class="input-mini" name="yellowgetfails" value="<?php echo $config->yellowgetfails?>"></td>
        <td><input type="text" class="input-mini" name="maxgetfails" value="<?php echo $config->maxgetfails?>"></td>        
        </tr>    
        <tr>  
        <td class="blue">Rem Fails</td>
        <td><input type="text" class="input-mini" name="yellowremfails" value="<?php echo $config->yellowremfails?>"></td>
        <td><input type="text" class="input-mini" name="maxremfails" value="<?php echo $config->maxremfails?>"></td>        
        </tr> 
        <tr>
        <td class="blue">Fan Percent</td>
        <td><input type="text" class="input-mini" name="yellowfan" value="<?php echo $config->yellowfan?>"></td>
        <td><input type="text" class="input-mini" name="maxfan" value="<?php echo $config->maxfan?>"></td>        
        </tr>
        <tr>
        <td class="blue">min. % of desired 5s MH/s</td>
        <td><input type="text" class="input-mini" name="yellowgessper" value="<?php echo $config->yellowgessper?>"></td>
        <td><input type="text" class="input-mini" name="maxgessper" value="<?php echo $config->maxgessper?>"></td>        
        </tr>
        <tr>
        <td class="blue">min. % of desired average MH/s</td>
        <td><input type="text" class="input-mini" name="yellowavgmhper" value="<?php echo $config->yellowavgmhper?>"></td>
        <td><input type="text" class="input-mini" name="maxavgmhper" value="<?php echo $config->maxavgmhper?>"></td>        
        </tr>
        <tr>
        <td class="blue">E-Mail Address for Notifications</td>
        <td colspan=2><input type="text" name="email" value="<?php echo $config->email?>"></td>
        </tr>        
        <tr>
        <td colspan="3" class="pull-right"><button type="submit" name="saveconf" class="btn">Save</button></td>
        </tr> 
    </thead>
</table>

</form>                

<?php include("footer.inc.php"); ?>
  
</body>
</html>