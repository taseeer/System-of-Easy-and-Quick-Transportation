<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelBus</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Custom CSS for Listening Animation */
.listening {
    display: flex;
    gap: 5px;
    justify-content: center;
}

.wave {
    width: 8px;
    height: 25px;
    background: #ff3b3b;
    border-radius: 10px;
    animation: wave-animation 1.2s infinite ease-in-out;
}

@keyframes wave-animation {
    0%, 100% { height: 10px; opacity: 0.3; }
    50% { height: 25px; opacity: 1; }
}
    </style>
</head>
<body>

    <!-- Header -->
    <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/FYP/php/header.php'); ?>

    <!-- Hero Section -->
    <section class="hero bg-light py-5">
        <div class="container">
            <div class="row align-items-center">
                <!-- Hero Content -->
                <div class="col-md-6 text-center text-md-start">
                    <h1 class="display-4 fw-bold">Get Your Ticket Online,<br> Easy and Safely</h1>
                    <!-- Microphone Button -->
                    <button id="micBtn" class="btn btn-danger btn-lg rounded-circle p-3 mt-3">
                        <i class="material-icons">mic</i>
                    </button>
                    <!-- Listening Animation -->
                    <div class="listening mt-3" id="listening">
                        <div class="wave"></div>
                        <div class="wave"></div>
                        <div class="wave"></div>
                        <div class="wave"></div>
                        <div class="wave"></div>
                    </div>
                </div>

                <!-- Ticket Form -->
                <div class="col-md-6 mt-5 mt-md-0">
                    <div class="card shadow">
                        <div class="card-body">
                            <h2 class="card-title text-center mb-4">Choose Your Ticket</h2>
                            <form action="php/find_tickets.php" method="POST">
                                <!-- Picking Point -->
                                <div class="mb-3">
                                    <label for="picking-point" class="form-label">Picking Point</label>
                                    <select class="form-select" id="picking-point" name="picking-point">
                                        <option value="">Select</option>
                                    </select>
                                </div>

                                <!-- Dropping Point -->
                                <div class="mb-3">
                                    <label for="dropping-point" class="form-label">Dropping Point</label>
                                    <select class="form-select" id="dropping-point" name="dropping-point">
                                        <option value="">Select</option>
                                    </select>
                                </div>

                                <!-- Date -->
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary w-100">Find Tickets</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/FYP/php/footer.php'); ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>
</html>