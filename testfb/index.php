<?php
session_start();
require_once __DIR__ . '/fb/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
    'app_id' => '1531200220503832',
    'app_secret' => '57eb83e55a6869bba787122fa75a8048',
    'default_graph_version' => 'v2.4',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['user_photos'];
$loginUrl = $helper->getLoginUrl('http://madinaoilco.com/testfb/fb-callback.php',$permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';