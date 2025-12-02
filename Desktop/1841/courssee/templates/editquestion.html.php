<?php if (isset($errorOutput)) echo $errorOutput; ?>
<?php if (!is_array($question)) {
    echo '<div class="errors">Không tìm thấy câu hỏi hoặc dữ liệu bị lỗi.</div>';
    return;
}
?>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="questionid" value="<?=$question['ID'];?>">
    
    <label for='questiontext'>Edit your question here:</label>
    <textarea id="questiontext" name="questiontext" rows="3" cols="40"><?php
    if (is_array($question) && isset($question['questiontext'])) {
        echo htmlspecialchars($question['questiontext'], ENT_QUOTES, 'UTF-8');
    }
    ?></textarea>
    
    <label for='username'>Edit your name:</label>
    <input type="text" id="username" name="username" value="<?php
        if (isset($_POST['username'])) {
            echo htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
        } elseif (isset($question['username'])) {
            echo htmlspecialchars($question['username'], ENT_QUOTES, 'UTF-8');
        }
    ?>">
    <label for="users_email"> Email</label>
    <input type="email" id="users_email" name="users_email" value="<?php
        if (isset($_POST['users_email'])) {
            echo htmlspecialchars($_POST['users_email'], ENT_QUOTES, 'UTF-8');
        } elseif (isset($question['users_email'])) {
            echo htmlspecialchars($question['users_email'], ENT_QUOTES, 'UTF-8');
        }
    ?>">
    
    
    <!-- <label for="users">Select a user:</label>
    <select name="users" id="users">
        <option value="">Select a user</option>
        <?php foreach($users as $user): ?>
            <option value="<?php echo htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8'); ?>" 
                <?php echo ($question['userid'] == $user['id']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?>
            </option>
        <?php endforeach; ?>
    </select> -->
    
    <label for="modules">Select a module:</label>
    <select name="modules" id="modules">
        <option value="">Select a module</option>
        <?php foreach($modules as $module): ?>
            <option value="<?php echo htmlspecialchars($module['id'], ENT_QUOTES, 'UTF-8'); ?>"
                <?php echo (isset($question['modules_id']) && $question['modules_id'] == $module['id']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($module['Modulename'], ENT_QUOTES, 'UTF-8'); ?>
            </option>
        <?php endforeach; ?>
    </select>
    
    <label for="image">Image:</label>
    <input type="file" name="image" id="image" accept="image/*">
    <?php if (!empty($question['image'])): ?>
        <p>Current image: <img src="<?php echo htmlspecialchars(getImagePath($question['image']), ENT_QUOTES, 'UTF-8'); ?>" style="max-width:100px;"></p>
    <?php endif; ?>

    <input class="button-a-question" type="submit" name="submit" value="Save">
</form>