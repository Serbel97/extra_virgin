<?php

namespace extra_virgin\auth;

include_once "../db/connect.php";


if (isset($_POST['login'])) {
    $logged = $GLOBALS["db"]->login($_POST['username'], $_POST['password']);
    if ($logged) {
        $_SESSION['is_admin'] = true;
        echo "<script> window.location.href='../views/admin.php';</script>";
    } else {
        echo "ERROR ON LOGIN!";
    }
} else {
    echo "<script> window.location.href='index.php';</script>";
}