<head>
 <link rel="stylesheet" href="login_out_register.css">
</head>
<body>

<div class="register-section">
    <h2>Registration</h2>
    
    <?php if (isset($success)): ?>
        <div class="alert success">
            <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
            <br><br><a href="login.php" class="btn-link">Login Now</a>
        </div>
    <?php endif; ?>
    
    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="alert error">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <?php if (!isset($success)): ?>
    <div class="registration-form-container">
        <form method="POST" class="register-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <!-- <div class="form-group">
                <label for="role">I am a:</label>
                <select id="role" name="role">
                    <option value="user" <?= ($_POST['role'] ?? '') === 'student' ? 'selected' : '' ?>>user</option>
                    <option value="admin" <?= ($_POST['role'] ?? '') === 'teacher' ? 'selected' : '' ?>>admin</option>
                </select>
            </div> -->
            
            <button type="submit" name="register" class="btn-register">Create Account</button>
        </form>
        
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
    <?php endif; ?>
</div>
</body>

