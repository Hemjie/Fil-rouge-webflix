<?php
    require "../partials/header.php";

    if (!isAdmin()) {
        display403();
    } 
?>

<?php
    require "../partials/footer.php";
?>
