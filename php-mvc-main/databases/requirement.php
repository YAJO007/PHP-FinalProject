<?php

function addReq(int $eid, string $req): bool|string
{
    global $conn;
    $sql = "INSERT INTO requirement (eid, requirement) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return 'DB prepare failed: ' . $conn->error;
    }

    $stmt->bind_param("is", $eid, $req);
    return $stmt->execute() ? true : ('DB execute failed: ' . $stmt->error);
}

function getReqs(int $eid): mysqli_result
{
    global $conn;
    return $conn->query("SELECT * FROM requirement WHERE eid = $eid");
}