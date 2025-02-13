<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelBus</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
<header>
    <div class="logo">
    <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/FYP/php/config.php'); ?>
<img src="<?php echo BASE_URL; ?>images/logo.png" alt="TravelBus Logo">


    </div>
    <nav>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="../about.php">About</a></li>
            <li><a href="../faqs.php">FAQs</a></li>
            <li><a href="../contact.php">Contact</a></li>
            <li><a href="../find_tickets.php" class="buy-tickets">Buy Tickets</a></li>
        </ul>
    </nav>
</header>

