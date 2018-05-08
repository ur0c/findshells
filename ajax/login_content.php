<?

session_start();

?>



<form method="post" action="/cms/login_action.php">
  <div class="form-group">
    <label for="pwd">Username:</label>
    <input name="passwd" type="password" class="form-control" id="pwd">
    <label for="pwd">Password:</label>
    <input name="passwd" type="password" class="form-control" id="pwd">
  </div>
  <button type="submit" class="btn btn-default" id="dologin">Ok!</button>
</form>



