<?php
//all the variables are here....
$hash = '';
$user = 'admin'; //change 'myaccount' to your username
$pass = 'password'; //change 'mypass'to your password
$random1 = 'neehoyfantrakikitinoleileimootikananana';  //random word 1. No need to change
$random2 = 'vennistdaasnurnstuckgitunslotermyeryabierhunddaasoderdieflipperwaldgershput';  //random word 2. No need to change
$hash = md5($random1.$pass.$random2);
$self = $_SERVER['REQUEST_URI'];

?>
