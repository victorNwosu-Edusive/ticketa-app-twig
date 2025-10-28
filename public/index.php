<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader);

echo $twig->render('home.html.twig', [
    'year' => date('Y'),
    'title' => 'Ticketa - Manage Tickets with Ease'
]);
