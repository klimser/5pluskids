var Fullscreen = {
    height: 0,
    launch: function(imgSrc, height) {
        if (!$(".fullscreen-wrapper").length) {
            $("body").append('<div class="fullscreen-wrapper" style="display: none;"><div class="fullscreen-content"></div></div>'); // <div class="close-button" onclick="Fullscreen.hide();"><span class="glyphicon glyphicon-remove"></span></div>
            $(".fullscreen-wrapper").click(function(){Fullscreen.hide();});
        }
        $(".fullscreen-wrapper .fullscreen-content").html('<img src="' + imgSrc + '">');
        this.height = height ? height: 0;
        this.checkSize();
        $(".fullscreen-wrapper").fadeIn();
    },
    hide: function() {
        if ($(".fullscreen-wrapper").length) {
            $(".fullscreen-wrapper").fadeOut();
        }
    },
    checkSize: function() {
        if (this.height && this.height > $(window).height()) {
            $(".fullscreen-wrapper .fullscreen-content img").css({"max-height": $(window).height()});
        }
    },
    init: function() {
        $("a.fullscreen-img").click(function(event) {
            event.preventDefault();
            Fullscreen.launch($(this).attr('href'), $(this).data('height'));
        });
        $(window).resize(function() {
            Fullscreen.checkSize();
        });
    }
};