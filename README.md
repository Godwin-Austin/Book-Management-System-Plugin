# Book Management System Plugin for WordPress

## Overview

The **Book Management System** plugin is a simple yet powerful tool for managing books in WordPress. It allows administrators to add, update, view, and delete books. The plugin features an intuitive interface for managing books and supports AJAX-based updates for real-time interactions. It also includes a trash system to move books temporarily before deletion and comes with an easy-to-use search functionality to filter books.

This plugin is ideal for anyone running a bookstore, library, or any website that needs to manage a catalog of books with details such as title, author, price, and cover image.

## Features

- **Add, Edit, and Delete Books**: Easily add new books to your system, edit their details, and delete them when no longer needed.
- **Trash Management**: Books can be moved to trash for temporary storage. You can restore or permanently delete them.
- **AJAX-based Actions**: All actions like adding, editing, and deleting books are performed with AJAX to ensure a smooth, non-reloading user experience.
- **Responsive Design**: Built with Bootstrap, the plugin interface is fully responsive and adapts to different screen sizes.
- **Search and Filter**: You can search books by name, author, or price to quickly find what you're looking for.
- **Custom Database Table**: The plugin creates a custom database table to store book information.
- **User-Friendly Interface**: Clean and simple UI that integrates well into the WordPress admin dashboard.

## Installation Instructions

### Step 1: Download the Plugin
Download the **Book Management System** plugin from the GitHub repository or by using the WordPress plugin uploader.

### Step 2: Upload the Plugin to WordPress
1. In your WordPress dashboard, navigate to **Plugins > Add New**.
2. Click on **Upload Plugin** at the top of the page.
3. Choose the `.zip` file of the plugin and click **Install Now**.

### Step 3: Activate the Plugin
Once installed, click on **Activate** to enable the plugin.

### Step 4: Start Using the Plugin
After activation, a new menu called **Book System** will appear in your WordPress admin dashboard. You can now start managing books.

## Usage

### Adding a New Book
1. Go to **Book System > Add New Book** from the WordPress dashboard.
2. Fill in the following fields:
   - **Name**: The name of the book.
   - **Author**: The author of the book.
   - **Price**: The price of the book.
   - **Cover Image**: Upload a cover image for the book.
3. Click **Save** to add the book to the database.

### Viewing and Managing Books
1. Go to **Book System > All Books**.
2. A list of all the books you have added will appear. You can:
   - **Edit**: Click the book's title to edit its details.
   - **Move to Trash**: Move a book to trash for temporary removal.
   - **Restore from Trash**: If a book is in trash, you can restore it back to active status.
   - **Delete Permanently**: If a book is in trash, you can delete it permanently.

### Searching for Books
On the **All Books** page, use the search bar to filter books by:
- **Book Name**
- **Author**
- **Price**

This allows you to quickly find specific books in your collection.

### Trash Management
- Go to **Book System > Trash** to view all trashed books.
- From here, you can either restore books to the active list or permanently delete them.

## Database Structure

The plugin creates a custom database table `wp_books_system` to store book details. The table schema is as follows:

| Column Name     | Data Type         | Description                                |
|-----------------|-------------------|--------------------------------------------|
| `id`            | INT (AUTO_INCREMENT) | Unique identifier for each book           |
| `name`          | VARCHAR(255)       | The name of the book                       |
| `author`        | VARCHAR(255)       | The author of the book                     |
| `profile_image` | VARCHAR(255)       | URL of the book's cover image              |
| `book_price`    | DECIMAL(10, 2)     | The price of the book                      |
| `created_at`    | DATETIME           | Timestamp of when the book was added       |
| `is_trash`      | TINYINT(1)         | Indicates whether the book is in trash (0 = active, 1 = trashed) |

## Hooks and Actions

The plugin uses several WordPress hooks and actions for various functionalities:

### Actions:
- `bms_handle_ajax_request`: Handles AJAX requests to add, edit, or delete books without page reloads.
- `CREATE_TABLE_BMS`: Creates the custom database table when the plugin is activated.
- `DROP_TABLE_BMS`: Drops the custom database table when the plugin is deactivated.

### Filters:
- `bms_book_table_data`: Allows customization of the data displayed in the book management table.

## Customization

The plugin is designed with flexibility in mind. If you'd like to customize its appearance or functionality, you can:
- Modify the `book-system.css` file for styling changes.
- Use WordPress hooks and filters to extend the functionality (e.g., add custom fields to the book form).
- Edit the plugin’s PHP files to alter how books are managed or displayed.

## Troubleshooting

### Issue: Plugin does not display correctly in the WordPress dashboard.
**Solution**: Ensure that your WordPress installation is up-to-date. This plugin relies on jQuery and Bootstrap for styling, so conflicts with other plugins or themes may occur. Deactivate other plugins to test compatibility.

### Issue: I can’t find the plugin in the dashboard after installation.
**Solution**: Ensure that the plugin is activated in **Plugins > Installed Plugins**. If it's not appearing, try reinstalling the plugin.

## Contribution Guidelines

If you'd like to contribute to this plugin, please follow these steps:
1. Fork the repository on GitHub.
2. Create a new branch for your feature or bugfix (`git checkout -b feature/my-feature`).
3. Commit your changes (`git commit -am 'Add new feature'`).
4. Push to your branch (`git push origin feature/my-feature`).
5. Create a pull request.

Please ensure your code follows the [WordPress coding standards](https://developer.wordpress.org/coding-standards/). If you’re submitting a bug fix or new feature, provide detailed information about your changes in the pull request description.

## License

This plugin is licensed under the **GPL-2.0 License**. See the [LICENSE](LICENSE) file for more details.

## Contact

For support or inquiries, you can reach us at [your email address or website link]. We’re happy to assist with any questions you may have regarding the plugin.

---

Thanks for using the **Book Management System** plugin!
