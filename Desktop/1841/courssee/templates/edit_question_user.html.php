<div class="edit-question-form">
    <h2>Edit Your Question</h2>
    
    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="alert error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form action="" method="post" enctype="multipart/form-data" class="question-form">
        <div class="form-group">
            <label for="questiontext">Question Text *</label>
            <textarea id="questiontext" name="questiontext" rows="6" required><?= htmlspecialchars($question['questiontext'], ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>

        <div class="form-group">
            <label for="username">User Name *</label>
            <input type="text" id="username" name="username" required value="<?= isset($question['username']) ? htmlspecialchars($question['username'], ENT_QUOTES, 'UTF-8') : '' ?>">
        </div>

        <div class="form-group">
            <label for="moduleid">Module *</label>
            <select id="moduleid" name="moduleid" required>
                <option value="">Select a module</option>
                <?php foreach ($modules as $module): ?>
                    <option value="<?= $module['id'] ?>" <?= $question['moduleid'] == $module['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($module['moduleName'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="image">Image (optional)</label>
            <?php if (!empty($question['image'])): ?>
                <div class="current-image">
                    <p>Current image:</p>
                    <img src="<?= htmlspecialchars(getImagePath($question['image']), ENT_QUOTES, 'UTF-8') ?>" alt="Current question image" style="max-width: 200px; margin-bottom: 10px;">
                </div>
            <?php endif; ?>
            <input type="file" id="image" name="image" accept="image/*">
            <small>Leave empty to keep current image. Supported formats: JPG, PNG, GIF</small>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Question</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<style>
.edit-question-form {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
}

.question-form {
    background: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

.form-group textarea,
.form-group select,
.form-group input[type="file"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;
}

.form-group textarea {
    resize: vertical;
    min-height: 120px;
}

.form-group select {
    height: 40px;
}

.current-image {
    margin-bottom: 10px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 4px;
}

.current-image p {
    margin: 0 0 10px 0;
    font-weight: bold;
}

.form-group small {
    display: block;
    margin-top: 5px;
    color: #666;
    font-size: 12px;
}

.form-actions {
    margin-top: 30px;
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.btn {
    padding: 12px 24px;
    text-decoration: none;
    border-radius: 4px;
    font-weight: bold;
    display: inline-block;
    text-align: center;
    border: none;
    cursor: pointer;
    font-size: 14px;
}

.btn-primary {
    background: #007bff;
    color: white;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn:hover {
    opacity: 0.9;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
}

.alert.error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert ul {
    margin: 0;
    padding-left: 20px;
}

@media (max-width: 768px) {
    .edit-question-form {
        margin: 10px;
        padding: 10px;
    }
    
    .question-form {
        padding: 20px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn {
        text-align: center;
    }
}
</style>