$(window).load(function() {
    grooming.main.reload();
    grooming.main.init();

    let $birth = $("#birth");

    if ($birth.length > 0)
        $birth.mask("99-99-9999",{placeholder:"dd-mm-yyyy"});

    const $playerPhoto = $(".player-photo");

    if ($playerPhoto.length > 0)
    {

        $(".photo .before").css({height: $playerPhoto.height() - 6 + 'px'});
        $(".player .box .photo .prev").css({height: $playerPhoto.height() + 'px'});
        $(".player .box .photo .next").css({height: $playerPhoto.height() + 'px'});
    }
});

$(window).resize(function() {
    grooming.main.reload();
});

$(window).scroll(function() {
    let height = $(window).scrollTop();

    if(height  > 10) {
        $('nav').addClass('fixed');
    } else {
        $('nav').removeClass('fixed');
    }
});

let grooming = {
    _var: {
        controller : null,
        scene_vote : null,
        scene_rating : null,
        scene_products : null,
        scene_contact : null,
        scene_result : null,
        scene_p2s1 : null,
        upload_obj : null,
        form_submit : false,
    },

    _con: {

    },

    main: {
        init: function() {
            grooming._var.controller = new ScrollMagic();

            grooming.main.click();
            grooming.main.change();
            grooming.main.submit();
            grooming.main.timer();
            grooming.main.scroller();
            grooming.main.parallax();
            grooming.main.active_menu();
            grooming.main.selectbox();
            grooming.main.fancybox();
            grooming.main.submitform();

        },


        click: function() {
            $(document).on("click", ".all-products .row.buttons a", function () {
                const $this = $(this);

                $(".all-products .row a.select").removeClass('select');
                $this.addClass('select');

                $(".all-products .row.select").removeClass('select');
                $(".all-products .row." + $this.attr('id')).addClass('select');

                return false;
            });

            $(document).on('click', '.form label', function(){
                const $this=$(this);

                if( $this.hasClass('check') )
                {
                    $this.removeClass('check');
                } else {
                    $this.addClass('check');
                }
            });

            $(document).on("click", "button.button-uploads", function () {
                $('#application_form_img_receipt').trigger("click");
            });
        },

        change: function () {
            $(document).on("change", ".upload-file", function () {
                const file = this.files[0];
                const fieldId = $(this).attr('id');
                const fieldError = $(`#${fieldId}_error`);

                fieldError.text('');

                if (file) {
                    if (file.size <= 4 * 1024 * 1024) {
                        const extension = file.name.split('.').pop().toLowerCase();
                        if (['jpg', 'jpeg', 'png'].indexOf(extension) !== -1) {
                            let reader = new FileReader();
                            reader.onload = function (event) {
                                $(`#${fieldId}_thumb`).attr('src', event.target.result);
                            }
                            reader.readAsDataURL(file);
                        } else {
                            // Wyświetlenie komunikatu o błędzie
                            fieldError.text('Można wybrać tylko pliki graficzne JPG, JPEG lub PNG');
                            // Wyczyszczenie pola wyboru pliku
                            $(this).val('');
                        }
                    } else {
                        // Wyświetlenie komunikatu o błędzie
                        fieldError.text('Rozmiar pliku nie może przekraczać 4 MB');
                        // Wyczyszczenie pola wyboru pliku
                        $(this).val('');
                    }
                }
            });
        },

        submit: function () {
            $(document).on('submit', '#trip form', function () {
                const form = $(this);
                const url = form.attr('action');
                const formData = new FormData(this);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        console.log(data);

                        if (data.success) {
                            location.href = data.redirect;
                        } else {
                            $('.error-post').text('');

                            $.each(data.errors, function(key, item) {
                                $(`#application_form_${key}`).closest('.element').find('.error-post').text(item);
                            });
                        }
                    },
                    error: function () {
                        console.error('Błąd sieciowy');
                    }
                });

                return false;
            });

            $(document).on('submit', '#contact form', function () {
                const form = $(this);
                const url = form.attr('action');
                const formData = new FormData(this);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.success) {
                            location.href = data.redirect;
                        } else {
                            // Wyświetlenie komunikatów błędów
                            const errorContainer = $('#contact .error-container');
                            errorContainer.html('');

                            data.errors.forEach(function (error) {
                                const errorElement = $('<div>').text(error);
                                errorContainer.append(errorElement);
                            });
                        }
                    },
                    error: function () {
                        console.error('Błąd sieciowy');
                    }
                });

                return false;
            })
        },

        reload: function() {
            let $bgFix = $(".bg-fixed");

            $bgFix.css({marginTop:   -( ( $bgFix.height() * 1191 / 2500 ) ) });
        },

        selectbox: function() {
            let $selectShop = $('select[name="application_form[shop]"]');
            let $selectCategory = $('select[name="application_form[category]"]');
            let $selectWhere = $('select[name="application_form[from_where]"]');

            if( $selectShop.length > 0 )
            {
                $selectShop.selectbox({});
            }

            if( $selectCategory.length > 0 )
            {
                $selectCategory.selectbox({});
            }

            if( $selectWhere.length > 0 )
            {
                $selectWhere.selectbox({});
            }

        },

        scroller: function() {
            // build scene
            grooming._var.scene_vote = new ScrollScene({triggerElement: "#vote", duration: 200, triggerHook: "onLeave"}).addTo(grooming._var.controller);
            grooming._var.scene_rating = new ScrollScene({triggerElement: "#rating", duration: 200, triggerHook: "onLeave"}).addTo(grooming._var.controller);
            grooming._var.scene_products = new ScrollScene({triggerElement: "#products", duration: 200, triggerHook: "onLeave"}).addTo(grooming._var.controller);
            grooming._var.scene_contact = new ScrollScene({triggerElement: "#contact", duration: 200, triggerHook: "onLeave"}).addTo(grooming._var.controller);
            grooming._var.scene_result = new ScrollScene({triggerElement: "#result", duration: 200, triggerHook: "onLeave"}).addTo(grooming._var.controller);

            // change behaviour of controller to animate scroll instead of jump
            grooming._var.controller.scrollTo(function (newpos) {
                TweenMax.to(window, 0.5, {scrollTo: {y: newpos}});
            });
        },

        parallax: function() {

            // PARALLAX 1 : SCENE 1 : [LAX-ONE]
            const P1S1_duration = 650;
            const P1S1_bgPosMovement = "0 -" + (P1S1_duration*0.4) + "px";
            const p1s1_controller = new ScrollMagic({globalSceneOptions: {triggerHook: "onEnter", duration: P1S1_duration}});
            new ScrollScene({triggerElement: "#trigger1"})
                .setTween(TweenMax.to("#parallax1", 1, {backgroundPosition: P1S1_bgPosMovement, ease: Linear.easeNone}))
                .addTo(p1s1_controller);

            // PARALLAX 1 : SCENE 2 : [LAX-ONE]
            // const P1S2_duration = 310;
            const P1S2_top = "" + 250 + "px";
            const p1s2_controller = new ScrollMagic({globalSceneOptions: {triggerHook: "onEnter", duration: 250}});
            new ScrollScene({triggerElement: "#trigger2"})
                .setTween(TweenMax.to("#parallax1 .bt1", 1, {top: P1S2_top, ease: Linear.easeNone}))
                .addTo(p1s2_controller);

            // PARALLAX 2 : SCENE 1 : [LAX-TWO]
            const P2S1_duration = 650;
            const P2S1_bgPosMovement = "0 -" + (P2S1_duration*0.4) + "px";
            const p2s1_controller = new ScrollMagic({globalSceneOptions: {triggerHook: "onEnter", duration: P2S1_duration}});
            new ScrollScene({triggerElement: "#trigger3"})
                .setTween(TweenMax.to("#parallax2", 1, {backgroundPosition: P2S1_bgPosMovement, ease: Linear.easeNone}))
                .addTo(p2s1_controller);

            // PARALLAX 2 : SCENE 2 : [LAX-TWO]
            // const P2S2_duration = 310;
            const P2S2_top = "" + 250 + "px";
            const p2s2_controller = new ScrollMagic({globalSceneOptions: {triggerHook: "onEnter", duration: 250}});
            new ScrollScene({triggerElement: "#trigger7"})
                .setTween(TweenMax.to("#parallax2 .bt2", 1, {top: P2S2_top, ease: Linear.easeNone}))
                .addTo(p2s2_controller);

            // PARALLAX 3 : SCENE 1 : [PRODUCTS 1]
            const P3S1_duration = $('#b1').height() * 0.75;
            const P3S1_right = "-" + 680 + "px";
            const p3s1_controller = new ScrollMagic({globalSceneOptions: {triggerHook: "onEnter", duration: P3S1_duration}});
            new ScrollScene({triggerElement: "#trigger4"})
                .setTween(TweenMax.to("#b1 .thumb", 1, {right: P3S1_right, ease: Linear.easeNone}))
                .addTo(p3s1_controller);
            //.addIndicators({zindex: 1000});

            // PARALLAX 3 : SCENE 2 : [PRODUCTS 2]
            const P3S2_duration = $('#b2').height() * 0.75;
            const P3S2_left = "-" + 680 + "px";
            const p3s2_controller = new ScrollMagic({globalSceneOptions: {triggerHook: "onEnter", duration: P3S2_duration}});
            new ScrollScene({triggerElement: "#trigger5"})
                .setTween(TweenMax.to("#b2 .thumb", 1, {left: P3S2_left, ease: Linear.easeNone}))
                .addTo(p3s2_controller)
            //.addIndicators({zindex: 1000});

            // PARALLAX 3 : SCENE 3 : [PRODUCTS 3]
            const P3S3_duration = $('#b3').height() * 0.75;
            const P3S3_right = "-" + 680 + "px";
            const p3s3_controller = new ScrollMagic({globalSceneOptions: {triggerHook: "onEnter", duration: P3S3_duration}});
            new ScrollScene({triggerElement: "#trigger6"})
                .setTween(TweenMax.to("#b3 .thumb", 1, {right: P3S3_right, ease: Linear.easeNone}))
                .addTo(p3s3_controller);
            //.addIndicators({zindex: 1000});

        },

        active_menu: function() {

            if ($("#awards").length > 0)
            {
                new ScrollScene({triggerElement: "#awards"})
                    .setClassToggle("nav .menu li a[href='#awards']", "current") // add class toggle
                    .addTo(new ScrollMagic({globalSceneOptions: {duration: $('section.awards').height()}}));
            }

            if ($("#take").length > 0)
            {
                new ScrollScene({triggerElement: "#take"})
                    .setClassToggle("nav .menu li a[href='#take']", "current") // add class toggle
                    .addTo(new ScrollMagic({globalSceneOptions: {duration: $('section.take').height()}}));
            }

            if ($("#vote").length > 0)
            {
                new ScrollScene({triggerElement: "#vote"})
                    .setClassToggle("nav .menu li a[href='#vote']", "current") // add class toggle
                    .addTo(new ScrollMagic({globalSceneOptions: {duration: $('section.vote').height()}}));
            }

            if ($("#rating").length > 0)
            {
                new ScrollScene({triggerElement: "#rating"})
                    .setClassToggle("nav .menu li a[href='#rating']", "current") // add class toggle
                    .addTo(new ScrollMagic({globalSceneOptions: {duration: $('section.rating').height()}}));
            }

            if ($("#products").length > 0)
            {
                new ScrollScene({triggerElement: "#products"})
                    .setClassToggle("nav .menu li a[href='#products']", "current") // add class toggle
                    .addTo(new ScrollMagic({globalSceneOptions: {duration: $('section.products').height()}}));
            }

            if ($("#about").length > 0)
            {
                new ScrollScene({triggerElement: "#about"})
                    .setClassToggle("nav .menu li a[href='#about']", "current") // add class toggle
                    .addTo(new ScrollMagic({globalSceneOptions: {duration: $('section.about').height()}}));
            }

            if ($("#contact").length > 0)
            {
                new ScrollScene({triggerElement: "#contact"})
                    .setClassToggle("nav .menu li a[href='#contact']", "current") // add class toggle
                    .addTo(new ScrollMagic({globalSceneOptions: {duration: $('section.contact').height()}}));
            }

            if ($("#result").length > 0)
            {
                new ScrollScene({triggerElement: "#result"})
                    .setClassToggle("nav .menu li a[href='#result']", "current") // add class toggle
                    .addTo(new ScrollMagic({globalSceneOptions: {duration: $('section.result').height()}}));
            }

            if ($("#thumbs").length > 0)
            {
                new ScrollScene({triggerElement: "#thumbs"})
                    .setClassToggle("nav .menu li a[href='#thumbs']", "current") // add class toggle
                    .addTo(new ScrollMagic({globalSceneOptions: {duration: $('section.thumbs').height()}}));
            }

        },

        submitform: function() {

            $(document).on("submit", "#submitTrip", function () {
                if( grooming._var.form_submit )
                {
                    return true;
                } else {
                    const photoUploader = $('#photoUploader');
                    photoUploader.parent().find('p.error-post').remove();
                    photoUploader.parent().append( "<p class='error-post'>Zdjęcie musi zostać załadowane na serwer.</p>" );
                    return false;
                }
            });

        },

        fancybox: function() {
            $(".product .buy, .box .buy").fancybox({
                maxWidth	: 790,
                maxHeight	: 460,
                width		: '70%',
                height		: '70%',
                autoSize	: false,
                closeClick	: false,
                openEffect	: 'none',
                closeEffect	: 'none',
                padding 	: 0,
                beforeLoad : function() {

                    this.content.find('a').attr( 'href' , '#' );

                    if( $(this.element).data('shop-p00') !== 'none' )
                        this.content.find('.p00').attr( 'href' , $(this.element).data('shop-p00') );

                    if( $(this.element).data('shop-p01') !== 'none' )
                        this.content.find('.p01').attr( 'href' , $(this.element).data('shop-p01') );

                    if( $(this.element).data('shop-p02') !== 'none' )
                        this.content.find('.p02').attr( 'href' , $(this.element).data('shop-p02') );

                    if( $(this.element).data('shop-p03') !== 'none' )
                        this.content.find('.p03').attr( 'href' , $(this.element).data('shop-p03') );

                    if( $(this.element).data('shop-p04') !== 'none' )
                        this.content.find('.p04').attr( 'href' , $(this.element).data('shop-p04') );

                    if( $(this.element).data('shop-p05') !== 'none' )
                        this.content.find('.p05').attr( 'href' , $(this.element).data('shop-p05') );

                    if( $(this.element).data('shop-p06') !== 'none' )
                        this.content.find('.p06').attr( 'href' , $(this.element).data('shop-p06') );

                    if( $(this.element).data('shop-p07') !== 'none' )
                        this.content.find('.p07').attr( 'href' , $(this.element).data('shop-p07') );

                    if( $(this.element).data('shop-p08') !== 'none' )
                        this.content.find('.p08').attr( 'href' , $(this.element).data('shop-p08') );

                    if( $(this.element).data('shop-p09') !== 'none' )
                        this.content.find('.p09').attr( 'href' , $(this.element).data('shop-p09') );

                    if( $(this.element).data('shop-p10') !== 'none' )
                        this.content.find('.p10').attr( 'href' , $(this.element).data('shop-p10') );

                    if( $(this.element).data('shop-p11') !== 'none' )
                        this.content.find('.p11').attr( 'href' , $(this.element).data('shop-p11') );

                    if( $(this.element).data('shop-p12') !== 'none' )
                        this.content.find('.p12').attr( 'href' , $(this.element).data('shop-p12') );

                    if( $(this.element).data('shop-p13') !== 'none' )
                        this.content.find('.p13').attr( 'href' , $(this.element).data('shop-p13') );

                    if( $(this.element).data('shop-p14') !== 'none' )
                        this.content.find('.p14').attr( 'href' , $(this.element).data('shop-p14') );

                    if( $(this.element).data('shop-p15') !== 'none' )
                        this.content.find('.p15').attr( 'href' , $(this.element).data('shop-p15') );
                }
            });
        },

        timer: function() {
            const year = 2015;
            const month = 1;
            const day = 5;
            const hour = 0;
            const minute = 0;
            const second = 0;

            grooming.main.r('.vote .row .timer',year,month,day,hour,minute,second);
        },

        cd: function(d,o,t,x) {
            return[x=~~(t=(d-o)/864e5),x=~~(t=(t-x)*24), x=~~(t=(t-x)*60),~~((t-x)*60)];
        },

        r: function(selector,yy,mm,dd,g,m,s,t) {
            t=grooming.main.cd( new Date(yy,mm-1,dd,g,m,s) , new Date() );

            $(selector + ' .dd').text( ( t[0] < 10 ) ? '0'+t[0] : t[0] );
            $(selector + ' .hh').text( ( t[1] < 10 ) ? '0'+t[1] : t[1] );
            $(selector + ' .mm').text( ( t[2] < 10 ) ? '0'+t[2] : t[2] );

            setTimeout('grooming.main.r("' + selector + '",' + yy + ',' + mm + ',' + dd + ',' + g + ',' + m + ',' + s + ')',1e3);
        },


    }

};
