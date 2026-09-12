<?php

require_once __DIR__ . '/../config/database.php';

/**
 * Class Model
 *
 * Abstract base class for all data models (User, Photo, Comment).
 * Provides shared access to the database connection so that child
 * models don't need to manage their own connection logic.
 */
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