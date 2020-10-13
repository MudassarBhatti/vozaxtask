<?php
include ('blackblazeoperation.php');
$folder_name = 'upload/';
$temp_file = $_FILES['file']['tmp_name'];
$location = $folder_name . $_FILES['file']['name'];
move_uploaded_file($temp_file, $location);

$sessionToken = generateSessionTokenForBlackBlaze();
$imageUploadurl = getImageUploadUrl($sessionToken);
$responce   = uploadFiletoBlackBlaze($imageUploadurl,$_FILES['file']['name'],$location);


echo $responce;




?>