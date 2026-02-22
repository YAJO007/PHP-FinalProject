<?php
// ฟังก์ชันสำหรับดึงข้อมูลนักเรียนจากฐานข้อมูล
function getuser(): mysqli_result
{
    global $conn;
    $sql = 'select * from user';
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

function addStudent($username, $first_name, $last_name, $email, $password, $birthdate, $gender, $phone, $congenital)
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

function checklogin($email, $password): bool
{
    global $conn;
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        return password_verify($password, $user['password']);
    } else {
        return false;
    }
}
