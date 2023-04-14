<?php
session_start();

$db= new PDO('mysql:host=localhost;dbname=tweetlike', 'root', '');

$secret = 'gzyeflgsm674*&';
$issuer = 'localhost';

$routes=[

    "/login"=>function(){
        $username=$_POST['login'];

        $password=$_POST['password'];

        $stmt= $db->query("select * from user WHERE username = :username AND password=:password");
        $stmt->execute();
        $ids =$stmt -> fetchAll();
        if(count($ids)===1){
            
            $userId = $ids[0];
            $expiration = time() + 3600;
            $issuedAt= time();

            $data=[
                'id'=>$userId,
                'exp'=>$expiration->getTimestamp(),
                'iat'=>$issuedAt->getTimestamp(),
                'iss'=>$issuer
            ];
            

            $token = JWT::encode(
                $data,
                $secretKey,
                'HS512'
            );
            http_response_code(200);
            return $token;
        }

    }
    "/createPost"=> function(){
        
        if(isset($_POST['message'] && isset($_SERVER['HTTP_AUTHORIZATION']))){
            $jwt=$_SERVER['HTTP_AUTHORIZATION']
            $token = JWT::decode($jwt, $secretKey, ['HS512']);
            $now = new DateTimeImmutable();
            $serverName = "localhost";

            if ($token->iss !== $serverName ||
                $token->exp < $now->getTimestamp()||
                $token->iat > $now->getTimestamp() ||)
            {
                header('HTTP/1.1 401 Unauthorized');
                exit;
            }
            $message=$_POST['message'];
            $userId=$token->id;
            $stmt= $db->prepare("insert into posts (author_id,created_at,content) values (:id,NOW(),:message)");
            $stmt->execute(['id'=>$userId, 'message'=>$message]);
            http_response_code(200);
        }
        else{
            http_response_code(500);
        }
    },
    "/deletePost/([0-9]+)"=> function($id){

            $stmt= $db->prepare("delete posts where id=:id");
            $stmt->execute(['id'=>$id]);
            http_response_code(200);
        

    },
    "/showLastPosts"=> function(){
        
        
            $stmt= $db->prepare("SELECT * FROM posts ORDER BY created_at DESC LIMIT 1, 10");
            $stmt->execute();
            $posts=$stmt->fetchAll();
            $data=json_encode($posts);
            http_response_code(200);
            return $data;
        
        

    },
    "/getPost/([0-9]+)"=> function(){

        $stmt= $db->prepare("SELECT * FROM posts WHERE id=:id");
        $stmt->execute(['id'=>$id]);
        $posts=$stmt->fetchAll();
        $data=json_encode($posts);
        http_response_code(200);
        return $data;


    }
];

foreach ($routes as $route => $endpoint){
    if(preg_match("#^$routes$#",$_SERVER['REQUEST_URI'],$matches)){
        array_shift($matches);
        echo call_user_func_array($endpoint, $matches);
        exit;
    }
}

http_response_code(404);
echo json_encode([
    "err"=>"endpoint_does_not_exist"
]);

