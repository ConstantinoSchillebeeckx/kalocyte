<div class="container">

<?php
echo "<h1>API test of rspace.com</h1>";

$result = meow();

// Will dump a beauty json :3
var_dump(json_decode($result, true));

?>

</div>
