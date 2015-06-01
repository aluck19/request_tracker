<?php
require_once ("../../includes/initialize.php");
 ?>
<?php
if (!$session -> is_logged_in() || $_SESSION['role']!="admin") { redirect_to("login.php");
}
 ?>

<?php	
	// 1. the current page number ($current_page)
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

	// 2. records per page ($per_page)
	$per_page = 10;

	// 3. total record count ($total_count)
	$total_count = User::count_all();
		
	
	$pagination = new Pagination($page, $per_page, $total_count);
	
	// Instead of finding all records, just find the records 
	// for this page
	$sql = "SELECT * FROM users ";
	$sql .= "LIMIT {$per_page} ";
	$sql .= "OFFSET {$pagination->offset()}";
	$users = User::find_by_sql($sql);
	
	if (empty($users)) {
		$session -> message("There are no users in user vault.");
		redirect_to('index.php');
	}
	
	// Need to add ?page=$page to all links we want to 
	// maintain the current page (or store $page in $session)
	
?>

<?php include_layout_template('admin_header.php'); ?>

<a class="ui blue basic button" href="index.php">&laquo; Back</a>
<br />

<?php echo output_message($message); ?>

<br>

<form method="get" action="search.php">
    <input  name="username" value="" >
    <input type="submit">
 </form>

<div style="min-height: 8rem; padding-bottom: 40px;" class="ui stacked segment">
	<p class="ui ribbon label">User List</p>
	<table class="ui celled striped table">
		<thead>
		  <tr>
		  	<th>ID</th>
		  	<th>Username</th>
		  	<th>First Name</th>  	
		  	<th>Last Name</th>
		  	<th>Role</th>
		  	<th>Created By</th>
		  	<th>Created On</th>
		  	<th>Edit</th>
		  	<th>Delete</th>  	
		  </tr>
	  	</thead>
	<?php foreach($users as $user): ?>
	  <tr>    
	    <td><?php echo $user -> id; ?></td>
	    <td><?php echo $user -> username; ?></td>	   
	    <td><?php echo $user -> first_name; ?></td>
	    <td><?php echo $user -> last_name; ?></td>
	    <td><?php echo $user -> role; ?></td>

	    <td><?php  $creater = $user -> created_by; 
	    	if($creater == 0){
	    		echo "System";
	    	}
			else {
				$user_creater = User::find_by_id($creater);
				echo $user_creater -> first_name;
			}
			
	    	?></td>

	    <td><?php echo datetime_to_text($user -> created); ?></td>
	    <td><a href="edit_users.php?id=<?php echo $user -> id; ?>"><i class="small circular inverted orange edit icon"></i></a></td>	
		<td><a href="delete_users.php?id=<?php echo $user -> id; ?>" onclick="return confirm('Are you sure?');"><i class="small circular inverted red remove icon"></i></a></td>
	  </tr>  
	<?php endforeach; ?>
	</table>
	<div id="pagination">
<ul>	
<?php
	if($pagination->total_pages() > 1) {
		
		if($pagination->has_previous_page()) { 
    	echo "<li><a href=\"list_users.php?page=";
      echo $pagination->previous_page();
      echo "\">&laquo; Previous</a></li> "; 
    }

		for($i=1; $i <= $pagination->total_pages(); $i++) {
			if($i == $page) {
				echo "<li id=\"selected\">{$i}</li> ";
			} else {
				echo "<li><a href=\"list_users.php?page={$i}\">{$i}</a></li> "; 
			}
		}

		if($pagination->has_next_page()) { 
			echo "<li> <a href=\"list_users.php?page=";
			echo $pagination->next_page();
			echo "\">Next &raquo;</a></li> "; 
    }
		
	}

?>
<ul>
</div>

</div> <!-- segment -->

<?php include_layout_template('admin_footer.php'); ?>