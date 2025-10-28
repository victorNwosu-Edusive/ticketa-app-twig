<?php
require_once '../vendor/autoload.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: /login.php');
    exit;
}

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);

$user = $_SESSION['user'];
$ticketsFile = '../data/tickets.json';
$toast = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $status = $_POST['status'] ?? 'open';

    if (empty($title) || empty($description)) {
        $toast = ['message' => '⚠ Title and description are required.', 'type' => 'error'];
    } else {
        $tickets = [];
        if (file_exists($ticketsFile)) {
            $content = file_get_contents($ticketsFile);
            if (!empty($content)) {
                $tickets = json_decode($content, true) ?? [];
            }
        }

        $tickets[] = [
            'id' => uniqid(),
            'title' => $title,
            'description' => $description,
            'status' => $status,
            'createdAt' => date('Y-m-d H:i:s')
        ];

        file_put_contents($ticketsFile, json_encode($tickets, JSON_PRETTY_PRINT));
        $toast = ['message' => '✅ Ticket created successfully!', 'type' => 'success'];
        
        echo "<script>
            setTimeout(() => window.location.href = '/tickets.php', 2000);
        </script>";
    }
}

echo $twig->render('create-ticket.html.twig', ['user' => $user, 'toast' => $toast, 'title' => 'Create Ticket - Ticketa']);