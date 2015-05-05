<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\Usuario;
use Crossfit\Dados\Configuracao;
use Crossfit\Util\Response;
use Crossfit\App;

class UsuarioController
{
	public function retornaUsuarioLogado()
	{
		$response = new Response();

		$usuario = App::getSession()->get('usuario');
		$configuracao = App::getSession()->get('configuracoes');
		$response->setData(array('usuario' => $usuario, 'configuracao' => $configuracao));

		return $response->getAsJson();
	}

	public function carregaUsuarios(Request $request) 
	{
		$response = new Response();
		$usuarios = \Crossfit\Dados\Usuario::retornaTodos(App::getSession()->get('organizacao'));
		$response->setData($usuarios);
		return $response->getAsJson();
	}

	public static function carregaCadUsuario($id_usuario)
	{
		$response = new Response();
		$resultado = \Crossfit\Dados\Usuario::retornaSelecionado($id_usuario);
		$response->setData($resultado);
		return $response->getAsJson();
	}

	public static function salvaUsuario(Request $request)
	{
		$response = new Response();
		$dataset = json_decode($request->getContent(), true);
		$dataset['id_organizacao'] = App::getSession()->get('organizacao');

		if (isset($dataset["senha"])) {
			$dataset["senha"] = md5($dataset["senha"]);
		}

		$resultado = Usuario::salvaUsuario($dataset);
		$response->setData($resultado);
		return $response->getAsJson();
	}

	public function atualizaUsuario(request $request, $id_usuario)
	{
		$response = new Response();
		$dataset = json_decode($request->getContent(), true);
		$changePassword = $request->query->get('changePassword');
		if($changePassword){
			return $this->atualizaSenha($id_usuario, $dataset);
		} else {
			$usuarioDataset = array(
				'nome' => $dataset['nome'],
				'usuario' => $dataset['usuario'],
			);

			if (isset($dataset["senha"]) && isset($dataset["confirmacaoSenha"])) {
				unset($dataset["confirmacaoSenha"]);
				$usuarioDataset["senha"] = md5($dataset["senha"]);
			}


			$resultado = Usuario::atualizaUsuario($id_usuario, $usuarioDataset);
			if($resultado) {
				$usuario = Usuario::retornaSelecionado($id_usuario);

				App::getSession()->set('usuario', $usuario);

				$response->setData($usuario);
			}
			return $response->getAsJson();
		}

	}

	public function atualizaSenha($id_usuario, $dataset)
	{
		$response = new Response();

		$usuario = Usuario::retornaSelecionado($id_usuario);
		
		if($usuario['senha'] == md5($dataset['senhaAtual'])) {
			$resultado = Usuario::atualizaSenha($id_usuario, $dataset['novaSenha']);	
			return $response->getAsJson();
		} else {
			$response->addMessage('danger', 'Erro ao atualizar senha', 'Nova senha deve ser igual a senha de confirmação.');
			return $response->getAsJson();
		}
	}

	public static function removeUsuario($id_usuario)
	{
		$response = new Response();
		$resultado = Usuario::removeUsuario($id_usuario);
		return $response->getAsJson();
	}
}