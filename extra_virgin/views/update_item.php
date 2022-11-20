<?php

namespace extra_virgin\views;

include_once "../db/connect.php";

$item = $GLOBALS["db"]->get_item_detail($_GET['id']);
?>


<h2>Item</h2>

<ul>
    <form action="../controllers/item.php" method="post">
        name: <br>
        <label>
            <input type="text" name="display_name" value="<?php echo $item['display_name']; ?>"/> <br>
        </label>

        context: <br>
        <label>
            <textarea name="context"><?php echo $item['context']; ?></textarea> <br>
        </label>

        category: <br>
        <label>
            <input type="text" name="category_id" value="<?php echo $item['category_id']; ?>"/> <br>
        </label>

        body: <br>
        <label>
            <input type="text" name="body_id" value="<?php echo $item['body_id']; ?>"/> <br>
        </label>

        price: <br>
        <label>
            <input type="text" name="price" value="<?php echo $item['pice']; ?>"/> <br>
        </label>

        currency: <br>
        <label>
            <input type="text" name="currency" value="<?php echo $item['currency']; ?>"/> <br>
        </label>

        <input type="hidden" name="id" value="<?php echo $item['id']; ?>"/>
        <input type="submit" name="update_item" value="Update"/>

    </form>
</ul>
