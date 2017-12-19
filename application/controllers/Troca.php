<?php

class Troca extends CI_Controller {
	public function Cadastrar(){
		$this->load->model("Loja_Model");
		$this->load->model("Perfil_Model");
		$this->load->model("Categoria_Model");
		$this->load->model("Produto_Model");
			

		$view['lojas'] 				= $this->Loja_Model->getAll();
		$view['perfil'] 			= $this->Perfil_Model->getAll();
		$view['Categorias'] 		= $this->Categoria_Model->getAll();
		$view['produtos_troca']		= $this->Produto_Model->getProdutosTrocas();

		$this->template->set('titulo','Troca');
		$this->template->load('template','Troca/Cadastrar',$view);
	}
}