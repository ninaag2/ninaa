<div class="admin-section">
    <h2>Comment Management</h2>
    
    <?php if (isset($success)): ?>
        <div class="alert success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <div class="alert error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    
    <!-- Pending Comments Section -->
    <div class="pending-comments-section">
        <h3>Pending Comments (<?= count($pendingComments) ?>)</h3>
        
        <?php if (empty($pendingComments)): ?>
            <p class="no-data">No pending comments.</p>
        <?php else: ?>
            <div class="comments-grid">
                <?php foreach ($pendingComments as $comment): ?>
                    <div class="comment-card pending">
                        <div class="comment-header">
                            <strong><?= isset($comment['username']) ? htmlspecialchars($comment['username'], ENT_QUOTES, 'UTF-8') : ''; ?></strong>
                            <span class="email">(<?= htmlspecialchars($comment['email'], ENT_QUOTES, 'UTF-8') ?>)</span>
                            <span class="date"><?= date('Y-m-d H:i', strtotime($comment['created_at'])) ?></span>
                        </div>
                        
                        <div class="question-context">
                            <strong>Question:</strong> <?= htmlspecialchars(substr($comment['questiontext'], 0, 100), ENT_QUOTES, 'UTF-8') ?>...
                        </div>
                        
                        <div class="comment-content">
                            <?= nl2br(htmlspecialchars($comment['message'], ENT_QUOTES, 'UTF-8')) ?>
                        </div>
                        
                        <div class="comment-actions">
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                <input type="hidden" name="action" value="approve">
                                <button type="submit" class="btn-approve">Approve</button>
                            </form>
                            
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                <input type="hidden" name="action" value="reject">
                                <button type="submit" class="btn-reject">Reject</button>
                            </form>
                            
                            <button class="btn-reply" onclick="showReplyForm(<?= $comment['id'] ?>)">Reply & Approve</button>
                        </div>
                        
                        <!-- Reply Form (Hidden by default) -->
                        <div id="reply-form-<?= $comment['id'] ?>" class="reply-form" style="display: none;">
                            <form method="POST">
                                <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                <input type="hidden" name="action" value="reply">
                                
                                <textarea name="reply_message" placeholder="Type your reply..." rows="3" required></textarea>
                                <div class="reply-actions">
                                    <button type="submit" class="btn-send-reply">Send Reply</button>
                                    <button type="button" class="btn-cancel" onclick="hideReplyForm(<?= $comment['id'] ?>)">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Approved Comments Section -->
    <div class="approved-comments-section">
        <h3>Recent Approved Comments (<?= count($approvedComments) ?>)</h3>
        
        <?php if (empty($approvedComments)): ?>
            <p class="no-data">No approved comments.</p>
        <?php else: ?>
            <div class="comments-table-container">
                <table class="comments-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Question</th>
                            <th>Comment</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($approvedComments as $comment): ?>
                        <tr class="<?= $comment['is_admin_reply'] ? 'admin-comment' : 'user-comment' ?>">
                            <td>
                                <?= isset($comment['username']) ? htmlspecialchars($comment['username'], ENT_QUOTES, 'UTF-8') : ''; ?>
                                <?php if ($comment['is_admin_reply']): ?>
                                    <span class="admin-badge">Admin</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $comment['type'] ?></td>
                            <td><?= htmlspecialchars(substr($comment['questiontext'], 0, 50), ENT_QUOTES, 'UTF-8') ?>...</td>
                            <td><?= htmlspecialchars(substr($comment['message'], 0, 100), ENT_QUOTES, 'UTF-8') ?>...</td>
                            <td><?= date('Y-m-d H:i', strtotime($comment['created_at'])) ?></td>
                            <td>
                                <a href="../question_detail.php?id=<?= $comment['questions_ID'] ?>" class="btn-view" target="_blank">View</a>
                                <form method="POST" style="display: inline;" onsubmit="return confirm('Delete this comment?');">;
                                    <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.admin-section {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
}

.pending-comments-section,
.approved-comments-section {
    margin-bottom: 40px;
}

.comments-grid {
    display: grid;
    gap: 20px;
    margin-top: 15px;
}

.comment-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    background: white;
}

.comment-card.pending {
    border-left: 4px solid #ffc107;
}

.comment-header {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-bottom: 10px;
    flex-wrap: wrap;
}

.comment-header .email {
    color: #666;
    font-size: 14px;
}

.comment-header .date {
    color: #666;
    font-size: 12px;
    margin-left: auto;
}

.question-context {
    background: #f8f9fa;
    padding: 8px;
    border-radius: 4px;
    margin-bottom: 10px;
    font-size: 14px;
}

.comment-content {
    margin-bottom: 15px;
    line-height: 1.4;
}

.comment-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.btn-approve {
    background: #28a745;
    color: white;
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
}

.btn-approve:hover {
    background: #218838;
}

.btn-reject {
    background: #dc3545;
    color: white;
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
}

.btn-reject:hover {
    background: #c82333;
}

.btn-reply {
    background: #007bff;
    color: white;
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
}

.btn-reply:hover {
    background: #0056b3;
}

.reply-form {
    margin-top: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 4px;
}

.reply-form textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
    margin-bottom: 10px;
}

.reply-actions {
    display: flex;
    gap: 10px;
}

.btn-send-reply {
    background: #28a745;
    color: white;
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
}

.btn-cancel {
    background: #6c757d;
    color: white;
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
}

.comments-table-container {
    overflow-x: auto;
}

.comments-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

.comments-table th,
.comments-table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    font-size: 14px;
}

.comments-table th {
    background: #f8f9fa;
    font-weight: bold;
}

.admin-comment {
    background: #e8f4fd;
}

.admin-badge {
    background: #007cba;
    color: white;
    padding: 2px 6px;
    border-radius: 10px;
    font-size: 10px;
    font-weight: bold;
}

.btn-view {
    background: #17a2b8;
    color: white;
    padding: 4px 8px;
    text-decoration: none;
    border-radius: 3px;
    font-size: 11px;
    margin-right: 5px;
}

.btn-view:hover {
    background: #138496;
}

.btn-delete {
    background: #dc3545;
    color: white;
    padding: 4px 8px;
    border: none;
    border-radius: 3px;
    font-size: 11px;
    cursor: pointer;
}

.btn-delete:hover {
    background: #c82333;
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

.no-data {
    text-align: center;
    color: #666;
    font-style: italic;
    padding: 20px;
}

@media (max-width: 768px) {
    .comment-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .comment-header .date {
        margin-left: 0;
    }
    
    .comment-actions {
        flex-direction: column;
    }
    
    .comments-table {
        font-size: 12px;
    }
    
    .comments-table th,
    .comments-table td {
        padding: 6px;
    }
}
</style>

<script>
function showReplyForm(commentId) {
    document.getElementById('reply-form-' + commentId).style.display = 'block';
}

function hideReplyForm(commentId) {
    document.getElementById('reply-form-' + commentId).style.display = 'none';
}
</script>