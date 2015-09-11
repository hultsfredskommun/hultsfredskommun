//used by dynamic load 
var settings = new Array();

(function($) {

var currPageTitle = $("head").find("title").html();
var havePushed = false;
var t_ajaxsearch;
var isLessThanIE9 = !$.support.leadingWhitespace;
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
 * redirect if mobile_rewrite is set
 */
window.onload = function(event) {
	if (event !== undefined) {
		event.stopPropagation(true);
	}
	if (isMobile.any() && (hultsfred_object["mobile_rewrite"] != undefined && hultsfred_object["mobile_rewrite"] != "" && window !== undefined)) {
		window.location.href = hultsfred_object["mobile_rewrite"];
	}
};


/**
 * search suggest 
 */
 /*
$.fn.searchSuggest = function()
{
	var sTimer;
	var newSearch = "";
	var oldSearch = "";
	var searching = false;
	var container = $(this).parent().find('#search-suggestion');
	
	//Stores synonyms in multiarray syn
	var nr = hk_options['syn_nr'];
	var syn = new Array();
	for (var i = 0; i < nr; i++){
		var tmp = hk_options['syn_'+i]['synonyms'];
		tmp = tmp.split(",");
		syn.push(tmp);
	}
	
	//function that checks the input for
	//matching synonyms and displays them
	function checkInput(inputBox){
		newSearch = $(inputBox).val();
		
		if(searching){
			if(newSearch != oldSearch){
				clearTimeout(sTimer);
			}
			else{
				return false;
			}
		}
		
		searching = true;
		$(inputBox).addClass("search_in_progress");
		$(container).hide().html(""); //emptying container
		
		if( newSearch.length >= 4 ){
			oldSearch = newSearch;
			
			var terms = newSearch.split(" "); //split searchterms into array
			//loop through synonyms and look for match
			for(var i = 0; i < nr; i++){
				var found = false;
				for(j in syn[i]){
					var syno = syn[i][j].replace(" ", "");
					for(n in terms){
						if( terms[n].length >= 4 ){
							terms[n] = terms[n].replace(" ", ""); //remove spaces that remains
							if( terms[n] == syno )
							{
								found = true;
							}
						}
					}
				}
				if(found){
					if( $(container).find('ul').length <= 0 ){
						var ul = $('<ul>');
						for(j in syn[i]){
							var a = $('<a>').html(syn[i][j].replace(" ", ""));
							var li = $('<li>').html(a);
							$(ul).append(li);
							//console.log($(li).html());
						}					
						$(container).html(ul);
					}
					else{
						var ul = $(container).find('ul');
						for(j in syn[i]){
							var a = $('<a>').html(syn[i][j].replace(" ", ""));
							var li = $('<li>').html(a);
							$(ul).append(li);
							//console.log($(li).html());
						}
					}
				}
			}
			
			//delaying the loading-image and the displaying of the results
			sTimer = setTimeout(function(){
				searching = false;
				$(inputBox).removeClass("search_in_progress");
				if( $(container).find('ul').length > 0 ){
					$(container).show();
				}
			}, 800);
			return false;
		}
		else{ //if input.length less than 4 chars
			searching = false;
			$(inputBox).removeClass("search_in_progress");
			return false;
		}
	}
	
	//call from search-field when content changes
	$(this).keyup( function(){
		checkInput(this);
	});
	
	//when search-field gets selected
	$(this).focus(function(){		
		if( $(container).html() != "" ){
			$(container).show();
		}
		else{
			$(container).hide();
		}
	});
	
	//when search-field gets deselected
	$(this).blur(function(){
		$(container).hide();
		$(this).removeClass("search_in_progress");
	});
	
	return false;
};
*/

/**
 * browser history helpers
 */
function resetHistory(){
	// reset webbrowser history
	history.replaceState(null, currPageTitle, hultsfred_object["currPageUrl"]);
	log("(reset) history.replaceState(null, "+currPageTitle+", "+hultsfred_object["currPageUrl"]+")");
	return false;
}
function pushHistory(title, url){
	if( url != hultsfred_object["currPageUrl"] && !havePushed ){
		history.pushState({}, title, url);
		log("(push if) history.pushState(null, "+title+", "+url+")");
		havePushed = true;
	}
	else if( url != hultsfred_object["currPageUrl"] ){
		history.replaceState({}, title, url);
		log("(push else) history.replaceState(null, "+title+", "+url+")");
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
				$(this).height(height).gmap({scrollwheel: false, center: coordinates, zoom: 15, callback: function() {
					var self = this;
					self.addMarker({'position': this.get('map').getCenter()}).unbind("click").bind("click",function() {
						self.openInfoWindow({ 'content': address}, this);
					});
				}});
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
					$(".close-contact").unbind("click").bind("click",function() {
						$(".contact-popup").remove();
					});

					$(".contact-popup.overlay").unbind("click").bind("click",function() {
						$(".contact-popup").remove();
					});

					height = $(".contact-popup").height();
					$(".contact-popup .map_canvas").height(height).gmap({scrollwheel: false, center: coordinates, zoom: 15, callback: function() {
						var self = this;
						self.addMarker({'position': this.get('map').getCenter()}).unbind("click").bind("click",function() {
							self.openInfoWindow({ 'content': address}, this);
						});
					}});
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
		}
		else {
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
		}
		else {
			if ($(this).find('.slide').length > 1) {
				
				/* set up slideshow first time */
				if (!$(this).hasClass("initialized")) {
					$(this).show();
					rand = Math.floor((Math.random()*1000)+1);
					$(this).find(".prevslide").addClass("prev"+rand);
					$(this).find(".nextslide").addClass("next"+rand);
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
						prev:   '.prev' + rand, 
						next:   '.next' + rand
					};

						
					// if pager should be added
					if (!$(this).hasClass("nopager")) {
						$(this).append('<div class="pager-wrapper pager-wrapper-'+rand+'"><ul class="pager pager'+rand+'"></ul><span class="pager-pause pause-icon"></span></div>');
						$('.pager-wrapper-'+rand+' .pager-pause').click(function() {
							if ($(this).hasClass("paused")) {
								$(this).parents('.slideshow').cycle('resume');
								$(this).removeClass("paused")
							} else {
								$(this).parents('.slideshow').cycle('pause');
								$(this).addClass("paused")
							}
						});
						
						args['pager'] =  '.pager' + rand;
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

					
					$(this).cycle( args );

					$(this).addClass("initialized");
				}
				else {
					/* just resume if already initialized */
					$(this).cycle( 'resume' );
				}
				
			}
		}
	}
}
else {
	alert("ERROR: The function $.fn.slideshow already exists");
}

/**
 * close all articles function
 */
function closeAllArticles()
{
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
function getHistoryTitle(article)
{
	entry_title = $(article).find(".entry-title a").html();
	blog_title = $("#logo").find('img').attr('alt');
	return entry_title + " | " + blog_title;
}
function readMoreToggle(el){
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
		contactAction(el,null);
		return false;
	}
	
	//toggle function
	function toggleShow(article) {
		// close article and show summary content
		if ( $(article).hasClass("full") )
		{
			// remove close-buttons
			$(article).find('.js-close-button').remove();
			
			$(article).find('.more-content').slideUp(0, function(){
				
				// remove full class to track article state
				$(this).parents("article").removeClass("full").addClass("summary");

				$(this).parents("article").find('.summary-content').slideDown(0, function(){
					if ($(document).scrollTop() > $(this).parents("article").position().top - $('#wpadminbar').height() || 0) {
						$("html,body").animate({scrollTop: -30 + $(this).parents("article").position().top - ($('#wpadminbar').height() || 0)}, 200);
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
			
			$(article).find('.summary-content').slideUp(0, function(){
	
				
				// add full class to track article state
				$(this).parents("article").addClass("full").removeClass("summary");
				$(this).parents("article").find('.more-content').slideDown(0, function(){
					
					
					// animate to top of article
					$("html,body").animate({scrollTop: -30 + $(this).parents("article").position().top - $('#wpadminbar').height() || 0}, 200);
					
					if ($(this).parents("article").find(".js-close-button").length >= 1)
						$(this).parents("article").find(".js-close-button").remove();
						
						
					//add close-button at top
					var closea = $("<a>").addClass('js-close-button close-link').attr("href","#").html("<span class='close-icon'></span>St&auml;ng").unbind("click").bind("click",function(ev){
						ev.preventDefault();
						readMoreToggle( $(this).parents("article").find(".entry-title a") );
					});
					$(this).parents("article").find(".header-tools .close-button-item").append(closea);

					//add close-button at bottom
					var closeb = $('<a>').addClass('js-close-button close-link').attr("href","#").html("<span class='close-icon'></span>St&auml;ng").unbind("click").bind("click",function(ev){
						ev.preventDefault();
						readMoreToggle( $(this).parents("article").find(".entry-title a") );
					});
					$(this).parents("article").find(".entry-meta").append(closeb);

					// articles slideshow
					$(this).slideshow();					

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

	if( !$(article).hasClass("loaded") && !$(article).hasClass("loading") ) {
		//add class loading
		$(article).addClass("loading"); //.html("Laddar...");
		
		//find posts id and store it in variable
		var post_id = $(article).find(".article_id").html();
	
		//create a new div with requested content
		var morediv = $("<div>").attr("class","more-content").hide();
		
		//append div after summary-content
		$(article).find('.summary-content').after(morediv);

		$.ajaxSetup({cache:false});
		$(article).addClass("muted wait");
		
		$(morediv).load(hultsfred_object["templateDir"]+"/ajax/single_post_load.php",{id:post_id,blog_id:hultsfred_object["blogId"]}, function()
		{
			// get plugin WP Lightbox 2 by Pankaj Jha to work with dynamical click
			var haveConf = (typeof JQLBSettings == 'object');
			if (haveConf && !$(this).attr("jqlbloaded")) {
				$(this).attr("jqlbloaded",true);
				if(haveConf && JQLBSettings.resizeSpeed) {
					JQLBSettings.resizeSpeed = parseInt(JQLBSettings.resizeSpeed);
				}
				if(haveConf && JQLBSettings.marginSize){
					JQLBSettings.marginSize = parseInt(JQLBSettings.marginSize);
				}
				var default_strings = {
					help: ' Browse images with your keyboard: Arrows or P(revious)/N(ext) and X/C/ESC for close.',
					prevLinkTitle: 'previous image',
					nextLinkTitle: 'next image',
					prevLinkText:  '&laquo; Previous',
					nextLinkText:  'Next &raquo;',
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
			
			// contact form 7
			if ( $('div.wpcf7 > form').length > 0 ) {
				if ( typeof $('div.wpcf7 > form').wpcf7InitForm == 'function' ) {
					$('div.wpcf7 > form').wpcf7InitForm();
				}
			}

			//set quick-links to related and contact
			setQuickLinks($(el).parents("article"));

			// set click action on content header tools
			if (typeof addthis != "undefined") {
				addthis.toolbox('.addthis_toolbox');
			}
			if (typeof rspkr != "undefined") {
				rspkr.ui.addClickEvents();
			}
			
			$(this).parents("article").find(".js-toggle-dropdown").unbind("click").bind("click",function(ev) {
				ev.preventDefault();
				if ($(this).next().is(":visible")) {
					$(this).next().fadeOut();
				}
				else {
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
			$(this).parents("article").find(".js-toggle-article").unbind("click").bind("click",function(ev){
				ev.preventDefault();
				readMoreToggle( $(this).parents("article").find(".entry-title a") );
			});

			$(this).parents("article").removeClass("muted wait");
			
			
			// All is loaded
			$(this).parents("article").removeClass("loading").addClass("loaded");

			//exec toggle function
			toggleShow($(this).parents("article"));
		});
	}
	else if( $(article).hasClass("loaded") ){
		toggleShow($(article));
	}
	return false;
}






//Webkit använder sig av ett annat sätt att mäta brädden på skärmen,
//om inte webbläsaren använder webkit så kompenseras det med värdet 17
var scrollbar = $.browser.webkit ? 0 : 17;
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

/* enter the active element in flip array */
/*function flipAnimation(active) {
	var image_width = $(active).width();
	var margin = image_width / 2 + 'px';
	var compress_css_properties = {
		width: 0,
		marginLeft: margin,
		opacity: 0.3
	};
	var decompress_css_properties = {
		width: image_width,
		marginLeft: 0,
		opacity: 1
	};
	if ($(active).next() != "")
		$(active).next().css(compress_css_properties);
	else
		$(active).first().css(compress_css_properties);

	$(active).click(function() {
		//animate width to 0 and margin-left to 1/2 width
		$(this).stop().animate(compress_css_properties, 1000, function() {
			// animate second card to full width and margin-left to 0  
			$(this).hide();
			$(this).next().show().animate(decompress_css_properties, 1000);
			flipAnimation($(this));
		});
	});
}*/

/* case insensitive contain */
$.extend($.expr[':'], {
  'containsi': function(elem, i, match, array) {
	return (elem.textContent || elem.innerText || '').toLowerCase()
		.indexOf((match[3] || "").toLowerCase()) >= 0;
  }
});

$(document).ready(function(){
	if (isLessThanIE9) {
		$(".branding").before("<div style='padding: 12px; width: 100%; background: red; color: white;'>Du anv&auml;nder en gammal webbl&auml;sare. Vissa funktioner kommer inte fungera.</div>");
	}

	/**
	 * Tag list functionality - collapse/expand
	 */
	//if in tag list
	if ($(".tag-listing").length > 0) {
		// collapse list if more items than 10
		hidden_stuff = false;
		$(".page-title").append("<div class='float--left half-margin--bottom tag-tools one-whole'></div>");
		
		if ($("ul.indent1 li, ul.indent2 li, ul.indent3 li, ul.indent4 li, ul.indent5 li").length > 10) {
			hidden_stuff = true;
			// hide wrappers all wrappers but level 1
			$(".wrapper2, .wrapper3, .wrapper4, .wrapper5, .wrapper6").hide();
			// set the click toggle action and +-sign to header
			$("h2.indent2, h3.indent3, h4.indent4, h5.indent5, h6.indent6").each(function() {
				if ($(this).next().hasClass("wrapper")) {
					$(this).append(" <span class='sign'>+</span>");
					$(this).css("cursor","pointer").click(function() {
						$(this).next().toggle();
						if ($(this).next().is(":visible")) {
							$(this).find(".sign").html("-");
						} else {
							$(this).find(".sign").html("+");
						}
					});
				}
			});
			
			// and collapse level 1 list
			// hide the ul
			$("ul.indent1").hide();
			// set the click action and +-sign to h1
			$("h1.indent1").each(function() {
				if ($(this).next().children().first().hasClass("indent1")) {
					$(this).append(" <span class='sign'>+</span>");
					$(this).css("cursor","pointer").click(function() {
						$(this).next().children().first().toggle();
						if ($(this).next().next().is(":visible")) {
							$(this).find(".sign").html("-");
						} else {
							$(this).find(".sign").html("+");
						}
					});
				}
			});			
		}
		// add expand all button
		if (hidden_stuff) {
			$(".tag-tools").append("<span class='float--right hand js-expand-all-tags zeta'>[visa alla]</span>");
			$(".js-expand-all-tags").click(function() {
				if (!$(this).hasClass("expanded")) {
					$(".wrapper2, .wrapper3, .wrapper4, .wrapper5, .wrapper6, ul.indent1").show();
					$(this).addClass("expanded").html("[st&auml;ng alla]");
					$(".tag-listing").find(".sign").html("-");
					$(".tag-listing li").show();
					$('#filter').val('');
					$('#rensa').hide();
				} else {
					$(".wrapper2, .wrapper3, .wrapper4, .wrapper5, .wrapper6, ul.indent1").hide();
					$(this).removeClass("expanded").html("[visa alla]");
					$(".tag-listing").find(".sign").html("+");
				}
			});
		}
		
		// add filter button
		$(".tag-tools").append("<div class='js-filter-tags zeta filter tool'></div>");
		$(".filter.tool").append("<span class='float--left half-margin--right'>filtrera</span>");
		$(".filter.tool").append("<input class='float--left' type='text' name='filter' id='filter' />");
		$(".filter.tool").append("<span class='float--left delete-icon rensa hand hidden half-margin--left' style='margin:0' id='rensa'></span>");
		$('#filter').focus();
		$('#rensa').click(function() {
			$('#filter').val('');
			$('#rensa').hide();
			$('#filter').focus();
			filter_tags();
		});
		

		$("#filter").keyup(function(ev) {
			$('#rensa').show();
			filter_tags();
		});
		function filter_tags() {
			filter = $('#filter').val().toLowerCase();
			
			// show all
			$(".wrapper2, .wrapper3, .wrapper4, .wrapper5, .wrapper6, ul.indent1").show();
			$(".tag-listing .js-expand-all-tags").removeClass("expanded").html("[visa alla]");
			$(".tag-listing").find(".sign").html("-");

			// hide not contains
			$(".tag-listing li:not(:containsi('"+filter+"'))").hide();
			// show contains
			$(".tag-listing li:containsi('"+filter+"')").show();
		}

	} // end tag-listing


	/**
	 * debug count and version log 
	 */
		/*function doCount() {
			
			$.getJSON( "http://smart-ip.net/geoip-json?callback=?",
				function(data){
					browser = "other";
					if ($.browser.webkit)
						browser = "webkit-" + $.browser.version;
					else if ($.browser.msie)
						browser = "msie-" + $.browser.version;
					else if ($.browser.opera)
						browser = "opera-" + $.browser.version;
					else if ($.browser.mozilla)
						browser = "mozilla-" + $.browser.version;
					else if ($.browser.safari)
						browser = "safari-" + $.browser.version;

					data = {action: 'hk_count', version: $("#version-2").length, browser: browser, ip: data.host };
					jQuery.ajax({
						type: 'POST',
						url: hultsfred_object["admin_ajax_url"], //"/wp/info/wp-admin/admin-ajax.php", // our PHP handler file
						data: data,
						dataType: 'html',
						success:function(response){
							log(response);
						},
						error:function(response){
							log("error: " + response);
						}
					});
				}
			);
		}
		doCount();*/
		
	/**
	 * show refresh alert if old/cached html 
	 */
	if ($("#version-2").length <= 0) {
		function newVersion() {
			$(".top-menu-wrapper").before("<div class='wrong-version one-whole island important-background white-text flush--bottom hidden'>Du ser en gammal version av webbplatsen. Klicka <a class='white-text' style='text-decoration:underline' href='#'>h&auml;r</a> eller uppdatera webbl&auml;saren f&ouml;r att se den nya.</div>");
			$(".wrong-version").slideDown("slow").find("a").click(function() {
				location.reload(true);
				return false;
			});
		}
		setTimeout(newVersion,2000);
	}
	
	var wpadminbarheight = $("#wpadminbar").height();
		
	//Stores the window-width for later use
	oldWidth = $(window).width();

	
	/** 
	 * fix placeholder text in ie9 and lower
	 */
	if ($(".login-action-login").length == 0  && $.browser.msie && parseInt($.browser.version, 10) <= 9) { 
		var active = document.activeElement;
		$(':text').focus(function () {
			if ($(this).attr('placeholder') != '' && $(this).val() == $(this).attr('placeholder')) {
				$(this).val('').removeClass('hasPlaceholder').css("color","#3f3f3f");
			}
		}).blur(function () {
			if ($(this).attr('placeholder') != '' && ($(this).val() == '' || $(this).val() == $(this).attr('placeholder'))) {
				$(this).val($(this).attr('placeholder')).addClass('hasPlaceholder').css("color","#999");
			}
		});
		$(':text').blur();
		$(active).focus();
		$('form:eq(0)').submit(function () {
			$(':text.hasPlaceholder').val('');
		});
	}
	
	/** 
	 * aditro scrolling on first page
	 */
	//flipAnimation($(".widget_hk_aditro_rss_widget .entry-wrapper:first"));
	
	/**
	 * load typekit if any
	 */	 
	if ( !($.browser.msie && parseInt($.browser.version, 10) < 9)) {
		try { Typekit.load(); } catch(e) {}
	}
	
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
	setQuickLinks($(document));

	/**
	 * set click action on content header tools
	 */
	$(".js-toggle-dropdown").unbind("click").bind("click",function(ev) {
		ev.preventDefault();
		if ($(this).next().is(":visible")) {
			$(this).next().fadeOut();
		}
		else {
			$(".js-toggle-dropdown").next().fadeOut();
			$(this).next().fadeIn();
		} 
	});

	
	
	
	/**
	 * history url handling
	 */ 
	/*History.Adapter.bind(window,'popstate',function(evt){
		//alert(evt.state);
		var State = History.getState();
		History.log(State);
		if(evt.state !== null && evt.state !== undefined){	
			window.location = State.url;
		}
	});*/
	
	//url clean-up and history-fix
	/*if( !$("body").hasClass("single") && !$("body").hasClass("page") ){
		//do a clean-up that removes the hash (tags, sort m.m.)
		var title = $("html head title").html();
		History.replaceState(null, title, hultsfred_object["currPageUrl"]);
	}*/


	/**
	 * view-modes 
	 */
	// show framed articles click action
	$(".js-view-summary").unbind("click").bind("click",function(ev){
		$("#content").addClass("viewmode-only-titles");
		$(".js-view-titles").removeClass("active");
		$(".js-view-summary").addClass("active");
		ev.preventDefault();
	});
	// show only title click action
	$(".js-view-titles").unbind("click").bind("click",function(ev){
		$("#content").removeClass("viewmode-only-titles");
		$(".js-view-titles").addClass("active");
		$(".js-view-summary").removeClass("active");
		ev.preventDefault();
	});
	
	
	/** 
	 * add action to read-more toggle, if in .home or in lt ie9, go to article 
	 */
	$("#primary, #firstpage-top-content").find("article").each(function(){
		if (!$(this).parents(".home").length && !$(this).parents(".search").length && !isLessThanIE9) {
			setArticleActions($(this));
		} else {
			$(this).unbind("click").bind("click",function() {
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
	if ($('.slideshow-contact-puff-area').find('.slide').length == 0 && $('.slideshow-contact-puff-area').find('.contact-puffs').length > 0){
		$('.slideshow-contact-puff-area').height($('.slideshow-contact-puff-area').width() * 326 / 1138);
	}
	if ($('.slideshow-contact-puff-area').find('.slide').length >= 1 && $('.slideshow-contact-puff-area').find('.contact-puffs').length > 0){
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
	$(window).scroll(function () {
	
		/* load next pages posts dynamically when reaching bottom of page */
		/*if( !$("body").hasClass("home") && parseInt($(this).scrollTop()) > parseInt($(document).height() - $(window).height()*2 - $("#colophon").height()) ) {
	
			if ($("#dyn-posts-load-posts").length <= 0 && !$("#shownposts").hasClass("loaded")) {
			
				dyn_posts_load_posts();
			}
		}*/
		
		
		/* show scroll to top icon */
		if( $(this).scrollTop() > 300 ) {
			$('#scrollTo_top').fadeIn(300);
		}
		else {
			$('#scrollTo_top').fadeOut(300);
		}

		
		/* stick menu to top */
		//if( $(this).scrollTop() > wpadminbarheight ) {
		//	$('#branding').css("position", "fixed").css("top", wpadminbarheight + "px"); /*.css("border-top-left-radius","0").css("border-top-right-radius","0").css("border-bottom-left-radius","10px").css("border-bottom-right-radius","10px")*/
		//}
		//else {
		//	$('#branding').css("position", "initial").css("top","initial"); /*.css("border-top-left-radius","10px").css("border-top-right-radius","10px").css("border-bottom-left-radius","0").css("border-bottom-right-radius","0")*/
		//}

		
		/*
		if( $(this).scrollTop() > 180 ) {
			$('#nav-sidebar').css("position", "fixed").css("top", "69px").css("width", "17%");
		}
		else {
			$('#nav-sidebar').css("position", "initial").css("width", "100%");
		}
		*/
	});
	$('#scrollTo_top a').unbind("click").bind("click",function(){
		$('html, body').animate({scrollTop:0}, 500 );
		return false;
	});
	/* END scroll to top  */


	/**
	 * Responsive top navigation bar
	 */
	$(".js-show-main-menu").unbind("click").bind("click",function(ev) {
		$(".main-menu").toggleClass("unhidden");
		ev.preventDefault();
	});
	$(".js-show-main-sub-menu").unbind("click").bind("click",function(ev) {
		$(".category-navigation").toggleClass("unhidden");
		ev.preventDefault();
	});
	$(".js-show-search").unbind("click").bind("click",function(ev) {
		$(".searchnavigation").toggleClass("unhidden");
		ev.preventDefault();
	});

	
	/**
	 * nav-sidebar collapsing and expand filters on category and tags
	 */
	 /* TODO TEMP REMOVED
	$(".children").each(function() {
	 	if ($(this).parent().parent().hasClass("parent") && !$(this).parent().hasClass("current-cat") && $(this).parent().find(".current-cat").length == 0) {
			$(this).prev().append("<span class='more-children'>+</span>");
			$(this).hide();		
	 	}
	});
	$(".more-children").each(function() {
		$(this).unbind("click").bind("click",function(ev) {
			ev.preventDefault();
			ev.stopPropagation();
			$(this).parent().parent().find(".children:first").toggle();
		});
	});*/

	/**
	 * first simple test of dynamic search 
	 */
	//$('#s').searchSuggest();
	

	/** 
	 * handle f5 refresh and esc
	 */ 
	$(document).keyup(function(event) { 
		var key = event.keyCode || event.which;
		log(key);
		switch(key) { 
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

	
	
	
	/** 
	 * give result in dropdownlist 
	 */ 
	/*if (!$("#searchform").hasClass("gcse")) {
	
	$('#s').keyup(function(event) { 
		if( $(window).width()+scrollbar > responsive_lap_start ){
			select = false; 
			// do ajax search 

			var key = event.keyCode || event.which;

			switch(key) { 
				case 40: 
					if($(".searchresult a").first().length > 0) 
					{ 
						$(".searchresult a").first().focus(); 
					} 
					event.preventDefault(); 
					select = true; 
					break; 
				case 38: 
					select = true; 
					event.preventDefault(); 
					break; 
				case 39: 
					select = true; 
					event.preventDefault(); 
					break; 
				case 37: 
					select = true; 
					event.preventDefault(); 
					break; 
				case 27: 
					erase_and_refocus_on_search_input(); 
					event.preventDefault(); 
					select = true; 
					break; 
				case 50: 
					select = true; 
					break; 

			}

			// don't search if pressing special keys
			if (!select) {
				
				
				if ($('#s').val().length >= 2)  {
					// wait 600ms before sending request.
					clearTimeout(t_ajaxsearch);
					t_ajaxsearch = setTimeout(ajaxsearch,600);
					
					function ajaxsearch() {
					
						if (!$(".searchresult-wrapper")[0]) 
						{ 
							$('#searchform').after("<div class='searchresult-wrapper'><div class='searchresult with-border'></div></div>"); 
						} 
						searchstring = $("#s").val(); 
						
						$(".searchresult-wrapper .searchresult").html("H&auml;mtar s&ouml;kresultat...").load(hultsfred_object["templateDir"]+"/ajax/search.php", 
						{ searchstring: searchstring }, 
						function() { 

							var link_objects = $('.searchresult li a');

							var first_index = 0;   var last_index = $('.searchresult li a').length-1;

							var first_link = $(link_objects).first();  var last_link = $(link_objects).last();

							var clearbutton = $('.clearbutton'); 

							if($(clearbutton).length == 0) 
							{ 
								clearbutton = $('#s').parent().prepend('<a href="#" class="clearbutton">Rensa</a>'); 
							} 

							// Erase search... 
							$(clearbutton).click(function(event){ 
								event.preventDefault(); 
								erase_and_refocus_on_search_input(); 
							}); 

							$(link_objects).each(function(index, value) {  
							
								var link = this;

								$(this).keydown(function(event){  var key = event.keyCode || event.which;

									event.preventDefault(); 

									switch(key) 
									{ 
										case 40: 

											var next_index = index+1; 

											if(next_index > last_index) 
											{ 
												$(first_link).focus(); 
											} 
											else 
											{ 
												$(link_objects)[next_index].focus(); 
											} 

											break;  
										case 38:

											var prev_index = index-1;

											if(prev_index <= first_index) 
											{ 
												$('#s').focus(); 
											} 
											else 
											{ 
												$(link_objects)[prev_index].focus(); 
											} 
											break; 

										case 27: 
											erase_and_refocus_on_search_input(); 
											break; 

										case 13: 
											window.location = $(this).attr('href'); 
											break; 

									}

								});

							});
						}); 
						 //$("#primary").load("/wordpress/?s="+$('#s').val()+"&submit=Sök #content", function() { 
						 // $(this).find('.readMoreToggleButton').each( function(){ 
						 // 
						 // initToggleReadMore(this); 
						 // }); 
						 //}); 
					} // end ajaxsearch
				} // end if more than 2 char
				else 
				{ 

					var erase_button = $('.clearbutton');

					if($(erase_button).length > 0) 
					{ 
						$(erase_button).remove(); 
					} 

					$('.searchresult-wrapper').remove(); 
				} 
			} 
		} // if not on palm
	}); 
	
	} */
	// end if gcse

	
	
	


	/*
	 * give result in dropdownlist
	 */
	 /*
	$('#menu li').each(function() {
		$(this).unbind("mouseenter").mouseenter(function() {
			if( $(window).width()+scrollbar > responsive_desk_start ) {
				if ($(this).attr("dropdown-id") === undefined) {
					rand = Math.floor(Math.random()*100000);
					$(this).attr("dropdown-id", rand);
					$(this).parent().after("<div class='menu-item-dropdown' id='menu-item-dropdown-" + rand + "'></div>");				
					href = $(this).find("a").attr("href");
					$("#menu-item-dropdown-" + rand).load(hultsfred_object["templateDir"]+"/ajax/dropdown.php",
					{ href: href },
					function() { 
						$(this).unbind("mouseout").mouseout(function() {
							$(this).hide();
						})
					});

				}
				else {
					$("#menu-item-dropdown-" + $(this).attr("dropdown-id")).show();
				}
			}
		});
	});
	*/
	
	
	//Skriver ut skärmens storlek
	/*log( "$(window).width = " + $(window).width() + ", " +
		"MQ Screensize = " + ($(window).width() + scrollbar) 
	);*//*
	setTimeout( function(){
		clearTimeout(hide);
		$("#log").fadeOut("slow", function() {
			log( "#page: " + $("#page").outerWidth() + ", body: " + $("body").outerWidth() + ", #branding: " + $("#branding").outerWidth() + ", #main: " + $("#main").outerWidth() + ", #colophon: " + $("#colophon").outerWidth() );
		});
	}, 3000);*/


	
	$("#s").focus(function() {
		/**
		 * add ajax searchbox if enabled in settings and not less than ie9
		 */
		if ($(".hk-gcse-ajax-searchbox").length > 0 && $("body.search").length == 0 && !isLessThanIE9) {

			window.__gcse = {
				parseTags: 'explicit',
				callback: hkGcseCallback
			};

			var cx = hultsfred_object["gcse_id"];
			var gcse = document.createElement('script'); gcse.type = 'text/javascript';
			gcse.async = true;
			gcse.src = (document.location.protocol == 'https' ? 'https:' : 'http:') +
			  '//www.google.com/cse/cse.js?cx=' + cx;
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(gcse, s);
		}
		$(this).unbind("focus");
	});
	
	/**
	 * init responsive search hook results
	 */
	initResponsiveSearchHookResult();
	
	/** 
	 * do callbacks if found 
	 */
	if(typeof setSingleSettings == 'function') {
		setSingleSettings();
	}

});/* END $(document).ready() */


/** 
 * gcse ajax callback and helpers
 */ 
var hkGcseCallback = function() {

	if (document.readyState == 'complete') {
		// Document is ready when CSE element is initialized.
		// Render an element with both search box and search results in div with id 'test'.
		google.search.cse.element.render(
		{
			div: 'hksearch',
			tag: 'search'
		});
		hkHandleKeypress();
	} else {
		// Document is not ready yet, when CSE element is initialized.
		google.setOnLoadCallback(function() {
			// Render an element with both search box and search results in div with id 'test'.
			google.search.cse.element.render(
			{
				div: 'hksearch',
				tag: 'search'
			});
			hkHandleKeypress();
		}, true);
	}
};
var hkPreventSubmit = function(e) {
	if(e.keyCode == 13 || e.which == 13) {  
		e.preventDefault();
		log('Enter pressed in search...'); 
		return false;
	}
};
var hkDoSearch = function(e) {
	var key = e.keyCode || e.which;
	
	if ($('#s').val().length == 0 || (key == 27)) {
		$(".hk-gcse-ajax-searchresults-wrapper").hide();
		$(".js-close-search").remove();
		$('#s').val('');
	}
	
	//Reset timer 
	if (t_ajaxsearch != undefined) {
		clearTimeout(t_ajaxsearch);
	}
	if ($('#s').val().length > 0 && (key != 27)) {
		t_ajaxsearch = setTimeout(hkSearch, 400);
	}
};
var hkSearch = function() {
	if ($('#s').val().length == 0) {
		$(".hk-gcse-ajax-searchresults-wrapper").hide();
		$(".js-close-search").remove();
	}
	else {
		$(".hk-gcse-ajax-searchresults-wrapper").show();

		if ($(".js-close-search").length == 0) {
			$(".hk-gcse-ajax-searchresults-wrapper").prepend("<div class='js-close-search close-search close-popup'></div>");
			$(".close-search").unbind("click").bind("click",function() {
				$(".hk-gcse-ajax-searchresults-wrapper").hide();
				$(".js-close-search").remove();
			});
		}
		
		log("Searching for: " + $('#s').val());
		google.search.cse.element.getElement("two-column").prefillQuery($('#s').val());
		google.search.cse.element.getElement("two-column").execute();
		
		if ($(".hk-gcse-ajax-searchresults-wrapper").find(".has-hook").length > 0) {
			data = {action: 'hk_search_hook', searchstring: $('#s').val()};
			jQuery.ajax({
				type: 'POST',
				url: hultsfred_object["admin_ajax_url"],
				data: data,
				dataType: 'html',
				success:function(response){
					$(".hk-gcse-hook-results").html(response);
					// contact popup
					$(".hk-gcse-hook-results").find(".js-contact-link").each(function() {
						setContactPopupAction($(this));
					});
					initResponsiveSearchHookResult();
					//console.log("success: " + response);
				},
				error:function(response){
					log("error: " + response);
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
 
function setQuickLinks(el) {

	if ($(el).find(".contact_title").length > 0)
	{
		$(el).find(".js-quick-link.contact").removeClass("force-hidden");
	}
	if ($(el).find(".related_title").length > 0)
	{
		$(el).find(".js-quick-link.related").removeClass("force-hidden");
	}
	$(el).find(".js-quick-link a").click(function(ev) {
		ev.preventDefault();
		$("html,body").animate({scrollTop: -30 + $("[name='"+$(this).attr("href").substring(1)+"']").position().top - ($('#wpadminbar').height() || 0)}, 200);
	});
}
function setArticleActions(el) {
	

	//sets click-action on entry-titles
	$(el).find('.js-toggle-article').unbind("click").bind("click",function(ev){
		ev.stopPropagation();
		ev.preventDefault();
		if( !$(this).parents('article').hasClass('loading') ){
			readMoreToggle(this);
		}
		else{ return false; }
	});
	
	
	//triggers articles click-action entry-title clicked
	$(el).find(".summary-content .entry-content, .summary-content .img-wrapper").unbind("click").bind("click",function(){
		if ($(this).parents("article").find('.entry-title a').hasClass('js-toggle-article')) {
			readMoreToggle( $(this).parents("article").find('.entry-title a') );
		}
	});
	
	
	//triggers contact click-action 
	$(el).find(".js-contact-link").each(function() {
		setContactPopupAction($(this));
	});
}

/**
 * set contact popup action 
 */
function setContactPopupAction(el) {
	$(el).unbind("click").bind("click",function(ev) {
		if (isLessThanIE9) {
			return true;
		}
		contactAction(el,ev);
		return false;
	});

}
function contactAction(el,ev) {
	if ($(".contact-popup").length == 0) {
		var post_id = $(el).parents(".contact-wrapper").find(".contact_id").html();
		if (post_id === undefined)
			post_id = $(el).parents("article").find(".article_id").html();
		
		// follow link if post_id not found
		if (post_id == null) return true;
		
		if (ev != null)
			ev.preventDefault();
			
		$("#page").append("<div class='contact-popup box'><div class='entry-content islet'>H&auml;mtar kontaktuppgifter...</div></div>").append("<div class='contact-popup overlay'></div>");

		$(".contact-popup.overlay").unbind("click").bind("click",function() {
			$(".contact-popup").remove();
			resetHistory();
		});
		
		if ($(this).attr("href") !== undefined) {
			var thepage = $(this).attr("href");
		}
		$(".contact-popup.box").load(hultsfred_object["templateDir"]+"/ajax/hk_kontakter_load.php",{id:post_id,blog_id:hultsfred_object["blogId"]}, function()
		{
			$(this).find(".entry-wrapper").before("<div class='js-close-contact close-contact close-popup'></div>");
			$(".js-close-contact").unbind("click").bind("click",function() {
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
	}
	else {
		$(this).slideshow("pause");
		$(".contact-popup").remove();
	}
}

/**
 * set contact popup action - link as input el 
 */
function setTextWidgetPopupAction(el) {
	$(el).unbind("click").bind("click",function(ev) {
		if (isLessThanIE9) {
			return true;
		}
		textWidgetAction(el,ev);
		return false;
	});

}

/**
 * Add action to text widget (i.e. popup with overlay if popuptext is found
 */
function textWidgetAction(el,ev) {
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
		$(parentwidget).find(".form-popup.overlay").unbind("click").bind("click",function(ev) {
			$(el).parents(".widget").find(".form-popup.overlay").hide();
		});
		$(parentwidget).find(".form-popup.box").unbind("click").bind("click",function(ev) {
			ev.stopPropagation();
		});
		$(parentwidget).find(".close-contact").unbind("click").bind("click",function() {
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
var loading_next_page = false;
function dyn_posts_load_posts() {
	filter = hultsfred_object["currentFilter"];
				
	if (!loading_next_page) {
		
		loading_next_page = true;
		var shownPosts = $("#shownposts").html();
				
		$('#primary')
			.append('<div id="dyn-posts-placeholder" class="dyn-posts-placeholder"></div>')	

		$('#dyn-posts-placeholder').hide().load(hultsfred_object["templateDir"]+"/ajax/posts_load.php",
			{ shownPosts: shownPosts, filter: filter }, 
			function() {
			
				// do nothing if dyn-posts is empty
				if ($('#dyn-posts-placeholder').html() == "") {
					return;
				}
				$('#dyn-posts-placeholder').prepend("<p>Du har nu sett de mest bes&ouml;kta artiklarna, men leta g&auml;rna vidare i denna lista med resten av ditt urval.</p>");
				
				
				// read-more toggle actions
				$('#dyn-posts-placeholder').find('article').each(function(){
					setArticleActions($(this));
				});
			
				$('#dyn-posts-placeholder').find('.more-link').addClass('dyn-posts').addClass('dyn-posts-placeholder').click(function(ev){
					$('#dyn-posts-placeholder').slideDown("slow");
					ev.preventDefault();
				});
											
				$("#shownposts").addClass("loaded");
				if( $('#dyn-posts-load-posts a').hasClass("loading") ){
					$('#dyn-posts-load-posts a').removeClass("loading").click();
				}
				
				
				// show list when loaded, change to false to show button instead
				if (true) {
					$('#dyn-posts-placeholder').slideDown("slow",function(){
						$('#dyn-posts-placeholder').children(":first-child").unwrap();
						$('#dyn-posts-load-posts').remove();
					});
				} else {
						
					// add button to show more
					$('#dyn-posts-placeholder')
					.before('<p id="dyn-posts-load-posts"><a href="#">Lista alla artiklar fr&aring;n underkategorier</a></p>');

					// Show new posts when the link is clicked.
					$('#dyn-posts-load-posts a').unbind("click").bind("click",function(ev) {
						if($("#shownposts").hasClass("loaded")) {
							$('#dyn-posts-placeholder').slideDown("slow",function(){
								$('#dyn-posts-placeholder').children(":first-child").unwrap();
								$('#dyn-posts-load-posts').remove();
							});
							ev.preventDefault();
						}
						else{ 
							$(this).addClass("loading");
							ev.preventDefault();
						}	
					});
				}
				
			}

		);
	} 	
	
	return false;
};





/**
 * handle browser resize
 */
$(window).resize(function() {
	
	/* scale map */
	$(".map_canvas").height($(".contact-popup").height());

	
	if( oldWidth != $(window).width() ) {
		/*alert($.browser);
		alert($.browser.version <= 9);
		alert(isMobile.any());
		if(($.browser.msie && $.browser.version <= 9) && !isMobile.any()) {
			alert("test");
		}*/
		
		//Skriver ut skärmens storlek
		/*log( $(window).height() + " $(window).width = " + $(window).width() + ", " +
			"MQ Screensize = " + ($(window).width() + scrollbar) 
		);*/
		
		/* reset responsive stuff */
		
		if( $(window).width()+scrollbar > responsive_lap_start ){
			$("ul.main-menu, ul.main-sub-menu").addClass("unhidden");
		}
		else {
			$("ul.main-menu, ul.main-sub-menu").removeClass("unhidden");
		}
		/*
		if( $(window).width()+scrollbar > responsive_lap_start ){
			$("#searchnavigation").addClass("unhide");
		} 
		else {
			$("#searchnavigation").removeClass("unhide");
		}
		*/
	}
	oldWidth = $(window).width();
});

/**
 * helper function
 */

var initResponsiveSearchHookResult = function() {
	if( $(window).width()+scrollbar < responsive_lap_start ){
		$(".js-toggle-search-hook").each(function() {
			toggleHookResult($(this));
			$(this).css("cursor","pointer").append(" <span class='js-toggle-search-expander' style='display:inline-block'>+</span>").click(function() {
				toggleHookResult($(this));
			});
		});
	}
}
var toggleHookResult = function(el) {
	var parent = $(el).parents(".js-toggle-search-wrapper");
	if ($(parent).find(".js-toggle-search-expander").html() == "+") {
		$(parent).find(".js-toggle-search-expander").html("-");
	}
	else {
		$(parent).find(".js-toggle-search-expander").html("+");
	}
	$(parent).find(".search-item").each( function() {
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

