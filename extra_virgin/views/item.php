<?php

namespace extra_virgin\views;

include_once "../db/connect.php";
?>

<h2>Item</h2>

<ul>
    <form action="../controllers/item.php" method="post">
        name: <br>
        <label>
            <input type="text" name="item_display_name" placeholder="display_name"/> <br>
        </label>

        context: <br>
        <label>
            <textarea name="item_context" placeholder="context"></textarea> <br>
        </label>

        category: <br>
        <label>
            <select name="item_category_id">
                <?php
                foreach ($GLOBALS["db"]->get_categories() as $category) {
                    echo $category['name'];
                  ?>
                    <option value="<?php echo $category['id']?>"><?php echo $category['name'];?></option>
                <?php
                }
                ?>
            </select>
        </label>

        <br> body: <br>
        <label>
            <textarea name="body" placeholder="body"></textarea> <br>
        </label>

        price: <br>
        <label>
            <input type="text" name="item_price" placeholder="price"/> <br>
        </label>

        currency: <br>
        <label>
            <input type="text" name="item_currency" placeholder="currency"/> <br>
        </label>

        image path: <br>
        <label>
            <input type="text" name="image_path" value="assets/img/shop_09.jpg"/> <br>
        </label>

        <input type="submit" name="create_item" value="Create"/>
    </form>
</ul>
