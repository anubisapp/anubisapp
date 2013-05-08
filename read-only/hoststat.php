<?php
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
  $host_alive = get_host_status($host_data);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Anubis: Host Status</title>

<?php require('stylesheets.inc.php'); ?>

<script type="text/javascript" src="scripts/jquery.min.js"></script>
<script type="text/javascript" src="scripts/ddsmoothmenu.js">


/***********************************************
* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>


<script type="text/javascript">

ddsmoothmenu.init({
	mainmenuid: "templatemo_menu", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

</script>


</head>
<body>

<div id="templatemo_wrapper">

<?php include ('header.inc.php'); ?>

    <div id="templatemo_main">
    	<div class="col_fw">
        	<div class="templatemo_megacontent">
            	<h2>Host Stats</h2>
				 <a href="edithost.php?id=<?php echo $id?>">Back to host details</a>
                <div class="cleaner h20"></div>
<?php
if ($host_data && $host_alive)
{
  echo "<table id='hostinfo' class='acuity' summary='HostInfo' width='100'>";
  echo process_host_info($host_data);
  echo "</table>";

  echo "<table id='hostnotify' class='acuity' summary='HostNotify' align='center'>";
  echo create_notify_header();
  echo process_notify_table($host_data);
  echo "</table>";

  echo "<table id='hostdevdetails' class='acuity' summary='HostDevDetails' align='center'>";
  echo create_devdetails_header();
  echo process_devdetails_table($host_data);
  echo "</table>";

  echo "<table id='hoststat' class='acuity' summary='HostStat' align='center'>";
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
	$('#hostinfo').load('hoststat.php?id=<?php echo $id?> #hostinfo');
	$('#hostnotify').load('hoststat.php?id=<?php echo $id?> #hostnotify');
	$('#hostdevdetails').load('hoststat.php?id=<?php echo $id?> #hostdevdetails');
	$('#hoststat').load('hoststat.php?id=<?php echo $id?> #hoststat');
}
</script>
  
</body>
</html>
