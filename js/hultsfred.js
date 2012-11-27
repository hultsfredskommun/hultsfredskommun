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
		$(this).each(function() {
			var coordinates = $(this).find(".coordinates").html();
			var address = $(this).find(".address").html();
			$(this).height("300px").gmap({scrollwheel: false, center: coordinates, zoom: 15, callback: function() {
				var self = this;
				self.addMarker({'position': this.get('map').getCenter()}).click(function() {
					self.openInfoWindow({ 'content': address}, this);
				});
			}});
		});
	}
} else {
	alert("ERROR: The function $.fn.googlemap already exists");
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
					rand = Math.floor((Math.random()*1000)+1);
					$(this).find(".prevslide").addClass("prev"+rand);
					$(this).find(".nextslide").addClass("next"+rand);
					// show slide navigation on hover
					$(this).hover(function() {
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
			
			$(article).find('.more-content').slideUp(0, function(){
				
				if( $("#content").hasClass("viewmode_titles") ){
					$(article).addClass("only-title");
				}
				
				// toggle visibility
				if ($(article).position().top +130 + $("html,body").position().top < 0) {
					$("html,body").animate({scrollTop: $(article).position().top +130}, 0);
				}
				$(article).find('.summary-content').slideDown(0, function(){
					
					// remove full class to track article state
					$(article).removeClass("full");
					// scroll to top of post 
					
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
			$(article).find('.summary-content').slideUp(0, function(){
				
				if( $("#content").hasClass("viewmode_titles") ){
					$(article).removeClass("only-title");
				}
				// add full class to track article state
				$(article).addClass("full");
				$(article).find('.more-content').slideDown(0, function(){
				
					//add close-button top right corner
					var closea = $('<div>').addClass('closeButton top close').html("<div class='icon'></div><a href='#'>Visa mindre</a>").click(function(ev){
						ev.preventDefault();
						readMoreToggle( $(this).parents("article").find(".entry-title a") );
					});
					var closeb = $('<div>').addClass('closeButton bottom close white').html("<div class='icon'></div><a href='#'>Visa mindre</a>").click(function(ev){
						ev.preventDefault();
						readMoreToggle( $(this).parents("article").find(".entry-title a") );
					});
					$(this).parents("article").find(".article-wrapper").prepend(closea).after(closeb);
					
					// scroll to top of post 
					//$("html,body").animate({scrollTop: $(article).position().top}, 150);

					// articles slideshow
					$(this).slideshow();

					// articles maps
					$(this).find(".map_canvas").googlemap();
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
		$(article).find('.summary-content').css("cursor","wait");
		$(morediv).load(hultsfred_object["templateDir"]+"/ajax/single_post_load.php",{id:post_id,blog_id:hultsfred_object["blogId"]}, function()
		{
			$(this).parents("article").find('.summary-content').css("cursor","pointer");
			//****** click-actions START *******
			
			//set click-action on print-post-link
			var print_link = $(this).find(".print-post");
			$(print_link).click(function(ev){
				PrintElem( $(this).attr("elem-id") );
				ev.preventDefault();
			});
			
			//***** click-actions END ******
			
			//All is loaded
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
var dropdown_max_width = 650;

var hide; //used by Timeout to hide #log
var oldWidth; //used to check if window-width have changed

//$.expander.defaults.slicePoint = 20;




$(document).ready(function(){
	var wpadminbarheight = $("#wpadminbar").height();
	
	/* GRID LINES */
	$("#cssgridbutton .onoff").click(function() {
		$("#cssgrid").toggle();
	});
	$("#cssgridbutton .zindex").click(function() {
		if ($("#cssgrid").css("z-index") > 2)
			$("#cssgrid").css("z-index",1);
		else
			$("#cssgrid").css("z-index",10000);
	});
	$("#cssgrid .wrapper .column").height($("#page").height());
	
	//Stores the window-width for later use
	oldWidth = $(window).width();

	/**
	 * Fix scroll to top on single and page
	 */
	$('html, body').animate({scrollTop:0}, 0);


	/**
	 * tabs action
	 */
	$(".home #content").tabs();


	/**
	 * sort-order click-action
	 */
	$("#sort-order").find("a").each(function(){
		$(this).click(function(ev){
			window.location.assign(hultsfred_object["currPageUrl"] + $(this).attr("href"));
			ev.preventDefault();
		});
	});
	
	/**
	 * click-actions on single/page
	 */
	if( $('body').hasClass("single") || $('body').hasClass("page") ){
		
		var article = $("#content").find('article');
		
		//****** click-actions START *******
		//set click-action on print-post-link
		var print_link = $(article).find(".print-post");
		$(print_link).click(function(ev){
			PrintElem( article );
			ev.preventDefault();
		});
		
		//***** click-actions END ******
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
	$("#viewmode_summary").click(function(ev){
		$("#content").removeClass("viewmode_titles");
		$("#content").find('article').removeClass("only-title");
		$("#viewmode_titles").show();
		$("#viewmode_summary").hide();
		ev.preventDefault();
	});
	// show only title click action
	$("#viewmode_titles").click(function(ev){
		$("#viewmode_titles").hide();
		$("#viewmode_summary").show();
		
		//get all articles in #content and store in arr
		var arr = $("#content").find('article');
		
		//for each article in arr
		arr.each(function(index, item) {
			var is_last_item = (index == (arr.length - 1));
			
			if( $(item).hasClass("full") ){
				
				// remove close-button
				$(item).find('.closeButton').remove();
				
				//hide more-content
				$(item).find('.more-content').hide();				
				
				//show summary-content
				$(item).find('.summary-content').show();
			
				// remove full class to track article state
				$(item).removeClass("full");
			}
			
			if(is_last_item){
				$("#content").addClass("viewmode_titles");	
				$("#content").find('article').addClass("only-title");
			}
		});
		ev.preventDefault();
	});
	// show only title click action
	$(".dropdown-tags .toggle-tags").click(function(ev){
		$(this).toggleClass("open");
		$(this).parent().find("ul").toggle();
		
		ev.preventDefault();
	});

	/**
	 * side-tab toggle
	 */
	$("#side-tab .widget-title").click(function() {
		if ($(".contact-popup").length == 0) {
			if ($(this).parent().find(".content-wrapper").width() < 200) {
				$(this).parents("#side-tab").animate({
					right: '+=1px',
					}, 500, function() {
				});
				$(this).parent().find(".content-wrapper").animate({
					width: '+=200px',
					}, 500, function() {
				});
			}
			else {
				$(this).parents("#side-tab").animate({
					right: '-=1px',
					}, 500, function() {
				});
				$(this).parent().find(".content-wrapper").animate({
					width: '-=200px',
					}, 500, function() {
				});
			}
		}
		else {
			$(".contact-popup").remove();
		}
	});
	
	/* add action to read-more toggle */
	$("#primary").find('article').each(function(){
		setArticleActions($(this));
	});
	$("#firstpage-sidebar, #sidebar-wrapper, #side-tab").find(".contact-wrapper a").each(function() {
		setContactPopupAction($(this));
	});
	
	/* init slideshows */
	$('.img-wrapper').slideshow();
	
	/* init google maps on ready */
	$(".map_canvas").googlemap();
	
	/**
	 * scroll to top actions 
	 */
	$('.scrollTo_top').hide();
	$(window).scroll(function () {
		/* load next pages posts dynamically when reaching bottom of page */
		if( parseInt($(this).scrollTop()) > parseInt($(document).height() - $(window).height()*2) ) {
			/*if (!$(body).hasClass("home")) {*/
				//$('#dyn-posts-load-posts a').click();
				/* REMOVED - load more functionality 
				dyn_posts_load_posts();
				*/
			/*}
			else {
				log("Ingen dynamisk laddning p&aring; f&ouml;rstasidan.");
			}*/
		}

		/* show scroll to top icon */
		if( $(this).scrollTop() > 1000 ) {
			$('.scrollTo_top').fadeIn(300);
		}
		else {
			$('.scrollTo_top').fadeOut(300);
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
	$('.scrollTo_top a').click(function(){
		$('html, body').animate({scrollTop:0}, 500 );
		return false;
	});
	/* END scroll to top  */


	/**
	 * responsive dropdown menu
	 */
	// set click action	
	$("#menu .dropdown-menu").click( function(){
		
		//toggle "#menu ul.main-menu"
		if( $("#menu ul.main-menu").is(":visible") ){
			$("#menu ul.main-menu, #nav").slideUp('fast');
		}
		else{ $("#menu ul.main-menu, #nav").slideDown('fast'); }
	
	});  

	/**
	 * nav-sidebar collapsing and expand filters on category and tags
	 */
	$(".children").each(function() {
	 	if ($(this).parent().parent().hasClass("parent") && !$(this).parent().hasClass("current-cat") && $(this).parent().find(".current-cat").length == 0) {
			$(this).prev().append("<span class='more-children'>+</span>");
			$(this).hide();		
	 	}
	});
	$(".more-children").each(function() {
		$(this).click(function(ev) {
			ev.preventDefault();
			ev.stopPropagation();
			$(this).parent().parent().find(".children:first").toggle();
		});
	});



	/**
	 * load more posts dynamic 
	 */
	
	// The number of the next page to load (/page/x/).
	settings["pageNum"] = parseInt(hultsfred_object.startPage) + 1;
	settings["pageNumVisible"] = 1;

	// The maximum number of pages the current query can return.
	settings["maxPages"] = parseInt(hultsfred_object.maxPages);
	
	// The link of the next page of posts.
	settings["nextLink"] = hultsfred_object.nextLink;
	
	/**
	 * Replace the traditional navigation with our own,
	 * but only if there is at least one page of new posts to load.
	 */
	if(settings["pageNum"] <= settings["maxPages"]) { // && !$(body).hasClass("home")) {
		// Insert the "More Posts" link.
		/* REMOVED - load more functionality 
		$('#content')
		.append('<div id="dyn-posts-placeholder-'+ settings["pageNum"] +'" class="dyn-posts-placeholder"></div>')
		.append('<p id="dyn-posts-load-posts"><a href="#">Ladda fler sidor</a></p>');*/
		// Remove the traditional navigation.
		$('.navigation').remove();
		$("#nav-below").remove();
	}
	
	
	/**
	 * Show new posts when the link is clicked.
	 */
	$('#dyn-posts-load-posts a').click(function(ev) {
		if(!loading_next_page){
			settings["pageNumVisible"]++;
			$('#dyn-posts-placeholder-'+ settings["pageNumVisible"]).slideDown("slow",function(){
				// Update the button message.
				if(settings["pageNumVisible"] < settings["maxPages"]) {
					$('#dyn-posts-load-posts a').text('Ladda fler sidor');
				} else {
					$('#dyn-posts-load-posts').remove();
				}
				$('#dyn-posts-placeholder-'+ settings["pageNumVisible"]).children(":first-child").unwrap();
			});
			ev.preventDefault();
		}
		else{ 
			$(this).addClass("loading");
			ev.preventDefault();
		}	
	});



	/**
	 * first simple test of dynamic search 
	 */
	//$('#s').searchSuggest();
	

	/*
	 * give result in dropdownlist
	 */
	$('#s').keyup(function(ev) {
		if ($('#s').val().length > 2)
		{
			if (!$("#searchform").find("#searchresult")[0]) {
				$('#searchform').append("<div id='searchresult'></div>");				
			}
			searchstring = $("#s").val();
			$("#searchresult").load(hultsfred_object["templateDir"]+"/ajax/search.php",
			{ searchstring: searchstring },
			function() {

			});
			//$("#primary").load("/wordpress/?s="+$('#s').val()+"&submit=Sök #content", function() {
			//	$(this).find('.readMoreToggleButton').each( function(){
			//		
			//		initToggleReadMore(this);
			//	});
			//});
		}
		else {
			$('#searchresult').remove();
		}
	});


	
	$(".only-widget-title").css("cursor","pointer").each(function() {
		$(this).find(".hk_kontakter").hide();
		$(this).click(function() {
			$(this).find(".hk_kontakter").toggle();
		});
	});

	


	/*
	 * give result in dropdownlist
	 */
	 /*
	$('#menu li').each(function() {
		$(this).mouseenter(function() {
			if( $(window).width()+scrollbar > dropdown_max_width ) {
				if ($(this).attr("dropdown-id") === undefined) {
					rand = Math.floor(Math.random()*100000);
					$(this).attr("dropdown-id", rand);
					$(this).parent().after("<div class='menu-item-dropdown' id='menu-item-dropdown-" + rand + "'></div>");				
					href = $(this).find("a").attr("href");
					$("#menu-item-dropdown-" + rand).load(hultsfred_object["templateDir"]+"/ajax/dropdown.php",
					{ href: href },
					function() { 
						$(this).mouseout(function() {
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
	log( "$(window).width = " + $(window).width() + ", " +
		"MQ Screensize = " + ($(window).width() + scrollbar) 
	);/*
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

/* article actions to be set when ready and when dynamic loading */
function setArticleActions(el) {
	//sets click-action on entry-titles

	$(el).find('.entry-title a, .togglearticle').click(function(ev){
		ev.stopPropagation();
		ev.preventDefault();
		if( !$(this).parents('article').hasClass('loading') ){
			readMoreToggle(this);
		}
		else{ return false; }
	});
	$(el).find('.post-edit-link').click(function(ev){
		ev.stopPropagation();
	});
	//triggers articles click-action entry-title clicked
	$(el).find(".summary-content .entry-wrapper, .summary-content .img-wrapper").click(function(){
		readMoreToggle( $(this).parents("article").find('.entry-title a') );
	});
	$(el).find(".contact-wrapper a").each(function() {
		setContactPopupAction($(this));
	});
}

/* set contact popup action */
function setContactPopupAction(el) {
	$(el).click(function(ev) {
		if ($(".contact-popup").length == 0) {
			var post_id = $(el).parent().find(".contact_id").html();
			ev.preventDefault();
			$("#page").append("<div class='contact-popup box'>H&auml;mtar kontaktuppgifter...</div>").append("<div class='contact-popup overlay'></div>");
	
			$(".contact-popup.overlay").click(function() {
				$(".contact-popup").remove();
			});
			$(".contact-popup.box").load(hultsfred_object["templateDir"]+"/ajax/hk_kontakter_load.php",{id:post_id,blog_id:hultsfred_object["blogId"]}, function()
			{
				$(this).find(".entry-wrapper").prepend("<div class='close-contact'><div class='icon'></div> St&auml;ng</div>");
				$(".close-contact").click(function() {
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

	// Are there more posts to load?
		
	if(settings["pageNum"] <= settings["pageNumVisible"]+1 && settings["pageNum"] <= settings["maxPages"] && !loading_next_page) {
		log("Laddar sida " + settings["pageNum"] + " / " + settings["maxPages"])
		loading_next_page = true;


		var uri = window.location.href.slice(window.location.href.indexOf('?') + 1);

		$('#dyn-posts-placeholder-'+ settings["pageNum"]).hide().load(hultsfred_object["templateDir"]+"/ajax/posts_load.php?" + uri,
			{ pageNum: settings["pageNum"], filter: filter }, /*settings["nextLink"] + ' .post',*/
			function() {
				//log("ready " + settings["pageNum"] + " " +settings["nextLink"]);
				
				if( $("#content").hasClass("viewmode_titles") ){
					$('#dyn-posts-placeholder-'+ settings["pageNum"]).find('article').addClass("only-title");
				}
				
				// read-more toggle
				$('#dyn-posts-placeholder-'+ settings["pageNum"]).find('article').each(function(){
					setArticleActions($(this));
				});
			
				$('#dyn-posts-placeholder-'+ settings["pageNum"]).find('.more-link').addClass('dyn-posts').addClass('dyn-posts-placeholder-'+ settings["pageNum"]).click(function(ev){
					settings["pageNumVisible"]++;
					$('#dyn-posts-placeholder-'+ settings["pageNumVisible"]).slideDown("slow");
					ev.preventDefault();
				});
			
				// Update page number and nextLink.
				settings["prevPageNum"] = settings["pageNum"];
				settings["pageNum"]++;
				settings["nextLink"] = settings["nextLink"].replace('page/'+settings["prevPageNum"], 'page/'+ settings["pageNum"]);
				
				// Add a new placeholder, for when user clicks again.
				$('#dyn-posts-load-posts')
					.before('<div id="dyn-posts-placeholder-'+ settings["pageNum"] +'" class="dyn-posts-placeholder"></div>')
				
				
				loading_next_page = false;
				if( $('#dyn-posts-load-posts a').hasClass("loading") ){
					$('#dyn-posts-load-posts a').removeClass("loading").click();
				}
				
			}

		);
	} else {
		// 	$('#dyn-posts-load-posts a').append('.');
	}	
	
	return false;
};


//om webbläsaren ändrar storlek
$(window).resize(function() {

	/* CSS GRID */
	

	if( oldWidth != $(window).width() ) {

		//Skriver ut skärmens storlek
		log( $(window).height() + " $(window).width = " + $(window).width() + ", " +
			"MQ Screensize = " + ($(window).width() + scrollbar) 
		);
		
		if( $(window).width()+scrollbar > dropdown_max_width ){
			$("#menu ul.main-menu").show();
		}
		else{
			if( $("#menu ul.main-menu").is(":visible") ){
				$("#menu ul.main-menu").hide();
			}
		}
	}
	oldWidth = $(window).width();
});

function log(logtext) {
	//Reset timer hide
	clearTimeout(hide);

	$("#log").fadeIn("slow").html(logtext);
	//Fading out in 5s.
	hide = setTimeout( function(){
		$("#log").fadeOut("slow");
	},2000);
}






})(jQuery);