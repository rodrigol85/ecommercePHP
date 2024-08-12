<?php

if (!isset($_SESSION['stato'])) {
    header("Location: ../../?page=homepage");
    exit();
}


?>