<!DOCTYPE html>
<!--[if LT IE 9]>
	<script type="text/javascript">
		var exec = true;
	</script>
<![endif]-->
<head>
	<meta charset=utf-8>
	<title></title>
	<style>
	.old_ie {
		padding: 10px;
		width: 340px;
		position: absolute;
		bottom: 10px;
		right: 10px;
		visibility: hidden;
		background: #F5C867;
	}
	.close {
		float: right;
		font-weight: bold;
		font-family: sans-serif;
		cursor: pointer;
	}
	.old_ie ul, li, p{
		margin: 0;
	}
	.old_ie p {
		width: 320px;
		float: left;
		margin-bottom: 15px;
	}
	.old_ie ul li a {
		text-decoration: none;
	}
	.old_ie ul li {
		list-style: none;
	}
	</style>
</head>
<body>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

<div class="old_ie">
	<span class="close">X</span>
	<p>For a better and more secure web browsing experience, please update your internet browser or consider an alternative browser:</p>
	<ul>
		<li><a href="#">Update Internet Explorer</a></li>
		<li><a href="#">Download Google Chrome</a></li>
	</ul>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		try {
			if (exec) {
				var box = $('.old_ie');
				box.attr('style', 'visibility: visible');
				$('.close').on('click', function(){
					$(box).slideUp();
					// store setting in session
				});
			}
		} catch(Exception) {
			var old_ie_error = Exception.message;
		}
	});
</script>

</body>
</html>