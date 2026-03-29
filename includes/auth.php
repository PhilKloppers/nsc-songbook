<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('NSC_PASSWORD_FILE', __DIR__ . '/../config/.admin_password');

function nscIsPasswordSet() {
    return file_exists(NSC_PASSWORD_FILE) && strlen(trim(file_get_contents(NSC_PASSWORD_FILE))) > 0;
}

function nscIsAuthenticated() {
    return isset($_SESSION['nsc_admin_auth']) && $_SESSION['nsc_admin_auth'] === true;
}

function nscCheckPassword($password) {
    if (!nscIsPasswordSet()) return false;
    $hash = trim(file_get_contents(NSC_PASSWORD_FILE));
    return password_verify($password, $hash);
}

function nscSetPassword($password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $dir = dirname(NSC_PASSWORD_FILE);
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    return file_put_contents(NSC_PASSWORD_FILE, $hash) !== false;
}

function nscLogin($password) {
    if (nscCheckPassword($password)) {
        session_regenerate_id(true);
        $_SESSION['nsc_admin_auth'] = true;
        return true;
    }
    return false;
}

function nscLogout() {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }
    session_destroy();
}

function nscRequireAuth() {
    if (!nscIsPasswordSet()) {
        header('Location: login.php?setup=1');
        exit;
    }
    if (!nscIsAuthenticated()) {
        header('Location: login.php');
        exit;
    }
}

function nscRequireApiAuth() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!nscIsAuthenticated()) {
        header('Content-Type: application/json');
        http_response_code(401);
        echo json_encode(['error' => 'Authentication required']);
        exit;
    }
}
