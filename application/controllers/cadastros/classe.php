
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
class Classe extends BaseController {

    function Classe() {
        parent::Controller();
        $this->load->model('cadastro/classe_model', 'classe');
        $this->load->model('cadastro/nivel1_model', 'nivel1');
        $this->load->model('cadastro/nivel2_model', 'nivel2');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
         
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('cadastros/classe-lista', $args);

//            $this->carregarView($data);
    }

    function carregarclasse($financeiro_classe_id) {
        $obj_classe = new classe_model($financeiro_classe_id);
        $data['obj'] = $obj_classe;
        $data['tipo'] = $this->classe->listartipo();
        $data['nivel1'] = $this->nivel1->listarnivel1();
        $data['nivel2'] = $this->nivel2->listarnivel2();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('cadastros/classe-form', $data);
    }

    function excluir($financeiro_classe_id) {
        $valida = $this->classe->excluir($financeiro_classe_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Classe';
        } else {
            $data['mensagem'] = 'Erro ao excluir a classe. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/classe");
    }

    function gravar() {
        $exame_classe_id = $this->classe->gravar();
        if ($exame_classe_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Classe. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Classe.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/classe");
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

