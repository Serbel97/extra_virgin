<?php

namespace extra_virgin\db;


include_once "connection.php";
session_start();

global $db;
$db = new Connection('extra_virgin', 'mysql', 'root', 'my-secret-pw');
