console.log("JS included");
jQuery(document).ready(function ($) {
  $("#deactivate-book-management-system").on("click", function (event) {
    event.preventDefault();
    var hasconfirm = confirm(
      "Are you sure to deactivate 'Book Management System' Plugin?"
    );
    if (hasconfirm) {
      var deactivate_url = $(this).attr("href");
      window.location.href = deactivate_url;
    }
  });
});
