<?php

function addRequirement(int $eid, string $requirement)
{
    global $conn;
    $sql = "INSERT INTO requirement (eid, requirement) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return 'DB prepare failed: ' . $conn->error;
    }

    $stmt->bind_param("is", $eid, $requirement);

    if (!$stmt->execute()) {
        $err = $stmt->error;
        $stmt->close();
        return 'DB execute failed: ' . $err;
    }

    $stmt->close();
    return true;
}

function getRequirementsByEventId(int $event_id): mysqli_result
{
    global $conn;
    return $conn->query("SELECT * FROM requirement WHERE eid = $event_id");
}