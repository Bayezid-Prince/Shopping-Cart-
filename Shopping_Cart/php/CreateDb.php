<?php

class CreateDb
{
    public $servername;
    public $username;
    public $password;
    public $dbname;
    public $tablename;
    public $con;

    // class constructor
    public function __construct(
        $dbname = "Newdb",
        $tablename = "Productdb",
        $servername = "localhost",
        $username = "root",
        $password = ""
    )
    {
        $this->dbname = $dbname;
        $this->tablename = $tablename;
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;

        // create connection
        $this->con = mysqli_connect($servername, $username, $password);

        // Check connection
        if (!$this->con) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // query to create database if not exists
        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

        // execute query
        if (mysqli_query($this->con, $sql)) {

            // connect to the database
            $this->con = mysqli_connect($servername, $username, $password, $dbname);

            // sql to create new table
            $sql = "CREATE TABLE IF NOT EXISTS $tablename (
                        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        product_name VARCHAR(25) NOT NULL,
                        product_price FLOAT,
                        product_image VARCHAR(100)
                    );";

            if (!mysqli_query($this->con, $sql)) {
                echo "Error creating table: " . mysqli_error($this->con);
            }
        } else {
            die("Error creating database: " . mysqli_error($this->con));
        }
    }

    // get product from the table
    public function getData()
    {
        $sql = "SELECT * FROM $this->tablename";
        $result = $this->con->query($sql);

        if (!$result) {
            die("Error executing the query: " . $this->con->error);
        }

        return $result;
    }
}
?>