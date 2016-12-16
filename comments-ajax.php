<?php
require_once 'db_config.php';
require_once 'class.paging.php';
//fetch news from db
$pagination = new paginate($db,"SELECT * FROM comments where news_id = {$_GET["nid"]}","id desc",5);
?>
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