<?php

namespace extra_virgin\controllers;

include_once "../db/connect.php";

if (isset($_POST['create_item'])) {
    $created = $GLOBALS["db"]->insert_item(
        $_POST['item_display_name'],
        $_POST['item_context'],
        $_POST['item_category_id'],
        $_POST['item_price'],
        $_POST['item_currency'],
        $_POST['body'],
        $_POST['image_path']
    );

    if ($created) {
        echo "<script> window.location.href='../admin.php';</script>";
    } else {
        echo 'ERROR ON CREATE ITEM!';
    }
} else if (isset($_POST['update_item'])) {
    $updated = $GLOBALS["db"]->update_item(
        $_POST['display_name'],
        $_POST['context'],
        $_POST['category_id'],
        $_POST['body_id'],
        $_POST['price'],
        $_POST['currency'],
        $_POST['id']
    );

    if ($updated) {
        echo "<script> window.location.href='../admin.php';</script>";
    } else {
        echo "ERROR ON ITEM UPDATE!";
    }
} else if (isset($_GET['item_id'])) {
    $deleted = $GLOBALS["db"]->delete_item($_GET['item_id']);

    if ($deleted) {
        echo "<script> window.location.href='../admin.php';</script>";
    } else {
        echo "ERROR ON ITEM DELETE!";
    }
} else {
    echo "<script> window.location.href='../index.php';</script>";
}
