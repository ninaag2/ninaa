<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel ="stylesheet" href="questions.css">
    <title><?= $title ?></title>
</head>
<body>
    <header>
    <h1>  welcome to Student Forum </h1>
    
    </header>
    <nav class=" M-nav">
        <ul>
            <li><a href="index.php"a> Home</li>
            <li><a href="questions.php"> Questions List</a></li>
            <li><a href="addquestion.php"> Add Question</a></li>
            <li><a href="contact.php">Contact us</a></li>
            
            <!-- <li><a href="admin/questions.php"> Admin</a></li> -->
            <li><a href="admin/login_logout/login.php"> Login</a></li>
            <li><a href="admin/login_logout/register.php">Register </a></li>
             
            
        </ul>
    </nav>
    <main>
        <?php if (!empty($_SESSION['flash_message'])): ?>
            <div class="flash-message" style="padding:10px;background:#e0ffe0;border:1px solid #b2d8b2;margin-bottom:1em;">
                <?= htmlspecialchars($_SESSION['flash_message'], ENT_QUOTES, 'UTF-8') ?>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>
        <?php
        // Support both $output and $content variables
        if (isset($output)) {
            echo $output;
        } elseif (isset($content)) {
            echo $content;
        } else {
            echo '<p>No content available</p>';
        }
        ?>
    </main> 
    <footer>&copy; studentforum 2025</footer>
</body>
</html>

