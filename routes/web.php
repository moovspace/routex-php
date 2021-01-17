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

// API Sample

// Create user token (delete after tests)
$r->Set('/api/token/{id}', 'App/Http/Controller/AuthUser/UserInfo', 'Token');

// Get user info with bearer token
$r->Set('/api/userinfo', 'App/Http/Controller/AuthUser/UserInfo', 'Index');

// Error page

// Show error page
$r->ErrorPage();
