<?php
require_once __DIR__ . '/includes/auth.php';

// Handle logout
if (isset($_GET['logout'])) {
    nscLogout();
    header('Location: login.php');
    exit;
}

// Already authenticated? Go to admin
if (nscIsAuthenticated()) {
    header('Location: admin.php');
    exit;
}

$error = '';
$isSetup = !nscIsPasswordSet();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($isSetup) {
        $pw = $_POST['password'] ?? '';
        $pw2 = $_POST['password_confirm'] ?? '';
        if (strlen($pw) < 4) {
            $error = 'Password must be at least 4 characters.';
        } elseif ($pw !== $pw2) {
            $error = 'Passwords do not match.';
        } else {
            nscSetPassword($pw);
            nscLogin($pw);
            header('Location: admin.php');
            exit;
        }
    } else {
        $pw = $_POST['password'] ?? '';
        if (nscLogin($pw)) {
            header('Location: admin.php');
            exit;
        } else {
            $error = 'Incorrect password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>NSC Songbook - <?= $isSetup ? 'Setup' : 'Login' ?></title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
	<link rel="stylesheet" href="css/mdb.min.css" />
	<link rel="stylesheet" href="css/style.css" />
	<script>(function(){var t=localStorage.getItem('nsc-theme')||'dark';document.documentElement.setAttribute('data-theme',t);})();</script>
	<style>
		.login-container {
			max-width: 400px;
			margin: 80px auto;
			padding: 32px;
			background: var(--bg-card);
			border-radius: 12px;
			box-shadow: 0 4px 20px rgba(0,0,0,0.3);
		}
		.login-container h2 {
			color: var(--text-primary);
			margin-bottom: 8px;
		}
		.login-container .subtitle {
			color: var(--text-secondary);
			margin-bottom: 24px;
		}
		.login-container input {
			background: var(--bg-body);
			border: 1px solid var(--border-color);
			color: var(--text-primary);
			width: 100%;
			padding: 12px;
			border-radius: 6px;
			margin-bottom: 16px;
			font-size: 1rem;
		}
		.login-container input:focus {
			outline: none;
			border-color: var(--accent);
			box-shadow: 0 0 0 2px rgba(74,158,255,0.2);
		}
		.btn-login {
			width: 100%;
			padding: 12px;
			background: var(--accent);
			color: #fff;
			border: none;
			border-radius: 6px;
			font-size: 1rem;
			font-weight: 500;
			cursor: pointer;
		}
		.btn-login:hover { opacity: 0.9; }
		.error-msg {
			background: rgba(249,49,84,0.15);
			color: #ff6b6b;
			padding: 10px 14px;
			border-radius: 6px;
			margin-bottom: 16px;
			font-size: 0.9rem;
		}
	</style>
</head>
<body>
	<div class="login-container">
		<?php if ($isSetup): ?>
			<h2><i class="fas fa-lock"></i> Setup Admin Password</h2>
			<p class="subtitle">Create a password to protect the admin interface.</p>
			<?php if ($error): ?><div class="error-msg"><?= htmlspecialchars($error) ?></div><?php endif; ?>
			<form method="POST">
				<input type="password" name="password" placeholder="New password" required autofocus />
				<input type="password" name="password_confirm" placeholder="Confirm password" required />
				<button type="submit" class="btn-login">Set Password &amp; Enter</button>
			</form>
		<?php else: ?>
			<h2><i class="fas fa-lock"></i> Admin Login</h2>
			<p class="subtitle">Enter the admin password to continue.</p>
			<?php if ($error): ?><div class="error-msg"><?= htmlspecialchars($error) ?></div><?php endif; ?>
			<form method="POST">
				<input type="password" name="password" placeholder="Password" required autofocus />
				<button type="submit" class="btn-login">Login</button>
			</form>
		<?php endif; ?>
		<div style="text-align:center; margin-top:16px;">
			<a href="index.php" style="color:var(--text-secondary); font-size:0.9rem;">&larr; Back to Songbook</a>
		</div>
	</div>
</body>
</html>
