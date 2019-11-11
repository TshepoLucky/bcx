<?php
require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}
else{
	#Retrieving data if user is not editing their own details
	$user = new User(Input::get('user'));
	$data = $user->data();
}

if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(			
                'required' => true,
                'min' => 2,
                'max' => 50
            ), 
			#Added extra fields to be validated
			'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20
            ),
            'surname' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            ),
            'email' => array(
                'required' => true,
                'min' => 2,
                'max' => 100
            ),
            'cell' => array(
                'required' => true,
                'min' => 2,
                'max' => 10
            ),
            'address' => array(
                'required' => false,
                'min' => 2,
                'max' => 200
            ),
            'jobtitle' => array(
                'required' => false,
                'min' => 2,
                'max' => 100
            )
        ));

        if($validation->passed()){
            try{				
                $user->update(array(
                    'name' => Input::get('name'),			#Fixed a typo name1 to name
					'username' => Input::get('username'),
					#added required fields 
					'surname' => Input::get('surname'),
					'email' => Input::get('email'),
					'cell' => Input::get('cell'),
					#added optional fields 
					'address' => Input::get('address'),
					'jobtitle' => Input::get('jobtitle')),
					
					#Added ID parameter for updating relevant record
					$user->data()->id
				);

                Session::flash('home', 'Your details have been updated');
                Redirect::to('index.php');

            } catch(Exception $e){
                die($e->getMessage());
            }
        } else{
            foreach($validation->errors() as $error){
                echo $error, "<br>";
            }
        }
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
	<h1>Edit Details</h1>
    <div>
		<table>
			<tr><td> <label for="name">Name :</label> </td><td><input type="text" name="name" value="<?php echo escape($user->data()->name); ?>"></td></tr>

			<!-- Added extra fields -->
			<tr><td><label for="username">Username :</label></td><td><input type="text" name="username" value="<?php echo escape($user->data()->username); ?>"></td></tr>
			<tr><td><label for="surname">Surname :</label></td><td><input type="text" name="surname" value="<?php echo escape($user->data()->surname); ?>"></td></tr>
			<tr><td><label for="email">Email :</label></td><td><input type="text" name="email" value="<?php echo escape($user->data()->email); ?>"></td></tr>
			<tr><td><label for="cell">Cell :</label></td><td><input type="text" name="cell" value="<?php echo escape($user->data()->cell); ?>"></td></tr>
			<tr><td><label for="address">Address : </label></td><td><input type="text" name="address" value="<?php echo escape($user->data()->address); ?>"></td></tr>
			<tr><td><label for="jobtitle">Job Title :</label></td><td><input type="text" name="jobtitle" value="<?php echo escape($user->data()->jobtitle); ?>"></td></tr>
<?php
	$role = $user->getRole();	
	if($role == 'Administrator'){
		$admin = 'selected';
?>
		<tr><td> <label for="roles">User Roles :</label> </td>
			<td>
				<select name="roles">
					<option value=""> Select Roles</option>
					<option value="Adminstrator" <?php echo $admin ?>> Adminstrator</option>
					<option value="Support">Support </option>
					<option value="Manager">Manager </option>
					<option value="User">User </option>
					<option value="Custom">Custom </option>	
				</select>
			</td>
		</tr>
		
<?php
		}else {
?>
		<tr><td><label for="jobtitle">User Role :</label></td><td><label for="jobtitle"><?php echo $role; ?> </label></td></tr>
<?php	
	}
?>		
		<tr><td colspan="2" align="center"><input type="submit" value="Update"></td></tr>
			
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    </div>
</form>