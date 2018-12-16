<?php foreach($seminar as $seminare) : 
    
    echo $seminare['SeminarName'];
    echo ("</br>");
    echo $seminare['LehrstuhlName'];
    echo ("</br>");
    echo $seminare['Beschreibung'];
    echo ("</br>");
    echo $seminare['Soll-Teilnehmerzahl'];
    echo ("</br>");
    echo $seminare['Semester'];
    echo ("</br>");




endforeach; ?>