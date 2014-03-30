<?php
	if(!isset($_SESSION))
	{
		session_start();
	}
    error_reporting(E_ALL);
	if(isset($_POST['DVD_Title']))
	{
		$db = new mysqli('localhost', 'root', '', 'Databases');
		$statement = $db->prepare("INSERT INTO Medias (Owner, DVD_Title, Studio, Released, Status, Sound, Versions, Price, Rating, Year, Genre, Aspect, UPC, DVD_ReleaseDate) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

        //$statement = $db->prepare("SELECT Studio FROM Medias where Owner like ?");
        //$statement->bind_param("s", $_POST['Genre']);

		$statement->bind_param("ssssssssssssss", $_SESSION['user'],$_POST['DVD_Title'], $_POST['Studio'], $_POST['Released'], $_POST['Status'], $_POST['Sound'], $_POST['Versions'], $_POST['Price'], $_POST['Rating'], $_POST['Year'], $_POST['Genre'], $_POST['Aspect'], $_POST['UPC'], $_POST['DVD_Release_Date']);
		if($statement->execute())
		{
			echo '<script>Submitted to the shop succesfuly</script>';
		}
	}
?>
<!doctype>
<html style="height: 100%;">
	<head>
		<meta charset="utf-8" />
		<title>Media Tags</title>

		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/default-theme.css">
	</head>
	<body style="height: 100%;">						<!-- navigation bar -->
		<div class="container">
			<div class="navbar navbar-inverse navbar-fixed-top default-background-color1" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="colapse" data-target=".navbar-collapse"></button>
						<a class="navbar-brand default-text-color1" href="/Database/home.php?home=true">Media Tag</a>
					</div>
					<div class="navbar-collapse collapse">
						<div class="nav navbar-nav default-text-color1">
							<li>
								<a href="/Database/home.php?home=true">Home</a>
							</li>
							<!--<li>
								<a href="#shop">Shop</a>
							</li>-->
							<li>
								<a href="#cart">My Cart</a>
							</li>
							<li class="active">
								<a href="#sell">Sell</a>
							</li>
							<li>
								<a href="#about">About</a>
							</li>
						</div>
						<div class="nav navbar-nav default-text-color1 navbar-right">
							<li>
								<a href="/Database">Log Out</a>
							</li>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid" style="height: 100%;">
			<div class="row not-row-sell">			<!--side bar!! -->
					<div class="col-sm-3 col-md-2 sidebar search-box" data-offset-bottom="0">
						<ul class="nav nav-sidebar affix-bottom affix-top affix-left affix-right sell-button">
								<li><a id="DVD_Title_a">Media Name</a></li>
								<li><a id="Price_a">Price</a></li>
								<li><a id="Studio_a">Studio</a></li>
								<li><a id="Released_a">Released</a></li>
								<li><a id="Status_a">Status</a></li>
								<li><a id="Sound_a">Sound</a></li>
								<li><a id="Versions_a">Versions</a></li>
								<li><a id="Rating_a">Rating</a></li>
								<li><a id="Year_a">Year</a></li>
								<li><a id="Genre_a">Genre</a></li>
								<li><a id="Aspect_a">Aspect</a></li>
								<li><a id="UPC_a">UPC</a></li>
								<li><a id="DVD_Release_Date_a">Release Date</a></li>
							  <button class="btn dropdown-toggle sr-only to-button sell-button" type="button" id="sellButton" onclick="submitForm()">
							    Sell
							  </button>
						</ul>
					</div>
			</div>
			<div class="container main">
				<form name="formToSell" id="formToSell" method="post" action="">
					<div style="display: inline margin-top: 50px;"><h5 class="sell-text">Name</h5><input name="DVD_Title" type="text" class="form-control signup-field sell-field" placeholder="Media Name" required=""/></div>
					<div style="display: inline"><h5 class="sell-text">Price</h5><input name="Price" type="number" class="form-control signup-field sell-field" placeholder="Price" required=""/></div>
					<div style="display: inline"><h5 class="sell-text">Studio</h5><input name="Studio" type="text" class="form-control signup-field sell-field" placeholder="Studio" required=""/></div>
					<div style="display: inline"><h5 class="sell-text">Released</h5><input name="Released" type="text" class="form-control signup-field sell-field" placeholder="Released" required=""/></div>
					<div style="display: inline"><h5 class="sell-text">Status</h5><input name="Status" type="text" class="form-control signup-field sell-field" placeholder="Status" required=""/></div>
					<div style="display: inline"><h5 class="sell-text">Sound</h5><input name="Sound" type="text" class="form-control signup-field sell-field" placeholder="Sound" required=""/></div>
					<div style="display: inline"><h5 class="sell-text">Versions</h5><input name="Versions" type="text" class="form-control signup-field sell-field" placeholder="Versions" required=""/></div>
					<div style="display: inline"><h5 class="sell-text">Rating</h5><input name="Rating" type="text" class="form-control signup-field sell-field" placeholder="Rating" required=""/></div>
					<div style="display: inline"><h5 class="sell-text">Year</h5><input name="Year" type="text" class="form-control signup-field sell-field" placeholder="Year" required=""/></div>
					<div style="display: inline"><h5 class="sell-text">Genre</h5><input name="Genre" type="text" class="form-control signup-field sell-field" placeholder="Genre" required=""/></div>
					<div style="display: inline"><h5 class="sell-text">Aspect</h5><input name="Aspect" type="text" class="form-control signup-field sell-field" placeholder="Aspect" required=""/></div>
					<div style="display: inline"><h5 class="sell-text">UPC</h5><input name="UPC" type="text" class="form-control signup-field sell-field" placeholder="UPC" required=""/></div>
					<div style="display: inline"><h5 class="sell-text">Release Date</h5><input name="DVD_Release_Date" type="text" class="form-control signup-field sell-field" placeholder="Release Date" required="" style="margin-bottom: 50px;"/></div>
				</form>
			</div>
		</div>
		<script type="text/javascript" src="js/jquery-1.11.0.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
			var newValue = new Array ($("input[name=DVD_Title]"), $("input[name=Price]"), $("input[name=Studio]"), $("input[name=Released]"), $("input[name=Status"), 
				$("input[name=Sound]"), $("input[name=Versions]"), $("input[name=Rating]"), $("input[name=Year]"), $("input[name=Genre]"), $("input[name=Aspect]"), 
				$("input[name=UPC]"), $("input[name=DVD_Release_Date]"));
			var textToChange = new Array ($("#DVD_Title_a"), $("#Price_a"), $("#Studio_a"), $("#Released_a"), $("#Status_a"), 
				$("#Sound_a"), $("#Versions_a"), $("#Rating_a"), $("#Year_a"), $("#Genre_a"), $("#Aspect_a"), 
				$("#UPC_a"), $("#DVD_Release_Date_a"))
			var placeHolder = new Array ('Media Name', 'Price', 'Studio', 'Released', 'Status', 'Sound', 'Versions', 'Rating', 'Year', 'Genre', 'Aspect', 'UPC', 'Release Date');
			//for (var i = 0; i <  newValue.length; i++) {
				//newValue[i].bind("propertychange keyup input paste", function(event){if(newValue[i].val() != '') textToChange[i].html(newValue[i].val()); else textToChange[i].html(placeHolder[i]);});
			//};
				newValue[0].bind("propertychange keyup input paste", function(event){if(newValue[0].val() != '') textToChange[0].html(newValue[0].val()); else textToChange[0].html(placeHolder[0]);});				//porque a porra do for não funciona '--

				newValue[1].bind("propertychange keyup input paste", function(event){if(newValue[1].val() != '') textToChange[1].html("" + newValue[1].val()); else textToChange[1].html(placeHolder[1]);});
				newValue[2].bind("propertychange keyup input paste", function(event){if(newValue[2].val() != '') textToChange[2].html(newValue[2].val()); else textToChange[2].html(placeHolder[2]);});
				newValue[3].bind("propertychange keyup input paste", function(event){if(newValue[3].val() != '') textToChange[3].html(newValue[3].val()); else textToChange[3].html(placeHolder[3]);});
				newValue[4].bind("propertychange keyup input paste", function(event){if(newValue[4].val() != '') textToChange[4].html(newValue[4].val()); else textToChange[4].html(placeHolder[4]);});
				newValue[5].bind("propertychange keyup input paste", function(event){if(newValue[5].val() != '') textToChange[5].html(newValue[5].val()); else textToChange[5].html(placeHolder[5]);});
				newValue[6].bind("propertychange keyup input paste", function(event){if(newValue[6].val() != '') textToChange[6].html(newValue[6].val()); else textToChange[6].html(placeHolder[6]);});
				newValue[7].bind("propertychange keyup input paste", function(event){if(newValue[7].val() != '') textToChange[7].html(newValue[7].val()); else textToChange[7].html(placeHolder[7]);});
				newValue[8].bind("propertychange keyup input paste", function(event){if(newValue[8].val() != '') textToChange[8].html(newValue[8].val()); else textToChange[8].html(placeHolder[8]);});
				newValue[9].bind("propertychange keyup input paste", function(event){if(newValue[9].val() != '') textToChange[9].html(newValue[9].val()); else textToChange[9].html(placeHolder[9]);});
				newValue[10].bind("propertychange keyup input paste", function(event){if(newValue[10].val() != '') textToChange[10].html(newValue[10].val()); else textToChange[10].html(placeHolder[10]);});
				newValue[11].bind("propertychange keyup input paste", function(event){if(newValue[11].val() != '') textToChange[11].html(newValue[11].val()); else textToChange[11].html(placeHolder[11]);});
				newValue[12].bind("propertychange keyup input paste", function(event){if(newValue[12].val() != '') textToChange[12].html(newValue[12].val()); else textToChange[12].html(placeHolder[12]);});
			 
		</script>
		<script type="text/javascript">
			function submitForm()
			{
				var numbers = /^[0-9]+$/;;
				var a=document.forms["formToSell"]["DVD_Title"].value;
			    var b=document.forms["formToSell"]["Price"].value;
			    var c=document.forms["formToSell"]["Studio"].value;
			    var d=document.forms["formToSell"]["Released"].value;
				var e=document.forms["formToSell"]["Status"].value;
			    var f=document.forms["formToSell"]["Sound"].value;
			    var g=document.forms["formToSell"]["Versions"].value;
			    var h=document.forms["formToSell"]["Rating"].value;
				var i=document.forms["formToSell"]["Year"].value;
			    var j=document.forms["formToSell"]["Genre"].value;
			    var k=document.forms["formToSell"]["Aspect"].value;
			    var l=document.forms["formToSell"]["UPC"].value;
			    var m=document.forms["formToSell"]["DVD_Release_Date"].value;
			    if (a==null || a=="",b==null || b=="",c==null || c=="",d==null || d=="", e==null || e=="",f==null || f=="",g==null || g=="",h==null || h=="", i==null || i=="",j==null || j=="",k==null || k=="",l==null || l=="", m==null || m=="")
			    {
				    alert("Please Fill All Required Fields Correctly");
				    return false;
			    }
			    else
			    {
			    	if(b.match(numbers))
			    	{
				    	alert("Please Fill All Required Fields Correctly");
						document.formToSell.submit();
			    	}
			    }
			}
		</script>
	</body>

</html>