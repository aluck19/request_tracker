<?php require_once("../../includes/initialize.php"); ?>
<?php if (!$session->is_logged_in() ) { redirect_to("login.php"); } ?>
<?php
	// must have an ID
  if(empty($_GET['id'])) {
  	$session->message("No request ID was provided.");
    redirect_to('index.php');
  }

  $request = Request::find_by_id($_GET['id']);
  if($request && $request->delete()) {
  	 $rq_subject = ucfirst($request-> subject);	
	 
	 if(empty($rq_subjectq)){
	 	$rq_subject = "No subject";
	 }
	  
     $session->message("The request \"{$rq_subject}\" was deleted.");
    redirect_to('list_requests.php');
  } else {
    $session->message("The request could not be deleted.");
    redirect_to('list_requests.php');
  }
  
?>
<?php if(isset($database)) { $database->close_connection(); } ?>
