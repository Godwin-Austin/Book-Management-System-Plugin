<div class="container-fluid">
    <div class="bms-container" >

        <h1 style="text-align:center;">View Book</h1>

        <form action="<?php echo admin_url('admin.php?page=add_books'); ?>" id="form-add-book" method="post">

            <div class="form-input">

                <label for="book_name">Name</label>

                <input type="text" required name="book_name" id="book_name" class="form-group" value="<?php _e($data['name']); ?>" readonly />
            </div>

            <div class="form-input">

                <label for="author_name">Author Name</label>

                <input type="text" required name="author_name" id="author_name" value="<?php _e($data['author']); ?>"
                    class="form-group" readonly>
            </div>

            <div class="form-input">

                <label for="book_price">Book Price</label>

                <input type="text" name="book_price" id="book_price" value="<?php _e($data['book_price']); ?>" class="form-group" readonly>
            </div>

            <div class="form-input">

                <label for="">Cover Image</label>

                <input type="text" name="cover_image" id="cover_image" class="form-group" value="<?php _e($data['profile_image']); ?>" readonly>
                <img src="<?php _e($data['profile_image']); ?>" height='160px' width="150px">

            </div>

        </form>

    </div>
</div>