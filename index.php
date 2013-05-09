<?php
require("auth.inc.php");
require("config.inc.php");
require("func.inc.php");


$dbh = anubis_db_connect();

$result = $dbh->query($show_tables);
db_error();

while ($row = $result->fetch(PDO::FETCH_NUM))
{
    if ($row[0] == "configuration")
    	$gotconfigtbl = 1;
    if ($row[0] == "hosts")
    	$gothoststbl = 1;
}

if (!isset($gotconfigtbl))
	include("configtbl.sql.php");

if (!isset($gothoststbl))
	include("hoststbl.sql.php");


$config = get_config_data();

?>

<?php require('head.inc.php'); ?>

    <div class="container">
        <div class="page-header">
            <div class="row-fluid">
                <div class="left">
                    <h1>Hosts</h1>
                </div>
                <div class="right">
                    <a class="btn btn-success" href="addhost.php"><i class="icon icon-plus icon-white"></i> Add Host</a>
                </div>
            </div>
        </div>
        <?php
            $result = $dbh->query("SELECT * FROM hosts ORDER BY name ASC");
            if ($result)
            {
                echo "<table id=\"hostsummary\" summary=\"Hostsummary\" class=\"table table-bordered table-striped\">";
                echo create_host_header();
            	while ($host_data = $result->fetch(PDO::FETCH_ASSOC)) {
            		echo get_host_summary($host_data);
            	}
                echo create_totals();
                echo "</table>";
            }
            else
            {
            	echo "No Hosts found, you might like to <a href=\"addhost.php\">add a host</a> ?<BR>";
            }
        ?>
        <div class="row-fluid">
            <div class="right">
                <a href="allgpus.php">Expand all Hosts</a>
            </div>
        </div>
    </div>
    <div id="push"></div>
</div>

<?php include("footer.inc.php"); ?>

<script>
$(function() {
  setInterval(update, 1000 * <?php echo $config->updatetime ?>);
});
function update() {
	$('#hostsummary').load('refresh_hosts.php');
}
</script>

</body>
</html>