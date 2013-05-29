<?php

require("DB.php");

try {
    $method = $_GET["method"];
    $retval = call_user_func($method);
    return json_encode($retval);
} catch (Exception $e) {
    return json_encode($e);
}

function CreateTables()
{
    try {
        $DB = new DB($_GET["username"], $_GET["password"], $_GET["database"], "mysql", $_GET["host"]);
        $sql = "
            CREATE TABLE IF NOT EXISTS `configuration` (
            `updatetime` int(11) NOT NULL,
            `yellowtemp` int(11) NOT NULL,
            `yellowrejects` int(11) NOT NULL,
            `yellowdiscards` int(11) NOT NULL,
            `yellowstales` int(11) NOT NULL,
            `yellowgetfails` int(11) NOT NULL,
            `yellowremfails` int(11) NOT NULL,
            `maxtemp` int(11) NOT NULL,
            `maxrejects` int(11) NOT NULL,
            `maxdiscards` int(11) NOT NULL,
            `maxstales` int(11) NOT NULL,
            `maxgetfails` int(11) NOT NULL,
            `maxremfails` int(11) NOT NULL,
            `email` varchar(200) NOT NULL,
            `yellowfan` int(11) NOT NULL,
            `maxfan` int(11) NOT NULL,
            `yellowgessper` int(11) NOT NULL,
            `maxgessper` int(11) NOT NULL,
            `yellowavgmhper` int(11) NOT NULL,
            `maxavgmhper` int(11) NOT NULL,
            `theme_id` int(3) NOT NULL DEFAULT 1
        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
        ";
        $DB->ExecuteSQL($sql);
        $sql =
            "CREATE TABLE IF NOT EXISTS `hosts` (
        `id` int(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `port` mediumint(6) NOT NULL DEFAULT '4028',
  `mhash_desired` decimal(10,2) NOT NULL,
  `conf_file_path` varchar(255) NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1";
        $DB->ExecuteSQL($sql);

        return "Tables Created";
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

function updateTables()
{
    try 
    {
        $DB = new DB($_GET["username"], $_GET["password"], $_GET["database"]);
        $SQL = "ALTER TABLE configuration ADD COLUMN theme_id INT(3) NOT NULL DEFAULT 1 AFTER maxavgmhper;";
        
        $DB->ExecuteSQL($SQL);
        return "Table configuration updated successfully";
    }
    catch(Exception $e)
    {
        return $e->getMessage();   
    }
}

function writeToConfig($host, $username, $pass, $database)
{
    
}

?>