<?php


namespace FirstFramework\DB;


class DBConnection
{
    private $pdo;
    private $config;
    private $connection;
    private static $instance;

    private function __construct()
    {
        $this->config = require_once CONFIG . 'dbconfig.php';
        $this->connection = $this->config['connections'][$this->config['connection']];
        $this->pdo = new \PDO(
            $this->getDns(),
            $this->getUsername(),
            $this->getPassword(),
            $this->getOptions()
        );
    }

    public static function instance(): DBConnection
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function pdo(): \PDO
    {
        return $this->pdo;
    }

    private function getDns(): string
    {
        return $this->connection['driver']  .
            ':host=' . $this->connection['host'] .
            ';port=' . $this->connection['port'] .
            ';dbname=' . $this->connection['database'] .
            ';charset=' . $this->connection['charset'];
    }

    private function getUsername(): string
    {
        return $this->connection['username'];
    }

    private function getPassword(): string
    {
        return $this->connection['password'];
    }

    private function getOptions(): array
    {
        return $this->connection['options'];
    }
}