<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel ="stylesheet" href="../questions.css">
    <title><?php echo $title; ?></title>
</head>
<body>
    <header id="admin">
        <h1> Studentforum Admin Area</h1>
    </header>
    <nav>
        <ul>
            <li><a href="questions.php">Questions List</a></li>
           
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_modules.php">Manage Modules</a></li>
            <li><a href="manage_comments.php">Manage Comments</a></li>
            <!-- <li><a href="register.php">Register User</a></li> -->
            <li><a href="login_logout/logout.php">Logout</a></li>
            <li><a href="../index.php">Public Site</a></li>
        </ul>
    </nav>
    <main>
        <?php if (!empty($_SESSION['flash_message'])): ?>
            <div class="flash-message" style="padding:10px;background:#e0ffe0;border:1px solid #b2d8b2;margin-bottom:1em;">
                <?php echo htmlspecialchars($_SESSION['flash_message'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>
    <?php echo $output; ?>
    </main> 
    <footer>&copy; Studentforum 2025 </footer>
</body>
</html>