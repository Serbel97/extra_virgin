<?php

namespace extra_virgin\controllers;

include_once "../db/connect.php";


if (isset($_POST['update_email'])) {
    $updated = $GLOBALS["db"]->update_email($_POST['email'], $_POST['name'], $_POST['subject'], $_POST['message'], $_POST['id']);

    if ($updated) {
        echo "<script> window.location.href='../admin.php';</script>";
    } else {
        echo "ERROR ON EMAIL UPDATE!";
    }
} else if (isset($_GET['email_id'])) {
    $deleted = $GLOBALS["db"]->delete_email($_GET['email_id']);

    if ($deleted) {
        echo "<script> window.location.href='../admin.php';</script>";
    } else {
        echo "ERROR ON EMAIL DELETE!";
    }
} else if (isset($_POST['create_email'])) {
    $inserted = $GLOBALS["db"]->insert_email($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message']);

    if ($inserted) {
        echo "<script> window.location.href='../contact.php';</script>";
    } else {
        echo 'ERROR ON EMAIL INSERT!';
    }
} else {
    echo "<script> window.location.href='../index.php';</script>";
}
