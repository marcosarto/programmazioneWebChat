<?php

#La funzione serve per creare delle immagini profilo predefinite da associare ad ogni contatto della chat.
#In questo caso prendiamo le iniziali dell'utente e le inscriviamo in un immagine rotonda.
function makeImageFromName($name) {
    $userImage = "";
    $abbreviazione = "";

    $names = explode(" ", $name);

    foreach ($names as $t){
        $abbreviazione .= $t[0];
    }

    $userImage = '<div class="name-image bg-primary">'.$abbreviazione.'</div>'; #Spiegazione di come prese le due iniziali
    #venga ricavata l'immagine rotonda e' rimandata al file CSS contenente la classe del div.
    return $userImage;
}

function makeImageFromNameProfile($name) {
    $userImage = "";
    $abbreviazione = "";

    $names = explode(" ", $name);

    foreach ($names as $t){
        $abbreviazione .= $t[0];
    }

    $userImage = '<div class="name-image-profile bg-primary">'.$abbreviazione.'</div>'; #Spiegazione di come prese le due iniziali
    #venga ricavata l'immagine rotonda e' rimandata al file CSS contenente la classe del div.
    return $userImage;
}
