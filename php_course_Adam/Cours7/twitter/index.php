<?php
session_start();
require('db.php');
// test SESSION 
// routage
$page = isset($_GET['page']) ? $_GET['page'] : 'default';
require("pages/$page.php");

