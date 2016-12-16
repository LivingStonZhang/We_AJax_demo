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

$pagination = new paginate($db,"SELECT * FROM comments where news_id = {$_GET["nid"]}","id desc");
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
     	<div class="pagination"><span class="showing_records">
		    Showing records <?php echo $pagination->firstItem() ?>—<?php echo $pagination->lastItem() ?> of <?php echo $pagination->total() ?></span>
		</div>
     	<ul>
     		<?php foreach ($pagination->dataRows() as $comment):?>
     			<li>
     			<p><?php echo $comment["content"]?> ~ by <?php echo $comment["name"]?></p></li>
     		<?php endforeach;?>
     	</ul>
     	
     	<?php echo $pagination->links()?>
    </div><!-- /.container -->


   
  </body>
</html>
