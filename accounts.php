<?php
require("auth.inc.php");
require("config.inc.php");
require("acc.inc.php");

$dbh = anubis_db_connect();

$result = $dbh->query($show_tables);
db_error();

while ($row = $result->fetch(PDO::FETCH_NUM))
{
    if ($row[0] == "accounts")
    $gotaccountstbl = 1;
    if ($row[0] == "accgroups")
    $gotgroupstbl = 1;
}

if (!isset($gotaccountstbl))
    create_accounts_table();

if (!isset($gotgroupstbl))
    create_accgroups_table();

db_error();

if (isset($_POST['addgroup']))
{
    $grp_name = $dbh->quote(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $grp_curr = $dbh->quote(filter_input(INPUT_POST, 'currency', FILTER_SANITIZE_STRING));

    $updq = "INSERT INTO accgroups (name, currency) VALUES ($grp_name, $grp_curr)";
    $updr = $dbh->exec($updq);
    db_error();
}

if (isset($_POST['addacc']))
{
    $acc_name = $dbh->quote(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $acc_addr = $dbh->quote(filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING));

    $updq = "INSERT INTO accounts (name, address, `group`) VALUES (".$acc_name.", ".$acc_addr.", ".$_POST['groupid'].");";
    $updr = $dbh->exec($updq);
    db_error();
}

if (isset($_POST['delete']))
{
    foreach ($_POST['del_acc'] as $acc_id)
    {
        $updq = "DELETE FROM accounts WHERE id = ".$acc_id.";";
        $updr = $dbh->exec($updq);
        db_error();
    }

    if(isset($_POST['deletegrp']))
    {
        $updq = "DELETE FROM accounts WHERE `group` = ".$_POST['deletegrp'].";";
        $updr = $dbh->exec($updq);
        db_error();

        $updq = "DELETE FROM accgroups WHERE id = ".$_POST['deletegrp'].";";
        $updr = $dbh->exec($updq);
        db_error();
    }
}

?>
<?php require('head.inc.php'); ?>

    <div class="container">
        <div class="page-header">
            <div class="row-fluid">
                <div class="left">
                    <h1>Accounts</h1>
                </div>
            </div>
        </div>
        <?php

            $grp_result = $dbh->query("SELECT * FROM accgroups ORDER BY name ASC");

            db_error();

            if ($grp_result)
            {

                while ($group_data = $grp_result->fetch(PDO::FETCH_ASSOC))
                {
                    $group_id = $group_data['id'];
                    echo "<form name=add action='accounts.php' method='post'>";
                    echo "<table class='table table-bordered table-striped' summary='GroupSummary'>";
                    echo create_group_header($group_data);

                    $acc_result = $dbh->query("SELECT * FROM accounts WHERE `group` = '".$group_id."' ORDER BY name ASC");
                    db_error();
                    if ($acc_result)
                    {
                      while ($acc_data = $acc_result->fetch(PDO::FETCH_ASSOC))
                      {
                        echo get_acc_summary($acc_data, $group_data);
                      }
                    }

                  echo create_group_totals();
                    echo "</table>";
                    echo "</form>";
                }
            }

            $currency_list = "";
            foreach($mtgox_currencys as $symbol)
              $currency_list .= "<option>" . $symbol . "</option>";

            ?>
        <form name="save" id="save" class="form-inline pull-right" action="accounts.php" method="post">
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="">
            <label for="currency">Currency</label>
            <select id="currency" name="currency"><?php echo $currency_list?><select>
            <button type="submit" class="btn" name="addgroup">Add new group</button>
        </form>
    </div>
    <div id="push"></div>
</div>

<?php include("footer.inc.php"); ?>

</body>
</html>
