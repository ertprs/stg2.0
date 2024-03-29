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
class Setor extends BaseController
{

    function Setor()
    {
        parent::Controller();
        $this->load->model('ponto/setor_model', 'setor');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
         
    }

    function index()
    {
        $this->pesquisar();
    }


    function pesquisar($args = array())
    {

        $this->loadView('ponto/setor-lista', $args);

//            $this->carregarView($data);
    }

    function carregar($setor_id)
    {
        $obj_setor = new setor_model($setor_id);
        $data['obj'] = $obj_setor;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ponto/setor-form', $data);
    }

    function excluir($setor_id)
    {
        if ($this->setor->excluir($setor_id)) {
            $mensagem = 'Sucesso ao excluir a setor.';
        } else {
            $mensagem = 'Erro ao excluir a setor. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ponto/setor");
    }

    function gravar()
    {
        $setor_id = $this->setor->gravar();
        //    { $mensagem = 'servidor003';}
        if ($setor_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o setor. Opera&ccedil;&atilde;o cancelada.';
        }
        //    { $mensagem = 'servidor002';}
        else {
            $data['mensagem'] = 'Sucesso ao gravar o setor.';
        }
        //{ $mensagem = 'servidor001';}
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ponto/setor");

        //$this->carregarView();
        //redirect(base_url()."giah/servidor/index/$data","refresh");
    }

    private function carregarView($data=null, $view=null)
    {
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