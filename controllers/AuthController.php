<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';


class AuthController extends Controller
{
    
    public function index(): void
    {
        $this->view('layout.home');
    }

    
    public function showLogin(): void
    {
        $lastLogin = $_COOKIE['last_login'] ?? null;

        $this->view('auth.login', [
            'lastLogin' => $lastLogin,
            'error'     => null,
        ]);
    }

    
    public function showRegister(): void
    {
        $this->view('auth.register', ['error' => null]);
    }

    public function register(): void
    {
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName  = trim($_POST['last_name'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $password  = $_POST['password'] ?? '';

        // Server-side validation
        if (!preg_match('/^[A-Za-z]{1,50}$/', $firstName) ||
            !preg_match('/^[A-Za-z]{1,50}$/', $lastName)) {
            $this->view('auth.register', ['error' => 'The name should contain only letters.']);
            return;
        }

       if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->view('auth.register', ['error' => 'The email format is invalid.']);
            return;
        }

        
        if (strlen($email) > 100) {
            $this->view('auth.register', ['error' => 'The email is too long (maximum 100 characters).']);
            return;
        }

        if (strlen($password) < 6) {
            $this->view('auth.register', ['error' => 'The password must be at least 6 characters long.']);
            return;
        }

        $userModel = new User();

        // Check for duplicate email before inserting
        if ($userModel->findByEmail($email)) {
            $this->view('auth.register', ['error' => 'This email is already registered.']);
            return;
        }

        $userModel->create($firstName, $lastName, $email, $password);

        $this->redirect('/login');
    }

    
    public function login(): void
    {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        // Verify the user exists AND the password matches the stored hash
        if (!$user || !password_verify($password, $user['password'])) {
            $this->view('auth.login', [
                'error'     => 'The email or password is incorrect.',
                'lastLogin' => $_COOKIE['last_login'] ?? null,
            ]);
            return;
        }

        // Store minimal identifying info in the session
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['first_name'] = $user['first_name'];

        // Set the last login cookie, valid for 7 days, independent of the session
        setcookie('last_login', date('Y-m-d H:i:s'), time() + (7 * 24 * 60 * 60), '/');

        $this->redirect('/photos');
    }

    
    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        $this->redirect('/login');
    }
}