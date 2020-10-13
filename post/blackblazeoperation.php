<?php

 function generateSessionTokenForBlackBlaze()
{
    $application_key_id = "002c7edb7ccdea80000000001"; // Obtained from your B2 account page
    $application_key = "K002gaGpFe4kAdBvqcGuSkVyVLuVe3Q"; // Obtained from your B2 account page
    $credentials = base64_encode($application_key_id . ":" . $application_key);
    $url = "https://api.backblazeb2.com/b2api/v2/b2_authorize_account";

    $session = curl_init($url);

// Add headers
    $headers = array();
    $headers[] = "Accept: application/json";
    $headers[] = "Authorization: Basic " . $credentials;
    curl_setopt($session, CURLOPT_HTTPHEADER, $headers);  // Add headers

    curl_setopt($session, CURLOPT_HTTPGET, true);  // HTTP GET
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // Receive server response
    $server_output = curl_exec($session);
    curl_close ($session);
    return json_decode($server_output);



}

function  getImageUploadUrl($sessionToken){


    $api_url = $sessionToken->apiUrl; // From b2_authorize_account call
    $auth_token = $sessionToken->authorizationToken; // From b2_authorize_account call
    $bucket_id = 'fc972e1d3ba72c3c7d5e0a18';  // The ID of the bucket you want to upload to

    $session = curl_init($api_url .  "/b2api/v2/b2_get_upload_url");

// Add post fields
    $data = array("bucketId" => $bucket_id);
    $post_fields = json_encode($data);
    curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields);

// Add headers
    $headers = array();
    $headers[] = "Authorization: " . $auth_token;
    curl_setopt($session, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($session, CURLOPT_POST, true); // HTTP POST
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
    $server_output = curl_exec($session); // Let's do this!
    curl_close ($session); // Clean up
    return json_decode($server_output); // Tell me about the rabbits, George!


}


function uploadFiletoBlackBlaze($session,  $fileName, $filePath)
{
    $file_name = $fileName;
    $my_file = $filePath;
    $handle = fopen($my_file, 'r');
    $read_file = fread($handle,filesize($my_file));

    $upload_url = $session->uploadUrl; // Provided by b2_get_upload_url
    $upload_auth_token = $session->authorizationToken; // Provided by b2_get_upload_url
    $bucket_id = $session->bucketId;// The ID of the bucket
    $content_type = "text/plain";
    $sha1_of_file_data = sha1_file($my_file);

    $session = curl_init($upload_url);

// Add read file as post field
    curl_setopt($session, CURLOPT_POSTFIELDS, $read_file);

// Add headers
    $headers = array();
    $headers[] = "Authorization: " . $upload_auth_token;
    $headers[] = "X-Bz-File-Name: " . $file_name;
    $headers[] = "Content-Type: " . $content_type;
    $headers[] = "X-Bz-Content-Sha1: " . $sha1_of_file_data;
    curl_setopt($session, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($session, CURLOPT_POST, true); // HTTP POST
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
    $server_output = curl_exec($session); // Let's do this!
    curl_close ($session); // Clean up
    return json_decode($server_output); // Tell me about the rabbits, George!
//
}


function getAllFiles($sessionToken)
{
    $api_url = $sessionToken->apiUrl; // From b2_authorize_account call
    $auth_token = $sessionToken->authorizationToken; // From b2_authorize_account call
    $bucket_id = 'fc972e1d3ba72c3c7d5e0a18';  // The ID of the bucket you want to upload to

    $session = curl_init($api_url .  "/b2api/v2/b2_list_file_names");

// Add post fields
    $data = array("bucketId" => $bucket_id);
    $post_fields = json_encode($data);
    curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields);

// Add headers
    $headers = array();
    $headers[] = "Authorization: " . $auth_token;
    curl_setopt($session, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($session, CURLOPT_POST, true); // HTTP POST
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
    $server_output = curl_exec($session); // Let's do this!
    curl_close ($session); // Clean up
    return  json_decode($server_output); // Tell me about the rabbits, George!

}




?>
