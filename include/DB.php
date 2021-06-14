<?php


class DB
{
    /**
     * connection details to database
     */
    private $host = 'localhost:3306';
    private $user = 'root';
    private $pass = '****';
    private $dbName = 'rally';
    private $myConnection;
    private $setDbColation = "SET NAMES utf8";

    /**
     * Construct connection to mySQL, check connection
     * @return mysqli connection
     */
    private function connectToDb()
    {
        $conn = mysqli_connect($this->host, $this->user, $this->pass, $this->dbName);
        if(!$conn){
            die("Cannot connect to database" . $this->dbName);
        }
        else {
            $this->myConnection = $conn;
        }
        return $this->myConnection;
    }

    /**
     * setup connection for each query
     * @return mysqli connection
     */
    private function setUpConnection(){
        $connection = new DB();
        return $connection->connectToDb();
    }

    /**
     * Close connection to database
     * @param $connection - connection to be closed
     */
    private function closeDb($connection){
        mysqli_close($connection);
    }

    /**
     * Default function to select data from database
     * @param $selectQuery - sql query to execute
     * @return bool|mysqli_result
     */
    function selectQuery($selectQuery){
        $link = $this->setUpConnection();
        mysqli_query($link, $this->setDbColation);
        $query = "{$selectQuery}";
        $result = mysqli_query($link, $query);
        $this->closeDb($link);
        return  $result;
    }

    /**
     * Default function to insert data to database
     * @param $insertQuery - sql insert query to execute
     * @return int - execution result
     */
    function insertQuery($insertQuery){
        $link = $this->setUpConnection();
        mysqli_query($link, $this->setDbColation);
        $query = "{$insertQuery}";
        mysqli_query($link, $query);
        $affected = mysqli_affected_rows($link);
        $this->closeDb($link);
        return $affected;
    }

    function insertQueryGetId($insertQuery){
        $link = $this->setUpConnection();
        mysqli_query($link, $this->setDbColation);
        $query = "{$insertQuery}";
        if(mysqli_query($link, $query)){
            return mysqli_insert_id($link);
        }else
            $this->closeDb($link);
            return -1;
    }

    /**
     * Default function to update data in database
     * @param $updateQuery - sql update query to execute
     * @return int - execution result
     */
    function updateQuery($updateQuery){
        $link = $this->setUpConnection();
        mysqli_query($link, $this->setDbColation);
        $query = "{$updateQuery}";
        mysqli_query($link, $query);
        $affected = mysqli_affected_rows($link);
        $this->closeDb($link);
        return $affected;
    }

    /**
     * Default function to delete data in database
     * @param $deleteQuery - sql delete query to execute
     * @return int - execution result
     */
    function deleteQuery($deleteQuery){
        $link = $this->setUpConnection();
        mysqli_query($link, $this->setDbColation);
        $query = "{$deleteQuery}";
        mysqli_query($link, $query);
        $affected = mysqli_affected_rows($link);
        $this->closeDb($link);
        return $affected;
    }
}