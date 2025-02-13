<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelBus</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/FYP/php/header.php'); ?>


    <section class="hero">
        <div class="hero-content">
            <h1>Get Your Ticket Online,<br> Easy and Safely</h1>
            <button id="micBtn" class="mic-btn"><i class="material-icons">mic</i></button>
            <div class="listening" id="listening">
                <div class="wave"></div>
                <div class="wave"></div>
                <div class="wave"></div>
                <div class="wave"></div>
                <div class="wave"></div>
            </div>
            <a href="#" class="cta-btn">GET TICKETS NOW</a>
        </div>
        
        <div class="ticket-form">
            <h2>Choose Your Ticket</h2>
            <form action="php/find_tickets.php" method="POST">
                <label for="picking-point">Picking Point</label>
                <select id="picking-point" name="picking-point">
                    <option value="">Select</option>
                </select>
                
                <label for="dropping-point">Dropping Point</label>
                <select id="dropping-point" name="dropping-point">
                    <option value="">Select</option>
                </select>
                
                <label for="date">Date</label>
                <input type="date" id="date" name="date" required>
                
                <button type="submit">Find Tickets</button>
            </form>
        </div>
    </section>
    <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/FYP/php/footer.php'); ?>

    <!-- ✅ Load JavaScript only once at the end -->
    <script src="js/script.js"></script>
</body>
</html>
