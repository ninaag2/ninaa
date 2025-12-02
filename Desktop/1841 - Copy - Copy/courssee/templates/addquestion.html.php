<form action="" method="post" enctype="multipart/form-data">
    <label class="form-group" for="questiontext">Type your question here:</label>
    <textarea name="questiontext" id="questiontext" cols="40" rows="3"><?php echo isset($_POST['questiontext']) ? htmlspecialchars($_POST['questiontext'], ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
    
    <label for="users_username">Type your a Name :</label>
    <input class="form"type="text" name="users_username" id="users_username" value="<?php echo isset($_POST['users_username']) ? htmlspecialchars($_POST['users_username'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
    
    <label for="users_email">Type your an email :</label>
    <input class="form"type="email" name="users_email" id="users_email" value="<?php echo isset($_POST['users_email']) ? htmlspecialchars($_POST['users_email'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
    <label class="form-group" for="modules">Select a module:</label>
    <select name="modules" id="modules">
        <option value="">Select a module</option>
        <?php if (isset($modules)): ?>
            <?php foreach($modules as $module): ?>
                <option value="<?php echo htmlspecialchars($module['id'], ENT_QUOTES, 'UTF-8'); ?>"
                    <?php echo (isset($_POST['modules']) && $_POST['modules'] == $module['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($module['Modulename'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
    
    <label class="form-group" for="image">Image:</label>
    <input type="file" name="image" id="image" accept="image/*">
    
    <input class="button-a-question" type="submit" name="submit" value="Add Question">
</form>
       
<style>
    form {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    
    .form-group {
        margin-bottom: 15px;
        display: flex;
        flex-direction: column;
        padding:10px;
        margin-right:5px;
    }


    
    label {
        margin-bottom: 5px;
        font-weight: bold;
    }
    
    textarea, select, input[type="file"] {
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    
    .button-a-question {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    
    .button-a-question:hover {
        background-color: #45a049;
    }
    .form{
        padding:17px;
        margin-left:10px;
    }
</style>