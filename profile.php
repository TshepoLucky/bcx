<?php
require_once 'core/init.php';

if(!$username = Input::get('user') ){
	Redirect::to('index.php');
} else{
	$user = new User($username);
	if(!$user->exists()){
		Redirect::to(404);
	} else{
		$data = $user->data();
	}
}
?>
<style>
form { 
	margin: 0 auto; 
	width:250px;
}
</style>
<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.1/build/pure-min.css">
<form action="" method="POST" class="pure-form pure-form-aligned">
	<div>
		<!-- Modified Profile to display more fields -->
		<h3> Profile for <?php echo escape($data->username); ?></h3>
		<table class="pure-table pure-table-bordered">
			<tr><td>Full name</td> <td><?php echo escape($data->name); ?></td></tr>
			<tr><td>Name</td> <td><?php echo escape($data->name); ?></td></tr>
			<tr><td>Username</td> <td><?php echo escape($user->data()->username); ?></td></tr>
			<tr><td>Surname</td> <td><?php echo escape($user->data()->surname); ?></td></tr>
			<tr><td>E-mail</td> <td><?php echo escape($user->data()->email); ?></td></tr>
			<tr><td>Cell</td> <td><?php echo escape($user->data()->cell); ?></td></tr>
			<tr><td>Address</td> <td><?php echo escape($user->data()->address); ?></td></tr>
			<tr><td>Job Title</td> <td><?php echo escape($user->data()->jobtitle); ?></td></tr>
			<tr><td>User Role</td> <td><?php echo $user->getRole(); ?></td></tr>
		</table>
		<input type="hidden" name="user" value="<?php echo $username ?>">
	</div>
</form>