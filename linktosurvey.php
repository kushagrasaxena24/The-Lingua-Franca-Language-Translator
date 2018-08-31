<?php


if(isset($_SESSION))
{
    //session_unset();
    session_destroy();}
header('Location:https://'."ufl.qualtrics.com/jfe/form/SV_4JzBEYZJadYH833");
exit;



?>