<?php

class Juros_Model extends CI_Model {

	public $taxaCartaoCreditoParcelado 		= 4.39;	
	public $taxaCartaoCreditoVista 			= 4;
	public $taxaCartaoDebito  				= 2;


	public function jurosCartao($id_formapagamento,$parcela,$valor) {
		
		if($id_formapagamento == '2') {

			switch ($parcela) {
				case '1':
					$TaxaParcela = 0.00;
				break;

				case '2':
					$TaxaParcela = 3.33;
				break;

				case '3':
					$TaxaParcela = 4.41;
				break;

				case '4':
					$TaxaParcela = 5.47;
				break;

				case '5':
					$TaxaParcela = 6.52;
				break;

				case '6':
					$TaxaParcela = 7.55;
				break;

				case '7':
					$TaxaParcela = 8.56;
				break;

				case '8':
					$TaxaParcela = 9.57;
				break;
			
				case '9':
					$TaxaParcela = 10.55;
				break;

				case '10':
					$TaxaParcela = 11.52;
				break;

				case '11':
					$TaxaParcela = 12.48;
				break;

				case '12':
					$TaxaParcela = 13.42;
				break;

					
				default:
					$TaxaParcela = 0;
				break;
			}

			if($parcela == 1){
				$JurosCartao 	= ($this->taxaCartaoCreditoVista)/100;
			} else {
				$JurosCartao 	= ($this->taxaCartaoCreditoParcelado)/100;
			}



			$TaxaTotal = $JurosCartao + $TaxaParcela;


			return ($valor*$TaxaTotal)/100;
			
		} else if($id_formapagamento == '1') {
			$JurosCartao    = ($valor*$this->taxaCartaoDebito)/100;
			return ($JurosCartao);
		} else {
			return 0;
		}
	}

}