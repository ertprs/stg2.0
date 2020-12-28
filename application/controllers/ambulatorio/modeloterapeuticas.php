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
class Modeloterapeuticas extends BaseController {

    function Modeloterapeuticas() {
        parent::Controller();
        $this->load->model('ambulatorio/modeloterapeuticas_model', 'modeloterapeuticas');
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

        $this->loadView('ambulatorio/modeloterapeuticas-lista', $args);

    }

    function carregarprocedimentos($terapeutica_id){
        $data['terapeuticas'] = $this->modeloterapeuticas->modeloterapeutica($terapeutica_id);
        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
        $data['procedimentoscadastrado'] = $this->modeloterapeuticas->carregarprocedimentosmodelo($terapeutica_id);

        $this->loadView('ambulatorio/modeloterapeuticaprocedimentos-form', $data);
    }

    function gravarprocedimentomodelo(){
        $verificar = $this->modeloterapeuticas->gravarprocedimentomodelo();

        if($verificar > 0){
            $mensagem = 'Sucesso ao Gravar o Procedimento';
        }else{
            $mensagem = 'Erro ao Gravar o Procedimento. Procedimento Já cadastrado.';
        }

        $terapeutica_id = $_POST['terapeutica_id'];
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modeloterapeuticas/carregarprocedimentos/$terapeutica_id");
    }

    function excluirprocedimentomodelo($solicitar_exames_procedimentos_id, $terapeutica_id){
        $verificar = $this->modeloterapeuticas->excluirprocedimentomodelo($solicitar_exames_procedimentos_id);

        if($verificar > 0){
            $mensagem = 'Sucesso ao Excluir o Procedimento';
        }else{
            $mensagem = 'Erro ao Excluir o Procedimento.';
        }
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modeloterapeuticas/carregarprocedimentos/$terapeutica_id");
    }

    function pesquisar2($args = array()) {

        $this->load->View('ambulatorio/modeloterapeuticas-lista2', $args);

    }

    function carregarmodeloterapeuticas($ambulatorio_modelo_terapeuticas_id) {
        $obj_modeloteraupeticas = new modeloterapeuticas_model($ambulatorio_modelo_terapeuticas_id);
        $data['obj'] = $obj_modeloteraupeticas;

        $this->load->View('ambulatorio/modeloterapeuticas-form', $data);
    }

    function excluirmodelo($ambulatorio_modelo_terapeuticas_id) {
        if ($this->modeloterapeuticas->excluir($ambulatorio_modelo_terapeuticas_id)) {
            $mensagem = 'Sucesso ao excluir a Modelo Terapeutica';
        } else {
            $mensagem = 'Erro ao excluir a Modelo Terapeutica. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modeloterapeuticas");
    }



    function gravar() {
        $ambulatorio_modelo_terapeuticas_id = $this->modeloterapeuticas->gravar();
        if ($ambulatorio_modelo_terapeuticas_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Modelosolicitarexames. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Modelosolicitarexames.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modeloterapeuticas");
    }


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
