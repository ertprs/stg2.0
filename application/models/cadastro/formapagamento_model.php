<?php

class formapagamento_model extends Model {

    var $_forma_pagamento_id = null;
    var $_nome = null;
    var $_conta_id = null;
    var $_ajuste = null;
    var $_dia_receber = null;
    var $_tempo_receber = null;
    var $_credor_devedor = null;
    var $_taxa_juros = null;
    var $_parcelas = null;
    var $_cartao = null;
    var $_fixar = null;

    function Formapagamento_model($forma_pagamento_id = null) {
        parent::Model();
        if (isset($forma_pagamento_id)) {
            $this->instanciar($forma_pagamento_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('forma_pagamento_id,
                            nome, 
                            ');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('ativo', 'true');
        $this->db->where('forma_pagamento_id !=', 1000); // Essa forma de pagamento é referente a forma de Pagamento "DEBITO"
         $this->db->where('forma_pagamento_id !=', 2000); // Essa forma de pagamento é referente a forma de Pagamento "TCD"
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listargruposasssociados($procedimento_convenio_id) {
        $this->db->select('procedimento_convenio_pagamento_id, fg.nome');
        $this->db->from('tb_procedimento_convenio_pagamento pcp');
        $this->db->join('tb_grupo_formapagamento gp', "gp.grupo_formapagamento_id = pcp.grupo_pagamento_id", 'left');
        $this->db->join('tb_financeiro_grupo fg', "fg.financeiro_grupo_id = gp.grupo_id", 'left');
        $this->db->where('procedimento_convenio_id', $procedimento_convenio_id);
        $this->db->where('pcp.ativo', 't');

        $return = $this->db->get();
        return $return->result();
    }

    function listarformasasssociados($procedimento_convenio_id) {
        $this->db->select('pcp.forma_pagamento_id, pcp.ajuste, f.cartao');
        $this->db->from('tb_procedimento_convenio_forma_pagamento pcp');
        $this->db->join('tb_forma_pagamento f', "f.forma_pagamento_id = pcp.forma_pagamento_id", 'left');
        $this->db->where('procedimento_convenio_id', $procedimento_convenio_id);
        $this->db->where('pcp.ativo', 't');
        $this->db->orderby("f.cartao DESC");        

        $return = $this->db->get();
        return $return->result();
    }

    function listargrupo($args = array()) {
        $this->db->select('financeiro_grupo_id,
                            nome 
                            ');
        $this->db->from('tb_financeiro_grupo');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarforma() {
        $this->db->select('forma_pagamento_id,
                            nome,
                            ajuste,
                            cartao');
        $this->db->from('tb_forma_pagamento');
        $this->db->where("ativo", 't');
        $this->db->orderby("nome");

        $return = $this->db->get();
        return $return->result();
    }

    function listarformanaocredito() {
        $this->db->select('forma_pagamento_id,
                            nome,
                            ajuste,
                            cartao');
        $this->db->from('tb_forma_pagamento');
        $this->db->where("ativo", 't');
        $this->db->where("forma_pagamento_id !=", 1000);
        $this->db->where("forma_pagamento_id !=", 2000);
        $this->db->orderby("nome");

        $return = $this->db->get();
        return $return->result();
        
        
        
        
    }

    function listarformacartao() {
        $this->db->select('forma_pagamento_id,
                            nome,
                            ajuste,
                            cartao');
        $this->db->from('tb_forma_pagamento');
        $this->db->where("ativo", 't');
        $this->db->where("cartao", 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listargrupos() {
        $this->db->select('financeiro_grupo_id,
                            nome');
        $this->db->from('tb_financeiro_grupo');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarformapagamentonogrupo($financeiro_grupo_id) {
        $this->db->select('fp.nome,
                           fp.forma_pagamento_id,
                           gf.grupo_formapagamento_id,
                           gf.grupo_id');
        $this->db->from('tb_grupo_formapagamento gf');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = gf.forma_pagamento_id', 'left');
        $this->db->where('gf.grupo_id', $financeiro_grupo_id);
        $this->db->where('gf.ativo', 'true');
        $this->db->where('fp.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarcredordevedor() {
        $this->db->select('financeiro_credor_devedor_id,
                            razao_social');
        $this->db->from('tb_financeiro_credor_devedor');
        $this->db->where("ativo", 't');
        $return = $this->db->get();
        return $return->result();
    }

    function buscafaixasparcelas($forma_pagamento_id) {
        $this->db->select('*');
        $this->db->from('tb_formapagamento_pacela_juros');
        $this->db->where("ativo", 't');
        $this->db->where("forma_pagamento_id", $forma_pagamento_id);
        $this->db->orderby("parcelas_inicio");
        $return = $this->db->get();
        return $return->result();
    }

    function buscarempresaconta($forma_pagamento_id) {
        $this->db->select('e.nome as empresa, 
                           formapagamento_conta_empresa_id, 
                           fce.conta_id, 
                           fp.nome as forma, 
                           fe.descricao as conta,
                           fe.conta as numero_conta,
                           fe.agencia');
        $this->db->from('tb_formapagamento_conta_empresa fce');
        $this->db->join('tb_empresa e', 'fce.empresa_id = e.empresa_id', 'left');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = fce.conta_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = fce.forma_pagamento_id', 'left');
        $this->db->where("fce.ativo", 't');
        $this->db->where("fce.forma_pagamento_id", $forma_pagamento_id);
        $this->db->orderby("fce.empresa_id");
        $return = $this->db->get();
        return $return->result();
    }

    function buscarempresacontateste($forma_pagamento_id) {
        $this->db->select('formapagamento_conta_empresa_id');
        $this->db->from('tb_formapagamento_conta_empresa fce');
        $this->db->where("fce.ativo", 't');
//        $this->db->where('conta_id', $_POST['conta']);
        $this->db->where('empresa_id', $_POST['empresa']);
        $this->db->where("fce.forma_pagamento_id", $forma_pagamento_id);
        $this->db->orderby("fce.empresa_id");
        $return = $this->db->get();
        return $return->result();
    }

    function cadastrarempresacontaautomatico() {

        $this->db->select('fp.forma_pagamento_id, fe.descricao');
        $this->db->from('tb_forma_pagamento fp');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = fp.conta_id', 'left');
        $this->db->where("fp.ativo", 't');
//        $this->db->orderby("fce.empresa_id");
        $return = $this->db->get()->result();
//        echo '<pre>';
//        var_dump($return);
//        die;

        foreach ($return as $item) {

            $this->db->select('fe.descricao, fe.forma_entradas_saida_id, fe.empresa_id');
            $this->db->from('tb_forma_entradas_saida fe');
            $this->db->where("fe.ativo", 't');
            $this->db->where("fe.descricao", $item->descricao);
//            $this->db->orderby("fce.empresa_id");
            $return2 = $this->db->get()->result();


            foreach ($return2 as $item2) {
                $this->db->set('conta_id', $item2->forma_entradas_saida_id);
                $this->db->set('empresa_id', $item2->empresa_id);
                $this->db->set('forma_pagamento_id', $item->forma_pagamento_id);
                $this->db->insert('tb_formapagamento_conta_empresa');
//                $devedor = $this->db->insert_id();
            }


//            var_dump($return2);
//            die;
        }
    }

    function buscarformapagamentoorcamento($forma_pagamento_id) {
        $this->db->select('forma_pagamento_id,
                            nome,
                            ajuste,
                            parcelas');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('ativo', 'true');
        $this->db->where('forma_pagamento_id', $forma_pagamento_id);
        $return = $this->db->get();
        return $return->result();
    }

    function buscarforma($forma_pagamento_id) {
        $this->db->select('forma_pagamento_id,
                            nome,
                            ajuste,
                            cartao,
                            parcelas');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('ativo', 'true');
        $this->db->where('forma_pagamento_id', "$forma_pagamento_id");
        $return = $this->db->get();
        return $return->result();
    }

    function buscargrupo($financeiro_grupo_id) {
        $this->db->select('financeiro_grupo_id,
                            nome,
                            ajuste');
        $this->db->from('tb_financeiro_grupo');
        $this->db->where('ativo', 'true');
        $this->db->where('financeiro_grupo_id', "$financeiro_grupo_id");
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($forma_pagamento_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('forma_pagamento_id', $forma_pagamento_id);
        $this->db->update('tb_forma_pagamento');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function excluirparcela($parcela_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('formapagamento_pacela_juros_id', $parcela_id);
        $this->db->update('tb_formapagamento_pacela_juros');
    }
    
    function excluircontaempresa($conta_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('formapagamento_conta_empresa_id', $conta_id);
        $this->db->update('tb_formapagamento_conta_empresa');
    }

    function excluirformapagamentodogrupo($grupo_formapagamento_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('grupo_formapagamento_id', $grupo_formapagamento_id);
        $this->db->update('tb_grupo_formapagamento');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function excluirgrupo($grupo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('financeiro_grupo_id', $grupo_id);
        $this->db->update('tb_financeiro_grupo');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('grupo_id', $grupo_id);
        $this->db->update('tb_grupo_formapagamento');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravarparcelas() {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);

        $this->db->set('forma_pagamento_id', $_POST['formapagamento_id']);
        $this->db->set('taxa_juros', $_POST['taxa']);
        $this->db->set('parcelas_inicio', $_POST['parcela_inicio']);
        $this->db->set('parcelas_fim', $_POST['parcela_fim']);
        $this->db->insert('tb_formapagamento_pacela_juros');
    }

    function gravarcontaempresa($formapagamento_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->set('forma_pagamento_id', $formapagamento_id);
        $this->db->set('conta_id', $_POST['conta']);
        $this->db->set('empresa_id', $_POST['empresa']);
        $this->db->insert('tb_formapagamento_conta_empresa');
    }

    function gravargruponome() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->insert('tb_financeiro_grupo');
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                return $this->db->insert_id();
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravargrupoadicionar() {
        try {
            $this->db->select('forma_pagamento_id');
            $this->db->from('tb_grupo_formapagamento');
            $this->db->where('forma_pagamento_id', $_POST['formapagamento']);
            $this->db->where('grupo_id ', $_POST['grupo_id']);
            $return = $this->db->get();
            $result = $return->result();


            if (count($result) == 0) {
                /* inicia o mapeamento no banco */
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');

                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('ajuste', $_POST['ajuste']);
                $this->db->where('financeiro_grupo_id ', $_POST['grupo_id']);
                $this->db->update('tb_financeiro_grupo');

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('forma_pagamento_id', $_POST['formapagamento']);
                $this->db->set('grupo_id ', $_POST['grupo_id']);
                $this->db->insert('tb_grupo_formapagamento');
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $forma_pagamento_id = $_POST['txtcadastrosformapagamentoid'];
            $this->db->set('nome', $_POST['txtNome']);
//            $this->db->set('conta_id', $_POST['conta']);


            $parcelas = $_POST['parcelas'];
//            if ($_POST['parcelas'] == "" || $_POST['parcelas'] == 0) {
//                $parcelas = 1;
//            }
            $diareceber = $_POST['diareceber'];
            $temporeceber = $_POST['temporeceber'];
            if ($_POST['diareceber'] == '' || $_POST['diareceber'] < 0) {
                $diareceber = 0;
            }
            if ($_POST['temporeceber'] == '' || $_POST['temporeceber'] < 0) {
                $temporeceber = 0;
            }
            $ajuste = $_POST['ajuste'];
            if ($_POST['ajuste'] == '') {
                $ajuste = 0;
            }

            $parcela_minima = $_POST['parcela_minima'];
            if ($_POST['parcela_minima'] == '') {
                $parcela_minima = 0;
            }
            $taxa_juros = $_POST['taxa_juros'];
            if ($_POST['taxa_juros'] == '') {
                $taxa_juros = 0;
            }

            if ($_POST['cartao'] == 'on') {
                $cartao = 't';
            } else {
                $cartao = 'f';
            }

            if ($_POST['tcd'] == 'on') {
                $tcd = 't';
            } else {
                $tcd = 'f';
            }
            
            if ($_POST['recebimento_antecipado'] == 'on') {
                $this->db->set('recebimento_antecipado', 't');
            } else {
                $this->db->set('recebimento_antecipado', 'f');
            }

            if ($_POST['arrendondamento'] == 'on') {
                $arredondamento = 't';
            } else {
                $arredondamento = 'f';
            }
//            var_dump($arredondamento); die;

            $this->db->set('ajuste', $ajuste);
            if ($parcelas > 0) {
                $this->db->set('parcelas', $parcelas);
            } else {
                $this->db->set('parcelas', 1);
            }


            $this->db->set('parcela_minima', str_replace(",", ".", str_replace(".", "", $parcela_minima)));
            $this->db->set('taxa_juros', $taxa_juros);
            $this->db->set('fixar', $arredondamento);
            $this->db->set('cartao', $cartao);
            $this->db->set('tcd', $tcd);
            if ($_POST['credor_devedor'] != '') {
                $this->db->set('credor_devedor', $_POST['credor_devedor']);
            } else {
                $this->db->set('credor_devedor', null);
            }
            $this->db->set('dia_receber', $diareceber);
            $this->db->set('tempo_receber', $temporeceber);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtcadastrosformapagamentoid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_forma_pagamento');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $forma_pagamento_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
//                $forma_pagamento_id = $_POST['txtcadastrosformapagamentoid'];
                $this->db->where('forma_pagamento_id', $forma_pagamento_id);
                $this->db->update('tb_forma_pagamento');
            }
            return $forma_pagamento_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($forma_pagamento_id) {

        if ($forma_pagamento_id != 0) {
            $this->db->select('forma_pagamento_id,
                               nome, 
                               conta_id,
                               ajuste, 
                               dia_receber, 
                               parcela_minima, 
                               tempo_receber, 
                               credor_devedor,
                               fixar,
                               taxa_juros,
                               parcelas,
                               cartao,
                               tcd,
                               recebimento_antecipado');
            $this->db->from('tb_forma_pagamento');
            $this->db->where("forma_pagamento_id", $forma_pagamento_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_forma_pagamento_id = $forma_pagamento_id;
            $this->_nome = $return[0]->nome;
            $this->_conta_id = $return[0]->conta_id;
            $this->_ajuste = $return[0]->ajuste;
            $this->_dia_receber = $return[0]->dia_receber;
            $this->_fixar = $return[0]->fixar;
            $this->_tempo_receber = $return[0]->tempo_receber;
            $this->_credor_devedor = $return[0]->credor_devedor;
            $this->_taxa_juros = $return[0]->taxa_juros;
            $this->_parcelas = $return[0]->parcelas;
            $this->_parcela_minima = $return[0]->parcela_minima;
            $this->_cartao = $return[0]->cartao;
            $this->_tcd = $return[0]->tcd;
            $this->_recebimento_antecipado = $return[0]->recebimento_antecipado;
        } else {
            $this->_forma_pagamento_id = null;
        }
    }
    
     function listarformasocredito() {
        $this->db->select('forma_pagamento_id,
                            nome,
                            ajuste,
                            cartao');
        $this->db->from('tb_forma_pagamento');
        $this->db->where("ativo", 't');
        $this->db->where("forma_pagamento_id", 1000);
        $this->db->orderby("nome");

        $return = $this->db->get();
        return $return->result();
      
    }
     function listarformasotcd() {
        $this->db->select('forma_pagamento_id,
                            nome,
                            ajuste,
                            cartao');
        $this->db->from('tb_forma_pagamento');
        $this->db->where("ativo", 't');
        $this->db->where("forma_pagamento_id", 2000);
        $this->db->orderby("nome");

        $return = $this->db->get();
        return $return->result();
      
    }
    
    
    

}

?>
