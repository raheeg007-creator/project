<?php

require_once __DIR__ . '/../config/database.php';


abstract class Model
{
    /**
     * @var PDO Holds the shared database connection instance.
     */
    protected PDO $db;

    /**
     * Constructor.
     * Automatically fetches the shared PDO connection from the
     * Database class whenever any child model is instantiated.
     */
    public function __construct()
    {
        $this->db = Database::getConnection();
    }
}