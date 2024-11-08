<?php

if (!class_exists("WP_List_Table")) {

    include_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class BooksListTable extends WP_List_Table
{
    public function prepare_items()
    {
        global $wpdb;
        $table_prefix = $wpdb->prefix;

        $per_page = 4;

        //get current page using get_pagenum() method 
        $current_page = $this->get_pagenum();

        //calculate offset
        $offset = ($current_page - 1) * $per_page;

        //get_current action
        $row_Action = $this->current_action();

        if ($row_Action) {
            $this->process_row_action($row_Action);
        }

        //get orderby and order when isset
        $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : "id";
        $order = isset($_GET['order']) ? $_GET['order'] : "DESC";
        $search_text = isset($_GET['s']) ? '%' .  $_GET['s'] . '%' : false;

        $this->_column_headers = array(
            $this->get_columns(),
            [],
            $this->get_sortable_columns()
        );

        if ($search_text) {
            //query to select all data from wp_books_syatem where search text found
            $total_books = $wpdb->get_results(
                "SELECT * FROM {$table_prefix}books_system
                WHERE `name` LIKE '$search_text' 
                OR `author`LIKE '$search_text'
                OR `book_price`LIKE '$search_text'  ",
                ARRAY_A
            );

            $books = $wpdb->get_results(
                "SELECT * FROM {$table_prefix}books_system 
                WHERE `name` LIKE '$search_text' 
                OR `author`LIKE '$search_text' 
                OR `book_price`LIKE '$search_text' 
                ORDER BY {$orderby} {$order}  
                LIMIT {$offset}, {$per_page}",
                ARRAY_A
            );
        } else {

            $isTrashCondition = "";
            //selcts all the data from wp_employee table 
            if ($row_Action == "show_all") {
            } elseif (($row_Action == "show_published")) {
                $isTrashCondition = "WHERE is_trash=0";
            } elseif (($row_Action == "show_trash")) {
                $isTrashCondition = "WHERE is_trash=1";
            }

            //query to select all data from wp_books_syatem
            $total_books = $wpdb->get_results(
                "SELECT * FROM {$table_prefix}books_system  {$isTrashCondition}",
                ARRAY_A
            );

            $books = $wpdb->get_results(
                "SELECT * FROM {$table_prefix}books_system
                {$isTrashCondition} 
                ORDER BY {$orderby} {$order}  
                LIMIT {$offset}, {$per_page}",
                ARRAY_A
            );
        }


        //count total records 
        $totalrecords = count($total_books);

        $this->set_pagination_args(
            array(
                "total_items" => $totalrecords,
                "per_page" => $per_page,
                "total_pages" => ceil($totalrecords / $per_page)
            )
        );

        $this->items = $books;
    }

    // Return column name
    public function get_columns()
    {
        // Key => value
        // DB Table column key => Front-end table column headers
        $columns = [
            "cb" => '<input type="checkbox" />',
            "id" => "ID",
            "name" => "Book Name",
            "author" => "Author Name",
            "profile_image" => "Book Cover",
            "book_price" => "Book Cost",
            "created_at" => "Created at"
        ];

        return $columns;
    }

    // //To add row actions : Method 1
    // public function handle_row_actions($item, $column_name, $primary)
    // {
    //     if ($column_name == 'name') {
    //         $actions = [
    //             'edit' => "<a href='#'>Edit",
    //             'quick_edit' => "<a href='#'>Quick Edit</a>",
    //             'trash' => "<a href='#'>Trash</a>",
    //             'view' => "<a href='#'>view</a>"
    //         ];
    //         return $this->row_actions($actions);
    //     }
    // }

    public function column_name($item)
    {
        $current_action = $this->current_action();
        if ($current_action == "show_trash") {
            $actions = [
                'restore' => "<a onclick='return confirm(\"Are you sure want to move to restore?\");' href='admin.php?page=list_books&action=restore&book_id=" . $item['id'] . "'>Restore</a>",
                'delete' => "<a  onclick='return confirm(\"Are you sure want to delete it permanently?\");' href='admin.php?page=list_books&action=delete&book_id=" . $item['id'] . "'>Delete Permanently</a>"
            ];
        } elseif ($current_action == "show_all") {
            if ($item['is_trash'] == 0) {
                $actions = [
                    'edit' => "<a href='admin.php?page=list_books&book_id=" . $item['id'] . "&action=edit'>Edit</a>",
                    'quick_edit' => "<a class='quick-edit-btn' href='#'>Quick Edit</a>",
                    'trash' => "<a href='admin.php?page=list_books&action=trash&book_id=" . $item['id'] . "'>Trash</a>",
                    'view' => "<a href='admin.php?page=list_books&book_id=" . $item['id'] . " &action=show'>View</a>"
                ];
            } else {
                $actions = [
                    'restore' => "<a onclick='return confirm(\"Are you sure want to move to restore?\");' href='admin.php?page=list_books&action=restore&book_id=" . $item['id'] . "'>Restore</a>",
                    'delete' => "<a  onclick='return confirm(\"Are you sure want to delete it permanently?\");' href='admin.php?page=list_books&action=delete&book_id=" . $item['id'] . "'>Delete Permanently</a>"
                ];
            }
        } else {
            $actions = [
                'edit' => "<a href='admin.php?page=list_books&book_id=" . $item['id'] . "&action=edit'>Edit</a>",
                'quick_edit' => "<a class='quick-edit-btn' href='#'>Quick Edit</a>",
                'trash' => "<a href='admin.php?page=list_books&action=trash&book_id=" . $item['id'] . "'>Trash</a>",
                'view' => "<a href='admin.php?page=list_books&book_id=" . $item['id'] . "&action=show'>View</a>"
            ];
        }
        return sprintf('%1$s  %2$s ', '<span class="bms_book_name">' . $item['name'] . '</span>', $this->row_actions($actions));
    }

    //To add bulk action Dropdown
    public function get_bulk_actions()
    {
        $current_action = $this->current_action();
        if ($current_action == 'show_trash') {
            $actions = array(
                'restore' => 'Restore',
                'delete' => 'Delete Permanently'
            );
        } else {
            $actions = array(
                'edit' => 'Edit',
                'trash' => 'Move to trash'
            );
        }


        return $actions;
    }

    public function process_row_action($action_type)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'books_system';
        if ($action_type == 'trash') {

            $book_ids = isset($_REQUEST['book_id']) ? $_REQUEST['book_id'] : '';

            if (is_array($book_ids)) {
                foreach ($book_ids as $book_id) {
                    $update_data = ['is_trash' => 1];

                    $where = ['id' => $book_id];

                    //update query
                    $wpdb->update($table_name, $update_data, $where);
                }
?>
                <script>
                    window.location.href = '<?php echo admin_url("admin.php?page=list_books") ?>';
                </script>
            <?php

            } else {
                if (!empty($book_ids)) {

                    $update_data = ['is_trash' => 1];

                    $where = ['id' => $book_ids];

                    //update query
                    $wpdb->update($table_name, $update_data, $where);
                }
            ?>
                <script>
                    window.location.href = '<?php echo admin_url("admin.php?page=list_books") ?>';
                </script>
            <?php
            }
        } elseif ($action_type == 'restore') {

            $book_ids = isset($_REQUEST['book_id']) ? $_REQUEST['book_id'] : '';

            if (is_array($book_ids)) {
                foreach ($book_ids as $book_id) {
                    $update_data = ['is_trash' => 0];

                    $where = ['id' => $book_id];

                    //update query
                    $wpdb->update($table_name, $update_data, $where);
                }
            ?>
                <script>
                    window.location.href = '<?php echo admin_url("admin.php?page=list_books&action=show_all") ?>';
                </script>
            <?php

            } else {
                if (!empty($book_ids)) {

                    $update_data = ['is_trash' => 0];

                    $where = ['id' => $book_ids];

                    //update query
                    $wpdb->update($table_name, $update_data, $where);
                }
            ?>
                <script>
                    window.location.href = '<?php echo admin_url("admin.php?page=list_books&action=show_all") ?>';
                </script>
            <?php
            }
        } elseif ($action_type == 'delete') {

            $book_ids = isset($_REQUEST['book_id']) ? $_REQUEST['book_id'] : '';

            if (is_array($book_ids)) {
                foreach ($book_ids as $book_id) {

                    $where = ['id' => $book_id];

                    //update query
                    $wpdb->delete($table_name, $where);
                }
            ?>
                <script>
                    window.location.href = '<?php echo admin_url("admin.php?page=list_books") ?>';
                </script>
            <?php

            } else {
                if (!empty($book_ids)) {

                    $where = ['id' => $book_ids];

                    //delete query 
                    $wpdb->delete($table_name, $where);
                }
            ?>
                <script>
                    window.location.href = '<?php echo admin_url("admin.php?page=list_books") ?>';
                </script>
<?php
            }
        }
    }

    public function extra_tablenav($position)
    {
        if ($position == "top") {
            global $wpdb;
            $table_name = $wpdb->prefix . 'books_system';
            $action_type = $this->current_action();
            $status_links = array(
                'all' => count($wpdb->get_results("SELECT * FROM {$table_name}", ARRAY_A)),
                'published' => count($wpdb->get_results("SELECT * FROM {$table_name} WHERE is_trash=0 ", ARRAY_A)),
                'trash' => count($wpdb->get_results("SELECT * FROM {$table_name} WHERE is_trash=1 ", ARRAY_A))
            );
            echo '<div class="alignleft action">';

            echo '<ul class="subsubsub status-links ">';
            foreach ($status_links as $status => $count) {
                $currentClass = "";
                if ($action_type == "show_" . $status) {
                    $currentClass = "current";
                }
                echo '<li><a href="admin.php?page=list_books&action=show_' . $status . '" class="' . $currentClass . '">' .  ucfirst($status) . ' (' . $count . ') ' . '</a></li>  |';
            }

            echo '</ul>';
            echo '</div>';
        }
    }
    public function column_cb($book)
    {

        return '<input type="checkbox" name="book_id[]" value="' . $book['id'] . '" />';
    }

    public function column_default($singleBook, $col_name)
    {
        return isset($singleBook[$col_name]) ? '<span class="bms_' . $col_name . '">'  . $singleBook[$col_name] . '</span>' : "N/A";
    }

    //get sortable columns
    public function get_sortable_columns()
    {
        $columns = array(
            'id' => array('id', true),
            'name' => array('name', false),
        );

        return $columns;
    }


    public function no_items()
    {
        echo "No books found.";
    }


    public function column_profile_image($book)
    {

        return '<img src="' . $book['profile_image'] . '" height="100px" width="100px"/>';
    }
}
