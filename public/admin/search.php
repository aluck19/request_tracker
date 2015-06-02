<?php
require_once ("../../includes/initialize.php");
 ?>
<?php
if (!$session -> is_logged_in() || $_SESSION['role'] != "admin") { redirect_to("login.php");
}

if (isset($_POST['submit'])) {
	$username = trim($_POST['username']);

	// for this page
	$sql = "SELECT * FROM users where username = '{$username}' ";

	$users = User::find_by_sql($sql);

	if (empty($users)) {
		$message = "User not found.";
	}
}
 elseif(!empty($_GET['username'])) {
	
	$username = $_GET['username'];	

	$sql = "SELECT * FROM users where username = '{$username}' ";

	$users = User::find_by_sql($sql);

	if (empty($users)) {
		$message = "User not found.";
	}
} else {
	$username = "";
	
	$sql = "SELECT * FROM users where username = '{$username}' ";
	$users = User::find_by_sql($sql);	
}
?>

<?php include_layout_template('admin_header.php'); ?>

<!-- <?php echo  $_GET['username']; ?> -->

<a class="ui blue basic button" href="index.php">&laquo; Back</a>
<br />

<?php echo output_message($message); ?>

<div style="min-height: 8rem; padding-bottom: 40px;" class="ui stacked segment">
	<p class="ui ribbon label">User List</p>
		<br>
	<br>
	<form method="get" action="search.php">

<div class="ui left icon input">
  <input placeholder="Search..." type="text" name="username" value="" required="">
  <i class="search icon"></i>
</div>    
    <input class="ui blue button" type="submit"/>
 </form>


<?php
	if (!empty($users)) {
		$output = "<table class=\"ui celled striped table\">";
		$output .= "<thead>
					<tr> 	
						<th>ID</th>
					  	<th>Username</th>
					  	<th>First Name</th>  	
					  	<th>Last Name</th>
					  	<th>Role</th>
		    		</tr> 	
		   		 </thead>";
		echo $output;
	}
?>
	
	
	
	<?php foreach($users as $user): ?>
	  <tr>    
	  	 <td><?php echo $user -> id; ?></td>
	    <td><?php echo $user -> username; ?></td>	   	   
	    <td><?php echo $user -> first_name; ?></td>
	    <td><?php echo $user -> last_name; ?></td>
	    <td><?php echo $user -> role; ?></td>
	  </tr>  
	<?php endforeach; ?>
	</table>

</div> <!-- segment -->

<?php include_layout_template('admin_footer.php'); ?>