<?php
namespace App\Http\Controller\AuthUser;

use Exception;
use App\Core\Auth\Auth;
use App\Core\Auth\Token;

class UserInfo
{
	/**
	 * Test with
	 * path: /api/userinfo
	 * curl -v --cookie -X POST http://router.xx/api/userinfo -H "Authorization: Bearer f488494099e15a780d3833bd60cdb50f1719290c2af6cdd2f9bfdc0e5349f827"
	 *
	 * @return void
	 */
	function Index()
	{
		try
		{
			$token = Token::BearerToken();

			$user = Auth::IsAuthorized();

			$user->pass = "";

			return json_encode( $user );
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	/**
	 * Create sample token (delete after tests)
	 * path: /api/userinfo
	 * curl -v --cookie -X GET http://router.xx/api/token/2
	 *
	 * @return String Token hash
	 */
	function Token()
	{
		try
		{
			global $r;

			$id = (int) $r->GetParam('{id}');

			if($id > 0)
			{
				$token = Token::Update($id);

				return json_encode( $token );
			}
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
}