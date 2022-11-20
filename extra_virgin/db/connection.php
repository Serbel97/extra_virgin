<?php

namespace extra_virgin\db;

use const http\Client\Curl\FEATURES;

class Connection
{
    public $connection;

    public function __construct($db_name, $host, $username, $password)
    {
        try {
            $this->connection = new \PDO("mysql:host=$host;dbname=$db_name", $username, $password);
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage() . "<br>";
        }

        return $this->connection;
    }

    public function get_menu()
    {
        $menu_items = [];
        $sql = "SELECT * FROM menus";


        try {
            $query = $this->connection->query($sql);

            while ($row = $query->fetch()) {
                $menu_items[] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'file_name' => $row['file_name'],
                ];
            }
        } catch (\PDOException $e) {
            echo "Error on get menus: " . $e->getMessage() . "<br>";
        }
        return $menu_items;
    }

    public function get_categories()
    {
        $categories = [];
        $sql = "SELECT * FROM categories";

        try {
            $query = $this->connection->query($sql);

            while ($row = $query->fetch()) {
                $categories[] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                ];
            }
        } catch (\PDOException $e) {
            echo "Error on get categories: " . $e->getMessage() . "<br>";
        }
        return $categories;
    }

    public function get_shop_categories($menu_id)
    {
        $shop_categories = [];
        $sql = "SELECT * FROM categories WHERE menu_id='" . $menu_id . "' ORDER BY parent_id";

        try {
            $query = $this->connection->query($sql);

            while ($row = $query->fetch()) {
                $shop_category = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'file_name' => $row['file_name'],
                    'parent' => $row['parent_id'],
                    'menu' => $row['menu_id'],
                ];

                if ($shop_category['parent'] == null) {
                    $shop_category['parent'] = [];
                    $shop_categories[] = $shop_category;
                } else {
                    foreach ($shop_categories as $index => $item) {
                        if ($item['id'] == $shop_category['parent']) {
                            $shop_categories[$index]['parent'][] = $shop_category;
                        }
                    }
                }
            }
        } catch (\PDOException $e) {
            echo "Error on get categories: " . $e->getMessage() . "<br>";
        }
        return $shop_categories;
    }


    public function get_items()
    {
        $items = [];
        $sql = "SELECT id, display_name, pice, currency FROM items";

        try {
            $query = $this->connection->query($sql);

            while ($row = $query->fetch()) {
                $items[] = [
                    'id' => $row['id'],
                    'name' => $row['display_name'],
                    'price' => $row['pice'],
                    'currency' => $row['currency'],
                ];
            }
        } catch (\PDOException $e) {
            echo "Error on get items: " . $e->getMessage() . "<br>";
        }
        return $items;
    }


    public function get_items_with_images()
    {
        $items = [];
        $sql = "SELECT I.*, Img.path AS image_path FROM items AS I JOIN images AS Img ON Img.item_id = I.id ORDER BY id desc ";

        try {
            $query = $this->connection->query($sql);

            while ($row = $query->fetch()) {
                $items[] = [
                    'id' => $row['id'],
                    'display_name' => $row['display_name'],
                    'context' => $row['context'],
                    'body_id' => $row['body_id'],
                    'price' => $row['pice'],
                    'currency' => $row['currency'],
                    'image_path' => $row['image_path']
                ];
            }
        } catch (\PDOException $e) {
            echo "Error on get items: " . $e->getMessage() . "<br>";
        }
        return $items;
    }

    public function get_emails()
    {
        $emails = [];
        $sql = "SELECT * FROM emails";

        try {
            $query = $this->connection->query($sql);

            while ($row = $query->fetch()) {
                $emails[] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'subject' => $row['subject'],
                    'email' => $row['email'],
                    'message' => $row['message'],
                ];
            }
        } catch (\PDOException $e) {
            echo "Error on get items: " . $e->getMessage() . "<br>";
        }
        return $emails;
    }

    public function get_body_detail($id)
    {
        $body = [];
        $sql = "SELECT * FROM body WHERE id=" . $id;

        try {
            $query = $this->connection->query($sql);
            $body = $query->fetch();
        } catch (\PDOException $e) {
            echo "Error on get body detail: " . $e->getMessage() . "<br>";
        }

        return $body;
    }

    public function login($username, $password)
    {
        $sha_pwd = sha1($password);

        $sql = "SELECT COUNT(id) AS is_admin FROM users WHERE username = :username AND  password = :password";


        echo $sha_pwd;
        echo $username;

        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute([
                ':username' => $username,
                ':password' => $sha_pwd
            ]);

            $user = $statement->fetch(\PDO::FETCH_ASSOC);
            if (intval($user['is_admin']) === 1) {
                $result = true;
            } else {
                $result = false;
            }
        } catch (\PDOException $e) {
            $result = false;
            echo "Error on login: " . $e->getMessage() . "<br>";
        }

        return $result;
    }

    public function insert_email($name, $email, $subject, $message)
    {
        $sql = "INSERT INTO emails (name, email, subject, message) 
            VALUES (
                :name, 
                :email,
                :subject,
                :message
            )";

        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute([
                ':name' => $name,
                ':email' => $email,
                ':subject' => $subject,
                ':message' => $message]);

//            $result = $this->connection->lastInsertId();
            $result = True;
        } catch (\PDOException $e) {
            echo "Error on email insert: " . $e->getMessage() . "<br>";
            $result = False;
        }

        return $result;
    }

    public function get_email_detail($id)
    {
        $email = null;
        $sql = "SELECT * FROM emails WHERE id = " . $id;

        try {
            $query = $this->connection->query($sql);
            $email = $query->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error on getting email detail: " . $e->getMessage() . "<br>";
        }

        return $email;
    }

    public function update_email($email, $name, $subject, $message, $id)
    {
        $sql = "UPDATE emails SET 
                  name = '" . $name . "', 
                  email = '" . $email . "', 
                  subject= '" . $subject . "', 
                  message = '" . $message . "' 
                  WHERE id = " . $id;

        try {
            $this->connection->exec($sql);
            $result = true;
        } catch (\PDOException $e) {
            $result = false;
        }

        return $result;
    }

    public function insert_item(
        $display_name, $context, $category_id, $price, $currency, $body, $path
    )
    {
        $sql = "INSERT INTO body (content) 
            VALUES (
                :content
            )";

        $body_item = null;

        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute([
                ':content' => $body
            ]);

            $body_id = $this->connection->lastInsertId();
        } catch (\PDOException $e) {
            echo "Error on body insert: " . $e->getMessage() . "<br>";
        }

        $sql = "INSERT INTO items (display_name, context, category_id, pice, currency, body_id) 
            VALUES (
                :display_name,
                :context,
                :category_id,
                :price,
                :currency,
                :body_id
            )";

        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute([
                ':display_name' => $display_name,
                ':context' => $context,
                ':category_id' => $category_id,
                ':price' => $price,
                ':currency' => $currency,
                ':body_id' => $body_id
            ]);
            $item_id = $this->connection->lastInsertId();
        } catch (\PDOException $e) {
            echo "Error on item insert: " . $e->getMessage() . "<br>";
        }

        $sql = "INSERT INTO images (path, item_id) 
            VALUES (
                :path,
                :item_id
            )";

        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute([
                ':path' => $path,
                ':item_id' => $item_id
            ]);
            $result = true;
        } catch (\PDOException $e) {
            $result = false;
            echo "Error on image insert: " . $e->getMessage() . "<br>";
        }

        return $result;
    }

    public function delete_email($id)
    {
        $sql = "DELETE FROM emails where id=:id";
        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute([
                ':id' => $id,
            ]);

            $result = True;
        } catch (\PDOException $e) {
            echo "Error on email delete: " . $e->getMessage() . "<br>";
            $result = False;
        }

        return $result;

    }

    public function get_item_detail($id)
    {
        $item = null;
        $sql = "SELECT * FROM items WHERE id = " . $id;

        try {
            $query = $this->connection->query($sql);
            $item = $query->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error on getting item detail: " . $e->getMessage() . "<br>";
        }

        return $item;
    }

    public function update_item($display_name, $context, $category_id, $body_id, $price, $currency, $id)
    {
        $sql = "UPDATE items SET 
                 display_name = '" . $display_name . "', 
                 context = '" . $context . "', 
                 category_id= '" . $category_id . "', 
                 body_id = '" . $body_id . "', 
                 price= '" . $price . "', 
                 currency= '" . $currency . "'
                  WHERE id = " . $id;

        try {
            $this->connection->exec($sql);
            $result = true;
        } catch (\PDOException $e) {
            echo "Error on item update: " . $e->getMessage() . "<br>";
            $result = false;
        }

        return $result;
    }

    public function delete_item($id)
    {
        $sql = "DELETE FROM items where id=:id";
        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute([
                ':id' => $id,
            ]);

            $result = true;
        } catch (\PDOException $e) {
            echo "Error on item delete: " . $e->getMessage() . "<br>";
            $result =  False;
        }

        return $result;
    }
}
