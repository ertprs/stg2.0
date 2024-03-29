<?php

require_once APPPATH . 'models/base/BaseModel.php';

//require_once APPPATH . 'models/base/ConvertXml.php';



class internacao_model extends BaseModel {

    var $_paciente_id = null;
    var $_nome = null;

    function internacao_model($emergencia_solicitacao_acolhimento_id = null) {
        parent::Model();
        if (isset($emergencia_solicitacao_acolhimento_id)) {
            $this->instanciar($emergencia_solicitacao_acolhimento_id);
        }
    }

    function listarultimoprecadastro($paciente_id, $internacao_ficha_id) {


        $this->db->select('idade_inicio, tipo_dependencia, grau_parentesco, ocupacao_responsavel, nome');
        $this->db->from('tb_internacao_ficha_questionario ');
        if ($internacao_ficha_id > 0) {
            $this->db->where('internacao_ficha_questionario_id', $internacao_ficha_id);
        } else {
            $this->db->where('paciente_id', $paciente_id);
        }
        $this->db->orderby('data_cadastro desc');
        $this->db->limit(1);

        $return = $this->db->get()->result();

        return $return;
    }

    function excluirinternacao($internacao_id, $paciente_id, $leito_id) { 
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('internacao_id', $internacao_id);
        $this->db->set('leito_id', $leito_id);
        $this->db->set('tipo', 'SAIDA');
        $this->db->set('status', 'SAIDA');
        $this->db->set('data', $horario);
        $this->db->set('operador_movimentacao', $operador_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_internacao_leito_movimentacao');

        //Tabela internação alteração

        $this->db->set('excluido', 't'); 
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('operador_exclusao', $operador_id);
        $this->db->set('data_exclusao', $horario);
        $this->db->where('internacao_id', $internacao_id);
        $this->db->update('tb_internacao');

        //Tabela Ocupação alteração
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('ocupado', 'f');
        $this->db->where('paciente_id', $paciente_id);
        $this->db->update('tb_internacao_ocupacao');

        //Tabela internacao_leito

        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('ativo', 't');
        $this->db->where('internacao_leito_id', $leito_id);
        $this->db->update('tb_internacao_leito');
    }

    function gravar($paciente_id) {
        $empresa_id = $this->session->userdata('empresa_id'); 
        try {

            $this->db->select('dinheiro');
            $this->db->from('tb_convenio');
            $this->db->where('convenio_id', $_POST['convenio1']);
            $convenio = $this->db->get()->result();


            $this->db->select('valortotal');
            $this->db->from('tb_procedimento_convenio');
            $this->db->where('procedimento_convenio_id', $_POST['procedimento1']);
            $return = $this->db->get()->result();
//            var_dump($return); die;

            $this->db->set('particular', $convenio[0]->dinheiro);
            $this->db->set('leito', $_POST['leitoID']);
            $this->db->set('codigo', $_POST['sisreg']);
            $this->db->set('aih', $_POST['aih']);
            $this->db->set('senha', $_POST['senha']);
            $this->db->set('prelaudo', $_POST['central']);
            $this->db->set('medico_id', $_POST['operadorID']);
            $this->db->set('data_internacao', date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $_POST['data']))));
            $this->db->set('forma_de_entrada', $_POST['forma']);
            $this->db->set('estado', $_POST['estado']);
            $this->db->set('carater_internacao', $_POST['carater']);
            $this->db->set('procedimento_convenio_id', $_POST['procedimento1']);
            if (count($return) > 0) {
                $this->db->set('valor_total', @$return[0]->valortotal);
            }

            $this->db->set('cid1solicitado', $_POST['cid1ID']);
            $this->db->set('cid2solicitado', $_POST['cid2ID']);
            $this->db->set('justificativa', $_POST['observacao']);
            $this->db->set('nome_responsavel', $_POST['nome_responsavel']);
            $this->db->set('cep_responsavel', $_POST['cep_responsavel']);
            $this->db->set('logradouro_responsavel', $_POST['logradouro_responsavel']);
            $this->db->set('numero_responsavel', $_POST['numero_responsavel']);
//            $this->db->set('complemento_responsavel', $_POST['complemento_responsavel']);
            $this->db->set('bairro_responsavel', $_POST['bairro_responsavel']);
            $this->db->set('rg_responsavel', $_POST['rg_responsavel']);
//            $this->db->set('cpf_responsavel', $_POST['cpf_responsavel']);
            $this->db->set('cpf_responsavel', str_replace("-", "", str_replace(".", "", $_POST['cpf_responsavel'])));
            $this->db->set('email_responsavel', $_POST['email_responsavel']);
            $this->db->set('celular_responsavel', $_POST['celular_responsavel']);
            $this->db->set('telefone_responsavel', $_POST['telefone_responsavel']);
            $this->db->set('grau_parentesco', $_POST['grau_parentesco']);
            $this->db->set('ocupacao_responsavel', $_POST['ocupacao_responsavel']);
            $this->db->set('empresa_id', $empresa_id);

            if ($_POST['municipio_responsavel_id'] != '') {
                $this->db->set('municipio_responsavel_id', $_POST['municipio_responsavel_id']);
            }

            if (@$_POST['alerta'] != '') {
                $this->db->set('internacao_alerta_id', $_POST['alerta']);
            }
 
            
            if (isset($_POST['tipo_dependencia'])) { 
                  $tipo_json = json_encode($_POST['tipo_dependencia']);
                    if (@$_POST['tipo_dependencia'] > 0) {
                        $this->db->set('tipo_dependencia', $tipo_json);
                    }
             }
            if (isset($_POST['idade_inicio'])) {  
                if ($_POST['idade_inicio'] > 0) {
                    $this->db->set('idade_inicio', $_POST['idade_inicio']);
                } 
            } 
            
            
            $this->db->set('paciente_id', $paciente_id);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['internacao_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);

                $this->db->insert('tb_internacao');

                $internacao_id = $this->db->insert_id();

                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else
                    $internacao_id = $this->db->insert_id();
                $this->db->set('ativo', 'false');
                $this->db->where('internacao_leito_id', $_POST['leitoID']);
                $this->db->update('tb_internacao_leito');

                $this->db->set('paciente_id', $paciente_id);
                $this->db->set('leito_id', $_POST['leitoID']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_ocupacao');

                $this->db->set('internacao_id', $internacao_id);
                $this->db->set('leito_id', $_POST['leitoID']);
                $this->db->set('tipo', 'ENTRADA');
                $this->db->set('status', 'INTERNACAO');
                $this->db->set('data', date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $_POST['data']))));
                $this->db->set('operador_movimentacao', $operador_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_leito_movimentacao');
 
                $this->db->set('procedimento_convenio_id', $_POST['procedimento1']);
                if (count($return) > 0) {
                    $this->db->set('valor_total', @$return[0]->valortotal);
                    $this->db->set('valor1', @$return[0]->valortotal);
                }

                $this->db->set('quantidade', 1);
                $this->db->set('empresa_id', $empresa_id);

                $this->db->set('ativo', 't');
                if ($_POST['operadorID'] != "") {
                    $this->db->set('medico_id', $_POST['operadorID']);
                }
                $this->db->set('faturado', 'f');
                $this->db->set('internacao_id', $internacao_id);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
//            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_procedimentos');
            } else { // update
                $internacao_id = $_POST['internacao_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_id', $internacao_id);
                $this->db->update('tb_internacao');
            }

            return $internacao_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarobservacaoprecadastro($internacao_ficha_questionario_id) {
        $empresa_id = $this->session->userdata('empresa_id');

        try {

//            var_dump($_POST); die;

            $this->db->set('observacao', $_POST['txtobservacao']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_ficha_questionario_id', $internacao_ficha_questionario_id);
            $this->db->update('tb_internacao_ficha_questionario');



            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarretornarinternacao($internacao_id) {
        $empresa_id = $this->session->userdata('empresa_id');

        try {

//            var_dump($return); die;

            $this->db->set('ativo', 't');
            $this->db->set('leito', $_POST['leitoID']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_id', $internacao_id);
            $this->db->update('tb_internacao');

            $this->db->set('ativo', 'false');
            $this->db->where('internacao_leito_id', $_POST['leitoID']);
            $this->db->update('tb_internacao_leito');

            $this->db->set('paciente_id', $_POST['idpaciente']);
            $this->db->set('leito_id', $_POST['leitoID']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_ocupacao');

            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('leito_id', $_POST['leitoID']);
            $this->db->set('tipo', 'ENTRADA');
            $this->db->set('status', 'INTERNACAO');
            $this->db->set('data', date("Y-m-d"));
            $this->db->set('operador_movimentacao', $operador_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_leito_movimentacao');

            return $internacao_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function listarmodelogrupoquestionario() {

        $this->db->select('im.internacao_modelo_grupo_id, im.nome, e.nome as empresa, im.texto');
        $this->db->from('tb_internacao_modelo_grupo im');
        $this->db->join('tb_empresa e', 'im.empresa_id = e.empresa_id', 'left');
        $this->db->where('im.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarmodelogrupo() {

        $this->db->select('im.internacao_modelo_grupo_id, im.nome, e.nome as empresa');
        $this->db->from('tb_internacao_modelo_grupo im');
        $this->db->join('tb_empresa e', 'im.empresa_id = e.empresa_id', 'left');
        $this->db->where('im.ativo', 't');
        return $this->db;
    }

    function listarautocompletemodelosgrupo($internacao_modelo_grupo_id = null) {

        $this->db->select('im.*');
        $this->db->from('tb_internacao_modelo_grupo im');
//        $this->db->join('tb_empresa_id e', 'im.empresa_id = e.empresa_id', 'left');
        if ($internacao_modelo_grupo_id != null) {
            $this->db->where('im.internacao_modelo_grupo_id', $internacao_modelo_grupo_id);
        }

        $return = $this->db->get();
        return $return->result();
    }

    function listarmodelogrupoform($internacao_modelo_grupo_id) {

        $this->db->select('im.*');
        $this->db->from('tb_internacao_modelo_grupo im');
//        $this->db->join('tb_empresa_id e', 'im.empresa_id = e.empresa_id', 'left');
        $this->db->where('im.internacao_modelo_grupo_id', $internacao_modelo_grupo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarfichaquestionario($args = array()) {

        $this->db->select('if.internacao_ficha_questionario_id, 
                             if.nome, 
                             p.nome as paciente, 
                             o.nome as operador, 
                             if.data_cadastro,
                             if.paciente_id,
                             if.observacao,
                             if.confirmado,
                             if.aprovado');
        $this->db->from('tb_internacao_ficha_questionario if');
        $this->db->join('tb_operador o', 'o.operador_id = if.operador_cadastro', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = if.paciente_id', 'left');
        $this->db->where('if.ativo', 't');

        if (isset($args['confirmado']) && strlen($args['confirmado']) > 0) {
            $this->db->where('if.confirmado', $args['confirmado']);
        }
        if (isset($args['aprovado']) && strlen($args['aprovado']) > 0) {
            $this->db->where('if.aprovado', $args['aprovado']);
        }
        if (isset($args['data_inicio']) && strlen($args['data_inicio']) > 0) {
            $this->db->where('if.data_cadastro >=', date("Y-m-d", strtotime(str_replace('/', '-', $args['data_inicio']))) . ' 00:00:00');
        }
        if (isset($args['data_fim']) && strlen($args['data_fim']) > 0) {
            $this->db->where('if.data_cadastro <=', date("Y-m-d", strtotime(str_replace('/', '-', $args['data_fim']))) . ' 23:59:59');
        }
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', '%' . $args['nome'] . '%');
        }
//        var_dump(date("Y-m-d",strtotime($args['data_inicio']))); die;

        return $this->db;
    }

    function listastatusinternacao($args = array()) {

        $this->db->select(' internacao_statusinternacao_id,
                            dias_status,
                            nome');
        $this->db->from('tb_internacao_statusinternacao');
        $this->db->where('ativo', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('nome ilike', "%" . $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    function listarstatuspacientetodos() {

        $this->db->select('ist.internacao_statusinternacao_id, 
                            ist.nome, 
                            ist.color, 
                            ist.dias_status, 
                            ist.observacao, 
                             ');
        $this->db->from('tb_internacao_statusinternacao ist');
        $this->db->where('ist.ativo', 't');
        $this->db->orderby('ist.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function novostatusinternacao($internacao_ficha_questionario_id) {

        $this->db->select('ist.internacao_statusinternacao_id, 
                            ist.nome, 
                            ist.color, 
                            ist.dias_status, 
                            ist.observacao, 
                             ');
        $this->db->from('tb_internacao_statusinternacao ist');
        $this->db->where('ist.internacao_statusinternacao_id', $internacao_ficha_questionario_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarstatuspaciente($internacao_id) {

        $this->db->select('ist.internacao_statusinternacao_id, 
                            ist.nome, 
                            ist.color, 
                            ist.dias_status, 
                            ist.observacao, 
                             ');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_statusinternacao ist', 'ist.internacao_statusinternacao_id = i.internacao_statusinternacao_id', 'left');
        $this->db->where('i.internacao_id', $internacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function gravarstatuspaciente($internacao_id) {

        try {
            $this->db->set('internacao_statusinternacao_id', $_POST['status']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_status', $horario);
            $this->db->set('operador_status', $operador_id);
            $this->db->where('internacao_id', $internacao_id);
            $this->db->update('tb_internacao');
            return $internacao_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarstatusinternacao() {

        try {
            $this->db->set('nome', $_POST['nome']);
            $this->db->set('observacao', $_POST['observacao']);
            $this->db->set('color', $_POST['color']);
            $this->db->set('dias_status', $_POST['dias_status']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['internacao_statusinternacao_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_statusinternacao');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else
                    $internacao_statusinternacao_id = $this->db->insert_id();
            }
            else { // update
                $internacao_statusinternacao_id = $_POST['internacao_statusinternacao_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_statusinternacao_id', $internacao_statusinternacao_id);
                $this->db->update('tb_internacao_statusinternacao');
            }

            return $internacao_statusinternacao_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function observacaoprecadastros($internacao_ficha_questionario_id) {

        $this->db->select('if.internacao_ficha_questionario_id, 
                             if.observacao, 
                             if.observacao_ligacao, 
                             if.data_cadastro,
                             ');
        $this->db->from('tb_internacao_ficha_questionario if');
        $this->db->where('if.ativo', 't');
        $this->db->where('if.internacao_ficha_questionario_id', $internacao_ficha_questionario_id);


//        var_dump(date("Y-m-d",strtotime($args['data_inicio']))); die;

        $return = $this->db->get();
        return $return->result();
    }

    function listarfichaquestionarioform($internacao_ficha_questionario_id) {

        $this->db->select('im.*, itp.*, p.nome as paciente,p.idade, p.nascimento, p.sexo, m.nome as cidade');
        $this->db->from('tb_internacao_ficha_questionario im');
        $this->db->join('tb_paciente p', 'p.paciente_id = im.paciente_id', 'left');
        $this->db->join('tb_internacao_tipo_comportamento itp', 'im.internacao_ficha_questionario_id = itp.internacao_ficha_questionario_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = im.municipio_id', 'left');
        $this->db->where('im.internacao_ficha_questionario_id', $internacao_ficha_questionario_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listartipodependencia() {

        $this->db->select('im.internacao_tipo_dependencia_id, im.nome');
        $this->db->from('tb_internacao_tipo_dependencia im');
//        $this->db->join('tb_empresa e', 'im.empresa_id = e.empresa_id', 'left');
        $this->db->where('im.ativo', 't');
        return $this->db;
    }

    function listartipodependenciaform($internacao_tipo_dependencia_id) {

        $this->db->select('im.*');
        $this->db->from('tb_internacao_tipo_dependencia im');
//        $this->db->join('tb_empresa_id e', 'im.empresa_id = e.empresa_id', 'left');
        $this->db->where('im.internacao_tipo_dependencia_id', $internacao_tipo_dependencia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listartipodependenciaquestionario() {

        $this->db->select('im.*');
        $this->db->from('tb_internacao_tipo_dependencia im');
//        $this->db->join('tb_empresa_id e', 'im.empresa_id = e.empresa_id', 'left');
//        $this->db->where('im.internacao_tipo_dependencia_id', $internacao_tipo_dependencia_id);
        $this->db->where('im.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function mostrartermoresponsabilidade($internacao_id) {

        $this->db->select('i.internacao_id,
                           p.*,
                           p.paciente_id,
                           i.prelaudo,
                           o.nome as medico,
                           o.conselho,
                           i.data_internacao,
                           i.data_saida,
                           i.senha,
                           i.forma_de_entrada,
                           i.estado,
                           i.idade_inicio,
                           il.nome as leito,
                           m.nome as municio,
                           mr.nome as municipio_responsavel,
                           m.codigo_ibge,
                           i.cid1solicitado,
                           pt.nome as procedimento,
                           i.procedimentosolicitado,
                           c.nome as convenio,
                           cbo.descricao as profissao,
                           i.nome_responsavel,
                           i.cep_responsavel,
                           i.logradouro_responsavel,
                           i.numero_responsavel,
                           i.complemento_responsavel,
                           i.bairro_responsavel,
                           i.municipio_responsavel_id,
                           i.rg_responsavel,
                           i.cpf_responsavel,
                           i.email_responsavel,
                           i.motivo_saida,
                           i.celular_responsavel,
                           i.telefone_responsavel,
                           i.grau_parentesco,
                           i.idade_inicio,
                           i.tipo_dependencia,
                           ocupacao_responsavel,
                           cid.co_cid,
                           cid.no_cid,
                           cid2.co_cid as co_cid2,
                           cid2.no_cid as no_cid2,
                           p.sexo,
                           p.estado_civil_id,
                           p.nascimento');
        $this->db->from('tb_internacao i');
        // $this->db->join('tb_internacao_tipo_dependencia itd', 'itd.internacao_tipo_dependencia_id = i.tipo_dependencia', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->join('tb_cid cid2', 'cid2.co_cid = i.cid2solicitado', 'left');
        $this->db->join('tb_municipio mr', 'mr.municipio_id = i.municipio_responsavel_id', 'left');

        $this->db->join('tb_cbo_ocupacao cbo', 'cbo.cbo_ocupacao_id = p.profissao', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'i.procedimento_convenio_id = pc.procedimento_convenio_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
        $this->db->join('tb_internacao_leito il', 'il.internacao_leito_id = i.leito', 'left');
        $this->db->where('i.internacao_id', $internacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function imprimirevolucaointernacao($internacao_evolucao_id) {

        $this->db->select('i.internacao_id,
                           p.nome,
                           p.paciente_id,
                           ie.operador_cadastro,
                           ie.data_cadastro,
                           ie.internacao_evolucao_id,
                           i.prelaudo,
                           o.nome as medico,
                           o.conselho,
                           i.data_internacao,
                           i.data_saida,
                           i.senha,
                           ie.diagnostico,

                           p.nascimento');
        $this->db->from('tb_internacao_evolucao ie');
        $this->db->join('tb_internacao i', 'ie.internacao_id = i.internacao_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ie.operador_cadastro', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->join('tb_cid cid2', 'cid2.co_cid = i.cid2solicitado', 'left');
        $this->db->join('tb_municipio mr', 'mr.municipio_id = i.municipio_responsavel_id', 'left');

        $this->db->join('tb_cbo_ocupacao cbo', 'cbo.cbo_ocupacao_id = p.profissao', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'i.procedimento_convenio_id = pc.procedimento_convenio_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
        $this->db->join('tb_internacao_leito il', 'il.internacao_leito_id = i.leito', 'left');
        $this->db->where('ie.internacao_evolucao_id', $internacao_evolucao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function imprimirevolucaointernacaotodas($internacao_id) {

        $this->db->select('i.internacao_id,
                           p.nome,
                           p.paciente_id,
                           ie.operador_cadastro,
                           ie.internacao_evolucao_id,
                           i.prelaudo,
                           o.nome as medico,
                           o.conselho,
                           i.data_internacao,
                           i.data_saida,
                           i.senha,
                           cbo.descricao as especialidade,
                           ie.diagnostico,
                           ie.data_cadastro,

                           p.nascimento');
        $this->db->from('tb_internacao_evolucao ie');
        $this->db->join('tb_internacao i', 'ie.internacao_id = i.internacao_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ie.operador_cadastro', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->join('tb_cid cid2', 'cid2.co_cid = i.cid2solicitado', 'left');
        $this->db->join('tb_municipio mr', 'mr.municipio_id = i.municipio_responsavel_id', 'left');

        $this->db->join('tb_cbo_ocupacao cbo', 'cbo.cbo_ocupacao_id = o.cbo_ocupacao_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'i.procedimento_convenio_id = pc.procedimento_convenio_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
        $this->db->join('tb_internacao_leito il', 'il.internacao_leito_id = i.leito', 'left');
        $this->db->where('ie.internacao_id', $internacao_id);
        $this->db->where('ie.ativo', 't');
        $this->db->orderby('ie.internacao_evolucao_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarinformacoesinternacao($internacao_id) {

        $this->db->select('i.internacao_id,
                           p.*,
                           p.paciente_id,
                           i.prelaudo,
                           o.nome as medico,
                           o.conselho,
                           i.data_internacao,
                           i.data_saida,
                           i.forma_de_entrada,
                           i.estado,
                           i.idade_inicio,
                           il.nome as leito,
                           m.nome as municio,
                           mr.nome as municipio_responsavel,
                           m.codigo_ibge,
                           i.cid1solicitado,
                           pt.nome as procedimento,
                           i.procedimentosolicitado,
                           c.nome as convenio,
                           cbo.descricao as profissao,
                           itd.nome as dependencia,
                           i.nome_responsavel,
                           i.cep_responsavel,
                           i.logradouro_responsavel,
                           i.numero_responsavel,
                           i.complemento_responsavel,
                           i.bairro_responsavel,
                           i.municipio_responsavel_id,
                           i.rg_responsavel,
                           i.cpf_responsavel,
                           i.email_responsavel,
                           i.motivo_saida,
                           i.celular_responsavel,
                           i.telefone_responsavel,
                           i.grau_parentesco,
                           i.idade_inicio,
                           ie.nome as enfermaria,
                           iu.nome as unidade,
                           c.nome as convenio,
                           ocupacao_responsavel,
                           cid.co_cid,
                           cid.no_cid,
                           cid2.co_cid as co_cid2,
                           cid2.no_cid as no_cid2,
                           p.sexo,
                           p.estado_civil_id,
                           p.nascimento');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_tipo_dependencia itd', 'itd.internacao_tipo_dependencia_id = i.tipo_dependencia', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->join('tb_cid cid2', 'cid2.co_cid = i.cid2solicitado', 'left');
        $this->db->join('tb_municipio mr', 'mr.municipio_id = i.municipio_responsavel_id', 'left');
//        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_cbo_ocupacao cbo', 'cbo.cbo_ocupacao_id = p.profissao', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'i.procedimento_convenio_id = pc.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_internacao_leito il', 'il.internacao_leito_id = i.leito', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id', 'left');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id', 'left');
        $this->db->where('i.internacao_id', $internacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function gravarinternacaonutricao($paciente_id) {

        try {
            if ($_POST['leito'] != "") {
                $this->db->set('leito', $_POST['leito']);
            }
            $this->db->set('codigo', $_POST['sisreg']);
            $this->db->set('aih', $_POST['aih']);
            if ($_POST['unidade'] != "") {
                $this->db->set('hospital_id', $_POST['unidade']);
            }
            if ($_POST['data_internacao'] != "") {
                $this->db->set('data_internacao', $_POST['data_internacao']);
            }
            if ($_POST['data_solicitacao'] != "") {
                $this->db->set('data_solicitacao', $_POST['data_solicitacao']);
            }
            $this->db->set('carater_internacao', $_POST['carater']);
            $this->db->set('procedimentosolicitado', $_POST['procedimentoID']);
            $this->db->set('cid1solicitado', $_POST['cid1ID']);
            $this->db->set('justificativa', $_POST['observacao']);
            $this->db->set('solicitante', $_POST['solicitante']);
            $this->db->set('reg', $_POST['reg']);
            $this->db->set('val', $_POST['val']);
            $this->db->set('pla', $_POST['pla']);
            $this->db->set('rx', $_POST['rx']);
            $this->db->set('acesso', $_POST['acesso']);
            $this->db->set('paciente_id', $paciente_id);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['internacao_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao');
                $internacao_id = $this->db->insert_id();
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return 0;
                } elseif ($_POST['leito'] != "") {
                    $this->db->set('ativo', 'false');
                    $this->db->set('condicao', 'Ocupado');
                    $this->db->where('internacao_leito_id', $_POST['leito']);
                    $this->db->update('tb_internacao_leito');

                    $this->db->set('paciente_id', $paciente_id);
                    $this->db->set('leito_id', $_POST['leito']);
                    $this->db->set('ocupado', 'false');
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_internacao_ocupacao');
                }
            } else { // update
                $internacao_id = $_POST['internacao_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_id', $internacao_id);
                $this->db->update('tb_internacao');
            }


            return $internacao_id;
        } catch (Exception $exc) {
            return 0;
        }
    }

    function mostrarsaidapaciente($internacao_id) {

        $this->db->select('i.internacao_id,
                           p.nome as paciente,
                           m.nome as motivosaida,
                           i.motivo_saida,
                           i.hospital_transferencia,
                           m.internacao_motivosaida_id,
                           p.paciente_id,
                           i.data_internacao,
                           i.observacao_saida,
                           i.leito,
                           p.sexo,
                           p.nascimento');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id', 'left');
        $this->db->join('tb_internacao_motivosaida m', 'm.internacao_motivosaida_id = i.motivo_saida', 'left');
        $this->db->where('i.internacao_id', $internacao_id);
//        $this->db->where('p.paciente_id = i.paciente_id');
//        $this->db->where('o.operador_id = i.medico_id');
        // $this->db->where('m.internacao_motivosaida_id = i.motivo_saida ');

        $return = $this->db->get();
        return $return->result();
    }

    function gravarevolucaointernacao() {
        $operador_id = ($this->session->userdata('operador_id'));
        $horario = date("Y-m-d H:i:s");
        $data = date('Y-m-d');

        if(isset($_POST['salvarprocedimento'])){
            $this->db->select('dinheiro');
            $this->db->from('tb_convenio');
            $this->db->where('convenio_id', $_POST['convenio1']);
            $convenio = $this->db->get()->result();
        }


        $this->db->set('diagnostico', $_POST['txtdiagnostico']);
        // $this->db->set('conduta', $_POST['txtconduta']);
        $this->db->set('internacao_id', $_POST['internacao_id']);



        if (@$_POST['internacao_evolucao_id'] != '') {
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_evolucao_id', $_POST['internacao_evolucao_id']);
            $this->db->update('tb_internacao_evolucao');
        } else {
            if(isset($_POST['salvarprocedimento'])){
                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
                $this->db->set('convenio_id', $_POST['convenio1']);
                $this->db->set('valor', $_POST['valor1']);
                $this->db->set('data', $data);
                $this->db->set('empresa_id', $this->session->userdata('empresa_id'));
                $this->db->set('particular', $convenio[0]->dinheiro);
            }

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_evolucao');
            $this->db->insert_id();
        }


        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return true;
        }
    }

    function gravarprocedimentoexternointernacao() {
        $operador_id = ($this->session->userdata('operador_id'));
        $horario = date("Y-m-d H:i:s");


        $this->db->set('procedimento', $_POST['procedimento']);
        $this->db->set('data', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data']))));
        $this->db->set('duracao', $_POST['duracao']);
        $this->db->set('observacao', $_POST['observacao']);
        // $this->db->set('conduta', $_POST['txtconduta']);
        $this->db->set('internacao_id', $_POST['internacao_id']);

        if (@$_POST['internacao_procedimentoexterno_id'] > 0) {
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_procedimento_externo_id', $_POST['internacao_procedimentoexterno_id']);
            $this->db->update('tb_internacao_procedimento_externo');
        } else {
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_procedimento_externo');
            $this->db->insert_id();
        }


        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return true;
        }
    }

    function excluirprocedimentoexternointernacao($internacao_proc_id) {
        $operador_id = ($this->session->userdata('operador_id'));
        $horario = date("Y-m-d H:i:s");

        $this->db->set('ativo', 'f');
        // $this->db->set('data', date("Y-m-d", strtotime(str_replace('/','-',$_POST['data']))));
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('internacao_procedimento_externo_id', $internacao_proc_id);
        $this->db->update('tb_internacao_procedimento_externo');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return true;
        }
    }

    function excluirevolucaointernacao($internacao_evolucao_id) {
        $operador_id = ($this->session->userdata('operador_id'));
        $horario = date("Y-m-d H:i:s");

        $this->db->set('ativo', 'false');
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('data_atualizacao', $horario);
        $this->db->where('internacao_evolucao_id', $internacao_evolucao_id);
        $this->db->update('tb_internacao_evolucao');
        

        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return true;
        }
    }

    function gravarprescricaoenteralnormal($internacao_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d H:i:s");
        $dataprescricao = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('internacao_precricao_id');
        $this->db->from('tb_internacao_precricao');
        $this->db->where("internacao_id", $internacao_id);
        $this->db->where("data", $dataprescricao);
        $query = $this->db->get();
        $return = $query->result();

        $numero = count($return);

        if ($numero == 0) {
            $this->db->set('data', $dataprescricao);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao');
            $internacao_precricao_id = $this->db->insert_id();
        } else {
            $internacao_precricao_id = $return[0]->internacao_precricao_id;
        }

        if ($_POST['produto'] != "Selecione") {

            $this->db->set('etapas', $_POST['etapas']);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_etapa');
            $internacao_precricao_etapa_id = $this->db->insert_id();

            $i = 0;
            foreach ($_POST['produto'] as $produto) {
                $z = 0;
                $c = 0;
                $i++;
                foreach ($_POST['volume'] as $itemvolume) {
                    $c++;
                    if ($i == $c) {
                        $volume = $itemvolume;
                        break;
                    }
                }
                foreach ($_POST['vazao'] as $itemvazao) {
                    $z++;
                    if ($i == $z) {
                        $vazao = $itemvazao;
                        break;
                    }
                }

                $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id);
                $this->db->set('internacao_precricao_id', $internacao_precricao_id);
                $this->db->set('internacao_id', $internacao_id);
                $this->db->set('etapas', $_POST['etapas']);
                $this->db->set('tipo', 'ENTERALNORMAL');
                if ($produto != "Selecione") {
                    $this->db->set('produto_id', $produto);
                }
                if ($volume != null) {
                    $this->db->set('volume', $volume);
                }
                if ($vazao != null) {
                    $this->db->set('vasao', $vazao);
                }
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_precricao_produto');
                $internacao_precricao_produto_id = $this->db->insert_id();
            }
        }

        if ($_POST['equipo'] != "Selecione") {

            $this->db->set('etapas', 1);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_etapa');
            $internacao_precricao_etapa_id_equipo = $this->db->insert_id();

            $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id_equipo);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('etapas', 1);
            $this->db->set('tipo', 'ENTERALNORMAL');
            $this->db->set('produto_id', $_POST['equipo']);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_produto');
        }
    }

    function gravarprescricaoenteralemergencial($internacao_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d H:i:s");
        $dataprescricao = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('internacao_precricao_id');
        $this->db->from('tb_internacao_precricao');
        $this->db->where("internacao_id", $internacao_id);
        $this->db->where("data", $dataprescricao);
        $query = $this->db->get();
        $return = $query->result();

        $numero = count($return);

        if ($numero == 0) {
            $this->db->set('data', $dataprescricao);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao');
            $internacao_precricao_id = $this->db->insert_id();
        } else {
            $internacao_precricao_id = $return[0]->internacao_precricao_id;
        }

        if ($_POST['produto'] != "Selecione") {

            $this->db->set('etapas', $_POST['etapas']);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_etapa');
            $internacao_precricao_etapa_id = $this->db->insert_id();

            $i = 0;
            foreach ($_POST['produto'] as $produto) {
                $z = 0;
                $c = 0;
                $i++;
                foreach ($_POST['volume'] as $itemvolume) {
                    $c++;
                    if ($i == $c) {
                        $volume = $itemvolume;
                        break;
                    }
                }
                foreach ($_POST['vazao'] as $itemvazao) {
                    $z++;
                    if ($i == $z) {
                        $vazao = $itemvazao;
                        break;
                    }
                }

                $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id);
                $this->db->set('internacao_precricao_id', $internacao_precricao_id);
                $this->db->set('internacao_id', $internacao_id);
                $this->db->set('etapas', $_POST['etapas']);
                $this->db->set('tipo', 'ENTERALEMERGENCIAL');
                if ($produto != "Selecione") {
                    $this->db->set('produto_id', $produto);
                }
                if ($volume != null) {
                    $this->db->set('volume', $volume);
                }
                if ($vazao != null) {
                    $this->db->set('vasao', $vazao);
                }
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_precricao_produto');
                $internacao_precricao_produto_id = $this->db->insert_id();
            }
        }

        if ($_POST['equipo'] != "Selecione") {

            $this->db->set('etapas', 1);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_etapa');
            $internacao_precricao_etapa_id_equipo = $this->db->insert_id();

            $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id_equipo);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('etapas', 1);
            $this->db->set('tipo', 'ENTERALEMERGENCIAL');
            $this->db->set('produto_id', $_POST['equipo']);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_produto');
        }
    }

    function repetirultimaprescicaoenteralnormal($internacao_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d H:i:s");
        $dataprescricao = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('internacao_precricao_id');
        $this->db->from('tb_internacao_precricao');
        $this->db->where("internacao_id", $internacao_id);
        $query = $this->db->get();
        $row = $query->last_row();

        $numero = count($row->internacao_precricao_id);
        if ($numero > 0) {
            $this->db->set('data', $dataprescricao);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao');
            $internacao_precricao_id = $this->db->insert_id();

            $this->db->select('internacao_precricao_etapa_id, etapas');
            $this->db->from('tb_internacao_precricao_etapa');
            $this->db->where("internacao_precricao_id", $row->internacao_precricao_id);
            $query = $this->db->get();
            $returno = $query->result();
            $numeroetapa = count($returno);

            if ($numeroetapa > 0) {
                foreach ($returno as $item) {
                    $this->db->set('etapas', $item->etapas);
                    $this->db->set('internacao_precricao_id', $internacao_precricao_id);
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_internacao_precricao_etapa');
                    $internacao_precricao_etapa_id = $this->db->insert_id();

                    $this->db->select('internacao_precricao_id, internacao_id, etapas, produto_id, volume, vasao');
                    $this->db->from('tb_internacao_precricao_produto');
                    $this->db->where("internacao_precricao_etapa_id", $item->internacao_precricao_etapa_id);
                    $query = $this->db->get();
                    $return = $query->result();
                    $numeroproduto = count($return);


                    if ($numeroproduto > 0) {
                        foreach ($return as $value) {
                            $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id);
                            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
                            $this->db->set('internacao_id', $value->internacao_id);
                            $this->db->set('etapas', $value->etapas);
                            $this->db->set('tipo', 'ENTERALNORMAL');
                            if ($value->produto_id != "") {
                                $this->db->set('produto_id', $value->produto_id);
                            }
                            if ($value->volume != "") {
                                $this->db->set('volume', $value->volume);
                            }
                            if ($value->vasao != "") {
                                $this->db->set('vasao', $value->vasao);
                            }
                            $this->db->set('empresa_id', $empresa_id);
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_internacao_precricao_produto');
                        }
                    }
                }
            }
        }
    }

    function gravarmodelogrupo() {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->set('nome', $_POST['nome']);
            $this->db->set('texto', $_POST['texto']);
            $this->db->set('empresa_id', $empresa_id);
//            var_dump($_POST['internacao_modelo_grupo_id']); die;
            if ($_POST['internacao_modelo_grupo_id'] > 0) {
                $internacao_modelo_grupo_id = $_POST['internacao_modelo_grupo_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_modelo_grupo_id', $internacao_modelo_grupo_id);
                $this->db->update('tb_internacao_modelo_grupo');
            } else {

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_modelo_grupo');
                $internacao_modelo_grupo_id = $this->db->insert_id();
            }

            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function excluirmodelogrupo($internacao_modelo_grupo_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
//            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_modelo_grupo_id', $internacao_modelo_grupo_id);
            $this->db->update('tb_internacao_modelo_grupo');


            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarfichaquestionario() {


        try {
            if ($_POST['txtPacienteId'] == '') {
 
                $this->db->set('nome', $_POST['nome_paciente']);
                $this->db->set('sexo', $_POST['sexo']);
                $this->db->set('idade', $_POST['idade']);
                if ($_POST['municipio_id'] > 0) {
                    $this->db->set('municipio_id', $_POST['municipio_id']);
                }
                if ($_POST['convenio'] > 0) {
                    $this->db->set('convenio_id', $_POST['convenio']);
                }
                if ($_POST['nascimento'] != '') {
                    $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
                }
                $this->db->insert('tb_paciente');
                $paciente_id = $this->db->insert_id();
            } else {
                
                $paciente_id = $_POST['txtPacienteId'];
//                die;
                $this->db->set('idade', $_POST['idade']);
                if ($_POST['municipio_id'] > 0) {
                    $this->db->set('municipio_id', $_POST['municipio_id']);
                }
                if ($_POST['convenio'] > 0) {
                    $this->db->set('convenio_id', $_POST['convenio']);
                }
                if ($_POST['nascimento'] != '') {
                    $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
                }
                $this->db->set('sexo', $_POST['sexo']);
                $this->db->set('nome', $_POST['nome_paciente']);
                $this->db->where('paciente_id', $paciente_id);
                $this->db->update('tb_paciente');
                
                
            }



            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
//            $empresa_id = $this->session->userdata('empresa_id');


            $this->db->set('nome', $_POST['nome_responsavel']);
            $this->db->set('grau_parentesco', $_POST['grau_parentesco']);
            $this->db->set('ocupacao_responsavel', $_POST['ocupacao']);
//            $this->db->set('grau_parentesco', $empresa_id);
            $this->db->set('paciente_id', $paciente_id);
            $tipo_dependencia_json = json_encode($_POST['tipo_dependencia']);
            // if ($_POST['tipo_dependencia'] > 0) {
            $this->db->set('tipo_dependencia', $tipo_dependencia_json);
            // }
            if ($_POST['idade_inicio'] > 0) {
//                echo 'asdad';
                $this->db->set('idade_inicio', $_POST['idade_inicio']);
            }
//            var_dump($_POST['idade_inicio']); die;

            $this->db->set('paciente_agressivo', $_POST['paciente_agressivo']);
            $this->db->set('aceita_tratamento', $_POST['aceita_tratamento']);
            if ($_POST['indicacao'] > 0) {
                $this->db->set('tomou_conhecimento', $_POST['indicacao']);
            }
            $this->db->set('plano_saude', $_POST['plano_saude']);
            $this->db->set('tratamento_anterior', $_POST['tratamento_anterior']);
            $this->db->set('telefone_contato', $_POST['telefone_contato']);
            if ($_POST['convenio'] > 0) {
                $this->db->set('convenio_id', $_POST['convenio']);
            }
            if ($_POST['municipio_id'] > 0) {
                $this->db->set('municipio_id', $_POST['municipio_id']);
            }

            $this->db->set('observacao', $_POST['observacao']);
            $this->db->set('grupo', $_POST['grupo']);
            $this->db->set('tipo_internacao', $_POST['tipo_internacao']);
//            var_dump($_POST['internacao_ficha_questionario_id']); die;
            if ($_POST['internacao_ficha_questionario_id'] > 0) {
                $internacao_ficha_questionario_id = $_POST['internacao_ficha_questionario_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_ficha_questionario_id', $internacao_ficha_questionario_id);
                $this->db->update('tb_internacao_ficha_questionario');
            } else {

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_ficha_questionario');
                $internacao_ficha_questionario_id = $this->db->insert_id();
            }

            // $this->db->select('internacao_ficha_questionario_id');
            // $this->db->where('internacao_ficha_questionario_id', $internacao_ficha_questionario_id);
            // $this->from('tb_internacao_tipo_comportamento');
            // $return = $this->db->get()->result();
            // $validacao = count($return);

            if(@$_POST['negacao'] != ''){
                $this->db->set('negacao', 't');
            }
            if(@$_POST['agressividade'] != ''){
                $this->db->set('agressividade', 't');
            }
            if(@$_POST['angustia'] != ''){
                $this->db->set('angustia', 't');
            }
            if(@$_POST['ansiedade'] != ''){
                $this->db->set('ansiedade', 't');
            }
            if(@$_POST['apatia'] != ''){
                $this->db->set('apatia', 't');
            }
            if(@$_POST['desanimo'] != ''){
                $this->db->set('desanimo', 't');
            }
            if(@$_POST['desordem_social'] != ''){
                $this->db->set('desordem_social', 't');
            }
            if(@$_POST['aborrecimento'] != ''){
                $this->db->set('aborrecimento', 't');
            }
            if(@$_POST['substituicao'] != ''){
                $this->db->set('substituicao', 't');
            }
            if(@$_POST['dificuldade_raciocinio'] != ''){
                $this->db->set('dificuldade_raciocinio', 't');
            }
            if(@$_POST['ideias_suicidas'] != ''){
                $this->db->set('ideias_suicidas', 't');
            }
            if(@$_POST['racionalizacao'] != ''){
                $this->db->set('racionalizacao', 't');
            }
            if(@$_POST['desconfianca'] != ''){
                $this->db->set('desconfianca', 't');
            }
            if(@$_POST['degradacao'] != ''){
                $this->db->set('degradacao', 't');
            }
            if(@$_POST['vergonha'] != ''){
                $this->db->set('vergonha', 't');
            }
            if(@$_POST['pessimismo'] != ''){
                $this->db->set('pessimismo', 't');
            }
            if(@$_POST['problemas_finaceiros'] != ''){
                $this->db->set('problemas_finaceiros', 't');
            }
            if(@$_POST['problemas_familiares'] != ''){
                $this->db->set('problemas_familiares', 't');
            }
            if(@$_POST['tentativas_s'] != ''){
                $this->db->set('tentativas_s', 't');
            }
            if(@$_POST['tristeza_p'] != ''){
                $this->db->set('tristeza_p', 't');
            }
            if(@$_POST['desleixo'] != ''){
                $this->db->set('desleixo', 't');
            }
            if(@$_POST['isolamento'] != ''){
                $this->db->set('isolamento', 't');
            }
            if(@$_POST['perda_controle'] != ''){
                $this->db->set('perda_controle', 't');
            }
            if(@$_POST['incapacidade'] != ''){
                $this->db->set('incapacidade', 't');
            }
            if(@$_POST['medo'] != ''){
                $this->db->set('medo', 't');
            }
            if(@$_POST['culpa'] != ''){
                $this->db->set('culpa', 't');
            }
            if($validacao > 0){
                $this->db->where('internacao_ficha_questionario_id', $internacao_ficha_questionario_id);
                $this->db->update('tb_internacao_tipo_comportamento');
            }else{
                $this->db->set('internacao_ficha_questionario_id', $internacao_ficha_questionario_id);
                $this->db->insert('tb_internacao_tipo_comportamento');
            }


            
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function excluirfichaquestionario($internacao_ficha_questionario_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
//            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_ficha_questionario_id', $internacao_ficha_questionario_id);
            $this->db->update('tb_internacao_ficha_questionario');


            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function confirmarligacaofichaquestionario($internacao_ficha_questionario_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
//            $empresa_id = $this->session->userdata('empresa_id');
            // var_dump($_POST); die;
            if (isset($_POST['btnEnviar'])) {
                $this->db->set('confirmado', 't');
            } else {
                $this->db->set('confirmado', 'f');
            }
            $this->db->set('observacao_ligacao', $_POST['txtobservacao']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_ficha_questionario_id', $internacao_ficha_questionario_id);
            $this->db->update('tb_internacao_ficha_questionario');


            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function desconfirmarligacaofichaquestionario($internacao_ficha_questionario_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
//            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->set('confirmado', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_ficha_questionario_id', $internacao_ficha_questionario_id);
            $this->db->update('tb_internacao_ficha_questionario');


            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function confirmaraprovacaofichaquestionario($internacao_ficha_questionario_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
//            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->set('aprovado', 't');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_ficha_questionario_id', $internacao_ficha_questionario_id);
            $this->db->update('tb_internacao_ficha_questionario');


            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravareditarimpressao($impressao_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('texto', $_POST['texto']);
            $this->db->set('impressao_id', $impressao_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_empresa_impressao_internacao_temp');
            $impressao_temp_id = $this->db->insert_id();


            return $impressao_temp_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravartipodependencia() {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->set('nome', $_POST['nome']);
//            var_dump($_POST['internacao_tipo_dependencia_id']); die;
            if ($_POST['internacao_tipo_dependencia_id'] > 0) {
                $internacao_tipo_dependencia_id = $_POST['internacao_tipo_dependencia_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_tipo_dependencia_id', $internacao_tipo_dependencia_id);
                $this->db->update('tb_internacao_tipo_dependencia');
            } else {

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_tipo_dependencia');
                $internacao_tipo_dependencia_id = $this->db->insert_id();
            }

            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function excluirtipodependencia($internacao_tipo_dependencia_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
//            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_tipo_dependencia_id', $internacao_tipo_dependencia_id);
            $this->db->update('tb_internacao_tipo_dependencia');


            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarmovimentacao($paciente_id, $leito_id) {

        try {
            $this->db->set('leito_id', $_POST['leitoID']);
            $this->db->set('paciente_id', $paciente_id);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');


            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('leito_id', $_POST['leitoID']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_ocupacao');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                $internacao_ocupacao_id = $this->db->insert_id();

                $this->db->set('ativo', 'false');
                $this->db->where('internacao_leito_id', $_POST['leitoID']);
                $this->db->update('tb_internacao_leito');

                $this->db->set('ativo', 'true');
                $this->db->where('internacao_leito_id', $leito_id);
                $this->db->update('tb_internacao_leito');
            }
            return $internacao_ocupacao_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function excluiritemprescicao($item_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('ativo', 'false');
            $this->db->where('internacao_precricao_produto_id', $item_id);
            $this->db->update('tb_internacao_precricao_produto');
            return $item_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarprescricaofarmacia($internacao_id) {

        $this->db->select('leito');
        $this->db->from('tb_internacao');
        $this->db->where('internacao_id', $internacao_id);
        $return = $this->db->get()->result();

        // echo '<pre>';
        // print_r($return[0]->leito);
        // die;

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('medicamento_id', $_POST['txtMedicamentoID']);
        $this->db->set('aprasamento', $_POST['aprasamento']);
        $this->db->set('dias', $_POST['dias']);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('internacao_id', $internacao_id);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->set('leito_solicitado', $return[0]->leito);
        if ($_POST['observacao'] != "") {
            $this->db->set('observacao', $_POST['observacao']);
        }
       
        $this->db->insert('tb_internacao_prescricao');
    }

    function cancelarprescricaopaciente($internacao_prescricao_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_exclusao', $horario);
        $this->db->set('operador_exclusao', $operador_id);
        $this->db->where('internacao_prescricao_id', $internacao_prescricao_id);
        $this->db->update('tb_internacao_prescricao');

        $this->db->select('fs.internacao_prescricao_id, fs.farmacia_saida_id');
        $this->db->from('tb_farmacia_saida fs');
        $this->db->where('fs.internacao_prescricao_id', $internacao_prescricao_id);
//        $this->db->where('fs.ativo', 't');
//        $this->db->where('(fs.ativo = true OR fs.ativo is null)');
        $return = $this->db->get()->result();
//        var_dump($return); die;

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('farmacia_saida_id', $return[0]->farmacia_saida_id);
        $this->db->update('tb_farmacia_saida');


        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('farmacia_saida_id', $return[0]->farmacia_saida_id);
        $this->db->update('tb_farmacia_saldo');
    }

    function confirmarprescricaofarmacia($internacao_prescricao_id, $internacao_id = NULL) {
        // $teste = -1;
        // $quantidade = -1 + ($teste);
        // print_r($quantidade);
        // die;

        if($internacao_id != NULL){
            $this->db->select('leito');
            $this->db->from('tb_internacao');
            $this->db->where('internacao_id', $internacao_id);
            $return = $this->db->get()->result();
        }

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');



        $quantidade_estoque = $_POST['quantidade_saida'] - $_POST['quantidade_ministrada'];
//        echo $quantidade_estoque;
//        die;

        $this->db->set('qtde_ministrada', $_POST['quantidade_ministrada']);
        $this->db->set('qtde_original', $_POST['quantidade_saida']);
        $this->db->set('qtde_volta', $quantidade_estoque);
        $this->db->set('confirmado', 't');
//        $this->db->set('aprasamento', $_POST['aprasamento']);
//        $this->db->set('dias', $_POST['dias']);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);

        if ($_POST['horario'] != "") {
            $this->db->set('horario', $_POST['horario']);
        }

        if($internacao_id != NULL){
            $this->db->set('leito_ministrado', $return[0]->leito);
        }

        $this->db->set('data_confirmada', $horario);
        $this->db->set('operador_ministrado', $operador_id);

        $this->db->where('internacao_prescricao_id', $internacao_prescricao_id);
        $this->db->update('tb_internacao_prescricao');

        if ($_POST['quantidade_ministrada'] <= $_POST['quantidade_saida']) {
            $this->db->select('quantidade');
            $this->db->from('tb_farmacia_saida');
            $this->db->where('farmacia_saida_id', $_POST['farmacia_saida_id']);
            $value = $this->db->get()->result();
            $quantidade_nova = $_POST['quantidade_ministrada'] + $value[0]->quantidade;
//            $quantidade_estoque = $_POST['quantidade_saida'] - $_POST['quantidade_ministrada'];
//            var_dump($_POST['quantidade_saida']); die;
//            $this->db->set('quantidade', $_POST['quantidade_ministrada']);

            $this->db->set('quantidade_internacao', $quantidade_estoque);
            $this->db->set('quantidade', $quantidade_nova);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('farmacia_saida_id', $_POST['farmacia_saida_id']);
            $this->db->update('tb_farmacia_saida');

            if ($_POS['medicamentos_ministrados_id'] != "") {
                
            } else {
                $this->db->select('quantidade');
                $this->db->from('tb_farmacia_saldo');
                $this->db->where('farmacia_saida_id', $_POST['farmacia_saida_id']);
                $value = $this->db->get()->result();
                if($value[0]->quantidade == 0){
                    $quantidade_nova = -($_POST['quantidade_ministrada']);
                }else{
                    $quantidade_nova = -$_POST['quantidade_ministrada'] + ($value[0]->quantidade);
                }

                $this->db->set('quantidade', $quantidade_nova);
                $this->db->set('quantidade_internacao', $quantidade_estoque);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('farmacia_saida_id', $_POST['farmacia_saida_id']);
                $this->db->update('tb_farmacia_saldo');
            }
        }
    }

    function listardadosreceituario($internacao_id) {
        $this->db->select('p.nome, 
                           pr.descricao_resumida as procedimento, 
                           i.solicitante, 
                           i.leito as sala, 
                           i.paciente_id, 
                           p.nascimento,
                           pr.procedimento_id');
        $this->db->from('tb_internacao i');
        $this->db->where("i.internacao_id = $internacao_id");
        $this->db->join('tb_paciente p', "i.paciente_id = p.paciente_id");
        $this->db->join('tb_procedimento pr', "pr.procedimento_id = i.procedimentosolicitado");
        $return = $this->db->get();
        return $return->result();
    }

    function listardadosinternacao($internacao_id) {
        $this->db->select('i.internacao_id,
                           i.solicitante, 
                           i.leito as sala, 
                           i.paciente_id, 
                           p.nascimento,
                           c.nome as convenio,
                           pc.convenio_id');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_paciente p', "i.paciente_id = p.paciente_id", 'left');
        $this->db->join('tb_procedimento_convenio pc', "pc.procedimento_convenio_id = i.procedimento_convenio_id", 'left');
        $this->db->join('tb_convenio c', "c.convenio_id = pc.convenio_id", 'left');
        $this->db->where("i.internacao_id = $internacao_id");
//        $this->db->where("i.ativo", 't');

        $return = $this->db->get();
        return $return->result();
    }

    function listarevolucoes($internacao_id) {
        $this->db->select('p.nome, 
                           ie.internacao_evolucao_id, 
                           ie.conduta, 
                           ie.diagnostico, 
                           o.nome as operador,
                           ie.data_cadastro, 
                           p.nascimento,
                           ie.valor,
                           pt.nome as procedimento,
                           ie.faturado,
                           i.paciente_id,
                           ie.particular,
                           (aef.valor_total - (select sum(valor_bruto) + sum(desconto)  as valorTotPag from ponto.tb_internacao_evolucao_faturar aef2
                            where aef2.internacao_evolucao_id = aef.internacao_evolucao_id and ativo = true)) as valor_restante,');
        $this->db->from('tb_internacao_evolucao ie');
        $this->db->join('tb_internacao_evolucao_faturar aef', 'aef.internacao_evolucao_id = ie.internacao_evolucao_id', 'left');
        $this->db->join('tb_internacao i', "i.internacao_id = ie.internacao_id", 'left');
        $this->db->join('tb_paciente p', "i.paciente_id = p.paciente_id", 'left');
        $this->db->join('tb_operador o', "ie.operador_cadastro = o.operador_id", 'left');
        $this->db->join('tb_procedimento_convenio pc', "pc.procedimento_convenio_id = ie.procedimento_tuss_id", 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("ie.internacao_id = $internacao_id");
        $this->db->where("ie.ativo", 't');
        $this->db->orderby("ie.internacao_evolucao_id");
        $this->db->groupby("p.nome, 
        ie.internacao_evolucao_id, 
        ie.conduta, 
        ie.diagnostico, 
        o.nome,
        ie.data_cadastro, 
        p.nascimento,
        ie.valor,
        pt.nome,
        ie.faturado,
        i.paciente_id,
        ie.particular,
        aef.valor_total,
        aef.internacao_evolucao_id
        ");
        $return = $this->db->get();
        return $return->result();
    }

    function gravarfaturamentomodelo2internacao($internacao_id) {
        try {


            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
            $desconto = (float) $_POST['desconto'];
            $valor1 = (float) $_POST['valor1'];
            $ajuste1 = (float) $_POST['ajuste1'];
            $valor_bruto = (float) $_POST['valor1'];
            $valorajuste1 = (float) $_POST['valorajuste1'];
            $valor_proc = (float) str_replace(',', '.', str_replace('.', '', $_POST['valor_proc']));
            $parcela1 = (int) $_POST['parcela1'];
            // $guia_id = $_POST['guia_id'];
            $internacao_id = $_POST['internacao_id'];
            $procedimento_convenio_id = $_POST['procedimento_convenio_id'];
            $forma_pagamento_id = $_POST['forma_pagamento_id'];
            $tipo_desconto = $_POST['desconto_especial'];
            $empresapermissoes = $this->guia->listarempresapermissoes();
            // Caso o faturamento parcial esteja ativado, ele vai pegar a data de hoje pra lançar o pagamento
            

            // echo '<pre>';
            // print_r($_POST);
            // die;

            $data = date("Y-m-d");


            if($forma_pagamento_id > 0){
              $this->db->set('forma_pagamento_id', $forma_pagamento_id);
            }
            $this->db->set('parcela', $parcela1);
            // $this->db->set('guia_id', $guia_id);
            // $this->db->set('internacao_evolucao_id', $internacao_evolucao_id);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('procedimento_convenio_id', $procedimento_convenio_id);
            $this->db->set('desconto', $desconto);
            $this->db->set('ajuste', $ajuste1);
            $this->db->set('valor_total', $valor_proc);
            if (@$forma_pagamento_id == 1000) {
                $this->db->set('valor', $valor_bruto);
            } else {
                $this->db->set('valor', $valorajuste1);
            }
            $this->db->set('valor_bruto', $valor_bruto);
            $this->db->set('data', $data);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('faturado', 't');
            $this->db->set('observacao', $_POST['observacao']);

            // if(isset($_POST['quitacao'])){
            //     $this->db->set('quitacao', 't');
            // }

            $this->db->insert('tb_internacao_faturar');
            $agenda_exames_faturar_id_modelo2 = $this->db->insert_id();

            
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            // }
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfaturamentomodelo2internacaoevolucao($internacao_id) {
        try {


            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
            $desconto = (float) $_POST['desconto'];
            $valor1 = (float) $_POST['valor1'];
            $ajuste1 = (float) $_POST['ajuste1'];
            $valor_bruto = (float) $_POST['valor1'];
            $valorajuste1 = (float) $_POST['valorajuste1'];
            $valor_proc = (float) str_replace(',', '.', str_replace('.', '', $_POST['valor_proc']));
            $parcela1 = (int) $_POST['parcela1'];
            // $guia_id = $_POST['guia_id'];
            $internacao_evolucao_id = $_POST['internacao_evolucao_id'];
            $procedimento_convenio_id = $_POST['procedimento_convenio_id'];
            $forma_pagamento_id = $_POST['forma_pagamento_id'];
            $tipo_desconto = $_POST['desconto_especial'];
            $empresapermissoes = $this->guia->listarempresapermissoes();
            // Caso o faturamento parcial esteja ativado, ele vai pegar a data de hoje pra lançar o pagamento
            

            // echo '<pre>';
            // print_r($_POST);
            // die;

            $data = date("Y-m-d");


            if($forma_pagamento_id > 0){
              $this->db->set('forma_pagamento_id', $forma_pagamento_id);
            }
            $this->db->set('parcela', $parcela1);
            // $this->db->set('guia_id', $guia_id);
            $this->db->set('internacao_evolucao_id', $internacao_evolucao_id);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('procedimento_convenio_id', $procedimento_convenio_id);
            $this->db->set('desconto', $desconto);
            $this->db->set('ajuste', $ajuste1);
            $this->db->set('valor_total', $valor_proc);
            if (@$forma_pagamento_id == 1000) {
                $this->db->set('valor', $valor_bruto);
            } else {
                $this->db->set('valor', $valorajuste1);
            }
            $this->db->set('valor_bruto', $valor_bruto);
            $this->db->set('data', $data);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('faturado', 't');
            $this->db->set('observacao', $_POST['observacao']);

            // if(isset($_POST['quitacao'])){
            //     $this->db->set('quitacao', 't');
            // }

            $this->db->insert('tb_internacao_evolucao_faturar');
            $agenda_exames_faturar_id_modelo2 = $this->db->insert_id();

            
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            // }
        } catch (Exception $exc) {
            return -1;
        }
    }

    
    function apagarfaturarmodelo2internacao($internacao_faturar_id, $internacao_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->where('internacao_faturar_id', $internacao_faturar_id);
            $this->db->delete('tb_internacao_faturar');

            $this->db->set('faturado', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_id', $internacao_id);
            $this->db->update('tb_internacao');
 
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }


    function apagarfaturarprocedimentosinternacaoevolucao($forma_pagamento_id, $internacao_id, $data_pag) {
        try {

            $this->db->select('internacao_evolucao_id');
            $this->db->from('tb_internacao_evolucao_faturar');
            $this->db->where('forma_pagamento_id', $forma_pagamento_id);
            $this->db->where('internacao_id', $internacao_id);
            $this->db->where('data', $data_pag);
            $return = $this->db->get()->result();


            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->where('forma_pagamento_id', $forma_pagamento_id);
            $this->db->where('internacao_id', $internacao_id);
            $this->db->where('data', $data_pag);
            $this->db->delete('tb_internacao_evolucao_faturar');

            foreach($return as $id){
                $this->db->set('faturado', 'f');
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_evolucao_id', $id->internacao_evolucao_id);
                $this->db->update('tb_internacao_evolucao');
            }
 
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function apagarfaturarprocedimentosinternacao($forma_pagamento_id, $internacao_id, $data_pag) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->where('forma_pagamento_id', $forma_pagamento_id);
            $this->db->where('internacao_id', $internacao_id);
            $this->db->where('data', $data_pag);
            $this->db->delete('tb_internacao_faturar');


                $this->db->set('faturado', 'f');
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_id', $internacao_id);
                $this->db->update('tb_internacao');

 
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }


    function apagarfaturarmodelo2internacaoevolucao($internacao_evolucao_faturar_id, $internacao_evolucao_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->where('internacao_evolucao_faturar_id', $internacao_evolucao_faturar_id);
            $this->db->delete('tb_internacao_evolucao_faturar');

            $this->db->set('faturado', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_evolucao_id', $internacao_evolucao_id);
            $this->db->update('tb_internacao_evolucao');
 
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    
    function confirmarinternacaopagamento($internacao_id){
        $this->db->set('faturado', 't');
        $this->db->where('internacao_id', $internacao_id);
        $this->db->update('tb_internacao');
    }

    function confirmarinternacaoevolucaopagamento($internacao_evolucao_id){
        $this->db->set('faturado', 't');
        $this->db->where('internacao_evolucao_id', $internacao_evolucao_id);
        $this->db->update('tb_internacao_evolucao');
    }

    function listarinternacaopagamento($internacao_id){
        $this->db->select('
                            i.internacao_id,
                            i.procedimento_convenio_id,
                            i.valor_total as valor_total,
                            i.valor_total as valor,
                            pt.nome as procedimento,
                            i.faturado');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('i.internacao_id', $internacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function gravarprocedimentosfaturarmodelo2internacao(){
        try{

            // echo '<pre>';
            // print_r($_POST);
            // die;
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');

            $desconto = (float) $_POST['desconto'];
            $valor1 = (float) $_POST['valor1'];
            $valorafaturar = (float) $_POST['valorafaturar'];
            $ajuste1 = (float) $_POST['ajuste1'];
            $valor_bruto = (float) $_POST['valor1'];
            $valorajuste1 = (float) round($_POST['valorajuste1'], 2);
            $valor_proc = (float) $_POST['valor_proc'];
            $parcela1 = (int) $_POST['parcela1'];
            $internacao_id = $_POST['internacao_id'];

            $forma_pagamento_id = $_POST['forma_pagamento_id'];

            $empresapermissoes = $this->guia->listarempresapermissoes();

            $data = date("Y-m-d");

            $array_exames = $_POST['evolucao_id'];
            $array_valores = $_POST['valores'];

            $i = 0;
            $array_geral = array();

            foreach ($array_exames as $internacao_id) {

                $valorExi_Array = $this->buscarValorExistentePagamento($internacao_id);
                if (count($valorExi_Array) > 0) {
                    $array_geral[$internacao_id] = (float) $valorExi_Array[0]->valor_restante;
                } else {
                    $array_geral[$internacao_id] = (float) $array_valores[$i];
                }
                $i++;
            }
            asort($array_geral);

            $i = 0;
            foreach ($array_exames as $internacao_id) {
                $array_geral[$internacao_id] = (float) $array_valores[$i];
                $i++;
            }

            $contador = 0;
            $qtdeProc = count($array_exames);
            $qtdeProcRes = count($array_exames);
            $valorForRestante = $valor_bruto;

            $valorDescRestante = $desconto;
            $valorDescTotal = 0;
            $valorForTotal = 0;
            $teste = 0;
            $valor_desconto = 0;
            $valorTotalProc = 0;
            $teste_de_valor = 0;
            $valor_ajustado = 0;
            $valorProcExis = null;
            $permissaoInsert = true;
            $valorAjusteCalculado = 0;
            $valorDivisao = (float) round($valorForRestante / $qtdeProc, 2);
            $valorDescDivisao = (float) round($desconto / $qtdeProc, 2);
            $valor_ajusteAdicional = 0;

            foreach($array_geral as $internacao_id => $valor){
                $contador++;
                $valorProcAtual = $valor;

                $valorProcExis = $this->buscarValorExistentePagamento($internacao_id);
                if (count($valorProcExis) > 0) {
                    if ($valorProcExis[0]->valor_restante == 0) {
                        $valorPagarAtual = $valorProcExis[0]->valor_restante;
                        $permissaoInsert = false;
                    } elseif ($valorProcExis[0]->valor_restante > 0) {
                        $valorPagarAtual = $valorProcExis[0]->valor_restante;
                        $permissaoInsert = true;
                    }
                } else {
                    $valorPagarAtual = $valorProcAtual;
                    $permissaoInsert = true;
                }

                if ($valorDivisao > $valorPagarAtual) {
                    $valor_pago = $valorPagarAtual;
                    $valorForRestante -= $valor_pago;
                    $qtdeProcRes--; 
                    if ($qtdeProcRes < 1) {
                        $qtdeProcRes = 1;
                    }
                    $valorDivisao = (float) round($valorForRestante / $qtdeProcRes, 2);
                    $valorDescDivisao = (float) round($valorDescRestante / $qtdeProcRes, 2);
                    $valor_desconto = 0;
                }else {
                    $qtdeProcRes--;
                    $valor_pago = $valorDivisao;
                    $valorForRestante -= $valor_pago;

                    if ($valorDescRestante > 0) {
                        $valor_calculo = $valorDescDivisao + $valor_pago;
                        if ($valor_calculo > $valorPagarAtual) {
                            $valor_desconto = $valorPagarAtual - $valor_pago;
                            $valorDescRestante -= $valor_desconto;
                            if ($qtdeProcRes < 1) {
                                $qtdeProcRes = 1;
                            }
                            $valorDescDivisao = (float) round($valorDescRestante / $qtdeProcRes, 2);
                        } else {
                            $valorDescRestante -= $valorDescDivisao;
                            $valor_desconto = $valorDescDivisao;
                        }
                        $valorDescTotal += $valor_desconto;
                    }
                }

                $valorForTotal += $valor_pago;
                $valorTotalProc += $valorPagarAtual;

                if ($contador >= count($array_geral)) {
                    if ($valorForRestante != 0) {
                        $valor_pago += $valorForRestante;
                        $valorForTotal += $valorForRestante;
                    }
                    if ($valorDescRestante != 0) {
                        $valor_desconto += $valorDescRestante;
                        $valorDescTotal += $valorDescRestante;
                        $valorDescRestante -= $valorDescRestante;
                    }
                }

                if ($ajuste1 > 0) {
                    $valor_ajustado = round($valor_pago + ($valor_pago * ($ajuste1 / 100)), 2);
                } else {

                }
                $valorAjusteCalculado += $valor_ajustado;

                if ($contador >= count($array_geral)) {

                    if ($valorajuste1 > $valorAjusteCalculado && $ajuste1 > 0) {
                        $restoAjuste = $valorajuste1 - $valorAjusteCalculado;
                        $valor_ajusteAdicional = $restoAjuste;
                    }
                }

                $valor_bruto_ins = $valor_pago;

                if ($permissaoInsert) {

                    $letra = substr($internacao_id, 0, 2);
                    if($letra == 'i_'){
                        $id = str_replace('i_', '', $internacao_id);
                    }else{
                        $id = str_replace('e_', '', $internacao_id);
                    }

                    if($forma_pagamento_id > 0){
                        $this->db->set('forma_pagamento_id', $forma_pagamento_id);
                      }
                      $this->db->set('parcela', $parcela1);
                    //   $this->db->set('guia_id', $guia_id);

                      if($letra == 'i_'){
                        $this->db->set('internacao_id', $id);
                      }else{
                        $this->db->set('internacao_evolucao_id', $id);  
                        $this->db->set('internacao_id', $_POST['internacao_id']);
                      }

                        $this->db->set('desconto', $valor_desconto);
                        $this->db->set('ajuste', $ajuste1);
                        $this->db->set('valor_total', $valorProcAtual);
                        $this->db->set('valor', $valor_pago);
                        $this->db->set('valor_bruto', $valor_bruto_ins);
                        $this->db->set('data', $data);
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->set('faturado_guia', 't');
                        $this->db->set('observacao', $_POST['observacao']);

                        if($letra == 'i_'){
                            $this->db->insert('tb_internacao_faturar');
                        }else{
                            $this->db->insert('tb_internacao_evolucao_faturar'); 
                        }

                        $internacao_id_modelo2 = $this->db->insert_id();

                        if($letra == 'e_'){
                            $forma_cadastrada = $this->agendaExamesFormasPagamentoInternacaoEvolucao($id);
                            if($forma_cadastrada[0]->valor_restante == 0.00){
                                $this->confirmarinternacaoevolucaopagamento($id);
                            }
                        }elseif($letra == 'i_'){
                            $forma_cadastrada = $this->agendaExamesFormasPagamentoInternacao($id);
                            if($forma_cadastrada[0]->valor_restante == 0.00){
                                $this->confirmarinternacaopagamento($id);
                            }
                        }
                }
            }

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        }catch (Exception $exc) {
            return -1;
        }
    }

    function buscarValorExistentePagamento($internacao_id = null) {

        $letra = substr($internacao_id, 0, 2);

        if($letra == 'i_'){
            $id = str_replace('i_', '', $internacao_id);
            $this->db->select('
            aef.internacao_id,
            aef.valor_total,
            (aef.valor_total - (select sum(valor_bruto) + sum(desconto)  as valorTotPag from ponto.tb_internacao_faturar aef2
            where aef2.internacao_id = aef.internacao_id and ativo = true)) as valor_restante,
            ', false);
            $this->db->from('tb_internacao_faturar aef');
            $this->db->where('aef.internacao_id', $id);
            $this->db->where('aef.ativo', 't');
            $this->db->groupby('aef.internacao_id,
                                aef.valor_total,
                              ');
        }else{
            $id = str_replace('e_', '', $internacao_id);
            $this->db->select('
            aef.internacao_evolucao_id,
            aef.valor_total,
            (aef.valor_total - (select sum(valor_bruto) + sum(desconto)  as valorTotPag from ponto.tb_internacao_evolucao_faturar aef2
            where aef2.internacao_evolucao_id = aef.internacao_evolucao_id and ativo = true)) as valor_restante,
            ', false);
            $this->db->from('tb_internacao_evolucao_faturar aef');
            $this->db->where('aef.internacao_evolucao_id', $id);
            $this->db->where('aef.ativo', 't');
            $this->db->groupby('aef.internacao_evolucao_id,
                                aef.valor_total,
                              ');
        }


        $return = $this->db->get();
        $retorno = $return->result();

        return $retorno;
    }

    function listarinternacaoevolucaopagamento($internacao_evolucao_id){
        $this->db->select('
                            ie.internacao_evolucao_id,
                            ie.procedimento_tuss_id,
                            ie.internacao_id,
                            ie.valor as valor_total,
                            ie.data,
                            ie.valor');
        $this->db->from('tb_internacao_evolucao ie');
        $this->db->where('ie.internacao_evolucao_id', $internacao_evolucao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function agendaExamesFormasPagamentoInternacao($internacao_id) {

        $this->db->select('fp.forma_pagamento_id,
                            aef.internacao_id,
                            aef.internacao_faturar_id,
                            aef.valor_total,
                            (aef.valor_total - (select sum(valor_bruto) + sum(desconto)  as valorTotPag from ponto.tb_internacao_faturar aef2
                            where aef2.internacao_id = aef.internacao_id and ativo = true)) as valor_restante,
                            aef.valor,
                            aef.valor_bruto,
                            aef.data,
                            aef.ajuste,
                            aef.parcela,
                            aef.financeiro,
                            aef.desconto,
                            fp.nome as forma_pagamento', false);
        $this->db->from('tb_internacao_faturar aef');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = aef.forma_pagamento_id', 'left');
        $this->db->where('aef.internacao_id', $internacao_id);
        $this->db->where('aef.ativo', 't');
        $this->db->orderby('aef.data, fp.nome');
        $return = $this->db->get();
        $retorno = $return->result();
        return $retorno;
    }

    function agendaExamesFormasPagamentoInternacaoEvolucao($internacao_evolucao_id) {

                $this->db->select('fp.forma_pagamento_id,
                                    aef.internacao_evolucao_id,
                                    aef.internacao_evolucao_faturar_id,
                                    aef.valor_total,
                                    (aef.valor_total - (select sum(valor_bruto) + sum(desconto)  as valorTotPag from ponto.tb_internacao_evolucao_faturar aef2
                                    where aef2.internacao_evolucao_id = aef.internacao_evolucao_id and ativo = true)) as valor_restante,
                                    aef.valor,
                                    aef.valor_bruto,
                                    aef.data,
                                    aef.ajuste,
                                    aef.parcela,
                                    aef.financeiro,
                                    aef.desconto,
                                    fp.nome as forma_pagamento', false);
                $this->db->from('tb_internacao_evolucao_faturar aef');
                $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = aef.forma_pagamento_id', 'left');
                $this->db->where('aef.internacao_evolucao_id', $internacao_evolucao_id);
                $this->db->where('aef.ativo', 't');
                $this->db->orderby('aef.data, fp.nome');
                $return = $this->db->get();
                $retorno = $return->result();
                return $retorno;
            }

            function agendaExamesFormasPagamentoInternacaoEvolucao2($internacao_id) {

                $this->db->select('fp.forma_pagamento_id,
                                    aef.internacao_id,
                                    sum(aef.valor_total) as valor_total,
                                    sum(aef.valor) as valor,
                                    sum(aef.valor_bruto) as valor_bruto,
                                    aef.data,
                                    aef.ajuste,
                                    aef.parcela,
                                    aef.financeiro,
                                    aef.desconto,
                                    fp.nome as forma_pagamento', false);
                $this->db->from('tb_internacao_evolucao_faturar aef');
                $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = aef.forma_pagamento_id', 'left');
                $this->db->where('aef.internacao_id', $internacao_id);
                $this->db->where('aef.ativo', 't');
                $this->db->orderby('aef.data, fp.nome');
                $this->db->groupby('fp.forma_pagamento_id,
                                    aef.internacao_id,
                                    aef.data,
                                    aef.ajuste,
                                    aef.parcela,
                                    aef.financeiro,
                                    aef.desconto,
                                    fp.nome');
                $return = $this->db->get();
                $retorno = $return->result();
                return $retorno;
            }

    function listarprocedimentoexterno($internacao_id) {
        $this->db->select('p.nome, 
                           ie.internacao_procedimento_externo_id, 
                           ie.procedimento, 
                           ie.duracao, 
                           ie.data, 
                           o.nome as operador,
                           ie.data_cadastro, 
                           p.nascimento');
        $this->db->from('tb_internacao_procedimento_externo ie');
        $this->db->join('tb_internacao i', "i.internacao_id = ie.internacao_id", 'left');
        $this->db->join('tb_paciente p', "i.paciente_id = p.paciente_id", 'left');
        $this->db->join('tb_operador o', "ie.operador_cadastro = o.operador_id", 'left');
        $this->db->where("ie.internacao_id = $internacao_id");
        $this->db->where("ie.ativo", 't');
        $this->db->orderby("ie.internacao_procedimento_externo_id");
        $return = $this->db->get();
        return $return->result();
    }

    function editarevolucaointernacao($internacao_evolucao_id) {
        $this->db->select('p.nome, 
                           ie.internacao_evolucao_id, 
                           ie.conduta, 
                           ie.diagnostico, 
                           ie.data_cadastro, 
                           p.nascimento,
                           pt.nome as procedimento,
                           ie.valor,
                           c.nome as convenio');
        $this->db->from('tb_internacao_evolucao ie');
        $this->db->join('tb_internacao i', "i.internacao_id = ie.internacao_id", 'left');
        $this->db->join('tb_paciente p', "i.paciente_id = p.paciente_id", 'left');
        $this->db->join('tb_convenio c', "c.convenio_id = ie.convenio_id", 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ie.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("ie.internacao_evolucao_id = $internacao_evolucao_id");
//        $this->db->where("ie.ativo", 't');
        $this->db->orderby("ie.internacao_evolucao_id");
        $return = $this->db->get();
        return $return->result();
    }

    function editarprocedimentoexternointernacao($internacao_procedimento_externo_id) {
        $this->db->select('p.nome, 
                           ie.internacao_procedimento_externo_id, 
                           ie.data, 
                           ie.duracao, 
                           ie.procedimento, 
                           ie.observacao, 
                           ie.data_cadastro, 
                           p.nascimento');
        $this->db->from('tb_internacao_procedimento_externo ie');
        $this->db->join('tb_internacao i', "i.internacao_id = ie.internacao_id", 'left');
        $this->db->join('tb_paciente p', "i.paciente_id = p.paciente_id", 'left');
        $this->db->where("ie.internacao_procedimento_externo_id = $internacao_procedimento_externo_id");
//        $this->db->where("ie.ativo", 't');
        $this->db->orderby("ie.internacao_procedimento_externo_id");
        $return = $this->db->get();
        return $return->result();
    }

    private function instanciar($emergencia_solicitacao_acolhimento_id) {
        if ($paciente_id != 0) {

            $this->db->select('tp.tipo_logradouro_id as codigo_logradouro,tp.descricao,p.*,c.nome as cidade_desc,c.municipio_id as cidade_cod,e.estado_id as uf_cod, e.nome as uf_desc');
            $this->db->from('tb_paciente p');
            $this->db->join('tb_municipio c', 'c.municipio_id = p.municipio_id', 'left');
            $this->db->join('tb_estado e', 'e.estado_id = p.uf_rg', 'left');
            $this->db->join('tb_tipo_logradouro tp', 'p.tipo_logradouro = tp.tipo_logradouro_id', 'left');
            $this->db->where("paciente_id", $paciente_id);
            $query = $this->db->get();
            $return = $query->result();

            $this->_paciente_id = $paciente_id;
            $this->_cpf = $return[0]->cpf;
            $this->_nome = $return[0]->nome;
            $this->_cns = $return[0]->cns;
            if (isset($return[0]->nascimento)) {
                $this->_nascimento = $return[0]->nascimento;
            }
            $this->_idade = $return[0]->idade;
            $this->_documento = $return[0]->rg;
            $this->_estado_id_expedidor = $return[0]->uf_rg;
            $this->_titulo_eleitor = $return[0]->titulo_eleitor;
            $this->_raca_cor = $return[0]->raca_cor;
            $this->_sexo = $return[0]->sexo;
            $this->_estado_civil = $return[0]->estado_civil_id;
            $this->_nomepai = $return[0]->nome_pai;
            $this->_nomemae = $return[0]->nome_mae;
            $this->_telMae = $return[0]->telefone_mae;
            $this->_telefone = $return[0]->telefone;
            $this->_tipoLogradouro = $return[0]->codigo_logradouro;
            $this->_numero = $return[0]->numero;
            $this->_rua = $return[0]->logradouro;
            $this->_bairro = $return[0]->bairro;
            $this->_cidade = $return[0]->municipio_id;
            $this->_cep = $return[0]->cep;
            $this->_observacao = $return[0]->observacao;
            $this->_complemento = $return[0]->complemento;
            $this->_estado_expedidor = $return[0]->uf_desc;
            $this->_estado_id_expedidor = $return[0]->uf_cod;
            $this->_cidade_nome = $return[0]->cidade_desc;
            $this->_data_emissao = $return[0]->data_emissao;
        }
    }

    function listaunidade() {
        $this->db->select(' internacao_unidade_id,
                            nome');
        $this->db->from('tb_internacao_unidade');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function usafarmacia() {
        $this->db->select(' empresa_id,
                            nome');
        $this->db->from('tb_empresa');
        $this->db->where('farmacia', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function pesquisarunidade($unidade_id) {
        $this->db->select(' internacao_unidade_id,
                            nome');
        $this->db->from('tb_internacao_unidade');
        $this->db->where('internacao_unidade_id', $unidade_id);
        $return = $this->db->get();
        return $return->result();
    }

    function pesquisarenfermaria($unidade_id) {
        $this->db->select(' internacao_enfermaria_id,
                            nome');
        $this->db->from('tb_internacao_enfermaria');
        $this->db->where('internacao_enfermaria_id', $unidade_id);
        $return = $this->db->get();
        return $return->result();
    }

    function pesquisarindicaco($unidade_id) {
        $this->db->select('paciente_indicacao_id,
                            nome');
        $this->db->from('tb_paciente_indicacao');
        $this->db->where('paciente_indicacao_id', $unidade_id);
        $return = $this->db->get();
        return $return->result();
    }

    function pesquisarconvenio($unidade_id) {
        $this->db->select('convenio_id,
                            nome');
        $this->db->from('tb_convenio');
        $this->db->where('convenio_id', $unidade_id);
        $return = $this->db->get();
        return $return->result();
    }

    function pesquisartipodependencia($unidade_id) {
        $this->db->select('internacao_tipo_dependencia_id,
                            nome');
        $this->db->from('tb_internacao_tipo_dependencia');
        $this->db->where('internacao_tipo_dependencia_id', $unidade_id);
        $return = $this->db->get();
        return $return->result();
    }

    function pesquisarcidade($unidade_id) {
        $this->db->select('municipio_id,
                            nome');
        $this->db->from('tb_municipio');
        $this->db->where('municipio_id', $unidade_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listapacienteinternado($internacao_id) {
        $this->db->select(' p.nome as paciente,
                            p.paciente_id,
                            i.internacao_id,
                            il.nome as leito,
                            i.leito as leito_id');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id ');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id ');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        // $this->db->where('p.paciente_id', $paciente_id);
        $this->db->where('i.internacao_id', $internacao_id);
        // $this->db->where('i.leito = il.internacao_leito_id');
        // $this->db->where('il.ativo', 'f');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprodutosenteral($internacao_id) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_paciente p', 'p.convenio_id = pc.convenio_id ');
        $this->db->join('tb_internacao i', 'i.paciente_id = p.paciente_id ');
        $this->db->where('i.internacao_id', $internacao_id);
        $this->db->where('pt.grupo', 'ENTERAL');
        $this->db->where('pc.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprodutosequipo($internacao_id) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_paciente p', 'p.convenio_id = pc.convenio_id ');
        $this->db->join('tb_internacao i', 'i.paciente_id = p.paciente_id ');
        $this->db->where('i.internacao_id', $internacao_id);
        $this->db->where('pt.grupo', 'EQUIPO');
        $this->db->where('pc.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoesenteral($internacao_id) {
        $data = date("Y-m-d");
        $this->db->select(' ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ', 'left');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ', 'left');
        $this->db->where('ipp.internacao_id', $internacao_id);
        $this->db->where('ipp.tipo', 'ENTERALNORMAL');
        $this->db->where('ip.data', $data);
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoesenteralemergencial($internacao_id) {
        $data = date("Y-m-d");
        $this->db->select(' ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ', 'left');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ', 'left');
        $this->db->where('ipp.internacao_id', $internacao_id);
        $this->db->where('ipp.tipo', 'ENTERALEMERGENCIAL');
        $this->db->where('ip.data', $data);
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoespaciente($internacao_id) {
        $data = date("Y-m-d");
        $this->db->select(' ip.data,
                            ip.internacao_precricao_id,
                            ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ');
        $this->db->where('ipp.internacao_id', $internacao_id);
        $this->db->where('pt.grupo !=', 'EQUIPO');
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoespacienteequipo($internacao_id) {
        $data = date("Y-m-d");
        $this->db->select(' ipp.internacao_precricao_id,
                            ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ');
        $this->db->where('ipp.internacao_id', $internacao_id);
        $this->db->where('pt.grupo', 'EQUIPO');
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoesdata() {
        $data = date("Y-m-d");
        $this->db->select(' ip.data,
                            ip.internacao_precricao_id,
                            ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome,
                            p.nome as paciente');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ');
        $this->db->join('tb_internacao i', 'i.internacao_id = ip.internacao_id');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id');
        $this->db->where('ip.data >=', $_POST['txtdata_inicio']);
        $this->db->where('ip.data <=', $_POST['txtdata_fim']);
        $this->db->where('ipp.tipo', $_POST['tipo']);
        if ($_POST['unidade'] != 0) {
            $this->db->where('i.hospital_id', $_POST['unidade']);
        }
        $this->db->where('pt.grupo !=', 'EQUIPO');
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioprecadastro() {
        $data = date("Y-m-d");
        $this->db->select(' 
                          p.nome as paciente,
                          p.idade,
                          ifq.nome as responsavel,
                          ifq.aceita_tratamento,
                          ifq.data_cadastro,
                          ifq.telefone_contato as telefone,
                          m.nome as cidade,
                          c.nome as convenio,
                          pi.nome as indicacao,
                          ifq.tipo_dependencia as dependencia,
                          ifq.confirmado,
                          ifq.aprovado,
                          ');
        $this->db->from('tb_internacao_ficha_questionario ifq');
        $this->db->join('tb_paciente p', 'p.paciente_id = ifq.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = ifq.convenio_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = ifq.municipio_id', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = ifq.tomou_conhecimento', 'left');
        // $this->db->join('tb_internacao_tipo_dependencia itd', 'itd.internacao_tipo_dependencia_id = ifq.tipo_dependencia', 'left');
        $this->db->where('ifq.ativo', 't');
        $this->db->where("ifq.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00');
        $this->db->where("ifq.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');


        if ($_POST['aceita_tratamento'] != '') {
            $this->db->where('ifq.aceita_tratamento', $_POST['aceita_tratamento']);
        }
        if ($_POST['indicacao'] > 0) {
            $this->db->where('ifq.tomou_conhecimento', $_POST['indicacao']);
        }
        if ($_POST['convenio'] != 0) {
            if ($_POST['convenio'] == '-1') {
                $this->db->where('ifq.convenio_id', null);
            } else {
                $this->db->where('ifq.convenio_id', $_POST['convenio']);
            }
        }
        if ($_POST['cidade'] > 0) {

            $this->db->where('ifq.municipio_id', $_POST['cidade']);
        }
        // $post_dependencia = $_POST['tipo_dependencia'];
        // if ($_POST['tipo_dependencia'] > 0) {
        //     $this->db->where("position('$post_dependencia' in ifq.tipo_dependencia) > 0");
        // }
        // Filtro é feito na view agora porque é mais de um por campo e blá blá blá.
        if ($_POST['confirmado'] != '') {
            $this->db->where('ifq.confirmado', $_POST['confirmado']);
        }
        if ($_POST['aprovado'] != '') {
            $this->db->where('ifq.aprovado', $_POST['aprovado']);
        }

        $this->db->orderby('ifq.data_cadastro desc');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocensodiario() {
        $data = date("Y-m-d");
        $this->db->select(' 
                          il.nome as leito,
                          il.condicao,
                          il.ativo,
                          ist.nome as status,
                          ist.color,
                          ROW_NUMBER() OVER (PARTITION BY il.internacao_leito_id) AS row_number, 
                          il.internacao_leito_id,
                          i.excluido as excluido_int,
                          i.ativo as ativo_int,
                          ie.nome as enfermaria,
                          ie.unidade_id,
                          iu.nome as unidade,
                          i.cid1solicitado as cid1,
                          i.data_internacao,
                          i.internacao_id,
                          p.nome as paciente,
                          p.sexo,
                          p.nascimento,
                          p.idade,
                          pt.nome as procedimento,
                          ia.nome as alerta,
                          ia.cor
                          
                          ');
        $this->db->from('tb_internacao_leito il');
        $this->db->join('tb_internacao i', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_statusinternacao ist', 'ist.internacao_statusinternacao_id = i.internacao_statusinternacao_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->join('tb_internacao_alerta ia', 'ia.internacao_alerta_id = i.internacao_alerta_id', 'left');
        $this->db->where('il.excluido', 'f');
        $this->db->where('ie.ativo', 't');
        $this->db->where('iu.ativo', 't');
        $this->db->where('(i.excluido = false OR i.excluido is null OR (i.excluido = true AND il.ativo = true))');
        $this->db->where('(i.ativo = true OR i.ativo is null OR (i.ativo = false AND il.ativo = true))');
        // Não dá pra fazer a verificação da existência da internação aqui, deve ser feito na view
        if ($_POST['unidade'] != '') {
            $this->db->where('ie.unidade_id', $_POST['unidade']);
        }
        if ($_POST['enfermaria'] != '') {
            $this->db->where('il.enfermaria_id', $_POST['enfermaria']);
        }
        if ($_POST['status_leito'] != '') {

            if ($_POST['status_leito'] == 'Vago') {
                $this->db->where('il.ativo', 't');
            } elseif ($_POST['status_leito'] == 'Ocupado') {
                $this->db->where('il.ativo', 'f');
            } else {
                $this->db->where('il.condicao', $_POST['status_leito']);
            }
        }

        $this->db->orderby('iu.internacao_unidade_id, ie.internacao_enfermaria_id, il.nome, p.paciente_id, i.data_internacao desc');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriounidadeleito() {
        $data = date("Y-m-d");
        $this->db->select(' 
                          il.nome as leito,
                          il.condicao,
                          il.tipo as tipoleito,
                          il.ativo,
                          ie.nome as enfermaria,
                          ie.unidade_id,
                          ie.tipo as tipoenfermaria,
                          iu.nome as unidade                        
                          
                          ');
        $this->db->from('tb_internacao_leito il');
        $this->db->join('tb_internacao i', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->where('il.excluido', 'f');
        $this->db->where('ie.ativo', 't');
        $this->db->where('iu.ativo', 't');
        $this->db->where('(i.excluido = false OR i.excluido is null)');
        $this->db->where('(i.ativo = true OR i.ativo is null)');

        if ($_POST['unidade'] != '') {
            $this->db->where('ie.unidade_id', $_POST['unidade']);
        }
        if ($_POST['enfermaria'] != '') {
            $this->db->where('il.enfermaria_id', $_POST['enfermaria']);
        }

        $this->db->orderby('iu.internacao_unidade_id, ie.internacao_enfermaria_id, il.ativo, il.nome, i.data_internacao desc');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriointernacao() {
        $data = date("Y-m-d");
        $this->db->select(' 
                          il.nome as leito,
                          il.condicao,
                          il.ativo,
                          ie.nome as enfermaria,
                          ie.unidade_id,
                          iu.nome as unidade,
                          i.cid1solicitado as cid1,
                          i.data_internacao,
                          p.nome as paciente,
                          p.sexo,
                          p.nascimento,
                          p.idade,
                          c.nome as convenio,
                          pt.nome as procedimento,
                          
                          ');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->where('i.ativo = true');
        $this->db->where('i.excluido = false');
        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00';

        $this->db->where("(i.data_internacao >= '$data_inicio' OR cast(i.data_internacao AS date) + 
        cast((Select sum(quantidade) from ponto.tb_internacao_procedimentos
         where internacao_id = i.internacao_id and ativo = true) as integer) >= '$data_inicio')");
//        $this->db->where("i.data_internacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) );
        $this->db->where("i.data_internacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
        if ($_POST['convenio'] != '') {
            if ($_POST['convenio'] == '-1') {
                $this->db->where('c.convenio_id', null);
            } else {
                $this->db->where('c.convenio_id', $_POST['convenio']);
            }
        }


        $this->db->orderby('iu.internacao_unidade_id, ie.internacao_enfermaria_id, il.ativo, il.nome, i.data_internacao desc');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriointernacaosituacao() {
        $data = date("Y-m-d");
        $this->db->select(' 
                          il.nome as leito,
                          il.condicao,
                          il.ativo,
                          ie.nome as enfermaria,
                          ie.unidade_id,
                          iu.nome as unidade,
                          i.ativo as situacao,
                          i.cid1solicitado as cid1,
                          i.data_internacao,
                          p.nome as paciente,
                          p.sexo,
                          p.nascimento,
                          p.idade,
                          c.nome as convenio,
                          pt.nome as procedimento,
                          
                          ');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
//        $this->db->where('i.ativo = true');
        $this->db->where('i.excluido = false');
        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00';

        $this->db->where("(i.data_internacao >= '$data_inicio' OR cast(i.data_internacao AS date) + 
        cast((Select sum(quantidade) from ponto.tb_internacao_procedimentos
         where internacao_id = i.internacao_id and ativo = true) as integer) >= '$data_inicio')");
//        $this->db->where("i.data_internacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) );
        $this->db->where("i.data_internacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
        if ($_POST['convenio'] != '') {
            if ($_POST['convenio'] == '-1') {
                $this->db->where('c.convenio_id', null);
            } else {
                $this->db->where('c.convenio_id', $_POST['convenio']);
            }
        }


        $this->db->orderby('iu.internacao_unidade_id, ie.internacao_enfermaria_id, il.ativo, il.nome, i.data_internacao desc');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriosaidainternacao() {
        $data = date("Y-m-d");
        $this->db->select(' 
                          il.nome as leito,
                          il.condicao,
                          il.ativo,
                          ie.nome as enfermaria,
                          ie.unidade_id,
                          iu.nome as unidade,
                          i.cid1solicitado as cid1,
                          i.data_internacao,
                          i.data_saida,
                          p.nome as paciente,
                          p.sexo,
                          p.nascimento,
                          p.idade,
                          c.nome as convenio,
                          pt.nome as procedimento,
                          
                          ');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->where('i.ativo = false');
        $this->db->where('i.excluido = false');
        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00';

        $this->db->where("(i.data_internacao >= '$data_inicio' OR cast(i.data_internacao AS date) + 
        cast((Select sum(quantidade) from ponto.tb_internacao_procedimentos
         where internacao_id = i.internacao_id and ativo = true) as integer) >= '$data_inicio')");
//        $this->db->where("i.data_internacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) );
        $this->db->where("i.data_internacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
        if ($_POST['convenio'] != '') {
            if ($_POST['convenio'] == '-1') {
                $this->db->where('c.convenio_id', null);
            } else {
                $this->db->where('c.convenio_id', $_POST['convenio']);
            }
        }


        $this->db->orderby('iu.internacao_unidade_id, ie.internacao_enfermaria_id, il.ativo, il.nome, i.data_internacao desc');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriointernacaofaturamento() { 
        $data = date("Y-m-d");
        $this->db->select(' 
                          il.nome as leito,
                          il.condicao,
                          il.ativo,
                          ie.nome as enfermaria,
                          ie.unidade_id,
                          iu.nome as unidade,
                          i.cid1solicitado as cid1,
                          i.data_internacao,
                          i.data_saida,
                          i.valor_total,
                          p.nome as paciente,
                          p.sexo,
                          p.nascimento,
                          p.idade,
                          c.nome as convenio,
                          pt.nome as procedimento,
                          op.nome as operador_cadstro
                          ');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'p.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->join('tb_operador op','op.operador_id = i.operador_cadastro','left');
//        $this->db->where('i.ativo = true');
        $this->db->where("i.data_internacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00');
        $this->db->where("i.data_internacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
        if ($_POST['convenio'] != '') {
            if ($_POST['convenio'] == '-1') {
                $this->db->where('c.convenio_id', null);
            } else {
                $this->db->where('c.convenio_id', $_POST['convenio']);
            }
        }
        if ($_POST['operador'] != "") {
            $this->db->where('op.operador_id',$_POST['operador']);
        }
          
        $this->db->orderby('iu.internacao_unidade_id, ie.internacao_enfermaria_id, il.ativo, il.nome, i.data_internacao desc');
        $return = $this->db->get();
        return $return->result();
    }

    function listarcarregarinternacao($internacao_id) {
        $data = date("Y-m-d");
        $this->db->select(' 
                          i.*,
                          il.nome as leito,
                          il.internacao_leito_id,
                          p.nome as paciente,
                          p.sexo,
                          p.nascimento,
                          ie.nome as enfermaria,
                          iu.nome as unidade,
                          cid.co_cid,
                          cid.no_cid,
                          cid2.co_cid as co_cid2,
                          cid2.no_cid as no_cid2,
                          pt.nome as procedimento,
                          pt.procedimento_tuss_id,
                          pc.procedimento_convenio_id,
                          pc.convenio_id,
                          m.nome as cidade_responsavel,
                          i.internacao_alerta_id
                          
                          ');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_municipio m', 'i.municipio_responsavel_id = m.municipio_id', 'left');
        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->join('tb_cid cid2', 'cid2.co_cid = i.cid2solicitado', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("i.internacao_id ", $internacao_id);

        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoesequipodata() {
        $data = date("Y-m-d");
        $this->db->select(' ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ');
        $this->db->join('tb_internacao i', 'i.internacao_id = ip.internacao_id');
        $this->db->where('ip.data >=', $_POST['txtdata_inicio']);
        $this->db->where('ip.data <=', $_POST['txtdata_fim']);
        $this->db->where('ipp.tipo', $_POST['tipo']);
        if ($_POST['unidade'] != 0) {
            $this->db->where('i.hospital_id', $_POST['unidade']);
        }
        $this->db->where('pt.grupo', 'EQUIPO');
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaleitointarnacao($unidade_id) {
        $this->db->select(' il.internacao_leito_id,
                            il.nome');
        $this->db->from('tb_internacao_leito il');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->where('il.ativo', 't');
        $this->db->where('il.excluido', 'f');
        $this->db->where('il.condicao', 'Normal');
        $this->db->where('iu.internacao_unidade_id', $unidade_id);
        $this->db->orderby('ie.internacao_enfermaria_id, il.internacao_leito_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaleitointarnacao2($unidade_id) {
        $this->db->select(' il.internacao_leito_id,
                            il.nome as leito,
                            ie.nome as enfermaria');
        $this->db->from('tb_internacao_leito il, tb_internacao_enfermaria ie');
        $this->db->where('ie.internacao_enfermaria_id = il.enfermaria_id');
        $this->db->where('il.ativo', 't');
        $this->db->where('il.excluido', 'f');
        $this->db->where('il.condicao', 'Normal');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->where('iu.internacao_unidade_id', $unidade_id);
        $this->db->orderby('ie.internacao_enfermaria_id, il.internacao_leito_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listapacienteunidade($unidade) {
        $this->db->select(' p.nome as paciente,
                            p.paciente_id,
                            il.internacao_leito_id as leito_id,
                            il.nome as leito,
                            ie.nome as enfermaria');
        $this->db->from('tb_paciente p, tb_internacao i, tb_internacao_leito il, tb_internacao_enfermaria ie');
        $this->db->where('i.paciente_id = p.paciente_id');
        $this->db->where('i.leito = il.internacao_leito_id');
        $this->db->where('il.ativo', 'f');
        $this->db->where('i.ativo', 't');
        $this->db->where('i.excluido', 'f');
        $this->db->where('il.excluido', 'f');
        $this->db->where('ie.internacao_enfermaria_id = il.enfermaria_id');
        $this->db->where('ie.unidade_id', $unidade);
        $this->db->orderby('ie.internacao_enfermaria_id, il.internacao_leito_id');

        $return = $this->db->get();
        return $return->result();
    }

    function listaunidadecondicao($condicao) {
        $sql = "SELECT DISTINCT iu.nome,
                       iu.internacao_unidade_id
                FROM ponto.tb_internacao_leito il, ponto.tb_internacao_enfermaria ie, ponto.tb_internacao_unidade iu
                WHERE ie.internacao_enfermaria_id = il.enfermaria_id
                AND iu.internacao_unidade_id = ie.unidade_id ";
        if ($condicao == "Ocupado") {
            $sql .= "AND il.ativo = 'f'";
        } else {
            $sql .= "AND il.ativo = 't'
                AND il.condicao = '$condicao'";
        }
        $return = $this->db->query($sql);
        return $return->result();
    }

    function listaunidadetransferencia($condicao = '') {
        $this->db->select('iu.internacao_unidade_id,
                           iu.nome as unidade');
        $this->db->from('tb_internacao_unidade iu');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaenfermariatransferencia() {
        $this->db->select('ie.internacao_enfermaria_id,
                           ie.nome as enfermaria,
                           ie.unidade_id');
        $this->db->from('tb_internacao_enfermaria ie');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaleitotransferencia() {
        $this->db->select('il.internacao_leito_id as leito_id,
                           il.nome as leito,
                           il.enfermaria_id');
        $this->db->from('tb_internacao_leito il');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function pegaidpacientepermuta($leito_id) {
        //pegando o id do paciente permutado
        $this->db->select('i.paciente_id');
        $this->db->from('tb_internacao i');
        $this->db->where('i.leito', $leito_id);
        $this->db->where('i.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function permutapacientes() {
        //trocando os leitos na tabela internacao
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('i.internacao_id');
        $this->db->from('tb_internacao i');
//        $this->db->where('i.leito',  $_POST['leito_troca']);
        $this->db->where('i.paciente_id', $_POST['paciente_id_selecionado']);
        $this->db->where('i.ativo', 't');
        $return1 = $this->db->get()->result();
        $internacao_id1 = $return1[0]->internacao_id;

        $this->db->set('leito', $_POST['leito_troca']);
        $this->db->where('internacao_id', $internacao_id1);
        $this->db->update('tb_internacao');


        $this->db->select('i.internacao_id');
        $this->db->from('tb_internacao i');
//        $this->db->where('i.leito',  $_POST['leito_troca']);
        $this->db->where('i.paciente_id', $_POST['id_paciente_troca'][0]->paciente_id);
        $this->db->where('i.ativo', 't');
        $return2 = $this->db->get()->result();
        $internacao_id2 = $return2[0]->internacao_id;


        $this->db->set('leito', $_POST['leito_id_selecionado']);
        $this->db->where('internacao_id', $internacao_id2);
        $this->db->update('tb_internacao');
        // Inserindo na tabela as informações de alteração de leito do paciente 1 (O paciente cujo os dados vem carregados)
        $this->db->set('internacao_id', $internacao_id1);
        $this->db->set('leito_id', $_POST['leito_id_selecionado']);
        $this->db->set('tipo', 'SAIDA');
        $this->db->set('status', 'PERMUTA');
        $this->db->set('data', $horario);
        $this->db->set('operador_movimentacao', $operador_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_internacao_leito_movimentacao');

        $this->db->set('internacao_id', $internacao_id1);
        $this->db->set('leito_id', $_POST['leito_troca']);
        $this->db->set('tipo', 'ENTRADA');
        $this->db->set('status', 'PERMUTA');
        $this->db->set('data', $horario);
        $this->db->set('operador_movimentacao', $operador_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_internacao_leito_movimentacao');
        // Inserindo na tabela a saida e a entrada do paciente 2 (O que foi escolhido no select)
        $this->db->set('internacao_id', $internacao_id2);
        $this->db->set('leito_id', $_POST['leito_troca']);
        $this->db->set('tipo', 'SAIDA');
        $this->db->set('status', 'PERMUTA');
        $this->db->set('data', $horario);
        $this->db->set('operador_movimentacao', $operador_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_internacao_leito_movimentacao');

        $this->db->set('internacao_id', $internacao_id2);
        $this->db->set('leito_id', $_POST['leito_id_selecionado']);
        $this->db->set('tipo', 'ENTRADA');
        $this->db->set('status', 'PERMUTA');
        $this->db->set('data', $horario);
        $this->db->set('operador_movimentacao', $operador_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_internacao_leito_movimentacao');

        //atualizando a tabela ocupacao
        $this->db->set('ocupado', 'f');
        $this->db->where('paciente_id', $_POST['paciente_id_selecionado']);
        $this->db->where('leito_id', $_POST['leito_id_selecionado']);
        $this->db->update('tb_internacao_ocupacao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }
        $this->db->set('ocupado', 'f');
        $this->db->where('paciente_id', $_POST['id_paciente_troca'][0]->paciente_id);
        $this->db->where('leito_id', $_POST['leito_troca']);
        $this->db->update('tb_internacao_ocupacao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }

        //inserindo na tabela ocupacao
        try {


            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('paciente_id', $_POST['paciente_id_selecionado']);
            $this->db->set('leito_id', $_POST['leito_troca']);
            $this->db->set('ocupado', 't');
            $this->db->insert('tb_internacao_ocupacao');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                $this->db->insert_id();
            }

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('paciente_id', $_POST['id_paciente_troca'][0]->paciente_id);
            $this->db->set('leito_id', $_POST['leito_id_selecionado']);
            $this->db->set('ocupado', 't');
            $this->db->insert('tb_internacao_ocupacao');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                $this->db->insert_id();
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function transferirpacienteleito() {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('i.internacao_id');
        $this->db->from('tb_internacao i');
//        $this->db->where('i.leito',  $_POST['leito_troca']);
        $this->db->where('i.paciente_id', $_POST['paciente_id']);
        $this->db->where('i.ativo', 't');
        $return1 = $this->db->get()->result();
        $internacao_id = $return1[0]->internacao_id;

        // Inserindo na tabela a saida e a entrada do paciente 2 (O que foi escolhido no select)
        $this->db->set('internacao_id', $internacao_id);
        $this->db->set('leito_id', $_POST['leito_id']);
        $this->db->set('tipo', 'SAIDA');
        $this->db->set('status', 'TRANSFERENCIA');
        $this->db->set('data', $horario);
        $this->db->set('operador_movimentacao', $operador_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_internacao_leito_movimentacao');

        $this->db->set('internacao_id', $internacao_id);
        $this->db->set('leito_id', $_POST['novo_leito']);
        $this->db->set('tipo', 'ENTRADA');
        $this->db->set('status', 'TRANSFERENCIA');
        $this->db->set('data', $horario);
        $this->db->set('operador_movimentacao', $operador_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_internacao_leito_movimentacao');

        //atualizando o leito na tabela internacao e ocupacao
        $this->db->set('leito', $_POST['novo_leito']);
        $this->db->where('internacao_id', $internacao_id);
        $this->db->update('tb_internacao');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }

        $this->db->set('ocupado', 'f');
        $this->db->where('paciente_id', $_POST['paciente_id']);
        $this->db->where('leito_id', $_POST['leito_id']);
        $this->db->update('tb_internacao_ocupacao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }


        //inserindo na tabela ocupacao
        try {


            if ($_POST['internacao_unidade_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('paciente_id', $_POST['paciente_id']);
                $this->db->set('leito_id', $_POST['novo_leito']);
                $this->db->set('ocupado', 't');
                $this->db->insert('tb_internacao_ocupacao');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else {
                    $internacao_unidade_id = $this->db->insert_id();
                }
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarreceituariointernacao($internacao_id) {
        try {

            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('texto', $_POST['laudo']);
            $this->db->set('paciente_id', $_POST['paciente_id']);
            $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
            $this->db->set('laudo_id', $internacao_id);
            $this->db->set('medico_parecer1', $_POST['medico']);
            $this->db->set('tipo', 'NORMAL');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_ambulatorio_receituario');


            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function atualizaleitotranferencia($leito_id, $novo_leito) {
        //setando o antigo leito para true
        $this->db->set('ativo', 'true');
        $this->db->where('internacao_leito_id', $leito_id);
        $this->db->update('tb_internacao_leito');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }
        //setando o atual leito para false
        $this->db->set('ativo', 'false');
        $this->db->where('internacao_leito_id', $novo_leito);
        $this->db->update('tb_internacao_leito');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }
    }

    function buscaPaciente($pacienteId) {

        $this->db->from('tb_paciente')
                ->select('nome');
        $this->db->where('paciente_id', $pacienteId);
        return $this->db;
    }

    function listar($args = array()) {
        $this->db->select(' i.internacao_id,
                            i.paciente_id,
                            p.nome,
                            i.data_internacao,
                            i.data_saida');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id ');
        $this->db->where('i.ativo', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', $args['nome'] . "%", 'left');
                $this->db->orwhere('i.paciente_id', $args['nome']);
            }
        }
        return $this->db;
    }

    function listarsaida($args = array()) {
        $this->db->select(' i.internacao_id,
                            i.paciente_id,
                            p.nome,
                            i.data_internacao,
                            i.data_saida');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'il.enfermaria_id = ie.internacao_enfermaria_id', 'left');
        $this->db->join('tb_internacao_unidade iu', 'ie.unidade_id = iu.internacao_unidade_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id ');
        $this->db->where('i.ativo', 'f');
        $this->db->where('i.excluido', 'f');
        if ($args) {
//            if (isset($args['nome']) && strlen($args['nome']) > 0) {
//                $this->db->where('p.nome ilike', $args['nome'] . "%", 'left');
////                $this->db->orwhere('i.paciente_id', $args['nome']);
//                $this->db->orwhere('p.nome', $args['nome']);
//            }

            if (isset($args['data_inicio']) && strlen($args['data_inicio']) > 0) {
                $this->db->where("i.data_internacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $args['data_inicio']))) . ' 00:00:00');
            }
            if (isset($args['data_fim']) && strlen($args['data_fim']) > 0) {
                $this->db->where("i.data_internacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $args['data_fim']))) . ' 23:59:59');
            }
            if (isset($args['unidade']) && strlen($args['unidade']) > 0) {
                $this->db->where('iu.internacao_unidade_id', $args['unidade']);
//                $this->db->orwhere('i.paciente_id', $args['nome']);
            }
            if (isset($args['enfermaria']) && strlen($args['enfermaria']) > 0) {
                $this->db->where('ie.internacao_enfermaria_id', $args['enfermaria']);
//                $this->db->orwhere('i.paciente_id', $args['nome']);
            }

            if (isset($args['leito']) && strlen($args['leito']) > 0) {
                $this->db->where('il.internacao_leito_id', $args['leito']);
//                $this->db->orwhere('i.paciente_id', $args['nome']);
            }
            if (isset($args['medico_responsavel']) && strlen($args['medico_responsavel']) > 0) {
                $this->db->where('i.medico_id', $args['medico_responsavel']);
//                $this->db->orwhere('i.paciente_id', $args['nome']);
            }

            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', $args['nome'] . "%", 'left');
//                $this->db->orwhere('i.paciente_id', $args['nome']);
            }
        }
        return $this->db;
    }

    function retornarinternacaopaciente($internacao_id) {

        $this->db->select('i.internacao_id,
                           p.nome as paciente,
                           m.nome as motivosaida,
                           i.motivo_saida,
                           i.hospital_transferencia,
                           m.internacao_motivosaida_id,
                           p.paciente_id,
                           i.data_internacao,
                           i.observacao_saida,
                           i.leito,
                           il.ativo as leito_ativo,
                           i.data_saida,
                           il.nome as leito_nome,
                           iu.nome as unidade,
                           ie.nome as enfermaria,
                           o.nome as medico_internacao,
                           o2.nome as medico_saida,
                           p.sexo,
                           p.nascimento');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'il.enfermaria_id = ie.internacao_enfermaria_id', 'left');
        $this->db->join('tb_internacao_unidade iu', 'ie.unidade_id = iu.internacao_unidade_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id', 'left');
        $this->db->join('tb_operador o2', 'o2.operador_id = i.medico_saida', 'left');
        $this->db->join('tb_internacao_motivosaida m', 'm.internacao_motivosaida_id = i.motivo_saida', 'left');
        $this->db->where('i.internacao_id', $internacao_id);
//        $this->db->where('p.paciente_id = i.paciente_id');
//        $this->db->where('o.operador_id = i.medico_id');
        // $this->db->where('m.internacao_motivosaida_id = i.motivo_saida ');

        $return = $this->db->get();
        return $return->result();
    }

    function listarinternacao($parametro) {
        $this->db->select('p.descricao,
                           cid.no_cid as nomecid,
                           cid.co_cid as codcid,
                           i.data_internacao,
                           o.nome as medico,
                           i.procedimentosolicitado,
                           i.estado');
        $this->db->from('tb_internacao i ');
        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado');
        $this->db->join('tb_procedimento p', 'p.procedimento = i.procedimentosolicitado');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id');
        $this->db->where('i.ativo', 't');
        if ($parametro != null) {
            $this->db->where('paciente_id', $parametro);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocaixainternacao(){

        $data_inicio_c = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))). ' 00:00:00';
        $data_fim_c = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))). ' 23:59:59';

        // print_r($data_fim_c);
        // die;
        $this->db->select("i.internacao_id,
                           i.data_internacao as data,
                           aef.data as data_faturar,
                           array_agg(f.nome) as forma_pagamento_array,
                            array_agg(aef.valor_bruto) as valor_bruto_array,
                            array_agg(aef.valor) as valor_ajustado_array,
                            array_agg(aef.ajuste) as ajuste_array,
                            array_agg(aef.desconto) as desconto_array,
                            array_agg(aef.ativo) as ativo_array,
                            array_agg(aef.financeiro) as financeiro_array,
                            array_agg(aef.parcela) as parcelas_array,
                            i.valor_total,
                            i.paciente_id,
                            p.nome as paciente,
                            i.procedimento_convenio_id,
                            pt.nome as procedimento,
                            pt.codigo,
                            o.nome as operador_cadastro,
                            op.nome as operador_faturamento,
                            aef.observacao
                           ", FALSE);
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_faturar aef', 'aef.internacao_id = i.internacao_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = aef.forma_pagamento_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.operador_cadastro', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = aef.operador_cadastro', 'left');
        $this->db->where('i.excluido', 'f');
        $this->db->where('i.particular', 't');
        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data_fim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data_inicio_c = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))). ' 00:00:00';
        $data_fim_c = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))). ' 23:59:59';
        $this->db->where("(aef.data >= '$data_inicio' OR (i.data_internacao >= '$data_inicio' AND aef.data is null))");
        $this->db->where("(aef.data <= '$data_fim' OR (i.data_internacao <= '$data_fim' AND aef.data is null))");
        $this->db->where('i.internacao_id is not null');

        if ($_POST['medico'] != "0") {
            $this->db->where('i.medico_id', $_POST['medico']);
        }
        if ($_POST['operador'] != "0") {
            $this->db->where('i.operador_cadastro', $_POST['operador']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('i.empresa_id', $_POST['empresa']);
        }
        $this->db->groupby('i.internacao_id,
                            i.data_internacao,
                            aef.data,
                            i.valor_total,
                            i.paciente_id,
                            p.nome,
                            i.procedimento_convenio_id,
                            pt.nome,
                            pt.codigo,
                            o.nome,
                            op.nome,
                            aef.observacao');
        $this->db->orderby('i.operador_cadastro, i.paciente_id, p.nome, i.internacao_id, i.data_internacao');

        $return = $this->db->get();
        return $return->result();
    }


    function relatoriocaixainternacaoevolucao($internacao_id){

        $data_inicio_c = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data_fim_c = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));

        $this->db->select("ie.internacao_evolucao_id,
                           ie.data,
                           ie.internacao_id,
                           aef.data as data_faturar,
                           array_agg(f.nome) as forma_pagamento_array,
                           p.nome as paciente,
                           p.paciente_id,
                            array_agg(aef.valor_bruto) as valor_bruto_array,
                            array_agg(aef.valor) as valor_ajustado_array,
                            array_agg(aef.ajuste) as ajuste_array,
                            array_agg(aef.desconto) as desconto_array,
                            array_agg(aef.ativo) as ativo_array,
                            array_agg(aef.financeiro) as financeiro_array,
                            array_agg(aef.parcela) as parcelas_array,
                            ie.valor as valor_total,
                            ie.procedimento_tuss_id,
                            pt.nome as procedimento,
                            pt.codigo,
                            o.nome as operador_cadastro,
                            op.nome as operador_faturamento,
                            aef.observacao
                           ", FALSE);
        $this->db->from('tb_internacao_evolucao ie');
        $this->db->join('tb_internacao_evolucao_faturar aef', 'aef.internacao_evolucao_id = ie.internacao_evolucao_id', 'left');
        $this->db->join('tb_internacao i', 'i.internacao_id = ie.internacao_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ie.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = aef.forma_pagamento_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ie.operador_cadastro', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = aef.operador_cadastro', 'left');
        $this->db->where('ie.ativo', 't');
        $this->db->where('ie.particular', 't');
        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data_fim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data_inicio_c = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))). ' 00:00:00';
        $data_fim_c = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))). ' 23:59:59';
        $this->db->where("(aef.data >= '$data_inicio' OR (ie.data >= '$data_inicio' AND aef.data is null))");
        $this->db->where("(aef.data <= '$data_fim' OR (ie.data <= '$data_fim' AND aef.data is null))");
        if($internacao_id > 0){
           $this->db->where('ie.internacao_id', $internacao_id); 
        }
        
        // if ($_POST['medico'] != "0") {
        //     $this->db->where('ie.medico_id', $_POST['medico']);
        // }
        if ($_POST['operador'] != "0") {
            $this->db->where('ie.operador_cadastro', $_POST['operador']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ie.empresa_id', $_POST['empresa']);
        }
        $this->db->groupby('ie.internacao_evolucao_id,
                            ie.data,
                            aef.data,
                            ie.valor,
                            ie.procedimento_tuss_id,
                            pt.nome,
                            pt.codigo,
                            o.nome,
                            op.nome,
                            aef.observacao,
                            p.paciente_id,
                            p.nome,
                            ie.internacao_id');
        $this->db->orderby('ie.operador_cadastro, ie.internacao_evolucao_id, ie.data, p.nome');

        $return = $this->db->get();
        return $return->result();
    }

    function fecharcaixainternacao(){
        $horario = date("Y-m-d H:i:s");
        $empresaAtual = $this->session->userdata('empresa_id');
        $operadorAtual = $this->session->userdata('operador_id');
        $empresa_id = $_POST['empresa'];
        // $operador_id = json_decode($_POST['operador']);

        if ($empresa_id > 0) {
            $empresa_obs = " Empresa: {$_POST['empresaNome']}";
        }else {
            $empresa_obs = " Todas as Empresas";
        }
        // Por Operador, ainda não funcional
        // if ($operador_id > 0) {
        //     $operador_obs = " Operador: {$_POST['operadorNome']}";
        // } else {
        //     $operador_obs = " ";
        // }

        $dataAtual = date("Y-m-d");
        $data_inicio = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data1'])));
        $data_fim = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data2'])));
        $data_inicio_obs = date("d/m/Y", strtotime(str_replace("/", "-", $data_inicio)));
        $data_fim_obs = date("d/m/Y", strtotime(str_replace("/", "-", $data_fim)));
        
        $observacao = "Caixa Período: $data_inicio_obs até $data_fim_obs $empresa_obs";

        $this->db->select("array_agg(aef.internacao_faturar_id) as internacao_faturar_id_array,
                            aef.forma_pagamento_id,
                            aef.parcela,
                            f.nome as forma_pagamento,
                            f.nome,
                            f.cartao,
                            f.fixar,
                            f.credor_devedor,
                            f.tempo_receber, 
                            f.dia_receber,
                            f.parcelas,
                            sum(aef.valor) as valor_total
                            ");
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_faturar aef', 'aef.internacao_id = i.internacao_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = aef.forma_pagamento_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.operador_cadastro', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = aef.operador_cadastro', 'left');
        $this->db->where('i.excluido', 'f');
        $this->db->where('i.particular', 't');
        $this->db->where("aef.data >= '$data_inicio'");
        $this->db->where("aef.data <= '$data_fim'");
        $this->db->where('aef.financeiro', "f");
        $this->db->where('aef.ativo', "t");
        $this->db->where("aef.forma_pagamento_id !=", '1000');
        $this->db->where("aef.forma_pagamento_id !=", '2000');
        // if (count($operador_id) > 0 && !in_array('0', $operador_id)) {
        //     $this->db->where_in('ae.operador_autorizacao', $operador_id);
        // }
        if ($empresa_id != "0") {
            $this->db->where('i.empresa_id', $empresa_id);
        }
        $this->db->groupby("
                            aef.forma_pagamento_id,
                            aef.parcela,
                            f.nome,
                            f.cartao,
                            f.fixar,
                            f.credor_devedor,
                            f.tempo_receber, 
                            f.dia_receber,
                            f.parcelas
                            ");
        $this->db->orderby('aef.forma_pagamento_id');
        $return = $this->db->get()->result();


        $this->db->select("array_agg(aef.internacao_evolucao_faturar_id) as internacao_evolucao_faturar_id_array,
                            aef.forma_pagamento_id,
                            aef.parcela,
                            f.nome as forma_pagamento,
                            f.nome,
                            f.cartao,
                            f.fixar,
                            f.credor_devedor,
                            f.tempo_receber, 
                            f.dia_receber,
                            f.parcelas,
                            sum(aef.valor) as valor_total
                            ");
        $this->db->from('tb_internacao_evolucao ie');
        $this->db->join('tb_internacao_evolucao_faturar aef', 'aef.internacao_evolucao_id = ie.internacao_evolucao_id', 'left');
        $this->db->join('tb_internacao i', 'i.internacao_id = ie.internacao_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ie.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = aef.forma_pagamento_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ie.operador_cadastro', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = aef.operador_cadastro', 'left');
        $this->db->where('ie.ativo', 't');
        $this->db->where('ie.particular', 't');
        $this->db->where("aef.data >= '$data_inicio'");
        $this->db->where("aef.data <= '$data_fim'");
        $this->db->where('aef.financeiro', "f");
        $this->db->where('aef.ativo', "t");
        $this->db->where("aef.forma_pagamento_id !=", '1000');
        $this->db->where("aef.forma_pagamento_id !=", '2000');
        // if (count($operador_id) > 0 && !in_array('0', $operador_id)) {
        //     $this->db->where_in('ae.operador_autorizacao', $operador_id);
        // }
        if ($empresa_id != "0") {
            $this->db->where('ie.empresa_id', $empresa_id);
        }
        $this->db->groupby("
                            aef.forma_pagamento_id,
                            aef.parcela,
                            f.nome,
                            f.cartao,
                            f.fixar,
                            f.credor_devedor,
                            f.tempo_receber, 
                            f.dia_receber,
                            f.parcelas
                            ");
        $this->db->orderby('aef.forma_pagamento_id');
        $pagamento_evolucao = $this->db->get()->result();


        // echo '<pre>';
        // print_r($pagamento_evolucao);
        // die;

        foreach ($return as $value) {
            $this->db->select('conta_id');
            $this->db->from('tb_formapagamento_conta_empresa');
            $this->db->where("ativo", 't');
            $this->db->where("forma_pagamento_id", $value->forma_pagamento_id);
            if ($empresa_id > 0) {
                $this->db->where("empresa_id", $empresa_id);
            } else {
                $this->db->where("empresa_id", $empresaAtual);
            }
            $conta_array = $this->db->get()->result();

            if (count($conta_array) > 0) {
                $value->conta_id = $conta_array[0]->conta_id;
            } else {
                $value->conta_id = '';
            }

            if ($value->nome == '' || $value->conta_id == '' || $value->credor_devedor == '' || $value->parcelas == '') {
                return 10;
            }

            if ($value->tempo_receber > 0 && $value->dia_receber > 0) {
                return 10;
            }
        }


        $i = 0;
        if ($empresa_id > 0) {
            $empresa_insert = $empresa_id;
        } else {
            $empresa_insert = $empresaAtual;
        }


        foreach ($return as $value) {
            $valor_total = $value->valor_total;

            $this->db->set('valor', $valor_total);
            $this->db->set('forma_pagamento_id', $value->forma_pagamento_id);
            $this->db->set('forma_pagamento_nome', $value->nome);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $this->session->userdata('operador_id'));
            $this->db->insert('tb_financeiro_caixa');
            $financeiro_caixa_id = $this->db->insert_id();

            $classe = "CAIXA INTERNACAO" . " " . $value->nome;

            if ($value->cartao == 'f') {

                // Se é dinheiro
                $this->db->set('financeiro_caixa_id', $financeiro_caixa_id);
                $this->db->set('data', $data_inicio);
                $this->db->set('valor', $valor_total);
                $this->db->set('classe', $classe);
                $this->db->set('nome', $value->credor_devedor);
                $this->db->set('tipo','CAIXA INTERNACAO');
                $this->db->set('conta', $value->conta_id);
                $this->db->set('observacao', $observacao);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('empresa_id', $empresa_insert);
                $this->db->set('operador_cadastro', $operadorAtual);
                $this->db->insert('tb_entradas');
                 $this->db->set('data_inicio',$data_inicio);
                $entradas_id = $this->db->insert_id();

                $this->db->set('data', $data_inicio);
                $this->db->set('valor', $valor_total);
                $this->db->set('data', $data_inicio);
                $this->db->set('entrada_id', $entradas_id);
                $this->db->set('conta', $value->conta_id);
                $this->db->set('nome', $value->credor_devedor);
                $this->db->set('empresa_id', $empresa_insert);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operadorAtual);
                $this->db->set('data_inicio',$data_inicio);
                $this->db->insert('tb_saldo');
            }else{
                $resto_data = 0;
                if ($value->tempo_receber > 0) {
                    $data_receber = date("Y-m-d", strtotime("+$value->tempo_receber days", strtotime($data_inicio)));
                } elseif ($value->dia_receber > 0) {
                    $diaAtual = date("d", strtotime($data_inicio));
                    $mesAtual = date("m", strtotime($data_inicio));
                    $anoAtual = date("Y", strtotime($data_inicio));
                    $data_string = "$anoAtual-$mesAtual-{$value->dia_receber}";
                    $data_receber = date("Y-m-d", strtotime($data_string));

                    if ($mesAtual == '02' && $value->dia_receber > 28) {
                        $resto_data = $value->dia_receber - 28;
                        $data_receber = "$anoAtual-$mesAtual-28";
                    }

                    if ($diaAtual > $value->dia_receber) {
                        $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
                    }
                } else {
                    $data_receber = $data_inicio;
                }

                $parcelas_pag = $value->parcela;
                $valor_bruto = $valor_total / $parcelas_pag;
                $ajuste = 0;

                if ($parcelas_pag != '') {
                    $jurosporparcelas = $this->jurosporparcelas($value->forma_pagamento_id, $parcelas_pag);
                    if (count($jurosporparcelas) > 0) {
                        if ($jurosporparcelas[0]->taxa_juros > 0) {
                            $taxa_juros = $jurosporparcelas[0]->taxa_juros;
                        } else {
                            $taxa_juros = 0;
                        }
                    } else {
                        $taxa_juros = 0;
                    }
                    $ajuste = $taxa_juros;

                    $valor_com_juros = $valor_bruto - ($valor_bruto * ($taxa_juros / 100));
                    $valor_parcela = $valor_com_juros;
                } else {
                    $valor_parcela = $valor_bruto;
                }

                for ($i = 1; $i <= $parcelas_pag; $i++) {

                    $this->db->set('financeiro_caixa_id', $financeiro_caixa_id);
                    $this->db->set('valor', $valor_parcela);
                    $this->db->set('devedor', $value->credor_devedor);
                    $this->db->set('data', $data_receber);
                    $this->db->set('parcela', $i);
                    $this->db->set('grupo_caixa', '');
                    $this->db->set('numero_parcela', $parcelas_pag);
                    $this->db->set('valor_bruto', $valor_bruto);
                    $this->db->set('classe', $classe);
                    $this->db->set('conta', $value->conta_id);
                    $this->db->set('observacao', $observacao);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operadorAtual);
                    $this->db->insert('tb_financeiro_contasreceber_temp');

                    $data_calculada = $this->calcularDataFixar($data_receber, $resto_data);
                    $data_receber = date("Y-m-d", strtotime($data_calculada['data']));
                    $resto_data = $data_calculada['restante'];
                } // FIM FOR 
            } // FIM ELSE 
                    $array_internacao_faturarPG = $value->internacao_faturar_id_array;
                    $array_internacao_faturarStr = str_replace('{', '', str_replace('}', '', $array_internacao_faturarPG));
                    $array_internacao_faturar = explode(',', $array_internacao_faturarStr);

                    $this->db->set('financeiro', 't');
                    $this->db->set('data_financeiro', $horario);
                    $this->db->set('operador_financeiro', $this->session->userdata('operador_id'));
                    $this->db->where_in('internacao_faturar_id', $array_internacao_faturar);
                    $this->db->update('tb_internacao_faturar');
        } // FIM FOREACHE 

        $receber_temp = $this->burcarcontasreceberModelo2();

        foreach ($receber_temp as $temp) {
            $receber_temp2 = $this->buscarParcelaMaxima($temp->devedor);
            $this->db->set('valor', $temp->valor);
            $this->db->set('devedor', $temp->devedor);
            $this->db->set('data', $temp->data);
            $this->db->set('parcela', $temp->parcela);
            $this->db->set('grupo_caixa', $temp->grupo_caixa);
            $this->db->set('numero_parcela', $receber_temp2[0]->max);
            // $this->db->set('ajuste', $temp->ajuste);
            $this->db->set('valor_bruto', $temp->valor_bruto);
            $this->db->set('classe', $temp->classe);
            $this->db->set('conta', $temp->conta);
            $this->db->set('observacao', $temp->observacao);
            $this->db->set('observacao', $observacao);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('empresa_id', $empresa_insert);
            $this->db->set('tipo','CAIXA INTERNACAO');
            $this->db->set('data_inicio',$data_inicio);
            $this->db->insert('tb_financeiro_contasreceber');
        }
        $this->db->set('ativo', 'f');
        $this->db->update('tb_financeiro_contasreceber_temp');



        foreach ($pagamento_evolucao as $value) {

            $this->db->select('conta_id');
            $this->db->from('tb_formapagamento_conta_empresa');
            $this->db->where("ativo", 't');
            $this->db->where("forma_pagamento_id", $value->forma_pagamento_id);
            if ($empresa_id > 0) {
                $this->db->where("empresa_id", $empresa_id);
            } else {
                $this->db->where("empresa_id", $empresaAtual);
            }
            $conta_array = $this->db->get()->result();

            if (count($conta_array) > 0) {
                $value->conta_id = $conta_array[0]->conta_id;
            } else {
                $value->conta_id = '';
            }

            if ($value->nome == '' || $value->conta_id == '' || $value->credor_devedor == '' || $value->parcelas == '') {
                return 10;
            }

            if ($value->tempo_receber > 0 && $value->dia_receber > 0) {
                return 10;
            }
        }

        $i = 0;
        if ($empresa_id > 0) {
            $empresa_insert = $empresa_id;
        } else {
            $empresa_insert = $empresaAtual;
        }

        foreach ($pagamento_evolucao as $value) {
            $valor_total = $value->valor_total;

            $this->db->set('valor', $valor_total);
            $this->db->set('forma_pagamento_id', $value->forma_pagamento_id);
            $this->db->set('forma_pagamento_nome', $value->nome);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $this->session->userdata('operador_id'));
            $this->db->insert('tb_financeiro_caixa');
            $financeiro_caixa_id = $this->db->insert_id();

            $classe = "CAIXA INTERNACAO EVOLUCOES" . " " . $value->nome;

            if ($value->cartao == 'f') {

                // Se é dinheiro
                $this->db->set('financeiro_caixa_id', $financeiro_caixa_id);
                $this->db->set('data', $data_inicio);
                $this->db->set('valor', $valor_total);
                $this->db->set('classe', $classe);
                $this->db->set('nome', $value->credor_devedor);
                $this->db->set('tipo','CAIXA INTERNACAO EVOLUCOES');
                $this->db->set('conta', $value->conta_id);
                $this->db->set('observacao', $observacao);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('empresa_id', $empresa_insert);
                $this->db->set('operador_cadastro', $operadorAtual);
                $this->db->insert('tb_entradas');
                 $this->db->set('data_inicio',$data_inicio);
                $entradas_id = $this->db->insert_id();

                $this->db->set('data', $data_inicio);
                $this->db->set('valor', $valor_total);
                $this->db->set('data', $data_inicio);
                $this->db->set('entrada_id', $entradas_id);
                $this->db->set('conta', $value->conta_id);
                $this->db->set('nome', $value->credor_devedor);
                $this->db->set('empresa_id', $empresa_insert);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operadorAtual);
                $this->db->set('data_inicio',$data_inicio);
                $this->db->insert('tb_saldo');
            }else{
                $resto_data = 0;
                if ($value->tempo_receber > 0) {
                    $data_receber = date("Y-m-d", strtotime("+$value->tempo_receber days", strtotime($data_inicio)));
                } elseif ($value->dia_receber > 0) {
                    $diaAtual = date("d", strtotime($data_inicio));
                    $mesAtual = date("m", strtotime($data_inicio));
                    $anoAtual = date("Y", strtotime($data_inicio));
                    $data_string = "$anoAtual-$mesAtual-{$value->dia_receber}";
                    $data_receber = date("Y-m-d", strtotime($data_string));

                    if ($mesAtual == '02' && $value->dia_receber > 28) {
                        $resto_data = $value->dia_receber - 28;
                        $data_receber = "$anoAtual-$mesAtual-28";
                    }

                    if ($diaAtual > $value->dia_receber) {
                        $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
                    }
                } else {
                    $data_receber = $data_inicio;
                }

                $parcelas_pag = $value->parcela;
                $valor_bruto = $valor_total / $parcelas_pag;
                $ajuste = 0;

                if ($parcelas_pag != '') {
                    $jurosporparcelas = $this->jurosporparcelas($value->forma_pagamento_id, $parcelas_pag);
                    if (count($jurosporparcelas) > 0) {
                        if ($jurosporparcelas[0]->taxa_juros > 0) {
                            $taxa_juros = $jurosporparcelas[0]->taxa_juros;
                        } else {
                            $taxa_juros = 0;
                        }
                    } else {
                        $taxa_juros = 0;
                    }
                    $ajuste = $taxa_juros;

                    $valor_com_juros = $valor_bruto - ($valor_bruto * ($taxa_juros / 100));
                    $valor_parcela = $valor_com_juros;
                } else {
                    $valor_parcela = $valor_bruto;
                }

                for ($i = 1; $i <= $parcelas_pag; $i++) {

                    $this->db->set('financeiro_caixa_id', $financeiro_caixa_id);
                    $this->db->set('valor', $valor_parcela);
                    $this->db->set('devedor', $value->credor_devedor);
                    $this->db->set('data', $data_receber);
                    $this->db->set('parcela', $i);
                    $this->db->set('grupo_caixa', '');
                    $this->db->set('numero_parcela', $parcelas_pag);
                    $this->db->set('valor_bruto', $valor_bruto);
                    $this->db->set('classe', $classe);
                    $this->db->set('conta', $value->conta_id);
                    $this->db->set('observacao', $observacao);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operadorAtual);
                    $this->db->insert('tb_financeiro_contasreceber_temp');

                    $data_calculada = $this->calcularDataFixar($data_receber, $resto_data);
                    $data_receber = date("Y-m-d", strtotime($data_calculada['data']));
                    $resto_data = $data_calculada['restante'];
                } // FIM FOR 
            } // FIM ELSE 
                    $array_internacao_evolucao_faturarPG = $value->internacao_evolucao_faturar_id_array;
                    $array_internacao_evolucao_faturarStr = str_replace('{', '', str_replace('}', '', $array_internacao_evolucao_faturarPG));
                    $array_internacao_evolucao_faturar = explode(',', $array_internacao_evolucao_faturarStr);

                    $this->db->set('financeiro', 't');
                    $this->db->set('data_financeiro', $horario);
                    $this->db->set('operador_financeiro', $this->session->userdata('operador_id'));
                    $this->db->where_in('internacao_evolucao_faturar_id', $array_internacao_evolucao_faturar);
                    $this->db->update('tb_internacao_evolucao_faturar');
        } // FIM FOREACHE 

        $receber_temp = $this->burcarcontasreceberModelo2();

        foreach ($receber_temp as $temp) {
            $receber_temp2 = $this->buscarParcelaMaxima($temp->devedor);
            $this->db->set('valor', $temp->valor);
            $this->db->set('devedor', $temp->devedor);
            $this->db->set('data', $temp->data);
            $this->db->set('parcela', $temp->parcela);
            $this->db->set('grupo_caixa', $temp->grupo_caixa);
            $this->db->set('numero_parcela', $receber_temp2[0]->max);
            // $this->db->set('ajuste', $temp->ajuste);
            $this->db->set('valor_bruto', $temp->valor_bruto);
            $this->db->set('classe', $temp->classe);
            $this->db->set('conta', $temp->conta);
            $this->db->set('observacao', $temp->observacao);
            $this->db->set('observacao', $observacao);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('empresa_id', $empresa_insert);
            $this->db->set('tipo','CAIXA INTERNACAO EVOLUCOES');
            $this->db->set('data_inicio',$data_inicio);
            $this->db->insert('tb_financeiro_contasreceber');
        }
        $this->db->set('ativo', 'f');
        $this->db->update('tb_financeiro_contasreceber_temp');

        return 1;

    }

    function burcarcontasreceberModelo2() {
        $this->db->select('valor,
                           valor_bruto,   
                           devedor,
                           grupo_caixa,
                           parcela,
                           data,
                           observacao,
                           entrada_id,
                           conta,
                           classe');
        $this->db->from('tb_financeiro_contasreceber_temp');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function buscarParcelaMaxima($devedor) {
        $this->db->select('max(parcela)');
        $this->db->from('tb_financeiro_contasreceber_temp');
        $this->db->where('devedor', $devedor);
        $this->db->where('ativo', 't');
        $this->db->groupby('devedor');
        $this->db->orderby('devedor');

        $return = $this->db->get();
        return $return->result();
    }


    function calcularDataFixar($data_rec, $resto) {
        $mes = date("m", strtotime($data_rec));
        $dia = date("d", strtotime($data_rec));
        $dias_subtrair = 0;
        $data_cal = $data_rec;

        if ($mes == '01' && $dia > 28) {
            // echo 'entrou errado';
            $dias_subtrair = $dia - 28;
            $data_cal = date("Y-m-d", strtotime("-$dias_subtrair days", strtotime($data_cal)));
            $data_cal = date("Y-m-d", strtotime("+1 month", strtotime($data_cal)));
        } else {
            $data_cal = date("Y-m-d", strtotime("+1 month", strtotime($data_cal)));
            // Echo 'entrou aqui';
        }

        if ($resto > 0) {
            $data_cal = date("Y-m-d", strtotime("+$resto days", strtotime($data_cal)));
        }

        $array = array(
            "data" => $data_cal,
            "restante" => $dias_subtrair,
        );
        return $array;
    }

    function jurosporparcelas($formapagamento_id, $parcelas) {
        $this->db->select('taxa_juros');
        $this->db->from('tb_formapagamento_pacela_juros');
        $this->db->where('forma_pagamento_id', $formapagamento_id);
        $this->db->where('parcelas_inicio <=', $parcelas);
        $this->db->where('parcelas_fim >=', $parcelas);
        $this->db->where('ativo', 't');
        $query = $this->db->get();

        return $query->result();
    }


    function listarinternacaolista($args = array()) {
        $this->db->select('pt.nome as procedimento,
                           p.nome as paciente,
                           i.data_internacao,
                           o.nome as medico,
                           il.nome as leito,
                           ie.nome as enfermaria,
                           iu.nome as unidade,
                           il.internacao_leito_id,
                           i.internacao_id,
                           i.paciente_id,
                           i.procedimentosolicitado,
                           i.estado,
                           i.faturado,
                           i.particular');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'il.enfermaria_id = ie.internacao_enfermaria_id', 'left');
        $this->db->join('tb_internacao_unidade iu', 'ie.unidade_id = iu.internacao_unidade_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
//       $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id', 'left');
        $this->db->where('i.excluido', 'f');
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('i.ativo', $args['situacao']);
        } else {
            $this->db->where('i.ativo', 't');
        }

        if (isset($args['data_inicio']) && strlen($args['data_inicio']) > 0) {
            $this->db->where("i.data_internacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $args['data_inicio']))) . ' 00:00:00');
        }
        if (isset($args['data_fim']) && strlen($args['data_fim']) > 0) {
            $this->db->where("i.data_internacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $args['data_fim']))) . ' 23:59:59');
        }



        if (isset($args['unidade']) && strlen($args['unidade']) > 0) {
            $this->db->where('iu.internacao_unidade_id', $args['unidade']);
 
        }
        if (isset($args['enfermaria']) && strlen($args['enfermaria']) > 0) {
            $this->db->where('ie.internacao_enfermaria_id', $args['enfermaria']);
 
        }

        if (isset($args['leito']) && strlen($args['leito']) > 0) {
            $this->db->where('il.internacao_leito_id', $args['leito']);
 
        }
        if (isset($args['medico_responsavel']) && strlen($args['medico_responsavel']) > 0) {
            $this->db->where('i.medico_id', $args['medico_responsavel']);
 
        }

        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', $args['nome'] . "%", 'left');
 
        }

        return $this->db;
    }

    function listarguiafaturamentomanualinternacao($args = array()) {
        $this->db->select('pt.nome as procedimento,
                           pt.codigo,
                           pt.qtde,
                           p.nome as paciente,
                           c.nome as convenio,
                           i.valor_total,
                           i.faturado,
                           i.data_internacao,
                           o.nome as medico,
                           il.nome as leito,
                           ie.nome as enfermaria,
                           iu.nome as unidade,
                           il.internacao_leito_id,
                           i.internacao_id,
                           i.paciente_id,
                           i.procedimentosolicitado,
                           i.estado');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'il.enfermaria_id = ie.internacao_enfermaria_id', 'left');
        $this->db->join('tb_internacao_unidade iu', 'ie.unidade_id = iu.internacao_unidade_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
//        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id', 'left');

        $this->db->where("i.data_internacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("i.data_internacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->where('i.excluido', 'false');
//        $this->db->where('c.dinheiro', 'false');

        if (isset($_POST['nome']) && strlen($_POST['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $_POST['nome'] . "%");
        }
        if (isset($_POST['convenio']) && $_POST['convenio'] != "") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        return $this->db->get()->result();
    }

    function listarguiafaturamentomanualinternacaoconvenio($args = array()) {
        $this->db->select('pt.nome as procedimento,
                           pt.codigo,
                           pt.qtde,
                           p.nome as paciente,
                           c.nome as convenio,
                           i.valor_total,
                           i.faturado,
                           i.data_internacao,
                           o.nome as medico,
                           
                           (Select sum(ip.valor_total) as valor_total_sum
                           from ponto.tb_internacao_procedimentos ip
                           where ip.internacao_id = i.internacao_id
                           and ip.ativo = true) as valor_total_sum, 
                           
                           (Select count(ip.valor_total) as contador_sum
                           from ponto.tb_internacao_procedimentos ip
                           where ip.internacao_id = i.internacao_id
                           and ip.ativo = true) as contador_sum, 
                           
                           (Select count(ip.valor_total)
                           from ponto.tb_internacao_procedimentos ip
                           where ip.internacao_id = i.internacao_id
                           and ip.ativo = true and faturado = true) as contador_faturado_sum, 
                           
                           (Select sum(ip.valor_total)
                           from ponto.tb_internacao_procedimentos ip
                           where ip.internacao_id = i.internacao_id
                           and ip.ativo = true and faturado = false) as valor_naofaturado_sum, 
                           
                           (Select sum(ip.valor_total)
                           from ponto.tb_internacao_procedimentos ip
                           where ip.internacao_id = i.internacao_id
                           and ip.ativo = true and faturado = true) as valor_faturado_sum, 
                           
                           (Select count(ip.valor_total)
                           from ponto.tb_internacao_procedimentos ip
                           where ip.internacao_id = i.internacao_id
                           and ip.ativo = true and financeiro = true) as contador_financeiro, 
                           il.nome as leito,
                           ie.nome as enfermaria,
                           iu.nome as unidade,
                           il.internacao_leito_id,
                           i.internacao_id,
                           i.paciente_id,
                           i.procedimentosolicitado,
                           i.estado');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'il.enfermaria_id = ie.internacao_enfermaria_id', 'left');
        $this->db->join('tb_internacao_unidade iu', 'ie.unidade_id = iu.internacao_unidade_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
//        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id', 'left');

        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));

        $this->db->where("(i.data_internacao >= '$data_inicio' OR cast(i.data_internacao AS date) + 
cast((Select sum(quantidade) from ponto.tb_internacao_procedimentos
 where internacao_id = i.internacao_id and ativo = true) as integer) >= '$data_inicio')");

        $this->db->where("i.data_internacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->where('i.excluido', 'false');
        $this->db->where('c.dinheiro', 'false');

        if (isset($_POST['nome']) && strlen($_POST['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $_POST['nome'] . "%");
        }
        if (isset($_POST['convenio']) && $_POST['convenio'] != "") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $this->db->orderby('i.data_internacao');
        return $this->db->get()->result();
    }

    function internacaoimpressaomodelo($internacao_id) {
        $this->db->select('pt.nome as procedimento,
                           p.nome as paciente,
                           p.convenionumero,
                           p.sexo,
                           p.nascimento,
                           p.rg,
                           p.cpf,
                           c.nome as convenio,
                           p.nome as paciente,
                           cid.no_cid as nomecid,
                           cid.co_cid as codcid,
                           cid2.no_cid as nomecid2,
                           cid2.co_cid as codcid2,
                           i.data_internacao,
                           o.nome as medico,
                           o.conselho,
                           m.nome as municipio,
                           m.codigo_ibge,
                           il.nome as leito_nome,
                           ie.nome as enfermaria,
                           iu.nome as unidade,
                           i.*
                           ');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'il.enfermaria_id = ie.internacao_enfermaria_id', 'left');
        $this->db->join('tb_internacao_unidade iu', 'ie.unidade_id = iu.internacao_unidade_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->join('tb_cid cid2', 'cid2.co_cid = i.cid2solicitado', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id', 'left');
        $this->db->where('i.internacao_id', $internacao_id);


        $return = $this->db->get();
        return $return->result();
    }

    function listarmodeloimpressaointernacao($empresa_impressao_cabecalho_id) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.empresa_impressao_internacao_id, ei.nome as nome_internacao,ei.texto,ei.adicional_cabecalho, ei.cabecalho,ei.rodape, e.nome as empresa');
        $this->db->from('tb_empresa_impressao_internacao ei');
        $this->db->join('tb_empresa e', 'e.empresa_id = ei.empresa_id', 'left');
        $this->db->where('ei.empresa_impressao_internacao_id', $empresa_impressao_cabecalho_id);
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        $return = $this->db->get();
        return $return->result();
    }

    function listarmodeloimpressaointernacaotemp($impressao_temp_id) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.*');
        $this->db->from('tb_empresa_impressao_internacao_temp ei');
        $this->db->where('ei.empresa_impressao_internacao_temp_id', $impressao_temp_id);
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        $return = $this->db->get()->result();

        return $return[0]->texto;
    }

    function listarleitosinternacao($parametro) {
        $this->db->select('io.leito_id,
                           io.data_cadastro,
                           io.operador_cadastro,
                           io.internacao_ocupacao_id,
                           il.nome as leito,
                           ie.nome as enfermaria,
                           iu.nome as unidade,
                           o.nome as operador');
        $this->db->from('tb_internacao_ocupacao io');
        $this->db->join('tb_internacao_leito il', 'il.internacao_leito_id = io.leito_id');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->join('tb_operador o', 'o.operador_id = io.operador_cadastro');
        $this->db->where('paciente_id', $parametro);
        $this->db->orderby('io.data_cadastro');
        $return = $this->db->get();
        return $return->result();
    }

    function listaleito($args = array()) {
        $this->db->select(' il.internacao_leito_id,
                            il.nome,
                            ienome as enfermaria,
                            iu.nome as unidade,
                            il.tipo');
        $this->db->from('tb_internacao_leito il');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id', 'left');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ', 'left');
        $this->db->where('ie.ativo', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('il.nome ilike', "%" . $args['nome'] . "%");
                $this->db->orwhere('ie.nome ilike', "%" . $args['nome'] . "%");
                $this->db->orwhere('iu.nome ilike', "%" . $args['nome'] . "%");
            }
        }
        return $this->db;
    }

    function listaprocedimentoautocomplete($parametro = null) {
        $this->db->select(' procedimento,
                            descricao,
                            procedimento_id');
        $this->db->from('tb_procedimento');
        if ($parametro != null) {
            $this->db->where('descricao ilike', "%" . $parametro . "%");
            $this->db->orwhere('procedimento ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletemedicamentoprescricao($parametro = null) {
        $this->db->select('farmacia_produto_id,
                           descricao');
        $this->db->from('tb_farmacia_produto');
        if ($parametro != null) {
            $this->db->where('descricao ilike', "%" . $parametro . "%");
        }
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listacidautocomplete($parametro = null) {
        $this->db->select(' co_cid,
                            no_cid');
        $this->db->from('tb_cid');
        if ($parametro != null) {
            $this->db->where('no_cid ilike', "%" . $parametro . "%");
            $this->db->orwhere('co_cid ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listamedicamentointernacao($internacao_id) {
        $this->db->select(' ip.dias,
                            ip.aprasamento,
                            ip.confirmado,
                            ip.qtde_ministrada,
                            pc.convenio_id,
                            fp.procedimento_tuss_id as procedimento_farmacia,
                            ip.internacao_prescricao_id,
                            fp.descricao,
                            ip.observacao,
                             ip.qtde_volta, 
                             o.nome as operador,
                             ip.data_cadastro,
                             il.nome as leito,
                             ie.nome as enf
                             ');
        $this->db->from('tb_internacao_prescricao ip');
        $this->db->join('tb_internacao i', 'i.internacao_id = ip.internacao_id');
        $this->db->join('tb_operador o', 'o.operador_id = ip.operador_cadastro');
        $this->db->join('tb_internacao_leito il', 'ip.leito_solicitado = il.internacao_leito_id');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_farmacia_produto fp', 'fp.farmacia_produto_id = ip.medicamento_id');
        $this->db->where('ip.ativo', 'true');
        $this->db->where('ip.internacao_id', $internacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarconvenio($internacao_id){
        $this->db->select('pc.convenio_id');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->where('i.internacao_id', $internacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentotaxa($convenio){
        $grupos = array('TAXA', 'MATERIAL');
        $this->db->select('pc.procedimento_convenio_id, pt.nome, pt.codigo,
        pc.valortotal, pt.grupo');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
        $this->db->where('pc.convenio_id', $convenio);
        $this->db->where('pc.ativo', 't');
        $this->db->where('pc.agrupador', 'f');
        $this->db->where_in('pt.grupo', $grupos);
        $this->db->orderby('pt.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function gravaroutrasdespesas($internacao_id){
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('internacao_id' , $internacao_id);
        $this->db->set('procedimento_convenio_id' , $_POST['procedimentoID']);
        $this->db->set('valor_u' , $_POST['valorunitario']);
        $this->db->set('quantidade' , $_POST['qtde']);
        $this->db->set('valor_total' , ($_POST['valorunitario'] * $_POST['qtde']));
        $this->db->set('grupo' , $_POST['grupo']);
        $this->db->set('unidade_medida' , $_POST['unidade_medida']);
        $this->db->set('operador_cadastro' , $operador_id);
        $this->db->set('data_cadastro' , $horario);
        $this->db->insert('tb_internacao_outras_despesas');
    }

    function listaroutrasdespesas($internacao_id){
        $this->db->select('od.internacao_outras_despesas_id,
                           od.valor_u,
                           od.quantidade,
                           od.valor_total,
                           od.unidade_medida,
                           pt.nome as taxa');
        $this->db->from('tb_internacao_outras_despesas od');
        $this->db->join('tb_procedimento_convenio pc','pc.procedimento_convenio_id = od.procedimento_convenio_id','left');
        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
        $this->db->where('od.ativo', 't');
        $this->db->where('od.internacao_id', $internacao_id);

        return $this->db->get()->result();

    }

    function cancelaroutradespesa($outradespesa_id){
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo' , 'f');
        $this->db->set('operador_atualizacao' , $operador_id);
        $this->db->set('data_atualizacao' , $horario);
        $this->db->where('internacao_outras_despesas_id',$outradespesa_id);
        $this->db->update('tb_internacao_outras_despesas');
    }



    function listaconveniomedicamento($convenio_id, $procedimento_tuss_id) {
        $this->db->select('pc.convenio_id');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->where('pc.ativo', 'true');
        $this->db->where('pc.procedimento_tuss_id', $procedimento_tuss_id);
        $this->db->where('pc.convenio_id', $convenio_id);
        $return = $this->db->get();
        return $return->result();
    }

    function carregarprescricaopaciente($internacao_prescricao_id) {
        $this->db->select(' ip.dias,
                            ip.aprasamento,
                            fs.farmacia_saida_id,
                            fs.quantidade,
                            fs.quantidade_internacao,
                            ip.internacao_prescricao_id,
                            fp.descricao,
                            ip.observacao,
                            o.nome as operador,
                             ip.data_cadastro,
                             il.nome as leito,
                             ie.nome as enf');
        $this->db->from('tb_internacao_prescricao ip');

        $this->db->join('tb_operador o', 'o.operador_id = ip.operador_cadastro');
        $this->db->join('tb_internacao_leito il', 'ip.leito_solicitado = il.internacao_leito_id');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id');

        $this->db->join('tb_farmacia_produto fp', 'fp.farmacia_produto_id = ip.medicamento_id');
        $this->db->join('tb_farmacia_saida fs', 'fs.internacao_prescricao_id = ip.internacao_prescricao_id');
        $this->db->where('ip.ativo', 'true');
        $this->db->where('fs.ativo', 'true');
        $this->db->where('fs.internacao_prescricao_id', $internacao_prescricao_id);
        $this->db->orderby('ip.internacao_prescricao_id');
        $return = $this->db->get();
        return $return->result();
    }

    function verificainternacao($paciente_id) {
        $this->db->select();
        $this->db->from('tb_internacao');
        $this->db->where("excluido", 'false');
        $this->db->where("paciente_id", $paciente_id);
        $this->db->where('ativo','t');
        $return = $this->db->count_all_results();
        return $return;
    }

    function internacaoalta($internacao_id) {
        $this->db->set('ativo', 'false');
        $this->db->where('internacao_id', $internacao_id);
        $this->db->update('tb_internacao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }
    }

    function listaralertainternacao() {

        $this->db->select('');
        $this->db->from('tb_internacao_alerta');
//        $this->db->join('tb_empresa e', 'im.empresa_id = e.empresa_id', 'left');
        $this->db->where('ativo', 't');


        return $this->db;
    }

    function carregaralertainternacao($internacao_alerta_id = NULL) {

        $this->db->select('');
        $this->db->from('tb_internacao_alerta');
//        $this->db->join('tb_empresa e', 'im.empresa_id = e.empresa_id', 'left');
        $this->db->where('ativo', 't');

        if ($internacao_alerta_id != "") {
            $this->db->where('internacao_alerta_id', $internacao_alerta_id);
        }





        return $this->db->get()->result();
    }

    function gravaralertainternacao() {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('cor', $_POST['cor']);
        $this->db->set('nome', $_POST['nome']);
        $this->db->set('observacao', $_POST['observacao']);

        if ($_POST['internacao_alerta_id'] == "") {


            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_alerta');
        } else {
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_alerta_id', $_POST['internacao_alerta_id']);
            $this->db->update('tb_internacao_alerta');
        }
    }

    function excluiralertainternacao($internacao_alerta_id = NULL) {
        $this->db->set('ativo', 'f');
        $this->db->where('internacao_alerta_id', $internacao_alerta_id);
        $this->db->update('tb_internacao_alerta');
    }

    function gravaraprazamento($internacao_prescricao_id, $internacao_id = NULL) {
        
        if($internacao_id != NULL){
            $this->db->select('leito');
            $this->db->from('tb_internacao');
            $this->db->where('internacao_id', $internacao_id);
            $return = $this->db->get()->result();
        }

        $horario = date('Y-m-d H:i:s');
        $operador = $this->session->userdata('operador_id');


        $this->db->set('quantidade', $_POST['quantidade_ministrada']);
        $this->db->set('horario', $_POST['horario']);

        $this->db->set('internacao_prescricao_id', $internacao_prescricao_id);

        $this->db->set('leito_ministrado', $return[0]->leito);
        $this->db->set('operador_ministrado', $operador);
        $this->db->set('data', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data']))));

        if ($_POST['medicamentos_ministrados_id'] != "") {
            $this->db->set('operador_atualizacao', $operador);
            $this->db->set('data_atualizacao', $horario);
            $this->db->where('medicamentos_ministrados_id', $_POST['medicamentos_ministrados_id']);
            $this->db->update('tb_medicamentos_ministrados');
        } else {
            $this->db->set('data_ministrada', $horario);
            $this->db->set('operador_cadastro', $operador);
            $this->db->set('data_cadastro', $horario);
            $this->db->insert('tb_medicamentos_ministrados');
        }
    }

    function listarministradas($internacao_prescricao_id) {
        $this->db->select('mm.*, o.nome as operador, il.nome as leito, ie.nome as enf');
        $this->db->from('tb_medicamentos_ministrados mm');

        $this->db->join('tb_operador o', 'o.operador_id = mm.operador_ministrado');
        $this->db->join('tb_internacao_leito il', 'mm.leito_ministrado = il.internacao_leito_id');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id');

        $this->db->where('mm.internacao_prescricao_id', $internacao_prescricao_id);
        $this->db->where('mm.ativo', 't');

        return $this->db->get()->result();
    }

    function somarquantiadadeministrada($internacao_prescricao_id) {
        $this->db->select('sum(quantidade) as medicamentosministrados');
        $this->db->from('tb_medicamentos_ministrados');
        $this->db->where('internacao_prescricao_id', $internacao_prescricao_id);
        $this->db->where('ativo', 't');

        return $this->db->get()->result();
    }

    function listardadosmedicamentoministrado($medicamentos_ministrados_id) {
        $this->db->select('');
        $this->db->from('tb_medicamentos_ministrados');
        $this->db->where('medicamentos_ministrados_id', $medicamentos_ministrados_id);
        return $this->db->get()->result();
    }

    function excluirmedicamentoministrado($medicamentos_ministrados_id, $internacao_prescricao_id) {
        $horario = date('Y-m-d H:i:s');
        $operador = $this->session->userdata('operador_id');


        $this->db->select('');
        $this->db->from('tb_medicamentos_ministrados');
        $this->db->where('medicamentos_ministrados_id', $medicamentos_ministrados_id);

        $res = $this->db->get()->result();

        $quantidade_excluida = $res[0]->quantidade;

        $this->db->select(' ip.dias,
                            ip.aprasamento,
                            fs.farmacia_saida_id,
                            fs.quantidade,
                            fs.quantidade_internacao,
                            ip.internacao_prescricao_id,
                            fp.descricao');
        $this->db->from('tb_internacao_prescricao ip');
        $this->db->join('tb_farmacia_produto fp', 'fp.farmacia_produto_id = ip.medicamento_id');
        $this->db->join('tb_farmacia_saida fs', 'fs.internacao_prescricao_id = ip.internacao_prescricao_id');
        $this->db->where('ip.ativo', 'true');
        $this->db->where('fs.ativo', 'true');
        $this->db->where('fs.internacao_prescricao_id', $internacao_prescricao_id);
        $this->db->orderby('ip.internacao_prescricao_id');
        $return = $this->db->get()->result();

        $quantidade_total = $return[0]->quantidade_internacao + $quantidade_excluida;
        $quantidade_nova = $return[0]->quantidade - $quantidade_excluida;

        $this->db->set('quantidade', $quantidade_nova);
        $this->db->set('quantidade_internacao', $quantidade_total);
        $this->db->where('internacao_prescricao_id', $internacao_prescricao_id);
        $this->db->update('tb_farmacia_saida');



        $this->db->select('');
        $this->db->from('tb_farmacia_saldo');
        $this->db->where('farmacia_saida_id', $return[0]->farmacia_saida_id);
        $resultsaldo = $this->db->get()->result();


        // if ($resultsaldo[0]->quantidade > 0) {
        //     $totalsaldo = $resultsaldo[0]->quantidade + $quantidade_excluida;
        // } else {
        //     $totalsaldo = $quantidade_excluida;
        // }
        $quantidade_nova = $resultsaldo[0]->quantidade_internacao + $quantidade_excluida;
        $totalsaldo = $resultsaldo[0]->quantidade + $quantidade_excluida;

        $this->db->set('quantidade', $totalsaldo);
        $this->db->set('quantidade_internacao', $quantidade_nova);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador);
        $this->db->where('farmacia_saida_id', $return[0]->farmacia_saida_id);
        $this->db->update('tb_farmacia_saldo');


        $this->db->set('ativo', 'f');
        $this->db->set('operador_atualizacao', $operador);
        $this->db->set('data_atualizacao', $horario);
        $this->db->where('medicamentos_ministrados_id', $medicamentos_ministrados_id);
        $this->db->update('tb_medicamentos_ministrados');
    }

    function gravarobservacaomedicamento($internacao_prescricao_id) {
        try {
            $horario = date('Y-m-d H:i:s');
            $operador = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador);
            $this->db->set('observacao', $_POST['observacao']);
            $this->db->where('internacao_prescricao_id', $internacao_prescricao_id);
            $this->db->update('tb_internacao_prescricao');
        } catch (Exception $ex) {
            
        }
    }

    
    function gravaranotacoesfarmacia($internacao_id) {
        
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id'); 
        $this->db->set('internacao_id', $internacao_id);
        if ($_POST['anotacoes'] != "") {
            $this->db->set('anotacoes', $_POST['anotacoes']);
        }  
        
        if ($_POST['internacao_anotacoes_id'] == "") {
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->insert('tb_internacao_anotacoes');
        }else{
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('data_atualizacao', $horario);
            $this->db->where('internacao_anotacoes_id',$_POST['internacao_anotacoes_id']);
            $this->db->update('tb_internacao_anotacoes');
        }
    
    }
    
    function listaranotacoes($internacao_id){
        $this->db->select('');
        $this->db->from('tb_internacao_anotacoes');
        $this->db->where('ativo','t');
        $this->db->where('internacao_id',$internacao_id);
        return $this->db->get()->result();         
    }
    
     function listaranotacao($internacao_anotacoes_id){
        $this->db->select('');
        $this->db->from('tb_internacao_anotacoes');
        $this->db->where('internacao_anotacoes_id',$internacao_anotacoes_id);
        return $this->db->get()->result();         
    }
    
   function excluiranotacaointernacao($internacao_anotacoes_id){
         
       $horario = date("Y-m-d H:i:s");
       $operador_id = $this->session->userdata('operador_id');
       $this->db->set('operador_atualizacao', $operador_id);
       $this->db->set('data_atualizacao', $horario);
       $this->db->set('ativo','f');
       $this->db->where('internacao_anotacoes_id',$internacao_anotacoes_id);
       $this->db->update('tb_internacao_anotacoes');
       
       
   }
    
     
   function dadosinternacao($paciente_id) {
        $this->db->select();
        $this->db->from('tb_internacao');
        $this->db->where("excluido", 'false');
        $this->db->where("paciente_id", $paciente_id); 
        return $this->db->get()->result();
        
    }
 
    
    
    function relatoriocancelamentointernacao(){
        
         $this->db->select('pt.nome as procedimento,
                           p.nome as paciente,
                           i.data_exclusao,
                           i.data_internacao,
                           o.nome as medico,
                           il.nome as leito,
                           ie.nome as enfermaria,
                           iu.nome as unidade,
                           il.internacao_leito_id,
                           i.internacao_id,
                           i.paciente_id,
                           i.procedimentosolicitado,
                           i.estado,
                           il.data_atualizacao,
                           o2.nome as operador_exclusao');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'il.enfermaria_id = ie.internacao_enfermaria_id', 'left');
        $this->db->join('tb_internacao_unidade iu', 'ie.unidade_id = iu.internacao_unidade_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
//        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c','c.convenio_id = pc.convenio_id','left');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id', 'left');
        $this->db->join('tb_operador o2', 'o2.operador_id = i.operador_exclusao', 'left');
        $this->db->where('i.excluido', 't'); 
        $this->db->where('i.data_exclusao >=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00');
        $this->db->where('i.data_exclusao <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
       
        if ($_POST['empresa'] != "TODAS") {
            $this->db->where('i.empresa_id',$_POST['empresa']);
        }
          if ($_POST['operador'] != "TODAS") {
            $this->db->where('o2.operador_id',$_POST['operador']);
        }
          if ($_POST['convenio'] != "TODAS") {
            $this->db->where('c.convenio_id',$_POST['convenio']);
        }
        
        return $this->db->get()->result();
        
          
    }

    function relatorioconsumoprescricao($operador){
        
        $this->db->select('mm.quantidade,
                           mm.horario,
                           mm.data,
                           mm.data_ministrada,

                           ip.aprasamento,
                           ip.dias,
                           ip.qtde_ministrada,

                           il2.nome as leito_solicitado,
                           enf2.nome as enf_solicitado,

                           o.nome as operador,
                           
                           il.nome as leito,
                           enf.nome as enf,
                           
                           p.nome as paciente,
                           
                           fp.descricao as medicamento');
       $this->db->from('tb_medicamentos_ministrados mm');
       $this->db->join('tb_internacao_prescricao ip', 'ip.internacao_prescricao_id = mm.internacao_prescricao_id', 'left');
       $this->db->join('tb_internacao_leito il', 'mm.leito_ministrado = il.internacao_leito_id', 'left');
       $this->db->join('tb_internacao_enfermaria enf', 'il.enfermaria_id = enf.internacao_enfermaria_id', 'left');
       $this->db->join('tb_internacao_leito il2', 'ip.leito_solicitado = il2.internacao_leito_id', 'left');
       $this->db->join('tb_internacao_enfermaria enf2', 'il2.enfermaria_id = enf2.internacao_enfermaria_id', 'left');
       $this->db->join('tb_internacao i', 'i.internacao_id = ip.internacao_id', 'left');
       $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
       $this->db->join('tb_operador o', 'o.operador_id = mm.operador_cadastro', 'left');
       $this->db->join('tb_farmacia_produto fp', 'fp.farmacia_produto_id = ip.medicamento_id', 'left');

       $this->db->where('mm.ativo', 't');
       $this->db->where('mm.data_ministrada >=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00');
       $this->db->where('mm.data_ministrada <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
      
        if ($_POST['empresa'] != "TODAS") {
            $this->db->where('i.empresa_id',$_POST['empresa']);
        }

        // if (count(@$_POST['operador']) > 0 && !in_array('0', @$_POST['operador'])) {
        //     $this->db->where_in('mm.operador_cadastro', @$_POST['operador']);
        // }
        $this->db->where('mm.operador_cadastro', $operador);

        $this->db->orderby('mm.data_ministrada, p.nome');
       
       return $this->db->get()->result();
       
         
   }


   function relatorioconsumoprescricaooperador(){
        
    $this->db->select('mm.operador_cadastro as operador');
   $this->db->from('tb_medicamentos_ministrados mm');
   $this->db->join('tb_internacao_prescricao ip', 'ip.internacao_prescricao_id = mm.internacao_prescricao_id', 'left');
   $this->db->join('tb_internacao_leito il', 'mm.leito_ministrado = il.internacao_leito_id', 'left');
   $this->db->join('tb_internacao_enfermaria enf', 'il.enfermaria_id = enf.internacao_enfermaria_id', 'left');
   $this->db->join('tb_internacao_leito il2', 'ip.leito_solicitado = il2.internacao_leito_id', 'left');
   $this->db->join('tb_internacao_enfermaria enf2', 'il2.enfermaria_id = enf2.internacao_enfermaria_id', 'left');
   $this->db->join('tb_internacao i', 'i.internacao_id = ip.internacao_id', 'left');
   $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
   $this->db->join('tb_operador o', 'o.operador_id = mm.operador_cadastro', 'left');
   $this->db->join('tb_farmacia_produto fp', 'fp.farmacia_produto_id = ip.medicamento_id', 'left');

   $this->db->where('mm.ativo', 't');
   $this->db->where('mm.data_ministrada >=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00');
   $this->db->where('mm.data_ministrada <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
  
    if ($_POST['empresa'] != "TODAS") {
        $this->db->where('i.empresa_id',$_POST['empresa']);
    }

    if (count(@$_POST['operador']) > 0 && !in_array('0', @$_POST['operador'])) {
        $this->db->where_in('mm.operador_cadastro', @$_POST['operador']);
    }

    $this->db->groupby('mm.operador_cadastro');
   
   return $this->db->get()->result();
   
     
}
    
    
}

?>
