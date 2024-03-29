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
class Modelosolicitarexames extends BaseController {

    function Modelosolicitarexames() {
        parent::Controller();
        $this->load->model('ambulatorio/modelosolicitarexames_model', 'modelosolicitarexames');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
        
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('ambulatorio/modelosolicitarexames-lista', $args);

//            $this->carregarView($data);
    }

    function carregarprocedimentos($exame_modelosolicitarexames_id){
        $data['solexames'] = $this->modelosolicitarexames->modelosolicitacao($exame_modelosolicitarexames_id);
        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
        $data['procedimentoscadastrado'] = $this->modelosolicitarexames->carregarprocedimentosmodelo($exame_modelosolicitarexames_id);

        $this->loadView('ambulatorio/modeloexamesprocedimentos-form', $data);
    }

    function gravarprocedimentomodelo(){
        $verificar = $this->modelosolicitarexames->gravarprocedimentomodelo();

        if($verificar > 0){
            $mensagem = 'Sucesso ao Gravar o Procedimento';
        }else{
            $mensagem = 'Erro ao Gravar o Procedimento. Procedimento Já cadastrado.';
        }

        $exames_id = $_POST['exames_id'];
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelosolicitarexames/carregarprocedimentos/$exames_id");
    }

    function excluirprocedimentomodelo($solicitar_exames_procedimentos_id, $exames_id){
        $verificar = $this->modelosolicitarexames->excluirprocedimentomodelo($solicitar_exames_procedimentos_id);

        if($verificar > 0){
            $mensagem = 'Sucesso ao Excluir o Procedimento';
        }else{
            $mensagem = 'Erro ao Excluir o Procedimento.';
        }
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelosolicitarexames/carregarprocedimentos/$exames_id");
    }

    function pesquisar2($args = array()) {

        $this->load->View('ambulatorio/modelosolicitarexames-lista2', $args);

//            $this->carregarView($data);
    }

    function carregarmodelosolicitarexames($exame_modelosolicitarexames_id) {
        $obj_modelosolicitarexames = new modelosolicitarexames_model($exame_modelosolicitarexames_id);
        $data['obj'] = $obj_modelosolicitarexames;
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
//        $this->load->View('ambulatorio/modeloatestado-form', $data);
        $this->load->View('ambulatorio/modelosolicitarexames-form', $data);
    }

    function excluirmodelo($exame_modelosolicitarexames_id) {
        if ($this->modelosolicitarexames->excluir($exame_modelosolicitarexames_id)) {
            $mensagem = 'Sucesso ao excluir a Modelo solicitar exames';
        } else {
            $mensagem = 'Erro ao excluir a Modelo solicitar exames. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelosolicitarexames");
    }

    function ativarmodeloexameautomatico($modeloexame_id) {
        $this->modelosolicitarexames->ativarmodeloexameautomatico($modeloexame_id);
        redirect(base_url() . "ambulatorio/modelosolicitarexames");
    }

    function desativarmodeloexameautomatico($modeloexame_id) {
        $this->modelosolicitarexames->desativarmodeloexameautomatico($modeloexame_id);
        redirect(base_url() . "ambulatorio/modelosolicitarexames");
    }

    function gravar() {
        $exame_modelosolicitarexames_id = $this->modelosolicitarexames->gravar();
        if ($exame_modelosolicitarexames_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Modelosolicitarexames. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Modelosolicitarexames.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modelosolicitarexames");
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
