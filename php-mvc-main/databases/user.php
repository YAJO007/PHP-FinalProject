<?php

function getUsers(): mysqli_result
{
    global $conn;
    return $conn->query("SELECT * FROM user");
}

function addUser(
    string $user, 
    string $fname, 
    string $lname, 
    string $email, 
    string $pwd, 
    string $dob, 
    string $gen, 
    string $phone, 
    string $disease
): bool|string {
    global $conn;

    $sql = "INSERT INTO user 
            (user_name, first_name, last_name, email, password, date_of_birth, gender, phone_number, congenital_disease) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $user, $fname, $lname, $email, $pwd, $dob, $gen, $phone, $disease);

    try {
        $stmt->execute();
        $stmt->close();
        return true;
    } catch (mysqli_sql_exception $e) {
        $stmt->close();
        if ($e->getCode() == 1062) {
            return "ข้อมูลซ้ำ: มีอีเมล ชื่อผู้ใช้ หรือเบอร์โทรศัพท์นี้ในระบบแล้ว";
        }
        return "เกิดข้อผิดพลาดจากระบบ: " . $e->getMessage();
    }
}

function checkLogin(string $email): bool
{
    global $conn;
    $sql = "SELECT 1 FROM user WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = ($stmt->get_result()->num_rows > 0);
    $stmt->close();
    return $res;
}

function getUserByEmail(string $email): mysqli_result
{
    global $conn;
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result();
}

function getUidByEmail(string $email): ?int
{
    global $conn;
    $sql = "SELECT uid FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $row ? (int)$row['uid'] : null;
}

function updateUser(
    string $email,
    string $fname,
    string $lname,
    string $phone,
    string $dob,
    string $gen,
    string $disease
): bool|string {
    global $conn;

    $sql = "UPDATE user SET first_name = ?, last_name = ?, phone_number = ?, 
            date_of_birth = ?, gender = ?, congenital_disease = ? WHERE email = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $fname, $lname, $phone, $dob, $gen, $disease, $email);

    try {
        $stmt->execute();
        $stmt->close();
        return true;
    } catch (mysqli_sql_exception $e) {
        $stmt->close();
        return "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
}

function getUserById(int $uid): ?array
{
    global $conn;

    $sql = "SELECT * FROM user WHERE uid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $uid);
    $stmt->execute();

    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $row ?: null;
}
