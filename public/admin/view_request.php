<?php
require_once ("../../includes/initialize.php");
 ?>
 <?php
if (!$session -> is_logged_in()) { redirect_to("login.php");
}
 ?>
<?php
if (empty($_GET['id'])) {
	$session -> message("No request ID was provided.");
	redirect_to('index.php');
}

$request = Request::find_by_id($_GET['id']);
$request_id = $request -> id;

if (!$request) {
	$session -> message("The request could not be located.");
	redirect_to('index.php');
}

//to get the FULL NAME for the notification
$user = User::find_by_id($request -> user_id);
$first_name = $user -> first_name;
$last_name = $user-> last_name;
$user-> full_name();

if (isset($_POST['submit'])) {
	$request = Request::find_by_id($_GET['id']);
	$user_id = $_SESSION['user_id'];
	$body = trim($_POST['body']);

	$new_comment = Comment::make($request_id, $user_id, $body);

	if ($new_comment && $new_comment -> save()) {
		// comment saved
		$session -> message("Comment was posted sucessfully.");
		// Important!  You could just let the page render from here.
		// But then if the page is reloaded, the form will try
		// to resubmit the comment. So redirect instead:
		redirect_to("view_request.php?id={$request->id}");

	} else {
		// Failed
		$message = "There was an error that prevented the comment from being saved.";
	}
} else {
	$body = "";
}

$comments = $request -> comments();
?>

<?php include_layout_template('admin_header.php'); ?>

<a class="ui blue basic button" href="index.php">&laquo; Back</a>
<br>

<?php echo output_message($message); ?>

<div style="min-height: 8rem;" class="ui stacked segment">
	<p class="ui ribbon label">View Request: <?php echo $request -> subject; ?></p>
	
<div class="ui form" style="margin-top: 10px">
	<div class="field">
		<label>Subject</label>
		<p><?php echo $request -> subject; ?></p>
		
	</div>
	<div class="field">
		<label>Description</label>
		<p><?php echo $request -> description; ?></p>
		
	</div>
	<div class="field">
		<label>Expected Solution</label>
		<p><?php echo $request -> expected_solution; ?></p>
		
	</div>
	<div class="field">
		<label>Created By</label>
			<a href="view_profile.php?id=<?php echo $user->id?>"><p><?php echo $user-> full_name(); ?></p></a>
	</div>
</div>

<h3>Comments</h3>
<div class="ui feed" style="margin-top: 10px;">
  <?php foreach($comments as $comment): ?>
    <div class="event">
        <div class="label">
          <i class="pencil icon"></i>
        </div>
        <div class="content">
          <div class="summary">
          	 <?php $user = User::find_by_id($comment -> user_id);
			echo htmlentities($user -> first_name);
 ?> 
            wrote 
            <div class="date">
             at <?php echo datetime_to_text($comment -> created); ?>
            </div>
          </div>
          <div class="extra text">
            	<?php echo strip_tags($comment -> body, '<strong><em><p>'); ?>
          </div>
          </div>
         </div>
  <?php endforeach; ?>
  <?php
if (empty($comments)) { echo "No Comments.";
}
 ?>
 
 <?php 
 if($_SESSION['user_id'] == $request->user_id)
 
 echo  "<a href=\"delete_request.php?id={$request -> id}\" onclick=\"return confirm('Are you sure?');\">
 	<div style=\"float:right;\" class=\"negative ui button\">Close Request</div></a>";
 
 
 ?>
</div><!-- feed -->


<div class="ui form">
  <h4>New Comment</h4>
  <form action="view_request.php?id=<?php echo $request -> id; ?>" method="post">
    	<div class="field">
         <textarea name="body" cols="40" rows="8"><?php echo $body; ?></textarea></td>
     </div>
     <div >
		<input class="ui green submit button"  type="submit" name="submit" value="Submit Comment" />
	 </div>
  </form>
</div>


</div> <!-- segment -->

<?php include_layout_template('admin_footer.php'); ?>