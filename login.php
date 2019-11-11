<?php
require_once 'core/init.php';
ini_set("log_errors", 1);
ini_set("error_log", "/logs/php.log");

if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array('required' => true),
            'password' => array('required' => true)
        ));
		
        if($validation->passed()){
            $user = new User();

            $remember = (Input::get('remember') === 'on') ? true : false;
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            if($login){
                Redirect::to('index.php');
            }else {
				echo "Access Denied";
				error_log("Access Denied",0,'logs/php.log');
            }
        }else {
            foreach($validation->errors() as $error){
                echo $error, "<br>";
				error_log($error,0,'logs/php.log');
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
	<h1> Log in </h1>
    <div>
        <label for="username">Username</label>
        <input type="text" name="username" id="username" autocomplete="off">
    </div>
    <br>
    <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
    </div>
    <br>
    <div>
        <label for="remember">
            <input type="checkbox" name="remember" id="remember"> Remember Me
        </label>
    </div>
    <br>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Log in" class="pure-button">
</form>