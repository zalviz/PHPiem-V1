<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Attendee extends PHPIEM_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function Index()
	{
	}

	public function Personal_data($s1)
	{
		switch ($s1) {
			case 'update':
				# code...
				break;
			default:
				# code...
				break;
		}
	}

	public function Payment_Confirmation($s1)
	{
		switch ($s1) {
			case 'submit':
				# code...
				break;
			default:
				# code...
				break;
		}
	}

	public function Feedback($s1)
	{
		switch ($s1) {
			case 'give-feedback':
				# code...
				break;
			case 'submit':
				# code...
				break;
			case 'view':
				# code...
				break;
			default:
				# code...
				break;
		}
	}
}