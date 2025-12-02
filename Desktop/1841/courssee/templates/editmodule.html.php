

<div class="admin-section">
    <h2>Edit Module</h2>
    
    <div class="breadcrumb">
        <a href="admin/manage_modules.php">← Back to Module Management</a>
    </div>
    
    <?php if (isset($success) && $success): ?>
        <div class="alert success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    
    <?php if (isset($error) && $error): ?>
        <div class="alert error"><?= $error ?></div>
    <?php endif; ?>
    
    <?php if ($module): ?>
    <div class="edit-module-section">
        <form method="POST" class="module-form">
            <div class="form-group">
                <label for="moduleName">Module Name:</label>
                <input type="text" id="moduleName" name="moduleName" 
                       value="<?= htmlspecialchars($module['Modulename'], ENT_QUOTES, 'UTF-8') ?>" 
                       required>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-update">Update Module</button>
                <a href="admin/manage_modules.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
        
        <div class="module-info">
            <h3>Module Information</h3>
            <p><strong>Module ID:</strong> <?= $module['id'] ?></p>
            <p><strong>Current Name:</strong> <?= htmlspecialchars($module['Modulename'], ENT_QUOTES, 'UTF-8') ?></p>
        </div>
    </div>
    <?php else: ?>
        <div class="alert error">Module not found!</div>
    <?php endif; ?>
</div>

<style>
.admin-section {
    max-width: 600px;
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

.edit-module-section {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.module-form {
    margin-bottom: 30px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input {
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
}

.btn-update:hover {
    background: #218838;
}

.btn-cancel {
    background: #6c757d;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 4px;
    display: inline-block;
}

.btn-cancel:hover {
    background: #5a6268;
}

.module-info {
    background: #e9ecef;
    padding: 15px;
    border-radius: 4px;
}

.module-info h3 {
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
</style>