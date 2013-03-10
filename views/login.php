<h3>Login</h3>
<form action="process.php?type=user&method=login" method="POST">
	<label for="email">Email: </label>
	<input type="text" name="email" />
	<label for="pass">Password: </label>
	<input type="password" name="pass" />
	<input class="btn btn-success" type="submit" value="Login" />
</form>

<h3>Register</h3>
<form class="form-horizontal" action="process.php?type=user&method=register" method="POST">
  <div class="control-group">
    <label class="control-label" for="name">Name: </label>
    <div class="controls">
      <input type="text" name="name" />
    </div>
  </div>
  <div class="control-group">
	  <label class="control-label" for="email">Email: </label>
    <div class="controls">
	    <input type="text" name="email" />
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="pass">Password: </label>
    <div class="controls">
      <input type="password" name="pass" />
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="confirmPass">Confirm: </label>
    <div class="controls">
      <input type="password" name="confirmPass" />
    </div>
  </div>
	<input class="btn btn-success" type="submit" value="Register" />
</form>

<?php

?>
