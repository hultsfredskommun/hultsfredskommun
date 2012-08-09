(function($) {
// JavaScript Document


var settings = new Array();


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
 * Initialize function read-more toggle-button 
 */
function readMoreToggleButton(el){
	//toggle function
	function toggleShow() {
		article = $(el).parents("article");
		
		// show summary content
		if ( $(article).hasClass("full") )
		{
			// toggle visibility
			setTimeout( function(){
				$(article).find('.summary-content').fadeIn("fast");
			}, 250);
			$(article).find('.more-content').hide(500, function(){
				if( $("#content").hasClass("viewmode_titles") || $(article).hasClass("news") ){
					$(article).addClass("only-title");
				}
				
				// alter close-buttons
				$(article).find('.closeButton').remove();
				$(article).find(".readMoreToggleButton").html(". . .")

				// remove full class to track article state
				$(article).removeClass("full");

				// scroll to top of post 
				$("html,body").animate({scrollTop: $(article).position().top}, 300);
			});
			
			// reset webbrowser history
			History.replaceState(null, title, hultsfred_object["currPageUrl"]);
		}
		// show full content
		else
		{
			if( $("#content").hasClass("viewmode_titles") || $(article).hasClass("news") ){
				$(article).removeClass("only-title");
			}
			// add full class to track article state
			$(article).addClass("full");
		
			// toggle visibility
			$(article).find('.summary-content').fadeOut("fast");
			$(article).find('.more-content').show(500, function(){
				// alter close-button
				$(article).find(".readMoreToggleButton").html("St&auml;ng");

				//add close-button top right corner
				var closea = $('<a>').addClass('closeButton').html("St&auml;ng").click(function(){
					readMoreToggleButton( $(this).parent().find('.readMoreToggleButton') );
				});
				$(article).append(closea);
				
				// scroll to top of post 
				$("html,body").animate({scrollTop: $(article).position().top}, 300);
			});
			
			//change webbrowser url
			//find and store post-title and post-url
			var entry_title = $(article).find(".entry-title");
			var blog_title = $("#logo").find('img').attr('alt');
			var title = $(entry_title).find("a").html().replace("&amp;","&") + " | " + blog_title;
			var url = $(entry_title).find("a").attr("href");
			
			History.replaceState(null, title, url);
		}
	}

	if( !$(el).hasClass("loaded") ){
		//add class loading
		$(el).addClass("loading").html("Laddar...");
		
		//find posts url and store it in variable
		var entry_title = $(el).parent().find(".entry-title");
		var post_id = $(entry_title).find("a").attr("post_id");
		
	
		//create a new div with requested content
		var morediv = $("<div>").attr("class","more-content").hide();
		
		//append div in readMoreContent
		var readMore = $(el).parent().find('.readMoreContent');
		$(readMore).append(morediv);

		$.ajaxSetup({cache:false});
		$(morediv).load(hultsfred_object["templateDir"]+"/post_load.php",{id:post_id}, function()
		{
			//hide old content and show new
			//$(this).parent().find('.entry-content').hide();
			//$(this).parent().find('.entry-title').hide();
			//$(this).show();
			
			//****** click-actions START *******
			
			//set click-action on print-post-link
			var print_link = $(this).find(".print-post");
			$(print_link).click(function(ev){
				PrintElem( $(this).attr("elem-id") );
				ev.preventDefault();
			});
			
			//set click-action on scroll-to-postFooter-link
			var scroll_link = $(this).find(".scroll-to-postFooter");
			$(scroll_link).click(function(ev){
				var id = $(this).attr("elem-id");
				var posFooter = $(id).find(".more-content > footer").position().top;
				var posPost = $(id).position().top;
				$("html,body").animate({scrollTop: (posPost + posFooter - 50)},"slow");
				ev.preventDefault();
			});
			
			//set click-action on scroll-to-postTop-link
			scroll_link = $(this).find(".scroll-to-postTop");
			$(scroll_link).click(function(ev){
				var id = $(this).attr("elem-id");
				$("html,body").animate({scrollTop: $(id).position().top},"slow");
				ev.preventDefault();
			});
			//***** click-actions END ******
			
			$(this).parents("article").find(".readMoreToggleButton").removeClass("loading").addClass("loaded");

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
var max_width = 650;

var hide; //used by Timeout to hide #log
var oldWidth; //used to check if window-width have changed

//$.expander.defaults.slicePoint = 20;




$(document).ready(function(){

	//Stores the window-width for later use
	oldWidth = $(window).width();

	/**
	 * Fix scroll to top on single and page
	 */
	//if( $("body").hasClass("single") || $("body").hasClass("page") ){	
	//	$('html, body').animate({scrollTop:0}, "fast" );
	//}


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
	 * history url handling
	 */
	History.Adapter.bind(window,'popstate',function(evt){
		//alert(evt.state);
		var State = History.getState();
		History.log(State);
		if(evt.state !== null && evt.state !== undefined){	
			window.location = State.url;
		}
	});
	//url clean-up and history-fix
	if( !$("body").hasClass("single") && !$("body").hasClass("page") ){
		//do a clean-up that removes the hash (tags, sort m.m.)
		var title = $("html head title").html();
		History.replaceState(null, title, hultsfred_object["currPageUrl"]);
	}
	

	/**
	 * view-modes 
	 */
	// show framed articles click action
	$("#viewmode_summary").click(function(ev){
		$("#content").removeClass("viewmode_titles");
		$("#content").find('article').removeClass("only-title");
		ev.preventDefault();
	});
	// show only title click action
	$("#viewmode_titles").click(function(ev){
		$("#content").addClass("viewmode_titles");	
		$("#content").find('article').addClass("only-title");
		ev.preventDefault();
	});

	/**
	 * add action to read-more toggle button
	 */
	$("#content").find('.readMoreToggleButton').each( function(){
		$(this).click(function(ev){
			ev.preventDefault();
			if( !$(this).hasClass('loading') ){
				readMoreToggleButton(this);
			}
		});
	});
	$("#content").find('.entry-title').each(function(){
		$(this).find('a').click(function(ev){
			ev.preventDefault();
			var post = $(this).parents('.post');
			$(post).find('.readMoreToggleButton').click();
		});
	});
	
	/**
	 * init slideshow
	 */
	$('.slideshow').cycle({
		slideExpr: 'article',
		fx: 'fade',
		timeout: 10000, //10 sekunder
		slideResize: true,
		containerResize: false,
		width: '100%',
		fit: 1,
		pause: 1
	});

	/**
	 * scroll to top actions 
	 */
	$('.scrollTo_top').hide();
	$(window).scroll(function () {
		/* load next pages posts dynamically when reaching bottom of page */
		if( parseInt($(this).scrollTop()) > parseInt($(document).height() - $(window).height()*2) ) {
			//$('#dyn-posts-load-posts a').click();
			dyn_posts_load_posts();
		}

		/* show scroll to top icon */
		if( $(this).scrollTop() > 1000 ) {
			$('.scrollTo_top').fadeIn(300);
		}
		else {
			$('.scrollTo_top').fadeOut(300);
		}

		/*		if( $(this).scrollTop() > 50 ) {
			$('#access').css("position", "fixed").css("top", "0px").css("border-top-left-radius","0").css("border-top-right-radius","0").css("border-bottom-left-radius","10px").css("border-bottom-right-radius","10px");
		}
		else {
			$('#access').css("position", "initial").css("border-top-left-radius","10px").css("border-top-right-radius","10px").css("border-bottom-left-radius","0").css("border-bottom-right-radius","0");
		}

		if( $(this).scrollTop() > 380 ) {
			$('#secondary-nav').css("position", "fixed").css("top", "69px").css("width", "22%");
		}
		else {
			$('#secondary-nav').css("position", "initial").css("width", "100%");
		}*/
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
	$("#dropdown-menu").click( function(){
		
		//toggle "#menu ul"
		if( $("#menu ul").is(":visible") ){
			$("#menu ul").slideUp('fast');
		}
		else{ $("#menu ul").slideDown('fast'); }
	
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
	if(settings["pageNum"] <= settings["maxPages"]) {
		// Insert the "More Posts" link.
		$('#content')
			.append('<div id="dyn-posts-placeholder-'+ settings["pageNum"] +'" class="dyn-posts-placeholder"></div>')
			.append('<p id="dyn-posts-load-posts"><a href="#">Ladda fler sidor</a></p>');
			
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
			$('#dyn-posts-placeholder-'+ settings["pageNumVisible"]).slideDown('',function(){
				// Update the button message.
				if(settings["pageNumVisible"] < settings["maxPages"]) {
					$('#dyn-posts-load-posts a').text('Ladda fler sidor');
				} else {
					$('#dyn-posts-load-posts a').text('Inga fler sidor att ladda.').click(function() {
						ev.preventDefault();
					});
				}
			});
			$('#dyn-posts-placeholder-'+ settings["pageNumVisible"]).children(":first-child").unwrap();
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
	$('#s').keyup(function(ev) {
		if ($('#s').val().length > 2)
		{
			$("#primary").load("/wordpress/?s="+$('#s').val()+"&submit=Sök #content", function() {
				$(this).find('.readMoreToggleButton').each( function(){
					
					initToggleReadMore(this);
				});
			});
		}
	});
	*/
	
	
	//Skriver ut skärmens storlek
	log( "$(window).width = " + $(window).width() + ", " +
		"MQ Screensize = " + ($(window).width() + scrollbar) 
	);

});/* END $(document).ready() */


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

		$('#dyn-posts-placeholder-'+ settings["pageNum"]).hide().load(hultsfred_object["templateDir"]+"/dyn_posts_load.php?" + uri,
			{ pageNum: settings["pageNum"], filter: filter }, /*settings["nextLink"] + ' .post',*/
			function() {
				//log("ready " + settings["pageNum"] + " " +settings["nextLink"]);
				
				if( $("#content").hasClass("viewmode_titles") ){
					$('#dyn-posts-placeholder-'+ settings["pageNum"]).find('article').addClass("only-title");
				}
				
				// read-more toggle button
				$('#dyn-posts-placeholder-'+ settings["pageNum"]).find('.readMoreToggleButton').each(function(){
					$(this).click(function(ev){
						ev.preventDefault();
						if( !$(this).hasClass('loading') ){
							readMoreToggleButton(this);	
						}
					});
				});
				
				$('#dyn-posts-placeholder-'+ settings["pageNum"]).find('.entry-title').each(function(){
					$(this).find('a').click(function(ev){
						ev.preventDefault();
						var post = $(this).parents("article");
						$(post).find('.readMoreToggleButton').click();
					});
				});
			
				$('#dyn-posts-placeholder-'+ settings["pageNum"]).find('.more-link').addClass('dyn-posts').addClass('dyn-posts-placeholder-'+ settings["pageNum"]).click(function(ev){
					settings["pageNumVisible"]++;
					$('#dyn-posts-placeholder-'+ settings["pageNumVisible"]).slideDown();
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

	if( oldWidth != $(window).width() ) {

		//Skriver ut skärmens storlek
		log( "$(window).width = " + $(window).width() + ", " +
			"MQ Screensize = " + ($(window).width() + scrollbar) 
		);

		if ( $(window).width() > (max_width - scrollbar) ) 
		{
			$("#menu ul").show();
		}else{
			$("#menu ul").hide();
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