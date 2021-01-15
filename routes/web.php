<?php
// Redirect (delete line below)
// $r->Redirect('/','/demo');

// Homepage
$r->Set('/', 'App/Http/Controller/Demo', 'Index');

// Default methods GET, POST, PUT
$r->Set('/demo', 'App/Http/Controller/Demo', 'Index');

// Only POST, GET request
$r->Set('/home/{id}', 'App/Http/Controller/Demo', 'Index', ['POST', 'GET']);

// Only POST, GET request
$r->Set('/home/{id}/book/{name}', 'App/Http/Controller/Demo', 'Index', ['POST', 'GET']);

// Function
$r->Set('/phpversion', function(){ echo phpversion(); });

// Show error page
$r->ErrorPage();
