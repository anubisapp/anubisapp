<?php
require("auth.inc.php");
require("config.inc.php");
require("func.inc.php");

$dbh = anubis_db_connect();

if (!isset($id))
  $id = 0 + $_GET['id'];
if (!$id || $id == 0) 
{
	echo "Need a Host to deal with !";
	die;
}

$config = get_config_data();

if($host_data = get_host_data($id))
{
  if($host_alive = get_host_status($host_data))
  {
    /* Determine if we can change values on this host */
    $privileged = get_privileged_status($host_data);
  
    if ($privileged)
    { 
      $wait = false;
       
      if (isset($_POST['config_submit']))
      {
      	$arr = array ('command'=>'config','parameter'=>'');
      	$config_arr = send_request_to_host($arr, $host_data);

      	$ScanTime_input = filter_input(INPUT_POST, 'ScanTime_dro', FILTER_SANITIZE_NUMBER_INT);
      	$Queue_input = filter_input(INPUT_POST, 'Queue_dro', FILTER_SANITIZE_NUMBER_INT);
      	$Expiry_input = filter_input(INPUT_POST, 'Expiry_dro', FILTER_SANITIZE_NUMBER_INT);
      	 
      	if ($ScanTime_input != $config_arr['CONFIG']['0']['ScanTime'])
      	{
      	  $arr = array ('command'=>'setconfig','parameter'=>'ScanTime,'.$ScanTime_input);
      	  $config_response = send_request_to_host($arr, $host_data);
      	}
      	
      	if ($Queue_input != $config_arr['CONFIG']['0']['Queue'])
        {
      	  $arr = array ('command'=>'setconfig','parameter'=>'Queue,'.$Queue_input);
      	  $config_response = send_request_to_host($arr, $host_data);
      	}
      	
      	if ($Expiry_input != $config_arr['CONFIG']['0']['Expiry'])
      	{
      	  $arr = array ('command'=>'setconfig','parameter'=>'Expiry,'.$Expiry_input);
      	  $config_response = send_request_to_host($arr, $host_data);
      	}
      	 
      	$wait = true;
      }
      
      if (isset($_POST['debug_submit']))
      {
	      $arr = array ('command'=>'debug','parameter'=>'');
		  $debug_result = send_request_to_host($arr, $host_data);	  
		  
	      foreach ($debug_param_arr as $param)
	      {	    
	      	if ((isset($_POST[$param]) && !$debug_result['DEBUG']['0'][$param])
	      	|| (!isset($_POST[$param]) && $debug_result['DEBUG']['0'][$param]))
	      	{
		      $arr = array ('command'=>'debug','parameter'=>$param);
		      $debug_response = send_request_to_host($arr, $host_data);
		      usleep(100000);
	          $wait = true;
	      	}
	      }
      }
      
      if (isset($_POST['default_submit']))
      {
      	$arr = array ('command'=>'debug','parameter'=>'Normal');
      	$debug_response[$index++] = send_request_to_host($arr, $host_data);
      	$wait = true;
      }
      
      if (isset($_POST['flashpga']))
      {
      	$pga_id = filter_input(INPUT_POST, 'flashpga', FILTER_SANITIZE_NUMBER_INT);
      	$arr = array ('command'=>'pgaidentify','parameter'=>$pga_id);
      	$dev_response = send_request_to_host($arr, $host_data);
        $wait = true;
      }
       	
      if ($wait)
      	sleep(2);
    }
  }
}

?>
<?php require('head.inc.php'); ?>

<div>
<h3>Host Stats</h3>
<a href="edithost.php?id=<?php echo $id?>" class="pull-right">Back to host details</a>
</div>
<?php
if ($host_data && $host_alive)
{
  echo "<form name=pool action='hoststat.php?id=".$id."' method='post'>";
  echo "<table id='hostinfo' class='table table-bordered table-striped' summary='HostInfo' width='100'>";
  echo process_host_info($host_data);
  if (isset($config_response))
  {
    if ($config_response['STATUS'][0]['STATUS'] == 'S')
      $dev_message = "Action successful: ";
    else if ($config_response['STATUS'][0]['STATUS'] == 'I')
       $dev_message = "Action info: ";
    else if ($config_response['STATUS'][0]['STATUS'] == 'W')
       $dev_message = "Action warning: ";
    else
       $dev_message = "Action error: ";

    echo "<tr>
            <th colspan='11' scope='col' class='rounded-company'>"
              . $dev_message . $config_response['STATUS'][0]['Msg'].
           "</th>
          </tr>";
  }
  echo "</table>";
  echo "</form>";
  
  echo "<form name=pool action='hoststat.php?id=".$id."' method='post'>";
  echo "<table id='rounded-corner' class='table table-bordered table-striped' summary='HostInfo' width='100'>";
  echo process_debug_info($host_data);
  echo "</table>";
  echo "</form>";
    
  echo "<table id='hostnotify' class='table table-bordered table-striped' summary='HostNotify' align='center'>";
  echo create_notify_header();
  echo process_notify_table($host_data);
  echo "</table>";

  echo "<form name=pool action='hoststat.php?id=".$id."' method='post'>";
  echo "<table id='hostdevdetails' class='table table-bordered table-striped' summary='HostDevDetails' align='center'>";
  echo create_devdetails_header();
  echo process_devdetails_table($host_data);
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
    echo "<tr>
            <th colspan='16'  scope='col' class='rounded-company'>"
              . $dev_message . $dev_response['STATUS'][0]['Msg'].
           "</th>
          </tr>";
  }
  echo "</table>";
  echo "</form>";

  echo "<table id='hoststat' class='table table-bordered table-striped' summary='HostStat' align='center'>";
  echo create_stats_header();
  echo "<tr><td><table border='0' width='100%'>";
    echo process_stats_table($host_data);
  echo "</table></td></tr>";
  echo "</table>";
}
else {
	echo "Host not found!<BR>";
}
?>
</div>

<?php include("footer.inc.php"); ?>

<script>
$(function() {
  setInterval(update, 1000 * <?php echo $config->updatetime ?>);
});
function update() {
	$('#hostinfo').load('hoststat.php?id=<?php echo $id?> #hostinfo');
	$('#hostnotify').load('hoststat.php?id=<?php echo $id?> #hostnotify');
	$('#hostdevdetails').load('hoststat.php?id=<?php echo $id?> #hostdevdetails');
	$('#hoststat').load('hoststat.php?id=<?php echo $id?> #hoststat');
}
</script>
  
</body>
</html>
