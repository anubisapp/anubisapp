<?php
require("config.inc.php");
require("func.inc.php");

$dbh = anubis_db_connect();
$config = get_config_data();

if (!isset($id))
  $id = 0 + $_GET['id'];
if (!$id || $id == 0) 
{
	echo "Need a Host to deal with !";
	die;
}


if($host_data = get_host_data($id))
{
  $host_alive = get_host_status($host_data);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Anubis - a cgminer web frontend</title>

<?php require('stylesheets.inc.php'); ?>

<script type="text/javascript" src="scripts/jquery.min.js"></script>
</head>
<body>

<div id="templatemo_wrapper">

<?php include ('header.inc.php'); ?>

    <div id="templatemo_main">
    	<div class="col_fw">
        	<div class="templatemo_megacontent">
            	<h2>Host detail</h2>
<?php
				 if ($host_alive)
                   echo "<a href='hoststat.php?id=".$id."'>View host stats</a>";
?>
                <div class="cleaner h20"></div>
<?php
if ($host_data)
{  
  echo "<table id=\"hostsum\" class='acuity' summary='HostSummary' align='center'>";
  echo create_host_header();
  echo get_host_summary($host_data);
  echo "</table>";

  if ($host_alive)
  {
    echo "<table id=\"devsum\" class='acuity' summary='DevsSummary' align='center'>";
    echo create_devs_header();
    echo process_devs_disp($host_data, $privileged);

    if (isset($dev_response))
    {
      if ($dev_response['STATUS'][0]['STATUS'] == 'S')
        $dev_message = "Action successful: ";
      else if ($dev_response['STATUS'][0]['STATUS'] == 'I')
         $dev_message = "Action info: ";
      else if ($dev_response['STATUS'][0]['STATUS'] == 'W')
         $dev_message = "Action warning: ";
      else
         $dev_message = "Action error: ";

      echo "<thead><tr>
              <th colspan='16'  scope='col' class='rounded-company'>"
                . $dev_message . $dev_response['STATUS'][0]['Msg'].
             "</th>
            </tr></thead>";
    }
    echo "</table>";

    echo "<table class='acuity' id=\"poolsum\" summary='PoolSummary' align='center'>";
    echo create_pool_header();
    echo process_pools_disp($host_data, $privileged);
        
    echo "</table>";
  }
?>

<?php
}
else {
	echo "Host not found or you just deleted the host !<BR>";
}
?>
                <div class="cleaner h20"></div>
<!--                 <a href="#" class="more float_r"></a> -->
            </div>

            <div class="cleaner"></div>
		</div>

        <div class="cleaner"></div>
        </div>
    </div>
    
    <div class="cleaner"></div>

<div id="templatemo_footer_wrapper">
    <div id="templatemo_footer">
        <?php include("footer.inc.php"); ?>
        <div class="cleaner"></div>
    </div>
</div> 

<script>
$(function() {
  setInterval(update, 1000 * <?php echo $config->updatetime ?>);
});
function update() {
	$('#hostsum').load('./edithost.php?id=<?php echo $id?> #hostsum');
	$('#devsum').load('./edithost.php?id=<?php echo $id?> #devsum');
	$('#poolsum').load('./edithost.php?id=<?php echo $id?> #poolsum');
}
</script>
  
</body>
</html>
