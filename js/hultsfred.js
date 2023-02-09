//used by dynamic load
var settings = new Array();
var currentSearch = null;
var currentSearchHook = null;

/* set rek variable if in "artikel" */
if (window.location.href.indexOf("artikel") > -1) {
    window.rek_viewclick = true;
}

/* block rek hits in dev */
// document.cookie = 'rekblock=1'; // TODO: only for dev

(function($) {

    var currPageTitle = $("head").find("title").html();
    var havePushed = false;
    var t_ajaxsearch;
    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/g);
        },
        iPhone: function() {
            return navigator.userAgent.match(/iPhone|iPod/g);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };



    /**
     * browser history helpers
     */
    function resetHistory() {
        // reset webbrowser history
        history.replaceState(null, currPageTitle, hultsfred_object["currPageUrl"]);
        // var ret = "(reset) history.replaceState(null, " + currPageTitle + ", " + hultsfred_object["currPageUrl"] + ")";
        // log(ret);
        return false;
    }

    function pushHistory(title, url) {
        if (url != hultsfred_object["currPageUrl"] && !havePushed) {
            history.pushState({}, title, url);
            // var ret = "(push if) history.pushState(null, " + title + ", " + url + ")";
            // log(ret);
            havePushed = true;
        } else if (url != hultsfred_object["currPageUrl"]) {
            history.replaceState({}, title, url);
            // var ret = "(push else) history.replaceState(null, " + title + ", " + url + ")";
            // log(ret);
        }
        return false;
    }

    /**
     * Initialize google map function
     */
    if (typeof $.fn.googlemap != 'function') {
        $.fn.googlemap = function() {
            if (typeof google != 'undefined') {
                $(this).each(function() {
                    var coordinates = $(this).find(".coordinates").html();
                    var address = $(this).find(".address").html();
                    height = $(".contact-popup").height();
                    $(this).height(height).gmap({
                        scrollwheel: false,
                        center: coordinates,
                        zoom: 15,
                        callback: function() {
                            var self = this;
                            self.addMarker({ 'position': this.get('map').getCenter() }).unbind("click").bind("click", function() {
                                self.openInfoWindow({ 'content': address }, this);
                            });
                        }
                    });
                });
            }
        }
    } else {
        alert("ERROR: The function $.fn.googlemap already exists");
    }
    if (typeof $.fn.googlemaplink != 'function') {
        $.fn.googlemaplink = function() {
            if (typeof google != 'undefined') {
                $(this).each(function() {
                    $(this).find(".coordinates, .address").hide();
                    $(this).unbind("click").bind("click", function(ev) {
                        ev.preventDefault();
                        var coordinates = $(this).find(".coordinates").html();
                        var address = $(this).find(".address").html();

                        $("#page").append("<div class='contact-popup box'><div class='map_canvas'>H&auml;mtar karta...</div></div>").append("<div class='contact-popup overlay'></div>");

                        $(".contact-popup.box").prepend("<div class='close-contact close-popup'></div>");
                        $(".close-contact").unbind("click").bind("click", function() {
                            $(".contact-popup").remove();
                        });

                        $(".contact-popup.overlay").unbind("click").bind("click", function() {
                            $(".contact-popup").remove();
                        });

                        height = $(".contact-popup").height();
                        $(".contact-popup .map_canvas").height(height).gmap({
                            scrollwheel: false,
                            center: coordinates,
                            zoom: 15,
                            callback: function() {
                                var self = this;
                                self.addMarker({ 'position': this.get('map').getCenter() }).unbind("click").bind("click", function() {
                                    self.openInfoWindow({ 'content': address }, this);
                                });
                            }
                        });
                    });
                });
            }
        }
    } else {
        alert("ERROR: The function $.fn.googlemaplink already exists");
    }

    /**
     * Initialize slideshow function
     */
    if (typeof $.fn.slideshow != 'function') {
        $.fn.slideshow = function(args) {
            if ($(this).hasClass("slideshow")) {
                $(this).doslideshow(args);
            } else {
                $(this).find(".slideshow").each(function() {
                    $(this).doslideshow(args);
                });
            }
        }
    }
    if (typeof $.fn.doslideshow != 'function') {
        $.fn.doslideshow = function(args) {
            if (args != undefined) {
                if ($(this).find('.slide').length > 1) {
                    $(this).cycle(args);
                }
            } else {
                if ($(this).find('.slide').length > 1) {

                    /* set up slideshow first time */
                    if (!$(this).hasClass("initialized")) {
                        $(this).show();
                        rand = Math.floor((Math.random() * 1000) + 1);
                        $(this).find(".prevslide").addClass("prev" + rand);
                        $(this).find(".nextslide").addClass("next" + rand);
                        // show slide navigation on hover
                        /*$(this).unbind("hover").hover(function() {
                        	$(this).find(".nextslide, .prevslide, .pager").fadeIn("fast");
                        	return false;
                        },function() {
                        	$(this).find(".nextslide, .prevslide, .pager").fadeOut("fast");
                        	return false;
                        });*/

                        $(this).find('.slideshow_bg').show();
                        args = {
                            fx: 'fade',
                            slideExpr: '.slide',
                            timeout: 5000,
                            slideResize: true,
                            containerResize: false,
                            width: '100%',
                            fit: 1,
                            pause: 0,
                            prev: '.prev' + rand,
                            next: '.next' + rand
                        };


                        // if pager should be added
                        if (!$(this).hasClass("nopager")) {
                            $(this).append('<div class="pager-wrapper pager-wrapper-' + rand + '"><ul class="pager pager' + rand + '"></ul><span class="pager-pause pause-icon"></span></div>');
                            $('.pager-wrapper-' + rand + ' .pager-pause').click(function() {
                                if ($(this).hasClass("paused")) {
                                    $(this).parents('.slideshow').cycle('resume');
                                    $(this).removeClass("paused")
                                } else {
                                    $(this).parents('.slideshow').cycle('pause');
                                    $(this).addClass("paused")
                                }
                            });

                            args['pager'] = '.pager' + rand;
                            args['pagerEvent'] = 'mouseover';
                            args['fastOnEvent'] = true;
                            //args['pagerAnchorBuilder'] = function(idx, slide) {
                            //return '<li><a href="#"></a></li>';
                            //};
                            args['pagerAnchorBuilder'] = function(idx, slide) {
                                // return selector string for existing anchor
                                return '<li class="pager-icon"></li>';
                            };
                        }


                        $(this).cycle(args);

                        $(this).addClass("initialized");
                    } else {
                        /* just resume if already initialized */
                        $(this).cycle('resume');
                    }

                }
            }
        }
    } else {
        alert("ERROR: The function $.fn.slideshow already exists");
    }

    /**
     * close all articles function
     */
    function closeAllArticles() {
        $("article.full").each(function() {
            if (!$(this).hasClass("single")) {
                $(this).removeClass("full").addClass("summary");
                $(this).find(".more-content").hide();
                $(this).find(".summary-content").show();
                //$(this).find(".more-content").slideUp(200);
                //$(this).find(".summary-content").slideDown(200);
            }
        });
    }
    /**
     * Initialize function read-more toggle-button
     */
    function getHistoryTitle(article) {
        entry_title = $(article).find(".entry-title a").html();
        blog_title = $("#logo").find('img').attr('alt');
        return entry_title + " | " + blog_title;
    }

    function readMoreToggle(el) {

        // save page to rek.ai
        if (window.__rekai) {
            window.__rekai.eventAddToSessionPath(window.__rekai.customer);
            window.__rekai.sendView();
        }

        //global var to article
        article = $(el).parents("article");
        if ($(article).hasClass("single")) {
            return false;
        }

        if ($(article).find(".js-external-link").length > 0 || $(article).parents(".search").length > 0) {
            location.href = $(article).find(".js-external-link").attr("href");
            return false;
        }
        if ($(article).hasClass("hk_kontakter")) {
            contactAction(el, null);
            return false;
        }

        //toggle function
        function toggleShow(article) {
            // close article and show summary content
            if ($(article).hasClass("full")) {
                // remove close-buttons
                $(article).find('.js-close-button').remove();

                $(article).find('.more-content').slideUp(0, function() {

                    // remove full class to track article state
                    $(this).parents("article").removeClass("full").addClass("summary");

                    $(this).parents("article").find('.summary-content').slideDown(0, function() {
                        if ($(document).scrollTop() > $(this).parents("article").position().top) {
                            $("html,body").animate({ scrollTop: $(this).parents("article").position().top }, 200);
                        }
                    });

                    $(this).parents("article").slideshow('pause');
                });

                // reset webbrowser history
                resetHistory();
                //title = getHistoryTitle($(article));
                //history.replaceState(null, title, hultsfred_object["currPageUrl"]);
            }
            // show full content
            else {
                // toggle visibility
                // only show one article at a time, i.e. close all first
                closeAllArticles();

                $(article).find('.summary-content').slideUp(0, function() {


                    // add full class to track article state
                    $(this).parents("article").addClass("full").removeClass("summary");
                    $(this).parents("article").find('.more-content').slideDown(0, function() {


                        // animate to top of article
                        $("html,body").animate({ scrollTop: $(this).parents("article").position().top }, 200);

                        if ($(this).parents("article").find(".js-close-button").length >= 1)
                            $(this).parents("article").find(".js-close-button").remove();


                        //add close-button at top
                        var closea = $("<a>").addClass('js-close-button close-link').attr("href", "#").html("<span class='close-icon'></span>St&auml;ng").unbind("click").bind("click", function(ev) {
                            ev.preventDefault();
                            readMoreToggle($(this).parents("article").find(".entry-title a"));
                        });
                        $(this).parents("article").find(".header-tools .close-button-item").append(closea);

                        //add close-button at bottom
                        var closeb = $('<a>').addClass('js-close-button close-link').attr("href", "#").html("<span class='close-icon'></span>St&auml;ng").unbind("click").bind("click", function(ev) {
                            ev.preventDefault();
                            readMoreToggle($(this).parents("article").find(".entry-title a"));
                        });
                        $(this).parents("article").find(".entry-meta").append(closeb);

                        // articles slideshow
                        $(this).slideshow();

                        // run collapse_init
                        if (typeof collapse_init === "function") {
                          collapse_init();
                        }

                    });
                });

                //change webbrowser url
                //find and store post-title and post-url
                //var entry_title = $(article).find(".entry-title");
                //var blog_title = $("#logo").find('img').attr('alt');
                //var title = $(entry_title).find("a").html().replace("&amp;","&") + " | " + blog_title;

                //call pushHistory
                resetHistory();
                url = $(article).find(".entry-title a").attr("href");
                title = getHistoryTitle($(article));
                pushHistory(title, url);


                //History.replaceState(null, title, url);
            }
        }

        if (!$(article).hasClass("loaded") && !$(article).hasClass("loading")) {
            //add class loading
            $(article).addClass("loading"); //.html("Laddar...");

            //find posts id and store it in variable
            var post_id = $(article).find(".article_id").html();

            //create a new div with requested content
            var morediv = $("<div>").attr("class", "more-content").hide();

            //append div after summary-content
            $(article).find('.summary-content').after(morediv);

            $.ajaxSetup({ cache: false });
            $(article).addClass("muted wait");

            $(morediv).load(hultsfred_object["templateDir"] + "/ajax/single_post_load.php", { id: post_id, blog_id: hultsfred_object["blogId"] }, function() {
                // get plugin WP Lightbox 2 by Pankaj Jha to work with dynamical click
                var haveConf = (typeof JQLBSettings == 'object');
                if (haveConf && !$(this).attr("jqlbloaded")) {
                    $(this).attr("jqlbloaded", true);
                    if (haveConf && JQLBSettings.resizeSpeed) {
                        JQLBSettings.resizeSpeed = parseInt(JQLBSettings.resizeSpeed);
                    }
                    if (haveConf && JQLBSettings.marginSize) {
                        JQLBSettings.marginSize = parseInt(JQLBSettings.marginSize);
                    }
                    var default_strings = {
                        help: ' Browse images with your keyboard: Arrows or P(revious)/N(ext) and X/C/ESC for close.',
                        prevLinkTitle: 'previous image',
                        nextLinkTitle: 'next image',
                        prevLinkText: '&laquo; Previous',
                        nextLinkText: 'Next &raquo;',
                        closeTitle: 'close image gallery',
                        image: 'Image ',
                        of: ' of ',
                        download: 'Download'
                    };
                    $(this).find('a[rel^="lightbox"]').lightbox({
                        adminBarHeight: $('#wpadminbar').height() || 0,
                        linkTarget: (haveConf && JQLBSettings.linkTarget.length) ? JQLBSettings.linkTarget : '_self',
                        displayHelp: (haveConf && JQLBSettings.help.length) ? true : false,
                        marginSize: (haveConf && JQLBSettings.marginSize) ? JQLBSettings.marginSize : 0,
                        fitToScreen: (haveConf && JQLBSettings.fitToScreen == '1') ? true : false,
                        resizeSpeed: (haveConf && JQLBSettings.resizeSpeed >= 0) ? JQLBSettings.resizeSpeed : 400,
                        displayDownloadLink: (haveConf && JQLBSettings.displayDownloadLink == '0') ? false : true,
                        navbarOnTop: (haveConf && JQLBSettings.navbarOnTop == '0') ? false : true,
                        //followScroll: (haveConf && JQLBSettings.followScroll == '0') ? false : true,
                        strings: (haveConf && typeof JQLBSettings.help == 'string') ? JQLBSettings : default_strings
                    });
                }

                //add filtersearch
                //add_filtersearch($(article));

                // contact form 7
                if ($('div.wpcf7 > form').length > 0) {
                    if (typeof $('div.wpcf7 > form').wpcf7InitForm == 'function') {
                        $('div.wpcf7 > form').wpcf7InitForm();
                    }
                }

                //set quick-links to related and contact
                //setQuickLinks($(el).parents("article"));

                // set click action on content header tools
                if (typeof rspkr != "undefined" && typeof rspkr.ui != "undefined") {
                    rspkr.ui.addClickEvents();
                }

                $(this).parents("article").find(".js-toggle-dropdown").unbind("click").bind("click", function(ev) {
                    ev.preventDefault();
                    if ($(this).next().is(":visible")) {
                        $(this).next().fadeOut();
                    } else {
                        $(".js-toggle-dropdown").next().fadeOut();
                        $(this).next().fadeIn();
                    }
                });

                // load google map
                $(this).parents("article").find(".map_canvas").googlemap();
                $(this).parents("article").find(".map_link").googlemaplink();

                // contact popup
                $(this).parents("article").find(".js-contact-link").each(function() {
                    setContactPopupAction($(this));
                });

                // set click on full header
                $(this).parents("article").find(".js-toggle-article").unbind("click").bind("click", function(ev) {
                    ev.preventDefault();
                    readMoreToggle($(this).parents("article").find(".entry-title a"));
                });

                $(this).parents("article").removeClass("muted wait");


                // All is loaded
                $(this).parents("article").removeClass("loading").addClass("loaded");

                //exec toggle function
                toggleShow($(this).parents("article"));
            });
        } else if ($(article).hasClass("loaded")) {
            toggleShow($(article));
        }
        return false;
    }






    //Webkit anv�nder sig av ett annat s�tt att m�ta br�dden p� sk�rmen,
    //om inte webbl�saren anv�nder webkit s� kompenseras det med v�rdet 17
    //var scrollbar = $.browser.webkit ? 0 : 17;
    var scrollbar = 0;
    var responsive_lap_start = 541;
    var responsive_desk_start = 970;

    var hide; //used by Timeout to hide #log
    var oldWidth; //used to check if window-width have changed

    //$.expander.defaults.slicePoint = 20;


    // reset opened articles when history back button
    $(window).on("popstate", function(e) {
        if (window.history.state == null && location.hash == "") {
            closeAllArticles();
        }
    });


    /* case insensitive contain */
    $.extend($.expr[':'], {
        'containsi': function(elem, i, match, array) {
            return (elem.textContent || elem.innerText || '').toLowerCase()
                .indexOf((match[3] || "").toLowerCase()) >= 0;
        }
    });

    if (typeof __rekai != "undefined" && hultsfred_object['rekai_autocomplete'] == '1') {
        __rekai.ready(function() {
            var rekAutocomplete = rekai_autocomplete('#s', {
                projectid: '10341068', // TODO: only for dev
                hint: true,
                tabAutocomplete: true,
            }).on('rekai_autocomplete:selected', function(event, suggestion, dataset) {
                window.location = suggestion.url;
            });
        });
    }
    $(document).ready(function() {
        /* bubble */
        if ($(".bubble").length >= 2) {
            var bubble_timeout = false
            setAnimateTimeout();

            
            function animateBubbleNext() {
                var bubble = $(".js-bubble-slideshow").find('.quick-bubble-scroll');
                if (bubble.length == 0) {
                    return;
                }
                var scroll = bubble.scrollLeft();
                var width = bubble.width();
                var max = 0;
                bubble.children().each(function() {
                    max += $(this).width();
                });
                max = Math.round(max / width);
                // calculate which bubble is visible
                var nr = Math.round(scroll / width);
                nr++;
                if (nr >= max) {
                    nr = 0;
                }
                // console.log(nr + " " + max)
                bubble.scrollLeft(nr * width)
                setAnimateTimeout()
            }
            function setAnimateTimeout() {
                if (bubble_timeout) {
                    clearTimeout(bubble_timeout)
                }
                bubble_timeout = setTimeout(animateBubbleNext, 7000)
            }
            $(".bubble").each(function() {
                var bubble = $(this);
            });
            $(".nav-item").click(function() {
                $(this).data('id')
                
            });
            $('.quick-bubble-scroll').scroll(function() {
                var scroll = $(this).scrollLeft();
                var width = $(this).width();
                var max = 0;
                $(this).children().each(function() {
                    max += $(this).width();
                });
                // calculate which bubble is visible
                var nr = Math.round(scroll / width);
                $(this).find(`.bubble[data-id!=${nr}]`).removeClass("active");
                $(this).find(`.bubble[data-id=${nr}]`).addClass("active");
                $(this).parent().find(`.nav-item[data-id!=${nr}]`).removeClass("active");
                $(this).parent().find(`.nav-item[data-id=${nr}]`).addClass("active");
                if (nr == 0) {
                    $('.quick-bubble .arrow-left').addClass('disabled');
                } else {
                    $('.quick-bubble .arrow-left').removeClass('disabled');
                }
                if (nr == max / width - 1) {
                    $('.quick-bubble .arrow-right').addClass('disabled');
                } else {
                    $('.quick-bubble .arrow-right').removeClass('disabled');
                }
                // console.log([scroll, width, max, nr]);
            });
            $('.quick-bubble .arrow').click(function() {
                var bubble = $(this).parents('.quick-bubble').find('.quick-bubble-scroll');
                var scroll = bubble.scrollLeft();
                var width = bubble.width();
                var max = 0;
                bubble.children().each(function() {
                    max += $(this).width();
                });
                // calculate which bubble is visible
                var nr = Math.round(scroll / width);
                if ($(this).hasClass('arrow-left') && nr > 0) {
                    nr--;
                }
                else if ($(this).hasClass('arrow-right') && nr < max / width) {
                    nr++;
                }
                bubble.scrollLeft(nr * width)
                setAnimateTimeout()
                // bubble.animate({
                //     scrollLeft: nr * width
                // }, 1500);
            });


        }


        /* add filter_search */
        if ($(".tag-listing").length > 0) {
            $(".page-title").append("<div class='tag-tools'></div>");
            add_filtersearch($(".tag-listing"));
        }


        /**
         * cleanup if dynamic load of posts
         */
        if ($("body").hasClass("hk-js-dynamic-posts-load")) {
            // hide pages info when infinite scroll
            $("#nav-below").hide();
            $(".breadcrumb .postcount .pagecountinfo").hide();
            // add article count at bottom aswell
            $("<div>").addClass("pagecount-below").addClass("breadcrumb").css("padding-left", "0px").appendTo("#primary");
            $(".breadcrumb .postcount").clone().appendTo(".pagecount-below");
            $(".pagecount-below .postcount").removeClass("float--right");
        }


        /**
         * SVG support
         */
        $(".js-svg-image").each(function() {
            if ($(this).attr("data-svg-src") != "") {
                $(this).attr("src", $(this).attr("data-svg-src"));
            }
        });


        //Stores the window-width for later use
        oldWidth = $(window).width();


        /**
         * open print dialog if on print page
         */
        if ($("body").hasClass("print")) {
            window.print();
            window.close();
        }

        /**
         * Expand article if only one, not on home page
         */
        /*if ($('.archive').find("article").length == 1 && !$(this).parents(".home").length) {
        	readMoreToggle($('.archive').find("article .entry-title a"));
        	$(".page-header").hide();
        }*/

        /**
         * set quick-links to related and contact
         */
        //setQuickLinks($(document));

        /**
         * set click action on content header tools
         */
        $(".js-toggle-dropdown").unbind("click").bind("click", function(ev) {
            ev.preventDefault();
            if ($(this).next().is(":visible")) {
                $(this).next().fadeOut();
            } else {
                $(".js-toggle-dropdown").next().fadeOut();
                $(this).next().fadeIn();
            }
        });



        /**
         * view-modes
         */
        // show framed articles click action
        $(".js-view-summary").unbind("click").bind("click", function(ev) {
            $("#content").addClass("viewmode-only-titles");
            $(".js-view-titles").removeClass("active");
            $(".js-view-summary").addClass("active");
            ev.preventDefault();
        });
        // show only title click action
        $(".js-view-titles").unbind("click").bind("click", function(ev) {
            $("#content").removeClass("viewmode-only-titles");
            $(".js-view-titles").addClass("active");
            $(".js-view-summary").removeClass("active");
            ev.preventDefault();
        });


        /**
         * add action to read-more toggle, if in .home or in lt ie9, go to article
         */
        $("#primary").find("article").each(function() {
            if (!$(this).parents(".home").length && !$(this).parents(".search").length) {
                setArticleActions($(this));
            } else {
                $(this).unbind("click").bind("click", function() {
                    if ($(this).find(".entry-title a").attr("href") !== undefined) {
                        location.href = $(this).find(".entry-title a").attr("href");
                    }
                    // if slideshow link
                    else if ($(this).find(".js-image-link").attr("href") !== undefined) {
                        location.href = $(this).find(".js-image-link").attr("href");
                    }
                });
            }
        });


        /**
         * popup actions
         */
        // contact popup
        $(".js-contact-link").each(function() {
            setContactPopupAction($(this));
        });
        // contact popup
        $(".js-video-popup").each(function() {
            setVideoPopupAction($(this));
        });
        //triggers popup-text-widget click-action
        $(".js-text-widget-popup").each(function() {
            setTextWidgetPopupAction($(this));
        });

        /**
         * read-more-links
         */
        $(".js-read-more-link").each(function() {
            $(this).unbind("click").bind("click", function(ev) {
                ev.preventDefault();
                $(this).siblings(".js-read-more-widget").toggle();
                $(this).hide();
            });
        });

        /**
         * init slideshows
         */
        $('.img-wrapper').slideshow();
        if ($('.slideshow-contact-puff-area').find('.slide').length == 0 && $('.slideshow-contact-puff-area').find('.contact-puffs').length > 0) {
            $('.slideshow-contact-puff-area').height($('.slideshow-contact-puff-area').width() * 326 / 1138);
        }
        if ($('.slideshow-contact-puff-area').find('.slide').length >= 1 && $('.slideshow-contact-puff-area').find('.contact-puffs').length > 0) {
            $('.slideshow-contact-puff-area').height($('.slideshow-contact-puff-area').width() * 326 / 1138);
            $('.slideshow-contact-puff-area').find(".slide").width($('.slideshow-contact-puff-area').width()).height($('.slideshow-contact-puff-area').width() * 326 / 1138);
        }


        /**
         * init google maps on ready
         */
        $(".contact-area .map_canvas, article.post .map_canvas, article.single .map_canvas").googlemap();
        $("article.single .map_link").googlemaplink();

        /**
         * scroll to top actions
         */
        $('#scrollTo_top').hide();
        $(window).scroll(function() {

            /* load next pages posts dynamically when reaching bottom of page */

            if ($("body").hasClass("hk-js-dynamic-posts-load") && parseInt($(this).scrollTop()) > parseInt($(document).height() - $(window).height() * 2 - $("#colophon").height())) {
                dyn_posts_load_posts();
            }


            /* show scroll to top icon */
            if ($(this).scrollTop() > 300) {
                $('#scrollTo_top').fadeIn(300);
            } else {
                $('#scrollTo_top').fadeOut(300);
            }

        });
        $('#scrollTo_top a').unbind("click").bind("click", function() {
            $('html, body').animate({ scrollTop: 0 }, 500);
            return false;
        });
        /* END scroll to top  */


        /**
         * Responsive top navigation bar
         */
        /* new-menu */
        $(".js-show-search").unbind("click").bind("click", function(ev) {
            $(".searchnavigation").toggleClass("unhidden");
            ev.preventDefault();
        });
        /* visa meny */
        $(".js-show-menu").unbind("click").bind("click", function(ev) {
            ev.preventDefault();
            if ($(".hultsfred-menu").length > 0) {
                $(".hultsfred-menu").toggleClass("unhidden");
                addExpandButtons();
            }
        });

        /* end new-menu */
        $(".js-show-main-menu").unbind("click").bind("click", function(ev) {
            $(".main-menu").toggleClass("unhidden");
            ev.preventDefault();
        });
        $(".js-show-tag-menu").unbind("click").bind("click", function(ev) {
            $(".tag-menu-wrapper").toggleClass("unhidden");
            ev.preventDefault();
        });
        /*	$(".js-show-navigation").unbind("click").bind("click",function(ev) {
        		if( $(window).width()+scrollbar < responsive_lap_start ) {
        			$(".category-navigation .cat-item").toggleClass("unhidden");
        			ev.preventDefault();
        		}
        });*/
        $(".js-show-tag-menu-li").unbind("click").bind("click", function(ev) {
            if ($(window).width() + scrollbar < responsive_lap_start) {
                $(".category-navigation .more-navigation .atag-item").toggleClass("unhidden");
                ev.preventDefault();
            }
        });
        $(".js-show-main-sub-menu").unbind("click").bind("click", function(ev) {
            ev.preventDefault();
            //$(".main-sub-menu").toggleClass("unhidden");
            $(".category-navigation").toggleClass("unhidden");
        });
        $(".js-show-search").unbind("click").bind("click", function(ev) {
            ev.preventDefault();
            $(".searchnavigation").toggleClass("unhidden");
        });


        /**
         * handle f5 refresh and esc
         */
        $(document).keyup(function(event) {
            var key = event.keyCode || event.which;
            // log(key);
            switch (key) {
                case 27:
                    if ($(".contact-popup").length > 0) {
                        $(".contact-popup").remove();
                    }
                    $(".form-popup.overlay").hide();
                    $(".hk-gcse-ajax-searchresults-wrapper").hide();
                    $(".js-close-search").remove();
                    $('#s').val('');
                    break;
                case 116:
                    event.preventDefault();
                    resetHistory();
                    window.location = hultsfred_object["currPageUrl"];
                    break;
            }
        });

        // make :focus work on navigation dropdowns (i.e. if has class .menu-item.menu-item-has-children is set on parent)
        $("a").hover(function(event) {
            $(".menu-item.menu-item-has-children .sub-menu.active").removeClass("active");
            //$(this).focus();
        });
        $("a").focus(function(event) {
            $(".menu-item.menu-item-has-children .sub-menu").removeClass("active");

            if ($(this).hasClass(".menu-item.menu-item-has-children") || $(this).parents(".menu-item.menu-item-has-children").length > 0) {
                $(this).parents(".menu-item.menu-item-has-children").find(".sub-menu").addClass("active");
            }
        });


        if (hultsfred_object['rekai_autocomplete'] != '1') {

            $("#s").focus(function() {
            
                /**
                 * add ajax searchbox if enabled in settings and not less than ie9
                 */
                if ($(".hk-ajax-searchbox").length > 0 && $("body.search").length == 0) { // else wp search
                    hkHandleKeypress();

                    /* make search-results have target blank */
                    $('.gcse-searchresults').on('mouseenter', 'a.js-toggle-article', function() {
                        $(this).attr('target', '_blank');
                    });

                }


                $(this).unbind("focus");
            });
        }
        /**
         * init responsive search hook results
         */
        initResponsiveSearchHookResult();


    }); /* END $(document).ready() */


    /**
     * gcse ajax callback and helpers
     */
    var hkPreventSubmit = function(e) {
        if (e.keyCode == 13 || e.which == 13) {
            e.preventDefault();
            // log('Enter pressed in search...');
            return false;
        }
    };
    var hkDoSearch = function(e) {
        var key = e.keyCode || e.which;
        
        // don't do anything if same search term is entered
        if ($('#s').val() == $('#s').data('old-search')) {
            return
        }
        $('#s').data('old-search', $('#s').val());

        if ($('#s').val().length == 0 || (key == 27)) {
            $(".hk-gcse-ajax-searchresults-wrapper").hide();
            $(".js-close-search").remove();
            $('#s').val('');
        }

        //Reset timer
        if (t_ajaxsearch != undefined) {
            clearTimeout(t_ajaxsearch);
        }
        if ($('#s').val().length > 2 && (key != 27)) {
            t_ajaxsearch = setTimeout(hkSearch, 300);
        }
    };
    var hkSearch = function() {
        if ($('#s').val().length < 3) {
            $(".hk-gcse-ajax-searchresults-wrapper").hide();
            $(".js-close-search").remove();
        } else {
            $(".hk-gcse-ajax-searchresults-wrapper").show();

            if ($(".js-close-search").length == 0) {
                $(".hk-gcse-ajax-searchresults-wrapper").prepend("<div class='js-close-search close-search close-popup'></div>");
                $(".close-search").unbind("click").bind("click", function() {
                    $(".hk-gcse-ajax-searchresults-wrapper").hide();
                    $(".js-close-search").remove();
                });
            }

            // log("Searching for: " + $('#s').val());
            if ($("body.search").length == 0) {
                    //$(".gcse-searchresults").html(response);
                    data = { action: 'hk_search', searchstring: $('#s').val() };
                    $(".gcse-searchresults").html('<div class="islet">V&auml;ntar på s&ouml;kresultat...<span style="display:inline-block" class="spinner"></span></div>');
                    if(currentSearch != null) {
                        currentSearch.abort();
                    }
                    currentSearch = jQuery.ajax({
                        type: 'POST',
                        url: hultsfred_object["admin_ajax_url"],
                        data: data,
                        dataType: 'html',
                        success: function(response) {
                            $(".gcse-searchresults").html(response);
                            //console.log("success: " + response);

                            // make click work on image and text
                            $(".hk-gcse-googleresults").find(".type-post .entry-content, .type-post .img-wrapper").click(function()
                            {
                              $(this).parents(".article-wrapper").find(".js-toggle-article")[0].click();
                            });
                            $(".hk-gcse-googleresults").find(".type-hk_kontakter .contact-wrapper").click(function() {
                              $(this).parents("article").find(".entry-title a")[0].click();
                            });

                        },
                        error: function(response) {
                            // log("error: " + response);
                        }
                    });
                
            }
            if ($(".hk-gcse-ajax-searchresults-wrapper").find(".has-hook").length > 0) {
                data = { action: 'hk_search_hook', searchstring: $('#s').val() };
                $(".hk-gcse-hook-results").html('<div class="islet">V&auml;ntar på s&ouml;kresultat...<span style="display:inline-block" class="spinner"></span></div>');

                if(currentSearchHook != null) {
                    currentSearchHook.abort();
                }
                currentSearchHook = jQuery.ajax({
                    type: 'POST',
                    url: hultsfred_object["admin_ajax_url"],
                    data: data,
                    dataType: 'html',
                    success: function(response) {
                        $(".hk-gcse-hook-results").html(response);
                        // contact popup
                        $(".hk-gcse-hook-results").find(".js-contact-link").each(function() {
                            setContactPopupAction($(this));
                        });

                        initResponsiveSearchHookResult();
                        //console.log("success: " + response);
                    },
                    error: function(response) {
                        // log("error: " + response);
                    }
                });
            }

        }
    };
    var hkHandleKeypress = function() {
        $("#s").keypress(hkPreventSubmit);
        $("#s").keydown(hkPreventSubmit);
        $("#s").keyup(hkPreventSubmit);
        $('#s').keyup(hkDoSearch);
    }


    /**
     * helper to ajax search
     */
    /*
function erase_and_refocus_on_search_input()
{
	$('#s').val('');
	$('#s').focus();

	var dropdown = $('.searchresult-wrapper');

	if($(dropdown).length > 0) {
		$(dropdown).remove();
	}

	var erase_button = $('.clearbutton');

	if($(erase_button).length > 0) {
		$(erase_button).remove();
	}

}
*/

    /**
     * article actions to be set when ready and when dynamic loading
     */
    /*
    function setQuickLinks(el) {

        if ($(el).find(".contact_title").length > 0) {
            $(el).find(".js-quick-link.contact").removeClass("force-hidden");
        }
        if ($(el).find(".related_title").length > 0) {
            $(el).find(".js-quick-link.related").removeClass("force-hidden");
        }
        $(el).find(".js-quick-link a").click(function(ev) {
            ev.preventDefault();
            $("html,body").animate({ scrollTop: $("[name='" + $(this).attr("href").substring(1) + "']").position().top }, 200);
        });
    }
    */

    function setArticleActions(el) {
        //add filtersearch
        //add_filtersearch($(el));

        // special if ghostrec active
        if (document.cookie.match(new RegExp('ghostrec-usability'))) {
            //location.href = $(article).find(".js-external-link").attr("href");
            return true;
        }

        //sets click-action on entry-titles
        $(el).find('.js-toggle-article').unbind("click").bind("click", function(ev) {
            ev.stopPropagation();
            ev.preventDefault();

            if (!$(this).parents('article').hasClass('loading')) {
                readMoreToggle(this);
            } else { return false; }
        });


        //triggers articles click-action entry-title clicked
        $(el).find(".summary-content .entry-content, .summary-content .img-wrapper").unbind("click").bind("click", function() {
            if ($(this).parents("article").find('.entry-title a').hasClass('js-toggle-article')) {
                readMoreToggle($(this).parents("article").find('.entry-title a'));
            }
        });


        //triggers contact click-action
        $(el).find(".js-contact-link").each(function() {
            setContactPopupAction($(this));
        });
    }
    /**
     * set video popup action
     */
    function setVideoPopupAction(el) {
        $(el).unbind("click").bind("click", function(ev) {
            videoAction(el, ev);
            return false;
        });
    }

    function youtube_parser(url) {
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
        var match = url.match(regExp);
        return (match && match[7].length == 11) ? match[7] : false;
    }

    function vimeo_parser(url) {
        var match = /vimeo.*\/(\d+)/i.exec(url);
        if (match) {
            return match[1];
        }
    }

    function videoAction(el, ev) {
        if ($(".video-popup").length == 0) {
            var videourl = $(el).attr("data-video-url");

            // follow link if post_id not found
            if (videourl == null) {
                return true;
            }

            if (ev != null) {
                ev.preventDefault();
            }

            videocode = "Har inte st&ouml;d f&ouml;r denna URL: " + videourl;
            youtubeurl = youtube_parser(videourl);
            vimeourl = vimeo_parser(videourl);
            uniqueVideoID = "";
            if (youtubeurl != "") {
                uniqueVideoID = youtubeurl;
                parsedvideourl = "https://www.youtube.com/embed/" + youtubeurl + "?autoplay=1";
                videocode = "<iframe src='" + parsedvideourl + "' frameborder='0' allowfullscreen></iframe>";
            } else if (vimeourl != "") {
                uniqueVideoID = vimeourl;
                parsedvideourl = "https://player.vimeo.com/video/" + vimeourl + "?autoplay=1";
                videocode = "<iframe src='" + parsedvideourl + "' frameborder='0' allowfullscreen></iframe>";
            }
            $("#page").append("<div class='video-popup box' id='" + uniqueVideoID + "'><div class='entry-content islet'>" + videocode + "</div></div>").append("<div class='video-popup overlay'></div>");

            $(".video-popup iframe").height($(".video-popup").height() - 24);
            $(".video-popup.overlay").unbind("click").bind("click", function() {
                $(".video-popup").remove();
                //resetHistory();
            });

            if ($(this).attr("href") !== undefined) {
                var thepage = $(this).attr("href");
            }


            $(".video-popup.box").find(".entry-content").before("<div class='js-close-video close-video close-popup'></div>");
            $(".js-close-video").unbind("click").bind("click", function() {
                $(".video-popup").remove();
                //resetHistory();
            });

            //call pushHistory
            //resetHistory();
            //url = $(this).find(".entry-title a").attr("href");
            //title = getHistoryTitle($(this));
            //pushHistory(title, url);

        } else {
            $(".video-popup").remove();
        }
    }

    /**
     * set contact popup action
     */
    function setContactPopupAction(el) {
        $(el).unbind("click").bind("click", function(ev) {
            contactAction(el, ev);
            return false;
        });

    }

    function contactAction(el, ev) {
        if ($(".contact-popup").length == 0) {
            var post_id = $(el).parents(".contact-wrapper").find(".contact_id").html();
            if (post_id === undefined)
                post_id = $(el).parents("article").find(".article_id").html();

            // follow link if post_id not found
            if (post_id == null) return true;

            if (ev != null)
                ev.preventDefault();

            $("#page").append("<div class='contact-popup box'><div class='entry-content islet'>H&auml;mtar kontaktuppgifter...</div></div>").append("<div class='contact-popup overlay'></div>");

            $(".contact-popup.overlay").unbind("click").bind("click", function() {
                $(".contact-popup").remove();
                resetHistory();
            });

            if ($(this).attr("href") !== undefined) {
                var thepage = $(this).attr("href");
            }
            $(".contact-popup.box").load(hultsfred_object["templateDir"] + "/ajax/hk_kontakter_load.php", { id: post_id, blog_id: hultsfred_object["blogId"] }, function() {
                $(this).find(".entry-wrapper").before("<div class='js-close-contact close-contact close-popup'></div>");
                $(".js-close-contact").unbind("click").bind("click", function() {
                    $(".contact-popup").remove();
                    resetHistory();
                });

                /* load google maps */
                $(this).find(".map_canvas").googlemap();

                /* init contact slideshow */
                $(this).slideshow();

                //call pushHistory
                resetHistory();
                url = $(this).find(".entry-title a").attr("href");
                title = getHistoryTitle($(this));
                pushHistory(title, url);

            });
        } else {
            $(this).slideshow("pause");
            $(".contact-popup").remove();
        }
    }

    /**
     * set contact popup action - link as input el
     */
    function setTextWidgetPopupAction(el) {
        $(el).unbind("click").bind("click", function(ev) {
            textWidgetAction(el, ev);
            return false;
        });

    }

    /**
     * Add action to text widget (i.e. popup with overlay if popuptext is found
     */
    function textWidgetAction(el, ev) {
        // check if previous popups
        //if ($(".contact-popup").length == 0) {
        parentwidget = $(el).parents(".widget");

        // follow link if no popuptext found
        if ($(parentwidget).find(".popuptext").length == 0)
            return true;
        if (ev != null)
            ev.preventDefault();

        // show popup
        $(parentwidget).find(".form-popup.overlay").show();

        // close button and close on overlay-press
        $(parentwidget).find(".form-popup.overlay").unbind("click").bind("click", function(ev) {
            $(el).parents(".widget").find(".form-popup.overlay").hide();
        });
        $(parentwidget).find(".form-popup.box").unbind("click").bind("click", function(ev) {
            ev.stopPropagation();
        });
        $(parentwidget).find(".close-contact").unbind("click").bind("click", function() {
            $(el).parents(".widget").find(".form-popup.overlay").hide();
        });

        /*}
        	else {
        	$(this).slideshow("pause");
        	$(".contact-popup").remove();
        }*/
    }

    /**
     * load next posts dynamic
     */
    var load_next_page = true;
    var first_page_loaded = false;
    var filter = "";
    var shownposts = "";

    function dyn_posts_load_posts() {
        // stop if already loading
        if (!load_next_page) {
            return false;
        }
        load_next_page = false;

        // first time only, get parameters
        if (!first_page_loaded) {
            first_page_loaded = true;
            filter = hultsfred_object["currentFilter"];
            filter = JSON.parse(filter);
            shownposts = $("#shownposts").data("shownposts");
            shownposts = shownposts.split(",");
        }

        // setup div to collect new posts
        $('#content')
            .append('<div id="dyn-posts-placeholder" class="dyn-posts-placeholder"></div><div class="dyn-posts-loading">Laddar fler artiklar <span class="spinner" style="display: inline-block"></span></div>')

        // update to new shownposts
        filter["shownposts"] = shownposts;

        // load new posts
        $('#dyn-posts-placeholder').hide().load(hultsfred_object["templateDir"] + "/ajax/posts_load.php", { filter: JSON.stringify(filter) },
            function() {

                // do nothing if dyn-posts is empty
                if ($('#dyn-posts-placeholder').html() == "") {
                    $(".dyn-posts-loading").html("Alla artiklar &auml;r laddade.");
                    load_next_page = false;
                    return; // i.e. don't try to load more pages
                }

                // read-more toggle actions on loaded posts
                $('#dyn-posts-placeholder').find('article').each(function() {
                    setArticleActions($(this));
                });

                // show list when loaded and unwrap, getting ready for more posts
                $('#dyn-posts-placeholder').slideDown("fast", function() {

                    // debug
                    //$('#dyn-posts-placeholder').prepend("<div>client: " + filter["paged"] + "</div>");

                    // add added posts to shownposts
                    $('#dyn-posts-placeholder').find(".article_id").each(function() {
                        shownposts.push($(this)[0].innerText);
                    });

                    // unwrap temp wrapper
                    $('#dyn-posts-placeholder').children(":first-child").unwrap();

                    // update loaded post count
                    $(".breadcrumb .postcount .count").html($("#content article").length);

                    // ready to load next page
                    $(".dyn-posts-loading").remove();
                    load_next_page = true;
                });

            }

        );


        return false;
    };





    /**
     * handle browser resize
     */
    $(window).resize(function() {

        /* scale map */
        $(".map_canvas").height($(".contact-popup").height());

        /* scale video */
        $(".video-popup iframe").height($(".video-popup").height() - 24);

        if (oldWidth != $(window).width()) {

            /* reset responsive stuff */
            if ($(window).width() + scrollbar > responsive_lap_start) {
                $("ul.main-menu, ul.main-sub-menu").addClass("unhidden");
            } else {
                $("ul.main-menu, ul.main-sub-menu").removeClass("unhidden");
            }
        }
        oldWidth = $(window).width();
    });

    /**
     * helper function
     */

    var initResponsiveSearchHookResult = function() {
        if ($(window).width() + scrollbar < responsive_lap_start) {
            $(".js-toggle-search-hook").each(function() {
                toggleHookResult($(this));
                $(this).css("cursor", "pointer").append(" <span class='js-toggle-search-expander' style='display:inline-block'>+</span>").click(function() {
                    toggleHookResult($(this));
                });
            });
        }
    }
    var toggleHookResult = function(el) {
        var parent = $(el).parents(".js-toggle-search-wrapper");
        if ($(parent).find(".js-toggle-search-expander").html() == "+") {
            $(parent).find(".js-toggle-search-expander").html("-");
        } else {
            $(parent).find(".js-toggle-search-expander").html("+");
        }
        $(parent).find(".search-item").each(function() {
            $(this).toggle();
        });

    }
    var log = function(logtext) {
        if (document.location.hostname == "127.0.0.1" || document.location.hostname == "localhost") {
            $("#log").unbind("click").click(function() {
                $("#log").hide();
            });
            //Reset timer hide
            //clearTimeout(hide);

            $("#log").fadeIn("slow");

            $("#log").append(logtext + "<br>");
            //Fading out in 5s.
            //hide = setTimeout( function(){
            //	$("#log").fadeOut("slow");
            //},2000);
        }
    }



    /**
     * filter functionality - alse collapse/expand in tags-list
     */
    var add_filtersearch = function(parent) {
            // check if filter exist
            //if ($(parent).find(".filtersearch").length <= 0 && !$(parent).hasClass("tag-listing")) {
            if (!$(parent).hasClass("tag-listing")) {
                return;
            }
            // pick text to use if entered in shortcode
            var text = $(parent).find(".filtersearch").attr("data-text");
            if (text === undefined) {
                text = "s&ouml;k p&aring; denna sida";
            }

            // add filter button
            $(".tag-tools, .filtersearch").append("<div class='js-filter-tags zeta filter tool'></div>");
            $(parent).find(".filter.tool").append("<span class='float--left half-margin--right'>" + text + "</span>");
            $(parent).find(".filter.tool").append("<input class='float--left filterinput' type='text' name='filterinput' />");
            $(parent).find(".filter.tool").append("<span class='float--left delete-icon rensa hand hidden half-margin--left rensa' style='margin:0'></span>");
            $(parent).find('.filter.tool .filterinput').focus();
            $(parent).find('.filter.tool .rensa').click(function() {
                $(this).parents(".filter.tool").find('.filterinput').val('');
                $(this).parents(".filter.tool").find('.rensa').hide();
                $(this).parents(".filter.tool").find('.filterinput').focus();
                filter_search($(this));
            });

            $(parent).find('.filter.tool .filterinput').keyup(function(ev) {
                $(this).parents(".filter.tool").find('.rensa').show();
                filter_search($(this));
            });
        } // end function add_filtersearch
    var filter_search = function(el) {
            var filter = $(el).val().toLowerCase();

            // if tag-list
            if ($(el).parents(".tag-listing").length > 0) {
                // article-taggar
                // show all
                $(el).parents(".tag-listing").find("article").show();
                $.each(["h4", "h3", "h2", "h1"], function(i, val) {
                    $(el).parents(".tag-listing").find(val).show();
                });

                // hide not contains
                $(el).parents(".tag-listing").find("article:not(:containsi('" + filter + "'))").hide();
                // show contains
                $(el).parents(".tag-listing").find("article:containsi('" + filter + "')").show();

                // tag-listing
                // show all
                $(el).parents(".tag-listing").find(".wrapper2, .wrapper3, .wrapper4, .wrapper5, .wrapper6, ul.indent1").show();
                $(el).parents(".tag-listing").find(".tag-listing .js-expand-all-tags").removeClass("expanded").html("[visa alla]");
                $(el).parents(".tag-listing").find(".tag-listing").find(".sign").html("-");

                // hide not contains
                $(el).parents(".tag-listing").find("li:not(:containsi('" + filter + "'))").hide();
                // show contains
                $(el).parents(".tag-listing").find("li:containsi('" + filter + "')").show();

                // hide empty headings
                $.each(["h4", "h3", "h2", "h1"], function(i, val) {
                    $(el).parents(".tag-listing").find(val).each(function() {
                        if ($(this).next().hasClass("wrapper")) {
                            if ($(this).next().find("article:visible").length == 0) {
                                $(this).hide();
                            }
                        }
                    });
                });
            }
    } // end function filter_search


    /* add expand-ul buttons helper function */
    var firstRunExpandButtons = true;
    var addExpandButtons = function() {
        if (firstRunExpandButtons) {
            firstRunExpandButtons = false;
            /* add button */
            if ($(".hultsfred-menu").length > 0) {
                $(".hultsfred-menu ul").each(function(e) {
                    var prevel = $(this).prev();
                    if ($(prevel).is("a")) {
                        if ($(this).has("li").length > 0) {
                            if ($(this).is(":visible")) {
                                $(prevel).after('<button class="js-expand expand-button expanded">-</button>');
                            } else {
                                $(prevel).after('<button class="js-expand expand-button">+</button>');
                            }
                        }
                    }

                })
            }
            /* add click-action */
            $(".hultsfred-menu .js-expand").click(function(ev) {
                if ($(this).hasClass("expanded")) {
                    $(this).html("+").toggleClass("expanded");
                    $(this).next().fadeToggle(200);
                } else {
                    $(this).html("-").toggleClass("expanded");
                    $(this).next().fadeToggle(200);
                }
            });
            $(".hultsfred-menu .js-expand-who").click(function(ev) {
                if ($(this).next().hasClass("expanded")) {
                    $(this).next().html("+");
                    $(this).next().toggleClass("expanded");
                    $(this).parent().find("ul").first().fadeToggle(200);
                } else {
                    $(this).next().html("-");
                    $(this).next().toggleClass("expanded");
                    $(this).parent().find("ul").first().fadeToggle(200);
                }
            });

        }

    } /* end addExpandButtons */


})(jQuery);

/*
 Copyright 2014 Google Inc. All rights reserved.

 Licensed under the Apache License, Version 2.0 (the "License");
 you may not use this file except in compliance with the License.
 You may obtain a copy of the License at

 http://www.apache.org/licenses/LICENSE-2.0

 Unless required by applicable law or agreed to in writing, software
 distributed under the License is distributed on an "AS IS" BASIS,
 WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 See the License for the specific language governing permissions and
 limitations under the License.
 */

(function(window) {

    if (!!window.cookieChoices) {
        return window.cookieChoices;
    }

    var document = window.document;
    // IE8 does not support textContent, so we should fallback to innerText.
    var supportsTextContent = 'textContent' in document.body;

    var cookieChoices = (function() {

        var cookieName = 'displayCookieConsent';
        var cookieConsentId = 'cookieChoiceInfo';
        var dismissLinkId = 'cookieChoiceDismiss';

        function _createHeaderElement(cookieText, dismissText, linkText, linkHref) {
            var butterBarStyles = 'width:800px;max-width:80%;background-color:#eee;border:1px solid #3e3e3f; border-radius: 4px; margin:0 auto; padding:20px; text-align:center;';
            var butterWrapperBarStyles = 'position:fixed;width:100%; margin:0; left:0; bottom:60px; z-index:10001!important;';


            var cookieConsentElement = document.createElement('div');
            cookieConsentElement.id = cookieConsentId;
            cookieConsentElement.style.cssText = butterBarStyles;
            cookieConsentElement.appendChild(_createConsentText(cookieText));

            var cookieWrapperConsentElement = document.createElement('div');
            cookieWrapperConsentElement.id = cookieConsentId;
            cookieWrapperConsentElement.style.cssText = butterWrapperBarStyles;
            cookieWrapperConsentElement.appendChild(cookieConsentElement);

            if (!!linkText && !!linkHref) {
                cookieConsentElement.appendChild(_createInformationLink(linkText, linkHref));
            }
            cookieConsentElement.appendChild(_createDismissLink(dismissText));
            return cookieWrapperConsentElement;
        }

        function _createDialogElement(cookieText, dismissText, linkText, linkHref) {
            var glassStyle = 'position:fixed;width:100%;height:100%;z-index:999;' +
                'top:0;left:0;opacity:0.5;filter:alpha(opacity=50);' +
                'background-color:#ccc;';
            var dialogStyle = 'z-index:1000;position:fixed;left:50%;top:50%';
            var contentStyle = 'position:relative;left:-50%;margin-top:-25%;' +
                'background-color:#fff;padding:20px;box-shadow:4px 4px 25px #888;';

            var cookieConsentElement = document.createElement('div');
            cookieConsentElement.id = cookieConsentId;

            var glassPanel = document.createElement('div');
            glassPanel.style.cssText = glassStyle;

            var content = document.createElement('div');
            content.style.cssText = contentStyle;

            var dialog = document.createElement('div');
            dialog.style.cssText = dialogStyle;

            var dismissLink = _createDismissLink(dismissText);
            dismissLink.style.display = 'block';
            dismissLink.style.textAlign = 'right';
            dismissLink.style.marginTop = '8px';

            content.appendChild(_createConsentText(cookieText));
            if (!!linkText && !!linkHref) {
                content.appendChild(_createInformationLink(linkText, linkHref));
            }
            content.appendChild(dismissLink);
            dialog.appendChild(content);
            cookieConsentElement.appendChild(glassPanel);
            cookieConsentElement.appendChild(dialog);
            return cookieConsentElement;
        }

        function _setElementText(element, text) {
            if (supportsTextContent) {
                element.textContent = text;
            } else {
                element.innerText = text;
            }
        }

        function _createConsentText(cookieText) {
            var consentText = document.createElement('span');
            _setElementText(consentText, cookieText);
            return consentText;
        }

        function _createDismissLink(dismissText) {
            var dismissLink = document.createElement('a');
            _setElementText(dismissLink, dismissText);
            dismissLink.id = dismissLinkId;
            dismissLink.href = '#';
            dismissLink.style.marginLeft = '16px';
            return dismissLink;
        }

        function _createInformationLink(linkText, linkHref) {
            var infoLink = document.createElement('a');
            _setElementText(infoLink, linkText);
            infoLink.href = linkHref;
            infoLink.target = '_top';
            infoLink.style.marginLeft = '16px';
            return infoLink;
        }

        function _dismissLinkClick() {
            _saveUserPreference();
            _removeCookieConsent();
            return false;
        }

        function _showCookieConsent(cookieText, dismissText, linkText, linkHref, isDialog) {
            if (_shouldDisplayConsent()) {
                _removeCookieConsent();
                var consentElement = (isDialog) ?
                    _createDialogElement(cookieText, dismissText, linkText, linkHref) :
                    _createHeaderElement(cookieText, dismissText, linkText, linkHref);
                var fragment = document.createDocumentFragment();
                fragment.appendChild(consentElement);
                document.body.appendChild(fragment.cloneNode(true));
                document.getElementById(dismissLinkId).onclick = _dismissLinkClick;
            }
        }

        function showCookieConsentBar(cookieText, dismissText, linkText, linkHref) {
            _showCookieConsent(cookieText, dismissText, linkText, linkHref, false);
        }

        function showCookieConsentDialog(cookieText, dismissText, linkText, linkHref) {
            _showCookieConsent(cookieText, dismissText, linkText, linkHref, true);
        }

        function _removeCookieConsent() {
            var cookieChoiceElement = document.getElementById(cookieConsentId);
            if (cookieChoiceElement != null) {
                cookieChoiceElement.parentNode.removeChild(cookieChoiceElement);
            }
        }

        function _saveUserPreference() {
            // Set the cookie expiry to one year after today.
            var expiryDate = new Date();
            expiryDate.setFullYear(expiryDate.getFullYear() + 1);
            document.cookie = cookieName + '=y; expires=' + expiryDate.toGMTString() + '; path=/';
        }

        function _shouldDisplayConsent() {
            // Display the header only if the cookie has not been set.
            return !document.cookie.match(new RegExp(cookieName + '=([^;]+)'));
        }

        var exports = {};
        exports.showCookieConsentBar = showCookieConsentBar;
        exports.showCookieConsentDialog = showCookieConsentDialog;
        return exports;
    })();

    window.cookieChoices = cookieChoices;
    return cookieChoices;
})(this);

/**/
document.addEventListener('DOMContentLoaded', function(event) {
    if (hultsfred_object != null && hultsfred_object["cookie_accept_enable"] == "1") {
        if (hultsfred_object["cookie_text"] != "" && hultsfred_object["cookie_button_text"] != "" && hultsfred_object["cookie_link_text"] != "" && hultsfred_object["cookie_link"] != "") {
            cookieChoices.showCookieConsentBar(hultsfred_object["cookie_text"], hultsfred_object["cookie_button_text"], hultsfred_object["cookie_link_text"], hultsfred_object["cookie_link"]);
        }
    }
});
