<?php
require_once ("../../includes/initialize.php");
 ?>
<?php
if (!$session -> is_logged_in()) { redirect_to("login.php");
}
 ?>
 
<?php // 1. the current page number ($current_page)
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

	// 2. records per page ($per_page)
	$per_page = 10;

	// 3. total record count ($total_count)
	$total_count = Request::submitted_requested_count_all($_SESSION['user_id']);

	$pagination = new Pagination($page, $per_page, $total_count);

	// Instead of finding all records, just find the records
	// for this page
	$sql = "SELECT * FROM requests ";
	$sql .= "WHERE user_id={$_SESSION['user_id']} ";
	$sql .= "LIMIT {$per_page} ";
	$sql .= "OFFSET {$pagination->offset()} ";
	$requests = Request::find_by_sql($sql);

	if (empty($requests)) {
		$session -> message("You have not submitted any requests yet.");
		redirect_to('index.php');
	}

	// Need to add ?page=$page to all links we want to
	// maintain the current page (or store $page in $session)
?>


<?php include_layout_template('admin_header.php'); ?>

<a class="ui blue basic button" href="index.php">&laquo; Back</a>
<br />

<?php echo output_message($message); ?>

<div style="min-height: 8rem; padding-bottom: 40px;" class="ui stacked segment">
	<p class="ui ribbon label">Request List</p>	
	<table class="ui celled striped table">
		<thead>
		  <tr>
		  	<th>Subject</th>
		  	<th>Created</th>
		  	<th>Comments</th>
		  	<th>View</th>  	
		  </tr>
	  </thead>
	<?php foreach($requests as $request): ?>
		  <tr>    
		    <td><?php echo $request -> subject; ?></td>
		    <td><?php echo datetime_to_text($request -> created); ?></td>
		    <td>
				<a href="comments.php?id=<?php echo $request -> id; ?>"> 
					<?php  
					if(	count($request -> comments()) == 0){
						echo "No Comments";
					}else {
						echo count($request->comments());
					}?> 
				</a>
			</td>
			<td>		
   			 	<a href="view_request.php?id=<?php echo $request -> id; ?>"><i class="small circular inverted yellow eye icon"></i></a>
    		</td>
		  </tr>  
	<?php endforeach; ?>
	</table>
	
	<div id="pagination">
<ul>	
<?php
if ($pagination -> total_pages() > 1) {

	if ($pagination -> has_previous_page()) {
		echo "<li><a href=\"submitted_requests.php?page=";
		echo $pagination -> previous_page();
		echo "\">&laquo; Previous</a></li> ";
	}

	for ($i = 1; $i <= $pagination -> total_pages(); $i++) {
		if ($i == $page) {
			echo "<li id=\"selected\">{$i}</li> ";
		} else {
			echo "<li><a href=\"submitted_requests.php?page={$i}\">{$i}</a></li> ";
		}
	}

	if ($pagination -> has_next_page()) {
		echo "<li> <a href=\"submitted_requests.php?page=";
		echo $pagination -> next_page();
		echo "\">Next &raquo;</a></li> ";
	}

}
?>
<ul>
</div>

</div><!-- segment -->

<?php include_layout_template('admin_footer.php'); ?>