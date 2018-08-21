<<<<<<< HEAD
<?php

require_once '/var/www/html/webmania/vendor/autoload.php';

use WebmaniaBR\NFe;

class Notafiscal
{
    public $pedido = array();
    public $settings = array();
    public $nfe;
    public $response;

    public function __construct()
    {

        $this->settings = array(
            'oauth_access_token' => '1174-sl88SZHEX5LMr0QIQgca8w4nTggxPuOiVncxUNZqe2UN0MS8',
            'oauth_access_token_secret' => '7jaARKIhKYEVn2c65nAHuyZ2tvRxgYBXUE8t1VlsxAe2FSRa',
            'consumer_key' => 'ly3yK1fQ1rFc3iCcrUi3QhVxOPUGr6qz',
            'consumer_secret' => 'hqwny0n0fP7mX42zkzz8VbovUzCHyQ3YE1W0GmXySO8XY40j'
        );

        $this->pedido = [
            'operacao'               => 1,
            'natureza_operacao'      => 'Venda de Produtos',
            'modelo'                 => 1,
            'finalidade'             => 1,
            'ambiente'               => 1
        ];

        $this->pedido['pedido'] = [
            'presenca' => 1, // Indicador de presença do comprador no estabelecimento comercial no momento da operação
            'modalidade_frete' => 0, // Modalidade do frete
            'frete' => 0.00, // Total do frete
            'desconto' => 0.00, // Total do desconto
        ];

        $this->nfe = new NFe($this->settings);

    }

    public function cancelarNota($chave, $nProt, $just)
    {
        $retorno = array();
        $this->nfeTools->sefazCancela($chave, $this->tpAmb, $just, $nProt, $retorno);
        return $retorno;
    }

    public function destinatario($dados = array())
    {


        $this->pedido['cliente'] = [
            'cpf' => $dados['cpf'], // (pessoa fisica) Número do CPF
            'cnpj' => $dados['cnpj'], // (pessoa fisica) Número do CPF
            'ie' => $dados['ie'], // (pessoa fisica) Número do CPF
            'nome_completo' => $dados['nome'], // (pessoa fisica) Nome completo
            'endereco' => $dados['endereco_rua'], // Endereço de entrega dos produtos
            'complemento' => $dados['complemento'], // Complemento do endereço de entrega
            'numero' => $dados['endereco_numero'], // Número do endereço de entrega
            'bairro' => $dados['bairro'], // Bairro do endereço de entrega
            'cidade' => $dados['cidade'], // Cidade do endereço de entrega
            'uf' => $dados['uf'], // Estado do endereço de entrega
            'cep' => $dados['cep'], // CEP do endereço de entrega
            'telefone' => $dados['telefone'], // Telefone do cliente
            'email' => $dados['email'], // E-mail do cliente para envio da NF-e
        ];

    }

    public function addProduto($produtos = array())
    {
        foreach ($produtos as $key => $prod) {
            $this->pedido['produtos'][] = array(
                'nome' => $prod['nome_produto'], // Nome do produto
                'origem' => 0,
                'ncm' => (empty($prod['ncm_produto'])) ? '85176262' : $prod['ncm_produto'], // Código NCM
                'quantidade' => $prod['unidade_produto'], // Quantidade de itens
                'unidade' => 'UN', // Unidade de medida da quantidade de itens
                'peso' => 'sem informações',
                'tributos_federais' => "13.25",
                'tributos_estaduais' => "5.00",
                'subtotal' => number_format($prod['preco_produto'], 4, '.', ''), // Preço unitário do produto - sem descontos
                'total' => number_format($prod['unidade_produto'] * $prod['preco_produto'], 2, '.', ''), // Preço total (quantidade x preço unitário) - sem descontos
                'impostos' => array(
                    'icms' => [
                        'codigo_cfop'           => '5.102',
                        'situacao_tributaria'   => '102'
                    ],
                    'ipi'  => [
                        'situacao_tributaria'   => '99',
                        'codigo_enquadramento'  => 999,
                        'aliquota'              => '0.00'
                    ],
                    'pis'  =>  [
                        'situacao_tributaria'   => '99',
                        'aliquota'              => '0.00'
                    ],
                    'cofins' => [
                        'situacao_tributaria'   => '99',
                        'aliquota'              => '0.00'
                    ]
                )
            );
        }

    }

    public function gerarNF()
    {

   
        $this->response = $this->nfe->emissaoNotaFiscal($this->pedido);


        if (isset($this->response->error)) {
            return array('erro' => true, 'msg' => 'Não foi possivel gerar.' . print_r($this->response->error, true));
        } else {
            if ($this->response->status == 'aprovado') {

                $status = (string) $this->response->status; // aprovado, reprovado, cancelado, processamento ou contingencia
                $nfe = (int) $this->response->nfe; // número da NF-e
                $serie = (int) $this->response->serie; // número de série
                $recibo = (int) $this->response->recibo; // número do recibo
                $chave = $this->response->chave; // número da chave de acesso
                $xml = (string) $this->response->xml; // URL do XML
                $danfe = (string) $this->response->danfe; // URL do Danfe (PDF)
                $log = $this->response->log;

                $dirPdf = "/var/www/html/public/pdf/nfe/{$chave}-danfe.pdf";
                file_put_contents($danfe, $dirPdf);

                $retornoConsulta['urlPdf'] = $danfe;
                return array('erro' => false, 'msg' => $retornoConsulta);
            } else {
                return array('erro' => true, 'msg' => 'Não foi possivel gerar.' . print_r($this->response->log, true));

            }
        }
    }
}
=======
<?php

require_once '/var/www/html/webmania/vendor/autoload.php';

use WebmaniaBR\NFe;

class Notafiscal
{
    public $pedido = array();
    public $settings = array();
    public $nfe;
    public $response;

    public function __construct()
    {

        $this->settings = array(
            'oauth_access_token' => '1174-sl88SZHEX5LMr0QIQgca8w4nTggxPuOiVncxUNZqe2UN0MS8',
            'oauth_access_token_secret' => '7jaARKIhKYEVn2c65nAHuyZ2tvRxgYBXUE8t1VlsxAe2FSRa',
            'consumer_key' => 'ly3yK1fQ1rFc3iCcrUi3QhVxOPUGr6qz',
            'consumer_secret' => 'hqwny0n0fP7mX42zkzz8VbovUzCHyQ3YE1W0GmXySO8XY40j',
        );

        $this->pedido = [
            'operacao' => 1,
            'natureza_operacao' => 'Venda de Produtos',
            'modelo' => 1,
            'finalidade' => 1,
            'ambiente' => 1,
        ];

        $this->pedido['pedido'][] = [
            'presenca' => 1, // Indicador de presença do comprador no estabelecimento comercial no momento da operação
            'modalidade_frete' => 0, // Modalidade do frete
            'frete' => 0.00, // Total do frete
            'desconto' => 0.00, // Total do desconto
        ];

        $this->nfe = new NFe($this->settings);

    }

    public function cancelarNota($chave, $nProt, $just)
    {
        $retorno = array();
        $this->nfeTools->sefazCancela($chave, $this->tpAmb, $just, $nProt, $retorno);
        return $retorno;
    }

    public function destinatario($dados = array())
    {

        print_r($dados);
        exit;

        $this->pedido['cliente'] = [
            'cpf' => $dados['cpf'], // (pessoa fisica) Número do CPF
            'cnpj' => $dados['cnpj'], // (pessoa fisica) Número do CPF
            'ie' => $dados['ie'], // (pessoa fisica) Número do CPF
            'nome_completo' => $dados['nome'], // (pessoa fisica) Nome completo
            'endereco' => $dados['endereco_rua'], // Endereço de entrega dos produtos
            'complemento' => $dados['complemento'], // Complemento do endereço de entrega
            'numero' => $dados['endereco_numero'], // Número do endereço de entrega
            'bairro' => $dados['bairro'], // Bairro do endereço de entrega
            'cidade' => $dados['municipio'], // Cidade do endereço de entrega
            'uf' => $dados['uf'], // Estado do endereço de entrega
            'cep' => $dados['cep'], // CEP do endereço de entrega
            'telefone' => $dados['telefone'], // Telefone do cliente
            'email' => $dados['email'], // E-mail do cliente para envio da NF-e
        ];

    }

    public function addProduto($produtos = array())
    {
        foreach ($produtos as $key => $prod) {
            $this->pedido['produtos'][] = array(
                'nome' => $prod['nome_produto'], // Nome do produto
                'ncm' => (empty($prod['ncm_produto'])) ? '85176262' : $prod['ncm_produto'], // Código NCM
                'quantidade' => $prod['unidade_produto'], // Quantidade de itens
                'unidade' => 'UN', // Unidade de medida da quantidade de itens
                'subtotal' => number_format($prod['unidade_produto'], 4, '.', ''), // Preço unitário do produto - sem descontos
                'total' => number_format($prod['unidade_produto'] * $prod['preco_produto'], 2, '.', ''), // Preço total (quantidade x preço unitário) - sem descontos
            );
        }

    }

    public function gerarNF()
    {

        print_r($this->pedido);
        exit;

        $this->response = $this->nfe->emissaoNotaFiscal($this->pedido);

        print_r($this->response);
        exit;

        if (isset($this->response->error)) {
            return array('erro' => true, 'msg' => 'Não foi possivel gerar.' . print_r($this->response->error, true));
        } else {
            if ($this->response->status == 'aprovado') {

                $status = (string) $this->response->status; // aprovado, reprovado, cancelado, processamento ou contingencia
                $nfe = (int) $this->response->nfe; // número da NF-e
                $serie = (int) $this->response->serie; // número de série
                $recibo = (int) $this->response->recibo; // número do recibo
                $chave = $this->response->chave; // número da chave de acesso
                $xml = (string) $this->response->xml; // URL do XML
                $danfe = (string) $this->response->danfe; // URL do Danfe (PDF)
                $log = $this->response->log;

                $dirPdf = "/var/www/html/public/pdf/nfe/{$chave}-danfe.pdf";
                file_put_contents($danfe, $dirPdf);

                $retornoConsulta['urlPdf'] = $danfe;
                return array('erro' => false, 'msg' => $retornoConsulta);
            } else {
                return array('erro' => true, 'msg' => 'Não foi possivel gerar.' . print_r($this->response->log, true));

            }
        }
    }
}
>>>>>>> c3294e0d5ec19a607dbb53ae1fb3cbc802aaddfa
