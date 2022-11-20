<?php

namespace extra_virgin\views;

include_once "../db/connect.php";

$email = $GLOBALS["db"]->get_email_detail($_GET['id']);
?>


<form action="../controllers/email.php" method="post">
    <label>
        From: <br>
        <input type="text" name="name" value="<?php echo $email['name']; ?>"/>  <br>
        Email: <br>
        <input type="email" name="email" value="<?php echo $email['email']; ?>"/> <br>
        Subject: <br>
        <input type="text" name="subject" value="<?php echo $email['subject']; ?>"/> <br>
        Message: <br>
        <textarea name="message"> <?php echo $email['message']; ?> </textarea>
        <input type="hidden" name="id" value="<?php echo $email['id']; ?>"/>
        <input type="submit" name="update_email" value="Update"/>
    </label>
</form>
