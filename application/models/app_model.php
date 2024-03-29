<?php

class app_model extends Model {

    function App_model($ambulatorio_pacientetemp_id = null) {
        parent::Model();
//        $this->load->library('utilitario');
    }

    function buscarAtendimentosMarcados() {
        $this->db->select('operador_id');
        $this->db->from('tb_operador');
        $this->db->where('usuario', $_GET['usuario']);
        $this->db->where('senha', md5($_GET['pw']));
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarLembretes() {
        
        $operador_id = $_GET['operador_id'];

        $this->db->select(" el.empresa_lembretes_id,
                            el.texto,
                            el.data_cadastro,
                            o.nome as operador,
                            op.nome as remetente,
                            (
                                SELECT COUNT(*) 
                                FROM ponto.tb_empresa_lembretes_visualizacao 
                                WHERE ponto.tb_empresa_lembretes_visualizacao.empresa_lembretes_id = el.empresa_lembretes_id 
                            ) as visualizado");
        $this->db->from('tb_empresa_lembretes el');
        $this->db->join('tb_operador o', "o.operador_id = el.operador_destino");
        $this->db->join('tb_operador op', "op.operador_id = el.operador_cadastro");
        $this->db->where('el.ativo', 't');
        $this->db->where('operador_destino', $operador_id);
        $this->db->orderby('data_cadastro DESC');
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorarioscalendarioAPP($medico_id, $data, $empresa_id) {
        $data_inicio = date("Y-m-01", strtotime($data));
        $data_fim = date("Y-m-t", strtotime($data));
        
        $this->db->select('ae.data, count(ae.data) as contagem, situacao, ae.medico_agenda as medico');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
       
        $this->db->where("(ae.situacao = 'LIVRE' OR ae.situacao = 'OK')");
        $this->db->where("ae.data is not null");

        $this->db->where("ae.data >=", $data_inicio);
        $this->db->where("ae.data <=", $data_fim);
        $this->db->where('ae.bloqueado', 'f');
        if ($empresa_id > 0) {
            $this->db->where("ae.empresa_id", $empresa_id);
        }
        $this->db->where("ae.medico_agenda", $medico_id);
        $this->db->groupby("ae.data, situacao, ae.medico_agenda");
        $this->db->orderby("ae.data, situacao");

        $return = $this->db->get();
        return $return->result();
    }

    function listartodospacientes($paciente){
        $this->db->select('paciente_id, p.nome, cpf, p.telefone, p.celular, c.nome as convenio, outro_convenio');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_convenio c', 'p.convenio_id = c.convenio_id', 'left');
        $this->db->where('p.ativo', 't');
        if($paciente != ""){
            $this->db->where('p.nome ilike', "%" . $paciente . "%");
        }
        $return = $this->db->get();

        if($paciente != ""){
            return $return->result();
        }else{
            return array();
        }
        
    }

    function repetirreceitapaciente($ambulatorio_laudo_id, $meses){
        $this->db->select('data_cadastro, texto, medico_parecer1, laudo_id, tipo, assinatura, carimbo, especial, receita_id, adendo');
        $this->db->from('tb_ambulatorio_receituario');
        $this->db->where('ambulatorio_receituario_id', $ambulatorio_laudo_id);
        $return = $this->db->get()->result();

            $data = date('Y-m-d', strtotime($return[0]->data_cadastro .' + '. $meses. ' months'));
            $data = $data.' 00:00:00';
            $this->db->set('texto', $return[0]->texto);
            $this->db->set('medico_parecer1', $return[0]->medico_parecer1);
            $this->db->set('laudo_id', $return[0]->laudo_id);
            $this->db->set('tipo', $return[0]->tipo);
            $this->db->set('assinatura', $return[0]->assinatura);
            $this->db->set('carimbo', $return[0]->carimbo);
            $this->db->set('especial', $return[0]->especial);
            $this->db->set('data_cadastro', $data);
            $this->db->set('receita_id', $return[0]->receita_id);
            $this->db->set('adendo', $return[0]->adendo);
            $this->db->set('operador_cadastro', 0);
            $this->db->insert('tb_ambulatorio_receituario');

            $insert_id = $this->db->insert_id();

        return $insert_id;
    }


    function repetirexamepaciente($ambulatorio_exame_id, $meses){
        $this->db->select('data_cadastro, texto, medico_parecer1, laudo_id, tipo, assinatura, carimbo, exame_id, adendo');
        $this->db->from('tb_ambulatorio_exame');
        $this->db->where('ambulatorio_exame_id', $ambulatorio_exame_id);
        $return = $this->db->get()->result();

            $data = date('Y-m-d', strtotime($return[0]->data_cadastro .' + '. $meses. ' months'));
            $data = $data.' 00:00:00';
            $this->db->set('texto', $return[0]->texto);
            $this->db->set('medico_parecer1', $return[0]->medico_parecer1);
            $this->db->set('laudo_id', $return[0]->laudo_id);
            $this->db->set('tipo', $return[0]->tipo);
            $this->db->set('assinatura', $return[0]->assinatura);
            $this->db->set('carimbo', $return[0]->carimbo);
            $this->db->set('data_cadastro', $data);
            $this->db->set('exame_id', $return[0]->exame_id);
            $this->db->set('adendo', $return[0]->adendo);
            $this->db->set('operador_cadastro', 0);
            $this->db->insert('tb_ambulatorio_exame');

            $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    function listarprescricao($paciente_id, $laudo_id){
        $this->db->select('pt.nome as procedimento,
                           al.texto,
                           al.ambulatorio_laudo_id,
                           al.data,
                           m.nome as medico,
                           al.exame_id,
                           al.tipo');
        $this->db->from('tb_ambulatorio_laudo al');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = al.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador m', 'm.operador_id = al.medico_parecer1', 'left');
        if($paciente_id > 0){
        $this->db->where('al.paciente_id', $paciente_id);
        }
        if($laudo_id > 0){
            $this->db->where('al.ambulatorio_laudo_id', $laudo_id);
        }
        $this->db->orderby('al.data asc');


        return $this->db->get()->result();
    }

    function listarreceitaatendimento($laudo_id){
        $this->db->select('ar.ambulatorio_receituario_id,
                           ar.texto,
                           ar.data_cadastro,
                           o.nome as medico,
                           ar.especial,
                           al.empresa_id');
        $this->db->from('tb_ambulatorio_receituario ar');
        $this->db->join('tb_ambulatorio_laudo al', 'al.ambulatorio_laudo_id = ar.laudo_id');
        $this->db->join('tb_operador o', 'o.operador_id = ar.medico_parecer1', 'left');
        $this->db->where('laudo_id', $laudo_id);
        $this->db->orderby('ar.data_cadastro asc');
        
        return $this->db->get()->result();
    }

    function listarsolexamesatendimento($laudo_id){
        $this->db->select('ar.ambulatorio_exame_id,
                           ar.texto,
                           ar.data_cadastro,
                           o.nome as medico,
                           al.empresa_id');
        $this->db->from('tb_ambulatorio_exame ar');
        $this->db->join('tb_ambulatorio_laudo al', 'al.ambulatorio_laudo_id = ar.laudo_id');
        $this->db->join('tb_operador o', 'o.operador_id = ar.medico_parecer1', 'left');
        $this->db->where('laudo_id', $laudo_id);
        $this->db->orderby('ar.data_cadastro asc');
        
        return $this->db->get()->result();
    }

    function listarsolrelatorioatendimento($laudo_id){
        $this->db->select('ar.ambulatorio_relatorio_id,
                           ar.texto,
                           ar.data_cadastro,
                           o.nome as medico,
                           al.empresa_id');
        $this->db->from('tb_ambulatorio_relatorio ar');
        $this->db->join('tb_ambulatorio_laudo al', 'al.ambulatorio_laudo_id = ar.laudo_id');
        $this->db->join('tb_operador o', 'o.operador_id = ar.medico_parecer1', 'left');
        $this->db->where('laudo_id', $laudo_id);
        $this->db->orderby('ar.data_cadastro asc');
        
        return $this->db->get()->result();
    }

    function listarsolterapeuticaatendimento($laudo_id){
        $this->db->select('ar.ambulatorio_terapeutica_id,
                           ar.texto,
                           ar.data_cadastro,
                           o.nome as medico,
                           al.empresa_id');
        $this->db->from('tb_ambulatorio_terapeuticas ar');
        $this->db->join('tb_ambulatorio_laudo al', 'al.ambulatorio_laudo_id = ar.laudo_id');
        $this->db->join('tb_operador o', 'o.operador_id = ar.medico_parecer1', 'left');
        $this->db->where('laudo_id', $laudo_id);
        $this->db->orderby('ar.data_cadastro asc');
        
        return $this->db->get()->result();
    }

    function listarhorariosAPP($medico_id, $data, $empresa_id) {
        
        $this->db->select('ae.agenda_exames_id as id, 
                            ae.paciente_id, 
                            p.nome as paciente,
                            p.cpf as paciente_cpf,
                            p.nascimento as paciente_dt_nascimento,
			                p.telefone,
                            ae.data,
                            pt.nome as exame,
                            ae.inicio as hora_inicio,
                            ae.fim as hora_fim,
                            cha.nome as convenio,
                            ha.grupo,
                            ae.situacao');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_horarioagenda ha', 'ha.horarioagenda_id = ae.horario_id', 'left');
        $this->db->join('tb_convenio cha', 'cha.convenio_id = ha.convenio_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("(ae.situacao = 'LIVRE' OR ae.situacao = 'OK')");
        $this->db->where("ae.data is not null");
        $this->db->where("ae.data", $data);
        $this->db->where('ae.bloqueado', 'f');
        if ($empresa_id > 0) {
            $this->db->where("ae.empresa_id", $empresa_id);
        }
        $this->db->where("ae.medico_agenda", $medico_id);
        // $this->db->where("cha.convenio_id is not null");
        $this->db->orderby("ae.inicio DESC");
        $return = $this->db->get();
        return $return->result();
    }

    function listargrupoconvenios() {

        $this->db->select('convenio_grupo_id as agente_pagador_id,
                            nome');
        $this->db->from('tb_convenio_grupo');
        $this->db->where('ativo', 't');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
        
    }

    function listarprocedimentos() {

        $this->db->select('procedimento_tuss_id,
            nome');
        $this->db->from('tb_procedimento_tuss');
        $this->db->where('ativo', 't');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarhistoricoAPP($agenda_exames_id, $paciente_id, $medico_id) {
        
        $this->db->select('ag.ambulatorio_laudo_id as laudo_id,
                            ag.data,
                            pt.nome as exame,
                            ag.texto as descricao,
                            o.nome as medico');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo agr', 'agr.nome = pt.grupo', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->where('age.paciente_id', $paciente_id);
        $this->db->where('age.agenda_exames_id !=', $agenda_exames_id);
        if($medico_id > 0){
            $this->db->where('ag.medico_parecer1', $medico_id);
        }
        $this->db->where("ag.cancelada", 'false');
        $this->db->orderby('ag.data_cadastro desc');
        $this->db->orderby('ag.situacao');
        $this->db->orderby('ag.data');
        $return = $this->db->get()->result();
        return $return;
    }

    function listarhistoricoAPPEspec($paciente_id, $tipo) {
        
        $this->db->select('agr.nome as especialidade,
                           o.nome as medico,
                           ag.ambulatorio_laudo_id,
                           age.data
                            ');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo agr', 'agr.nome = pt.grupo', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->where('age.paciente_id', $paciente_id);
        $this->db->where('agr.tipo', $tipo);
        $this->db->where('ag.situacao', 'FINALIZADO');
        $this->db->orderby('ag.data_cadastro desc');
        $this->db->orderby('ag.situacao');
        $this->db->orderby('ag.data');
        $return = $this->db->get()->result();
        return $return;
    }

    function confirmarAjuste($solicitacao_id, $medico_id){
        $horario = date("Y-m-d H:i:s");

        $this->db->set('medico_ajuste_id', $medico_id);
        $this->db->set('confirmado', 't');
        $this->db->set('status', 'Finalizada');
        $this->db->set('operador_atualizacao', $medico_id);
        $this->db->set('data_atualizacao', $horario);
        $this->db->where('solicitacao_ajuste_id', $solicitacao_id);
        $this->db->update('tb_solicitacao_ajuste');

        $this->db->select('sa.solicitacao_ajuste_id as id,
                            sa.medico_solicitante_id,
                            sa.medico_ajuste_id,
                            sa.status,
                            sa.inicio,
                            sa.fim,
                            sa.data_original,
                            sa.data_ajustada,
                            sa.agenda_exames_id,
                            ');
        $this->db->from('tb_solicitacao_ajuste sa');
        $this->db->where('sa.solicitacao_ajuste_id', $solicitacao_id);
        $this->db->orderby('sa.data_original, sa.data_ajustada');
        $return = $this->db->get()->result();

        if(count($return) > 0){
            $this->db->select('agenda_exames_id');
            $this->db->from('tb_agenda_exames');
            $this->db->where('medico_agenda', $return[0]->medico_solicitante_id);
            $this->db->where('data', $return[0]->data_ajustada);
            if($return[0]->inicio != ''){
                $this->db->where('inicio >=', $return[0]->inicio);
            }
            if($return[0]->fim != ''){
                $this->db->where('fim <=', $return[0]->fim);
            }
            $resultadoAgenda = $this->db->get()->result();
            if(count($resultadoAgenda) == 0){

            }

            $this->db->set('medico_agenda', $return[0]->medico_ajuste_id);
            $this->db->set('data_atualizacao', $horario);
            if($return[0]->agenda_exames_id > 0){
                $this->db->where('agenda_exames_id', $return[0]->agenda_exames_id);
            }else{
                $this->db->where('medico_agenda', $return[0]->medico_solicitante_id);
                $this->db->where('data', $return[0]->data_ajustada);
                if($return[0]->inicio != ''){
                    $this->db->where('inicio >=', $return[0]->inicio);
                }
                if($return[0]->fim != ''){
                    $this->db->where('fim <=', $return[0]->fim);
                }
            }
            
            $this->db->update('tb_agenda_exames');

            return $return;
        }else{
            return false;
        }

    }

    function registrarDispositivo($medico_id, $hash){
        $horario = date("Y-m-d H:i:s");
        if(count($this->buscarHashDispositivoHash($medico_id, $hash)) > 0){
            return false;
        }
        if($hash != '' && $medico_id != ''){
            $this->db->set('medico_id', $medico_id);
            $this->db->set('hash', $hash);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $medico_id);
            $this->db->insert('tb_registro_dispositivo');
            return array(true);
        }else{
            return false;
        }
        
        
    }

    function registrarDispositivoPaciente($paciente_id, $hash){
        $horario = date("Y-m-d H:i:s");
        if(count($this->buscarHashDispositivoHashPaciente($paciente_id, $hash)) > 0){
            return false;
        }
        if($hash != '' && $paciente_id != ''){
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('hash', $hash);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', 1);
            $this->db->insert('tb_registro_dispositivo');
            return array(true);
        }else{
            return false;
        }
    }

    function buscarHashDispositivo($medico_id, $tipo, $grupo = ''){
        $this->db->select('rd.hash, rd.medico_id');
        $this->db->from('tb_registro_dispositivo rd');
        $this->db->join('tb_operador o', 'o.operador_id = rd.medico_id', 'left');
        $this->db->where('rd.paciente_id is null');
        if($grupo == '' && $medico_id > 0){
            if($tipo == 1){
                $this->db->where('rd.medico_id ', $medico_id);
            }
            if($tipo == 0){
                $this->db->where('rd.medico_id !=', $medico_id);
            }
        }else{
            $this->db->where("position('$grupo' in o.grupo_agenda) > 0");
            // die;
        }
        
        $return = $this->db->get()->result();
        return $return;
    }

    function buscarHashDispositivoPaciente(){
        $this->db->select('rd.hash, rd.paciente_id');
        $this->db->from('tb_registro_dispositivo rd');
        $this->db->join('tb_paciente p', 'p.paciente_id = rd.paciente_id', 'left');
        $this->db->where('rd.medico_id is null');
        
        $return = $this->db->get()->result();
        return $return;
    }

    function buscarHashDispositivoHashPaciente($paciente_id, $hash){
        $this->db->select('hash');
        $this->db->from('tb_registro_dispositivo');
        $this->db->where('paciente_id', $paciente_id);
        $this->db->where('hash', $hash);        
        $return = $this->db->get()->result();
        return $return;
    }

    function buscarHashDispositivoHash($medico_id, $hash){
        $this->db->select('hash');
        $this->db->from('tb_registro_dispositivo');
        $this->db->where('medico_id', $medico_id);
        $this->db->where('hash', $hash);        
        $return = $this->db->get()->result();
        return $return;
    }

    function solicitarAjuste($medico_id, $data_ajustada, $hora_inicio, $hora_fim, $medico_solicitado, $grupo_solicitado, $agenda_exames_id){
        $horario = date("Y-m-d H:i:s");
        if($data_ajustada != '' && $medico_id != ''){
            $this->db->set('data_ajustada', $data_ajustada);
            // $this->db->set('data_original', $data_original);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('confirmado', 'f');
            $this->db->set('operador_cadastro', $medico_id);
            $this->db->set('medico_solicitante_id', $medico_id);
            if($agenda_exames_id > 0){
                $this->db->set('agenda_exames_id', $agenda_exames_id);
            }
            if($medico_solicitado > 0){
                $this->db->set('medico_ajuste_id', $medico_solicitado);
            }else{
                $this->db->set('grupo_solicitado', $grupo_solicitado);
            }
            if($hora_inicio != ''){
                $this->db->set('inicio', $hora_inicio);
            }
            if($hora_fim != ''){
                $this->db->set('fim', $hora_fim);
            }
            $this->db->insert('tb_solicitacao_ajuste');

            return array(true);
        }else{
            return false;
        }
        
        
    }

    function listarmedicos($grupo = '') {
        $this->db->select('o.operador_id as id,
                               o.grupo_agenda as grupos,
                               o.nome,');
        $this->db->from('tb_operador o');
        $this->db->where("consulta", 't');
        $this->db->where('o.ativo', 'true');
//        $this->db->where('o.medico_cirurgiao', 'false');
        if($grupo != ''){
            $this->db->where("position('$grupo' in o.grupo_agenda) > 0");
        }
        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listargrupos($medico_id) {
        if($medico_id > 0){
            $this->db->select('grupo_agenda as nome');
            $this->db->from('tb_operador o');
            $this->db->where('o.operador_id', $medico_id);
        }else{
            $this->db->select('nome');
            $this->db->from('tb_ambulatorio_grupo');
    //        $this->db->where("tipo !=", 'AGRUPADOR');
            $this->db->orderby("nome");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarSolicitacoesAjustes($medico_id){
        $this->db->select('grupo_agenda');
        $this->db->from('tb_operador o');
        $this->db->where('o.operador_id', $medico_id);
        $grupoRet = $this->db->get()->result();

        if(count($grupoRet) > 0){
            if(count($grupoRet) > 0 && $grupoRet[0]->grupo_agenda != ''){
                $grupos = json_decode($grupoRet[0]->grupo_agenda);
            }else{
                $grupos = array();
                return array();
            }
        }else{
            $grupos = array();
            return array();
        }

        $data = date("Y-m-d");
        $this->db->select('sa.solicitacao_ajuste_id as id,
                            o.nome as medico_solicitante,
                            o2.nome as medico_ajuste,
                            sa.grupo_solicitado,
                            sa.medico_solicitante_id as medico_id,
                            sa.status,
                            sa.data_original,
                            sa.data_ajustada,
                            ');
        $this->db->from('tb_solicitacao_ajuste sa');
        $this->db->join('tb_operador o', 'o.operador_id = sa.medico_solicitante_id', 'left');
        $this->db->join('tb_operador o2', 'o2.operador_id = sa.medico_ajuste_id', 'left');
        $this->db->where('sa.medico_ajuste_id', $medico_id);
        $this->db->where('sa.confirmado', 'f');
        foreach ($grupos as $value) {
            $this->db->orwhere("position('$value' in o.grupo_agenda) > 0");
        }
        $this->db->where('sa.medico_solicitante_id', $medico_id);
        // $this->db->where('sa.data_original >=', $data);
        $this->db->where('sa.data_ajustada >=', $data);
        $this->db->where('sa.ativo', 't');
        $this->db->where('sa.confirmado', 'f');
        $this->db->orderby('sa.data_original, sa.data_ajustada');
        $return = $this->db->get()->result();
        return $return;
    }

    function listarEmpresas() {

        $this->db->select('empresa_id as id,
                            nome,
                            logradouro as endereco,
                            email,
                            telefone as telefone_01,
                            celular as telefone_02
                            ');
        $this->db->from('tb_empresa');
        $this->db->where("ativo", 't');
        $this->db->orderby('empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarEmpresaGerenciaNet($empresa_id = 1) {

        $this->db->select('client_id,
                            client_secret,
                            client_sandbox,
                            valor_consulta_app,
                            ');
        $this->db->from('tb_empresa');
        $this->db->where("empresa_id", $empresa_id);
        $this->db->orderby('empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarFlags($empresa_id = null) {
        if ($empresa_id == null) {
            $empresa_id = 1;
        }

        $this->db->select('ep.agenda_albert as escala');
        $this->db->from('tb_empresa e');
        $this->db->where('e.empresa_id', $empresa_id);
        $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
        $this->db->orderby('e.empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarBotoes($empresa_id = null) {
        // if ($empresa_id == null) {
        //     $empresa_id = 1;
        // }

        $this->db->select('ep.botoes_app');
        $this->db->from('tb_empresa e');
        if ($empresa_id != null) {
            $this->db->where('e.empresa_id', $empresa_id);
        }
        $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
        $this->db->orderby('e.empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarPostsBlog() {

        $this->db->select("posts_blog_id as id,
                            titulo,
                            breve_descricao,
                            thumbnail,
                            corpo_html,
                            thumbnail as plano,
                            ");
        $this->db->from('tb_posts_blog');
        $this->db->where("ativo", 't');
        $this->db->orderby('data_cadastro');
        $return = $this->db->get();
        return $return->result();
    }

    function listarConvenios() {

        $this->db->select(' c.convenio_id,
                            c.nome,
                            c.caminho_logo');
        $this->db->from('tb_convenio c');
        $this->db->where("c.ativo", 'true');
        $this->db->orderby("c.nome");
        $query = $this->db->get();
        $return = $query->result();

        return $return;
    }

    function adicionaradendo($laudo_id, $texto_add, $medico_id){
        $this->db->select('texto');
        $this->db->from('tb_ambulatorio_laudo');
        $this->db->where('ambulatorio_laudo_id', $laudo_id);
        $query = $this->db->get()->result();
        $texto = $query[0]->texto;
        
        $horario = date("Y-m-d H:i:s");

        $texto_adicional_html = "</html>";
        $texto_adicional_body = "</body>";
        $texto = str_replace($texto_adicional_html, "", $texto);
        $texto = str_replace($texto_adicional_body, "", $texto);
        
        $adendo = $texto  . "<p><strong>Adendo de: " . date("d/m/Y H:i:s") . "<br></strong></p>" . $texto_add . $texto_adicional_body . $texto_adicional_html;
        

        $this->db->set('texto', $adendo);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $medico_id);
        $this->db->where('ambulatorio_laudo_id', $laudo_id);
        $this->db->update('tb_ambulatorio_laudo');
        return array(true);
    }

    function gravarPacienteLink($transacao_id, $paciente_id, $link_pagamento, $agenda_exames_id){
        $this->db->set('gerencianet_id', $transacao_id);
        $this->db->set('gerencianet_link', $link_pagamento);
        $this->db->where('paciente_id', $paciente_id);
        $this->db->update('tb_paciente');

        $this->db->set('gerencianet_id', $transacao_id);
        $this->db->set('gerencianet_link', $link_pagamento);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');
        return array(true);
    }
    
    function agenda_charge_id($agenda_exames_id){
        $this->db->select('gerencianet_id, gerencianet_link');
        $this->db->from('tb_agenda_exames');
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $query = $this->db->get()->result();
        return $query;
    }

    function paciente_charge_id($paciente_id){
        $this->db->select('gerencianet_id, gerencianet_link');
        $this->db->from('tb_paciente');
        $this->db->where('paciente_id', $paciente_id);
        $query = $this->db->get()->result();
        return $query;
    }
    

    function gravarmedicoprecadastro(){
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('nome', $_POST['nome']);
        $this->db->set('email', $_POST['email']);
        $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['telefone']))));
        $this->db->set('cidade_text', $_POST['cidade']);
        $this->db->set('crm', $_POST['crm']);
        $this->db->set('outros', $_POST['outros']);
        if(count(json_decode($_POST['residencias'])) > 0){
            $residen = '';
            foreach (json_decode($_POST['residencias']) as $key => $value) {
                $residen .= " $value,";
            }
            $this->db->set('instituto_resid', $residen);
        }
        if(count(json_decode($_POST['especializacoes'])) > 0){
            $this->db->set('titulo_especialista', 't');
            $instesp = '';
            foreach (json_decode($_POST['especializacoes']) as $key => $value) {
                $instesp .= " $value,";
            }
            $this->db->set('instituicao_especialista', $instesp);
        }
        if(count(json_decode($_POST['subespecializacoes'])) > 0){
            $this->db->set('subespecializacao', 't');
            $instesp = '';
            foreach (json_decode($_POST['subespecializacoes']) as $key => $value) {
                $instesp .= " $value,";
            }
            $this->db->set('instituicao_subespecializacao', $instesp);
        }
        if(count(json_decode($_POST['mestrados'])) > 0){
            $this->db->set('mestrado', 't');
            $instesp = '';
            foreach (json_decode($_POST['mestrados']) as $key => $value) {
                $instesp .= " $value,";
            }
            $this->db->set('instituicao_mestrado', $instesp);
        }
        if(count(json_decode($_POST['doutorados'])) > 0){
            $this->db->set('doutorado', 't');
            $instesp = '';
            foreach (json_decode($_POST['doutorados']) as $key => $value) {
                $instesp .= " $value,";
            }
            $this->db->set('instituicao_doutorado', $instesp);
        }
      
        $this->db->set('data_cadastro', $horario);
        // $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_pacientes_precadastro');
        $operador_id = $this->db->insert_id();
        return $operador_id;

    }

    function relatorioRecebimentos($json_post){
        $medico_id = $json_post->medico_id;
        $data_inicio = $json_post->data_inicio;
        $data_fim = $json_post->data_fim;
        $convenio_id = $json_post->convenio_id;
        $grupo_convenio_id = $json_post->agente_pagador_id;
        $procedimento_tuss_id = $json_post->procedimento_tuss_id;
        $grupo = $json_post->grupo;
        $this->db->select("ae.quantidade,
                            p.nome as paciente,
                            pt.nome as procedimento,
                            pc.procedimento_convenio_id,
                            ae.autorizacao,
                            ae.agenda_exames_id,
                            ae.percentual_medico,
                            ae.valor_medico,
                            ae.percentual_laboratorio,
                            ae.valor_laboratorio,
                            ae.laboratorio_id,
                            lab.nome as laboratorio,
                            ae.percentual_promotor,
                            ae.valor_promotor,
                            ae.desconto_ajuste1,
                            ae.desconto_ajuste2,
                            ae.desconto_ajuste3,
                            ae.desconto_ajuste4,
                            ae.data,
                            ae.producao_paga,
                            ae.tipo_desconto,
                            al.data as data_laudo,
                            al.data_producao,
                            al.ambulatorio_laudo_id,
                            ae.data_antiga,
                            ae.sala_pendente,
                            e.situacao,
                            op.operador_id,
                            ae.valor,
                            ae.valor1,
                            ae.valor2,
                            ae.valor3,
                            ae.valor4,
                            ae.valor_total,
                            pc.procedimento_tuss_id,
                            al.medico_parecer1,
                            pt.grupo,
                            pt.perc_medico,
                            (
                                SELECT dia_recebimento 
                                FROM ponto.tb_procedimento_percentual_medico_convenio ppmc
                                INNER JOIN ponto.tb_procedimento_percentual_medico ppm 
                                ON ppm.procedimento_percentual_medico_id = ppmc.procedimento_percentual_medico_id
                                WHERE ppm.procedimento_tuss_id = ae.procedimento_tuss_id
                                AND ppm.ativo = 't'
                                AND ppmc.ativo = 't'
                                AND ppmc.medico = al.medico_parecer1
                                ORDER BY ppmc.data_cadastro DESC
                                LIMIT 1
                            ) as dia_recebimento,
                            (
                                SELECT tempo_recebimento 
                                FROM ponto.tb_procedimento_percentual_medico_convenio ppmc
                                INNER JOIN ponto.tb_procedimento_percentual_medico ppm 
                                ON ppm.procedimento_percentual_medico_id = ppmc.procedimento_percentual_medico_id
                                WHERE ppm.procedimento_tuss_id = ae.procedimento_tuss_id
                                AND ppm.ativo = 't'
                                AND ppmc.ativo = 't'
                                AND ppmc.medico = al.medico_parecer1
                                ORDER BY ppmc.data_cadastro DESC
                                LIMIT 1
                            ) as tempo_recebimento,
                            al.situacao as situacaolaudo,
                            tu.classificacao,
                            o.nome as revisor,
                            op.taxa_administracao,
                            pt.percentual,
                            op.nome as medico,
                            op.taxaadm_perc,
                            op.piso_medico,
                            pi.nome as indicacao,
                            ops.nome as medicosolicitante,
                            c.nome as convenio,
                            c.iss,
                            ae.valor1,
                            ae.forma_pagamento as forma_pagamento1,
                            ae.forma_pagamento2,
                            ae.valor2,
                            ae.forma_pagamento3,
                            ae.valor3,
                            ae.numero_sessao,
                            ae.forma_pagamento4,
                            ae.valor4,
                            f.nome as forma_pagamento_1,
                            f.cartao as cartao1,
                            f2.nome as forma_pagamento_2,
                            f2.cartao as cartao2,
                            f3.nome as forma_pagamento_3,
                            f3.cartao as cartao3,
                            f4.nome as forma_pagamento_4,
                            f4.cartao as cartao4 ");
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = ae.indicacao', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_laboratorio lab', 'lab.laboratorio_id = ae.laboratorio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer2', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_operador ops', 'ops.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio_grupo cg', 'cg.convenio_grupo_id = c.convenio_grupo_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->join('tb_forma_pagamento f2', 'f2.forma_pagamento_id = ae.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento f3', 'f3.forma_pagamento_id = ae.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento f4', 'f4.forma_pagamento_id = ae.forma_pagamento4', 'left');
//        $this->db->join('tb_agenda_exames_faturar aef', 'aef.agenda_exames_id = ae.agenda_exames_id', 'left');
//        $this->db->where('aef.ativo','t');
        $this->db->where('e.cancelada', 'false');
//        $this->db->where('ae.valor_medico is not null');
        $this->db->where('ae.paciente_id is not null');
        $this->db->where('pt.home_care', 'f');

        $this->db->where("ae.data_faturar >=", $data_inicio);
        $this->db->where("ae.data_faturar <=", $data_fim);
        
        if($convenio_id > 0){
            $this->db->where("pc.convenio_id", $convenio_id);
        }
        if($procedimento_tuss_id > 0){
            $this->db->where("pc.procedimento_tuss_id", $procedimento_tuss_id);
        }
        if($grupo_convenio_id > 0){
            $this->db->where("c.convenio_grupo_id", $grupo_convenio_id);
        }
        if($grupo != ''){
            $this->db->where("pt.grupo", $grupo);
        }
        $this->db->where("al.medico_parecer1", $medico_id);
        $this->db->orderby('al.medico_parecer1');
        $this->db->orderby('ae.data');
        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.paciente_id');

        $return = $this->db->get();
        return $return->result();

    }

    function relatorioRecebimentosImp($json_post){
        $medico_id = $json_post->medico_id;
        $data_inicio = $json_post->data_inicio;
        $data_fim = $json_post->data_fim;
        $convenio_id = $json_post->convenio_id;
        $grupo_convenio_id = $json_post->agente_pagador_id;
        $procedimento_tuss_id = $json_post->procedimento_tuss_id;
        $grupo = $json_post->grupo;

        $this->db->select("pi.quantidade,
                            pi.medico_id,
                            pi.convenio_id,
                            pi.data_producao,
                            pi.data_producao as data,
                            pi.data_agendamento,
                            pi.valor as valor_total,
                            pi.valor,
                            pi.valor_medico,
                            c.iss,
                            pi.percentual_medico,
                            c.nome as convenio,
                            o.nome as medico,
                            p.nome as paciente,
                            pt.nome as procedimento,
                            pc.procedimento_convenio_id,
                            pt.grupo,
                            NULL as agenda_exames_id,
                            NULL as percentual_promotor,
                            NULL as valor_promotor,
                            NULL as valor_promotor,
                            ", false);
        $this->db->from('tb_procedimento_importacao_producao pi');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pi.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = pi.medico_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pi.paciente_id', 'left');
        // $this->db->where('ae.paciente_id is not null');
        $this->db->where('pi.ativo','t');
        $this->db->where('pi.duplo', 'f');

        $this->db->where("pi.data_producao >=", $data_inicio);
        $this->db->where("pi.data_producao <=", $data_fim);
        if($convenio_id > 0){
            $this->db->where("pc.convenio_id", $convenio_id);
        }
        if($procedimento_tuss_id > 0){
            $this->db->where("pc.procedimento_tuss_id", $procedimento_tuss_id);
        }
        if($grupo_convenio_id > 0){
            $this->db->where("c.convenio_grupo_id", $grupo_convenio_id);
        }
        if($grupo != ''){
            $this->db->where("pt.grupo", $grupo);
        }
        $this->db->where("pi.medico_id", $medico_id);
        $this->db->orderby('pi.data_agendamento');
        $this->db->orderby('pi.medico_id');
        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('pi.data_producao');
        $this->db->orderby('pi.paciente_id');

        $return = $this->db->get();
        return $return->result();

    }

    function buscarpaciente($json_post) {
        $this->db->select('p.nome,
                            p.cns as email,
                            p.cpf,
                            p.telefone,
                            p.whatsapp,
                            p.nascimento as data_nascimento,
                            ');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_municipio c', 'c.municipio_id = p.municipio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_tipo_logradouro tp', 'p.tipo_logradouro = tp.tipo_logradouro_id', 'left');
        $this->db->where("p.paciente_id", $json_post->paciente_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendatotalpacientegeral($pacientetemp_id) {
        $data = date("Y-m-d");
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            pt.nome as procedimento,
                            c.nome as convenio,
                            a.data,
                            a.data,
                            es.nome as sala,
                            a.medico_agenda,
                            a.gerencianet_link,
                            a.gerencianet_id,
                            o.nome as medico,
                            o.link_reuniao,
                            a.confirmado as liberado,
                            al.situacao,
                            emp.nome as empresa,
                            pt.home_care');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = a.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_empresa emp', 'emp.empresa_id = a.empresa_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        // $this->db->where("al.situacao !=", 'FINALIZADO');
        // $this->db->where("a.confirmado", 'false');
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");       
        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacaoagendamento() {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('pp.paciente_solicitar_agendamento_id, 
                            pp.paciente_id, 
                            pp.data, 
                            pp.hora, 
                            pp.confirmado, 
                            p.nome as paciente,
                            c.nome as convenio, 
                            pt.nome as procedimento, 
                            pp.convenio_text, 
                            pp.procedimento_text, 
                            pp.data_cadastro');
        $this->db->from('tb_paciente_solicitar_agendamento pp');
        $this->db->join('tb_paciente p', 'p.paciente_id = pp.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pp.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('pp.ativo', 't');
        $this->db->orderby("pp.data");
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosatendimentonovo($parametro, $parametro2) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.codigo,
                            pc.valortotal,
                            c.dinheiro,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->where("ag.tipo !=", 'CIRURGICO');
        $this->db->where("pc.ativo", 't');
        $this->db->where("pt.agrupador", 'f');
        $this->db->where('pc.convenio_id', $parametro);
        if($parametro2 != ''){
            $this->db->where('ag.tipo', $parametro2);
        }
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentoconsultaparticular() {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.codigo,
                            pc.valortotal,
                            c.dinheiro,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->where("ag.tipo !=", 'CIRURGICO');
        $this->db->where("pc.ativo", 't');
        $this->db->where("pt.agrupador", 'f');
        $this->db->where('c.nome', 'PARTICULAR');
        $this->db->where('ag.tipo', 'CONSULTA');
        $this->db->orderby("pt.nome");
        $return = $this->db->get()->result();
        if(count($return) > 0){
            return $return[0]->procedimento_convenio_id;
        }else{
            return 10;
        }
        
    }

    function listarclinicaprocedimento() {
        $this->db->select('e.nome as empresa,
                            e.empresa_id,
                            e.logradouro,
                            e.numero,
                            m.nome as municipio,
                            m.estado,
                            e.bairro,
                            e.celular,
                            e.telefone,
                            e.municipio_id');
        $this->db->from('tb_empresa e');
        $this->db->join('tb_municipio m', 'm.municipio_id = e.municipio_id', 'left');
        $this->db->where("e.ativo", 't');


        $this->db->orderby("e.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function horariosdisponiveisclinica($procedimento_id, $empresa_id) {
        $this->db->select("ag.tipo");
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->where('pc.procedimento_convenio_id', $procedimento_id);
        $retorno = $this->db->get()->result();
        $grupo = $retorno[0]->tipo;
        // if (count($retorno) == 0) {
        // var_dump($grupo); die;
        $horario = date("Y-m-d");
        // $horario_fim = date("2019-05-04");
            // O "false" no parametro so SELECT serve para dizer ao CodeIgniter não pôr aspas.
        $this->db->select("a.data,to_char(a.data, 'DD-MM-YYYY') as data_formatada_picker,
                              to_char(a.data, 'DD') as dia_picker,
                              to_char(a.data, 'MM') as mes_picker,
                              to_char(a.data, 'YYYY') as ano_picker,
                              to_char(a.data, 'DD/MM/YYYY') as data_formatada", false);
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_ambulatorio_tipo_consulta atc', 'atc.ambulatorio_tipo_consulta_id = a.tipo_consulta_id');
        // $this->db->where('a.ativo', 'true');
        $this->db->where('a.paciente_id is null');
        $this->db->where('a.bloqueado', 'false');
        $this->db->where('a.data >=', $horario);
        // $this->db->where('a.data <=', $horario_fim);
        $this->db->where('a.empresa_id', $empresa_id);
        $this->db->where("atc.grupo", $grupo);
        $this->db->orderby('a.data');
        $this->db->groupby('a.data');
        $this->db->limit(150);
        $return = $this->db->get()->result();
        // echo '<pre>'; var_dump($return); die;
        return $return;
        // } else {
            // return false;
        // }
    }

    function horariosdisponiveisclinicaunicas() {
        // if (count($retorno) == 0) {
        // var_dump($grupo); die;
        $horario = date("Y-m-d");
        // $horario_fim = date("2019-05-04");
            // O "false" no parametro so SELECT serve para dizer ao CodeIgniter não pôr aspas.
        $this->db->select("a.data,to_char(a.data, 'DD-MM-YYYY') as data_formatada_picker,
                              to_char(a.data, 'DD') as dia_picker,
                              to_char(a.data, 'MM') as mes_picker,
                              to_char(a.data, 'YYYY') as ano_picker,
                              to_char(a.data, 'DD/MM/YYYY') as data_formatada", false);
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_agenda', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta atc', 'atc.ambulatorio_tipo_consulta_id = a.tipo_consulta_id');
        if($_GET['tipo_agenda'] != ''){
            $this->db->where("a.tipo_consulta_id", $_GET['tipo_agenda']);
        }
        $this->db->where('o.link_reuniao !=', '');
        // $this->db->where('a.ativo', 'true');
        $this->db->where('a.paciente_id is null');
        $this->db->where('a.bloqueado', 'false');
        $this->db->where('a.data >=', $horario);
        // $this->db->where('a.data <=', $horario_fim);
        $this->db->orderby('a.data');
        $this->db->groupby('a.data');
        $this->db->limit(150);
        $return = $this->db->get()->result();
        // echo '<pre>'; var_dump($return); die;
        return $return;
        // } else {
            // return false;
        // }
    }

    function listartipoagenda() {
        $this->db->select('ambulatorio_tipo_consulta_id as id,
                            descricao as nome');
        $this->db->from('tb_ambulatorio_tipo_consulta');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function cancelar_agendamento($agenda_exames_id) {

        $this->db->set('paciente_id', null);
        $this->db->set('procedimento_tuss_id', null);
        $this->db->set('guia_id', null);
        $this->db->set('situacao', "LIVRE");
        $this->db->set('observacoes', "");
        $this->db->set('valor', NULL);
        $this->db->set('ativo', 't');
        $this->db->set('convenio_id', null);
        $this->db->set('autorizacao', null);
        $this->db->set('operador_atualizacao', null);
        $this->db->set('confirmado', 'f');
        $this->db->set('situacao', 'LIVRE');
        $this->db->set('observacoes', "");
        $horario = date("Y-m-d H:i:s");
        $this->db->set('ambulatorio_pacientetemp_id', null);
        $this->db->set('data_atualizacao', $horario);
        // $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    } 

    function listarhorariosmedicos($procedimento_id, $empresa_id, $data) {

        // var_dump($data);
        //  die;
        $this->db->select("ag.tipo");
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->where('pc.procedimento_convenio_id', $procedimento_id);
        $retorno = $this->db->get()->result();
        $grupo = $retorno[0]->tipo;
        // if (count($retorno) == 0) {
            // var_dump($grupo);
        $horario = date("Y-m-d");
        $data_teste = "2019-04-18";
            // O "false" no parametro so SELECT serve para dizer ao CodeIgniter não pôr aspas.
        $this->db->select("a.inicio,
                           a.medico_agenda,
                           a.data,
                           a.agenda_exames_id,
                           o.nome as medico,
                           o.conselho,
                           si.nome as sigla,
                        ", false);
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_agenda', 'left');
        $this->db->join('tb_sigla si', 'o.sigla_id = si.sigla_id', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta atc', 'atc.ambulatorio_tipo_consulta_id = a.tipo_consulta_id', 'left');
        $this->db->where('a.ativo', 'true');
        $this->db->where('a.paciente_id is null');
        $this->db->where('a.bloqueado', 'false');
        $this->db->where('a.data', $data);
        // $this->db->where('a.data <=', $horario_fim);
        $this->db->where('a.empresa_id', $empresa_id);
        $this->db->where("atc.grupo", $grupo);
        // $this->db->where("a.medico_agenda", 1);
        $this->db->orderby('a.data, a.inicio');
            //        $this->db->limit(250);
        $return = $this->db->get()->result();
        return $return;
        // } else {
            // return false;
        // }
    }

    function listarhorariosmedicosunicos($data) {

        // if (count($retorno) == 0) {
            // var_dump($grupo);
        $horario = date("Y-m-d");
        $data_teste = "2019-04-18";
            // O "false" no parametro so SELECT serve para dizer ao CodeIgniter não pôr aspas.
        $this->db->select("a.inicio,
                            a.medico_agenda,
                            a.data,
                            a.agenda_exames_id,
                            o.nome as medico,
                            o.conselho,
                            si.nome as sigla,
                        ", false);
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_agenda', 'left');
        $this->db->join('tb_sigla si', 'o.sigla_id = si.sigla_id', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta atc', 'atc.ambulatorio_tipo_consulta_id = a.tipo_consulta_id', 'left');
        $this->db->where('a.ativo', 'true');
        $this->db->where('a.paciente_id is null');
        $this->db->where('a.bloqueado', 'false');
        $this->db->where('o.link_reuniao !=', '');
        $this->db->where('a.data', $data);
        // $this->db->where('a.data <=', $horario_fim);
        // $this->db->where('a.empresa_id', $empresa_id);
        if($_GET['tipo_agenda'] != ''){
            $this->db->where("a.tipo_consulta_id", $_GET['tipo_agenda']);
        }

        // $this->db->where("a.medico_agenda", 1);
        // $this->db->groupby('a.data, a.inicio');
        $this->db->orderby('a.data, a.inicio');
            //        $this->db->limit(250);
        $return = $this->db->get()->result();
        return $return;
        // } else {
            // return false;
        // }
    }

    function listarsolicitarexameimpressao($ambulatorio_laudo_id) {
        $this->db->select('ar.ambulatorio_exame_id,
                            ar.paciente_id,
                            ar.data_cadastro');
        $this->db->from('tb_ambulatorio_exame ar');

        $this->db->where("ar.laudo_id", $ambulatorio_laudo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarreceitalaudo($paciente_id) {

        $this->db->select(' ag.ambulatorio_receituario_id,
                ag.texto,
                ag.data_cadastro,
                ag.medico_parecer1,
                ag.especial,
                al.cabecalho,
                o.nome as medico,
                o.operador_id,
                pt.grupo,
                pt.nome as procedimento
                ');
        $this->db->from('tb_ambulatorio_receituario ag');
        $this->db->join('tb_ambulatorio_laudo al', 'al.ambulatorio_laudo_id = ag.laudo_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = al.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = al.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->where('al.paciente_id', $paciente_id);
        $this->db->where('ag.tipo', 'NORMAL');
        $this->db->orderby('ag.data_cadastro DESC');

        $return = $this->db->get();
        return $return->result();
    }

    function gravarPrecadastro($json_post){
        $horario = date("Y-m-d H:i:s");
        $this->db->select('paciente_id, nome');
        $this->db->from('tb_paciente');
        // $this->db->where('nome', $json_post->nome);
        $this->db->where('cpf', str_replace(".", "", str_replace("-", "", $json_post->cpf)));
        $this->db->where('ativo', 't');
        $this->db->orderby('paciente_id');
        $contadorPaciente = $this->db->get()->result();
        // $contadorPaciente = array();
        if(count($contadorPaciente)  > 0){
            $paciente_id = $contadorPaciente[0]->paciente_id;
            $nome = $contadorPaciente[0]->nome;
            $this->db->set('usuario_app', $json_post->usuario_app);
            $this->db->set('senha_app', md5($json_post->senha_app));
            // $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_id', $paciente_id);
            $this->db->update('tb_paciente');
            return array($paciente_id, $nome);
        }

        // $this->db->select('nome');
        // $this->db->from('tb_paciente_precadastro_c');
        // // $this->db->where('nome', $json_post->nome);
        // $this->db->where('cpf', str_replace(".", "", str_replace("-", "", $json_post->cpf)));
        // $this->db->where('ativo', 't');
        // $this->db->orderby('nome');
        // $contadorPacientePre = $this->db->get()->result();
        // if(count($contadorPacientePre)  > 0){
        //     $nome = $contadorPacientePre[0]->nome;
            
        //     return array(0, $nome);
        // }
        $this->db->set('nome', $json_post->nome);
        $this->db->set('cns', $json_post->email);
        // $this->db->set('usuario_app', $json_post->usuario_app);
        $this->db->set('senha_app', md5($json_post->senha_app));
        if($json_post->data_nascimento != ''){
            $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $json_post->data_nascimento))));
        }
        $this->db->set('cpf', str_replace(".", "", str_replace("-", "", $json_post->cpf)));
        $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $json_post->telefone))));
        $this->db->set('whatsapp', str_replace("(", "", str_replace(")", "", str_replace("-", "", $json_post->whatsapp))));
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', 1);
        $this->db->insert('tb_paciente');
        $paciente_id =  $this->db->insert_id();
        return array($paciente_id, $json_post->nome);
    }

    function editarCadastroPaciente($json_post){
        $horario = date("Y-m-d H:i:s");
        
        $this->db->set('nome', $json_post->nome);
        $this->db->set('cns', $json_post->email);
        $this->db->set('cpf', str_replace(".", "", str_replace("-", "", $json_post->cpf)));
        if($json_post->data_nascimento != ''){
            $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $json_post->data_nascimento))));
        }
        $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $json_post->telefone))));
        $this->db->set('whatsapp', str_replace("(", "", str_replace(")", "", str_replace("-", "", $json_post->whatsapp))));
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', 1);
        $this->db->where('paciente_id', $json_post->paciente_id);
        $this->db->update('tb_paciente');
       
        return array($json_post->paciente_id, $json_post->nome);
    }

    function editarSenhaPaciente($json_post){
        $horario = date("Y-m-d H:i:s");
        
        $this->db->set('senha_app', md5($json_post->senha_app));
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', 1);
        $this->db->where('paciente_id', $json_post->paciente_id);
        $this->db->update('tb_paciente');
        return array($json_post->paciente_id);
    }

    function emailPaciente($json_post){
        $horario = date("Y-m-d H:i:s");

        $this->db->select('paciente_id, nome, cns as email');
        $this->db->from('tb_paciente');
        // $this->db->where('nome', $json_post->nome);
        $this->db->where('cns', $json_post->email);
        $this->db->orderby('paciente_id');
        $contadorPaciente = $this->db->get()->result();
        if(count($contadorPaciente) > 0){
            return array($contadorPaciente[0]->paciente_id, $json_post->email);
        }else{
            return array('', $json_post->email);
        }
       
    }
    
    function resetarSenhaPaciente($paciente_id){
        $horario = date("Y-m-d H:i:s");
        $senha_nova = $this->generateRandomString(10);
        // var_dump($senha_nova); die;
        
        $this->db->set('senha_app', md5($senha_nova));
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', 1);
        $this->db->where('paciente_id', $paciente_id);
        $this->db->update('tb_paciente');

        $this->db->select('paciente_id, nome, cns as email');
        $this->db->from('tb_paciente');
        // $this->db->where('nome', $json_post->nome);
        $this->db->where('paciente_id', $paciente_id);
        $this->db->orderby('paciente_id');
        $contadorPaciente = $this->db->get()->result();

        return array($paciente_id, $senha_nova, $contadorPaciente[0]->email);
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function gravarAgendamento($empresa_id, $paciente_id, $agenda_exames_id, $procedimento_id){
        $horario = date("Y-m-d H:i:s"); 
        $this->db->set('procedimento_tuss_id', $procedimento_id);
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('tipo', 'EXAME');
        $this->db->set('ativo', 'f');
        $this->db->set('cancelada', 'f');
        $this->db->set('confirmado', 'f');
        $this->db->set('situacao', 'OK');
        $horario = date("Y-m-d H:i:s");
        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('app_paciente_online', 't');
        // $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');
        return true;
    }

    function gravarSolicitarAgendamento($paciente_id, $data, $hora, $procedimento_id, $procedimento_text, $convenio_text){
        $horario = date("Y-m-d H:i:s");

        $this->db->set('data', $data);
        $this->db->set('hora', $hora);
        if(!$procedimento_id > 0){
            $this->db->set('procedimento_text', $procedimento_text);
            $this->db->set('convenio_text', $convenio_text);
        }else{
            $this->db->set('procedimento_convenio_id', $procedimento_id);
        }
        
        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('data_cadastro', $horario);
        // $this->db->set('operador_atualizacao', $operador_id);
        $this->db->insert('tb_paciente_solicitar_agendamento');
        return true;
    }

    function listarempresapermissoes($empresa_id = null) {
        if ($empresa_id == null) {
            $empresa_id = $this->session->userdata('empresa_id');
        }
        $this->db->select('e.empresa_id,
                            ordem_chegada,
                            promotor_medico,
                            excluir_transferencia,
                            orcamento_config,
                            rodape_config,
                            cabecalho_config,
                            valor_recibo_guia,
                            valor_autorizar,
                            gerente_contasapagar,
                            cpf_obrigatorio,
                            orcamento_recepcao,
                            relatorio_ordem,
                            relatorio_producao,
                            relatorios_recepcao,
                            encaminhamento_email,
                            financeiro_cadastro,
                            sem_margens_laudo,
                            odontologia_valor_alterar,
                            selecionar_retorno,
                            oftamologia,
                            carregar_modelo_receituario,
                            retirar_botao_ficha,
                            endereco_integracao_lab,
                            identificador_lis,
                            laboratorio,
                            convenio_padrao_id,
                            ep.convenio_padrao,
                            ep.laboratorio_sc,
                            ep.desabilitar_trava_retorno,
                            ep.conjuge,
                            ep.associa_credito_procedimento,
                            ep.valor_laboratorio,
                            ep.tecnico_recepcao_editar,
                            ep.desativar_personalizacao_impressao,
                            ep.campos_obrigatorios_pac_cpf,
                            ep.profissional_completo,
                            ep.tecnica_promotor,
                            ep.tecnica_enviar,
                            recibo_config,
                            ep.campos_obrigatorios_pac_sexo,
                            ep.campos_cadastro,
                            ep.campos_atendimentomed,
                            ep.dados_atendimentomed,
                            ep.campos_obrigatorios_pac_nascimento,
                            ep.campos_obrigatorios_pac_telefone,
                            ep.campos_obrigatorios_pac_municipio,
                            ep.reservar_escolher_proc,
                            ep.orcamento_cadastro,
                            ep.repetir_horarios_agenda,
                            ep.id_linha_financeiro,
                            ep.senha_finalizar_laudo,
                            ep.gerente_cancelar,
                            ep.valor_convenio_nao,
                            ep.producao_alternativo,
                            ep.apenas_procedimentos_multiplos,
                            ep.percentual_multiplo,
                            ep.ajuste_pagamento_procedimento,
                            ep.valor_autorizar,
                            ep.botao_ficha_convenio,
                            ep.orcamento_multiplo,
                            ep.ocupacao_mae,
                            ep.ocupacao_pai,
                            ep.faturamento_novo,
                            ep.filtrar_agenda,
                            ep.impressao_cimetra,
                            ep.faturamento_novo,
                            ep.carteira_administrador,
                            ep.caixa_grupo,
                            ep.filtro_exame_cadastro,
                            ep.editar_historico_antigo,
                            ep.laboratorio_sc,
                            ep.endereco_ficha,
                            ep.convenio_paciente,
                            ep.fidelidade_paciente_antigo,
                            ep.faturar_parcial,
                            ep.inadimplencia,
                            ep.cirugico_manual,
                            ep.enviar_para_atendimento,
                            ep.tecnico_acesso_acesso,
                            ep.alterar_data_emissao,
                            ep.pesquisar_responsavel,
                            ep.convenio_padrao,
                            ep.travar_convenio_paciente,
                            e.razao_social,
                            ep.empresas_unicas,
                            ep.tarefa_medico,
                            ep.data_pesquisa_financeiro,
                            ep.nao_sobrepor_laudo,
                            e.logradouro,
                            e.cnpj,
                            e.numero,
                            e.nome as nome_empresa,
                            ep.espera_intercalada
                            ');
        $this->db->from('tb_empresa e');
        $this->db->where('e.empresa_id', $empresa_id);
        $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
        $this->db->orderby('e.empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarPagamentoAgendaExames() {
        $data = date("Y-m-d");
        $this->db->select('ae.agenda_exames_id, ae.gerencianet_id as charge_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->where("ae.confirmado", 'f');
        $this->db->where("ae.data", $data);
        $this->db->where("ae.gerencianet_id is not null");
        $query = $this->db->get();
        $agenda = $query->result();
        return $agenda;
    }

    function verificagrupoprocedimento($procedimento_convenio_id) {

        $this->db->select('ag.nome, pc.valortotal');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->where("pc.procedimento_convenio_id", $procedimento_convenio_id);
        $query = $this->db->get();
        $tipo = $query->result();
        return $tipo[0]->nome;
    }

    function listarguia($paciente_id) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ep.guia_procedimento');
        $this->db->from('tb_empresa e');
        $this->db->where('e.empresa_id', $empresa_id);
        $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
        $this->db->orderby('e.empresa_id');
        $permissoes = $this->db->get()->result();


        $this->db->select('ambulatorio_guia_id');
        $this->db->from('tb_ambulatorio_guia');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('paciente_id', $paciente_id);
        $this->db->where('data_criacao', $data);
        $return = $this->db->get();


        if (@$permissoes[0]->guia_procedimento == 't') {
            return null;
        } else {
            return $return->row_array();
        }
    }

    function gravarguia($paciente_id) {
        //        var_dump($_POST);die;
        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('tipo', 'EXAME');
        $this->db->set('data_criacao', $data);
       
        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_ambulatorio_guia');
        $ambulatorio_guia_id = $this->db->insert_id();
        return $ambulatorio_guia_id;
    }

    function autorizarPacienteGerenciaNet($agenda_exames_id){
        
        $this->db->select('ae.procedimento_tuss_id,
                            ae.paciente_id,
                            ae.medico_agenda');
        $this->db->from('tb_agenda_exames ae');
        $this->db->where("ae.agenda_exames_id", $agenda_exames_id);
        $query = $this->db->get();
        $agenda = $query->result();
        // $procedimento_tuss_id = $agenda[0]->procedimento_tuss_id;
        $medicoexecutante = $agenda[0]->medico_agenda;
        $paciente_id = $agenda[0]->paciente_id;
        $qtde = 1;
        
        $this->db->select('pc.valortotal, pc.convenio_id, pc.procedimento_convenio_id');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->where("ag.nome", 'TELEMEDICINA');
        $query = $this->db->get();
        $proc = $query->result();
        $procedimento_tuss_id = $proc[0]->procedimento_convenio_id;
        

        $resultadoguia = $this->listarguia($paciente_id);
        if ($resultadoguia == null) {
            $ambulatorio_guia_id = $this->gravarguia($paciente_id);
        } else {
            $ambulatorio_guia_id = $resultadoguia['ambulatorio_guia_id'];
        }

        // var_dump($procedimento_tuss_id); die;
        $this->db->select('pc.valortotal, pc.convenio_id');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->where("pc.procedimento_convenio_id", $procedimento_tuss_id);
        $query = $this->db->get();
        $proc = $query->result();
        $valor = $proc[0]->valortotal;
        $convenio = $proc[0]->convenio_id;
       

        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");

        $this->db->select('mc.valor as perc_medico, mc.percentual');
        $this->db->from('tb_procedimento_percentual_medico_convenio mc');
        $this->db->join('tb_procedimento_percentual_medico m', 'm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id', 'left');
        $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
        $this->db->where('mc.medico', $medicoexecutante);
        $this->db->where('mc.ativo', 'true');
        $this->db->where('mc.revisor', 'false');
        $percentual = $this->db->get()->result();
        $grupo_laboratorio = $this->verificagrupoprocedimento($procedimento_tuss_id);
//                    $grupo = $_POST['grupo'][$i];
        if ($grupo_laboratorio == 'LABORATORIAL') {
            $this->db->select('mc.valor as perc_laboratorio, mc.percentual, mc.laboratorio');
            $this->db->from('tb_procedimento_percentual_laboratorio_convenio mc');
            $this->db->join('tb_procedimento_percentual_laboratorio m', 'm.procedimento_percentual_laboratorio_id = mc.procedimento_percentual_laboratorio_id', 'left');
            $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
//        $this->db->where('mc.laboratorio', $laboratoriopercentual);
            $this->db->where('mc.ativo', 'true');
//                        $this->db->where('mc.revisor', 'false');
            $percentual_laboratorio = $this->db->get()->result();
        }else{
            $percentual_laboratorio = array();
        }
//                    echo '<pre>';
//                    var_dump($percentual_laboratorio); die;

        if (count($percentual) == 0) {
            $this->db->select('pt.perc_medico, pt.percentual');
            $this->db->from('tb_procedimento_convenio pc');
            $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
            $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
//                        $this->db->where('pc.ativo', 'true');
//                        $this->db->where('pt.ativo', 'true');
            $percentual = $this->db->get()->result();
        }

        $this->db->set('valor_medico', $percentual[0]->perc_medico);
        $this->db->set('percentual_medico', $percentual[0]->percentual);

        if (count($percentual_laboratorio) > 0) {
//                        var_dump($index, $_POST['indicacao']);
            $this->db->set('valor_laboratorio', $percentual_laboratorio[0]->perc_laboratorio);
            $this->db->set('percentual_laboratorio', $percentual_laboratorio[0]->percentual);
            $this->db->set('laboratorio_id', $percentual_laboratorio[0]->laboratorio);
        }
        
        // $this->db->set('empresa_id', $empresa_id);
        // $this->db->set('paciente_id', $paciente_id);
        $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
        $this->db->set('convenio_id', $convenio);
    
        if ($medicoexecutante != "") {
            $this->db->set('medico_solicitante', $medicoexecutante);
        }
        if ($medicoexecutante != "") {
            $this->db->set('medico_agenda', $medicoexecutante);
            $this->db->set('medico_consulta_id', $medicoexecutante);
        }

        $this->db->set('guia_id', $ambulatorio_guia_id);
        $this->db->set('quantidade', $qtde);
//                    $this->db->set('valor', $valor);
        $valortotal = $valor * $qtde;
//                    $this->db->set('valor_total', $valortotal);

        
        $this->db->set('valor', $valor);
        $this->db->set('valor_total', $valortotal);
        
        // $this->db->set('faturado', 't');
        // $this->db->set('forma_pagamento', $formapagamento);
        // $this->db->set('valor1', $valortotal);
        // $this->db->set('operador_faturamento', $operador_id);
        // $this->db->set('data_faturamento', $horario);
        
        $this->db->set('confirmado', 't');

        $this->db->set('ambulatorio_pacientetemp_id', null);
        $this->db->set('data_autorizacao', $horario);
        $data = date("Y-m-d");
        $this->db->set('data_faturar', $data);
        $this->db->set('senha', md5($agenda_exames_id));
        $this->db->set('operador_autorizacao', 1);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');

        $this->db->select('ae.agenda_exames_nome_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->where('ae.agenda_exames_id', $agenda_exames_id);
//                    $this->db->orderby('e.empresa_id');
        $agenda_exames_s = $this->db->get()->result();
        $tipo_grupo = $this->verificatipoprocedimento($procedimento_tuss_id);
        $dados['agenda_exames_id'] = $agenda_exames_id;
        $dados['medico'] = $medicoexecutante;
        $dados['paciente_id'] = $paciente_id;
        $dados['procedimento_tuss_id'] = $procedimento_tuss_id;
        $dados['sala_id'] = $agenda_exames_s[0]->agenda_exames_nome_id;
        $dados['guia_id'] = $ambulatorio_guia_id;
        $dados['tipo'] = $tipo_grupo;
        $this->enviarsaladeespera($dados);

        // die;
    }

    function verificatipoprocedimento($procedimento_convenio_id) {

        $this->db->select('ag.tipo');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->where("pc.procedimento_convenio_id", $procedimento_convenio_id);
        $query = $this->db->get();
        $tipo = $query->result();
        return $tipo[0]->tipo;
    }

    function enviarsaladeespera($dados) {

        $agenda_exames_id = $dados['agenda_exames_id'];
        $medico = $dados['medico'];
        $paciente_id = $dados['paciente_id'];
        $procedimento_tuss_id = $dados['procedimento_tuss_id'];
        $sala_id = $dados['sala_id'];
        $guia_id = $dados['guia_id'];
        $tipo = $dados['tipo'];

        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
        $exame_id = $agenda_exames_id;
//            echo '<pre>';
//            var_dump($_POST);
//            var_dump($procedimento_tuss_id);
//            var_dump($guia_id);
//            var_dump($agenda_exames_id);
//            var_dump($tipo);
//            die;


        $this->db->select('al.ambulatorio_laudo_id');
        $this->db->from('tb_ambulatorio_laudo al');
        $this->db->join('tb_exames ae', 'ae.exames_id = al.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->where("age.agenda_exames_id is not null");
        $this->db->where("al.data <=", $data);
        $this->db->where("age.paciente_id", $paciente_id);
        $this->db->where("al.medico_parecer1", $medico);
        $atendimentos = $this->db->get()->result();

        $this->db->select('data_senha, senha, toten_fila_id, toten_senha_id');
        $this->db->from('tb_paciente p');
        $this->db->where("p.paciente_id", $paciente_id);
        $paciente_inf = $this->db->get()->result();

        $this->db->select('valor_total');
        $this->db->from('tb_agenda_exames ae');
        $this->db->where("ae.agenda_exames_id", $agenda_exames_id);
        $valor_exame = $this->db->get()->result();

        $this->db->select('forma_pagamento_id');
        $this->db->from('tb_forma_pagamento fp');
        $this->db->where("fp.nome", 'DINHEIRO');
        $dinheiro = $this->db->get()->result();
        // var_dump($dinheiro); die;
        // if($valor_exame[0]->valor_total == 0.00){
        //     // die;
        //     $this->db->set('data_faturamento', $horario);
        //     $this->db->set('operador_faturamento', $operador_id);
        //     $this->db->set('valor1', 0);
        //     $this->db->set('faturado', 't');
        //     $this->db->set('forma_pagamento', $dinheiro[0]->forma_pagamento_id);
        // }
//            var_dump($atendimentos); die;
        if (count($atendimentos) > 0) {
            $primeiro_atendimento = 'f';
        } else {
            $primeiro_atendimento = 't';
        }

        $this->db->select('ppmc.dia_recebimento, ppmc.tempo_recebimento');
        $this->db->from('tb_procedimento_percentual_medico ppm');
        $this->db->join("tb_procedimento_percentual_medico_convenio ppmc", "ppmc.procedimento_percentual_medico_id = ppm.procedimento_percentual_medico_id");
        $this->db->where("ppm.procedimento_tuss_id", $procedimento_tuss_id);
        $this->db->where("ppmc.medico", $medico);
        $this->db->where("ppmc.ativo", 't');
        $this->db->where("ppm.ativo", 't');
        $retorno = $this->db->get()->result();

//            echo "<pre>"; var_dump($retorno); die;
        if (count($retorno) > 0 && @$retorno[0]->dia_recebimento != '' && @$retorno[0]->tempo_recebimento != '') {
            if (date("d") > $retorno[0]->dia_recebimento) {
                $d = date("Y-m-", strtotime("+1 month")) . $retorno[0]->dia_recebimento;
                $dataProducao = date("Y-m-d", strtotime("+" . $retorno[0]->tempo_recebimento . " days", strtotime($d)));
            } else {
                $d = date("Y-m-") . $retorno[0]->dia_recebimento;
                $dataProducao = date("Y-m-d", strtotime("+" . $retorno[0]->tempo_recebimento . " days", strtotime($d)));
            }
        } else {
            $dataProducao = $data;
        }

//                $this->db->set('ativo', 'f');
//                $this->db->where('exame_sala_id', $_POST['txtsalas']);
//                $this->db->update('tb_exame_sala');

        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('paciente_id', $paciente_id);

        $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
        $this->db->set('guia_id', $guia_id);
        $this->db->set('tipo', $tipo);
        $this->db->set('agenda_exames_id', $agenda_exames_id);
        $this->db->set('sala_id', $sala_id);
        if ($medico != "") {
            $this->db->set('medico_realizador', $medico);
        }

        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_exames');
        $exames_id = $this->db->insert_id();

        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('data', $data);
        if (count($paciente_inf) > 0) {
            $this->db->set('toten_senha_id', $paciente_inf[0]->toten_senha_id);
            $this->db->set('toten_fila_id', $paciente_inf[0]->toten_fila_id);
            $this->db->set('senha ', $paciente_inf[0]->senha);
            $this->db->set('data_senha', $paciente_inf[0]->data_senha);
        }

        $this->db->set('data_producao', $dataProducao);
        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
        $this->db->set('exame_id', $exames_id);
        $this->db->set('guia_id', $guia_id);
        $this->db->set('tipo', $tipo);
        $this->db->set('primeiro_atendimento', $primeiro_atendimento);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        if ($medico != "") {
            $this->db->set('medico_parecer1', $medico);
        }
//        $this->db->set('id_chamada', $_POST['idChamada']);
        $this->db->insert('tb_ambulatorio_laudo');
        $laudo_id = $this->db->insert_id();

        if ($medico != "") {
            $this->db->set('medico_consulta_id', $medico);
            $this->db->set('medico_agenda', $medico);
        }
        if ($valor_exame[0]->valor_total == 0.00) {
            // die;
            $this->db->set('data_faturamento', $horario);
            $this->db->set('operador_faturamento', $operador_id);
            $this->db->set('valor1', 0);
            $this->db->set('faturado', 't');
            $this->db->set('forma_pagamento', $dinheiro[0]->forma_pagamento_id);
        }
        $this->db->set('cancelada', 'false');
        $this->db->set('realizada', 'true');
        $this->db->set('senha', md5($exame_id));
        $this->db->set('data_realizacao', $horario);
        $this->db->set('operador_realizacao', $operador_id);

        $this->db->set('agenda_exames_nome_id', $sala_id);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');

        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('agenda_exames_id', $agenda_exames_id);
        $this->db->set('sala_id', $sala_id);
        $this->db->set('paciente_id', $paciente_id);
        $this->db->insert('tb_ambulatorio_chamada');

        return true;
    }


    function gravarRiscoCirurgico($paciente_id, $questionario){
        $horario = date("Y-m-d H:i:s");

        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('questionario', json_encode($questionario));
        $this->db->set('data_cadastro', $horario);
        // $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_paciente_risco_cirurgico');
        // $operador_id = $this->db->insert_id();
        return array('1');

    }

    function gravaralertamedico($medico_id, $mensagem){
        $horario = date("Y-m-d H:i:s");

        $this->db->set('texto', $mensagem);
        $this->db->set('operador_destino', $medico_id);
        $this->db->set('empresa_id', null);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', 1);
        $this->db->insert('tb_empresa_lembretes');
        // $operador_id = $this->db->insert_id();
        return array('1');

    }

    function gravarPesquisaSatisfacao($paciente_id, $questionario){
        $horario = date("Y-m-d H:i:s");

        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('questionario', json_encode($questionario));
        $this->db->set('data_cadastro', $horario);
        // $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_paciente_pesquisa_satisfacao');
        // $operador_id = $this->db->insert_id();
        return array('1');

    }

    function buscarLembreteNaoLido() {
        
        $operador_id = $_GET['operador_id'];
//        var_dump($operador_id); die;
        $this->db->select('empresa_lembretes_id,
                            texto,
                            empresa_id,
                            o.nome as operador');
        $this->db->from('tb_empresa_lembretes el');
        $this->db->join('tb_operador o', 'o.operador_id = el.operador_cadastro', 'left');
        $this->db->where('el.ativo', 't');
        $this->db->where('operador_destino', $operador_id);
        $this->db->where('(
                            SELECT COUNT(*) 
                            FROM ponto.tb_empresa_lembretes_visualizacao 
                            WHERE ponto.tb_empresa_lembretes_visualizacao.empresa_lembretes_id = el.empresa_lembretes_id 
                            AND ponto.tb_empresa_lembretes_visualizacao.operador_visualizacao = ' . $operador_id . '
                        ) =', 0);
        $return = $this->db->get();
        $retorno = $return->result();
        
        foreach($retorno as $value){
            
            $empresa_id = $value->empresa_id;
            $horario = date("Y-m-d H:i:s");

            $this->db->set('empresa_lembretes_id', $value->empresa_lembretes_id);
            $this->db->set('data_visualizacao', $horario);
            $this->db->set('operador_visualizacao', $operador_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->insert('tb_empresa_lembretes_visualizacao');
            
        }
        
        return $retorno;
    }

    function validaUsuario() {
        $this->db->select('operador_id');
        $this->db->from('tb_operador');
        $this->db->where('usuario', $_GET['usuario']);
        $this->db->where('senha', md5($_GET['pw']));
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function buscandoAgenda($operador_id, $paciente, $situacao, $data) {
        ini_set('display_errors',1);
        ini_set('display_startup_erros',1);
        error_reporting(E_ALL);
                
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.realizada,
                            ae.confirmado,
                            ae.data_atualizacao,
                            ae.operador_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.nome,
                            ae.observacoes,
                            ae.encaixe,
                            ae.chegada,
                            ae.procedimento_tuss_id,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            c.nome as convenio,
                            co.nome as convenio_paciente,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            e.situacao as situacaoexame,
                            tc.descricao as tipoconsulta,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo,
                            tel.nome as telefonema_operador');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->join('tb_operador tel', 'tel.operador_id = ae.operador_telefonema', 'left');
//        $this->db->where('ae.data', $dataAtual);
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("(ae.medico_consulta_id = $operador_id OR ae.medico_agenda = $operador_id)");
        
        if ($situacao != '') {
            
            switch ($situacao) {
                case 'o':
                    $sit = 'OK';
                    break;
                case 'l':
                    $sit = 'LIVRE';
                    break;
                case 'b':
                    $sit = 'BLOQUEADO';
                    break;
                case 'f':
                    $sit = 'FALTOU';
                    break;
                default:
                    break;
            }
            
            if (isset($sit)) {
                if ($sit == "BLOQUEADO") {
                    $this->db->where('ae.bloqueado', 't');
                }
                if ($sit == "LIVRE") {
                    $this->db->where('ae.bloqueado', 'f');
                    $this->db->where('ae.situacao', 'LIVRE');
                }
                if ($sit == "OK") {
                    $this->db->where('ae.situacao', 'OK');
                }
                if ($sit == "FALTOU") {
                    date_default_timezone_set('America/Fortaleza');
                    $data_atual = date('Y-m-d');
                    $this->db->where('ae.data <', $data_atual);
                    $this->db->where('ae.situacao', 'OK');
                    $this->db->where('ae.realizada', 'f');
                    $this->db->where('ae.bloqueado', 'f');
                    $this->db->where('ae.operador_atualizacao is not null');
                }  
            }
        }

        if($data != ""){
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $data))) );
        }
        
        if($paciente != ""){
            $this->db->where('p.nome ilike', "%" . $paciente . "%");
        }
        
        $this->db->orderby('ae.agenda_exames_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorarioscalendario($operador_id, $paciente) {
//        ini_set('display_errors',1);
//        ini_set('display_startup_erros',1);
//        error_reporting(E_ALL);
//                
        $data_passado = date('Y-m-d', strtotime("-1 year", strtotime(date('Y-m-d'))));
        $data_futuro = date('Y-m-d', strtotime("+1 year", strtotime(date('Y-m-d'))));
        
        $this->db->select('ae.data, count(ae.data) as contagem, ae.situacao, ae.medico_agenda as medico');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->where("ae.data is not null");
        $this->db->where('ae.bloqueado', 'f');
        $this->db->where("(ae.situacao = 'LIVRE' OR ae.situacao = 'OK')");
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.medico_consulta_id', $operador_id);
        $this->db->where("ae.data >", $data_passado);
        $this->db->where("ae.data <", $data_futuro);
        
        if($paciente != ""){
            $this->db->where('p.nome ilike', "%" . $paciente . "%");
        }
        $this->db->groupby("ae.data, ae.situacao, ae.medico_agenda");
        $this->db->orderby("ae.data, ae.situacao");
        $return = $this->db->get();
        return $return->result();
    }
    
    function buscarHistoricoPaciente() {
        
        $agenda_exames_id = $_GET['agenda_exames_id'];
        
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            c.nome as convenio,
                            a.medico_consulta_id,
                            a.procedimento_tuss_id,
                            pt.nome as procedimento,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("a.confirmado", 'true');
        $this->db->where("a.paciente_id = (SELECT paciente_id FROM ponto.tb_agenda_exames WHERE agenda_exames_id = {$agenda_exames_id} LIMIT 1) ");
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $return = $this->db->get();
        
        return $return->result();
    }
    
    function buscarQuantidadeAtendimentos($operador_id) {
                
        $this->db->select('ae.telefonema, 
                           o.nome as medico,
                           ae.inicio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.paciente_id IS NOT NULL');
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.data', date("Y-m-d", strtotime("+1 day")) );
        $this->db->where('ae.medico_consulta_id', $operador_id);
        $this->db->orderby('ae.inicio');
        
        $return = $this->db->get();
        
        return $return->result();
    }
    
    function confirmarAtendimento(){
        $operador_id = $_GET['operador_id'];
        $resposta = $_GET['value'];
        $data = date("Y-m-d", strtotime("+1 day"));
        
        $this->db->set("confirmacao_medico", $resposta);
        $this->db->where("data", $data);
        $this->db->where("medico_consulta_id", $operador_id);
        $this->db->update("tb_agenda_exames");
        
    }

    function listarLaudosNaoCriados($string) {
        $this->db->select('al.ambulatorio_laudo_id, al.exame_id, e.sala_id');
        $this->db->from('tb_ambulatorio_laudo al');
        $this->db->join('tb_exames e', 'e.exames_id = al.exame_id');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id');
        $this->db->where("al.situacao", "FINALIZADO");
        if($string != ''){
            $this->db->where("al.ambulatorio_laudo_id NOT IN ($string)");
        }
        $this->db->where("pc.convenio_id = 108");
        
        $this->db->where("al.data >= '2018-02-28'");
        $this->db->where("al.data <= '2018-03-27'");
        $return = $this->db->get();
        return $return->result();
    }
    
  function envia_mensagem(){
        date_default_timezone_set('America/Fortaleza');
        header('Access-Control-Allow-Origin: *');
        $array = Array("status"=>200);
        $value = json_encode($_GET);
    if (count($_GET) == 0 || @$_GET['medico_id'] == ""  || @$_GET['mensagem'] == "" ) {
            if (@$_GET['medico_id'] == "") {
                    $erro = "MEDICO VAZI0";
            }elseif(@$_GET['mensagem'] == ""){
               $erro = "MENSAGEM VAZIA";
            }else{                
            }
            $arrayErro = Array("status"=>"erro","mensagem"=>$erro);
            echo json_encode($arrayErro);
    }else{
        try {
        $this->db->set('data_cadastro',date('Y-m-d H:i:s'));
        $this->db->set('de',$_GET['medico_id']);
        $this->db->set('mensagem',$_GET['mensagem']);	
        $this->db->set('postAPI',$value);
        $this->db->insert('tb_mensagem');
        echo json_encode($array);
        } catch (Exception $e) {
           echo json_encode($e);
        }
    }
}



     function listar_mensagens_chat(){
        header('Access-Control-Allow-Origin: *');
            $medico = @$_GET['medico_id'];
        if ($medico  == "") {
            $array = Array("status"=>"erro","mensagem"=>"medico_id vazio");
            echo json_encode($array, JSON_PRETTY_PRINT);
        }else{
            $this->db->select('mensagem,data_cadastro as horario_mensagem,empresa');
            $this->db->from('tb_mensagem');
            $this->db->where("(de = '$medico' or para = '$medico')");
            $this->db->order_by("mensagem_id","desc");
            $return =  $this->db->get()->result();
            $array = Array("status"=>200,"data"=>$return);
            echo json_encode($array);
      } 
    }
                
     function gravarmensagemchat($medico_id=NULL){
        date_default_timezone_set('America/Fortaleza');
        $horario = date('Y-m-d H:i:s');
	$this->db->set('mensagem',$_POST['mensagem']);
        
        if ($_POST['grupos'][0] != "") {
          $this->db->set('grupo', $_POST['grupos'][0]); 
        }  
	$this->db->set('de',$_POST['meu_id']);
	if ($medico_id != "") {
		$this->db->set('para',$medico_id);
	}
	$this->db->set('empresa','t');
        $this->db->set('data_cadastro',$horario); 
	$this->db->insert('tb_mensagem');
    }
                
    function buscarOperadores(){
        $this->db->select('operador_id,grupo_agenda');
        $this->db->from('tb_operador');
        $this->db->where('perfil_id',4);
        $this->db->where('ativo','t');
        return $this->db->get()->result();
        
        
    }
    
             
    function relatorioRecebimentos2($json_post){
        $medico_id = $json_post->medico_id;
        $data_inicio = $json_post->data_inicio;
        $data_fim = $json_post->data_fim;
        $convenio_id = $json_post->convenio_id;
        $grupo_convenio_id = $json_post->agente_pagador_id;
        $procedimento_tuss_id = $json_post->procedimento_tuss_id;
        $grupo = $json_post->grupo;
        $this->db->select("ae.quantidade,
                            p.nome as paciente,
                            pt.nome as procedimento,
                            pc.procedimento_convenio_id,
                            ae.autorizacao,
                            ae.agenda_exames_id,
                            ae.percentual_medico,
                            ae.valor_medico,
                            ae.percentual_laboratorio,
                            ae.valor_laboratorio,
                            ae.laboratorio_id,
                            lab.nome as laboratorio,
                            ae.percentual_promotor,
                            ae.valor_promotor,
                            ae.desconto_ajuste1,
                            ae.desconto_ajuste2,
                            ae.desconto_ajuste3,
                            ae.desconto_ajuste4,
                            ae.data,
                            ae.producao_paga,
                            ae.tipo_desconto,
                            al.data as data_laudo,
                            al.data_producao,
                            al.ambulatorio_laudo_id,
                            ae.data_antiga,
                            ae.sala_pendente,
                            e.situacao,
                            op.operador_id,
                            ae.valor,
                            ae.valor1,
                            ae.valor2,
                            ae.valor3,
                            ae.valor4,
                            ae.valor_total,
                            pc.procedimento_tuss_id,
                            al.medico_parecer1,
                            pt.grupo,
                            pt.perc_medico,
                            (
                                SELECT dia_recebimento 
                                FROM ponto.tb_procedimento_percentual_medico_convenio ppmc
                                INNER JOIN ponto.tb_procedimento_percentual_medico ppm 
                                ON ppm.procedimento_percentual_medico_id = ppmc.procedimento_percentual_medico_id
                                WHERE ppm.procedimento_tuss_id = ae.procedimento_tuss_id
                                AND ppm.ativo = 't'
                                AND ppmc.ativo = 't'
                                AND ppmc.medico = al.medico_parecer1
                                ORDER BY ppmc.data_cadastro DESC
                                LIMIT 1
                            ) as dia_recebimento,
                            (
                                SELECT tempo_recebimento 
                                FROM ponto.tb_procedimento_percentual_medico_convenio ppmc
                                INNER JOIN ponto.tb_procedimento_percentual_medico ppm 
                                ON ppm.procedimento_percentual_medico_id = ppmc.procedimento_percentual_medico_id
                                WHERE ppm.procedimento_tuss_id = ae.procedimento_tuss_id
                                AND ppm.ativo = 't'
                                AND ppmc.ativo = 't'
                                AND ppmc.medico = al.medico_parecer1
                                ORDER BY ppmc.data_cadastro DESC
                                LIMIT 1
                            ) as tempo_recebimento,
                            al.situacao as situacaolaudo,
                            tu.classificacao,
                            o.nome as revisor,
                            op.taxa_administracao,
                            pt.percentual,
                            op.nome as medico,
                            op.taxaadm_perc,
                            op.piso_medico,
                            pi.nome as indicacao,
                            ops.nome as medicosolicitante,
                            c.nome as convenio,
                            c.iss,
                            ae.valor1,
                            ae.forma_pagamento as forma_pagamento1,
                            ae.forma_pagamento2,
                            ae.valor2,
                            ae.forma_pagamento3,
                            ae.valor3,
                            ae.numero_sessao,
                            ae.forma_pagamento4,
                            ae.valor4,
                            f.nome as forma_pagamento_1,
                            f.cartao as cartao1,
                            f2.nome as forma_pagamento_2,
                            f2.cartao as cartao2,
                            f3.nome as forma_pagamento_3,
                            f3.cartao as cartao3,
                            f4.nome as forma_pagamento_4,
                            f4.cartao as cartao4 ");
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = ae.indicacao', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_laboratorio lab', 'lab.laboratorio_id = ae.laboratorio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer2', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_operador ops', 'ops.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio_grupo cg', 'cg.convenio_grupo_id = c.convenio_grupo_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->join('tb_forma_pagamento f2', 'f2.forma_pagamento_id = ae.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento f3', 'f3.forma_pagamento_id = ae.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento f4', 'f4.forma_pagamento_id = ae.forma_pagamento4', 'left');
//        $this->db->join('tb_agenda_exames_faturar aef', 'aef.agenda_exames_id = ae.agenda_exames_id', 'left');
//        $this->db->where('aef.ativo','t');
        $this->db->where('e.cancelada', 'false');
//        $this->db->where('ae.valor_medico is not null');
        $this->db->where('ae.paciente_id is not null');
        $this->db->where('ae.producao_paga','t');
        $this->db->where('pt.home_care', 'f');

        $this->db->where("al.data_producao >=", $data_inicio);
        $this->db->where("al.data_producao <=", $data_fim);
        
        
        if($convenio_id > 0){
            $this->db->where("pc.convenio_id", $convenio_id);
        }
        if($procedimento_tuss_id > 0){
            $this->db->where("pc.procedimento_tuss_id", $procedimento_tuss_id);
        }
        if($grupo_convenio_id > 0){
            $this->db->where("c.convenio_grupo_id", $grupo_convenio_id);
        }
        if($grupo != ''){
            $this->db->where("pt.grupo", $grupo);
        }
        $this->db->where("al.medico_parecer1", $medico_id);
        $this->db->orderby('al.medico_parecer1');
        $this->db->orderby('ae.data');
        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.paciente_id');

        $return = $this->db->get();
        return $return->result();

    }
    
    
    function relatorioRecebimentos3($json_post){
        $medico_id = $json_post->medico_id;
        $data_inicio = $json_post->data_inicio;
        $data_fim = $json_post->data_fim;
        $convenio_id = $json_post->convenio_id;
        $grupo_convenio_id = $json_post->agente_pagador_id;
        $procedimento_tuss_id = $json_post->procedimento_tuss_id;
        $grupo = $json_post->grupo;
        $this->db->select("ae.quantidade,
                            p.nome as paciente,
                            pt.nome as procedimento,
                            pc.procedimento_convenio_id,
                            ae.autorizacao,
                            ae.agenda_exames_id,
                            ae.percentual_medico,
                            ae.valor_medico,
                            ae.percentual_laboratorio,
                            ae.valor_laboratorio,
                            ae.laboratorio_id,
                            lab.nome as laboratorio,
                            ae.percentual_promotor,
                            ae.valor_promotor,
                            ae.desconto_ajuste1,
                            ae.desconto_ajuste2,
                            ae.desconto_ajuste3,
                            ae.desconto_ajuste4,
                            ae.data,
                            ae.producao_paga,
                            ae.tipo_desconto,
                            al.data as data_laudo,
                            al.data_producao,
                            al.ambulatorio_laudo_id,
                            ae.data_antiga,
                            ae.sala_pendente,
                            e.situacao,
                            op.operador_id,
                            ae.valor,
                            ae.valor1,
                            ae.valor2,
                            ae.valor3,
                            ae.valor4,
                            ae.valor_total,
                            pc.procedimento_tuss_id,
                            al.medico_parecer1,
                            pt.grupo,
                            pt.perc_medico,
                            (
                                SELECT dia_recebimento 
                                FROM ponto.tb_procedimento_percentual_medico_convenio ppmc
                                INNER JOIN ponto.tb_procedimento_percentual_medico ppm 
                                ON ppm.procedimento_percentual_medico_id = ppmc.procedimento_percentual_medico_id
                                WHERE ppm.procedimento_tuss_id = ae.procedimento_tuss_id
                                AND ppm.ativo = 't'
                                AND ppmc.ativo = 't'
                                AND ppmc.medico = al.medico_parecer1
                                ORDER BY ppmc.data_cadastro DESC
                                LIMIT 1
                            ) as dia_recebimento,
                            (
                                SELECT tempo_recebimento 
                                FROM ponto.tb_procedimento_percentual_medico_convenio ppmc
                                INNER JOIN ponto.tb_procedimento_percentual_medico ppm 
                                ON ppm.procedimento_percentual_medico_id = ppmc.procedimento_percentual_medico_id
                                WHERE ppm.procedimento_tuss_id = ae.procedimento_tuss_id
                                AND ppm.ativo = 't'
                                AND ppmc.ativo = 't'
                                AND ppmc.medico = al.medico_parecer1
                                ORDER BY ppmc.data_cadastro DESC
                                LIMIT 1
                            ) as tempo_recebimento,
                            al.situacao as situacaolaudo,
                            tu.classificacao,
                            o.nome as revisor,
                            op.taxa_administracao,
                            pt.percentual,
                            op.nome as medico,
                            op.taxaadm_perc,
                            op.piso_medico,
                            pi.nome as indicacao,
                            ops.nome as medicosolicitante,
                            c.nome as convenio,
                            c.iss,
                            ae.valor1,
                            ae.forma_pagamento as forma_pagamento1,
                            ae.forma_pagamento2,
                            ae.valor2,
                            ae.forma_pagamento3,
                            ae.valor3,
                            ae.numero_sessao,
                            ae.forma_pagamento4,
                            ae.valor4,
                            f.nome as forma_pagamento_1,
                            f.cartao as cartao1,
                            f2.nome as forma_pagamento_2,
                            f2.cartao as cartao2,
                            f3.nome as forma_pagamento_3,
                            f3.cartao as cartao3,
                            f4.nome as forma_pagamento_4,
                            f4.cartao as cartao4 ");
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = ae.indicacao', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_laboratorio lab', 'lab.laboratorio_id = ae.laboratorio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer2', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_operador ops', 'ops.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio_grupo cg', 'cg.convenio_grupo_id = c.convenio_grupo_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->join('tb_forma_pagamento f2', 'f2.forma_pagamento_id = ae.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento f3', 'f3.forma_pagamento_id = ae.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento f4', 'f4.forma_pagamento_id = ae.forma_pagamento4', 'left');
//        $this->db->join('tb_agenda_exames_faturar aef', 'aef.agenda_exames_id = ae.agenda_exames_id', 'left');
//        $this->db->where('aef.ativo','t');
        $this->db->where('e.cancelada', 'false');
//        $this->db->where('ae.valor_medico is not null');
        $this->db->where('ae.paciente_id is not null');
        $this->db->where("(ae.producao_paga = 'f' or ae.producao_paga is null)");
        $this->db->where('pt.home_care', 'f');

        $this->db->where("ae.data_faturar >=", $data_inicio);
        $this->db->where("ae.data_faturar <=", $data_fim);
                
        if($convenio_id > 0){
            $this->db->where("pc.convenio_id", $convenio_id);
        }
        if($procedimento_tuss_id > 0){
            $this->db->where("pc.procedimento_tuss_id", $procedimento_tuss_id);
        }
        if($grupo_convenio_id > 0){
            $this->db->where("c.convenio_grupo_id", $grupo_convenio_id);
        }
        if($grupo != ''){
            $this->db->where("pt.grupo", $grupo);
        }
        $this->db->where("al.medico_parecer1", $medico_id);
        $this->db->orderby('al.medico_parecer1');
        $this->db->orderby('ae.data');
        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.paciente_id');

        $return = $this->db->get();
        return $return->result();

    }
    
     function listardatashistorico($paciente_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select("distinct(to_char(ag.data_cadastro, 'YYYY-MM-DD')) as data_cadastro",false);
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo agr', 'agr.nome = pt.grupo', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
//      $this->db->where('age.paciente_id', $paciente_id);
        $this->db->where('p.prontuario_antigo', $paciente_id);
        $this->db->where("ag.cancelada", 'false');
        $this->db->orderby("to_char(ag.data_cadastro, 'YYYY-MM-DD') desc");
//        $this->db->orderby('ag.situacao');
//        $this->db->orderby('ag.data_cadastro');
        $return = $this->db->get()->result();
//      echo '<pre>';
//      var_dump($return); die;
        return $return;
    }
    
//      function listardatashistoricoantigo($paciente_id) { 
//        $empresa_id = $this->session->userdata('empresa_id');
//        $this->db->select("distinct(to_char(ag.data_cadastro, 'YYYY-MM-DD')) as data_cadastro",false);
//        $this->db->from('tb_ambulatorio_laudo_antigo ag'); 
//        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
////        $this->db->where('ag.paciente_id', $paciente_id);
//        $this->db->where('p.prontuario_antigo', $paciente_id);
//        $this->db->where("ag.cancelada", 'false');
//        $this->db->orderby("to_char(ag.data_cadastro, 'YYYY-MM-DD') desc");
//        $return = $this->db->get()->result(); 
//        return $return;
//    }
    
    
       function listarconsultahistoricodiferenciado($paciente_id,$data=NULL) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.data_cadastro as data_cadastro,
                            ag.situacao,
                            o.nome as medico,
                            ag.texto,
                            age.procedimento_tuss_id,
                            pt.nome as procedimento,
                            ag.medico_parecer1,
                            ae.agenda_exames_id,
                            c.nome as convenio,
                            age.agenda_exames_nome_id,
                            p.nome as paciente,
                            ag.texto,
                            ag.template_obj,
                            ae.exames_id,
                            p.nascimento,
                            p.paciente_id');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo agr', 'agr.nome = pt.grupo', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
//        $this->db->where('age.paciente_id', $paciente_id);
         $this->db->where('p.prontuario_antigo', $paciente_id);
       // $this->db->where('ag.ambulatorio_laudo_id !=', $ambulatorio_laudo_id);
        if($data != ""){
          $this->db->where('ag.data_cadastro >=', $data . " " . "00:00:00");
          $this->db->where('ag.data_cadastro <=', $data . " " . "23:59:59");
        }
//        $this->db->where('ag.empresa_id', $empresa_id);
        $this->db->where("(agr.tipo = 'CONSULTA' or agr.tipo = 'ESPECIALIDADE')"); 
        $this->db->where("ag.cancelada", 'false');
        $this->db->orderby('ag.data_cadastro desc');
        $this->db->orderby('ag.situacao');
        $this->db->orderby('ag.data');
        $return = $this->db->get()->result();
//        echo '<pre>';
//        var_dump($return); die;
        return $return;
    }
    
     function listarexamehistoricodiferenciado($paciente_id,$data=NULL) { 
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.data_cadastro as data_cadastro,
                            ag.situacao,
                            o.nome as medico,
                            ag.texto,
                            ae.exames_id,
                            age.procedimento_tuss_id,
                            pt.nome as procedimento,
                            ag.medico_parecer1,
                            ae.agenda_exames_id,
                            age.agenda_exames_nome_id,
                            p.nome as paciente,
                            agr.tipo as sabertipo,
                            p.paciente_id');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo agr', 'agr.nome = pt.grupo', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
//        $this->db->where('ae.paciente_id', $paciente_id);
            $this->db->where('p.prontuario_antigo', $paciente_id);
        if($data != ""){
         $this->db->where('ag.data_cadastro >=', $data . " " . "00:00:00");
         $this->db->where('ag.data_cadastro <=', $data . " " . "23:59:59");
        }
//       $this->db->where('ag.empresa_id', $empresa_id);
        $this->db->where("(agr.tipo = 'EXAME')"); 
        $this->db->where("ag.cancelada", 'false');
        $this->db->orderby('ag.data_cadastro desc');
        $this->db->orderby('ag.situacao');
        $this->db->orderby('ag.data_cadastro');
        $return = $this->db->get();
        return $return->result();
    }
    
     function listarespecialidadehistoricodiferenciado($paciente_id,$data=NULL) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.data_cadastro,
                            ag.situacao,
                            o.nome as medico,
                            ag.texto,
                            ae.exames_id,
                            age.procedimento_tuss_id,
                            pt.nome as procedimento,
                            ag.medico_parecer1,
                            ae.agenda_exames_id,
                            age.agenda_exames_nome_id,
                            p.nome as paciente,
                            p.paciente_id');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo agr', 'agr.nome = pt.grupo', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
//        $this->db->where('ae.paciente_id', $paciente_id);
            $this->db->where('p.prontuario_antigo', $paciente_id);
        if($data != ""){
            $this->db->where('ag.data_cadastro >=', $data . " " . "00:00:00");
            $this->db->where('ag.data_cadastro <=', $data . " " . "23:59:59");
        }
//      $this->db->where('ag.empresa_id', $empresa_id);
        $this->db->where("(agr.tipo = 'ESPECIALIDADE' or ae.tipo = 'ESPECIALIDADE')");
        $this->db->where("ag.cancelada", 'false');
        $this->db->orderby('ag.data_cadastro desc');
        $this->db->orderby('ag.situacao');
        $this->db->orderby('ag.data_cadastro');
        $return = $this->db->get();
        return $return->result();
    }
    
    
      function listarreceita($paciente_id,$data=NULL) {

        $this->db->select(' ag.ambulatorio_receituario_id,
                            ag.texto,
                            ag.data_cadastro,
                            ag.medico_parecer1,
                            al.cabecalho,
                            o.nome as medico,
                            o.operador_id,
                            ag.especial,
                            pt.nome as procedimento,
                            al.ambulatorio_laudo_id,
                            p.prontuario_antigo,
                            pt.grupo
                            ');
        $this->db->from('tb_ambulatorio_receituario ag');
        $this->db->join('tb_ambulatorio_laudo al', 'al.ambulatorio_laudo_id = ag.laudo_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = al.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
//        $this->db->where('al.paciente_id', $paciente_id);
        $this->db->where('p.prontuario_antigo', $paciente_id);
        $this->db->where('ag.tipo', 'NORMAL');
        if($data != ""){
           $this->db->where('ag.data_cadastro >=', $data . " " . "00:00:00");
           $this->db->where('ag.data_cadastro <=', $data . " " . "23:59:59");
        }
        $this->db->orderby('ag.data_cadastro DESC');

        $return = $this->db->get();
        return $return->result();
    }
    
      function listarreceitaprocedimentos($ambulatorio_laudo_id) {

        $this->db->select(' ag.ambulatorio_receituario_id,
                            ag.texto,
                            ag.data_cadastro,
                            ag.medico_parecer1,
                            al.cabecalho,
                            o.nome as medico,
                            o.operador_id,
                            ag.especial,
                            pt.nome as procedimento,
                            al.ambulatorio_laudo_id,
                            p.prontuario_antigo,
                            pt.grupo
                            ');
        $this->db->from('tb_ambulatorio_receituario ag');
        $this->db->join('tb_ambulatorio_laudo al', 'al.ambulatorio_laudo_id = ag.laudo_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = al.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
//        $this->db->where('al.paciente_id', $paciente_id);
        $this->db->where('al.ambulatorio_laudo_id', $ambulatorio_laudo_id);
        $this->db->where('ag.tipo', 'NORMAL');
                
        $this->db->orderby('ag.data_cadastro DESC');

        $return = $this->db->get();
        return $return->result();
    }


    function listarinformaçõesinternacao($paciente_id){
        $this->db->select('i.internacao_id,
                            i.paciente_id,
                            m.nome as medico,
                            i.data_internacao,
                            pt.nome as procedimento,
                            il.nome as leito,
                           ie.nome as enfermaria,
                           iu.nome as unidade');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_operador m', 'm.operador_id = i.medico_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'il.enfermaria_id = ie.internacao_enfermaria_id', 'left');
        $this->db->join('tb_internacao_unidade iu', 'ie.unidade_id = iu.internacao_unidade_id', 'left');
        $this->db->where('i.ativo', 't');
        $this->db->where('i.paciente_id', $paciente_id);

        return $this->db->get()->result();

    }

    function listarevolucoesinternacao($internacao_id){
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
                           ie.particular');
        $this->db->from('tb_internacao_evolucao ie');
        $this->db->join('tb_internacao i', "i.internacao_id = ie.internacao_id", 'left');
        $this->db->join('tb_paciente p', "i.paciente_id = p.paciente_id", 'left');
        $this->db->join('tb_operador o', "ie.operador_cadastro = o.operador_id", 'left');
        $this->db->join('tb_procedimento_convenio pc', "pc.procedimento_convenio_id = ie.procedimento_tuss_id", 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("ie.internacao_id = $internacao_id");
        $this->db->where("ie.ativo", 't');
        $this->db->orderby("ie.internacao_evolucao_id");
        $return = $this->db->get();
        return $return->result();
    }

    function listarunidade(){
        $this->db->select('nome,
                internacao_unidade_id');
        $this->db->from('tb_internacao_unidade');
        $this->db->where('ativo', 't');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }


    function listaenfermariaunidade($unidade) {

        $this->db->select('nome,
                           internacao_enfermaria_id,
                           tipo,
                           ativo');
        $this->db->from('tb_internacao_enfermaria');
        $this->db->where('unidade_id', $unidade);
        $return = $this->db->get();
        return $return->result();
    }

    function listaleitounidade($internacao_enfermaria_id) {
        $this->db->select('il.internacao_leito_id,
                           il.nome,
                           il.tipo,
                           il.condicao,
                           il.enfermaria_id,
                           il.ativo,
                           i.internacao_id');
        $this->db->from('tb_internacao_leito il');
        $this->db->join('tb_internacao i', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->where('il.excluido', 'f');
        $this->db->where('il.condicao !=', 'Cirurgico');
        $this->db->where('il.enfermaria_id', $internacao_enfermaria_id);
        $return = $this->db->get();
        return $return->result();
    }

    function gravarevolucao($convenio_id, $txtdiagnostico, $internacao_id,  $procedimento_tuss_id, $valor, $operador_cadastro){
        $horario = date("Y-m-d H:i:s");
        $data = date('Y-m-d');

        $this->db->select('dinheiro');
        $this->db->from('tb_convenio');
        $this->db->where('convenio_id', $convenio_id);
        $convenio = $this->db->get()->result();

        $this->db->set('diagnostico', $txtdiagnostico);
        $this->db->set('internacao_id', $internacao_id);

        $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
        $this->db->set('convenio_id', $convenio_id);
        $this->db->set('valor', $valor);
        $this->db->set('data', $data);
        // $this->db->set('empresa_id', $this->session->userdata('empresa_id'));
        $this->db->set('particular', $convenio[0]->dinheiro);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_cadastro);
        $this->db->insert('tb_internacao_evolucao');

        return $this->db->insert_id();
    }

    function listarconveniosevolucao($empresa_id){
        $this->db->select(' c.convenio_id,
                            c.nome,
                            c.dinheiro,
                            c.conta_id');
        $this->db->from('tb_convenio c');
        $this->db->join('tb_convenio_empresa ce', 'ce.convenio_id = c.convenio_id', 'left');
        $this->db->where('c.convenio_id IN (SELECT convenio_id FROM ponto.tb_procedimento_convenio WHERE ativo = TRUE)');
        $this->db->where("c.ativo", 'true');
        $this->db->where("ce.empresa_id", $empresa_id);
        $this->db->where("ce.ativo", 'true');
        $this->db->orderby("c.nome");
        $query = $this->db->get();
        $return = $query->result();

        return $return;
    }

    function listarprocedimentosconveniointernacao($convenio_id) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.codigo,
                            pt.nome as procedimento,
                            pc.valortotal');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $convenio_id);
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }
    
}

?>
