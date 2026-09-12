<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';

/**
 * Class AuthController
 *
 * Handles user registration, login, logout, session state,
 * and the "last login" cookie behavior.
 */
class AuthController extends Controller
{
    /**
     * Renders the home/landing page. Shows the LoginRegister view
     * if the user is not logged in.
     *
     * @return void
     */
    public function index(): void
    {
        $this->view('layout.home');
    }

    /**
     * Displays the login form, including the "last login from this
     * computer" cookie message if one exists.
     *
     * @return void
     */
    public function showLogin(): void
    {
        $lastLogin = $_COOKIE['last_login'] ?? null;

        $this->view('auth.login', [
            'lastLogin' => $lastLogin,
            'error'     => null,
        ]);
    }

    /**
     * Displays the registration form.
     *
     * @return void
     */
    public function showRegister(): void
    {
        $this->view('auth.register', ['error' => null]);
    }

    /**
     * Processes registration form submission: validates input,
     * checks for a duplicate email, and creates the new user.
     *
     * @return void
     */
    public function register(): void
    {
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName  = trim($_POST['last_name'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $password  = $_POST['password'] ?? '';

        // Server-side validation
        if (!preg_match('/^[A-Za-z]{1,50}$/', $firstName) ||
            !preg_match('/^[A-Za-z]{1,50}$/', $lastName)) {
            $this->view('auth.register', ['error' => 'الاسم يجب أن يحتوي على حروف فقط.']);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->view('auth.register', ['error' => 'صيغة البريد الإلكتروني غير صحيحة.']);
            return;
        }

        if (strlen($password) < 6) {
            $this->view('auth.register', ['error' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل.']);
            return;
        }

        $userModel = new User();

        // Check for duplicate email before inserting
        if ($userModel->findByEmail($email)) {
            $this->view('auth.register', ['error' => 'هذا البريد الإلكتروني مسجل بالفعل.']);
            return;
        }

        $userModel->create($firstName, $lastName, $email, $password);

        $this->redirect('/login');
    }

    /**
     * Processes login form submission: verifies credentials, starts
     * the session, and sets the 7-day "last login" cookie.
     *
     * @return void
     */
    public function login(): void
    {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        // Verify the user exists AND the password matches the stored hash
        if (!$user || !password_verify($password, $user['password'])) {
            $this->view('auth.login', [
                'error'     => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
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

    /**
     * Logs the current user out by destroying the session.
     * Note: this does NOT clear the last_login cookie, since that
     * cookie must persist independently of session state.
     *
     * @return void
     */
    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        $this->redirect('/login');
    }
}