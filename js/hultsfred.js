//used by dynamic load 
var settings = new Array();

(function($) {
// JavaScript Document

var currPageTitle = $("head").find("title").html();
var havePushed = false;

/**
 * print element (TODO not working in IE)
 */
function PrintElem(elem)
{
	Popup($(elem));
}
function Popup(data) 
{
	var a = $(data).find(".entry-title > a");
	var url = $(a).attr("href");
	var printData = $(data).clone( true );
	
	$(printData).find(".readMoreContainer").attr("style", "height: 100%");
	$(printData).find(".readMoreContent").attr("style", "height: 100%");
	$(printData).find("#misc-ctrl").remove();
	$(printData).find(".readMoreContent > footer").remove();
	$(printData).find(".readMoreToggleButton").remove();
	$(printData).find(".closeButton").remove();
	
	$(printData).css({
		"height": "100%",
		"width": "100%",
		"margin": "0"
	});
	
	var mywindow = window.open('', url, 'height=400,width=600');
	mywindow.document.write('<html><head><title>'+ url +'</title>');
	//mywindow.document.write('<link rel="stylesheet" href="'+templateDir+'/style.css" type="text/css" />');
	mywindow.document.write('</head><body >');
	mywindow.document.write( $(printData).html() );
	mywindow.document.write('</body></html>');
	
	mywindow.print();
	mywindow.close();

	return true;
}

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
 * Initialize function resetHistory
 */
/*function resetHistory(){
	// reset webbrowser history
	History.replaceState(null, currPageTitle, hultsfred_object["currPageUrl"]);
	return false;
}*/

/**
 * Initialize function pushHistory
 */
function pushHistory(title, url){
	if( url != hultsfred_object["currPageUrl"] && !havePushed ){
		History.pushState(null, title, url);
		havePushed = true;
	}
	else if( url != hultsfred_object["currPageUrl"] ){
		History.replaceState(null, title, url);
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
					self.addMarker({'position': this.get('map').getCenter()}).unbind("click").click(function() {
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
		if (google !== undefined) {
			$(this).each(function() {
				$(this).find(".coordinates, .address").hide();
				$(this).unbind("click").click( function(ev) {
					ev.preventDefault();
					var coordinates = $(this).find(".coordinates").html();
					var address = $(this).find(".address").html();
					
					$("#page").append("<div class='contact-popup box'><div class='map_canvas'>H&auml;mtar karta...</div></div>").append("<div class='contact-popup overlay'></div>");
			
					// google analytics
					push_google_analytics("#googlemap=" + address + " " + coordinates);

					$(".contact-popup.box").prepend("<div class='close-contact'><i class='i' data-icon='&#xF14E;'></div></div>");
					$(".close-contact").unbind("click").click(function() {
						$(".contact-popup").remove();
					});

					$(".contact-popup.overlay").unbind("click").click(function() {
						$(".contact-popup").remove();
					});

					height = $(".contact-popup").height();
					$(".contact-popup .map_canvas").height(height).gmap({scrollwheel: false, center: coordinates, zoom: 15, callback: function() {
						var self = this;
						self.addMarker({'position': this.get('map').getCenter()}).unbind("click").click(function() {
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
 * Initialize google analytics push function 
 */
if (typeof $.fn.push_google_analytics != 'function') {
	$.fn.push_google_analytics = function() {
		if ($(this).attr("href") !== undefined) {
			push_google_analytics($(this).attr("href"));
		}
	}
}
if (typeof push_google_analytics != 'function') {
	push_google_analytics = function(page) {
		if (hultsfred_object['allow_google_analytics'] && typeof _gaq != 'undefined') {
			_gaq.push(['_setAccount', hultsfred_object['google_analytics']]); 
			_gaq.push(['_setDomainName', hultsfred_object['google_analytics_domain']]);
			_gaq.push(['_trackPageview', page]);
		}
	}
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
					$(this).show("fast");
					rand = Math.floor((Math.random()*1000)+1);
					$(this).find(".prevslide").addClass("prev"+rand);
					$(this).find(".nextslide").addClass("next"+rand);
					// show slide navigation on hover
					$(this).unbind("hover").hover(function() {
						$(this).find(".nextslide, .prevslide, .pager").fadeIn("fast");
						return false;
					},function() {
						$(this).find(".nextslide, .prevslide, .pager").fadeOut("fast");
						return false;
					});

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
						$(this).append('<ul class="pager pager'+rand+'">');
						args['pager'] =  '.pager' + rand;
						// callback fn that creates a thumbnail to use as pager anchor 
						args['pagerAnchorBuilder'] = function(idx, slide) {
							var src = slide.src;
							if (src == undefined)
								src = $(slide).find("img").attr("src");
							return '<li><a href="#"><img src="' + src + '" width="50" height="50" /></a></li>'; 
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
 * Initialize function read-more toggle-button 
 */
function readMoreToggle(el){
	//global var to article
	article = $(el).parents("article");

	//toggle function
	function toggleShow() {
		// show summary content
		
		if ( $(article).hasClass("full") )
		{			
			// alter close-buttons
			$(article).find('.closeButton').remove();
			$(article).find('.openButton').show();
			$(article).find('.more-content').slideUp(200, function(){
				
				
				// toggle visibility
				$("html,body").animate({scrollTop: $(article).position().top}, 200);
				
				// remove full class to track article state
				$(article).removeClass("full").addClass("summary");

				$(article).find('.summary-content').slideDown(200, function(){
					
				});

				$(article).slideshow('pause');
			});
			
			// reset webbrowser history
			//resetHistory();
			//History.replaceState(null, title, hultsfred_object["currPageUrl"]);
		}
		// show full content
		else {
			// toggle visibility
			$(article).find('.summary-content').slideUp(200, function(){
	
				// add full class to track article state
				$(this).parents("article").addClass("full").removeClass("summary");
				$(this).parents("article").find('.more-content').slideDown(200, function(){
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
					
					$(article).find('.openButton').hide();
					//add close-button top right corner
					var closea = $('<div>').addClass('closeButton button top').html("<i class='i' data-icon='&#xF148;'></i><a href='#'>Visa mindre</a>").unbind("click").click(function(ev){
						ev.preventDefault();
						readMoreToggle( $(this).parents("article").find(".entry-title a") );
					});
					var closeb = $('<div>').addClass('closeButton button bottom').html("<i class='i' data-icon='&#xF148;'></i><a href='#'>Visa mindre</a>").unbind("click").click(function(ev){
						ev.preventDefault();
						readMoreToggle( $(this).parents("article").find(".entry-title a") );
					});
					$(this).parents("article").prepend(closea).append(closeb);
					
					// scroll to top of post 
					$("html,body").animate({scrollTop: $(this).parents("article").position().top}, 150);

					// articles slideshow
					$(this).slideshow();
					

				});
			});
			
			//change webbrowser url
			//find and store post-title and post-url
			var entry_title = $(article).find(".entry-title");
			var blog_title = $("#logo").find('img').attr('alt');
			var title = $(entry_title).find("a").html().replace("&amp;","&") + " | " + blog_title;
			var url = $(entry_title).find("a").attr("href");
			//call pushHistory
			//pushHistory(title, url);
			//History.replaceState(null, title, url);
		}
	}

	if( !$(article).hasClass("loaded") ){
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
			// google analytics
			$(this).parents("article").find(".entry-title a").push_google_analytics();
			
			// load google map
			$(this).parents("article").find(".map_canvas").googlemap();
			$(this).parents("article").find(".map_link").googlemaplink();
			
			// contact popup
			$(this).find(".js-contact-click").each(function() {
				setContactPopupAction($(this));
			});

			$(this).parents("article").removeClass("muted wait");
			
			//****** click-actions START *******
			
			//set click-action on print-post-link
			var print_link = $(this).find(".print-post");
			$(print_link).unbind("click").click(function(ev){
				PrintElem( $(this).attr("elem-id") );
				ev.preventDefault();
			});
			
			//***** click-actions END ******
			
			// All is loaded
			$(this).parents("article").removeClass("loading").addClass("loaded");

			//exec toggle function
			toggleShow();
		});
	}
	else{
		toggleShow();
		return false;
	}
}






//Webkit använder sig av ett annat sätt att mäta brädden på skärmen,
//om inte webbläsaren använder webkit så kompenseras det med värdet 17
var scrollbar = $.browser.webkit ? 0 : 17;
var responsive_mobil_size = 480;
var responsive_small_size = 650;

var hide; //used by Timeout to hide #log
var oldWidth; //used to check if window-width have changed

//$.expander.defaults.slicePoint = 20;




$(document).ready(function(){
	var wpadminbarheight = $("#wpadminbar").height();
		
	//Stores the window-width for later use
	oldWidth = $(window).width();

	
	/*
	 * load typekit if any
	 */
	try { Typekit.load(); } catch(e) {}
	
	/*
	 * open print dialog if on print page
	 */
	if ($("body").hasClass("print")) {
		window.print();
		window.close();
	}

	/* 
	 * add responsive menu 
	 */
	responsive_menu()
	
	
	/**
	 * Expand article if only one, not on home page
	 */
	if ($('.archive').find("article").length == 1 && $(this).parents(".home").length) {
		readMoreToggle($('.archive').find("article .entry-title a"));
	}


	/**
	 * Fix scroll to top on single and page
	 */
	$('html, body').animate({scrollTop:0}, 0);


	/**
	 * tabs action
	 */
	if (typeof $.fn.tabs == 'function') {
		$(".home #content,.home #quickmenus").tabs();
	}

	
	
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
	/*$("#viewmode").unbind("hover").hover(function() {
		$(this).append("<div id='all_title_div'></div>");
		$("#content article .entry-title").each(function() {
			if ($(this).find("a").length > 1) {
				$("#all_title_div").append($(this).html());	
			}
		});
		$("#all_title_div a.post-edit-link").remove(); // cleanup if edit links added
	}, function() {
		$("#all_title_div").remove();
	});*/
	$(".js-view-summary").unbind("click").click(function(ev){
		$("#content").removeClass("viewmode-only-titles");
		$(".js-view-titles").removeClass("hide");
		$(".js-view-summary").addClass("hide");
		ev.preventDefault();
	});
	// show only title click action
	$(".js-view-titles").unbind("click").click(function(ev){
		$("#content").addClass("viewmode-only-titles");
		$(".js-view-titles").addClass("hide");
		$(".js-view-summary").removeClass("hide");
		ev.preventDefault();
	});
	
	
	/* add action to read-more toggle, if in .home go to article */
	$("#primary").find("article").each(function(){
		if (!$(this).parents(".home").length) {
			setArticleActions($(this));
		} else {
			$(this).unbind("click").click(function() {
				location.href = $(this).find(".entry-title a").attr("href");
			});
		}
	});
	// contact popup
	$(".js-contact-link").each(function() {
		setContactPopupAction($(this));
	});
	
	/* init slideshows */
	$('.img-wrapper').slideshow();
	
	/* init google maps on ready */
	$(".contact-area .map_canvas, article.single .map_canvas").googlemap();
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
		if( $(this).scrollTop() > 1000 ) {
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
	$('#scrollTo_top a').unbind("click").click(function(){
		$('html, body').animate({scrollTop:0}, 500 );
		return false;
	});
	/* END scroll to top  */


	/**
	 * Responsive top navigation bar
	 */
	$(".js-show-search").click(function(ev) {
		$(".searchnavigation").toggleClass("unhide");
		ev.preventDefault();
	});
	$(".js-show-main-menu").click(function(ev) {
		$(".main-menu").toggleClass("unhide");
		ev.preventDefault();
	});
	
	/**
	 * responsive dropdown menu
	 */
	// set click action	on responsive dropdown-menu
	$(".dropdown-menu-button").unbind("click").click( function(){
		if ($(this).hasClass("submenu")) {
			$("ul.main-sub-menu").toggleClass("unhide");
		}
		else if ($(this).hasClass("category")) {
			$(".category-navigation").slideToggle('fast');
		}		
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
		$(this).unbind("click").click(function(ev) {
			ev.preventDefault();
			ev.stopPropagation();
			$(this).parent().parent().find(".children:first").toggle();
		});
	});*/

	/**
	 * first simple test of dynamic search 
	 */
	//$('#s').searchSuggest();
	

	/* 
	* give result in dropdownlist 
	*/ 
	$('#s').keyup(function(ev) { 
		
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

			if ($('#s').val().length > 2)  {

				if (!$(".searchresult-wrapper")[0]) 
				{ 
					$('#searchform').after("<div class='searchresult-wrapper'><div class='searchresult'></div></div>"); 
				} 
				searchstring = $("#s").val(); 
				
				$(".searchresult").load(hultsfred_object["templateDir"]+"/ajax/search.php", 
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
					$(clearbutton).click(function(){ 
						event.preventDefault(); 
						erase_and_refocus_on_search_input(); 
					}); 

					$(link_objects).each(function(index, value) {  
					
						var link = this;

						$(this).keydown(function(){  var key = event.keyCode || event.which;

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
			} 
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
	}); 

	
	
	


	/*
	 * give result in dropdownlist
	 */
	 /*
	$('#menu li').each(function() {
		$(this).unbind("mouseenter").mouseenter(function() {
			if( $(window).width()+scrollbar > responsive_small_size ) {
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


	/* do callbacks if found */
	if(typeof setSingleSettings == 'function') {
		setSingleSettings();
	}

});/* END $(document).ready() */

/* helper to ajax search */
function erase_and_refocus_on_search_input() 
{ 
	$('#s').val(''); 
	$('#s').focus(); 

	var dropdown = $('.searchresult'); 

	if($(dropdown).length > 0) { 
		$(dropdown).remove(); 
	} 

	var erase_button = $('.clearbutton');

	if($(erase_button).length > 0) { 
		$(erase_button).remove(); 
	} 

}


/* article actions to be set when ready and when dynamic loading */
function setArticleActions(el) {

	/* add print dialog */
	$("article .side-content").find(".tool-line.print").unbind("click").click(function(ev) {
		if ($(this).parents("body").hasClass("single")) {
			ev.preventDefault();
			window.print();
		}
	});
	
	/* show all side-content when hover */
	/*
	$("article .side-content").unbind("hover").hover(function() {
		if ($(this).find("a.contactlink, .related_link a, .related_file a").length > 2) {
			$(this).append("<div class='hover-side-content'></div>");
			$(".hover-side-content").html($(this).html()).unbind("mouseout").mouseout(function() {
				$(this).find("a.contactlink").each(function() {
					setContactPopupAction($(this));
				});
				$(this).find(".related_link a").each(function() {
					if ($(this).attr("href") !== undefined) {
						$(this).unbind("click").click(function () {
							push_google_analytics("#link=" + $(this).attr("href"));
						});
					}
				});
				$(this).find(".related_file a").each(function() {
					if ($(this).attr("href") !== undefined) {
						$(this).unbind("click").click(function () {
							push_google_analytics("#file=" + $(this).attr("href"));
						});
					}
				});
			
			});
		}
	},function() {	
		$(".hover-side-content").remove();
	});
	*/
	
	$(el).find(".js-read-click").unbind("click").click(function(ev) {
		ev.preventDefault();
		$(this).parent().next().find(".readspeaker_toolbox").fadeToggle();
	});
	/* add AddThis onclick */
	$(el).find(".js-friend-click").unbind("click").click(function(ev) {
		ev.preventDefault();
		$(this).parent().next().find(".addthis_toolbox").fadeToggle();
	});

	//sets click-action on entry-titles
	$(el).find('.entry-title').after("<div class='openButton button top hidden'><i class='i' data-icon='&#xF149;'></i>Visa mer</div>");
	
	$(el).find('.entry-title a, .togglearticle, .openButton').unbind("click").click(function(ev){
		ev.stopPropagation();
		ev.preventDefault();
		if( !$(this).parents('article').hasClass('loading') ){
			readMoreToggle(this);
		}
		else{ return false; }
	});
	
	// edit links
/*	if ($(el).find(".post-edit-link").attr("href") !== undefined) {
		$(el).find(".entry-title").append("<a title='Redigera inl&auml;gg' class='post-edit-link' href='"+$(el).find(".post-edit-link").attr("href")+"'><span class='icon'></span></a>");
	}
	$(el).find('.post-edit-link').unbind("click").click(function(ev){
		ev.stopPropagation();
	});
	*/
	
	//triggers articles click-action entry-title clicked
	$(el).find(".summary-content").unbind("click").click(function(){
		readMoreToggle( $(this).parents("article").find('.entry-title a') );
	});
	$(el).find(".js-contact-click").each(function() {
		setContactPopupAction($(this));
	});
	
	
	//google analytics
	$(el).find(".related_link a").each(function() {
		if ($(this).attr("href") !== undefined) {
			$(this).unbind("click").click(function () {
				push_google_analytics("#link=" + $(this).attr("href"));
			});
		}
	});
	$(el).find(".related_file a").each(function() {
		if ($(this).attr("href") !== undefined) {
			$(this).unbind("click").click(function () {
				push_google_analytics("#file=" + $(this).attr("href"));
			});
		}
	});
}

/* set contact popup action */
function setContactPopupAction(el) {
	$(el).unbind("click").click(function(ev) {
		if ($(".contact-popup").length == 0) {
			var post_id = $(el).parent().find(".contact_id").html();
			
			// follow link if post_id not found
			if (post_id == null) return true;
			
			ev.preventDefault();
			$("#page").append("<div class='contact-popup box'><div class='entry-content'>H&auml;mtar kontaktuppgifter...</div></div>").append("<div class='contact-popup overlay'></div>");
	
			$(".contact-popup.overlay").unbind("click").click(function() {
				$(".contact-popup").remove();
			});
			
			if ($(this).attr("href") !== undefined) {
				var thepage = $(this).attr("href");
			}
			$(".contact-popup.box").load(hultsfred_object["templateDir"]+"/ajax/hk_kontakter_load.php",{id:post_id,blog_id:hultsfred_object["blogId"]}, function()
			{
				// google analytics
				if (thepage !== undefined) {
					push_google_analytics(thepage);
				}

				$(this).find(".entry-wrapper").before("<div class='close-contact'><i class='i' data-icon='&#xF14E;'></i></div>");
				$(".close-contact").unbind("click").click(function() {
					$(".contact-popup").remove();
				});
				/* load google maps */
				$(this).find(".map_canvas").googlemap();
				
				/* init contact slideshow */
				$(this).slideshow();
			});
		}
		else {
			$(this).slideshow("pause");
			$(".contact-popup").remove();
		}
		return false;
	});

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
					$('#dyn-posts-load-posts a').unbind("click").click(function(ev) {
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

$.fn.sumWidth = function() {
	totalWidth = 0;
	$(this).each(function(index) {
		totalWidth += $(this).width();
	});
	return totalWidth;
}
function responsive_menu() {
	wrapperwidth = $(".menu-wrapper").width();

	function do_responsive_menu(classname) {
		// main-menu
		$(classname).find(".menu-item").removeClass("force-hidden");
		$(classname).find(".more-menu").remove();
		if ($(classname).children(".menu-item").sumWidth() > wrapperwidth) {
			$(classname).find(".right-nav-menu-item").addClass("force-hidden");
		}		
		if ($(classname).children(".menu-item").sumWidth() > wrapperwidth) {
			$(classname).append("<li class='more-menu menu-item'><a class='more-menu-a  js-more-menu-click' href='#'><i class='i' data-icon='&#xF149;'></i>Mer</a><ul class='more-menu-ul'></ul></li>");
			count=0; // to avoid infinit loop
			while (($(classname).children(".menu-item").sumWidth() > wrapperwidth) && count < 20) {
				count++;
				//log($(classname).children(".menu-item").not(".more-menu").sumWidth() + " " + $(classname).find(".more-menu").width() + " " + wrapperwidth);
				$(classname).find(".more-menu-ul").append("<li>"+$(classname).children(".menu-item").not(".force-hidden").not(".more-menu").last().addClass("force-hidden").html()+"</li>");
			}
		}
	}

	do_responsive_menu(".main-menu");
	do_responsive_menu(".main-sub-menu");
	
	


	$(".more-menu-ul").hide();
	
	$(".js-more-menu-click").unbind("click").click(function(ev) {
		//log($(this).parents("ul").find("more-menu-ul"));
		$(this).parents("ul").find(".more-menu-ul").toggle();
		ev.preventDefault();
	});

	//log($(".menu-wrapper").width() + " " + $(".main-menu")[0].scrollWidth + " " + $(".main-sub-menu")[0].clientWidth);
}

//om webbläsaren ändrar storlek
$(window).resize(function() {
	
	/* scale map */
	$(".map_canvas").height($(".contact-popup").height());

	
	if( oldWidth != $(window).width() ) {
		responsive_menu();

		//Skriver ut skärmens storlek
		/*log( $(window).height() + " $(window).width = " + $(window).width() + ", " +
			"MQ Screensize = " + ($(window).width() + scrollbar) 
		);*/
		
		/* reset responsive stuff */
		/*
		if( $(window).width()+scrollbar > responsive_small_size ){
			$("ul.main-menu, ul.main-sub-menu").show();
		}
		else {
			$("ul.main-menu, ul.main-sub-menu").hide();
		}
		
		if( $(window).width()+scrollbar > responsive_mobil_size ){
			$("#searchnavigation").slideDown("fast");
		} 
		else {
			$("#searchnavigation").slideUp("fast");
		}
		*/
	}
	oldWidth = $(window).width();
});

function log(logtext) {
	//Reset timer hide
	//clearTimeout(hide);

	$("#log").fadeIn("slow");
	$("#log").html(logtext);
	//Fading out in 5s.
	//hide = setTimeout( function(){
	//	$("#log").fadeOut("slow");
	//},2000);
}






})(jQuery);