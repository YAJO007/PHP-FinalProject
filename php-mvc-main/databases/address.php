<?php

function getAddressByEventId($event_id): mysqli_result
{
    global $conn;
    return $conn->query("SELECT * FROM address WHERE eid = $event_id");
} 

function addAddress($event_id, $province, $district, $address_line)
{
    global $conn;
    $sql = "INSERT INTO address (eid, province, district, Address_line) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return 'DB prepare failed: ' . $conn->error;
    }

    $stmt->bind_param("isss", $event_id, $province, $district, $address_line);

    if (!$stmt->execute()) {
        $err = $stmt->error;
        $stmt->close();
        return 'DB execute failed: ' . $err;
    }

    $stmt->close();
    return true;
}