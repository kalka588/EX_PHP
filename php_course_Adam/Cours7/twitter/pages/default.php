<?php
echo 'default';
// test SESSION
// afficher les 10 derniers posts
$get = file_get_contents('http://localhost/iutRivesDeSeine/twitter/API.php?api=allposts');
$posts = json_decode($get);

foreach($posts as $post) {
    echo($post->idUser);
    echo($post->content);
    echo($post->date);
}