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
$ticket = null;

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: /tickets.php');
    exit;
}

// Load tickets
$tickets = [];
if (file_exists($ticketsFile)) {
    $content = file_get_contents($ticketsFile);
    if (!empty($content)) {
        $tickets = json_decode($content, true) ?? [];
    }
}

// Find ticket
foreach ($tickets as $t) {
    if ($t['id'] === $id) {
        $ticket = $t;
        break;
    }
}

if (!$ticket) {
    header('Location: /tickets.php');
    exit;
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $status = $_POST['status'] ?? 'open';

    if (empty($title) || empty($description)) {
        $toast = ['message' => '⚠ Title and description are required.', 'type' => 'error'];
    } else {
        // Update ticket
        foreach ($tickets as &$t) {
            if ($t['id'] === $id) {
                $t['title'] = $title;
                $t['description'] = $description;
                $t['status'] = $status;
                $ticket = $t;
                break;
            }
        }

        file_put_contents($ticketsFile, json_encode($tickets, JSON_PRETTY_PRINT));
        $toast = ['message' => '✅ Ticket updated successfully!', 'type' => 'success'];
        
        echo "<script>
            setTimeout(() => window.location.href = '/tickets.php', 2000);
        </script>";
    }
}

echo $twig->render('edit-ticket.html.twig', ['user' => $user, 'ticket' => $ticket, 'toast' => $toast, 'title' => 'Edit Ticket - Ticketa']);