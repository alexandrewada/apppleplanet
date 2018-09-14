<?php

function getInfoLoja($id_loja) {

    $id_loja = $_SESSION['id_loja'];

    switch ($id_loja) {
        case '1':
            return 'IPLANET COMERCIO VAREJISTA DE PRODUTOS ELETRONICOS LTDA - EPP | CNPJ: 24.909.865/0001-33 | Telefone (11) 3582-2084 <br>Rua Clodomiro Amazonas,1158, Loja 3 - Itaim Bibi - CEP: 04537-002 - São Paulo/SP';
        break;

        case '2':
            return 'IPLANET COMERCIO VAREJISTA DE PRODUTOS ELETRONICOS LTDA - EPP | CNPJ: 24.909.865/0001-33 | Telefone (11) 3473-6473 <br>Rua Joaquim Nabuco, 192, Brooklin Paulista, São Paulo';
        break;
        
        default:
            # code...
        break;
    }
}

?>