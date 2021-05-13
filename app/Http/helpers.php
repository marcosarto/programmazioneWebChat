<?php

function makeImageFromName($name) {
    $userImage = "";
    $abbreviazione = "";

    $names = explode(" ", $name);

    foreach ($names as $t){
        $abbreviazione .= $t[0];
    }

    $userImage = '<div class="name-image bg-primary">'.$abbreviazione.'</div>';
    return $userImage;
}
