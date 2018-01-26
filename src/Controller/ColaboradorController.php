<?php 
	namespace App\Controller;

	use Simple\ORM\TableRegistry;

	class ColaboradorController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow(['login']);
		}
		
		public function login()
		{
			$cadastro = TableRegistry::get('Cadastro');

			if ($this->request->is('POST')) {
				$dados = $this->request->getData();
				
				if (!empty($dados['cnpj']) && !empty($dados['login']) &&
					!empty($dados['senha']) 
			 	) {
					$cadastro = $cadastro->validaCadastro($dados['cnpj']);

					if ($cadastro) {
						if ($cadastro->status !== 8) {
							$colaborador = $this->Colaborador->validaAcesso(
								$cadastro->cod_cadastro, $dados['login'], $dados['senha']
							);

							if ($colaborador) {
								$colaborador->cadastro = $cadastro;

								$this->Auth->setUser($colaborador);
								$this->Ajax->response('login', [
									'redirect' => $this->Auth->loginRedirect()
								]);
							}
							else {
								$this->Ajax->response('login', [
									'status' => 'error',
									'message' => 'Usuário ou senha incorreto, tente novamente.'
								]);
							}
						}
						else {
							$this->Ajax->response('login', [
								'status' => 'error',
								'message' => 'Desculpe, este contrato foi cancelado, renove-o para continuar usando.'
							]);
						}
					}
					else {
						$this->Ajax->response('login', [
							'status' => 'error',
							'message' => 'Nenhum contrato foi encontrado com o CNPJ informado.'
						]);
					}
				}
				else {
					$this->Ajax->response('login', [
						'status' => 'error',
						'message' => 'Os campos CNPJ, usuário e senha, são obrigatórios.'
					]);
				}
			}
			else {
				return $this->redirect('default');
			}
		}

		public function logout()
		{
			$this->Auth->destroy();

			return $this->redirect($this->Auth->logoutRedirect());
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['logout']);
		}
	}