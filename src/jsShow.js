$(function() {
    setInterval(showMess, 400);

    function showMess() {
        $.ajax({
            type: "POST",
            url: "show.php",
            success: function(html) {
                $('#messages').html(html);
            }
        });
    }
});