<?php
ERROR_REPORTING(0);
require_once 'core/init.php';
$user = new User();

if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20
            ),
            'password' => array(
                'required' => true,
                'min' => 8   #Change the paasword minimun from 6 to 8
            ),
            'password_again' => array(
                'required' => true,
                'matches' => 'password'
            ),
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            ),
			#Added extra fields to be validated
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
            $salt = Hash::salt(32);
			
            try{
                
                $user->create(array(
                    'username' => Input::get('username'),
                    'password' => Hash::make(Input::get('password'), $salt),
                    'salt' => $salt,
                    'name' => Input::get('name'),
                    'joined' => date('Y-m-d H:i:s'),
                    'group' => 1,
					
					#added required fields
					'surname' => Input::get('surname'),
					'email' => Input::get('email'),
					'cell' => Input::get('cell'),
					
					#added optional fields
					'address' => Input::get('address'),
					'jobtitle' => Input::get('jobtitle')
                ));

                Session::flash('home','You have been registered and can now log in!');
                Redirect::to('index.php');

            }catch(Exception $e){
                die($e->getMessage());
            }
        } else {
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
	<h1>Register User</h1><br>
	
	<table>
        <tr>
			<td> <label for="username">Username *</label> </td>
			<td> <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off"> </td>
		</tr>
	
		<tr>
			<td><label for="name">Name *</label></td>
			<td><input type="text" name="name" id="name" value="<?php echo escape(Input::get('name')); ?>"></td>
		</tr>

	<!-- Added Surname field -->
		<tr>
			<td><label for="surname">Surname *</label> </td>
			<td><input type="text" name="surname" id="surname" value="<?php echo escape(Input::get('surname')); ?>"> </td>
		</tr>
	
	<!-- Added Email field -->
		<tr>
			<td><label for="email">E-mail *</label> </td>
			<td><input type="text" name="email" id="email" value="<?php echo escape(Input::get('email')); ?>"> </tr>
		</tr>
	
	<!-- Added Cell field -->
		<tr>
			<td><label for="name">Cell * </label></td>
			<td><input type="text" name="cell" id="cell" value="<?php echo escape(Input::get('cell')); ?>"></td>
		</tr>
	
	<!-- Added Address field -->
		<tr>
			<td><label for="address">Address</label> </td>
			<td><input type="text" name="address" id="address" value="<?php echo escape(Input::get('address')); ?>"> </td>
		</tr>
	
	<!-- Added Job Title field -->
		<tr>
			<td><label for="jobtitle">Job</label> </td>
			<td><input type="text" name="jobtitle" id="jobtitle" value="<?php echo escape(Input::get('jobtitle')); ?>"> </td>
		</tr>
	
		<tr>
			<td><label for="password">Password *</label> </td>
			<td><input type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[0-9]).{8,}" title="Password with 8+ char including a special char and number"> </td>
		</tr>

		<tr>
			<td><label for="password_again">Confirm password *</label> </td>
			<td><input type="password" name="password_again" id="password_again" pattern="(?=.*\d)(?=.*[a-z])(?=.*[0-9]).{8,}" title="Password with 8+ char including a special char and number"> </td>
		</tr>
<?php
	$role = $user->getRole();	
	if($role == 'Administrator' || $role == 'Manager'){
?>
		<tr>
			<td> <label for="roles">User Roles :</label> </td>
			<td>
				<select name="roles">
					<option value=""> Select Roles</option>
					<option value="Adminstrator"> Adminstrator</option>
					<option value="Support">Support </option>
					<option value="Manager">Manager </option>
					<option value="User">User </option>
					<option value="Custom">Custom </option>	
				</select>
			</td>
		</tr>
		
<?php
		}
?>
	
		<tr><td colspan=2 align="center"><input type="submit" value="Register" class="pure-button"></td></tr>
	</table>
	
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    
</form>