<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends RestController
{
	function __construct()
	{
		// Construct the parent class
		parent::__construct();
		$this->load->database();
	}


	public function users_get()
	{
		// Users from a data store e.g. database
		$users = [
			['id' => 0, 'name' => 'John', 'email' => 'john@example.com'],
			['id' => 1, 'name' => 'Jim', 'email' => 'jim@example.com'],
		];

		$id = $this->get('id');

		if ($id === null) {
			// Check if the users data store contains users
			if ($users) {
				// Set the response and exit
				$this->response($users, 200);
			} else {
				// Set the response and exit
				$this->response([
					'status' => false,
					'message' => 'No users were found'
				], 404);
			}
		} else {
			if (array_key_exists($id, $users)) {
				$this->response($users[$id], 200);
			} else {
				$this->response([
					'status' => false,
					'message' => 'No such user found'
				], 404);
			}
		}
	}

	public function checkGateOut_get()
	{
		$serviceNumber = $this->get('serviceNumber');
		if(empty($serviceNumber)){
			$this->response([
				'status' => false,
				'message' => 'Service Number Required!'
			], 404);
			exit();
		}
		$this->db->where('no_bl_awb', $serviceNumber);
		$this->db->where_in('flag_transfer',['2','5']);
		$checkGateOut = $this->db->get('get_imp_out')->result();
		if(count($checkGateOut) == 0){
			$this->response([
				'status' => false,
				'message' => 'No users were found'
			], 404);
			exit();
		}
		$this->response([
			'status' => true,
			'message' => 'Data'
		], 200);

	}
}
