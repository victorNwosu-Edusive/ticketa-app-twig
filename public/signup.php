<?php
require_once '../vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);

$toast = null;
$dataFile = '../data/users.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($name) || empty($email) || empty($password)) {
        $toast = ['message' => '⚠ All fields are required.', 'type' => 'error'];
    } else {
        $users = json_decode(file_get_contents($dataFile), true) ?? [];

        $exists = array_filter($users, fn($u) => $u['email'] === $email);

        if ($exists) {
            $toast = ['message' => '❌ Email already exists.', 'type' => 'error'];
        } else {
            $users[] = ['id' => uniqid(), 'name' => $name, 'email' => $email, 'password' => $password];
            file_put_contents($dataFile, json_encode($users, JSON_PRETTY_PRINT));
            $toast = ['message' => '✅ Signup successful! Redirecting to login...', 'type' => 'success'];

            echo "<script>
                    setTimeout(() => window.location.href = '/login.php', 2000);
                  </script>";
        }
    }
}

echo $twig->render('signup.html.twig', ['toast' => $toast, 'title' => 'Sign Up - Ticketa']);
