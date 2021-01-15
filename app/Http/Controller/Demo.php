<?php
namespace App\Http\Controller;

use Exception;
use App\Http\Model\DemoModel;

class Demo
{
	function Index()
	{
		try
		{
			// Router
			global $r;

			// Get url param if exists
			$id = $r->GetParam('{id}');
			$name = $r->GetParam('{name}');

			// Rows
			$users = DemoModel::Users(2);

			// Send email
			$sent = DemoModel::Mail();

			// Post request
			$obj =  json_decode(DemoModel::CurlPostJson());

			// Show as json
			DemoModel::AddJsonHeader();

			// Json response
			return json_encode( [ 'info' => 'REST API Php router works awesome! ', 'sent' => $sent, 'data' => $obj, 'id' => (int) $id, 'name' => $name, 'users' => $users ] );
		}
		catch (Exception $e)
		{
			throw $e;
			// echo $e->getMessage()
		}
	}
}