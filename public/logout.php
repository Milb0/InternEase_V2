<?php
session_start();
session_unset();
session_destroy();
$Message = urlencode("Session timed out.");
header("Location: index.php?Message={$Message}");
exit();
?>
