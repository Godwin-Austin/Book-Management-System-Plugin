console.log("JS included");
jQuery(document).ready(function ($) {
  $("#btn-upload-cover").on("click", function (event) {
    event.preventDefault();
    //media object
    var mediaUploader = wp.media({
      title: "Upload Book Cover",
      multiple: false,
    });
    mediaUploader.open();
    mediaUploader.on("select", function () {
      var attachment = mediaUploader.state().get("selection").first().toJSON();
      //console.log(attachment);
      $("#cover_image").val(attachment.url);
    });
  });
  var existingRow = "";
  jQuery(document)
    .off("click", ".quick-edit-btn")
    .on("click", ".quick-edit-btn", function () {
      let book_id = jQuery(this).parents("tr").find(".bms_id").text();
      console.log(book_id);
      let book_name = jQuery(this).parents("tr").find(".bms_book_name").text();
      let author_name = jQuery(this).parents("tr").find(".bms_author").text();
      let book_price = jQuery(this)
        .parents("tr")
        .find(".bms_book_price")
        .text();

      if (jQuery(".quick_edit_cancel_btn").length > 0) {
        jQuery(".quick_edit_cancel_btn").trigger("click");
        let book_name = " ";
      }

      let editHtml =
        `
<td colspan="7">
<table>
<tr>
<td>
Quick Edit
</td>
</tr>
<tr>
 <td>Book Name
 </td>
 <td ><input class="bms-book-name" type="text" value="` +
        book_name +
        `"  name="book_name"  />
 </td>
</tr>
<tr>
 <td>Author Name
 </td>
 <td> 
 <input type="text" class="bms-book-author" name="author_name" value="` +
        author_name +
        `">
 </td>
</tr>
<tr>
 <td>Book Cost
 </td>
 <td><input class="bms-book-price" type="text"  name="book_price" value="${book_price}">
 </td>
</tr>
<tr>
<td>
<button data-id=${book_id} type="button" class="quick_edit_update_btn button button-primary save" >Update</button>
</td>
<td>
<button type="button" class=" button cancel quick_edit_cancel_btn">Cancel</button>
</td>
</tr>
</table>
</td>
`;
      existingRow = jQuery(this).parents("tr").html();

      jQuery(this).parents("tr").html(editHtml);

      jQuery(document)
        .off("click", ".quick_edit_cancel_btn")
        .on("click", ".quick_edit_cancel_btn", function () {
          jQuery(this).parents("tr").html(existingRow);
        });
    });

  //Ajax Request

  jQuery(document)
    .off("click", ".quick_edit_update_btn")
    .on("click", ".quick_edit_update_btn", function () {
      let book_id = jQuery(this).data("id");
      let book_name = jQuery(this).parents("tr").find(".bms-book-name").val();
      let author_name = jQuery(this)
        .parents("tr")
        .find(".bms-book-author")
        .val();
      let book_price = jQuery(this).parents("tr").find(".bms-book-price").val();

      // console.log(book_id + "" + book_name + "" + book_cost + "" + author_name);
      // return false;

      $.ajax({
        url: "admin-ajax.php",
        data: {
          action: "bms_action",
          name: book_name,
          author: author_name,
          price: book_price,
          id: book_id,
        },
        type: "POST",
        success: function (response) {
          if (response == 1) {
            location.reload();
          } else {
            alert(response);
          }
        },
      });
    });
});
