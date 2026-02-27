<?php

function getAddr(int $eid): mysqli_result
{
    global $conn;
    $sql = "SELECT * FROM address WHERE eid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eid);
    $stmt->execute();
    return $stmt->get_result();
}

function addAddr(int $eid, string $prov, string $dist, string $line): bool|string
{
    global $conn;
    $sql = "INSERT INTO address (eid, province, district, address_line) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return 'DB prepare failed: ' . $conn->error;
    }

    $stmt->bind_param("isss", $eid, $prov, $dist, $line);
    return $stmt->execute() ? true : ('DB execute failed: ' . $stmt->error);
}
