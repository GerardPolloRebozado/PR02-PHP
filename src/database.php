<?php

namespace src;

class Database
{
    private $_connection;
    private static $_instance;
    private $_host = "db";
    private $_username = "root";
    private $_password = "rootpassword";

    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    // Constructor
    private function __construct()
    {
        // Connect without selecting a database
        $this->_connection = new \mysqli($this->_host, $this->_username, $this->_password);

        if (mysqli_connect_error()) {
            trigger_error("Failed to connect to MySQL: " . mysqli_connect_error(), E_USER_ERROR);
        }
        // Create database if not exists
        $this->_connection->query("CREATE DATABASE IF NOT EXISTS storeStocks");
        $this->_connection->select_db('storeStocks');

        // Create tables
        $this->createTableCities();
        $this->createTableProducts();
        $this->createTableStore();
        $this->createTableStoresProducts();

        // Insert cities
        $this->insertCities();
    }

    private function createTableCities()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS `Cities` (
            `id` int(30) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ";
        $this->_connection->query($sql);
    }

    private function createTableProducts()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS `Products` (
            `id` int(30) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `description` varchar(255) NOT NULL,
            `brand` varchar(255) NOT NULL,
            `price` double NOT NULL,
            `cost` double NOT NULL,
            `weight` double NOT NULL,
            `dimensions` double NOT NULL,
            `last_updated` datetime NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ";
        $this->_connection->query($sql);
    }

    private function createTableStore()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS `Store` (
            `id` int(30) NOT NULL AUTO_INCREMENT,
            `city` int(30) NOT NULL,
            `address` varchar(255) NOT NULL,
            `phone` VARCHAR(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `opening_time` VARCHAR(255) NOT NULL,
            `closing_time` VARCHAR(255) NOT NULL,
            `last_updated` datetime NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`city`) REFERENCES `Cities` (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ";
        $this->_connection->query($sql);
    }

    private function createTableStoresProducts()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS `Stores_Products` (
            `id` int(30) NOT NULL AUTO_INCREMENT,
            `id_store` int(30) NOT NULL,
            `id_product` int(30) NOT NULL,
            `stock_quantity` int(30) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`id_store`) REFERENCES `Store` (`id`),
            FOREIGN KEY (`id_product`) REFERENCES `Products` (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ";
        $this->_connection->query($sql);
    }

    private function insertCities()
    {
        $cities = [
        'Barcelona', 'Madrid', 'Valencia', 'Terrassa',
        'Sevilla', 'Premia de Mar', 'Mataro', 'Sabadell'
        ];
        foreach ($cities as $city) {
            $query = "INSERT INTO Cities (name) VALUES ('$city')";
            $this->_connection->query($query);
        }
    }

    private function __clone()
    {
    }

    public function getConnection()
    {
        return $this->_connection;
    }
}
