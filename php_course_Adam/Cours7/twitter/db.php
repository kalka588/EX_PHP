<?php
define ("DB_URL", "mysql:host=localhost;dbname=twitter"); 
define ("DB_USER", "root"); 
define ("DB_PASS", "");


function dbConnect() {
	global $pdo;
	try {
		$pdo = new PDO(DB_URL, DB_USER, DB_PASS);
		$pdo->exec('SET NAMES UTF8');
	}
	catch (PDOException $e) {
		die("<p class='error'>Erreur: " . $e->getMessage() . "</p>");	
	}
}

dbConnect();

function getAllPosts() {
	global $pdo;
	$query=$pdo->prepare("SELECT * FROM posts ORDER BY idPost DESC LIMIT 10");
	$query->execute();
	$data=$query->fetchAll();
	//var_dump($data);
	return $data;
}

function getUserPosts($idUser) {
	global $pdo;
	$query=$pdo->prepare("SELECT * FROM posts WHERE idUser = ? ORDER BY idPost DESC LIMIT 10");
	$query->execute([$idUser]);
	$data=$query->fetchAll();
	//var_dump($data);
	return $data;
}

function creatPost($post) {
	global $pdo;
	$query=$pdo->prepare("INSERT INTO posts(`isUser`,`content`,`date`) VALUES(?,?,?)");
	$query->execute([$post['idUser'], $post['content'], $post['date']]);
}


