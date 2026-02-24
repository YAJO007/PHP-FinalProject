<?php
// routes/edit_event.php - Handle event editing (GET and POST)

// Ensure functions are loaded
if (!function_exists('getEventById')) {
    require_once DATABASES_DIR . '/event.php';
}

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Display edit form - GET request
    $eid = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;
    
    if ($eid <= 0) {
        renderView('404');
        exit;
    }
    
    $event = getEventById($eid);
    if (!$event) {
        renderView('404');
        exit;
    }
    
    renderView('edit_event', ['event' => $event]);
    
} elseif ($method === 'POST') {
    // Process form submission - POST request
    $eid = isset($_POST['eid']) ? (int)$_POST['eid'] : 0;
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $detail = isset($_POST['detail']) ? trim($_POST['detail']) : '';
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
    $max_participants = isset($_POST['max_participants']) ? (int)$_POST['max_participants'] : 0;
    
    // Validate input
    if ($eid <= 0 || empty($title) || empty($detail) || empty($start_date) || 
        empty($end_date) || $max_participants <= 0) {
        // Redirect back with error
        header('Location: edit_event?eid=' . $eid . '&error=incomplete');
        exit;
    }
    
    // Convert datetime-local format to MySQL format
    $start_date = str_replace('T', ' ', $start_date) . ':00';
    $end_date = str_replace('T', ' ', $end_date) . ':00';
    
    // Update event in database
    $result = updateEvent($eid, $title, $max_participants, $start_date, $end_date, $detail);
    
    if ($result === true) {
        // Success
        header('Location: detail?eid=' . $eid . '&updated=success');
        exit;
    } else {
        // Database error
        header('Location: edit_event?eid=' . $eid . '&error=db');
        exit;
    }
}

?>
