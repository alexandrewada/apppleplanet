<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function Index()
	{


					$this->load->model("Relatorio_Model");
					$this->template->set('titulo','eaea');


					switch ($this->session->userdata()['id_perfil']) {
						case '2':
							redirect("relatorio");
						break;

						case '1':
							$this->template->load('template','Principal/cliente',$view);
						break;
						
						case '4':
							$this->template->load('template','Principal/atendimento',$view);
						break;

						case '5':
							$this->template->load('template','Principal/atendimento',$view);
						break;

						
						default:
							$this->template->load('template','Principal/cliente',$view);
						break;
					}

					}


	public function Sair() {

		unset($_SESSION);
		session_destroy();
		$this->session->set_userdata(array('logado' => false));
		$this->session->unset_userdata('logado');
		redirect('/Login');
	}
}
