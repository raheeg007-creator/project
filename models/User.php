<?php

require_once __DIR__ . '/../core/Model.php';


class User extends Model
{
    /**
     * @param string $firstName User's first name.
     * @param string $lastName  User's last name.
     * @param string $email     User's unique email address.
     * @param string $password  Plain-text password (will be hashed here).
     * @return int The id of the newly created user.
     * @throws PDOException if the insert fails (e.g. duplicate email).
     */
    public function create(string $firstName, string $lastName, string $email, string $password): int
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (first_name, last_name, email, password)
                VALUES (:firstName, :lastName, :email, :password)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':firstName' => $firstName,
            ':lastName'  => $lastName,
            ':email'     => $email,
            ':password'  => $hashedPassword,
        ]);

        return (int) $this->db->lastInsertId();
    }

    /**
     *
     * @param string $email The email address to search for.
     * @return array|false
     */
    public function findByEmail(string $email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    /**
     * @param int $id The user's id.
     * @return array|false
     */
    public function findById(int $id)
    {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}