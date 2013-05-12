<?php
require("auth.inc.php");
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

if (isset($_GET['dev']))
  $dev = 0 + $_GET['dev'];
else
{
    echo "Need a device number to deal with !";
    die;
}

if (isset($_GET['type']))
  $type = $_GET['type'];
else
{
    echo "Need a device type to deal with !";
    die;
}

if($host_data = get_host_data($id))
{
  if($host_alive = get_host_status($host_data))
  {
    /* Determine if we can change values on this host */
    $privileged = (get_privileged_status($host_data) && ($type != 'CPU'));

    if ($privileged)
    {
      /* Process POST data - send any changes to host */
      $value_changed = false;

      if ($type == 'PGA')
      {
        if (isset($_POST['start']))
        {
          $arr = array ('command'=>'pgaenable','parameter'=>$dev);
          $dev_response = send_request_to_host($arr, $host_data);
          $value_changed = true;
        }

        if (isset($_POST['stop']))
        {
          $arr = array ('command'=>'pgadisable','parameter'=>$dev);
          $dev_response = send_request_to_host($arr, $host_data);
          $value_changed = true;
        }
      }

      if ($type == 'GPU')
      {
        if (isset($_POST['start']))
        {
          $arr = array ('command'=>'gpuenable','parameter'=>$dev);
          $dev_response = send_request_to_host($arr, $host_data);
          $value_changed = true;
        }

        if (isset($_POST['stop']))
        {
          $arr = array ('command'=>'gpudisable','parameter'=>$dev);
          $dev_response = send_request_to_host($arr, $host_data);
          $value_changed = true;
        }

        if (isset($_POST['restart']))
        {
          $arr = array ('command'=>'gpurestart','parameter'=>$dev);
          $dev_response = send_request_to_host($arr, $host_data);
          $value_changed = true;
        }

        if(isset($_POST['apply']))
        {
          if(isset($_POST['gpuclk_chk']))
          {
            $arr = array ('command'=>'gpuengine','parameter'=>$dev.','.$_POST['gpuclk_dro']);
            $gpu_response[0] = send_request_to_host($arr, $host_data);
            $value_changed = true;
          }

          if(isset($_POST['memclk_chk']))
          {
            $arr = array ('command'=>'gpumem','parameter'=>$dev.','.$_POST['memclk_dro']);
            $gpu_response[1] = send_request_to_host($arr, $host_data);
            $value_changed = true;
          }

          if(isset($_POST['gpuvolt_chk']))
          {
            $arr = array ('command'=>'gpuvddc','parameter'=>$dev.','.$_POST['gpuvolt_dro']);
            $gpu_response[2] = send_request_to_host($arr, $host_data);
            $value_changed = true;
          }

          if(isset($_POST['gpufan_chk']))
          {
            $arr = array ('command'=>'gpufan','parameter'=>$dev.','.$_POST['gpufan_dro']);
            $gpu_response[3] = send_request_to_host($arr, $host_data);
            $value_changed = true;
          }

          if(isset($_POST['intensity_chk']))
          {
            $arr = array ('command'=>'gpuintensity','parameter'=>$dev.','.$_POST['intensity_dro']);
            $gpu_response[4] = send_request_to_host($arr, $host_data);
            $value_changed = true;
          }
        }
      }
      /* wait a couple of seconds if a change occured */
      if ($value_changed)
        sleep(2);
    }
    $gpu_data_array = get_dev_data($host_data, $dev, $type);
  }
}

?>
<?php require('head.inc.php'); ?>

    <div class="container">
        <div class="page-header">
            <div class="row-fluid">
                <div class="left">
                    <h1>Device Details</h1>
                </div>
                <div class="right">
                    <?php
                    if ($host_alive)
                        echo "<a href='hoststat.php?id=".$id."' class=\"pull-right\">View host stats</a>";
                    ?>
                </div>
            </div>
        </div>
        <?php

        if ($host_data)
        {
          echo "<table class='table table-striped table-bordered' summary='HostSummary' align='center'>";
          echo create_host_header();
          echo get_host_summary($host_data);
          echo "</table>";
          if ($host_alive)
          {
            echo "<form name='control' action='editdev.php?id=".$id."&dev=".$dev."&type=".$type."' method='post'>";
            echo "<table class='table table-striped table-bordered' summary='DevsSummary' align='center'>";
            echo create_devs_header();
            echo process_dev_disp($gpu_data_array, $privileged);

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
            echo "</form>";
          }

          if ($privileged && ($type == 'GPU'))
          {
        ?>
            <form name='apply' class="form-inline" action='editdev.php?id=<?php echo $id?>&dev=<?php echo $dev?>&type=<?php echo $type?>' method='post'>
                <table class="table table-striped table-bordered" summary='DevsControl' align='center'>
                <thead>
                    <tr>
                      <th colspan='6' scope='col'> Edit settings below for <?php echo $type?> <?php echo $dev?> on <?php echo $host_data['name']?></th>
                    </tr>
                    <tr>
                        <th width="10" scope='col'>Set</th>
                        <th colspan="3" scope='col'>Setting</th>
                        <th width="20" scope='col'>Min</th>
                        <th width="20" scope='col'>Max</th>
                    </tr>
                </thead>
                <tr>
                  <td><input type="checkbox" name="gpuclk_chk"  id="gpuclk_chk" value="1"/></td>
                  <td><label for="gpuclk_dro">Set GPU Clock Speed:</label></td>
                  <td>
                      <div class="input-append">
                          <input type="text" id="gpuclk_dro" data-field="true" name="gpuclk_dro" id="gpuclk_dro" value="<?php $gpu_data_array['GPU Clock']?>">
                          <span class="add-on">MHz</span>
                      </div>
                  <td><input type="text" id="gpuclk_dro_slider" data-slider="true" data-for="gpuclk_dro" data-slider-step="1" data-slider-range="300,1900" value="<?php $gpu_data_array['GPU Clock']?>"></td>
                  <td>300</td>
                  <td>1900</td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="memclk_chk"  id="memclk_chk" value="1"/></td>
                  <td><label for="memclk_dro">Set Memory Clock Speed:</label></td>
                  <td>
                      <div class="input-append">
                          <input type="text" id="memclk_dro" data-field="true" name="memclk_dro" id="memclk_dro" value="<?php $gpu_data_array['Memory Clock']?>">
                          <span class="add-on">MHz</span>
                      </div>
                  <td><input type="text" id="memclk_dro_slider" data-slider="true" data-for="memclk_dro" data-slider-step="1" data-slider-range="300,1900" value="<?php $gpu_data_array['Memory Clock']?>"></td>
                  <td>300</td>
                  <td>1900</td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="gpuvolt_chk"  id="gpuvolt_chk" value="1"/></td>
                  <td><label for="gpuvolt_dro">Set GPU Voltage:</label></td>
                  <td>
                      <div class="input-append">
                          <input type="text" id="gpuvolt_dro" data-field="true" name="gpuvolt_dro" id="gpuvolt_dro" value="<?php echo $gpu_data_array['GPU Voltage']?>">
                          <span class="add-on">v</span>
                      </div>
                  <td><input type="text" id="gpuvolt_dro_slider" data-slider="true" data-for="gpuvolt_dro" data-slider-range="0.5,1.5" data-slider-step="0.01" value="<?php echo $gpu_data_array['GPU Voltage']?>"></td>
                  <td>0.50</td>
                  <td>1.50</td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="gpufan_chk"  id="gpufan_chk" value="1"/></td>
                  <td><label for="gpufan_dro">Set Fan Speed:</label></td>
                  <td >
                      <div class="input-append">
                          <input type="text" id="gpufan_dro" data-field="true" name="gpufan_dro" id="gpufan_dro" value="<?php echo $gpu_data_array['Fan Percent']?>">
                          <span class="add-on">%</span>
                      </div>
                  <td><input type="text" id="gpufan_dro_slider" data-slider="true" data-for="gpufan_dro" data-slider-step="1" data-slider-range="0,100" value="<?php echo $gpu_data_array['Fan Percent']?>"></td>
                  <td>0</td>
                  <td>100</td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="intensity_chk"  id="intensity_chk" value="1"/></td>
                  <td><label for="intensity_dro">Set Intensity:</label></td>
                  <td><input type="text" id="intensity_dro" name="intensity_dro" id="intensity_dro" value="<?php echo $intensity?>"></td>
                  <td><input type="text" id="intensity_dro_slider" data-slider="true" data-for="intensity_dro" data-slider-range="0,20" data-slider-step="1" data-slider-snap="true" value="<?php echo $intensity?>"></td>
                  <td>0</td>
                  <td>20</td>
                </tr>
                <thead>
                  <tr>
                    <th colspan='6' scope='col''>
                        <button class='btn pull-right' type='submit'name='apply'>Apply Settings</button>
                    </th>
                  </tr>
                <?php
                    if (isset($_POST['apply']))
                    {
                      for ($i=0; $i<5; $i++)
                      {
                        if (isset($gpu_response[$i]))
                        {
                          if ($gpu_response[$i]['STATUS'][0]['STATUS'] == 'S')
                            $dev_message = "Action successful: ";
                          else if ($gpu_response[$i]['STATUS'][0]['STATUS'] == 'I')
                             $dev_message = "Action info: ";
                          else if ($gpu_response[$i]['STATUS'][0]['STATUS'] == 'W')
                             $dev_message = "Action warning: ";
                          else
                             $dev_message = "Action error: ";

                          echo "<tr><th colspan='4'>"
                                    . $dev_message . $gpu_response[$i]['STATUS'][0]['Msg'] .
                                 "</th><tr>";
                        }
                      }
                    }
                ?>
                </thead>
                </table>
            </form>
        <?php
          }
        }
        else
        {
            echo "Host not found or you just deleted the host !<BR>";
        }
        ?>
    </div>
    <div id="push"></div>
</div>

<script>
    $(function() {
        $('[data-slider]').bind("slider:ready slider:changed", function (event, data) {
            var input = "#" + $(this).attr("data-for");
            var val = ($(this).attr("id") == "gpuvolt_dro" ? data.value.toFixed(3) : data.value);
            $(input).val(val);
        });
        $('[data-field]').on('input', function() {
            var input = "#" + $(this).attr("id") + "_slider";
            $(input).simpleSlider("setValue", $(this).val());
        });
    })
</script>
<?php include("footer.inc.php"); ?>

</body>
</html>
