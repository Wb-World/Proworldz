<?php

include_once 'api/dbconf.php';
$db = new DBconfig();
$c = $db->check_con();

echo $db->upload_tasks('PWZ-210','Print Hello World');