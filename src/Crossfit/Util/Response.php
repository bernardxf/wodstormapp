<?php
namespace Crossfit\Util;

use Symfony\Component\HttpFoundation\Response as SResponse;

class Response
{
	private $messages = array();
	private $data;
	private $success = true;

	public function addMessage($type, $title, $message){
		$this->messages[] = array("type" => $type, "title" => $title, "message" => $message);
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

		return new SResponse(json_encode($response));
	}
}