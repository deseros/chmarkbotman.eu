$(function() {
    function str_rand() {
        var result       = '';
        var words        = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
        var max_position = words.length - 1;
            for( i = 0; i < 36; ++i ) {
                position = Math.floor ( Math.random() * max_position );
                result = result + words.substring(position, position + 1);
            }
        return result;
    }

    
    $("#gen").click(function() { 
    $("#short_link").val(str_rand());        
});
});
