<?php foreach ($questions as $question): ?>
    <blockquote>
     <?php echo htmlspecialchars($question['questiontext'], ENT_QUOTES, 'UTF-8'); ?>
     <br/><?php echo htmlspecialchars($question['module_name'], ENT_QUOTES, 'UTF-8'); ?>
    <?php if (!empty($question['image'])): ?>
        <div class="question-image">
            <a href="<?php echo htmlspecialchars(getImagePath($question['image']), ENT_QUOTES, 'UTF-8'); ?>" target="_blank">
                <img src="<?php echo htmlspecialchars(getImagePath($question['image']), ENT_QUOTES, 'UTF-8'); ?>"
                     alt="Question image" style="max-width:200px;display:block;margin-top:0.5em;">
            </a>
        </div>
    <?php endif; ?>
    (Poster: <?php echo !empty($question['username']) ? htmlspecialchars($question['username'], ENT_QUOTES, 'UTF-8') : 'Unknown'; ?> | 
    Day: <?php echo htmlspecialchars($question['questiondate'], ENT_QUOTES, 'UTF-8'); ?> | 
    Time: <?php echo htmlspecialchars($question['questiontime'], ENT_QUOTES, 'UTF-8'); ?>)
    <br/>
    <a href="editquestion.php?id=<?php echo $question['ID']; ?>">Edit</a>
    <form action="deletequestion.php" method="post" style="display:inline;" onsubmit="return confirm('Delete this question?');">
        <input type="hidden" name="id" value="<?php echo $question['ID']; ?>">
        <input  class="button-delete" type="submit" value="Delete">
    </form>
    </blockquote>

<?php endforeach; ?>