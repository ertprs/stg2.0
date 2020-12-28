<?php

class modeloterapeuticas_model extends Model {

    var $_ambulatorio_modelo_terapeuticas_id = null;
    var $_nome = null;
    var $_medico_id = null;
    var $_texto = null;

    function Modeloterapeuticas_model($ambulatorio_modelo_terapeuticas_id = null) {
        parent::Model();
        if (isset($ambulatorio_modelo_terapeuticas_id)) {
            $this->instanciar($ambulatorio_modelo_terapeuticas_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('ambulatorio_modelo_terapeuticas_id,
                            aml.nome,
                            aml.nao_editavel,
                            oo.perfil_id');
        $this->db->from('tb_ambulatorio_modelo_terapeuticas_id aml');
        $this->db->join('tb_operador oo', 'oo.operador_id = aml.operador_cadastro', 'left');
        $this->db->where('aml.ativo', 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('aml.nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function excluir($ambulatorio_modelo_terapeuticas_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('ambulatorio_modelo_terapeuticas_id', $ambulatorio_modelo_terapeuticas_id);
        $this->db->update('tb_ambulatorio_modelo_terapeuticas_id');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }


    function modeloterapeutica($terapeutica_id){
        $this->db->select('ambulatorio_modelo_terapeuticas_id,
                            nome');
        $this->db->from('tb_ambulatorio_modelo_terapeuticas_id');  
        $this->db->where('ambulatorio_modelo_terapeuticas_id', $terapeutica_id);
        return $this->db->get()->result();              
    }

    function carregarprocedimentosmodelo($terapeutica_id){
        $this->db->select('aml.procedimento_tuss_id,
                           pt.nome as procedimento,
                           aml.terapeuticas_procedimentos_id,
                           aml.terapeuticas_id');
        $this->db->from('tb_ambulatorio_modelo_terapeuticas_procedimentos aml');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = aml.procedimento_tuss_id', 'left');
        $this->db->where('aml.terapeuticas_id', $terapeutica_id);
        $this->db->where('aml.ativo', 't');
        $this->db->orderby('pt.nome');
        return $this->db->get()->result();     
    }

    function excluirprocedimentomodelo($terapeuticas_procedimentos_id){
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('data_atualizacao', $horario);
        $this->db->where('terapeuticas_procedimentos_id', $terapeuticas_procedimentos_id);
        $this->db->update('tb_ambulatorio_modelo_terapeuticas_procedimentos');
        return 1;
    }

    function gravarprocedimentomodelo(){
        $this->db->select('terapeuticas_procedimentos_id');
        $this->db->from('tb_ambulatorio_modelo_terapeuticas_procedimentos');
        $this->db->where('terapeuticas_id', $_POST['terapeutica_id']);
        $this->db->where('procedimento_tuss_id', $_POST['procedimento_tuss_id']);
        $this->db->where('ativo', 't');
        $return = $this->db->get()->result();

        if(count($return) > 0){
            return -1;
        }else{
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('terapeuticas_id', $_POST['terapeutica_id']);
        $this->db->set('procedimento_tuss_id', $_POST['procedimento_tuss_id']);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->insert('tb_ambulatorio_modelo_terapeuticas_procedimentos');
            return 1;
        }
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $ambulatorio_modelo_terapeuticas_id = $_POST['ambulatorio_modelo_terapeuticas_id'];
            $this->db->set('nome', $_POST['txtNome']);
            // $this->db->set('medico_id', $_POST['medico']);
            $this->db->set('texto', $_POST['terapeuticas']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if(isset($_POST['administrador'])){
                $this->db->set('nao_editavel', 't');
            }
            
            if ($_POST['ambulatorio_modelo_terapeuticas_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_ambulatorio_modelo_terapeuticas_id');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $ambulatorio_modelo_terapeuticas_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('ambulatorio_modelo_terapeuticas_id', $ambulatorio_modelo_terapeuticas_id);
                $this->db->update('tb_ambulatorio_modelo_terapeuticas_id');
            }
            return $ambulatorio_modelo_terapeuticas_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($ambulatorio_modelo_terapeuticas_id) {
        if ($ambulatorio_modelo_terapeuticas_id != 0) {
            $this->db->select('ambulatorio_modelo_terapeuticas_id,
                            nome,
                            texto,
                            nao_editavel');
            $this->db->from('tb_ambulatorio_modelo_terapeuticas_id');
            $this->db->where("ambulatorio_modelo_terapeuticas_id", $ambulatorio_modelo_terapeuticas_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_ambulatorio_modelo_terapeuticas_id = $ambulatorio_modelo_terapeuticas_id;
            $this->_nome = $return[0]->nome;
            $this->_texto = $return[0]->texto;
            $this->_nao_editavel = $return[0]->nao_editavel;
        } else {
            $this->_ambulatorio_modelo_terapeuticas_id = null;
        }
    }

}

?>
