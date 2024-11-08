<?php

class BooksManagement
{
    private $message = '';
    public function __construct()
    {

        add_action("admin_menu", array($this, "addBMSMenu"));

        add_action('admin_enqueue_scripts', array($this, "load_assets"));
    }
    public function load_assets()
    {
        if (@$_GET['page'] == 'list_books' || @$_GET['page'] == 'add_books') {

            wp_enqueue_style(
                "bms_style",
                BMS_PLUGIN_URL . 'assets/css/style.css',
            );

            wp_enqueue_media();

            wp_enqueue_style(
                'bootstrap-css',
                'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'
            );

            wp_enqueue_script(
                'bms-js-file',
                BMS_PLUGIN_URL . 'assets/js/js_script.js',
                array(),
                "1.0",
                true
            );
        }
        wp_enqueue_script(
            'bms-js',
            BMS_PLUGIN_URL . 'assets/js/js.js',
            array(),
            "1.0",
            true
        );
    }

    public function addBMSMenu()
    {
        add_menu_page(
            'Book Management System',
            'Book System',
            'manage_options',
            'list_books',
            [$this, 'book_list'],
            'dashicons-book',
            25
        );

        add_submenu_page(
            'list_books',
            'All Books',
            'All Books',
            'manage_options',
            'list_books',
            [$this, 'book_list'],

        );

        add_submenu_page(
            'list_books',
            'Add New Book',
            'Add New Book',
            'manage_options',
            'add_books',
            [$this, 'add_new_book'],

        );
    }
    private function getBookDetailsById($book_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'books_system';
        $book_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE id={$book_id}", ARRAY_A);
        return $book_data;
    }
    public function book_list()
    {
        $hasAction = isset($_REQUEST['action']) ? $_REQUEST['action'] : " ";
        $hasBookId = isset($_REQUEST['book_id']) ? $_REQUEST['book_id'] : " ";


        if ($hasAction == 'show') {
            // echo "view page";
            $data = $this->getBookDetailsById($hasBookId);
            include_once BMS_PLUGIN_PATH . 'html/show_book.php';
        } elseif ($hasAction == 'edit') {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : '';
                $book_name = isset($_POST['book_name']) ? sanitize_text_field($_POST['book_name']) : '';
                $book_author = isset($_POST['author_name']) ? sanitize_text_field($_POST['author_name']) : '';
                $book_image = isset($_POST['cover_image']) ? sanitize_url($_POST['cover_image']) : '';
                $book_price = isset($_POST['book_price']) ? sanitize_text_field($_POST['book_price']) : '';
                global $wpdb;
                $table_name = $wpdb->prefix . "books_system";
                $update_data = [
                    'name' => $book_name,
                    'author' => $book_author,
                    'book_price' => $book_price,
                    'profile_image' => $book_image
                ];
                $where = [
                    'id' => $book_id
                ];
                $wpdb->update($table_name, $update_data, $where);
                $response = 'Book Updated Successfully';
            }
            $data = $this->getBookDetailsById($hasBookId);

            include_once BMS_PLUGIN_PATH . 'html/edit_book.php';
        } else {
            include_once BMS_PLUGIN_PATH . 'html/book_list.php';
        }
    }

    private function saveBookData()
    {
        global $wpdb;

        $tablePrefix = $wpdb->prefix; // wp_

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_REQUEST['btn_form_submit'])) {

            // Sanitize
            $book_name = sanitize_text_field($_REQUEST['book_name']);
            $book_author = sanitize_text_field($_REQUEST['author_name']);
            $book_price = sanitize_text_field($_REQUEST['book_price']);
            $book_image = sanitize_text_field($_REQUEST['cover_image']);

            // Insert data
            $wpdb->insert("{$tablePrefix}books_system", [
                "name" => $book_name,
                "author" => $book_author,
                "book_price" => $book_price,
                "profile_image" => $book_image
            ]);

            $book_id = $wpdb->insert_id;

            if ($book_id > 0) {

                $this->message = "Successfully, book has been created";
?>
                <script>
                    window.location.href =
                        "http://localhost/wp/wp-admin/admin.php?page=list_books";
                </script>
<?php
            } else {

                $this->message = "Failed to create book";
            }
        }
    }

    public function add_new_book()
    {
        $this->saveBookData();
        $response = $this->message;
        include_once BMS_PLUGIN_PATH . 'html/add_books.php';
    }

    public function CREATE_TABLE_BMS()
    {
        global $wpdb;
        $table_prifix = $wpdb->prefix;
        $table_name = $wpdb->prefix . "books_system";
        $create_table = "CREATE TABLE $table_name (
        `id` bigint(50) NOT NULL AUTO_INCREMENT,
        `name` varchar(150) NOT NULL,
        `author` varchar(150) NOT NULL,
        `profile_image` text NOT NULL,
        `book_price` int(10) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        `is_trash` int(11) NOT NULL DEFAULT 0,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
        include_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($create_table);
    }

    public function DROP_TABLE_BMS()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "books_system";
        $drop_table = "DROP TABLE IF EXISTS $table_name;";
        $wpdb->query($drop_table);
    }

    public function bms_handle_ajax_request()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $book_id = isset($_POST['id']) ? intval($_POST['id']) : '';
            $book_name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
            $book_author = isset($_POST['author']) ? sanitize_text_field($_POST['author']) : '';
            $book_price = isset($_POST['price']) ? sanitize_text_field($_POST['price']) : '';
            global $wpdb;
            $table_name = $wpdb->prefix . "books_system";
            $update_data = [
                'name' => $book_name,
                'author' => $book_author,
                'book_price' => $book_price
            ];
            $where = [
                'id' => $book_id
            ];
            $update = $wpdb->update($table_name, $update_data, $where);
            if ($update) {
                echo 1;
                wp_die();
            } else {
                wp_send_json_error("Error While Updating");
            }
        }
    }
}
