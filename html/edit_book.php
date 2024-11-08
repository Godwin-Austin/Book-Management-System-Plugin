<div class="container-fluid">
    <div class="bms-container">

        <h1 style="text-align:center;">Edit Book</h1>
        <?php
        if (!empty($response)) {

        ?>
            <p id="save-response"> <?php echo $response; ?> </p>
        <?php
        }
        ?>
        <form action="<?php echo admin_url('admin.php?page=list_books&book_id=' . $data['id'] . '&action=edit'); ?>" id="form-edit-book" method="post">
            <input type="hidden" name="book_id" id="book_id" value="<?php _e($data['id']); ?>" class="form-group">
            <div class="form-input">

                <label for="book_name">Name</label>

                <input type="text" required name="book_name" id="book_name" value="<?php _e($data['name']); ?>" class="form-group">
            </div>

            <div class="form-input">

                <label for="author_name">Author Name</label>

                <input type="text" required name="author_name" id="author_name" value="<?php _e($data['author']); ?>"
                    class="form-group">
            </div>

            <div class="form-input">

                <label for="book_price">Book Price</label>

                <input type="text" name="book_price" id="book_price" value="<?php _e($data['book_price']); ?>" class="form-group">
            </div>

            <div class="form-input">

                <label for="">Cover Image</label>

                <input type="text" name="cover_image" id="cover_image" class="form-group" value="<?php _e($data['profile_image']); ?>" readonly>

                <button id="btn-upload-cover" type="button">Upload Cover Image</button>
            </div>

            <button type="submit" name="btn_form_submit" class="btn">Submit</button>

        </form>

    </div>
</div>