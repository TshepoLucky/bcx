<?php
require_once 'core/init.php';

$user = new User();

if(Input::exists()){
    if(Token::check(Input::get('token'))){
		try{
			$user->update(array(
				'archived' => Input::get('archived')),
				Input::get('user_id')
			);

			$user->logout();
			Session::flash('home', 'User Deleted Successfully.');
			Redirect::to('index.php');

		} catch(Exception $e){
			die($e->getMessage());
		}
    }
}
else{
	#Retrieving data if user is not editing their own details
	$user = new User(Input::get('user'));
	$data = $user->data();
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
	
		<br><h1 align="center"> Delete User </h1><br>
		<table class="pure-table pure-table-bordered">
			<tr><td>Name :    </td> <td><?php echo escape($user->data()->name); ?>     </td></tr>
			<tr><td>Username :</td> <td><?php echo escape($user->data()->username); ?> </td></tr>
			<tr><td>Surname : </td> <td><?php echo escape($user->data()->surname); ?>  </td></tr>
			<tr><td>E-mail :  </td> <td><?php echo escape($user->data()->email); ?>    </td></tr>
			<tr><td>Cell :    </td> <td><?php echo escape($user->data()->cell); ?>     </td></tr>
			<tr><td>Address : </td> <td><?php echo escape($user->data()->address); ?>  </td></tr>
			<tr><td>Job Title :</td> <td><?php echo escape($user->data()->jobtitle); ?> </td></tr>
			<tr><td colspan="3" align="center"> <input type="submit" value="Delete User" class="pure-button"> </td></tr>
		</table>
		
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		
		<!-- Added hidden field to Remove/archive the user -->
        <input type="hidden" name="archived" value="1">
		<input type="hidden" name="user_id" value="<?php echo escape($user->data()->id); ?>">
		
    </div>
</form>