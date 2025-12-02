<div class="question-detail">
    <?php if ($question): ?>
        <!-- Question Display -->
        <div class="question-content">
            <h2><?= htmlspecialchars($question['questiontext'], ENT_QUOTES, 'UTF-8') ?></h2>
            
            <div class="question-meta">
                <span class="users">By: <?= htmlspecialchars($question['users_username'] , ENT_QUOTES, 'UTF-8') ?></span>
                <span class="module">Module: <?= htmlspecialchars($question['module_name'] ?? 'No module', ENT_QUOTES, 'UTF-8') ?></span>
                <span class="date">Posted: <?= date('Y-m-d H:i', strtotime($question['questiondate'])) ?></span>
            </div>
            
            <?php if (!empty($question['image'])): ?>
                <div class="question-image">
                    <img src="image/<?= htmlspecialchars($question['image'], ENT_QUOTES, 'UTF-8') ?>" 
                         alt="Question image" style="max-width: 100%; height: auto;">
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Comments Section -->
        <div class="comments-section">
            <h3>Comments (<?= count($comments) ?>)</h3>
            
            <!-- Display Comments -->
            <div class="comments-list">
                <?php if (empty($comments)): ?>
                    <p class="no-comments">No comments yet. Be the first to comment!</p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment <?= $comment['is_admin_reply'] ? 'admin-comment' : 'user-comment' ?>">
                            <div class="comment-header">
                                <strong><?= isset($comment['name']) ? tmlspecialchars($comment['name'], ENT_QUOTES, 'UTF-8') : (isset($comment['username']) ? htmlspecialchars($comment['username'], ENT_QUOTES, 'UTF-8') : ''); ?></strong>
                                <?php if ($comment['is_admin_reply']): ?>
                                    <span class="admin-badge">Admin</span>
                                <?php endif; ?>
                                <span class="comment-date"><?= date('Y-m-d H:i', strtotime($comment['created_at'])) ?></span>
                            </div>
                            <div class="comment-content">
                                <?= nl2br(htmlspecialchars($comment['message'], ENT_QUOTES, 'UTF-8')) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <!-- Comment Form -->
            <div class="comment-form-section">
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <h4>Leave a Comment</h4>
                    <?php if (isset($success)): ?>
                        <div class="alert success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endif; ?>
                    
                    <?php if (isset($errors) && !empty($errors)): ?>
                        <div class="alert error">
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" class="comment-form">
                        <div class="form-group">
                            <label for="message">Your Comment *</label>
                            <textarea id="message" name="message" rows="4" required 
                                      placeholder="Share your thoughts..."><?= htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                        </div>
                        <button type="submit" name="submit_comment" class="btn-submit">Post Comment</button>
                    </form>
                    <p class="form-note">Your comment will be reviewed before being published.</p>
                <?php else: ?>
                    <div class="login-prompt">
                        <h4>Want to comment?</h4>
                        <p><a href="login.php">Login</a> or <a href="register.php">Register</a> to leave a comment!</p>
                    </div>
                <?php endif; ?>
            </div>
            </div>
        </div>
        
        <div class="back-link">
            <a href="questions.php">← Back to Questions</a>
        </div>
        
    <?php else: ?>
        <div class="alert error">Question not found!</div>
        <a href="questions.php">← Back to Questions</a>
    <?php endif; ?>
</div>

<style>
.question-detail {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
}

.question-content {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
}

.question-content h2 {
    margin-top: 0;
    color: #333;
}

.question-meta {
    display: flex;
    gap: 20px;
    margin: 15px 0;
    flex-wrap: wrap;
}

.question-meta span {
    color: #666;
    font-size: 14px;
}

.question-image {
    margin-top: 15px;
}

.comments-section {
    margin-top: 30px;
}

.comments-section h3 {
    color: #333;
    border-bottom: 2px solid #007cba;
    padding-bottom: 5px;
}

.comments-list {
    margin: 20px 0;
}

.comment {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 15px;
}

.user-comment {
    background: #ffffff;
}

.admin-comment {
    background: #e8f4fd;
    border-left: 4px solid #007cba;
}

.comment-header {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-bottom: 10px;
}

.admin-badge {
    background: #007cba;
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: bold;
}

.comment-date {
    color: #666;
    font-size: 12px;
    margin-left: auto;
}

.comment-content {
    color: #333;
    line-height: 1.5;
}

.no-comments {
    text-align: center;
    color: #666;
    font-style: italic;
    padding: 20px;
}

.comment-form-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-top: 20px;
}

.comment-form-section h4 {
    margin-top: 0;
    color: #333;
}

.comment-form .form-row {
    display: flex;
    gap: 20px;
}

.form-group {
    margin-bottom: 15px;
    flex: 1;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}

.btn-submit {
    background: #007cba;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.btn-submit:hover {
    background: #005a8b;
}

.form-note {
    font-size: 12px;
    color: #666;
    margin-top: 10px;
    font-style: italic;
}

.alert {
    padding: 10px;
    margin-bottom: 15px;
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

.alert ul {
    margin: 0;
    padding-left: 20px;
}

.back-link {
    margin-top: 30px;
    text-align: center;
}

.back-link a {
    color: #007cba;
    text-decoration: none;
}

.back-link a:hover {
    text-decoration: underline;
}

@media (max-width: 600px) {
    .question-detail {
        padding: 10px;
    }
    
    .comment-form .form-row {
        flex-direction: column;
        gap: 0;
    }
    
    .question-meta {
        flex-direction: column;
        gap: 5px;
    }
    
    .comment-header {
        flex-wrap: wrap;
    }
}

.login-prompt {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 5px;
    text-align: center;
    border: 1px solid #dee2e6;
    margin-top: 20px;
}

.login-prompt h4 {
    margin: 0 0 10px 0;
    color: #495057;
}

.login-prompt p {
    margin: 0;
    color: #6c757d;
}

.login-prompt a {
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
}

.login-prompt a:hover {
    text-decoration: underline;
}
</style>