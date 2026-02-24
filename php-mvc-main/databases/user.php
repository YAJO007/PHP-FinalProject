<?php
// ฟังก์ชันสำหรับดึงข้อมูลนักเรียนจากฐานข้อมูล
function getuser(): mysqli_result
{
    global $conn;
    $sql = "SELECT * FROM user";
    return $conn->query($sql);
}

function adduser($username, $first_name, $last_name, $email, $password, $birthdate, $gender, $phone, $congenital)
{
    global $conn;
    $sql = "INSERT INTO user 
            (user_name, first_name, last_name, email, password, date_of_birth, gender, phone_number, congenital_disease) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $username, $first_name, $last_name, $email, $password, $birthdate, $gender, $phone, $congenital);
    
    try {
        // ลองสั่งบันทึกข้อมูล
        $stmt->execute();
        $stmt->close();
        return true; // สำเร็จ คืนค่า true
        
    } catch (mysqli_sql_exception $e) {
        $stmt->close(); 
        if ($e->getCode() == 1062) {
            return "ข้อมูลซ้ำ: มีอีเมล ชื่อผู้ใช้ หรือเบอร์โทรศัพท์นี้ในระบบแล้ว";
        } else {
            return "เกิดข้อผิดพลาดจากระบบ: " . $e->getMessage();
        }
    }
}

function checklogin($email): bool
{
    global $conn;
    $sql = "SELECT 1 FROM user WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = ($result->num_rows > 0);
    $stmt->close();
    return $exists;
}
function getUserByEmail(string $email): mysqli_result
{
    global $conn;
    $sql  = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result();
}

function getUseridbyEmail(string $email): ?int
{
    global $conn;

    $sql = "SELECT uid FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return (int)$row['uid'];
    }

    return null;
}

function updateUserProfile(string $email, string $first_name, string $last_name, 
                          string $phone_number, string $date_of_birth, 
                          string $gender, string $congenital_disease)
{
    global $conn;
    
    $sql = "UPDATE user SET 
            first_name = ?, 
            last_name = ?, 
            phone_number = ?, 
            date_of_birth = ?, 
            gender = ?, 
            congenital_disease = ? 
            WHERE email = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $first_name, $last_name, $phone_number, 
                      $date_of_birth, $gender, $congenital_disease, $email);
    
    try {
        $stmt->execute();
        $stmt->close();
        return true; // สำเร็จ
    } catch (mysqli_sql_exception $e) {
        $stmt->close();
        return "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
}