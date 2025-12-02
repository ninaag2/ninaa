<div class="admin-section">
    <h2>Edit User</h2>
    
    <div class="breadcrumb">
        <a href="manage_users.php">← Back to User Management</a>
    </div>
    
    <?php if ($success): ?>
        <div class="alert success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert error"><?= $error ?></div>
    <?php endif; ?>
    
    <?php if ($user): ?>
    <div class="edit-user-section">
        <form method="POST" class="user-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" 
                           value="<?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?>" 
                           required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" 
                           value="<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>" 
                           required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>user</option>
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="password">New Passwor:</label>
                    <input type="password" id="password" name="password" 
                           placeholder="Enter new password or leave blank">
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-update">Update User</button>
                <a href="manage_users.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
        
        <div class="user-info">
            <h3>User Information</h3>
            <p><strong>User ID:</strong> <?= $user['id'] ?></p>
            <p><strong>Created:</strong> <?= date('Y-m-d H:i:s', strtotime($user['created_at'])) ?></p>
            <p><strong>Current Role:</strong> <?= ucfirst($user['role']) ?></p>
        </div>
    </div>
    <?php else: ?>
        <div class="alert error">User not found!</div>
    <?php endif; ?>
</div>

<style>
.admin-section {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
}

.breadcrumb {
    margin-bottom: 20px;
}

.breadcrumb a {
    color: #007cba;
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.edit-user-section {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.user-form {
    margin-bottom: 30px;
}

.form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
}

.form-group {
    flex: 1;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}

.form-actions {
    margin-top: 20px;
}

.btn-update {
    background: #28a745;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 10px;
    font-size: 16px;
}

.btn-update:hover {
    background: #218838;
}

.btn-cancel {
    background: #f21c23ff;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 4px;
    display: inline-block;
    font-size: 16px;
}

.btn-cancel:hover {
    background: #5a6268;
}

.user-info {
    background: #e9ecef;
    padding: 15px;
    border-radius: 4px;
}

.user-info h3 {
    margin-top: 0;
    color: #495057;
}

.alert {
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 4px;
}

.alert.success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert.error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

@media (max-width: 600px) {
    .form-row {
        flex-direction: column;
        gap: 10px;
    }
}
</style>