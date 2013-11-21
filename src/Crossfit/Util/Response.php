<?php
namespace Crossfit\Util;

use Symfony\Component\HttpFoundation\JsonResponse;

class Response
{
	private $messages = array();
	private $data;

	public function addMessage($type, $message){
		$this->messages[$type][] = $message;
	}

	public function setData($data){
		$this->data = $data;
	}

	public function getAsJson(){
		$response = array();
		$response['messages'] = $this->messages;
		$response['data'] = $this->data;

		return new JsonResponse($response);
	}
}