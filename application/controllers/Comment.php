<?php

class Comment extends CI_Controller {
    public function Cadastrar() {
        header("Content-type: application/json");
        $this->load->model('Comment_Model');
        $return = $this->Comment_Model->Comentar($this->input->post('origem'),
            $this->session->userdata()['id_usuario'],
            $this->input->post('id_os'),
            $this->input->post('comentario')
        );

        if($return == true){
            $script = '<script>$("#comment").click();</script>';
            echo json_encode(array('erro' => false, 'msg' => 'Enviada com sucesso!'.$script));
        } else {
            echo json_encode(array('erro' => true, 'msg' => 'Erro ao adicionar !'));
        }
    }
}