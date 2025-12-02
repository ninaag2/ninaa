<div class="admin-section">
    <h2>Module Management</h2>
    
    <?php if (isset($success)): ?>
        <div class="alert success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <div class="alert error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    
    <!-- Create New Module Form -->
    <div class="create-module-section">
        <h3>Create New Module</h3>
        <form method="POST" class="module-form">
            <div class="form-group">
                <label for="module_name">Module Name:</label>
                <input type="text" id="module_name" name="module_name" required>
            </div>
            
            <button type="submit" name="create_module" class="btn-create">Create Module</button>
        </form>
    </div>
    
    <!-- Modules List -->
    <div class="modules-list-section">
        <h3>All Modules</h3>
        <table class="modules-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Module Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($modules as $module): ?>
                <tr>
                    <td><?= $module['id'] ?></td>
                    <td><?= htmlspecialchars($module['Modulename'] ?? 'No name', ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <a href="../editmodule.php?id=<?= $module['id'] ?>" class="btn-edit">Edit</a>
                        <form method="POST" style="display: inline;" onsubmit="return confirm('Delete this module?');">
                            <input type="hidden" name="module_id" value="<?= $module['id'] ?>">
                            <button type="submit" name="delete_module" class="btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
.admin-section {
    padding: 20px;
}

.alert {
    padding: 10px;
    margin: 10px 0;
    border-radius: 4px;
}

.alert.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.module-form {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 5px;
    margin: 20px 0;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    margin-right:20px;
    padding:4px;
}

.form-group input,
.form-group textarea {
    width: 100%;
    max-width: 400px;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.btn-create, .btn-edit, .btn-delete {
    padding: 8px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    margin-right: 5px;
}

.btn-create {
    background-color: #007bff;
    color: white;
    margin-left: 30px;
    margin-top: 20px;
    font-size: 16px;
}

.btn-edit {
    background-color: #28a745;
    color: white;
    font-size:16px;
}

.btn-delete {
    background-color: #dc3545;
    color: white;
    font-size:16px;
}

.modules-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.modules-table th,
.modules-table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

.modules-table th {
    background-color: #f8f9fa;
    font-weight: bold;
}
</style>