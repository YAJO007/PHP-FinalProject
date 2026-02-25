<?php
// routes/edit_profile.php - Handle profile editing (GET and POST)

// Ensure functions are loaded
if (!function_exists('getUserByEmail')) {
    require_once DATABASES_DIR . '/user.php';
}

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit();
}

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Display edit form - GET request
    $email = $_SESSION['email'];
    $result = getUserByEmail($email);
    
    if ($result->num_rows !== 1) {
        renderView('404');
        exit;
    }
    
    $user = $result->fetch_assoc();
    renderView('edit_profile', ['user' => $user]);
    
} elseif ($method === 'POST') {
    // Process form submission - POST request
    $email = $_SESSION['email'];
    $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $phone_number = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : '';
    $date_of_birth = isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $congenital_disease = isset($_POST['congenital_disease']) ? trim($_POST['congenital_disease']) : '';
    
    // Validate input
    if (empty($first_name) || empty($last_name) || empty($phone_number) || 
        empty($date_of_birth) || empty($gender)) {
        // Redirect back with error
        header('Location: edit_profile?error=incomplete');
        exit;
    }
    
    // Update user profile in database
    $result = updateUserProfile($email, $first_name, $last_name, $phone_number, $date_of_birth, $gender, $congenital_disease);
    
    if ($result === true) {
        // Success - redirect to profile page
        header('Location: profile?success=updated');
        exit;
    } else {
        // Error - redirect back with error message
        header('Location: edit_profile?error=' . urlencode($result));
        exit;
    }
}
