<?php

class modelorelatorio_model extends Model {

    var $_ambulatorio_modelo_relatorio_id = null;
    var $_nome = null;
    var $_medico_id = null;
    var $_texto = null;

    function Modelorelatorio_model($ambulatorio_modelo_relatorio_id = null) {
        parent::Model();
        if (isset($ambulatorio_modelo_relatorio_id)) {
            $this->instanciar($ambulatorio_modelo_relatorio_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('ambulatorio_modelo_relatorio_id,
                            aml.nome,
                            aml.nao_editavel,
                            oo.perfil_id');
        $this->db->from('tb_ambulatorio_modelo_relatorio aml');
        $this->db->join('tb_operador oo', 'oo.operador_id = aml.operador_cadastro', 'left');
        $this->db->where('aml.ativo', 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('aml.nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function excluir($ambulatorio_modelo_relatorio_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('ambulatorio_modelo_relatorio_id', $ambulatorio_modelo_relatorio_id);
        $this->db->update('tb_ambulatorio_modelo_relatorio');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }



    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $ambulatorio_modelo_relatorio_id = $_POST['ambulatorio_modelo_relatorio_id'];
            $this->db->set('nome', $_POST['txtNome']);
            // $this->db->set('medico_id', $_POST['medico']);
            $this->db->set('texto', $_POST['relatorio']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if(isset($_POST['administrador'])){
                $this->db->set('nao_editavel', 't');
            }

            if ($_POST['ambulatorio_modelo_relatorio_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_ambulatorio_modelo_relatorio');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $ambulatorio_modelo_relatorio_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('ambulatorio_modelo_relatorio_id', $ambulatorio_modelo_relatorio_id);
                $this->db->update('tb_ambulatorio_modelo_relatorio');
            }
            return $ambulatorio_modelo_relatorio_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($ambulatorio_modelo_relatorio_id) {
        if ($ambulatorio_modelo_relatorio_id != 0) {
            $this->db->select('ambulatorio_modelo_relatorio_id,
                            nome,
                            texto,
                            nao_editavel');
            $this->db->from('tb_ambulatorio_modelo_relatorio');
            $this->db->where("ambulatorio_modelo_relatorio_id", $ambulatorio_modelo_relatorio_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_ambulatorio_modelo_relatorio_id = $ambulatorio_modelo_relatorio_id;
            $this->_nome = $return[0]->nome;
            $this->_texto = $return[0]->texto;
            $this->_nao_editavel = $return[0]->nao_editavel;
        } else {
            $this->_ambulatorio_modelo_relatorio_id = null;
        }
    }

}

?>
