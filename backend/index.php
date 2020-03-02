<?php

require './main.php';
require './utils/connection.php';

$main = new Main($con);

$response = $main->indentifyMethodAndVars($_SERVER['REQUEST_METHOD'], json_decode(file_get_contents('php://input')));
echo ($response);

?>