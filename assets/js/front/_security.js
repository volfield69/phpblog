$(".toggle-password").on('click', function() {
    $(this).toggleClass("fa-eye fa-eye-slash");

    var input = $($(this).attr("toggle"));

    var type = input.attr("type");

    if (type === "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});
