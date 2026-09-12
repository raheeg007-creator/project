<?php

/**
 * Class Database
 */
class Database
{
    // Database configuration - adjust these to match your local setup
    private static $host = 'localhost';
    private static $dbName = 'alzikrayat';
    private static $username = 'root';
    private static $password = '';

    // Holds the single shared PDO instance
    private static $connection = null;

    /**
     * Returns the shared PDO database connection.
     * Creates it on first call, then reuses it on every subsequent call.
     *
     * @return PDO The active database connection.
     * @throws PDOException if the connection fails.
     */
    public static function getConnection()
    {
        if (self::$connection === null) {
            try {
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbName . ";charset=utf8mb4";

                self::$connection = new PDO($dsn, self::$username, self::$password, [
                    // Throw exceptions on errors instead of failing silently
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    // Return results as associative arrays by default
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    // Use real prepared statements (safer against SQL injection)
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                // In production you'd log this instead of exposing details
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}