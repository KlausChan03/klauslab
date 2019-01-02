let filter_dom = document.querySelector(".entry-content-filter");

$(document).on("click", ".expand-btn", function () {
    var this_ = $(this),
        this_id = $(this).data("id"),
        this_action = $(this).data("action"),
        this_dom = $(this).parent().parent().siblings(".entry-main").find(".entry-main-detail");

    var req = {
        action: "preview_post",
        um_id: this_id,
        um_action: this_action
    };
    $.post("/wp-admin/admin-ajax.php", req, function (res) {
        var content = res;
        this_dom.removeClass("hide").html(content);
        this_dom.siblings().addClass("hide");

        this_.siblings().removeClass("hide").addClass("show");
        this_.removeClass("show").addClass("hide");

    });
})

