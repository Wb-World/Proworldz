<?php

// echo random_int(100000,999999);
$a = file_get_contents('https://phoneintelligence.abstractapi.com/v1/?api_key=99007ad35f2c49e7a6039487b7e3b3ce&phone=919944994778');
$d = json_decode($a,true);
print_r($d);
// print_r($d).'<br>';
// echo $d['email_deliverability']['status'];
// echo $d['email_deliverability']['status_detail'];
// echo $d['email_deliverability']['is_format_valid'];
// echo $d['email_sender']['email_provider_name'];
// echo $d['email_sender']['organization_name'];
// echo $d['email_deliverability']['status_detatil'].;
//  [status] => deliverable [status_detail] => valid_email [is_format_valid]