<?php
/**
 * Created by IntelliJ IDEA.
 * User: micha
 * Date: 2/25/2018
 * Time: 5:18 PM
 */

$mysqli = new mysqli('localhost', 'wustl_inst', 'wustl_pass', 'recipino');
mysqli_set_charset($mysqli, 'utf8');
if($mysqli->connect_errno) {
    printf("Connection Failed: %s\n", $mysqli->connect_error);
    exit;
}

?>
