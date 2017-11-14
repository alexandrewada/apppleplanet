<?php

class Relatorio extends CI_Controller {
	public function Index() {
			$this->load->model("Relatorio_Model");
			$this->template->set('titulo','eaea');


			$view['TotalVendas'] 		= $this->Relatorio_Model->getTotalVendasHoje();
			$view['TotalPecas']			= $this->Relatorio_Model->getTotalPecas();
			$view['TotalProdutos']		= $this->Relatorio_Model->getTotalProdutos();
			$view['TotalLucroHoje']		= $this->Relatorio_Model->getValorTotalLucroHoje();
			$view['TotalValorVendas']	= $this->Relatorio_Model->getValorTotalVendasHoje();
			$view['TotalClientes']		= $this->Relatorio_Model->getTotalClientes();
			$view['TotalOsFaturadas']   = $this->Relatorio_Model->getOsFaturadas();
			$view['TotalOsAberta']		= $this->Relatorio_Model->getOsAberta();
			$view['TotalProdutoBrinde'] = $this->Relatorio_Model->getTotalProdutoBrindeHoje();
			$view['TotalPecaBrinde']    = $this->Relatorio_Model->getTotalPecaBrindeHoje();
			$view['TotalPecaGarantia']  = $this->Relatorio_Model->getTotalPecaGarantiaHoje();
			$view['TotalProdutoGarantia']  = $this->Relatorio_Model->getTotalProdutoGarantiaHoje();

			$this->template->load('template','Relatorio/Index',$view);
				
	}


	public function VendasProdutos() {
		$this->load->model("Relatorio_Model");
		$view['VendasProdutos'] = $this->Relatorio_Model->VendasProdutos();
		$this->template->load('template','Relatorio/VendasProdutos',$view);
	}

	public function AssistenciasFaturadas() {
		$this->load->model("Relatorio_Model");
		$view['AssistenciasFaturadas'] = $this->Relatorio_Model->AssistenciasFaturadas();
		$this->template->load('template','Relatorio/AssistenciasFaturadas',$view);
	}

}