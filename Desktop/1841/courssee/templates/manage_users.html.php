<div class="admin-section">
    <h2>User Management</h2>
    
    <?php if (isset($success)): ?>
        <div class="alert success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <div class="alert error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    
    <!-- Create New User Form -->
    <div class="create-user-section">
        <h3>Create New User</h3>
        <form method="POST" class="user-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role">
                    <option value="user">user</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            
            <button type="submit" name="create_user" class="btn-create">Create User</button>
        </form>
    </div>
    
    <!-- Users List -->
    <div class="users-list-section">
        <h3>All Users</h3>
        <table class="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= $user['created_at'] ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn-edit">Edit</a>
                        <form method="POST" style="display: inline;" onsubmit="return confirm('Delete this user?');">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <button type="submit" name="delete_user" class="btn-delete">Delete</button>
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

.user-form {
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
    border-radius: 4px;
    padding: 4px;
}

.form-group input,
.form-group select {
    width: 100%;
    max-width: 300px;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-left: 20px;
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
    font-size:16px;
    margin-left: 30px;
    margin-top : 0px;
}

.btn-edit {
    background-color: #28a745;
    color: white;
    font-size:16px;
}

.btn-delete {
    background-color: #dc3545;
    color: white;
    font-size: 16px;
}

.users-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.users-table th,
.users-table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

.users-table th {
    background-color: #f8f9fa;
    font-weight: bold;
}
</style>