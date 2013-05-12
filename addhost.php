<?php
require("auth.inc.php");
require("config.inc.php");
require("func.inc.php");

$dbh = anubis_db_connect();

// Required field names
$required = array('name', 'ipaddress', 'port');
$error = false;

$id = (isset($_POST['savehostid'])) ? 0 + $_POST['savehostid'] : NULL;
$name = (isset($_POST['name'])) ? $_POST['name'] : NULL;
$address = (isset($_POST['ipaddress'])) ? $_POST['ipaddress'] : NULL;
$port = (isset($_POST['port'])) ? $_POST['port'] : '4028';
$hash = (isset($_POST['hash'])) ? $_POST['hash'] : NULL;

$errored = array();
foreach($required as $field)
{
    if (empty($_POST[$field]))
    {
        $error = true;
        $errored[] = $field;
    }
}
$errorFields = implode(", ", $errored);

if ($error)
{
    $message = '<strong>Error!</strong> Please fill in a <strong>'.$errorFields.'</strong> to add a host!';
    $type = 'alert-error';
}
else
{
    if ($name && $name !== "" && $address && $address !== "" && $port && $port !== "")
    {
        $dbname = $dbh->quote($name);
        $dbaddress = $dbh->quote($address);
        $dbport = $dbh->quote($port);
        $dbhash = $dbh->quote($hash);

        $updq = "INSERT INTO hosts (name, address, port, mhash_desired) VALUES ($dbname, $dbaddress, $dbport, $dbhash)";
        $updr = $dbh->exec($updq);
        db_error();

        if ($updr > 0)
        {
            $askq = "SELECT id FROM hosts WHERE address = $dbaddress AND name = $dbname";
            $askr = $dbh->query($askq);
            db_error();

            $idr = $askr->fetch(PDO::FETCH_ASSOC);
            $id = $idr['id'];

            $id = $dbh->quote($id);

            $host_data = get_host_data($id);
            db_error();
        }
    }

    if (isset($id))
    {
        if ($host_data)
        {
            $message = '<strong>Success!</strong> The host <strong>'.$name.'</strong> has been added!';
            $type = 'alert-success';
        }
    }
}
?>

<?php require('head.inc.php'); ?>

    <div class="container">
        <div class="page-header">
            <?php if ($_POST) echo alert($message, $type); ?>
            <div class="row-fluid">
                <div class="left">
                    <h1>Add Host</h1>
                </div>
                <div class="right">
                    <a href="index.php" class="btn pull-right">Back to Overview</a>
                </div>
            </div>
        </div>
        <form type="submit" action="" method="post">
            <fieldset>
                <label><strong>Name</strong></label>
                <input type="text" name="name" placeholder="my.hostname.com" value="<?php echo $name ?>" required>
                <span class="help-block">Name your CGMINER host.</span>

                <label><strong>IP / Hostname</strong></label>
                <input type="text" name="ipaddress" placeholder="192.168.0.1" value="<?php echo $address ?>" required>
                <span class="help-block">Enter the IP or FQDN of your API enabled CGMINER host.</span>

                <label><strong>Port</strong></label>
                <input type="text" name="port" placeholder="4028" value="<?php echo $port ?>" required>
                <span class="help-block">Enter the port CGMINER is listening on (default 4028).</span>

                <label><strong>Desired Hashrate</strong></label>
                <input type="text" name="hash" value="<?php echo $hash ?>">
                <span class="help-block">Set a desired hashare or leave it empty for maximum hashrate.</span>

                <input type=hidden name="savehostid" value="<?php echo $id ?>">
                <button type="submit" class="m_t10 btn btn-primary">Submit</button>
            </fieldset>
        </form>

        <div class="row-fluid">
            <div class="left">
                <span class=""><strong>Note:</strong> You can change any value afterwards.</span>
            </div>
        </div>
    </div>
    <div id="push"></div>
</div>

<?php include("footer.inc.php"); ?>

</body>
</html>
