<?php

if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $eventId = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;

    if ($eventId <= 0) {
        renderView('404');
        exit;
    }

    $event = getEventById($eventId);
    if (!$event) {
        renderView('404');
        exit;
    }

    $event['images'] = getImgs($eventId);
    renderView('edit_event', ['event' => $event]);

} elseif ($method === 'POST') {
    global $conn;
    
    $eventId = isset($_POST['eid']) ? (int)$_POST['eid'] : 0;
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if (isset($_POST['delete_cover_image']) && !empty($_POST['delete_cover_image'])) {
        $imageToDelete = $_POST['delete_cover_image'];
        $filePath = __DIR__ . '/../public/img/' . $imageToDelete;
        
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        
        $stmt = $conn->prepare("DELETE FROM event_img WHERE eid = ? AND image_path = ?");
        $stmt->bind_param("is", $eventId, $imageToDelete);
        $stmt->execute();
        $stmt->close();
    }

    if (isset($_POST['delete_additional_images']) && is_array($_POST['delete_additional_images'])) {
        foreach ($_POST['delete_additional_images'] as $imageToDelete) {
            if (!empty($imageToDelete)) {
                $filePath = __DIR__ . '/../public/img/' . $imageToDelete;
                
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                
                $stmt = $conn->prepare("DELETE FROM event_img WHERE eid = ? AND image_path = ?");
                $stmt->bind_param("is", $eventId, $imageToDelete);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
    
    if (($action === 'delete_cover_image' || $action === 'delete_additional_images') && !isset($_POST['title'])) {
        header('Location: edit_event?eid=' . $eventId . '&success=1');
        exit;
    }

    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $detail = isset($_POST['detail']) ? trim($_POST['detail']) : '';
    $startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';
    $maxParticipants = isset($_POST['max_participants']) ? (int)$_POST['max_participants'] : 0;

    if ($eventId <= 0 || empty($title) || empty($detail) || empty($startDate) || empty($endDate) || $maxParticipants <= 0) {
        header('Location: edit_event?eid=' . $eventId . '&error=incomplete');
        exit;
    }

    $startDate = str_replace('T', ' ', $startDate) . ':00';
    $endDate = str_replace('T', ' ', $endDate) . ':00';

    $result = updateEvent($eventId, $title, $maxParticipants, $startDate, $endDate, $detail);

    if ($result !== true) {
        header('Location: edit_event?eid=' . $eventId . '&err=1');
        exit;
    }

    $imageDir = __DIR__ . '/../public/img/';
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $maxFileSize = 5 * 1024 * 1024;

    if (!empty($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['cover_image']['tmp_name'];
        $fileName = $_FILES['cover_image']['name'];
        
        if (file_exists($tmpName) && is_uploaded_file($tmpName)) {
            $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            
            if (in_array($extension, $allowedExtensions)) {
                $fileSize = $_FILES['cover_image']['size'];
                if ($fileSize <= $maxFileSize) {
                    $newFileName = uniqid('event_', true) . '.' . $extension;
                    
                    if (move_uploaded_file($tmpName, $imageDir . $newFileName)) {
                        addImg($eventId, $newFileName);
                    }
                }
            }
        }
    }

    if (!empty($_FILES['additional_images']) && is_array($_FILES['additional_images']['name'])) {
        foreach ($_FILES['additional_images']['name'] as $key => $name) {
            if (empty($name) || $_FILES['additional_images']['error'][$key] !== UPLOAD_ERR_OK) {
                continue;
            }

            $tmpName = $_FILES['additional_images']['tmp_name'][$key];
            
            if (file_exists($tmpName) && is_uploaded_file($tmpName)) {
                $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                
                if (in_array($extension, $allowedExtensions)) {
                    $fileSize = $_FILES['additional_images']['size'][$key];
                    if ($fileSize <= $maxFileSize) {
                        $newFileName = uniqid('event_', true) . '.' . $extension;
                        
                        if (move_uploaded_file($tmpName, $imageDir . $newFileName)) {
                            addImg($eventId, $newFileName);
                        }
                    }
                }
            }
        }
    }

    header('Location: manage_event?eid=' . $eventId . '&updated=1');
    exit;
}