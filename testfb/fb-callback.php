<?php
session_start();
require_once __DIR__ . '/fb/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([  
  'app_id' => '1531200220503832',  
  'app_secret' => '57eb83e55a6869bba787122fa75a8048',  
  'default_graph_version' => 'v2.5',  
  ]);

$permissions = ['user_photos']; // Optional permissions
$helper = $fb->getRedirectLoginHelper();
$accessToken = $helper->getAccessToken()->getValue();

$photos = $fb->get('/me/albums?limit=20', $accessToken)->getGraphEdge()->asArray();
var_dump($accessToken);
echo "<pre>";
print_r($photos);
echo "</pre>";

?>