<?php

if (!class_exists("BooksListTable")) {

    include_once BMS_PLUGIN_PATH . 'class/BooksListTable.php';
}
$BooksListTableObject = new BooksListTable;
echo '<div class="wrap">';
echo '<h1 class="text-center">List of Books</h1>';


$BooksListTableObject->prepare_items();

echo '<form method="GET" id="form_search">';
echo '<input type="hidden" name="page" value="list_books">';

$BooksListTableObject->extra_tablenav('top');
//add search box
$BooksListTableObject->search_box("Search Book", "search_books");

//display records
$BooksListTableObject->display();

echo '</form>';
echo '</div>';
