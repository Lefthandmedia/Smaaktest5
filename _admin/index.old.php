<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>smaaktest</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script src="http://www.google.com/jsapi" type="text/javascript"></script>
		<script type="text/javascript" charset="utf-8">
			google.load("jquery", "1.3");
		</script>
		<link rel="stylesheet" href="../prettyPhoto/css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
		<script src="../prettyPhoto/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
		
		<style type="text/css" media="screen">
			* { margin: 0; padding: 0; }
			
			body {
				font: 80%/1.2 Arial, Verdana, Sans-Serif;
				padding: 0 20px;
			}
			
			h4 { margin: 15px 0 5px 0; }
			
			h4, p { font-size: 1.2em; }
			
			ul li { display: block; }
		</style>
	</head>
	<body>

    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9"></div>


        </div>

    </div>


<h4>Main menu</h4>
		<ul class="gallery clearfix">
			<li><a href="create_locatie.php?iframe=true&amp;width=800&amp;height=600" rel="prettyPhoto['page1']">Locatie aanmaken</a></li>
            <li><a href="edit_locatie.php?iframe=true&amp;width=800&amp;height=600" rel="prettyPhoto['page2']">Locatie bewerken</a></li>
            <li><a href="create_tag.php?iframe=true&amp;width=800&amp;height=600" rel="prettyPhoto['page3']">Tags toevoegen</a></li>
            <li><a href="uitslag.php?iframe=true&amp;width=900&amp;height=600" rel="prettyPhoto['page4']">Uitslagen</a></li>
    </ul>
<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){
			$(".gallery a[rel^='prettyPhoto']").prettyPhoto({theme:'light_rounded'});
		});
		</script>
</body>
</html>