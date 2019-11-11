<?php
require_once 'core/init.php';

if(Session::exists('home')){
    echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User();
if($user->isLoggedIn()){
?>
    <p>
		Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>">
		<?php echo escape($user->data()->username); ?></a>!
	</p>
    <ul>
        <li><a href="logout.php">Log out</a></li>
        <li><a href="update.php">Update Details</a></li>
        <li><a href="changepassword.php">Change Password</a></li>
<?php
	#Added page for users with permissions
	if($user->data()->group > 1){
?>
        <li><a href="allusers.php?user=<?php echo escape($user->data()->username); ?>">All Users</a></li>	
<?php
		}
?>		
    </ul>
<?php
}
else {
    echo "<p>You need to <a href='login.php'>login</a> or  <a href='register.php'>register</a>";
}