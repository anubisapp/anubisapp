<?php

class DB
{
    private $_host = "";
    private $_username = "";
    private $_password = "";
    private $_database = "";
    private $_conn = null;
    private $_DBEngine = "";
    private $_errors = array();

    function __construct($username, $password, $database, $engine = "mysql", $host = "localhost")
    {
        $this->_username = $username;
        $this->_password = $password;
        $this->_database = $database;
        $this->_DBEngine = $engine;
        $this->_host = $host;
        $this->connect();
    }
    
    function connect()
    {
        try 
        {
            $connString = sprintf("%s:host=%s;dbname=%s",$this->_DBEngine, $this->_host, $this->_database);
            $this->_conn = new PDO($connString, $this->_username, $this->_password);
        }
        catch(Exception $e)
        {
            array_push($this->_errors, $e->getMessage());
            return $e->getmessage();
        }
    }
    
    function ExecuteSQL($sql)
    {
        try
        {
            if($this->_conn == null) die("Not Connected to the database");
            
            //PDO::Quote causing errors as SQL is not on a single line, ideally this needs a fix.
            $var = $this->_conn->exec($sql);

            if($var === false) return $this->_conn->errorInfo();
            
            return $var;
        }
        catch(Exception $e)
        {
            array_push($this->_errors, $e->getMessage());
            return $e->getMessage();
        }
    }
    
    function LastError()
    {
        //0 - SQLSTATE error code
        //1 - Driver specific error code
        //2 - Error Message
        $err = $this->_conn->errorInfo();
        array_push($this->_errors, $err[2]);
        return $err[2];
    }
    
    function __destruct()
    {
        
    }
}




?>