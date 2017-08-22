var view = {

    listenEvent: function () {

        //admin page controller
        $('#show_chapter_content').click(function () {
            $('.show_off_content').hide();
            $('#chapter_block_content').show()
        })

        $('#show_comment_content').click(function () {
            $('.show_off_content').hide();
            $('#comment_block_content').show()
        })

        $('#show_user_content').click(function () {
            $('.show_off_content').hide();
            $('#user_block_content').show()
        })
    }
}