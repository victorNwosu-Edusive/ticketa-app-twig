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
$tickets = [];

if (file_exists($ticketsFile)) {
    $content = file_get_contents($ticketsFile);
    if (!empty($content)) {
        $tickets = json_decode($content, true) ?? [];
    }
}

echo $twig->render('dashboard.html.twig', ['user' => $user, 'tickets' => $tickets, 'title' => 'Dashboard - Ticketa']);
