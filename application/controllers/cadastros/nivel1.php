
<?php

require_once APPPATH . 'controllers/base/BaseController.php';

/**
 * Esta classe é o controler de Servidor. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Nivel1 extends BaseController {

    function Nivel1() {
        parent::Controller();
        $this->load->model('cadastro/nivel1_model', 'nivel1');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
        
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('cadastros/nivel1-lista', $args);

//            $this->carregarView($data);
    }

    function carregarnivel1($nivel1_id) {
        $obj_nivel1 = new nivel1_model($nivel1_id);
        $data['obj'] = $obj_nivel1;        
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('cadastros/nivel1-form', $data);
    }

    function excluir($nivel1) {
        $valida = $this->nivel1->excluir($nivel1);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Classe';
        } else {
            $data['mensagem'] = 'Erro ao excluir a classe. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/nivel1");
    }

    function gravar() {
        $nivel1_id = $this->nivel1->gravar();
        if ($nivel1_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Nível 1. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Nível 1.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/nivel1");
    }

    private function carregarView($data = null, $view = null) {
        if (!isset($data)) {
            $data['mensagem'] = '';
        }

        if ($this->utilitario->autorizar(2, $this->session->userdata('modulo')) == true) {
            $this->load->view('header', $data);
            if ($view != null) {
                $this->load->view($view, $data);
            } else {
                $this->load->view('giah/servidor-lista', $data);
            }
        } else {
            $data['mensagem'] = $this->mensagem->getMensagem('login005');
            $this->load->view('header', $data);
            $this->load->view('home');
        }
        $this->load->view('footer');
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */

