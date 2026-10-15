<?php
// index.php
// Main page - Application form and listing

require_once __DIR__ . '/includes/Application.php';

$app = new Application();
$message = '';
$messageType = '';
$editData = null;
$isEditing = false;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $data = [
                    'first_name' => trim($_POST['first_name']),
                    'last_name' => trim($_POST['last_name']),
                    'email' => trim($_POST['email']),
                    'phone' => trim($_POST['phone']),
                    'position_applied' => trim($_POST['position_applied']),
                    'years_experience' => (int)$_POST['years_experience'],
                    'skills' => trim($_POST['skills']),
                    'expected_salary' => $_POST['expected_salary'] ? (float)$_POST['expected_salary'] : null,
                ];
                
                if ($app->create($data)) {
                    $message = 'Application submitted successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Failed to submit application.';
                    $messageType = 'error';
                }
                break;
                
            case 'update':
                $id = (int)$_POST['id'];
                $data = [
                    'first_name' => trim($_POST['first_name']),
                    'last_name' => trim($_POST['last_name']),
                    'email' => trim($_POST['email']),
                    'phone' => trim($_POST['phone']),
                    'position_applied' => trim($_POST['position_applied']),
                    'years_experience' => (int)$_POST['years_experience'],
                    'skills' => trim($_POST['skills']),
                    'expected_salary' => $_POST['expected_salary'] ? (float)$_POST['expected_salary'] : null,
                ];
                
                if ($app->update($id, $data)) {
                    $message = 'Application updated successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Failed to update application.';
                    $messageType = 'error';
                }
                break;
                
            case 'delete':
                $id = (int)$_POST['id'];
                if ($app->delete($id)) {
                    $message = 'Application deleted successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Failed to delete application.';
                    $messageType = 'error';
                }
                break;
                
            case 'edit':
                $id = (int)$_POST['id'];
                $editData = $app->readOne($id);
                if ($editData) {
                    $isEditing = true;
                }
                break;
        }
    }
}

// Handle edit via GET
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $editData = $app->readOne($id);
    if ($editData) {
        $isEditing = true;
    }
}

// Get all applications
$applications = $app->readAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application System - Software Engineer</title>
</head>
<body>
    <div class="container">
        <h1>Job Application System</h1>
        <p>Dream Job: Software Engineer</p>
        
        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <!-- Application Form -->
        <div class="form-container">
            <h2><?php echo $isEditing ? 'Edit Application' : 'Submit New Application'; ?></h2>
            <form method="POST" action="">
                <input type="hidden" name="action" value="<?php echo $isEditing ? 'update' : 'create'; ?>">
                <?php if ($isEditing): ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($editData['id']); ?>">
                <?php endif; ?>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name *</label>
                        <input type="text" name="first_name" required value="<?php echo $isEditing ? htmlspecialchars($editData['first_name']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Last Name *</label>
                        <input type="text" name="last_name" required value="<?php echo $isEditing ? htmlspecialchars($editData['last_name']) : ''; ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" required value="<?php echo $isEditing ? htmlspecialchars($editData['email']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" value="<?php echo $isEditing ? htmlspecialchars($editData['phone']) : ''; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Position Applied For *</label>
                    <select name="position_applied" required>
                        <option value="">Select Position</option>
                        <option value="Junior Software Engineer" <?php echo ($isEditing && $editData['position_applied'] === 'Junior Software Engineer') ? 'selected' : ''; ?>>Junior Software Engineer</option>
                        <option value="Software Engineer" <?php echo ($isEditing && $editData['position_applied'] === 'Software Engineer') ? 'selected' : ''; ?>>Software Engineer</option>
                        <option value="Senior Software Engineer" <?php echo ($isEditing && $editData['position_applied'] === 'Senior Software Engineer') ? 'selected' : ''; ?>>Senior Software Engineer</option>
                        <option value="Lead Software Engineer" <?php echo ($isEditing && $editData['position_applied'] === 'Lead Software Engineer') ? 'selected' : ''; ?>>Lead Software Engineer</option>
                        <option value="Full Stack Developer" <?php echo ($isEditing && $editData['position_applied'] === 'Full Stack Developer') ? 'selected' : ''; ?>>Full Stack Developer</option>
                        <option value="Backend Developer" <?php echo ($isEditing && $editData['position_applied'] === 'Backend Developer') ? 'selected' : ''; ?>>Backend Developer</option>
                        <option value="Frontend Developer" <?php echo ($isEditing && $editData['position_applied'] === 'Frontend Developer') ? 'selected' : ''; ?>>Frontend Developer</option>
                        <option value="DevOps Engineer" <?php echo ($isEditing && $editData['position_applied'] === 'DevOps Engineer') ? 'selected' : ''; ?>>DevOps Engineer</option>
                    </select>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Years of Experience *</label>
                        <input type="number" name="years_experience" min="0" max="50" required value="<?php echo $isEditing ? htmlspecialchars($editData['years_experience']) : '0'; ?>">
                    </div>
                    <div class="form-group">
                        <label>Expected Salary</label>
                        <input type="number" name="expected_salary" step="0.01" min="0" value="<?php echo $isEditing ? htmlspecialchars($editData['expected_salary']) : ''; ?>" placeholder="e.g., 80000.00">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Skills & Technologies</label>
                    <textarea name="skills" placeholder="e.g., PHP, MySQL, JavaScript, React, Docker, Git, REST APIs, AWS"><?php echo $isEditing ? htmlspecialchars($editData['skills']) : ''; ?></textarea>
                </div>
                
                <?php if ($isEditing): ?>
                    <button type="submit" class="btn">Update Application</button>
                    <a href="index.php" class="btn">Cancel</a>
                <?php else: ?>
                    <button type="submit" class="btn">Submit Application</button>
                <?php endif; ?>
            </form>
        </div>
        
        <!-- Applications List -->
        <div class="table-container">
            <h2>All Applications (<?php echo count($applications); ?>)</h2>
            <?php if (empty($applications)): ?>
                <p>No applications submitted yet.</p>
            <?php else: ?>
                <table border="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Position</th>
                            <th>Experience</th>
                            <th>Skills</th>
                            <th>Expected Salary</th>
                            <th>Date Added</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $application): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($application['id']); ?></td>
                                <td><?php echo htmlspecialchars($application['first_name'] . ' ' . $application['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($application['email']); ?></td>
                                <td><?php echo htmlspecialchars($application['phone'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($application['position_applied']); ?></td>
                                <td><?php echo htmlspecialchars($application['years_experience']); ?> years</td>
                                <td><?php echo htmlspecialchars($application['skills'] ?? '-'); ?></td>
                                <td><?php echo $application['expected_salary'] ? '$' . number_format($application['expected_salary'], 2) : '-'; ?></td>
                                <td><?php echo date('Y-m-d H:i', strtotime($application['date_added'])); ?></td>
                                <td>
                                    <a href="index.php?edit=<?php echo $application['id']; ?>">Edit</a>
                                    <form method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $application['id']; ?>">
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this application?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
