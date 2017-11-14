<?php

class Autoexec
{
    public $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ChecarPendenciaAprovacaoOrcamento();
    }

    public function ChecarPendenciaAprovacaoOrcamento()
    {

    	$paginaAtual      = strtolower($this->ci->router->fetch_class().'/'.$this->ci->router->fetch_method());

    	if($paginaAtual != 'os/aprovacao' AND $paginaAtual != 'principal/sair' AND $_SESSION['logado'] == true) {

	    	$this->ci->load->model('Os_Model');
	    	$os = $this->ci->Os_Model;

	    	if($os->aprovacaoOrcamento($_SESSION['id_usuario']) != false) {
	    		redirect(base_url('os/aprovacao'));
	    	}

    	}

    }
}
