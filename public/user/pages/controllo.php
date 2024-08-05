<?php

if (!isset($_SESSION['role']) || !isset($_SESSION['stato'])) {
    header("Location: ../../?page=homepage");
    exit();
}


?>
