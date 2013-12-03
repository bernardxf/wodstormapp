<?php
namespace Crossfit\Util;

use Symfony\Component\HttpFoundation\JsonResponse;

class Response
{
	private $messages = array();
	private $data;
	private $success = true;

	public function addMessage($type, $message){
		$this->messages[$type][] = $message;
	}

	public function setData($data){
		$this->data = $data;
	}

	public function setSuccess($success)
	{
		$this->success = $success;
	}

	public function getAsJson(){
		$response = array();
		$response['messages'] = $this->messages;
		$response['data'] = $this->data;
		$response['success'] = $this->success;

		return new JsonResponse($response);
	}
}