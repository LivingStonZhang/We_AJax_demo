<?php 
require_once 'db_config.php';
require_once 'class.paging.php';
//fetch news from db

$sql = "select * from news where id = ?";
$stmt = $db->prepare($sql);
$stmt->execute(array($_GET["nid"]));

try{
	$news = $stmt->fetch(PDO::FETCH_ASSOC);
}catch(PDOException $exception){
	echo $exception->getMessage();
	die();
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Contact Form</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    

    <div class="container">
		<h1><?php echo $news["title"]?></h1>
		<p><?php echo time()?></p>
		<div>
			<?php echo nl2br($news["content"])?>
		</div>
		
		<br/>
		<h4>Comments</h4>
     	
     	<div id="comments">
     		<img src="https://i0.wp.com/cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif"> Loading...
      	</div>
      	
      	
     	
    </div><!-- /.container -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  
    <script>

    var loading = '<img src="https://i0.wp.com/cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif"> Loading...'
        
    function loadComments(page) {
        //place loading sign in comment container
    	$("#comments").html(loading)
        
        //ajax request to get comments
        //1. remote url
        //2. call function 
        $.get("comments-ajax.php?nid=<?php echo $_GET["nid"]?>&page="+page,function(data){
        	$("#comments").html(data)
       	})
    }
    
    $().ready(function() {
        loadComments(1)
		
        $("#comments").on("click","ul.pagination a",function(){
            var page = $(this).attr("data-page")
            loadComments(page)
			return false;
        })
		
    })
       
    </script>
   
  </body>
</html>
