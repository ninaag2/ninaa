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
    
    <div class="question-actions" style="margin-top: 10px;">
        <a href="question_detail.php?id=<?php echo $question['ID']; ?>" class="view-details-btn"> Comments</a>
    </div>

    </blockquote>
    
    
<?php endforeach; ?>

<style>
.view-details-btn {
    display: inline-block;
    background: #007cba;
    color: white;
    padding: 6px 12px;
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
    transition: background-color 0.3s;
}

.view-details-btn:hover {
    background: #005a8b;
}
</style> 