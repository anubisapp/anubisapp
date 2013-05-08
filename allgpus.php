<?php
require("auth.inc.php");
require("config.inc.php");
require("func.inc.php");

$dbh = anubis_db_connect();
$config = get_config_data();

?>
<?php require('head.inc.php'); ?>

<div>
<h3>Hosts</h3>
<span class="pull-right"><a href="index.php">Back to normal view</a></span>
</div>

<?php

$result = $dbh->query("SELECT * FROM hosts");
if ($result)
{
  echo "<table id='hostsum' class='table table-bordered table-striped' summary='Hostsummary'>";
  echo create_host_header();

	while ($host_data = $result->fetch(PDO::FETCH_ASSOC))
	{
      $host_alive = get_host_status($host_data);

      echo get_host_summary($host_data);
      if ($host_alive)
      {
        $privileged = get_privileged_status($host_data);
        echo "<tr><td colspan='14'>";
           // Pool summary off for now
#          echo "<table id='poolsum' class='acuity' summary='PoolSummary' align='center'>";
#          echo create_pool_header();
#          echo process_pools_disp($host_data);
#          echo "</table>";
        
          echo "<table id='devsum' class='table table-bordered table-striped' summary='DevsSummary' align='center'>";
          echo create_devs_header();
          echo process_devs_disp($host_data);
          echo "</table>";
        echo "</td></tr>";
      }
    }

    echo create_totals();
	echo "</table>";
}
else 
{
	echo "No Hosts found, you might like to <a href=\"addhost.php\">add a host</a> ?<BR>";
}

?>

<div style="text-align:center;"><a class="btn btn-success" href="addhost.php"><i class="icon icon-plus icon-white"></i> Add Host</a></div>

<?php include("footer.inc.php"); ?>


<script>
$(function() {
  setInterval(update, 1000 * <?php echo $config->updatetime ?>);
});
function update() {
	$('#hostsum').load('allgpus.php?id=<?php echo $id?> #hostsum');
	$('#devsum').load('allgpus.php?id=<?php echo $id?> #devsum');
/*	$('#poolsum').load('allgpus.php?id=<?php echo $id?> #poolsum'); */
}
</script>
  
</body>
</html>
