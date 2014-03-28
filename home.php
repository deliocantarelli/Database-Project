<?php
	if(!isset($_SESSION))			//just for localhost
	{
		session_start();
	}
	if(!isset($_SESSION['sortType']))
	{
		$_SESSION['sortType'] = 'TitleASC';		//for initialization
		$_SESSION['sortTitle'] = 'true';
		$_SESSION['sortDecade'] = 'false';
		$_SESSION['sortGenre'] = 'false';
		$_SESSION['decade'] = '2000';
		$_SESSION['onlyDecade'] = 'false';
		$_SESSION['itensPerPage'] = 20;
		$_SESSION['page'] = 1;
	}
	if(isset($_GET['sortType']))				//to see the way the user wants oredered
	{
		if($_SESSION['sortTitle'] == 'true' && isset($_GET['sortTitle']))
		{
			if($_SESSION['sortType'] == 'TitleASC')
			{
				$_SESSION['sortType'] = 'TitleDESC';
			}
			else
			{
				$_SESSION['sortType'] = 'TitleASC';
			}
		}
		elseif ($_SESSION['sortDecade'] == 'true' && isset($_GET['sortDecade'])) {
			if($_SESSION['sortType'] == 'DecadeASC')
			{
				$_SESSION['sortType'] = 'DecadeDESC';
			}
			else
			{
				$_SESSION['sortType'] = 'DecadeASC';
			}
		}
		elseif($_SESSION['sortGenre'] == 'true' && isset($_GET['sortGenre']))
		{
			if($_SESSION['sortType'] == 'GenreASC')
			{
				$_SESSION['sortType'] = 'GenreDESC';
			}
			else
			{
				$_SESSION['sortType'] = 'GenreASC';
			}
		}
		elseif (isset($_GET['sortTitle'])) {
			$_SESSION['sortType'] = 'TitleASC';
			$_SESSION['sortTitle'] = 'true';
			$_SESSION['sortDecade'] = 'false';
			$_SESSION['sortGenre'] = 'false';
		}
		elseif (isset($_GET['sortDecade'])) {
			$_SESSION['sortType'] = 'DecadeASC';
			$_SESSION['sortTitle'] = 'false';
			$_SESSION['sortDecade'] = 'true';
			$_SESSION['sortGenre'] = 'false';
		}
		elseif (isset($_GET['sortGenre'])) {
			$_SESSION['sortType'] = 'GenreASC';
			$_SESSION['sortTitle'] = 'false';
			$_SESSION['sortDecade'] = 'false';
			$_SESSION['sortGenre'] = 'true';
		}
	}
	if(isset($_GET['decade']))
	{
		$_SESSION['onlyDecade'] = 'true';
		$_SESSION['decade'] = $_GET['decade'];
	}
	else
	{
		$_SESSION['onlyDecade'] = 'false';
	}

	$db = new mysqli('localhost', 'root', '', 'Databases');
	$query = "SELECT * FROM Medias";

    if($db->connect_errno > 0)										//change the query to the right way
    {
        die('Unable to connect to database [' . $db->connect_error . ']');
    }
    if($_SESSION['onlyDecade'] == 'true')
    {
    	$query = $query . " where Year > " . ($_SESSION['decade'] - 1) . " and Year < " . ($_SESSION['decade'] + 10);
    }
	if($_SESSION['sortType'] == 'GenreASC')
	{
		$query = $query . " order by Genre ASC";
	}
	elseif($_SESSION['sortType'] == 'GenreDESC')
	{
		$query = $query . " order by Genre DESC";
	}
	else if($_SESSION['sortType'] == 'TitleASC')
	{
		$query = $query . " order by DVD_Title ASC";
	}
	elseif($_SESSION['sortType'] == 'TitleDESC')
	{
		$query = $query . " order by DVD_Title DESC";
	}
	elseif($_SESSION['sortType'] == 'DecadeASC')
	{
		$query = $query . " order by Year ASC";
	}
	elseif($_SESSION['sortType'] == 'DecadeDESC')
	{
		$query = $query . " order by Year DESC";
	}

	global $result, $count, $first_result, $last_result, $number_pages;		//for using in other parts of the code
    $result = $db->query($query);							//gets ready all the important data
    $count = $result->num_rows;
    $number_pages = ceil($count / $_SESSION['itensPerPage']);


	if(isset($_GET['page']))								//verify if the page is a validy one
	{
		if($_GET['page'] > 0 && $_GET['page'] <= $number_pages)
		{
			$_SESSION['page'] = $_GET['page'];
		}
	}

    																	
    $first_result = ($_SESSION['page'] - 1) * $_SESSION['itensPerPage'];	//needs the atual page, so it has to be under
    $last_result = $first_result + $_SESSION['itensPerPage'];


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
						<a class="navbar-brand default-text-color1" href="#home">Media Tag</a>
					</div>
					<div class="navbar-collapse collapse">
						<div class="nav navbar-nav default-text-color1">
							<li class="active">
								<a href="#home">Home</a>
							</li>
							<li>
								<a href="#shop">Shop</a>
							</li>
							<li>
								<a href="#sell">Sell</a>
							</li>
							<li>
								<a href="#cart">My Cart</a>
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
		<div class="container-fluid">
			<div class="row not-row">			<!--side bar!! -->
					<div class="col-sm-3 col-md-2 sidebar search-box" data-offset-bottom="0">
						<ul class="nav nav-sidebar affix-bottom affix-top affix-left affix-right">
								<form method="get" action="">
									<div class="input-group input-group-md under-nav">
									  <span class="input-group-addon glyphicon glyphicon-search icon"></span>
									  <input type="text" class="form-control" style="margin-top: 2px;" placeholder="Search media">
								</div>
								</form>
								<li class="active"><a href="?sortType=true&sortTitle=true">Sort Alphabetically</a></li>
								<li><a href="?sortType=true&sortDecade=true">Sort by Decade</a></li>
								<li><a href="?sortType=true&sortGenre=true">Sort by Genre</a></li>
								<div class="dropdown">
								  <button class="btn dropdown-toggle sr-only to-button" type="button" id="dropdownMenu1" data-toggle="dropdown">
								    Decade
								  </button>
								  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
								    <li role="presentation"><a role="menuitem" tabindex="-1" href="?decade=2010">2010's</a></li>
								    <li role="presentation"><a role="menuitem" tabindex="-2" href="?decade=2000">2000's</a></li>
								    <li role="presentation"><a role="menuitem" tabindex="-3" href="?decade=1990">90's</a></li>
								    <li role="presentation"><a role="menuitem" tabindex="-4" href="?decade=1980">80's</a></li>
								    <li role="presentation"><a role="menuitem" tabindex="-5" href="?decade=1970">70's</a></li>
								    <li role="presentation"><a role="menuitem" tabindex="-6" href="?decade=1960">60's</a></li>
								    <li role="presentation"><a role="menuitem" tabindex="-7" href="?decade=1950">50's</a></li>
								    <li role="presentation"><a role="menuitem" tabindex="-8" href="?decade=1940">40's</a></li>
								    <li role="presentation"><a role="menuitem" tabindex="-9" href="?decade=1930">30's</a></li>
								    <li role="presentation"><a role="menuitem" tabindex="-10" href="?decade=1920">20's</a></li>
								    <li role="presentation"><a role="menuitem" tabindex="-11" href="?decade=1910">10's</a></li>
								  </ul>
								</div>
						</ul>
					</div>
			</div>			
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">	<!-- main body -->
				<div>
					<h2 class="sub-header share-index">
						Medias
					</h2>
					<div>				<!-- pages index -->
						<?php

							echo " 
									<h5 class=\"numbers\" style=\"margin-left: 200px; color: #33A1DE\">Page</h5>
									<form method=\"get\" action=\"\">
										<input class=\"input-page form-control\" type=\"text\" name=\"page\" />
									</form>
							";

							echo "<h5><a href=\"?page=1\" class=\"numbers\">1</a></h5>";

							if($_SESSION['page'] > 2)			//show number before!!
							{
								if($_SESSION['page'] != 3)
								{
									echo "<h5 class=\"numbers\"> . . .</a></h5>";
								}

								echo "<h5><a href=\"?page=" . ($_SESSION['page'] - 1) . "\" class=\"numbers\">" . ($_SESSION['page'] - 1) . "</a></h5>";
							}

							if($_SESSION['page'] != 1 && $_SESSION['page'] != $number_pages)			//show the pages number
							{

								echo "<h5 class=\"numbers\">" . $_SESSION['page'] ."</h5>";

							}
							if($_SESSION['page'] < ($number_pages - 1))				//show next number!!
							{

								echo "<h5><a href=\"?page=" . ($_SESSION['page'] + 1) . "\" class=\"numbers\">" . ($_SESSION['page'] + 1) . "</a></h5>";

								if($_SESSION['page'] != ($number_pages - 2))
								{
									echo "<h5 class=\"numbers\"> . . .</a></h5>";
								}
							}

							echo "<h5><a href=\"?page=". $number_pages ."\" class=\"numbers\">". $number_pages ."</a></h5>";
						?>
					</div>
				</div>
				<div class="table-responsive">				<!-- table of content -->
					<table class="table table-striped">
						<thead>
							<tr>
								<th></th>
								<th>Name</th>
								<th>Price</th>
								<th>Genre</th>
								<th>Year</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$result->data_seek($first_result);
				            	for ($i = $first_result; $i < $last_result && ($row = $result->fetch_array()); $i ++)
								{
									echo

									"<tr>" .
									"<td><input type=\"checkbox\" name=\"checkbox-".$row["ID"]. "\" value=\"checked\" /></td>" .
									"<td>".$row["DVD_Title"]."</td>".
									"<td>" .$row["Price"]."</td>".
									"<td>".$row["Genre"]."</td>".
									"<td>".$row["Year"]."</td>".

									"</tr>";
								}
							?>


						</tbody>
					</table>
				</div>
				<div class="numbers-bottom">
					<?php

							echo "<h5><a href=\"?page=1\" class=\"numbers\">1</a></h5>";

							if($_SESSION['page'] > 2)			//show number before!!
							{
								if($_SESSION['page'] != 3)
								{
									echo "<h5 class=\"numbers\"> . . .</a></h5>";
								}

								echo "<h5><a href=\"?page=" . ($_SESSION['page'] - 1) . "\" class=\"numbers\">" . ($_SESSION['page'] - 1) . "</a></h5>";
							}

							if($_SESSION['page'] != 1 && $_SESSION['page'] != $number_pages)			//show the pages number
							{

								echo "<h5 class=\"numbers\">" . $_SESSION['page'] ."</h5>";

							}
							if($_SESSION['page'] < ($number_pages - 1))				//show next number!!
							{

								echo "<h5><a href=\"?page=" . ($_SESSION['page'] + 1) . "\" class=\"numbers\">" . ($_SESSION['page'] + 1) . "</a></h5>";

								if($_SESSION['page'] != ($number_pages - 2))
								{
									echo "<h5 class=\"numbers\"> . . .</a></h5>";
								}
							}

							echo "<h5><a href=\"?page=". $number_pages ."\" class=\"numbers\">". $number_pages ."</a></h5>";
						?>
				</div>
				
			</div>
		</div>


		<script type="text/javascript" src="js/jquery-1.11.0.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
	</body>
</html>