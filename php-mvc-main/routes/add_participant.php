<?php
// routes/add_participant.php
// Handle /add_participant?eid=... requests

$eid = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;
$creatorId = isset($_GET['uid']) ? (int)$_GET['uid'] : 0;
$userId = getUseridbyEmail($_SESSION['email']);
if($creatorId == $userId){
    echo "<script>alert('This is your Event');</script>";
    exit;
}

if($eid <= 0)
{
    renderView('404');
    echo "<script>alert('Error: wrong event id');</script>";
    exit;
}

if(!addUserEvent($eid, $userId))
{
    echo "<script>alert('you already joined the event');</script>";
    exit;
}
else
{
    echo "<script>alert('ขอเข้าร่วมสำเร็จ'); location.href='event';</script>";
}



