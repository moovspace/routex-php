<?php
require __DIR__.'/../boot/app.php';
use App\Core\Router\Router;
try {
   	$r = new Router();
   	require __DIR__.'/../routes/web.php';
} catch(Exception $e) {
    echo json_encode((object) ['error' => ['message' => $e->getMessage(), 'code' => $e->getCode()]]);
}
