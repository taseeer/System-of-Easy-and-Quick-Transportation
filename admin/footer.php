<footer class="main-footer">
        <strong>Copyright &copy; 2023 Your Company.</strong> All rights reserved.
    </footer>
<!-- jQuery -->
<script src="../admin/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 JS -->
<script src="../admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../admin/assets/dist/js/adminlte.min.js"></script>
<script src="../js/search.js"></script>
<script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Bootstrap toasts
            var toasts = document.querySelectorAll('.toast');
            toasts.forEach(function (toast) {
                new bootstrap.Toast(toast, {
                    autohide: true,
                    delay: 5000 // 5 seconds
                }).show();
            });
        });
    </script>
</body>
</html>