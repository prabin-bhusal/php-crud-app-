<footer class="footer fixed-bottom bg-dark text-white p-2 d-flex justify-content-between px-5">


    <div>
        <a href="/guest/index.php" class="text-decoration-none text-white">Back To Home</a>
    </div>
    <div>

        <?php
        if (empty($_SESSION['user'])) { ?>
            <a href="/guest/login.php" class="text-decoration-none text-white">Login</a>
        <?php

        } else { ?>
            <a href="/guest/logout.php" class="text-decoration-none text-white">Logout</a>
        <?php
        }
        ?>
    </div>

</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>