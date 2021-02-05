<?php

/**
 * Class Database
 *
 * Database connection class
 */

namespace App\Connection;

class Database
{
    private $db_type;
    private $host;
    private $port;
    private $database_name;
    private $username;
    private $password;
    private $options;

    public $conn;

    /**
     * Constructor
     *
     * Initialize variables that will be used in connecting to DB
     *
     * @param string $db_type  type of database ex. mysql, postgre, etc..
     * @param string $host     DB server domain or ip
     * @param string $port     DB server port
     * @param string $db_name  DB name
     * @param string $username DB access username
     * @param string $password DB access password
     * @param string $options  enabling other connection settings like enablessl
     *
     * @return none
     *
     * @access public
     */
    public function __construct(
        $db_type = "pgsql",
        $host = "localhost",
        $port = "5432",
        $db_name = "test",
        $username = "root",
        $password = "",
        $options = ""
    ) {
        $this->db_type = $db_type;
        $this->host = $host;
        $this->port = $port;
        $this->database_name = $db_name;
        $this->username = $username;
        $this->password = $password;
        $this->options = $options;
    }

    /**
     * Get Connection Method
     *
     * Connect to Database using PDO
     *
     * @return object
     *
     * @access public
     */
    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new \PDO(
                $this->db_type . ":host=" . $this->host . ";
                port=" . $this->port . ";
                dbname=" . $this->database_name . $this->options,
                $this->username,
                $this->password
            );
        } catch (\PDOException $exception) {
            header('HTTP/1.1 500');
            echo "Database could not be connected: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
