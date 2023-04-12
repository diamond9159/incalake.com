<?php 

 /**
	Request CodeIgnater 2.x  GET | POST | PUT | DELETE
	Microframework CI INCALAKE
*/
	
class Request
{
	public static function get($value) 
	{
		switch (strtolower($_SERVER['REQUEST_METHOD'])) {
			case 'post':
				return $_POST[$value];
			break;
			case 'get':
				return $_GET[$value]; 
			break;
		}
	}
}