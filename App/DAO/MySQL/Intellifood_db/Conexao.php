<?php

namespace App\DAO\MySQL\Intellifood_db;


abstract class Conexao
{
    /**
     * @var \PDO
     */
    protected $pdo;

    public function __construct()
    {
        $host = getenv('Intellifood_db_MYSQL_HOST');
        $port = getenv('Intellifood_db_MYSQL_PORT');
        $user = getenv('Intellifood_db_MYSQL_USER');
        $pass = getenv('Intellifood_db_MYSQL_PASSWORD');
        $dbname = getenv('Intellifood_db_MYSQL_DBNAME');

        $dsn = "mysql:host={$host};dbname={$dbname};port={$port}";

        $this->pdo = new \PDO($dsn, $user, $pass);

        $this->pdo->setAttribute(
            \PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION
        );
    }
}