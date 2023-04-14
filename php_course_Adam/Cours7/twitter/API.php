<?php
require('db.php');

$endpoints = [ // routage  variable  serveur  fc bdd called  inweb front  =)  return json
    "userposts" => function() {
        echo json_encode(getUserPosts(0));
    }, 
    "allposts" => function() {
        echo json_encode(getAllPosts());
    }
]; 

$apiR = isset($_GET['api']) ? $_GET['api'] : 'no';

if (!isset($endpoints[$apiR])){ // test is there endpoints 
    http_response_code(404);
    echo json_encode([ "err"=>"endpoint_does_not_exits"]);
    exit;
}

$endpoint  = $endpoints[$apiR];
$endpoint();