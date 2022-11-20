<?php

require "../db/connect.php";

$_SESSION["is_admin"] = false;

echo "<script> window.location.href='../views/admin.php';</script>";
