<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// ========== CORE QUERY FUNCTION ==========
function query($pdo, $sql, $parameters = [])
{
    if (empty($parameters)) {
        $query = $pdo->query($sql);
        $query->execute();
    } else {
        $query = $pdo->prepare($sql);
        $query->execute($parameters);
    }
    return $query;
}

// ========== QUESTIONS FUNCTIONS ========== 
function getAllQuestions($pdo) {
    $sql = 'SELECT q.*, m.moduleName as module_name, u.username as user_username,
        DATE(q.questiondate) as questiondate, q.questiontime as questiontime
        FROM questions q 
        LEFT JOIN users u ON q.users_id = u.id
        LEFT JOIN module m ON q.moduleid = m.id
        ORDER BY q.questiondate DESC';
    return query($pdo, $sql);
}

function totalQuestions($pdo) {
    // fetchColumn() is independent of fetch mode and returns the first column of the next row
    $query = query($pdo, 'SELECT COUNT(*) FROM questions');
    return (int) $query->fetchColumn();
}

function getQuestionById($pdo, $id) {
    $parameters = [':id' => $id];
    $query = query($pdo, 'SELECT * FROM questions WHERE id = :id', $parameters);
    return $query->fetch();
}

function addQuestion($pdo, $questiontext, $users_id, $moduleid, $imagePath = null, $questiontime = null) {
    $stmt = $pdo->prepare('SELECT username FROM users WHERE id = ?');
    $stmt->execute([$users_id]);
    $user = $stmt->fetch();
    $username = $user ? $user['username'] : null;

    $sql = 'INSERT INTO questions (questiontext, image, questiondate, questiontime, users_id, moduleid, username) 
            VALUES (:questiontext, :image, CURRENT_DATE(), CURRENT_TIME(), :users_id, :moduleid, :username)';
    $parameters = [
        ':questiontext' => $questiontext,
        ':users_id' => $users_id,
        ':moduleid' => $moduleid,
        ':image' => $imagePath,
        ':username' => $username
    ];
    query($pdo, $sql, $parameters);
}

function updateQuestion($pdo, $id, $questiontext, $users_id, $moduleid, $imagePath = null) {
    if ($imagePath !== null) {
        $sql = 'UPDATE questions SET questiontext = :questiontext, users_id = :users_id, username = :username, 
                moduleid = :moduleid, image = :image, questiontime = CURRENT_TIME WHERE id = :id';
        $parameters = [
            ':questiontext' => $questiontext,
            ':users_id' => $users_id,
            ':username' => $username,
            ':moduleid' => $moduleid,
            ':image' => $imagePath,
            ':id' => $id
        ];
    } else {
        $sql = 'UPDATE questions SET questiontext = :questiontext, users_id = :users_id, username = :username, 
                moduleid = :moduleid ,questiontime = CURRENT_TIME WHERE id = :id';
        $parameters = [
            ':questiontext' => $questiontext,
            ':users_id' => $users_id    ,
            ':username' => $username,
            ':moduleid' => $moduleid,
            ':id' => $id
        ];
    }
    query($pdo, $sql, $parameters);
}

function deleteQuestion($pdo, $id) {
    // Get image path before deleting to remove file
    $question = getQuestionById($pdo, $id);
    if ($question && !empty($question['image'])) {
        $imagePath = __DIR__ . '/../' . $question['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
    $parameters = [':id' => $id];
    query($pdo, 'DELETE FROM questions WHERE id = :id', $parameters);
}

// ========== USER FUNCTIONS ==========
// USER FUNCTIONS REMOVED. Use users table and related functions instead.

// ========== MODULE FUNCTIONS ==========
function getAllModules($pdo) {
    return query($pdo, 'SELECT * FROM module ORDER BY Modulename');
}

function getModuleById($pdo, $id) {
    $parameters = [':id' => $id];
    $query = query($pdo, 'SELECT * FROM module WHERE id = :id', $parameters);
    return $query->fetch();
}

function addModule($pdo, $moduleName, $description = null) {
    $sql = 'INSERT INTO module (moduleName, description) VALUES (:moduleName, :description)';
    $parameters = [
        ':moduleName' => $moduleName,
        ':description' => $description
    ];
    query($pdo, $sql, $parameters);
}

function updateModule($pdo, $id, $moduleName, $description = null) {
    $sql = 'UPDATE module SET moduleName = :moduleName, description = :description WHERE id = :id';
    $parameters = [
        ':moduleName' => $moduleName,
        ':description' => $description,
        ':id' => $id
    ];
    query($pdo, $sql, $parameters);
}

function deleteModule($pdo, $id) {
    $parameters = [':id' => $id];
    query($pdo, 'DELETE FROM module WHERE id = :id', $parameters);
}

// ========== SEARCH AND FILTER FUNCTIONS ==========
function searchQuestions($pdo, $searchTerm) {
    $sql = 'SELECT q.*, u.username as users_username, m.moduleName as module_name,
        DATE(q.questiondate) as post_date, TIME(q.questiondate) as post_time
        FROM questions q 
        LEFT JOIN users u ON q.users_id = u.id 
        LEFT JOIN module m ON q.moduleid = m.id 
        WHERE q.questiontext LIKE :search 
        OR u.username LIKE :search 
        OR m.moduleName LIKE :search 
        ORDER BY q.questiondate DESC';
    $parameters = [':search' => '%' . $searchTerm . '%'];
    return query($pdo, $sql, $parameters);
}

function getQuestionsByModule($pdo, $moduleId) {
    $sql = 'SELECT q.*, u.username as users_username, m.moduleName as module_name,
        DATE(q.questiondate) as post_date, TIME(q.questiondate) as questiondate, q.questiontime as questiontime
        FROM questions q 
        LEFT JOIN users u ON q.users_id = u.id 
        LEFT JOIN module m ON q.moduleid = m.id 
        WHERE q.moduleid = :moduleid 
        ORDER BY q.questiondate DESC';
    $parameters = [':moduleid' => $moduleId];
    return query($pdo, $sql, $parameters);
}

function getQuestionsByUser($pdo, $userid) {
    $sql = 'SELECT q.*, u.username as users_username, m.moduleName as module_name,
        DATE(q.questiondate) as questiondate, q.questiontime as questiontime
        FROM questions q 
        LEFT JOIN users u ON q.users_id = u.id 
        LEFT JOIN module m ON q.moduleid = m.id 
        WHERE q.users_id = :users_id 
        ORDER BY q.questiondate DESC';
    $parameters = [':users_id' => $users_id];
    return query($pdo, $sql, $parameters);
}



// ========== UTILITY FUNCTIONS ==========
function handleImageUpload($file) {
    if (empty($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $tmp = $file['tmp_name'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $tmp);
    finfo_close($finfo);

    $allowed = [
        'image/jpeg' => 'jpg', 
        'image/png' => 'png', 
        'image/gif' => 'gif'
    ];

    if (!isset($allowed[$mime])) {
        throw new Exception('Invalid file type. Only JPG, PNG, and GIF are allowed.');
    }

    $ext = $allowed[$mime];
    $uploadDir = __DIR__ . '/../image/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $filename = uniqid('img_', true) . '.' . $ext;
    if (move_uploaded_file($tmp, $uploadDir . $filename)) {
        return 'image/' . $filename;
    }

    throw new Exception('Failed to upload image.');
}

function getImagePath($imagePath) {
    // This function returns the correct path for images from any directory
    if (empty($imagePath)) {
        return null;
    }
    
    // Check if we're in admin directory
    $currentDir = basename(dirname($_SERVER['SCRIPT_NAME']));
    if ($currentDir === 'admin') {
        // We're in admin, need to go up one level
        return '../' . $imagePath;
    } else {
        // We're in root directory
        return $imagePath;
    }
}

function deleteImageFile($imagePath) {
    if (!empty($imagePath)) {
        $fullPath = __DIR__ . '/../' . $imagePath;
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}

// ========== VALIDATION FUNCTIONS ==========
function validateQuestion($questiontext, $username, $useremail, $moduleid) {
    $errors = [];
    if (empty(trim($questiontext))) {
        $errors[] = 'Question text is required.';
    }
    if (empty(trim($username))) {
        $errors[] = 'User name is required.';
    }
    if (empty(trim($useremail))) {
        $errors[] = 'User email is required.';
    } elseif (!filter_var($useremail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (empty($moduleid) || !is_numeric($moduleid)) {
        $errors[] = 'Please select a valid module.';
    }
    return $errors;
}

function validateUser($name, $email = null) {
    $errors = [];

    if (empty(trim($name))) {
        $errors[] = 'User name is required.';
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    return $errors;
}

function validateModule($moduleName) {
    $errors = [];

    if (empty(trim($moduleName))) {
        $errors[] = 'Module name is required.';
    }

    return $errors;
}

function isValidContactForm($name, $email, $subject, $message) {
    if (empty(trim($name)) || empty(trim($email)) || empty(trim($subject)) || empty(trim($message))) {
        return false;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}

// ========== LEGACY FUNCTION ALIASES (for backward compatibility) ========== 
function addquestions($pdo, $questiontext, $questiontime, $users_id, $moduleid, $user_name, $imagePath = null) {
    return addQuestion($pdo, $questiontext, $users_id, $moduleid, $imagePath,$user_name, $questiontime);
}

function getquestions($pdo, $id) {
    return getQuestionById($pdo, $id);
}

function updatequestions($pdo, $id, $questiontext) {
    // This is a simplified version - consider using updateQuestion instead
    $sql = 'UPDATE questions SET questiontext = :questiontext WHERE id = :id';
    $parameters = [
        ':questiontext' => $questiontext,
        ':id' => $id
    ];
    query($pdo, $sql, $parameters);
}

function deletequestions($pdo, $id) {
    return deleteQuestion($pdo, $id);
}

// ========== COMMENTS FUNCTIONS ==========
function addComment($pdo, $questions_ID, $username, $email, $message, $isAdminReply = 0, $parentId = null) {
    $sql = 'INSERT INTO comments (questions_ID, username, email, commentText, is_admin_reply, parent_id, status) 
            VALUES (:questions_ID, :username, :email, :commentText, :is_admin_reply, :parent_id, :status)';
    $status = $isAdminReply ? 'approved' : 'pending';
    $parameters = [
        ':questions_ID' => $questions_ID,
        ':username' => $username,
        ':email' => $email,
        ':commentText' => $message,
        ':is_admin_reply' => $isAdminReply,
        ':parent_id' => $parentId,
        ':status' => $status
    ];
    query($pdo, $sql, $parameters);
}

function getCommentsByQuestion($pdo, $questions_ID) {
    $sql = 'SELECT * FROM comments WHERE questions_ID = :questions_ID AND status = "approved" ORDER BY created_at ASC';
    $parameters = [':questions_ID' => $questions_ID];
    return query($pdo, $sql, $parameters);
}

function getAllPendingComments($pdo) {
    $sql = 'SELECT c.*, q.questiontext 
            FROM comments c 
            LEFT JOIN questions q ON c.questions_ID = q.id 
            WHERE c.status = "pending" 
            ORDER BY c.created_at DESC';
    return query($pdo, $sql);
}

function getAllApprovedComments($pdo) {
    $sql = 'SELECT c.*, q.questiontext, 
            CASE WHEN c.parent_ID IS NOT NULL THEN "Reply" ELSE "Comment" END as type
            FROM comments c 
            LEFT JOIN questions q ON c.questions_ID = q.id 
            WHERE c.status = "approved" 
            ORDER BY c.created_at DESC';
    return query($pdo, $sql);
}

function approveComment($pdo, $commentId) {
    $sql = 'UPDATE comments SET status = "approved" WHERE id = :id';
    $parameters = [':id' => $commentId];
    query($pdo, $sql, $parameters);
}

function rejectComment($pdo, $commentId) {
    $sql = 'UPDATE comments SET status = "rejected" WHERE id = :id';
    $parameters = [':id' => $commentId];
    query($pdo, $sql, $parameters);
}

function deleteComment($pdo, $commentId) {
    $sql = 'DELETE FROM comments WHERE id = :id';
    $parameters = [':id' => $commentId];
    query($pdo, $sql, $parameters);
}

function getCommentById($pdo, $commentId) {
    $sql = 'SELECT * FROM comments WHERE id = :id';
    $parameters = [':id' => $commentId];
    $result = query($pdo, $sql, $parameters);
    return $result->fetch();
}
function getQuestionDetail($pdo, $questions_ID) {
        $sql = "SELECT q.*, u.username as users_username, u.email as users_email, m.Modulename as module_name
            FROM questions q 
            LEFT JOIN users u ON q.users_id = u.id 
            LEFT JOIN module m ON q.moduleid = m.id 
            WHERE q.id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$questions_ID]);
        return $stmt->fetch();
}

function updateUser($pdo, $id, $username = null, $email = null, $password = null, $role = null) {
    $fields = [];
    $params = [':id' => $id];
    if ($username !== null) {
        $fields[] = 'username = :username';
        $params[':username'] = $username;
    }
    if ($email !== null) {
        $fields[] = 'email = :email';
        $params[':email'] = $email;
    }
    if ($password !== null) {
        $fields[] = 'password = :password';
        $params[':password'] = $password;
    }
    if ($role !== null) {
        $fields[] = 'role = :role';
        $params[':role'] = $role;
    }
    if (empty($fields)) return false;
    $sql = 'UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($params);
}
function getAllUsers($pdo) {
    return query($pdo, 'SELECT * FROM users ORDER BY username');
}
function CreateUser($pdo, $username, $email) {
    // Check if user exists
    $sql = 'SELECT id FROM users WHERE username = :username AND email = :email';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => $username, ':email' => $email]);
    $user = $stmt->fetch();
    if ($user) {
        return $user['id'];
    } else {
        // Create new user with default password and role
        $defaultPassword = password_hash('pass123', PASSWORD_DEFAULT);
        $role = 'user';
        $sqlInsert = 'INSERT INTO users (username, email, password, role, created_at) VALUES (:username, :email, :password, :role, NOW())';
        $stmtInsert = $pdo->prepare($sqlInsert);
        $stmtInsert->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $defaultPassword,
            ':role' => $role
        ]);
        return $pdo->lastInsertId();
    }
}


// PHP mailer
function handleContactSubmission($pdo, $name, $email, $subject, $message) {
    // Include PHPMailer files
    include 'PHPMailer-master/Exception.php';
    include 'PHPMailer-master/PHPMailer.php';
    include 'PHPMailer-master/SMTP.php';
    
    // Save to database
    $created_at = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("INSERT INTO messages (sender_name, sender_email, subject, message, created_at) 
                           VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $subject, $message, $created_at]);

    // Configure PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Configure SMTP for PHPMailer
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'userstudentforum@gmail.com';
        $mail->Password = 'mbiy kcbj wxpc wdju';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configure sender and receiver information
        $mail->setFrom($email, $name);
        $mail->addAddress('nhudthgcs220086@fpt.edu.vn');

        //Email content
        $mail->isHTML(true);
        $mail->Subject = "Contact Form: $subject";
        $mail->Body    = "<strong>Name:</strong> $name <br><strong>Email:</strong> $email <br><strong>Subject:</strong> $subject <br><br><strong>Message:</strong><br> $message";

        //Send email
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        // Nếu có lỗi
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}

?>