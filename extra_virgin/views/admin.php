<?php

namespace extra_virgin\views;


include_once "../db/connect.php";

if (isset($_SESSION["is_admin"]) && $_SESSION['is_admin'] === false) {
    ?>
    <script> window.location.href = '../views/login.php';</script>";
    <?php

} else {
    ?>
    <H1>Admin</H1>
    <ul>
        <li>
            <a href="../index.php">Go HOME</a>
        </li>
        <li>
            <a href="../auth/logout.php">Logout</a>
        </li>

    </ul>

    <h2> Emails </h2>

    <ol>
        <?php
        foreach ($GLOBALS["db"]->get_emails() as $email) {
            echo "<li> &nbsp; Name: " . $email['name'] . " from " . $email['email'] . ", subject:" . $email['subject'] . " message: " . $email['message'] . "!";
            echo '&nbsp;&nbsp;&nbsp;<a href="../controllers/email.php?email_id=' . $email['id'] . '">DELETE</a> this email.';
            echo '</br> &nbsp; <a href="update_email.php?id=' . $email['id'] . '"> UPDATE</a></li>';
        }
        ?>
    </ol>


    <h2> Items </h2>

    <?php
    echo '<p> <a href="item.php">Create item </a> </p>';
    ?>

    <ol>
        <?php
        foreach ($GLOBALS["db"]->get_items() as $index => $item) {
            echo "<li> &nbsp; Item: " . $item['name'] . " with price " . $item['currency'] . $item['price'];
            echo '&nbsp;&nbsp;&nbsp;<a href="../controllers/item.php?item_id=' . $item['id'] . '">DELETE</a> this item.';
            echo '</br> &nbsp; <a href="update_item.php?id=' . $item['id'] . '"> UPDATE</a></>';
        }
        ?>
    </ol>

    <?php
}
?>