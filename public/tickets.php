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

// Load tickets
$tickets = [];
if (file_exists($ticketsFile)) {
    $content = file_get_contents($ticketsFile);
    if (!empty($content)) {
        $tickets = json_decode($content, true) ?? [];
    }
}

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'delete' && isset($_POST['id'])) {
        $id = $_POST['id'];
        $tickets = array_filter($tickets, fn($t) => $t['id'] !== $id);
        file_put_contents($ticketsFile, json_encode(array_values($tickets), JSON_PRETTY_PRINT));
        $toast = ['message' => '✅ Ticket deleted successfully!', 'type' => 'success'];
    }
}

echo $twig->render('tickets.html.twig', ['user' => $user, 'tickets' => $tickets, 'toast' => $toast, 'title' => 'Tickets - Ticketa']);