<?php
// $db_host = "sql204.infinityfree.com";
// $db_user = "if0_40322633";
// $db_pass = "HDm584vG4kZDnt";
// $db_name = "if0_40322633_students";
class DBconfig {
    protected $db_host = "sql204.infinityfree.com";
    protected $db_user = "if0_40322633";
    protected $db_pass = "HDm584vG4kZDnt";
    protected $db_name = "if0_40322633_students";
    protected $con;

    public function __construct()
    {
        $this->con = new mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
    }

    public function check_con(){
        if($this->con->connect_error) return "connection error";
        else return $this->con;
    }

    public function getInfoByUser($user){
        $sql = "SELECT id, gender, phone, email, IPADDR 
                FROM users 
                WHERE name = ? 
                LIMIT 1";

        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $user);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }


}