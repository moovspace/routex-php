<?php
// Request
if(!empty($_GET)) { print_r($_GET); }
if(!empty($_POST)) { print_r($_POST); }
// Json string
echo file_get_contents("php://input");