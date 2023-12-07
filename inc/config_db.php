<?php
$conn = mysqli_connect('localhost','root','root','ex_project');
if(!$conn){
    echo "Error".mysqli_connect_error();
}
?>