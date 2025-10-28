<?php
require_once '../vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);

session_start();

$toast = null;
$dataFile = '../data/users.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $users = json_decode(file_get_contents($dataFile), true) ?? [];
    $user = null;

    foreach ($users as $u) {
        if ($u['email'] === $email && $u['password'] === $password) {
            $user = $u;
            break;
        }
    }

    if ($user) {
        $_SESSION['user'] = ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email']];
        $toast = ['message' => '☑ Login successful! Redirecting...', 'type' => 'success'];
        echo "<script>
                setTimeout(() => window.location.href = '/dashboard.php', 2000);
              </script>";
    } else {
        $toast = ['message' => '⚠ Invalid credentials. Try again.', 'type' => 'error'];
    }
}

echo $twig->render('login.html.twig', ['toast' => $toast, 'title' => 'Login - Ticketa']);
