<form method="post" action="searching.php">
<label> <b>Search Posts: </b> </label>
<input type="text" name="search">
<input type="hidden" name="option" value="user" >
<?php

		echo '<input type="hidden" name="user_id" value= "'.$_GET['id'] . '" >';

?>
<input type="submit" value="submit">
</form>