<?php
// $db_host = "sql204.infinityfree.com";
// $db_user = "if0_40322633";
// $db_pass = "HDm584vG4kZDnt";
// $db_name = "if0_40322633_students";
class DBconfig {
    // protected $db_host = "sql204.infinityfree.com";
    // protected $db_user = "if0_40322633";
    // protected $db_pass = "HDm584vG4kZDnt";
    // protected $db_name = "if0_40322633_students";

    protected $db_host = "localhost";
    protected $db_user = "root";
    protected $db_pass = "mypass123";
    protected $db_name = "test";
    protected $con;

    public function __construct()
    {
        $this->con = new mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
    }

    public function check_con(){
        if($this->con->connect_error) return "connection error";
        else return $this->con;
    }

    public function getUserInfo($userId, $requestedFields = []) {

    if (empty($requestedFields)) {
        return null;
    }

    $allowedFields = [
        'id', 'name', 'gender', 'phone', 'email',
        'IPADDR', 'eagle_coins', 'assignments', 'course'
    ];

    $validFields = array_intersect($requestedFields, $allowedFields);

    if (empty($validFields)) {
        return null;
    }

    $columns = implode(", ", $validFields);

    // 🔥 IF userId == 'all' → no WHERE clause
    if ($userId === 'all') {
        $sql = "SELECT $columns FROM users";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // 🔥 normal single-user query
    $sql = "SELECT $columns FROM users WHERE id = ? LIMIT 1";
    $stmt = $this->con->prepare($sql);
    $stmt->bind_param("s", $userId);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}

}