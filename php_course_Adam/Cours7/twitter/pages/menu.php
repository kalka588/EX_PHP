<?php
$menu = [
    [
        'name' => 'home',
        'link' => 'home'
    ],
   
    [
        'name' => 'login',
        'link' => 'login'
    ],
     [
        'name' => 'logout',
        'link' => 'logout'
    ],
    [
        'name' => 'signin',
        'link' => 'signin'
    ],
];

foreach($menu as $m) {
    echo("<a href='index.php?page=".$m['link']."'>".$m['name']."</a>");
}