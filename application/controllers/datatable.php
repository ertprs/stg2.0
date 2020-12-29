
<?php

class Datatable extends Controller {

    function Datatable() {

        parent::Controller();
        $this->load->model('ponto/funcao_model', 'funcao');
        $this->load->model('ponto/funcionario_model', 'funcionario');
        $this->load->model('ponto/ocorrenciatipo_model', 'ocorrenciatipo');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('ambulatorio/procedimentoplano_model', 'procedimentoplano');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('ambulatorio/exametemp_model', 'exametemp');
        $this->load->model('ambulatorio/exame_model', 'exame');
        $this->load->model('estoque/fornecedor_model', 'fornecedor_m');
        $this->load->model('estoque/produto_model', 'produto_m');
        $this->load->model('estoque/nota_model', 'nota');
        $this->load->model('estoque/armazem_model', 'armazem');
        $this->load->model('ambulatorio/laudo_model', 'laudo');
        $this->load->model('ponto/cargo_model', 'cargo');
        $this->load->model('ponto/setor_model', 'setor');
        $this->load->model('cadastro/paciente_model', 'paciente_m');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('cadastro/contaspagar_model', 'contaspagar');
        $this->load->model('cadastro/classe_model', 'financeiro_classe');
        $this->load->model('cadastro/forma_model', 'forma');
        $this->load->model('cadastro/nivel2_model', 'nivel2');
        $this->load->model('cadastro/tipo_model', 'tipo');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('emergencia/solicita_acolhimento_model', 'solicita_acolhimento_m');
        $this->load->model('internacao/internacao_model', 'internacao_m');
        $this->load->model('internacao/unidade_model', 'unidade_m');
        $this->load->model('internacao/enfermaria_model', 'enfermaria_m');
        $this->load->model('internacao/leito_model', 'leito_m');
        $this->load->model('ponto/horariostipo_model', 'horariostipo');
        $this->load->model('cadastro/formapagamento_model', 'formapagamento');
        $this->load->model('cadastro/classe_model', 'financeiro_classe');
        $this->load->model('estoque/menu_model', 'menu');
        $this->load->model('centrocirurgico/centrocirurgico_model', 'centrocirurgico');
        $this->load->model('ambulatorio/saudeocupacional_model', 'saudeocupacional');

        $this->load->library('utilitario');
    }

        function listartcd($paciente_id){
            $result = $this->exametemp->listartcd2($paciente_id);

            foreach($result as $item){
                $arrayresultado['nome'] = $item->nome;
                $arrayresultado['valor'] = $item->valor;
                $arrayresultado['data'] = date('d/m/Y',strtotime($item->data));
                $arrayresultado['paciente_id'] = $item->paciente_id;
                $arrayresultado['observacao'] = $item->observacao;
                $arrayresultado['orcamento_id'] = $item->orcamento_id;
                $arrayresultado['confirmado'] = $item->confirmado;
                $arrayresultado['guia_id_modelo2'] = $item->guia_id_modelo2;
                $arrayresultado['detalhe'] = "<a class='btn btn-outline-success btn-round btn-sm' onclick='abrirModal($item->paciente_tcd_id)'><b>Opções</b></a>";


                $arrayAjax[] = $arrayresultado;
            }
            $obj = new stdClass();
            $obj->data = $arrayAjax;
            echo json_encode($obj);
        }


        function listartcdusados($paciente_id){
            $result = $this->exametemp->listartcdusados2($paciente_id);

            foreach($result as $item){
                $arrayresultado['nome'] = $item->nome;
                $arrayresultado['valor'] = number_format($item->valor * -1, 2, ",", "");
                $arrayresultado['data'] = date('d/m/Y',strtotime($item->data));
                $arrayresultado['paciente_id'] = $item->paciente_id;
                $arrayresultado['observacao'] = $item->observacao;
                $arrayresultado['orcamento_id'] = $item->orcamento_id;
                $arrayresultado['data_cadastro'] = $item->data_cadastro;
                $arrayresultado['operador_cadastro'] = $item->operador_cadastro;
                $arrayresultado['agenda_exames_id'] = $item->agenda_exames_id;

                $arrayAjax[] = $arrayresultado;
            }   

            $obj = new stdClass();
            $obj->data = $arrayAjax;
            echo json_encode($obj);
        }

    }