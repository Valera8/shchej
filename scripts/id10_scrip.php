<?php
    $int1 = $_POST['int1'];
    $int2 = $_POST['int2'];
    $x = ($int1 + $int2);
    header ("Location: id10_dex.php?x=$x");
