<?php


include ('blackblazeoperation.php');
   $sessionToken = generateSessionTokenForBlackBlaze();
   $response  = getAllFiles($sessionToken);
   echo json_encode($response);





?>