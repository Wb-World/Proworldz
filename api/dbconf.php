<?php
// $db_host = "sql204.infinityfree.com";
// $db_user = "if0_40322633";
// $db_pass = "HDm584vG4kZDnt";
// $db_name = "if0_40322633_students";
class DBconfig {
    // protected $db_host = "localhost";
    // protected $db_user = "root";
    // protected $db_pass = "mypass123";
    // protected $db_name = "test";
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

    // Get ID by Name
    public function getIdbyName($name){
        $sql = "SELECT id FROM users WHERE name = ? LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['id'] : null;
    }

    // Get Name by ID
    public function getNamebyId($id){
        $sql = "SELECT name FROM users WHERE id = ? LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['name'] : null;
    }

    // Get Eagle Coins by ID
    public function getEagleCoinsbyId($id){
        $sql = "SELECT eagle_coins FROM users WHERE id = ? LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['eagle_coins'] : null;
    }

    // Get Gender by ID
    public function getGenderbyId($id){
        $sql = "SELECT gender FROM users WHERE id = ? LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['gender'] : null;
    }

    // Get Phone by ID
    public function getPhonebyId($id){
        $sql = "SELECT phone FROM users WHERE id = ? LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['phone'] : null;
    }

    // Get Email by ID
    public function getEmailbyId($id){
        $sql = "SELECT email FROM users WHERE id = ? LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['email'] : null;
    }

    // Get IP Address by ID
    public function getIPAddressbyId($id){
        $sql = "SELECT IPADDR FROM users WHERE id = ? LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['IPADDR'] : null;
    }

    // Get Assignments by ID
    public function getAssignmentsbyId($id){
        $sql = "SELECT assignments FROM users WHERE id = ? LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['assignments'] : null;
    }

    // Get Course by ID
    public function getCoursebyId($id){
        $sql = "SELECT course FROM users WHERE id = ? LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['course'] : null;
    }

    // Get All Users Data
    public function getAllUsersData($fields = []){
        if (empty($fields)) {
            $fields = ['id', 'name', 'gender', 'phone', 'email', 'IPADDR', 'eagle_coins', 'assignments', 'course'];
        }
        
        $allowedFields = [
            'id', 'name', 'gender', 'phone', 'email',
            'IPADDR', 'eagle_coins', 'assignments', 'course'
        ];
        
        $validFields = array_intersect($fields, $allowedFields);
        
        if (empty($validFields)) {
            return null;
        }
        
        $columns = implode(", ", $validFields);
        $sql = "SELECT $columns FROM users";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Generic method to get any single field by ID
    public function getFieldbyId($id, $field){
        $allowedFields = [
            'id', 'name', 'gender', 'phone', 'email',
            'IPADDR', 'eagle_coins', 'assignments', 'course'
        ];
        
        if (!in_array($field, $allowedFields)) {
            return null;
        }
        
        $sql = "SELECT $field FROM users WHERE id = ? LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result[$field] : null;
    }

    // Original getUserInfo method (kept for backward compatibility)
    public function getUserInfo($userId, $requestedFields = []) {
        if (empty($requestedFields)) {
            return null;
        }

        $allowedFields = [
            'id', 'name', 'gender', 'phone', 'email',
            'IPADDR', 'eagle_coins', 'assignments', 'course','assigns_complete','device'
        ];

        $validFields = array_intersect($requestedFields, $allowedFields);

        if (empty($validFields)) {
            return null;
        }

        $columns = implode(", ", $validFields);

        if ($userId === 'all') {
            $sql = "SELECT $columns FROM users";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        $sql = "SELECT $columns FROM users WHERE id = ? LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $userId);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // Add this method to your DBconfig class
    public function updateUserEagleCoins($userId, $newCoins) {
        $sql = "UPDATE users SET eagle_coins = ? WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        
        // Check if it's a decimal number and bind accordingly
        if (is_float($newCoins)) {
            $stmt->bind_param("is", $newCoins, $userId); // 'd' for double/float
        } else {
            $stmt->bind_param("is", $newCoins, $userId); // 'i' for integer
        }
        
        $result = $stmt->execute();
        
        // Check if update was successful
        if ($result && $stmt->affected_rows > 0) {
            return true;
        } else {
            // Log error for debugging
            error_log("Failed to update eagle coins for user ID: $userId");
            return false;
        }
    }

    // Alternatively, if you want a function that adds to existing coins:
    public function addEagleCoins($userId, $amountToAdd) {
        // Get current coins first
        $currentCoins = $this->getEagleCoinsbyId($userId);
        if ($currentCoins === null) {
            return false;
        }
        
        // Calculate new total
        $newCoins = $currentCoins + $amountToAdd;
        
        // Update in database
        return $this->updateUserEagleCoins($userId, $newCoins);
    }

    // Simple increment function (for 0.50 coins)
    public function incrementEagleCoins($userId) {
        return $this->addEagleCoins($userId, 0.50);
    }

    public function upload_data($column_name, $value, $id) {
        if (empty($column_name) || $value === null || empty($id)) {
            return false;
        }
        
        $allowedFields = [
            'name', 'gender', 'phone', 'email', 
            'IPADDR', 'eagle_coins', 'assignments', 'course', 'assigns_complete','device'
        ];
        
        if (!in_array($column_name, $allowedFields)) {
            return false;
        }
        
        $sql = "UPDATE users SET $column_name = ? WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        
        if (!$stmt) {
            return false;
        }
        
        $type = '';
        if (is_int($value)) {
            $type = 'i';
        } elseif (is_float($value)) {
            $type = 'd';
        } else {
            $type = 's';
        }
        
        $stmt->bind_param($type . 's', $value, $id);
        
        return $stmt->execute();
    }

    public function upload_waiting_assign($userId, $assignmentTitle) {
        if (empty($userId) || empty($assignmentTitle)) {
            return false;
        }
        
        $existing = $this->get_waiting_assign($userId);
        $existing[] = $assignmentTitle;
        $jsonData = json_encode($existing);
        
        $sql = "UPDATE users SET waiting_assigns = ? WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        
        if (!$stmt) {
            return false;
        }
        
        $stmt->bind_param("ss", $jsonData, $userId);
        return $stmt->execute();
    }

    public function get_waiting_assign($userId) {
        if (empty($userId)) {
            return [];
        }
        
        $sql = "SELECT waiting_assigns FROM users WHERE id = ? LIMIT 1";
        $stmt = $this->con->prepare($sql);
        
        if (!$stmt) {
            return [];
        }
        
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if (!$row || empty($row['waiting_assigns'])) {
            return [];
        }
        
        $data = json_decode($row['waiting_assigns'], true);
        return is_array($data) ? $data : [];
    }

    public function upload_tasks($userId, $taskNameToRemove) {
        if(empty($userId) || empty($taskNameToRemove)) return false;
        
        // First, get the current tasks
        $sql = "SELECT tasks FROM tasksdb WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        if(!$stmt) return false;
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $res = $stmt->get_result();
        $data = $res->fetch_assoc();
        $stmt->close();
        
        // If no data found, return false
        if(!$data || !isset($data['tasks']) || empty($data['tasks'])) {
            return false;
        }
        
        // Decode the JSON data
        $tasksArray = json_decode($data['tasks'], true);
        
        if(!is_array($tasksArray)) {
            return false;
        }
        
        // Find and remove the specified task by name (exact match)
        $modified = false;
        $newTasksArray = [];
        
        foreach($tasksArray as $task) {
            // If the task itself is just a string (not an array), compare directly
            if(is_string($task) && $task === $taskNameToRemove) {
                $modified = true;
                continue; // Skip this task (remove it)
            }
            // If the task is an array with a 'title' field
            elseif(is_array($task) && isset($task['title']) && $task['title'] === $taskNameToRemove) {
                $modified = true;
                continue; // Skip this task (remove it)
            }
            // If the task is an array with a 'name' field  
            elseif(is_array($task) && isset($task['name']) && $task['name'] === $taskNameToRemove) {
                $modified = true;
                continue; // Skip this task (remove it)
            }
            // Keep all other tasks
            $newTasksArray[] = $task;
        }
        
        // If no task was found to remove, return false
        if(!$modified) {
            return false;
        }
        
        // Encode the modified array back to JSON
        $newTasksJson = json_encode($newTasksArray);
        
        // Update the database with the modified tasks
        $updateSql = "UPDATE tasksdb SET tasks = ? WHERE id = ?";
        $updateStmt = $this->con->prepare($updateSql);
        if(!$updateStmt) return false;
        
        $updateStmt->bind_param("ss", $newTasksJson, $userId);
        $result = $updateStmt->execute();
        $updateStmt->close();
        
        return $result;
    }

    public function get_tasks($userId, $all) {
        if(empty($userId)) return $all === 'all' ? [] : ($all === 'total' || $all === 'eagle_coins' ? 0 : []);
        
        if($all === 'all') {
            $sql = "SELECT id, tasks, completed, total, eagle_coins FROM tasksdb WHERE id = ?";
            $stmt = $this->con->prepare($sql);
            if(!$stmt) return [];
            
            $stmt->bind_param("s", $userId);
            $stmt->execute();
            $res = $stmt->get_result();
            $data = $res->fetch_assoc();
            $stmt->close();
            
            return $data ?: [];
        }
        
        $column = $all;
        if(!in_array($all, ['tasks', 'completed', 'total', 'eagle_coins'])) {
            $column = 'tasks';
        }
        
        $sql = "SELECT $column FROM tasksdb WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        if(!$stmt) return $all === 'total' || $all === 'eagle_coins' ? 0 : [];
        
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $res = $stmt->get_result();
        $data = $res->fetch_assoc();
        $stmt->close();
        
        if(!$data || !isset($data[$column])) {
            return $all === 'total' || $all === 'eagle_coins' ? 0 : [];
        }
        
        if($all === 'total' || $all === 'eagle_coins') {
            return (int)$data[$column];
        }
        
        $result = json_decode($data[$column], true);
        return is_array($result) ? $result : [];
    }

}