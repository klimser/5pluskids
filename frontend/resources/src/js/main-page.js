var MainPage = {
    subjectList: [],
    subjectAgeList: [],
    launchModal: function (listType) {
        if (listType === undefined) listType = 'subject';
        var itemList = this.subjectList;
        if (listType === 'subjectAge') itemList = this.subjectAgeList;
        var targetSelect = $("#order-subject");
        targetSelect.html('');
        for (var i = 0; i < itemList.length; i++) {
            targetSelect.append('<option value="' + itemList[i].id + '">' + itemList[i].name + '</option>');
        }
        if ($("#order_form_body").hasClass("hidden")) grecaptcha.reset();
        $("#order_form_body").removeClass("hidden").find("input[name='order[type]']").val(listType);
        $("#order_form_extra").html('').addClass("hidden");
        $("#order_form").find(".modal-footer").removeClass("hidden");
        $("#order_form").modal();
    },
    completeOrder: function(form) {
        var gToken = grecaptcha.getResponse();
        if (gToken.length === 0) return false;
        $("#order_form").find("button.btn-primary").prop("disabled", true);
        $.ajax({
            url: $(form).attr('action'),
            method: 'post',
            dataType: 'json',
            data: $(form).serialize(),
            success: function (data) {
                if (data.status === 'ok') {
                    $("#order_form_body").addClass("hidden");
                    $("#order_form").find(".modal-footer").addClass("hidden");
                    Main.throwFlashMessage("#order_form_extra", 'Ваша заявка принята. Наши менеджеры свяжутся с вами в ближайшее время.', 'alert-success');
                } else {
                    Main.throwFlashMessage("#order_form_extra", 'Не удалось отправить заявку: ' + data.errors , 'alert-danger');
                    grecaptcha.reset();
                }
                $("#order_form_extra").removeClass("hidden");
                $("#order_form").find("button.btn-primary").prop("disabled", false);
            },
            error: function (xhr, textStatus, errorThrown) {
                Main.throwFlashMessage("#order_form_extra", 'Произошла ошибка при отправке заявки. Вы также можете оставить заявку по телефону.', 'alert-danger');
                $("#order_form_extra").removeClass("hidden");
                $("#order_form").find("button.btn-primary").prop("disabled", false);
            }
        });
        return false;
    },
    recalcCarouselWidth: function(carousel) {
        var stage = $(carousel).find('.owl-stage');
        if (stage) stage.width(Math.ceil(stage.width()) + 1);
    },
    init: function() {
        $('#owl-carousel-1').owlCarousel({
            margin:10,
            loop:true,
            nav: true,
            dots: false,
            navText: ['<span class="icon icon-arrow_left"></span>', '<span class="icon icon-arrow_right"></span>'],
            navElement: "div",
            navContainer: "#carousel-nav-1",
            responsiveClass:true,
            responsive:{
                0:{items:2},
                992:{items:4}
            }
        });
        $('#owl-carousel-2').owlCarousel({
            margin:10,
            loop:true,
            nav: true,
            dots: false,
            navText: ['<span class="icon icon-arrow_left"></span>', '<span class="icon icon-arrow_right"></span>'],
            navElement: "div",
            navContainer: "#carousel-nav-2",
            responsiveClass:true,
            responsive:{
                0:{items:2},
                992:{items:4}
            }
        });
        $('#owl-carousel-3').owlCarousel({
            margin:10,
            loop:true,
            nav: true,
            dots: false,
            navText: ['<span class="icon icon-arrow_left"></span>', '<span class="icon icon-arrow_right"></span>'],
            navElement: "span",
            navContainer: "#carousel-nav-3",
            items: 2
        });
        $('#owl-carousel-4').owlCarousel({
            margin: 15,
            loop:true,
            nav: true,
            dots: false,
            navText: ['<span class="icon icon-arrow_left"></span>', '<span class="icon icon-arrow_right"></span>'],
            navElement: "span",
            navContainer: "#carousel-nav-4",
            items: 2
        });
        $('#owl-carousel-5').owlCarousel({
            margin: 15,
            loop:true,
            nav: true,
            dots: false,
            navText: ['<span class="icon icon-arrow_left"></span>', '<span class="icon icon-arrow_right"></span>'],
            navElement: "span",
            navContainer: "#carousel-nav-5",
            items: 2
        });
        $('#owl-carousel-6').owlCarousel({
            margin: 15,
            loop:true,
            nav: true,
            dots: false,
            navText: ['<span class="icon icon-arrow_left"></span>', '<span class="icon icon-arrow_right"></span>'],
            navElement: "span",
            navContainer: "#carousel-nav-6",
            items: 2
        });

        $(window).on('resize', function(e) {
            $(".owl-carousel").each(function(){
                MainPage.recalcCarouselWidth(this);
            });
        }).resize();

        $('.owl-carousel').on('refreshed.owl.carousel', function(event) {
            MainPage.recalcCarouselWidth(this);
        });

        $("#order-phone").inputmask({"mask": "99 999-9999"});

        Review.init();

        $.ajax({
            url: '/subject/list',
            success: function(data) {
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        MainPage.subjectList.push(data[i]);
                    }
                }
            }
        });

        $.ajax({
            url: '/subject-age/list',
            success: function(data) {
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        MainPage.subjectAgeList.push(data[i]);
                    }
                }
            }
        });
    }
};