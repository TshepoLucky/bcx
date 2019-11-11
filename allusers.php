<?php
require_once 'core/init.php';

if(Input::exists()){
     Redirect::to('register.php');
}

if(!$username = Input::get('user') ){
	Redirect::to('index.php');
} else{
	$user = new User($username);
	if(!$user->exists()){
		Redirect::to(404);
	} else{
		$data = $user->data();
	}
	
	$cv = $user->canView();
	$cnt = count($cv);
?>
<style>
form { 
	margin: 0 auto; 
	width:1000px;
}
</style>
<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.1/build/pure-min.css">
<form action="" method="POST" class="pure-form pure-form-aligned">
	<div class="field">
		<h3><?php echo escape($data->username); ?> logged in as <?php echo $user->getRole(); ?></h3>
		
		<table class="pure-table pure-table-bordered">
			<thead>
			<tr><th>Name</th><th>Username</th><th>Surname</th><th>E-mail</th><th>Cell</th><th>Address</th><th>Job Title</th><th>Action</th></tr>
			</thead>
<?php
	for($x=0; $x<$cnt; $x++) {
?>
		<tr>
			<td><?php echo $cv[$x]->name     ; ?> </td>
			<td><?php echo $cv[$x]->username ; ?> </td>
			<td><?php echo $cv[$x]->surname  ; ?> </td>
			<td><?php echo $cv[$x]->email    ; ?> </td>
			<td><?php echo $cv[$x]->cell     ; ?> </td>
			<td><?php echo $cv[$x]->address  ; ?> </td>
			<td><?php echo $cv[$x]->jobtitle ; ?> </td>
			<td>
<?php
		if($user->hasPermission('read')) {
?>
			<a href='profile.php?user=<?php echo $cv[$x]->username; ?>'>View</a> &nbsp;
<?php
		}
		if($user->hasPermission('update')) {
?>
			<a href='update.php?user=<?php echo $cv[$x]->username ?>'>Edit</a> &nbsp
<?php
			}
			if($user->hasPermission('delete')) {
?>
				<a href='removeuser.php?user=<?php echo $cv[$x]->username ?>'>Delete</a> &nbsp;
<?php
			}
?>
			</td>
		</tr>
<?php
	}
	
	if($user->hasPermission('create')) {
?>
		<tr><td colspan=8 align="center"><input type="submit" value="Create User" class="pure-button"></td></tr>
<?php
	}
?>
	</table>
<?php
}
?>		
		<input type="hidden" name="user" value="<?php echo $username ?>">
	</div>
</form>