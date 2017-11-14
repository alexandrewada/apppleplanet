<?php

class Login extends CI_Controller {
	public function Index() {

		if($this->input->post() == true) {
			$this->load->model('Login_Model');
			$this->load->model('Usuario_Model');

			$Logar = $this->Login_Model->Login($this->input->post('email'),$this->input->post('senha'));

			if(is_array($Logar) == true) {
				$Logar['logado'] = true;
				$this->session->set_userdata($Logar);

				// Contar Acessos
				$this->Usuario_Model->contarAcesso($Logar['id_usuario']);
				
				redirect('/');
			} else {
				$this->load->view('Login/index',array('erro' => '<b style=\'color: red;\'>Algo está errado revise o email e a senha.</b>'));	
			}

		} else {
			$this->load->view('Login/index');
		}
	}
}