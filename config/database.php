<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/config/model.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

defined("MODE_APP") OR define("MODE_APP", "dev");
defined("DB_APP") OR define("DB_APP", $_SERVER["DB_APP"]);
defined("DB_HOST") OR define("DB_HOST",  $_SERVER["DB_HOST"]);
defined("DB_USER") OR define("DB_USER",  $_SERVER["DB_USER"]);
defined("DB_PASS") OR define("DB_PASS",  $_SERVER["DB_PASS"]);
defined("DB_PORT") OR define("DB_PORT",  $_SERVER["DB_PORT"]);

defined("APP_PATH") OR define("APP_PATH", dirname(__DIR__));

class Database extends model {
    private $conn;
    private $dbUser = DB_USER;
    private $dbPass = DB_PASS;
    private $dbName = DB_APP;
    private $dbPort = DB_PORT;
    private $dbHost = DB_HOST;

    public function __construct($fromInit = true)  {
        if ($fromInit == true) $this->init_connection();
    }

    public function init_connection() {
        $dbHost = $this->get_host_db();
        $dbUser = $this->get_user_db();
        $dbPass = $this->get_password_db();
        $dbName = $this->get_name_db();
        $dbPort = $this->get_port_db();

        $this->conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $dbPort);
        if (!$this->conn) {
            die("Connection error: " . mysqli_connect_error());
        }

    }

    public function connect()
    {
        return $this->conn;
    }

    public function set_host_db($dbHost = "") {
        $this->dbHost = $dbHost;
    }

    public function set_user_db($dbUser = "") {
        $this->dbUser = $dbUser;
    }

    public function set_password_db($dbPass = "") {
        $this->dbPass = $dbPass;
    }

    public function set_name_db($dbName = "") {
        $this->dbName = $dbName;
    }

    public function set_port_db($dbPort = "") {
        $this->dbPort = $dbPort;
    }

    private function get_host_db() {
        return $this->dbHost;
    }

    private function get_user_db() {
        return $this->dbUser;
    }

    private function get_password_db() {
        return $this->dbPass;
    }

    public function get_name_db() {
        return $this->dbName;
    }

    private function get_port_db() {
        return $this->dbPort;
    }
}