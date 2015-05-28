<?php
require_once ("../includes/initialize.php");
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

if (isset($_POST['submit'])) {
	$request = Request::find_by_id($_GET['id']);

	$user_id = $_SESSION['user_id'];
	$body = trim($_POST['body']);
	$request_id = $request -> id;

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

<?php include_layout_template('header.php'); ?>
<a href="index.php">&laquo; Back</a><br />
<br />

<?php echo output_message($message); ?>

<h2>View Request <?php echo $request -> id; ?></h2>

<div>
	<table class="bordered" cellpadding="5">
		<tr>
			<td>ID:</td>
			<td><p><?php echo $request -> id; ?></p></td>
		</tr>	
		<tr>
			<td>Subject:</td>
			<td><p><?php echo $request -> subject; ?></p></td>
		</tr>
		<tr>
			<td>Description:</td>
			<td><p><?php echo $request -> description; ?></p></td>
		</tr>
		<tr>
			<td>Expected Solution:</td>
			<td><p><?php echo $request -> expected_solution; ?></p></td>	
		</tr>
		<tr>
			<td>Created:</td>
			<td><p><?php echo datetime_to_text($request -> created); ?></p></td>
		</tr>
     </table>
</div>


<div id="comments">
  <?php foreach($comments as $comment): ?>
    <div class="comment" style="margin-bottom: 2em;">
	    <div class="author">
	      <?php echo htmlentities($comment -> user_id); ?> wrote:
	    </div>
      <div class="body">
				<?php echo strip_tags($comment -> body, '<strong><em><p>'); ?>
			</div>
	    <div class="meta-info" style="font-size: 0.8em;">
	      <?php echo datetime_to_text($comment -> created); ?>
	    </div>
	    <hr style="width: 50%; float: left;">
    </div>
  <?php endforeach; ?>
  <?php
if (empty($comments)) { echo "No Comments.";
}
 ?>
</div>


<div id="comment-form">
  <h3>New Comment</h3>
  <?php echo output_message($message); ?>
  <form action="view_request.php?id=<?php echo $request -> id; ?>" method="post">
    <table>
      <tr>
        <td>Your comment:</td>
        <td><textarea name="body" cols="40" rows="8"><?php echo $body; ?></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="submit" value="Submit Comment" /></td>
      </tr>
    </table>
  </form>
</div>



<?php include_layout_template('footer.php'); ?>
