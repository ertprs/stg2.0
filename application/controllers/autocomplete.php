<?php

class Autocomplete extends Controller {

    function Autocomplete() {

        parent::Controller();
//        if ($this->session->userdata('autenticado') != true) {
//            redirect(base_url() . "login/index/login004", "refresh");
//        }
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

    function index() {
//        $this->listarhorariosmultiempresa();
    }

    function horariosambulatorio() {
        $_GET['teste'] = date("Y-m-d", strtotime(str_replace("/", "-", $_GET['teste'])));

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarautocompletehorarios($_GET['exame'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarautocompletehorarios();
        }
        echo json_encode($result);
    }

    function horariosambulatorioexamereagendar() {
        $_GET['teste'] = date("Y-m-d", strtotime(str_replace("/", "-", $_GET['teste'])));

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarautocompletehorariosexame($_GET['exame'], $_GET['teste'],@$_GET['empresa_id']);
        } else {
            $result = $this->exametemp->listarautocompletehorariosexame();
        }
        echo json_encode($result);
    }

    function testeDeConversaoArrayXML(){
        $string = '';
        $xml = '<ans:guiaResumoInternacao>
        <ans:cabecalhoGuia>
          <ans:registroANS>317144</ans:registroANS>
          <ans:numeroGuiaPrestador>126659518</ans:numeroGuiaPrestador>
        </ans:cabecalhoGuia>
        <ans:numeroGuiaSolicitacaoInternacao>126659518</ans:numeroGuiaSolicitacaoInternacao>
        <ans:dadosAutorizacao>
          <ans:numeroGuiaOperadora>126659518</ans:numeroGuiaOperadora>
          <ans:dataAutorizacao>2020-02-22</ans:dataAutorizacao>
          <ans:senha>126659518</ans:senha>
        </ans:dadosAutorizacao>
        <ans:dadosBeneficiario>
          <ans:numeroCarteira>9790020053574260</ans:numeroCarteira>
          <ans:atendimentoRN>N</ans:atendimentoRN>
          <ans:nomeBeneficiario>MARIA REJANE DE SOUZA</ans:nomeBeneficiario>
        </ans:dadosBeneficiario>
        <ans:dadosExecutante>
          <ans:contratadoExecutante>
            <ans:codigoPrestadorNaOperadora>11005120</ans:codigoPrestadorNaOperadora>
            <ans:nomeContratado>INSTITUTO DE OFTALM. E OTORRINOLARIG. DE FORTALEZA</ans:nomeContratado>
          </ans:contratadoExecutante>
          <ans:CNES>3030849</ans:CNES>
        </ans:dadosExecutante>
        <ans:dadosInternacao>
          <ans:caraterAtendimento>1</ans:caraterAtendimento>
          <ans:tipoFaturamento>4</ans:tipoFaturamento>
          <ans:dataInicioFaturamento>2020-02-22</ans:dataInicioFaturamento>
          <ans:horaInicioFaturamento>16:47:03</ans:horaInicioFaturamento>
          <ans:dataFinalFaturamento>2020-02-23</ans:dataFinalFaturamento>
          <ans:horaFinalFaturamento>14:58:31</ans:horaFinalFaturamento>
          <ans:tipoInternacao>2</ans:tipoInternacao>
          <ans:regimeInternacao>1</ans:regimeInternacao>
        </ans:dadosInternacao>
        <ans:dadosSaidaInternacao>
          <ans:diagnostico>J342</ans:diagnostico>
          <ans:indicadorAcidente>9</ans:indicadorAcidente>
          <ans:motivoEncerramento>12</ans:motivoEncerramento>
        </ans:dadosSaidaInternacao>
        <ans:procedimentosExecutados>
          <ans:procedimentoExecutado>
            <ans:dataExecucao>2020-02-22</ans:dataExecucao>
            <ans:procedimento>
              <ans:codigoTabela>00</ans:codigoTabela>
              <ans:codigoProcedimento>58991530</ans:codigoProcedimento>
              <ans:descricaoProcedimento>PACOTE SEPTOPLASTIA VIA ENDOSCOPICA ENF</ans:descricaoProcedimento>
            </ans:procedimento>
            <ans:quantidadeExecutada>1</ans:quantidadeExecutada>
            <ans:reducaoAcrescimo>1.00</ans:reducaoAcrescimo>
            <ans:valorUnitario>1642.62</ans:valorUnitario>
            <ans:valorTotal>1642.62</ans:valorTotal>
          </ans:procedimentoExecutado>
          <ans:procedimentoExecutado>
            <ans:dataExecucao>2020-02-22</ans:dataExecucao>
            <ans:procedimento>
              <ans:codigoTabela>00</ans:codigoTabela>
              <ans:codigoProcedimento>58991549</ans:codigoProcedimento>
              <ans:descricaoProcedimento>PACOTE SINUSECTOMIA ENDOSCOPIA NASAL ENF</ans:descricaoProcedimento>
            </ans:procedimento>
            <ans:quantidadeExecutada>1</ans:quantidadeExecutada>
            <ans:reducaoAcrescimo>1.00</ans:reducaoAcrescimo>
            <ans:valorUnitario>792.54</ans:valorUnitario>
            <ans:valorTotal>792.54</ans:valorTotal>
          </ans:procedimentoExecutado>
        </ans:procedimentosExecutados>
        <ans:valorTotal>
          <ans:valorProcedimentos>2435.16</ans:valorProcedimentos>
          <ans:valorTaxasAlugueis>118.78</ans:valorTaxasAlugueis>
          <ans:valorTotalGeral>2553.94</ans:valorTotalGeral>
        </ans:valorTotal>
        <ans:outrasDespesas>
          <ans:despesa>
            <ans:codigoDespesa>07</ans:codigoDespesa>
            <ans:servicosExecutados>
              <ans:dataExecucao>2020-02-22</ans:dataExecucao>
              <ans:codigoTabela>18</ans:codigoTabela>
              <ans:codigoProcedimento>60024380</ans:codigoProcedimento>
              <ans:quantidadeExecutada>1</ans:quantidadeExecutada>
              <ans:unidadeMedida>036</ans:unidadeMedida>
              <ans:reducaoAcrescimo>1.00</ans:reducaoAcrescimo>
              <ans:valorUnitario>118.78</ans:valorUnitario>
              <ans:valorTotal>118.78</ans:valorTotal>
              <ans:descricaoProcedimento>TAXA DE VIDEO-CIRURGICO</ans:descricaoProcedimento>
            </ans:servicosExecutados>
          </ans:despesa>
        </ans:outrasDespesas>
      </ans:guiaResumoInternacao>';
        $array = [1, 2, 4, 5, 6];
        foreach ($array as $key => $value) {
            $medicamentos = array(
                'anscabecalhoGuia' => array(
                                        'ansregistroANS' => '1',       
                                        'ansnumeroGuiaPrestador' => '11112',       
                                    ),
                'ansnumeroGuiaSolicitacaoInternacao' => '126659518',
                'ansdadosAutorizacao' => array(
                                        'ansnumeroGuiaOperadora' => '126659518',       
                                        'ansdataAutorizacao' => '2020-02-22',       
                                        'anssenha' => '126659518',       
                                    ),
                'ansdadosBeneficiario' => '1',
                'ansdadosExecutante' => '1',
                'ansdadosInternacao' => '1',
                'ansdadosSaidaInternacao' => '1',
                'ansprocedimentosExecutados' => '1',
                'ansvalorTotal' => '1',
                'ansoutrasDespesas' => '1',
                
                
            );
            $xml_data = new SimpleXMLElement('<ansguiaResumoInternacao></ansguiaResumoInternacao>');
            $this->utilitario->array_to_xml($medicamentos, $xml_data);
            // $xml_data->asXML('/home/sisprod/projetos/name.xml');    
            $string.= str_replace('<?xml version="1.0"?>', '', $xml_data->asXML());  
        }

        // // $xml.=;
        //  $string= str_replace('ans', 'ans:', $string);

        // $string.=$xml;
        // // $xml.=$string;

        // print_r($string);
        // die;
        
        return $string;
    }

    function conversaoRtfAlberto() {

        $this->load->library('RtfReader');
        $result = $this->exametemp->testandoConversaoArquivosRTF();
        // echo '<pre>';
        // var_dump($result); die;
        echo '<meta charset="UTF-8">';
        foreach ($result as $key => $value) {
            if (strlen($value->texto) > 10) {
                $reader = new RtfReader();
                $rtf = str_replace(';', '', $value->texto);
                $reader->Parse($rtf);
                // $reader->root->dump();

                $formatter = new RtfHtml();

                $html = $formatter->Format($reader->root);
                $result = $this->exametemp->convertendoArquivoRtfHTML($value->consultas_sim_id, $html);
                echo $value->consultas_sim_id . '<br> <hr>';
                // echo $html . "<br>";
            }

            // die;
        }


        // $data = '4201388889';
        // echo date("Y-m-d H:i",$data);
    }

    function conversaoRtfValeImagem() {

        $this->load->library('RtfReader');
        $result = $this->exametemp->testandoConversaoArquivosRTFValeImagem();
        // echo '<pre>';
        // var_dump($result); die;
        echo '<meta charset="UTF-8">';
        foreach ($result as $key => $value) {
            if (strlen($value->dslaudo) > 10) {
                $reader = new RtfReader();
                $rtf = str_replace(';', '', $value->dslaudo);
                $reader->Parse($rtf);
                // $reader->root->dump();

                $formatter = new RtfHtml();

                $html = $formatter->Format($reader->root);
                $html = str_replace('&loz;', '', $html);

                // var_dump($html); die;
                // $result = $this->exametemp->convertendoArquivoRtfHTMLValeImagem($value, $html);
                // echo $value->idagendaitens . '<br> <hr>';
                // echo $html . "<br>";
            }

            // die;
        }


        // $data = '4201388889';
        // echo date("Y-m-d H:i",$data);
    }

    function salvarRtfValeImagem() {

        $this->load->library('RtfReader');
        $result = $this->exametemp->testandoConversaoArquivosRTFValeImagem();
        // echo '<pre>';
        // var_dump($result); die;
        // echo '<meta charset="UTF-8">';
        if (!is_dir("./upload/paciente")) {
            mkdir("./upload/paciente");
            $destino = "./upload/paciente";
            chmod($destino, 0777);
        }
        foreach ($result as $key => $value) {
            if (strlen($value->dslaudo) > 10) {
                $rtf = $value->dslaudo;
                $paciente_id = $value->idpacie;
                $id = $value->idagendaitens;
                if (!is_dir("./upload/paciente/$paciente_id")) {
                    mkdir("./upload/paciente/$paciente_id");
                    $destino = "./upload/paciente/$paciente_id";
                    chmod($destino, 0777);
                }
                $fp = fopen("./upload/paciente/$paciente_id/$id.rtf", "a+");
                fwrite($fp, $rtf);
                fclose($fp);
            }

            // die;
        }


        // $data = '4201388889';
        // echo date("Y-m-d H:i",$data);
    }

    function testandoPrintPHP() {

        // $teste = new login();
        // require __DIR__ . '/impressaoViaNavegador.php';
        // $result = $this->exametemp->testandoConversaoArquivosRTF();
        // echo '<pre>';
        // var_dump($result); die;
    }

    function verificarCarenciaFidelidade() {
        $paciente_id = $_GET['paciente_id'];
        $_GET['paciente'] = $_GET['paciente_id'];
        $convenio_id = $_GET['convenio_id'];
        // verificarcarenciaweb
        $flags = $this->guia->listarempresapermissoes();
        $paciente_inf = $this->guia->pacienteAntigoId($paciente_id);
        $convenio_retorno = $this->guia->enderecoSistemaFidelidade($convenio_id);
        $endereco = $convenio_retorno[0]->fidelidade_endereco_ip;
        $parceiro_id = $convenio_retorno[0]->fidelidade_parceiro_id;
        $paciente_antigo_id = (int) $paciente_inf[0]->prontuario_antigo;
        $cpf = $paciente_inf[0]->cpf;
        $procedimento = $_GET['procedimento'];

        if ($endereco != '') {
            if ($flags[0]->fidelidade_paciente_antigo == 'f') {
                $paciente_antigo_id = 0;
            }
            // Dessa forma, se a flag estiver desativada o sistema manda zero pro fidelidade
            // daí o fidelidade não pesquisa pelo ID e sim pelo CPF.
            //    echo "<pre>";
            $return = file_get_contents("http://{$endereco}/autocomplete/verificarcarenciaweb?paciente=$paciente_id&paciente_antigo_id=$paciente_antigo_id&parceiro_id=$parceiro_id&cpf=$cpf&procedimento=$procedimento");
            $resposta = json_decode($return);
            // var_dump($resposta);
            // die;
            echo json_encode($resposta);
        } else {
            echo json_encode(true);
        }
    }

    function gravarhorarioagendawebconvenio() {
        header('Access-Control-Allow-Origin: *');
        $paciente_id = $this->exametemp->crianovopacientefidelidade();
        $result = $this->exametemp->gravarpacienteconsultasweb($paciente_id);
//        var_dump($result); die;
        $retorno['data'] = $result[0]->data;
        $retorno['paciente_id'] = $result[0]->paciente_id;
        $var[] = $retorno;

        echo json_encode($var);
    }

    function gravarsenhatoten() {
        header('Access-Control-Allow-Origin: *');
        $result = $this->exametemp->gravarsenhatoten();

        if ($result) {
            echo json_encode('true');
        } else {
            echo json_encode('false');
        }
    }

    function gravaridmedicototem(){
        header('Access-Control-Allow-Origin: *');
        $result = $this->exametemp->gravaridmedicototem();

        if ($result) {
            echo json_encode('true');
        } else {
            echo json_encode('false');
        }
    }

    function historicopordia() {
        $_GET['dataescolhida'] = date("Y-m-d", strtotime(str_replace("/", "-", $_GET['dataescolhida'])));
         $tipo =  "";
        if(isset($_GET['tipo']) && $_GET['tipo'] != ""){
          $tipo =  $_GET['tipo'];   
        }  
        $result = $this->laudo->listardatashistoricopordia($_GET['paciente'], $_GET['dataescolhida'],$tipo);

        echo json_encode($result);
    }

    function enviar_valor() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: content-type");
        $json_post = json_decode(file_get_contents("php://input"));
        // var_dump($json_post); 
        // die;
        $convenio = $json_post->convenio;
        $codigo = $json_post->codigo;
        $valor = $json_post->valor;
        $origemLis = $json_post->origemLis;
        // echo '<pre>';
        // var_dump($texto_add); 
        // die;
        $resposta = $this->procedimento->gravarValorLabAPI($convenio, $codigo, $valor, $origemLis);

        $obj = new stdClass();
        if(count($resposta) > 0){
            $obj->status = 200;
            $obj->data = $resposta;
        }else{
            $obj->status = 404;
        }
        // echo '<pre>';
        // var_dump($obj); 
        // die;

        echo json_encode($obj); 
    }

    function descontoespecialvalor() {
        $tipo_desconto = $_GET['tipo_desconto'];
        $agenda_exames_id = $_GET['agenda_exames_id'];

        $result = $this->exametemp->listardescontoespecialvalor($tipo_desconto, $agenda_exames_id);

        echo json_encode($result);
    }

    function gravarpacientefidelidade() {
        header('Access-Control-Allow-Origin: *');
        $obj_paciente = json_decode($_POST['body']);
        $retorno_paciente = $this->paciente_m->contadorpacientefidelidade($obj_paciente);
        // echo '<pre>';
        // var_dump($retorno_paciente); 
        // die; 
        if ($retorno_paciente == 0) {
            $paciente_id = $this->paciente_m->gravarpacientefidelidade($obj_paciente);
        } else {
            $paciente_id = 0;
        }
        // echo '<pre>';
        // var_dump($paciente_id); 
        // die;

        echo json_encode($paciente_id);
    }

    function resultadoIntegracaoLabLuz() {
        header('Access-Control-Allow-Origin: *');

        // A Você que verá o código a seguir, sinto muito, mas era o único jeito.

        $xml_PT1 = "<?xml version='1.0'?>
        <lote codigoLis='123' identificadorLis='teste' origemLis='TESTE' criacaoLis='2016-08-01T06:56:52-0300'>         
            <solicitacoes>
                <solicitacao codigoLis='123'>
                <solicitacao codigoLis='124'>
                </solicitacao>
            </solicitacoes>
            <parametros acao='VIEW' parcial='S'retorno='PDF'>
        
        </lote>";

        $xml_final = $xml_PT1;


        $postdata = http_build_query(
                array(
                    'body' => $xml_final,
                    'url' => 'https://labluz.lisnet.com.br/lisnet/APOIO/resultado',
                )
        );

        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );

        $context = stream_context_create($opts);

        $result = file_get_contents(base_url() . 'autocomplete/enviarCurlLabLuz', false, $context);
        if (!preg_match('/\Erro/', $result)) {

            $xml = simplexml_load_string($result);
            $json = json_encode($xml);
            $array = json_decode($json, TRUE);
            echo '<pre>';
            var_dump($array);
            // var_dump($result);
            // var_dump($xml_string);
            die;
        } else {
            echo 'erro de conexao';
            die;
        }
        // var_dump($result); die;
    }

    function testandoIntegracaoLabLuz() {
        header('Access-Control-Allow-Origin: *');
        //Lote
        $empresa = $this->guia->listarempresa();

        if ($empresa[0]->endereco_integracao_lab != '') {
            $url = $empresa[0]->endereco_integracao_lab;
        } else {
            $url = '';
        }
        if ($empresa[0]->identificador_lis != '') {
            $identificador_lis = $empresa[0]->identificador_lis;
        } else {
            $identificador_lis = '';
        }
        if ($empresa[0]->origem_lis != '') {
            $origem_lis = $empresa[0]->origem_lis;
        } else {
            $origem_lis = '';
        }
        // Lote
        $criacaoLis = date("Y-m-d") . 'T' . date("H:i:s") . '-0300';
        $codigoLis = '112'; // Ambulatorio_guia_id provavelmente
        $identificadorLis = $identificador_lis;
        $origemLis = $origem_lis;
        // Solicitacao
        $solCodigoLis = '9996';
        $codigoConvenio = '1';
        $descConvenio = '1';
        $descConvenio = 'CONVENIO TESTE';
        $codigoPlano = '1';
        $descricaoPlano = 'PLANO TESTE';
        // Solicitacao->Paciente
        $pacienteCodigoLis = '123';
        $nome = 'PACIENTE TESTE';
        $nascimento = '1955-02-05';
        $sexo = 'M';
        // Solicitacao->Exames
        // Exames ->Exame
        $exameCodigoLis = 'TR4';
        $amostraLis = '5555555';
        $materialLis = '4956';
        // Exame-> Solicitantes
        // Solicitantes -> Solicitante
        $conselho = 'CRM';
        $uf = 'BA';
        $numero = '9999999999';
        $nome_medico = 'MEDICO';

//////////////////////////// Definição dos Objs ////////////////////////

        $geral_obj = new stdClass();
        $lote_obj = new stdClass();
        $solicitacoes_obj = new stdClass();
        $solicitacao_obj = new stdClass();
        $solicitacao_array = array();
        $solicitacao_obj = new stdClass();
        $paciente_obj = new stdClass();
        $exames_obj = new stdClass();

        $exame_array = array();

////////////// Solicitantes ////////////////////////////
        $solicitantes_obj = new stdClass();
        $solicitante_array = array();
        $solicitante_array[0] = new stdClass();
        $solicitante_array[0]->conselho = 'CRM';
        $solicitante_array[0]->uf = 'SP';
        $solicitante_array[0]->numero = '1';
        $solicitante_array[0]->nome = 'MEDICO';
        $solicitantes_obj->solicitante = $solicitante_array;
        // array_push($solicitante_array, $solicitantes_obj);
/////////////// Exames //////////////////      
        $teste = array(1);
        $contador = 0;

        foreach ($teste as $item) {
            $exame_array[$contador] = new stdClass();
            $exame_array[$contador]->codigoLis = 'COL1';
            $exame_array[$contador]->amostraLis = '';
            $exame_array[$contador]->materialLis = '4956';
            $exame_array[$contador]->solicitantes = $solicitantes_obj;

            $contador++;
        }

        $exames_obj->exame = $exame_array; // O atributo exame recebe o array de outros objs criados no foreach
///////////////// Paciente ////////////////

        $paciente_obj->codigoLis = $pacienteCodigoLis;
        $paciente_obj->nome = $nome;
        $paciente_obj->nascimento = $nascimento;
        $paciente_obj->sexo = $sexo;

///////////////// Solicitacao /////////////////////////

        $solicitacao_array[0] = new stdClass();
        $solicitacao_array[0]->codigoLis = $solCodigoLis;
        $solicitacao_array[0]->criacaoLis = $criacaoLis;
        $solicitacao_array[0]->paciente = $paciente_obj; // Obj Paciente
        $solicitacao_array[0]->exames = $exames_obj; // Obj Exames

        $solicitacoes_obj->solicitacao = $solicitacao_array;
////////////////  Lote ////////////////////////

        $lote_obj->codigoLis = $codigoLis;
        $lote_obj->identificadorLis = $identificadorLis;
        $lote_obj->origemLis = $origemLis;
        $lote_obj->criacaoLis = $criacaoLis;
        $lote_obj->solicitacoes = $solicitacoes_obj;

/////////////// Objeto Com o Lote //////////////////
        $geral_obj->lote = $lote_obj;
        $json_geral = json_encode($geral_obj);

        // echo '<pre>';
        // var_dump($json_geral);
        // var_dump($json_novo_decode);
        // die;


        $postdata = http_build_query(
                array(
                    'body' => $json_geral,
                    'url' => $url,
                )
        );

        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );

        $context = stream_context_create($opts);

        $result = file_get_contents(base_url() . 'autocomplete/enviarCurlLabLuz', false, $context);

        // var_dump($result); die;
        // $xml = simplexml_load_string($result);
        // $json = json_encode($xml);
        $decode_result = json_decode($result);

        if (isset($decode_result)) {

            if ($decode_result->lote->solicitacoes[0]->solicitacao->mensagem == 'REJEITADO') {
                echo 'Errado';
            }
        }
        echo '<pre>';
        // echo $result;
        var_dump($decode_result);
        // var_dump($decode_result);
        die;
    }

    function enviarCurlLabLuz() {
        // header('Access-Control-Allow-Origin: *');
        // header("Access-Control-Allow-Headers: content-type");
        // echo 'aaa';
        // var_dump($_POST); 
        // die;
        $headers = array();
        $fields = array('' => $_POST['body']);
        $url = $_POST['url'];
        $ch = curl_init();
        // $headers[] = "Content-length: $strlen";
        $headers[] = 'Content-type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST['body']);

        $result = curl_exec($ch);
        // var_dump($result);
        curl_close($ch);
    }

    function testarconexaointegracaolaudo() {
        header('Access-Control-Allow-Origin: *');
        set_time_limit(0); // Limite de tempo de execução: 2h. Deixe 0 (zero) para sem limite
        ignore_user_abort(true); // Não encerra o processamento em caso de perda de conexãoF

        echo json_encode('true');
    }

    function gravaratendimentointegracaoweb() {
        header('Access-Control-Allow-Origin: *');
        set_time_limit(0); // Limite de tempo de execução: 2h. Deixe 0 (zero) para sem limite
        ignore_user_abort(true); // Não encerra o processamento em caso de perda de conexão
        if (isset($_POST)) {
            $paciente_obj = json_decode($_POST['paciente_json']);
            $laudo_obj = json_decode($_POST['laudo_json']);
            $paciente_web_id = $paciente_obj[0]->paciente_id;
//            echo '<pre>';
//            var_dump($paciente_obj);
            if ($paciente_obj[0]->cpf != '') {
                $paciente_id = $this->exametemp->criarnovopacienteintegracaoweb($paciente_obj[0]->cpf, $paciente_obj);
                $retorno = $this->laudo->gravarlaudointegracaoweb($paciente_id, $paciente_web_id, $laudo_obj);
            } else {
                $retorno = false;
            }

//            var_dump($retorno);
        } else {
            $retorno = false;
        }
//        echo '<pre>';
//        var_dump($_POST);
        echo json_encode($retorno);
//        die;
    }

    function atendersenhatoten() {
        header('Access-Control-Allow-Origin: *');

        set_time_limit(0); // Limite de tempo de execução: 2h. Deixe 0 (zero) para sem limite
        ignore_user_abort(true); // Não encerra o processamento em caso de perda de conexão

        $result = $this->exametemp->atendersenhatoten();

        if ($result) {
            echo json_encode('true');
        } else {
            echo json_encode('false');
        }
    }

    function listarinadimplenciautocomplete() {
        $empresapermissoes = $this->guia->listarempresapermissoes();
        if (isset($_GET['paciente_id'])) {
            $result = $this->exametemp->listarinadimplenciautocomplete($_GET['paciente_id']);
        } else {
            $result = $this->exametemp->listarinadimplenciautocomplete();
        }
        if (count($result) > 0 && $empresapermissoes[0]->inadimplencia == 't') {
            echo json_encode('true');
        } else {
            echo json_encode('false');
        }
        // echo json_encode('false');
        // echo json_encode($result);
    }

    function listarusuarioSenhaAdmin() {
        // var_dump($_POST); die;
        if (isset($_POST['senha'])) {
            $result = $this->operador_m->listarusuarioadminsenha($_POST['senha']);
        }
        if (count($result) > 0) {
            die(header("HTTP/1.1 200 OK"));
        } else {
            die(header("HTTP/1.0 404 Not Found"));
        }
        // echo json_encode($result);
    }

    function procedimentoconveniocirurgico() {

        if (isset($_GET['convenio1'])) {
            $result = $this->centrocirurgico->listarautocompleteprocedimentoscirurgico($_GET['convenio1']);
        } else {
            $result = $this->centrocirurgico->listarautocompleteprocedimentoscirurgico();
        }
        echo json_encode($result);
    }

    // function procedimentoconveniointernacao() {

    //     if (isset($_GET['convenio1'])) {
    //         $result = $this->centrocirurgico->listarautocompleteprocedimentoscirurgico($_GET['convenio1']);
    //     } else {
    //         $result = $this->centrocirurgico->listarautocompleteprocedimentoscirurgico();
    //     }
    //     echo json_encode($result);
    // }

    function buscadadosgraficorelatoriodemandagrupo() {
        $result = $this->exame->buscadadosgraficorelatoriodemandagrupo();
//        echo '<pre>';
//        var_dump($result);die;

        $array = array();
        $array['Indiferente'] = 0;
        $contador = 0;
        foreach ($result as $item) {
            if ($item->data_preferencia != '') {
                switch (date('N', strtotime($item->data_preferencia))) {
                    case 1:
                        $diaSemana = 'segunda';
                        break;
                    case 2:
                        $diaSemana = 'terca';
                        break;
                    case 3:
                        $diaSemana = 'quarta';
                        break;
                    case 4:
                        $diaSemana = 'quinta';
                        break;
                    case 5:
                        $diaSemana = 'sexta';
                        break;
                    case 6:
                        $diaSemana = 'sabado';
                        break;
                    case 7:
                        $diaSemana = 'domingo';
                        break;
                    default :
                        $diaSemana = 'indiferente';
                        break;
                }
            } else {
                $diaSemana = 'indiferente';
            }

            if ($diaSemana == $_GET['dia']) {
//                var_dump($item->data_preferencia);
//                var_dump($item->horario_preferencia);
//                var_dump($diaSemana);
                if ($item->horario_preferencia != '') {
                    if (!isset($array[$item->horario_preferencia])) {
                        $array[$item->horario_preferencia] = 1;
                    } else {
                        if ($item->horario_preferencia == $result[$contador - 1]->horario_preferencia) {
                            $array[$item->horario_preferencia] ++;
                        } else {
//                        $array[$item->horario_preferencia] = 1;
                        }
                    }
                } else {
                    $array['Indiferente'] ++;
                }
            }


            $contador++;
        }
        $array_horarios = array();

        foreach ($array as $key => $value) {
            $array_atual = array(
                'horario' => $key,
                'contador' => $value
            );
            array_push($array_horarios, $array_atual);
        }

        echo json_encode($array_horarios);
    }

    function procedimentoconveniocirurgicoagrupador() {

        if (isset($_GET['convenio1'])) {
            $result = $this->centrocirurgico->listarautocompleteprocedimentoconveniocirurgicoagrupador($_GET['convenio1']);
        } else {
            $result = $this->centrocirurgico->listarautocompleteprocedimentoconveniocirurgicoagrupador();
        }
        echo json_encode($result);
    }

    function produtofarmacia() {

        if (isset($_GET['term'])) {
            $result = $this->produto_m->autocompleteprodutofarmacia($_GET['term']);
        } else {
            $result = $this->produto_m->autocompleteprodutofarmacia();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->farmacia_produto_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function fornecedorfarmacia() {

        if (isset($_GET['term'])) {
            $result = $this->fornecedor_m->autocompletefornecedorfarmacia($_GET['term']);
        } else {
            $result = $this->fornecedor_m->autocompletefornecedorfarmacia();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->fantasia;
            $retorno['id'] = $item->farmacia_fornecedor_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function prescricaomedicamento() {

        if (isset($_GET['term'])) {
            $result = $this->internacao_m->listarautocompletemedicamentoprescricao($_GET['term']);
        } else {
            $result = $this->internacao_m->listarautocompletemedicamentoprescricao();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->farmacia_produto_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function saldofarmacia() {

        if (isset($_GET['entrada_id'])) {
            $result = $this->saida_farmacia_m->listarsaldoprodutofarmaciaautocomplete($_GET['entrada_id']);
        } else {
            $result = $this->saida_farmacia_m->listarsaldoprodutofarmaciaautocomplete();
        }
//        var_dump($result); die;
        foreach ($result as $item) {
            $retorno['value'] = $item->total;
//            $retorno['id'] = $item->estoque_produto_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function saidaprescricaofarmacia() {

        if (isset($_GET['prescricao_id'])) {
            $result = $this->saida_farmacia_m->listarsaidaprescricaofarmaciaautocomplete($_GET['prescricao_id']);
        } else {
            $result = $this->saida_farmacia_m->listarsaidaprescricaofarmaciaautocomplete();
        }
//        var_dump($result); die;
        foreach ($result as $item) {
            $retorno['value'] = $item->total;
//            $retorno['id'] = $item->estoque_produto_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function produtofarmaciafracionamento() {

        if (isset($_GET['term'])) {
            $result = $this->produto_m->autocompleteprodutofarmaciafracionamento($_GET['term']);
        } else {
            $result = $this->produto_m->autocompleteprodutofarmaciafracionamento();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->farmacia_produto_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function listarhorarioagendawebconvenio() {
        header('Access-Control-Allow-Origin: *');
//        var_dump($_GET); die;
        $convenio = $this->procedimentoplano->listarconveniointegracaofidelidade($_GET['parceiro_id']);
        echo json_encode($convenio);
    }

    function testandototen() {
        echo '<pre>';
//        header('Access-Control-Allow-Origin: *');
//        var_dump('dasdasd'); die;
//        $url = 'http://localhost/clinicas/autocomplete/TESTEPARTE2TOTENFODIDO';
//        $url = "http://192.168.25.47:8099/webService/telaAtendimento/proximo/'27'/Guichê1/false/true/12";
//        
        $data = array(
            'setores' => '27',
            'guiche' => 'Guichê 1',
            'fila' => 'false',
            'filaPrioridade' => 'true',
            'idUsuarioStg' => '12'
        );
//
//// use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST'
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
//        $grupo_busca = file_get_contents($url);
        if ($result === FALSE) { /* Handle error */
        }

        var_dump($result);
        # Our new data
//        $data = array(
//            'election' => 1,
//            'name' => 'Test'
//        );
//        
//       
# Create a connection
//       $url = 'http://localhost/clinicas/autocomplete/TESTEPARTE2TOTENFODIDO';
        $url = 'http://192.168.25.47:8099/webService/telaAtendimento/proximo/"27"/Guichê1/false/true/12';
        $ch = curl_init($url);
# Form data string
        $postString = http_build_query($data, '', '&');
# Setting our options
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
        $response = curl_exec($ch);
        var_dump($response);
//        die;
        curl_close($ch);


//        $r = new HttpRequest('http://192.168.25.47:8099/webService/telaAtendimento/proximo/"27"/Guichê1/false/true/12', HttpRequest::METH_POST);
//        $r->setOptions(array('cookies' => array('lang' => 'pt')));
//        $r->addPostFields(array('user' => 'mike', 'pass' => 's3c|r3t'));
//        $r->addPostFile('image', 'profile.jpg', 'image/jpeg');
//        try {
//            echo $r->send()->getBody();
//        } catch (HttpException $ex) {
//            echo $ex;
//        }

        $grupo_busca = file_get_contents("http://192.168.25.47:8099/webService/telaAtendimento/setores");
        $grupo = json_decode($grupo_busca);
        var_dump($grupo);
//        var_dump($grupo[0]->nome);
        die;
    }

    function enviaremailstg() {
        header('Access-Control-Allow-Origin: *');
//        var_dump($_POST);
//        die;
        if ($_POST['human'] == '4') {


            $this->load->library('email');

            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'ssl://smtp.gmail.com';
            $config['smtp_port'] = '465';
            $config['smtp_user'] = 'equipe2016gcjh@gmail.com';
            $config['smtp_pass'] = 'aramis*123@';
            $config['validate'] = TRUE;
            $config['mailtype'] = 'html';
            $config['charset'] = 'utf-8';
            $config['newline'] = "\r\n";
            $email = $_POST['message'] . "<br>  "
                    . "<br> Nome: {$_POST['name']}"
                    . "<br> Telefone: {$_POST['telefone']}"
                    . "<br> Email: {$_POST['email']}";

            $this->email->initialize($config);
            $this->email->from('equipe2016gcjh@gmail.com', $_POST['name']);
            $this->email->to('contato@stgsaude.com.br');
            $this->email->subject($_POST['subject']);
            $this->email->message($email);
            if ($this->email->send()) {
                $mensagem = "Email enviado com sucesso.";
            } else {
                $mensagem = "Envio de Email malsucedido.";
            }
            echo "<html>
            <meta charset='UTF-8'>
        <script type='text/javascript'>
        alert('$mensagem');
        window.location.href = 'http://stgsaude.com.br';
            </script>
            </html>";
//        redirect("http://stgsaude.com.br");
        } else {
            echo "<html>
            <meta charset='UTF-8'>
        <script type='text/javascript'>
        alert('Você respondeu o anti-spam errado');
        window.location.href = 'http://stgsaude.com.br';
            </script>
            </html>";
        }
    }

    function autorizaragendaweb() {
        header('Access-Control-Allow-Origin: *');

        $parceiro = $this->parceiro->listarparceiroendereco($parceiro_id);
        @$endereco = $parceiro[0]->endereco_ip;
        @$parceiro_gravar_id = $parceiro[0]->financeiro_parceiro_id;
        $cpf = $cpf_array[0]->cpf;
        // BUSCANDO O GRUPO DO PROCEDIMENTO NA CLINICA

        $grupo_busca = file_get_contents("http://{$endereco}/autocomplete/listargrupoagendamentoweb?procedimento_convenio_id={$_POST['procedimento']}");
        $grupo = json_decode($grupo_busca);

        //LISTANDO AS INFORMAÇÕES DE CARÊNCIA E PARCELAS PAGAS PELO PACIENTE

        $parcelas = $this->guia->listarparcelaspaciente($_POST['txtNomeid']);
        $carencia = $this->guia->listarparcelaspacientecarencia($_POST['txtNomeid']);

        $listaratendimento = $this->guia->listaratendimentoparceiro($paciente_id);
        $carencia_exame = $carencia[0]->carencia_exame;
        $carencia_consulta = $carencia[0]->carencia_consulta;
        $carencia_especialidade = $carencia[0]->carencia_especialidade;

        // COMPARANDO O GRUPO E ESCOLHENDO O VALOR DE CARÊNCIA PARA O GRUPO DESEJADO
        if ($grupo == 'EXAME') {
            $carencia = (int) $carencia_exame;
        } elseif ($grupo == 'CONSULTA') {
            $carencia = (int) $carencia_consulta;
        } elseif ($grupo == 'FISIOTERAPIA') {
            $carencia = (int) $carencia_especialidade;
        }
        // 

        $dias_parcela = 30 * count($parcelas);
        $dias_atendimento = $carencia * count($listaratendimento);


        if (($dias_parcela - $dias_atendimento) >= $carencia) {
            return json_encode(true);
        } else {
            return json_encode(false);
        }
        die;
    }

//    function unidadeleito() {
//
//        if (isset($_GET['unidade'])) {
//            $result = $this->internacao_m->listaleitointarnacao($_GET['unidade']);
//        } else {
//            $result = $this->internacao_m->listaleitointarnacao();
//        }
//        echo json_encode($result);
//    }

    function unidadeleito2() {

        if (isset($_GET['unidade'])) {
            $result = $this->internacao_m->listaleitointarnacao2($_GET['unidade']);
        } else {
            $result = $this->internacao_m->listaleitointarnacao2();
        }
        echo json_encode($result);
    }

    function unidadepaciente() {

        if (isset($_GET['unidade'])) {
            $result = $this->internacao_m->listapacienteunidade($_GET['unidade']);
        } else {
            $result = $this->internacao_m->listapacienteunidade();
        }
        echo json_encode($result);
    }

    function listarmedicoweb() {
        header('Access-Control-Allow-Origin: *');
//        var_dump($_GET); die;
        $medicos = $this->operador_m->listarmedicos();
        echo json_encode($medicos);
    }

    function listarhorarioagendaweb() {
        header('Access-Control-Allow-Origin: *');
        $agenda_exames_id = $_GET['agenda_exames_id'];
        $consultas = $this->exametemp->listaragendasconsultapaciente($agenda_exames_id);
        echo json_encode($consultas);
    }

    function gerarelatorioconsultasagendadas() {
        header('Access-Control-Allow-Origin: *');

        $result = $this->exame->gerarelatorioconsultasagendadas();
        echo json_encode($result);
    }

    function listarexameagendamentoweb() {
        header('Access-Control-Allow-Origin: *');

        $result = $this->exame->listaragendamentoweb()->limit($_GET['limit'], $_GET['pagina'])->get()->result();
        echo json_encode($result);
    }

    function listarexameagendamentowebcpf() {
        header('Access-Control-Allow-Origin: *');
//        var_dump($_GET); die;
        $result = $this->exame->listaragendamentowebcpf()->limit($_GET['limit'], $_GET['pagina'])->get()->result();
//        var_dump($result); die;
        echo json_encode($result);
    }

    function listargrupoagendamentoweb() {
//        var_dump($_GET); die;
        header('Access-Control-Allow-Origin: *');

        if (isset($_GET['procedimento_convenio_id'])) {
            $result = $this->exametemp->listarautocompletegrupoweb(@$_GET['procedimento_convenio_id']);
        } else {
            $result = $this->exametemp->listarautocompletegrupoweb(@$_GET['procedimento_convenio_id']);
        }

        echo json_encode($result[0]->tipo);
    }

    function excluirconsultaweb() {
        $agenda_exames_id = $_GET['agenda_exames_id'];
//        var_dump($agenda_exames_id); die;
        $this->exametemp->excluirexametemp($agenda_exames_id);
        echo json_encode(true);
    }

    function buscarvalorprocedimentoagrupados() {
        $result = array();

        if (isset($_GET['convenio']) && isset($_GET['procedimento_id'])) {
            $result = $this->exametemp->buscarvalorprocedimentoagrupados($_GET['convenio'], $_GET['procedimento_id']);
        }

        die(json_encode($result));
    }

    function buscaexamesanteriores() {
        $result = array();

        if (isset($_GET['paciente_id']) && isset($_GET['procedimento_id'])) {
            $result = $this->exametemp->buscaexamesanteriores($_GET['paciente_id'], $_GET['procedimento_id']);
        }

        echo json_encode($result);
    }

    function validaretornoprocedimento() {
        $result = array();

        if (isset($_GET['paciente_id']) && isset($_GET['procedimento_id'])) {
            $result = $this->exametemp->validaretornoprocedimento($_GET['paciente_id'], $_GET['procedimento_id']);
        }

        echo json_encode($result);
    }

    function validaretornoprocedimentoinverso() {
        $result = array();  
        if (isset($_GET['paciente_id']) && isset($_GET['procedimento_id'])) {
            $result = $this->exametemp->validaretornoprocedimentoinverso($_GET['paciente_id'], $_GET['procedimento_id']);
        }

        echo json_encode($result);
    }

    function buscaconsultasanteriores() {
        $result = array();

        if (isset($_GET['paciente_id']) && isset($_GET['procedimento_id'])) {
            $result = $this->exametemp->buscaconsultasanteriores($_GET['paciente_id'], $_GET['procedimento_id']);
        }

        echo json_encode($result);
    }

    function horariosambulatorioexame() {
        $_GET['teste'] = date("Y-m-d", strtotime(str_replace("/", "-", $_GET['teste'])));

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarautocompletehorariosexame($_GET['exame'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarautocompletehorariosexame();
        }
        echo json_encode($result);
    }

    function unidadeleito() {

        if (isset($_GET['unidade'])) {
            $result = $this->internacao_m->listaleitointarnacao($_GET['unidade']);
        } else {
            $result = $this->internacao_m->listaleitointarnacao();
        }
        echo json_encode($result);
    }

    function buscarprocedimentoconvenioprincipal() {
        if (isset($_GET['convenio'])) {
            $result = $this->procedimentoplano->buscarprocedimentoconvenioprincipal($_GET['convenio']);
        } else {
            $result = $this->procedimentoplano->buscarprocedimentoconvenioprincipal();
        }
        echo json_encode($result);
    }

    function buscarprocedimentoconveniosecundario() {
        if (isset($_GET['convenio'])) {
            $result = $this->procedimentoplano->buscarprocedimentoconveniosecundario($_GET['convenio']);
        } else {
            $result = $this->procedimentoplano->buscarprocedimentoconveniosecundario();
        }
        echo json_encode($result);
    }

    function buscarconveniosecundario() {
        if (isset($_GET['convenio'])) {
            $result = $this->procedimentoplano->buscarconveniosecundario($_GET['convenio']);
        } else {
            $result = $this->procedimentoplano->buscarconveniosecundario();
        }
        echo json_encode($result);
    }

    function horariosambulatorioconsulta() {
        $_GET['teste'] = date("Y-m-d", strtotime(str_replace("/", "-", $_GET['teste'])));
        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarhorariosconsulta($_GET['exame'], $_GET['teste'],@$_GET['empresa_id']);
        } else {
            $result = $this->exametemp->listarhorariosconsulta();
        }
        echo json_encode($result);
    }

    function horariosambulatorioespecialidade() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        $_GET['teste'] = date("Y-m-d", strtotime(str_replace("/", "-", $_GET['teste'])));
        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarhorariosespecialidade($_GET['exame'], $_GET['teste'],$_GET['empresa_id']);
        } else {
            $result = $this->exametemp->listarhorariosespecialidade();
        }
        echo json_encode($result);
    }

    function horariosambulatorioespecialidadepersonalizado() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        $_GET['teste'] = date("Y-m-d", strtotime(str_replace("/", "-", $_GET['teste'])));
        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarhorariosespecialidadepersonalizado($_GET['exame'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarhorariosespecialidadepersonalizado();
        }
        echo json_encode($result);
    }

    function armazemtransferenciaentrada() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['produto'])) {
            $result = $this->armazem->armazemtransferenciaentradajson($_GET['produto'], $_GET['armazem']);
        } else {
            $result = $this->armazem->armazemtransferenciaentradajson();
        }
        echo json_encode($result);
    }

    function armazemtransferenciaentradaproduto() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['produto'])) {
            $result = $this->armazem->armazemtransferenciaentradaproduto($_GET['produto'], $_GET['armazem']);
        } else {
            $result = $this->armazem->armazemtransferenciaentradaproduto();
        }
        echo json_encode($result);
    }

    function armazemtransferenciaentradaquantidade() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['produto'])) {
            $result = $this->armazem->armazemtransferenciaentradajsonquantidade($_GET['produto'], $_GET['armazem']);
        } else {
            $result = $this->armazem->armazemtransferenciaentradajsonquantidade();
        }
        echo json_encode($result);
    }

    function armazemtransferenciaentradaquantidadegastos() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['produto'])) {
            $result = $this->armazem->armazemtransferenciaentradajsonquantidadegasto($_GET['produto'], $_GET['armazem']);
        } else {
            $result = $this->armazem->armazemtransferenciaentradajsonquantidadegasto();
        }
        echo json_encode($result);
    }

    function saiuDoLaudo(){
        $ambulatorio_laudo_id = $_GET['laudo_id'];
        $this->laudo->auditoriaLaudo($ambulatorio_laudo_id, 'Saiu do Laudo');
        echo 'true';
    }

    function quantidadegastosfarmacia() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['produto'])) {
            $result = $this->armazem->quantidadegastosfarmacia($_GET['produto'], $_GET['armazem']);
        } else {
            $result = $this->armazem->quantidadegastosfarmacia();
        }
        echo json_encode($result);
    }

    function produtosaldofracionamento() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['produto'])) {
            $result = $this->armazem->produtosaldofracionamento($_GET['produto']);
        } else {
            $result = $this->armazem->produtosaldofracionamento();
        }
        echo json_encode($result);
    }

    function produtofracionamentounidade() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['produto'])) {
            $result = $this->armazem->produtofracionamentounidade($_GET['produto']);
        } else {
            $result = $this->armazem->produtosaldofracionamento();
        }
        echo json_encode($result);
    }

    function produtosaldofracionamentofarmacia() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['produto'])) {
            $result = $this->armazem->produtosaldofracionamentofarmacia($_GET['produto']);
        } else {
            $result = $this->armazem->produtosaldofracionamentofarmacia();
        }
        echo json_encode($result);
    }

    function produtofracionamentounidadefarmacia() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['produto'])) {
            $result = $this->armazem->produtofracionamentounidadefarmacia($_GET['produto']);
        } else {
            $result = $this->armazem->produtosaldofracionamentofarmacia();
        }
        echo json_encode($result);
    }

    function horariosambulatoriogeral() {

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarhorariosgeral($_GET['exame'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarhorariosgeral();
        }
        echo json_encode($result);
    }

    function horariosdisponiveisorcamento() {
        $result = array();
        // var_dump($_GET); die;
        if (isset($_GET['grupo1']) && isset($_GET['empresa1'])) {
            $result = $this->exametemp->listarhorariosdisponiveisorcamento($_GET['grupo1'], $_GET['empresa1']);
        }
        echo json_encode($result);
    }

    function horariosdisponiveisorcamentodata() {
        $result = array();
        if (isset($_GET['grupo1']) && isset($_GET['empresa1']) && isset($_GET['data'])) {
            $result = $this->exametemp->listarhorariosdisponiveisorcamentodata($_GET['grupo1'], $_GET['empresa1'], $_GET['data']);
        }
        echo json_encode($result);
    }

    function horariosdisponiveisorcamentoempresa() {
           
        $result = array();
        // var_dump($_GET); die;
        if (isset($_GET['medico'])) {
            // $empresa = $this->exametemp->listarempresaprocedimentoconvenio($_GET['procedimento_terce_id']);
            // $empresa_id = $empresa[0]->empresa_id;
            $empresa_id = $this->session->userdata('empresa_id');  
            if(isset($_GET['empresa_id']) && $_GET['empresa_id'] != ""){
               $empresa_id = $_GET['empresa_id'];
            }  
            $result = $this->exametemp->listarhorariosdisponiveisorcamentopormedico($_GET['medico'], $empresa_id);            
        }
        echo json_encode($result);
    }

    function informarpacientesfaltou(){
        $result = array();
        if(isset($_GET['tempo'])){
            $result = $this->exametemp->listarpacientefaltososhoje($_GET['tempo']);
        }
        echo json_encode($result);
    }

    function listarprocedimentointernacaoautocomplete() {
        if (isset($_GET['term'])) {
            $result = $this->procedimento->listarprocedimentoautocomplete($_GET['term']);
        } else {
            $result = $this->procedimento->listarprocedimentoautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->procedimento_tuss_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function listarprocedimentoautocomplete() {
        if (isset($_GET['term'])) {
            $result = $this->procedimento->listarprocedimentoautocomplete($_GET['term']);
        } else {
            $result = $this->procedimento->listarprocedimentoautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->procedimento_tuss_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimentoproduto() {
        if (isset($_GET['term'])) {
            $result = $this->procedimento->listarprocedimentoautocomplete($_GET['term']);
        } else {
            $result = $this->procedimento->listarprocedimentoautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->procedimento_tuss_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimentocirurgia() {
        if (isset($_GET['procedimento_id'])) {
            $result = $this->procedimento->listarprocedimentocirurgia2autocomplete($_GET['procedimento_id'], $_GET['convenio_id']);
        } else {
            $result = $this->procedimento->listarprocedimentocirurgia2autocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->codigo . " - " . $item->nome;
            $retorno['id'] = $item->procedimento_tuss_id;
            $retorno['valor'] = $item->procedimento_tuss_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimentoconveniocirurgia() {

        if (isset($_GET['procedimento'])) {
            $result = $this->procedimento->listarprocedimentocirurgiaautocomplete($_GET['procedimento']);
        } else {
            $result = $this->procedimento->listarprocedimentocirurgiaautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->procedimento_convenio_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function listarespecialidademultiempresa() {
        header('Access-Control-Allow-Origin: *');

        $result = $this->exametemp->listarespecialidademultiempresa();

        foreach ($result as $item) {
            $retorno['cbo_ocupacao_id'] = $item->cbo_ocupacao_id;
            $retorno['descricao'] = $item->descricao;
            @$var[] = $retorno;
        }
        echo json_encode($var);
    }

    function listarmedicosmultiempresa() {
        header('Access-Control-Allow-Origin: *');

        $result = $this->exametemp->listarmedicosmultiempresa();

        foreach ($result as $item) {
            $retorno['operador_id'] = $item->operador_id;
            $retorno['nome'] = $item->nome;
            $retorno['conselho'] = $item->conselho;
            @$var[] = $retorno;
        }
        echo json_encode($var);
    }

    function listarconsultaspacientemultiempresa() {
        header('Access-Control-Allow-Origin: *');
        $agenda_exames_id = $_POST['agenda_exames_id'];
//        $agenda_exames_id = 911481;

        $result = $this->exametemp->listarconsultaspacientemultiempresa($agenda_exames_id);

        foreach ($result as $item) {
            $retorno['agenda_exames_id'] = $item->agenda_exames_id;
            $retorno['inicio'] = $item->inicio;
            $retorno['data'] = $item->data;
            $retorno['nome'] = $item->nome;
            $retorno['medico'] = $item->medico;
            $retorno['medico_agenda'] = $item->medico_agenda;
            $retorno['observacoes'] = $item->observacoes;
            @$var[] = $retorno;
        }
        echo json_encode($var);
    }

    function listarconveniomultiempresa() {
        $result = $this->exametemp->listarconveniomultiempresa();
        foreach ($result as $item) {
            $retorno['convenio_id'] = $item->convenio_id;
            $retorno['nome'] = $item->nome;
            @$var[] = $retorno;
        }
        echo json_encode($var);
    }

    function listarhorariosmultiempresa() {
//        var_dump(date("Y-m-d", strtotime(str_replace('/', '-', $_GET['data'])))); 
//        die;
        $result = $this->exametemp->listarhorariosmultiempresa();
//        var_dump($result); 
//        die;
        foreach ($result as $item) {

            $retorno['agenda_exames_id'] = $item->agenda_exames_id;
            $retorno['inicio'] = $item->inicio;
            $retorno['fim'] = $item->fim;
            $retorno['situacao'] = $item->situacao;
            $retorno['data'] = $item->data;
            $retorno['situacaoexame'] = $item->situacaoexame;
            $retorno['paciente'] = $item->paciente;
            $retorno['paciente_id'] = $item->paciente_id;
            $retorno['medicoagenda'] = $item->medicoagenda;
            $retorno['medico_agenda'] = $item->medico_agenda;
            $retorno['convenio'] = $item->convenio;
            $retorno['convenio_paciente'] = $item->convenio_paciente;
            $retorno['realizada'] = $item->realizada;
            $retorno['confirmado'] = $item->confirmado;
            $retorno['procedimento'] = $item->procedimento;
            $retorno['celular'] = $item->celular;
            $retorno['telefone'] = $item->telefone;
            $retorno['operador_atualizacao'] = $item->operador_atualizacao;
            $retorno['ocupado'] = $item->ocupado;
            $retorno['bloqueado'] = $item->bloqueado;
            $retorno['telefonema'] = $item->telefonema;
            $retorno['telefonema_operador'] = $item->telefonema_operador;
            $retorno['tipo'] = $item->tipo;
            @$var[] = $retorno;
        }
        echo json_encode($var);
    }

    function listarhorarioscalendarioagendacriada() {
//            echo $_POST['custom_param1'];
        if (count($_POST) > 0) {
            $result = $this->exametemp->listarhorarioscalendarioagendacriada($_POST['agenda_id'], $_POST['situacao']);
//            $algo = 'asd';
        } else {
            $result = $this->exametemp->listarhorarioscalendarioagendacriada();
//            $algo = 'dsa';
        }

        $var = Array();
        $i = 0;
//            $result2 = $this->exametemp->listarhorarioscalendarioocupado();
        $agenda_id = $_POST['agenda_id'];

        foreach ($result as $item) {
            $i++;
            $retorno['id'] = $i;
            if ($item->situacao == 'LIVRE') {
                $retorno['title'] = 'V: ' . $item->contagem;
            } else {
                $retorno['title'] = 'M: ' . $item->contagem;
            }

            $retorno['start'] = $item->data;
            $retorno['end'] = $item->data;
            if ($item->situacao == 'LIVRE') {
                $retorno['color'] = '#62C462';
            } else {
                $retorno['color'] = '#B30802';
            }
            $situacao = $item->situacao;
            if (isset($item->medico)) {
                $medico = $item->medico;
            } else {
                $medico = null;
            }

            $dia = date("d", strtotime($item->data));
            $mes = date("m", strtotime($item->data));
            $ano = date("Y", strtotime($item->data));

//            $medico = $item->medico;
            $retorno['url'] = "../../ambulatorio/exame/calendariohorariosagenda?agenda_id=$agenda_id&situacao=$situacao&data=$dia%2F$mes%2F$ano";

            $var[] = $retorno;
        }
        echo json_encode($var);

//        foreach ($result2 as $value) {
//            $retorno['title'] =  'H: Ocupados: ' . $value->contagem_ocupado;
//            $retorno['start'] = $value->data;
//            $retorno['end'] = $value->data;
//            $retorno['color'] = '#0E9AA7';
//            $dia = date("d", strtotime($item->data));
//            $mes = date("m", strtotime($item->data));
//            $ano = date("Y", strtotime($item->data));
//            $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaoconsulta?empresa=&especialidade=&medico=&situacao=OK&data=$dia%2F$mes%2F$ano&nome=";
//            $var[] = $retorno;
//        }
    }
    

    function listarhorarioscalendario() {

//            echo $_POST['custom_param1'];
        if (count($_POST) > 0) {
            $result = $this->exametemp->listarhorarioscalendariovago($_POST['medico'], null, $_POST['empresa'], $_POST['sala'], $_POST['grupo'], $_POST['tipoagenda'], @$_POST['procedimento'], @$_POST['minicurriculo_id'],@$_POST['nome']);
//            $algo = 'asd';
        } else {
            $result = $this->exametemp->listarhorarioscalendariovago();
//            $algo = 'dsa';
        }

        $var = Array();
        $i = 0;
//            $result2 = $this->exametemp->listarhorarioscalendarioocupado();
        //echo '<pre>';
       // print_r('morreu');
        //die;
        foreach ($result as $item) {
            $i++;
            $retorno['id'] = $i;
            if ($item->situacao == 'LIVRE') {
                $retorno['title'] = 'V: ' . $item->contagem;
            } else {
                $retorno['title'] = 'M: ' . $item->contagem;
            }

            $retorno['start'] = $item->data. "T" .$item->inicio;
            $retorno['end'] = $item->data. "T" .$item->fim;

            if ($item->situacao == 'LIVRE') {
                $retorno['color'] = '#62C462';
            } else {
                $retorno['color'] = '#B30802';
            }
            $situacao = $item->situacao;
            if (isset($item->medico)) {
                $medico = $item->medico;
            } else {
                $medico = null;
            }
            if (isset($_POST['tipoagenda'])) {
                $tipoagenda = $_POST['tipoagenda'];
            } else {
                $tipoagenda = null;
            }
            if(isset($_POST['paciente'])){
                if ($_POST['paciente'] != '') {
                    $nome = $_POST['paciente'];
                } else {
                    $nome = null;
                }
            }else{
                $nome = null;
            }

            if(isset($_POST['procedimento'])){
                if ($_POST['procedimento'] != '') {
                    $procedimento = $_POST['procedimento'];
                } else {
                    $procedimento = null;
                }
            }else{
                $procedimento = null;
            }

            if(isset($_POST['minicurriculo_id'])){
                if ($_POST['minicurriculo_id'] != '') {
                    $curriculos = $_POST['minicurriculo_id'];
                } else {
                    $curriculos = null;
                }
            }else{
                $curriculos = null;
            }

            if(isset($_POST['sala'])){
                $sala = $_POST['sala'];
            }else{
                $sala = null;
            }

            if(isset($_POST['grupo'])){
                $grupo = $_POST['grupo'];
            }else{
                $grupo = null;
            }

            if(isset($_POST['empresa'])){
                $empresa_link = $_POST['empresa'];
            }else{
                $empresa_link = null;
            }

            $dia = date("d", strtotime($item->data));
            $mes = date("m", strtotime($item->data));
            $ano = date("Y", strtotime($item->data));

            $empresa = $this->session->userdata('empresa_id');
            $this->db->select('calendario_layout');
            $this->db->from('tb_empresa_permissoes');
            $this->db->where('empresa_id', $empresa);
            $res = $this->db->get()->result();
            $calendario_layout = $res[0]->calendario_layout;
//            $medico = $item->medico;
            if ($calendario_layout == 't') {
                $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaocalendario2?empresa=$empresa_link&grupo=$grupo&sala=$sala&tipoagenda=$tipoagenda&medico=$medico&situacao=$situacao&data=$dia%2F$mes%2F$ano&nome=$nome&procedimento=$procedimento&curriculos=$curriculos";
            } else {
                $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaocalendario?empresa=$empresa_link&grupo=$grupo&sala=$sala&tipoagenda=$tipoagenda&medico=$medico&situacao=$situacao&data=$dia%2F$mes%2F$ano&nome=$nome";
            }

            $var[] = $retorno;
        }
        echo json_encode($var);

//        foreach ($result2 as $value) {
//            $retorno['title'] =  'H: Ocupados: ' . $value->contagem_ocupado;
//            $retorno['start'] = $value->data;
//            $retorno['end'] = $value->data;
//            $retorno['color'] = '#0E9AA7';
//            $dia = date("d", strtotime($item->data));
//            $mes = date("m", strtotime($item->data));
//            $ano = date("Y", strtotime($item->data));
//            $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaoconsulta?empresa=&especialidade=&medico=&situacao=OK&data=$dia%2F$mes%2F$ano&nome=";
//            $var[] = $retorno;
//        }
    }


    function listarhorarioscalendario2() {
        //echo $_POST['custom_param1'];
        if (isset($_POST['medico']) || isset($_POST['especialidade'])) {
            $result = $this->exametemp->listarhorarioscalendariovago($_POST['medico'],$_POST['especialidade']);
        } else {
            $result = $this->exametemp->listarhorarioscalendariovago();
        }

        $var = Array();
        $i = 0;
        //$result2 = $this->exametemp->listarhorarioscalendarioocupado();

        foreach ($result as $item) {
            $i++;
            $retorno['id'] = $i;
            if ($item->situacao == 'LIVRE') {
                $retorno['title'] = 'H: Vagos: ' . $item->contagem;
            } else {
                $retorno['title'] = 'H: Ocupados: ' . $item->contagem;
            }

            $retorno['start'] = $item->data;
            $retorno['end'] = $item->data;
            if ($item->situacao == 'LIVRE') {
                $retorno['color'] = '#92DBC7';
            } else {
                $retorno['color'] = '#36C4D0';
            }
            $situacao = $item->situacao;
            if(isset($item->medico)) {
              $medico = $item->medico;
                
            }else{
                $medico = null;
            }
            if(isset($item->especialidade)) {
              $especialidade = $item->especialidade;
                
            }else{
                $especialidade = null;
            }

            $dia = date("d", strtotime($item->data));
            $mes = date("m", strtotime($item->data));
            $ano = date("Y", strtotime($item->data));
            
            //$medico = $item->medico;
                
              $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaomedicoconsulta?empresa=&especialidade=$especialidade&medico=$medico&situacao=$situacao&data=$dia%2F$mes%2F$ano&nome=";


            $var[] = $retorno;
        }
        echo json_encode($var);

            //        foreach ($result2 as $value) {
            //            $retorno['title'] =  'H: Ocupados: ' . $value->contagem_ocupado;
            //            $retorno['start'] = $value->data;
            //            $retorno['end'] = $value->data;
            //            $retorno['color'] = '#0E9AA7';
            //            $dia = date("d", strtotime($item->data));
            //            $mes = date("m", strtotime($item->data));
            //            $ano = date("Y", strtotime($item->data));
            //            $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaoconsulta?empresa=&especialidade=&medico=&situacao=OK&data=$dia%2F$mes%2F$ano&nome=";
            //            $var[] = $retorno;
        }

    function listarhorarioscalendariopaciente() {
//            echo $_POST['custom_param1'];
        if (count($_POST) > 0) {
            $result = $this->exametemp->listarhorarioscalendariovagopaciente($_POST['medico'], null, $_POST['empresa'], $_POST['sala'], $_POST['grupo'], $_POST['tipoagenda'], @$_POST['procedimento']);
//            $algo = 'asd';
        } else {
            $result = $this->exametemp->listarhorarioscalendariovagopaciente();
//            $algo = 'dsa';
        }

        $var = Array();
        $i = 0;
//            $result2 = $this->exametemp->listarhorarioscalendarioocupado();

        foreach ($result as $item) {
            $i++;
            $retorno['id'] = $i;
            if ($item->situacao == 'LIVRE') {
                $retorno['title'] = 'V: ' . $item->contagem;
            } else {
                $retorno['title'] = 'M: ' . $item->contagem;
            }

            $retorno['start'] = $item->data;
            $retorno['end'] = $item->data;
            if ($item->situacao == 'LIVRE') {
                $retorno['color'] = '#62C462';
            } else {
                $retorno['color'] = '#B30802';
            }
            $situacao = $item->situacao;
            if (isset($item->medico)) {
                $medico = $item->medico;
            } else {
                $medico = null;
            }
            if ($_POST['tipoagenda']) {
                $tipoagenda = $_POST['tipoagenda'];
            } else {
                $tipoagenda = null;
            }
            if ($_POST['paciente'] != '') {
                $nome = $_POST['paciente'];
            } else {
                $nome = null;
            }
            if (@$_POST['procedimento'] != '') {
                $procedimento = $_POST['procedimento'];
            } else {
                $procedimento = null;
            }
            $sala = $_POST['sala'];
            $grupo = $_POST['grupo'];
            $empresa = $_POST['empresa'];
            $paciente_id = $_POST['paciente_id'];

            $dia = date("d", strtotime($item->data));
            $mes = date("m", strtotime($item->data));
            $ano = date("Y", strtotime($item->data));

//            $medico = $item->medico;

            $retorno['url'] = "../../../ambulatorio/exame/listarmultifuncaocalendariopaciente/$paciente_id?empresa=$empresa&grupo=$grupo&sala=$sala&tipoagenda=$tipoagenda&medico=$medico&situacao=$situacao&data=$dia%2F$mes%2F$ano&nome=$nome&procedimento=$procedimento";


            $var[] = $retorno;
        }
        echo json_encode($var);

//        foreach ($result2 as $value) {
//            $retorno['title'] =  'H: Ocupados: ' . $value->contagem_ocupado;
//            $retorno['start'] = $value->data;
//            $retorno['end'] = $value->data;
//            $retorno['color'] = '#0E9AA7';
//            $dia = date("d", strtotime($item->data));
//            $mes = date("m", strtotime($item->data));
//            $ano = date("Y", strtotime($item->data));
//            $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaoconsulta?empresa=&especialidade=&medico=&situacao=OK&data=$dia%2F$mes%2F$ano&nome=";
//            $var[] = $retorno;
//        }
    }

    function listarhorarioscalendarioexame() {
//            echo $_POST['custom_param1'];
        if (isset($_POST['medico']) || isset($_POST['especialidade']) || isset($_POST['empresa']) || isset($_POST['sala']) || isset($_POST['nome'])) {
            $result = $this->exametemp->listarhorarioscalendarioexame($_POST['medico'], $_POST['especialidade'], $_POST['empresa'], $_POST['sala'], $_POST['grupo'],@$_POST['nome']);
        } else {
            $result = $this->exametemp->listarhorarioscalendarioexame();
        }

        $var = Array();
        $i = 0;
//            $result2 = $this->exametemp->listarhorarioscalendarioocupado();

        foreach ($result as $item) {
            $i++;
            $retorno['id'] = $i;
            if ($item->situacao == 'LIVRE') {
                $retorno['title'] = 'V: ' . $item->contagem;
            } else {
                $retorno['title'] = 'M: ' . $item->contagem;
            }

            $retorno['start'] = $item->data;
            $retorno['end'] = $item->data;
            if ($item->situacao == 'LIVRE') {
                $retorno['color'] = '#62C462';
            } else {
                $retorno['color'] = '#B30802';
            }
            $situacao = $item->situacao;
            if (isset($item->medico)) {
                $medico = $item->medico;
            } else {
                $medico = null;
            }
            if ($_POST['especialidade']) {
                $especialidade = $_POST['especialidade'];
            } else {
                $especialidade = null;
            }
            if ($_POST['paciente'] != '') {
                $nome = $_POST['paciente'];
            } else {
                $nome = null;
            }
            $sala = $_POST['sala'];
            $grupo = $_POST['grupo'];
            $empresa = $_POST['empresa'];

            $dia = date("d", strtotime($item->data));
            $mes = date("m", strtotime($item->data));
            $ano = date("Y", strtotime($item->data));

//            $medico = $item->medico;

            $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaoexamecalendario?empresa=$empresa&grupo=$grupo&sala=$sala&especialidade=$especialidade&medico=$medico&situacao=$situacao&data=$dia%2F$mes%2F$ano&nome=$nome";


            $var[] = $retorno;
        }
        echo json_encode($var);

//        foreach ($result2 as $value) {
//            $retorno['title'] =  'H: Ocupados: ' . $value->contagem_ocupado;
//            $retorno['start'] = $value->data;
//            $retorno['end'] = $value->data;
//            $retorno['color'] = '#0E9AA7';
//            $dia = date("d", strtotime($item->data));
//            $mes = date("m", strtotime($item->data));
//            $ano = date("Y", strtotime($item->data));
//            $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaoconsulta?empresa=&especialidade=&medico=&situacao=OK&data=$dia%2F$mes%2F$ano&nome=";
//            $var[] = $retorno;
//        }
    }

    function listarhorarioscalendarioconsulta() {
//            echo $_POST['custom_param1'];
        $empresa_id = "";
        if (isset($_POST['medico']) || isset($_POST['tipoagenda']) || isset($_POST['empresa']) || isset($_POST['nome'])) {
              $empresa_id = $_POST['empresa'];
            $result = $this->exametemp->listarhorarioscalendarioconsulta($_POST['medico'], $_POST['tipoagenda'], $_POST['empresa'],@$_POST['nome']);
        } else {
            $result = $this->exametemp->listarhorarioscalendarioconsulta();
        }
      

        $var = Array();
        $i = 0;
//            $result2 = $this->exametemp->listarhorarioscalendarioocupado();

        foreach ($result as $item) {
            $i++;
            $retorno['id'] = $i;
            if ($item->situacao == 'LIVRE') {
                $retorno['title'] = 'V: ' . $item->contagem;
            } else {
                $retorno['title'] = 'M: ' . $item->contagem;
            }

            $retorno['start'] = $item->data;
            $retorno['end'] = $item->data;
            if ($item->situacao == 'LIVRE') {
                $retorno['color'] = '#62C462';
            } else {
                $retorno['color'] = '#B30802';
            }
            $situacao = $item->situacao;
            if (isset($item->medico)) {
                $medico = $item->medico;
            } else {
                $medico = null;
            }
            if ($_POST['tipoagenda']) {
                $tipoagenda = $_POST['tipoagenda'];
            } else {
                $tipoagenda = null;
            }
            if ($_POST['paciente'] != '') {
                $nome = $_POST['paciente'];
            } else {
                $nome = null;
            } 
            $dia = date("d", strtotime($item->data));
            $mes = date("m", strtotime($item->data));
            $ano = date("Y", strtotime($item->data)); 
//            $medico = $item->medico;

            $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaoconsultacalendario?empresa=$empresa_id&tipoagenda=$tipoagenda&medico=$medico&situacao=$situacao&data=$dia%2F$mes%2F$ano&nome=$nome";


            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function listarhorarioscalendarioespecialidade() {
//            echo $_POST['custom_param1'];
        if (isset($_POST['medico']) || isset($_POST['tipoagenda']) || isset($_POST['empresa']) || isset($_POST['nome'])) {
            $result = $this->exametemp->listarhorarioscalendarioespecialidade($_POST['medico'], $_POST['tipoagenda'], $_POST['empresa'],@$_POST['nome']);
        } else {
            $result = $this->exametemp->listarhorarioscalendarioespecialidade();
        }

        $var = Array();
        $i = 0;
//            $result2 = $this->exametemp->listarhorarioscalendarioocupado();

        foreach ($result as $item) {
            $i++;
            $retorno['id'] = $i;
            if ($item->situacao == 'LIVRE') {
                $retorno['title'] = 'V: ' . $item->contagem;
            } else {
                $retorno['title'] = 'M: ' . $item->contagem;
            }

            $retorno['start'] = $item->data;
            $retorno['end'] = $item->data;
            if ($item->situacao == 'LIVRE') {
                $retorno['color'] = '#62C462';
            } else {
                $retorno['color'] = '#B30802';
            }
            $situacao = $item->situacao;
            if (isset($item->medico)) {
                $medico = $item->medico;
            } else {
                $medico = null;
            }
            if (isset($_POST['especialidade']) && $_POST['especialidade']) {
                $especialidade = $_POST['especialidade'];
            } else {
                $especialidade = null;
            }
            if (isset($_POST['empresa']) && $_POST['empresa'] != '') {
                $empresa_id = $_POST['empresa'];
            } else {
                $empresa_id = '';
            }
            if (isset($_POST['paciente']) && $_POST['paciente'] != '') {
                $nome = $_POST['paciente'];
            } else {
                $nome = null;
            }

            $dia = date("d", strtotime($item->data));
            $mes = date("m", strtotime($item->data));
            $ano = date("Y", strtotime($item->data));

//            $medico = $item->medico;

            $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaoespecialidadecalendario?empresa=$empresa_id&especialidade=$especialidade&medico=$medico&situacao=$situacao&data=$dia%2F$mes%2F$ano&nome=$nome";


            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function centrocirurgicomedicos() {


        if (isset($_GET['term'])) {
            $result = $this->centrocirurgico->listarmedicocirurgiaautocomplete($_GET['term']);
        } else {
            $result = $this->centrocirurgico->listarmedicocirurgiaautocomplete();
        }
        foreach ($result as $item) {
            $retorno['nome'] = $item->nome;
            $retorno['id'] = $item->operador_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function alterardatacirurgiajson() {
//        var_dump(123);die;

        if (isset($_GET['solicitacao_id'])) {
            $this->centrocirurgico->alterardatacirurgiajson($_GET['solicitacao_id']);
            $retorno = true;
        } else {
            $retorno = false;
        }

        echo json_encode($retorno);
    }

    function pacientefaltantemuito(){
        $retorno = array();

        if (isset($_GET['paciente_id'])) {
            $empresa = $this->exametemp->qtdfaltas();

            $retorno = $this->exametemp->pacientefaltou($_GET['paciente_id']);

            if($retorno[0]->totalfaltas < $empresa){
                $retorno = array();
            }
        }

        echo json_encode($retorno);
    }

    function carregavalorprocedimentocirurgico() {

        if (isset($_GET['procedimento_id']) && isset($_GET['equipe_id'])) {
            $procedimento_valor = $this->procedimento->carregavalorprocedimentocirurgico($_GET['procedimento_id']);
            $equipe = $this->exame->listarquipeoperadores($_GET['equipe_id']);

            $valorProcedimento = ((float) ($procedimento_valor[0]->valor_total));
            $valorCirurgiao = 0;
            $valorAnestesista = 0;

            foreach ($equipe as $value) {
                if ($value->funcao == '00') {//cirurgiao
                } elseif ($value->funcao == '00') {//anestesista
                }
            }
        }
        echo json_encode($result);
    }

    function procedimentoconveniomedicocadastrosala() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentoconveniomedicocadastrosala($_GET['convenio1'], $_GET['teste'], $_GET['sala']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentoconveniomedicocadastrosala();
        }
        echo json_encode($result);
    }


    function nivel1diagnostico() {

        if (isset($_GET['opcoes'])) {
            $nivel1 = $this->guia->listarautocompletenivel1diagnostico($_GET['opcoes'], $_GET['diagnostico_id']);
        } else {
            $nivel1 = $this->guia->listarautocompletenivel1diagnostico();
        }


        foreach($nivel1 as $item){
            $arraynivel1  = json_decode($item->nivel1);
        }

        $id_opcoes = $_GET['opcoes'];


        $result = array_filter($arraynivel1, function ($setence) use ($id_opcoes) {
             return in_array($id_opcoes, explode('-', $setence));
        });

        foreach ($result as $key => $value) {
            $novoarray[] = $value;
        }

        // print_r($novoarray);


        echo json_encode($novoarray);
    }

    function nivel2diagnostico() {

        if (isset($_GET['nivel1'])) {
            $nivel2 = $this->guia->listarautocompletenivel2diagnostico($_GET['nivel1'], $_GET['diagnostico_id']);
        } else {
            $nivel2 = $this->guia->listarautocompletenivel2diagnostico();
        }


        foreach($nivel2 as $item){
            $arraynivel2  = json_decode($item->nivel2);
        }

        $id_opcoes = $_GET['nivel1'];

        $result = array_filter($arraynivel2, function ($setence) use ($id_opcoes) {
            return in_array($id_opcoes, explode('-', $setence));
        });

        foreach ($result as $key => $value) {
            $novoarray[] = $value;
        }

        echo json_encode($novoarray);
    }

    function nivel3diagnostico() {

        if (isset($_GET['nivel2'])) {
            $nivel3 = $this->guia->listarautocompletenivel3diagnostico($_GET['nivel2'], $_GET['diagnostico_id']);
        } else {
            $nivel3 = $this->guia->listarautocompletenivel3diagnostico();
        }


        foreach($nivel3 as $item){
            $arraynivel3  = json_decode($item->nivel3);
        }

        $id_opcoes = $_GET['nivel2'];

        $result = array_filter($arraynivel3, function ($setence) use ($id_opcoes) {
            return in_array($id_opcoes, explode('-', $setence));
        });

        foreach ($result as $key => $value) {
            $novoarray[] = $value;
        }

        echo json_encode($novoarray);
    }



    function procedimentoconveniomedicocadastro() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconveniomedicocadastro($_GET['convenio1'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconveniomedicocadastro();
        }
        echo json_encode($result);
    }

    function procedimentoconveniomedico() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconveniomedico($_GET['convenio1'], $_GET['teste'], $_GET['empresa_id'], @$_GET['grupo1'], @$_GET['especialidade']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconveniomedico();
        }
        echo json_encode($result);
    }

    function buscarsaldopacientefaturar() {
        if (isset($_GET['paciente_id'])) {

            $paciente_id = $_GET['paciente_id'];

            $saldoCredito = $this->exametemp->listarsaldocreditopaciente($paciente_id);
        }

        echo json_encode(array("saldo" => $saldoCredito[0]->saldo, "paciente_id" => $paciente_id));
    }

    function criarPastasPaciente() {
        $this->load->helper('directory');
        $pacientes = $this->exametemp->listarpacientecriarpasta();
//        echo '<pre>';
//        var_dump($pacientes);
//        die;
        if (!is_dir("./upload/paciente")) {
            mkdir("./upload/paciente");
            $destino = "./upload/paciente";
            chmod($destino, 0777);
        }

        foreach ($pacientes as $value) {
            if (!is_dir("./upload/paciente/$value->paciente_id")) {
                mkdir("./upload/paciente/$value->paciente_id");
                $destino = "./upload/paciente/$value->paciente_id";
                chmod($destino, 0777);
            }
        }
    }

    function moverLaudoPacienteAlbertoLima() {
        $this->load->helper('directory');

        echo '<pre>';
        //    var_dump($atendimentos);
//        die;
        $arquivos = directory_map("./upload/PDFAlberto");
        sort($arquivos);


        $arquivo_explode = explode('_', $arquivos[0]);
        $arquivo_Tipo = $arquivo_explode[1];
        $arquivo_Prontuario = $arquivo_explode[2];
        $arquivo_Data = $arquivo_explode[3];
        $arquivo_HoraHtml = explode('.', $arquivo_explode[4]);
        $arquivo_Hora = str_replace('-', ':', $arquivo_HoraHtml[0]);
        var_dump($arquivos);
        die;

        if (!is_dir("./upload/paciente")) {
            mkdir("./upload/paciente");
            $destino = "./upload/paciente";
            chmod($destino, 0777);
        }

        $this->db->where('paciente_id is not null');
        $this->db->delete('tb_laudoantigo');

        foreach ($arquivos as $item) {
            $arquivo_explode = explode('_', $item);
            $arquivo_Tipo = $arquivo_explode[1];
            $arquivo_Prontuario = $arquivo_explode[2];
            $arquivo_Data = $arquivo_explode[3];
            $arquivo_HoraHtml = explode('.', $arquivo_explode[4]);
            $arquivo_Hora = str_replace('-', ':', $arquivo_HoraHtml[0]);
            $data_hora = $arquivo_Data . ' ' . $arquivo_Hora;


            if (!is_dir("./upload/paciente/$arquivo_Prontuario")) {
                mkdir("./upload/paciente/$arquivo_Prontuario");
                $destino = "./upload/paciente/$arquivo_Prontuario";
                chmod($destino, 0777);
            }


            $origem = "./upload/PDFAlberto/$item";
            // $destino = "./upload/paciente/$arquivo_Prontuario/$item";
            // copy($origem, $destino);
            // chmod($origem, 0777);
            $html_enc = file_get_contents($origem);
            $html = ($html_enc);
            // var_dump($html);
            // die;
            // $inserir = $this->exametemp->inserirHtmlAlbertoLima($html, $data_hora, $arquivo_Prontuario);
            $this->db->set('nrcategoria', $arquivo_Tipo);
            $this->db->set('laudo', $html);
            if (strlen($data_hora) > 5) {
                $this->db->set('data_cadastro', $data_hora);
            }

            $this->db->set('paciente_id', $arquivo_Prontuario);
            $this->db->insert('tb_laudoantigo');
            // break;  
        }
    }

    function moverLaudoPacienteValeImagem() {
        $this->load->helper('directory');
        $atendimentos = $this->exametemp->listaridlaudovaleimagem();
        echo '<pre>';
//        var_dump($atendimentos);
//        die;
        $arquivos = directory_map("./upload/PDFVALE/");
        sort($arquivos);
//        var_dump($arquivos);
//        die;

        if (!is_dir("./upload/paciente")) {
            mkdir("./upload/paciente");
            $destino = "./upload/paciente";
            chmod($destino, 0777);
        }

        foreach ($atendimentos as $item) {
            if (in_array($item->IDagendaItens . ".pdf", $arquivos)) {
                if (!is_dir("./upload/paciente/$item->IDpacie")) {
                    mkdir("./upload/paciente/$item->IDpacie");
                    $destino = "./upload/paciente/$item->IDpacie";
                    chmod($destino, 0777);
                }
                var_dump($item);

                $origem = "./upload/PDFVALE/$item->IDagendaItens.pdf";
                $destino = "./upload/paciente/$item->IDpacie/$item->IDagendaItens.pdf";
                copy($origem, $destino);
            }
//            
        }
    }

    function buscarsaldopaciente() {

        if (isset($_GET['guia_id'])) {
            $paciente_id = $this->exametemp->listarpacienteporguia($_GET['guia_id']);
            $saldoCredito = $this->exametemp->listarsaldocreditopaciente($paciente_id);
        }

        echo json_encode(array("saldo" => $saldoCredito[0]->saldo, "paciente_id" => $paciente_id));
    }

    function buscarobscredito() {
        if (isset($_GET['guia_id'])) {
            $result = $this->exametemp->listarpacienteporguiaobs($_GET['guia_id'], $_GET['forma_pagamento_id']);
        } else {
//            $result = $this->armazem->armazemsaidaproduto();
        }
        echo json_encode($result);
    }

    function conveniopaciente() {
        if (isset($_GET['txtNomeid'])) {
            $result = $this->exametemp->listarautocompleteconveniopaciente($_GET['txtNomeid']);
        } else {
            $result = $this->exametemp->listarautocompleteconveniopaciente();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos2() {

        if (isset($_GET['convenio2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos3() {

        if (isset($_GET['convenio3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos4() {

        if (isset($_GET['convenio4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function classeportiposaidalista() {
        if (isset($_GET['nome'])) {
            $result = $this->financeiro_classe->listarautocompleteclassessaida($_GET['nome']);
        } else {
            $result = $this->financeiro_classe->listarautocompleteclassessaida();
        }
        echo json_encode($result);
    }

    function nivel2pornivel1saidalista() {
        if (isset($_GET['nome'])) {
            $result = $this->nivel2->listarautocompletenivel2saida($_GET['nome']);
        } else {
            $result = $this->nivel2->listarautocompletenivel2saida();
        }
        echo json_encode($result);
    }

    function tipopornivel2saidalista() {
        if (isset($_GET['nome'])) {
            $result = $this->tipo->listarautocompletetiposaida($_GET['nome']);
        } else {
            $result = $this->tipo->listarautocompletetiposaida();
        }
        echo json_encode($result);
    }

    function contaporempresa() {
        if (isset($_GET['empresa'])) {
            $result = $this->forma->listarautocompletecontaempresa($_GET['empresa']);
        } else {
            $result = $this->forma->listarautocompletecontaempresa();
        }
        echo json_encode($result);
    }

    function classeportiposaidalistadescricao() {
        if (isset($_GET['nome'])) {
            $result = $this->financeiro_classe->listarautocompleteclassessaidadescricao($_GET['nome']);
        } else {
            $result = $this->financeiro_classe->listarautocompleteclassessaidadescricao();
        }
        echo json_encode($result);
    }

    function classeportiposaidalistadescricaotodos() {
        if (isset($_GET['nome'])) {
            $result = $this->financeiro_classe->listarautocompleteclassessaidadescricaotodos($_GET['nome']);
        } else {
            $result = $this->financeiro_classe->listarautocompleteclassessaidadescricaotodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos5() {

        if (isset($_GET['convenio5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos6() {

        if (isset($_GET['convenio6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos7() {

        if (isset($_GET['convenio7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos8() {

        if (isset($_GET['convenio8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos9() {

        if (isset($_GET['convenio9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos10() {

        if (isset($_GET['convenio10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos11() {

        if (isset($_GET['convenio11'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio11']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos12() {

        if (isset($_GET['convenio12'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio12']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos13() {

        if (isset($_GET['convenio13'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio13']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos14() {

        if (isset($_GET['convenio14'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio14']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos15() {

        if (isset($_GET['convenio15'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio15']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioajustarvalor() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosajustarvalor($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosajustarvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio() {
        header('Access-Control-Allow-Origin: *');

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio1'],@$_GET['empresa_id']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function pacientesinternacao() {
        header('Access-Control-Allow-Origin: *');

        if (isset($_GET['paciente_id'])) {
            $result = $this->guia->listarpacientesinternacao($_GET['paciente_id']);
            $telefone = $result[0]->telefone;
            $data = date("Y-m-d");
            $nascimento = $result[0]->nascimento;
            $date_time = new DateTime($nascimento);
            $diff = $date_time->diff(new DateTime($data));
            $teste = $diff->format('%Y');
            $return = array($telefone, $teste);
//            var_dump($teste);die;
        } else {
            $result = $this->guia->listarpacientesinternacao();
        }
        echo json_encode($return);
    }

    function procedimentoconvenioaso() {
        header('Access-Control-Allow-Origin: *');
        if ($_GET['funcao'] != '') {
            $result = $this->exametemp->listarautocompleteprocedimentos2($_GET['funcao'], $_GET['empresa'], $_GET['setor']);
            // echo '<pre>';

            $json_exames = json_decode($result[0]->exames_id);
            // var_dump(count($json_exames));
            // var_dump($json_exames); die;

            if (count($json_exames) > 0) {
                $result2 = $this->saudeocupacional->listarautocompleteexamesjson2($json_exames);
                echo json_encode($result2);
            } else {
                $result2 = array();
                echo json_encode($result2);
            }
        } else {
            $result2 = array();
            echo json_encode($result2);
        }
    }
                    
//   function tipoasovalidade() { 
//        if (isset($_GET['tipo'])) {            
//            $result = $this->guia->listartipoasovalidade($_GET['tipo'], $_GET['empresa']);
//            $result2 = $result[0]->tipo_aso;
//        }
//        echo json_encode($result2);
//    }
                    
    function datavalidade356() {

        if (isset($_GET['tipo'])) {
            if ($_GET['modalidade'] == "conveniado") {
                $empresa = $_GET['empresa'];
            } else {
                $modelo = $this->guia->listarempresamodelo();
                $empresa = $modelo[0]->convenio_id;
            }
            $result1 = $this->guia->listartipoasovalidade($_GET['tipo'], $empresa);
            if (count($result1) > 0) {
                $result2 = $result1[0]->validade;
            } else {
                $result2 = 365;
            }
            $data = date("Y-m-d", strtotime(str_replace('/', '-', $_GET['data_realizacao'])));
            $result = date('d/m/Y', strtotime("+$result2 day", strtotime($data)));
        }
        echo json_encode($result);
    }

    function datavalidadenova() {

        if (isset($_GET['data_realizacao'])) {
            if ($_GET['modalidade'] == "conveniado") {
                $empresa = $_GET['empresa'];
            } else {
                $modelo = $this->guia->listarempresamodelo();
                $empresa = $modelo[0]->convenio_id;
            }
            $result1 = $this->guia->listartipoasovalidade($_GET['tipo'], $empresa);
            if (count($result1) > 0) {
                $result2 = $result1[0]->validade;
            } else {
                $result2 = 365;
            }
            $data = date("Y-m-d", strtotime(str_replace('/', '-', $_GET['data_realizacao'])));
            $result = date('d/m/Y', strtotime("+$result2 day", strtotime($data)));
        }
        echo json_encode($result);
    }

    function procedimentoconvenioatendimento() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosatendimento($_GET['convenio1'], @$_GET['grupo']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosatendimento();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioatendimentonovo() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosatendimentonovo($_GET['convenio1'], @$_GET['grupo']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosatendimentonovo();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioorcamento() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosorcamento($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosorcamento();
        }
        echo json_encode($result);
    }

    function procedimentoconveniofidelidadeweb() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosfidelidadeweb($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosfidelidadeweb();
        }
        echo json_encode($result);
    }

    function procedimentoconveniofaturar() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosfaturar($_GET['convenio1'], @$_GET['grupo1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosfaturar();
        }
        echo json_encode($result);
    }

    function procedimentoconveniointernacao() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentoconveniointernacao($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentoconveniointernacao();
        }
        echo json_encode($result);
    }

    function procedimentoconveniofaturarmatmed() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosfaturarmatmed($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosfaturarmatmed();
        }
        echo json_encode($result);
    }

    function conveniocarteira() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteconveniocarteira($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteconveniocarteira();
        }
        echo json_encode($result);
    }

    function procedimentoconveniogrupoexame() {
//        var_dump($_GET);die;
        if (isset($_GET['convenio1']) && isset($_GET['grupo1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupoexame($_GET['convenio1'], $_GET['grupo1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupoexame(@$_GET['convenio1'], @$_GET['grupo1']);
        }
        echo json_encode($result);
    }

    function procedimentoconveniogrupoorcamento() {
//        var_dump($_GET);die;
        if (isset($_GET['convenio1']) && isset($_GET['grupo1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupoorcamento($_GET['convenio1'], $_GET['grupo1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupoorcamento(@$_GET['convenio1'], @$_GET['grupo1']);
        }
        echo json_encode($result);
    }

    function cadastroexcecaoprocedimentoconveniogrupo() {

        if (isset($_GET['convenio1']) && isset($_GET['grupo1'])) {
            $result = $this->exametemp->listarautocompletecadastroexcecaoprocedimentosgrupo($_GET['convenio1'], $_GET['grupo1']);
        } else {
            $result = $this->exametemp->listarautocompletecadastroexcecaoprocedimentosgrupo(@$_GET['convenio1'], @$_GET['grupo1']);
        }

        echo json_encode($result);
    }

    function procedimentoagrupadorgrupo() {

        $result = $this->exametemp->listarautocompleteprocedimentoagrupadorgrupo($_GET['grupo1']);

        echo json_encode($result);
    }

    function procedimentoconveniogrupo() {

        if (isset($_GET['convenio1']) && isset($_GET['grupo1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupo($_GET['convenio1'], $_GET['grupo1'],@$_GET['empresa_id']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupo(@$_GET['convenio1'], @$_GET['grupo1'],@$_GET['empresa_id']);
        }

        echo json_encode($result);
    }

    function procedimentoconveniogrupobardeira() {

        if (isset($_GET['convenio1']) && isset($_GET['grupo1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupobardeira($_GET['convenio1'], $_GET['grupo1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupobardeira(@$_GET['convenio1'], @$_GET['grupo1']);
        }

        echo json_encode($result);
    }

    function procedimentoconveniogrupopadrao() {

        if (isset($_GET['convenio1']) && isset($_GET['grupo1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupopadrao($_GET['convenio1'], $_GET['grupo1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupopadrao(@$_GET['convenio1'], @$_GET['grupo1']);
        }

        echo json_encode($result);
    }

    function procedimentoconveniogrupopadraosadt() {

        if (isset($_GET['convenio1']) && isset($_GET['grupo1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupopadraosadt($_GET['convenio1'], $_GET['grupo1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupopadraosadt(@$_GET['convenio1'], @$_GET['grupo1']);
        }

        echo json_encode($result);
    }

    function procedimentoconveniogrupoajustemedico() {
        // var_dump($_GET['convenio1']); die;

        if (isset($_GET['convenio1']) && isset($_GET['grupo1'])) {
            $result = $this->procedimentoplano->procedimentoconveniogrupoajustemedico($_GET['convenio1'], $_GET['grupo1']);
        } else {
            $result = $this->procedimentoplano->procedimentoconveniogrupoajustemedico(@$_GET['convenio1'], @$_GET['grupo1']);
        }

        echo json_encode($result);
    }

//    function funcaosetormt() {
//        header('Access-Control-Allow-Origin: *');
//        if (isset($_GET['setor'])) {
//            $result = $this->saudeocupacional->listarautocompletefuncaosetormt($_GET['setor']);
//        } else {
//            $result = $this->saudeocupacional->listarautocompletefuncaosetormt(@$_GET['setor']);
//        }
//
//        $json_funcao = json_decode($result[0]->aso_funcao_id);
//
//        $result2 = $this->saudeocupacional->listarautocompletesetorjson($json_funcao);
//
//        echo json_encode($result2);
//    }

    function funcaosetormt2() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['setor'])) {
            $result = $this->convenio->listarautocompletefuncao($_GET['setor'], $_GET['empresa']);
        } else {
            $result = $this->convenio->listarautocompletefuncao(@$_GET['setor']);
        }

//        $json_funcao = json_decode($result[0]->aso_funcao_id);
//
//        $result2 = $this->saudeocupacional->listarautocompletesetorjson($json_funcao);

        echo json_encode($result);
    }

//    function setorempresamt() {
//        header('Access-Control-Allow-Origin: *');
//        if (isset($_GET['convenio1'])) {
//            $result = $this->saudeocupacional->listarautocompletesetorempresamt($_GET['convenio1']);
//        } else {
//            $result = $this->saudeocupacional->listarautocompletesetorempresamt(@$_GET['convenio1']);
//        }
//
//        echo json_encode($result);
//    }

    function setorempresamt2() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['convenio1'])) {
            $result = $this->convenio->listarautocompletesetor($_GET['convenio1']);
        } else {
            $result = $this->convenio->listarautocompletesetor(@$_GET['convenio1']);
        }

        echo json_encode($result);
    }

    function medcoordenador() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['convenio1'])) {
            $result = $this->convenio->listarautocompletecoordenador($_GET['convenio1']);
        } else {
            $result = $this->convenio->listarautocompletecoordenador(@$_GET['convenio1']);
        }

        echo json_encode($result);
    }

    function medcoordenadorparticular() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['convenio1'])) {
            $result = $this->convenio->listarautocompletecoordenadorparticular($_GET['convenio1']);
        } else {
            $result = $this->convenio->listarautocompletecoordenadorparticular(@$_GET['convenio1']);
        }

        echo json_encode($result);
    }

    function perfiloperador() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['perfil_id'])) {
            $result = $this->operador_m->listarautocompleteoperador($_GET['perfil_id']);
        } else {
            $result = $this->operador_m->listarautocompleteoperador(@$_GET['perfil_id']);
        }

        echo json_encode($result);
    }

    function procedimentoparticular() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['aso_id'])) {
            $result = $this->guia->listarprocedimentoparticular($_GET['aso_id']);
        } else {
            $result = $this->guia->listarriscosparticular(@$_GET['aso_id']);
        }

        $impressao_decode = json_decode($result[0]->impressao_aso);
        $json_procedimentos = $impressao_decode->procedimento1;
//        var_dump($json_procedimentos);die;
        $result2 = $this->saudeocupacional->listarautocompleteprocedimentojson2($json_procedimentos);

        echo json_encode($result2);
    }

    function riscofuncaomt() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['aso_id'])) {
            $result = $this->guia->listarriscosparticular($_GET['aso_id']);
        } else {
            $result = $this->guia->listarriscosparticular(@$_GET['aso_id']);
        }
        $impressao_decode = json_decode($result[0]->impressao_aso);
        $json_riscos = $impressao_decode->riscos;
//        var_dump($impressao_decode->riscos);die;
        $result2 = $this->saudeocupacional->listarautocompletefuncaojson2($json_riscos);

        echo json_encode($result2);
    }

    function riscofuncaomt2() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['funcao'])) {
            $result = $this->convenio->listarautocompleteriscos($_GET['funcao'], $_GET['setor'], $_GET['empresa']);

//            var_dump($result);die;
        } else {
            $result = $this->convenio->listarautocompleteriscos(@$_GET['funcao']);
        }

        $json_riscos = json_decode($result[0]->risco_id);

        $result2 = $this->saudeocupacional->listarautocompletefuncaojson2($json_riscos);

        echo json_encode($result2);
    }

    function listargruposala() {
        if (isset($_GET['sala'])) {
            $result = $this->exametemp->listarautocompletegruposala($_GET['sala']);
        }

        echo json_encode($result);
    }

    function listarsalaporgrupo() {
        if (isset($_GET['grupo1'])) {
            $result = $this->exametemp->listarautocompletesalaporgrupo($_GET['grupo1']);
        }

        echo json_encode($result);
    }

    function listarmedicoprocedimentoconvenio() {
//        var_dump($_GET);die;
        if (isset($_GET['procedimento'])) {
            $result = $this->exametemp->listarautocompletemedicoporprocedimento($_GET['procedimento']);
        }else{
            $result = $this->operador_m->listarmedicos();
        }  
        
        echo json_encode($result);
    }

    function procedimentoconveniogrupomedico() {
//        var_dump($_GET);die;
        if (isset($_GET['convenio1']) && isset($_GET['grupo1']) && isset($_GET['teste'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupomedico($_GET['convenio1'], $_GET['grupo1'], $_GET['teste']);
        }

        echo json_encode($result);
    }

    function procedimentoporconvenio() {

        if (isset($_GET['covenio'])) {
            $result = $this->procedimentoplano->listarautocompleteprocedimentos($_GET['covenio']);
        } else {
            $result = $this->procedimentoplano->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoporconveniobardeira() {

        if (isset($_GET['covenio'])) {
            $result = $this->procedimentoplano->listarautocompleteprocedimentosbardeira($_GET['covenio']);
        } else {
            $result = $this->procedimentoplano->listarautocompleteprocedimentosbardeira();
        }
        echo json_encode($result);
    }

    function procedimentoporconvenioajustemedico() {
        // var_dump($_GET['covenio']); die;
        if (isset($_GET['covenio'])) {
            $result = $this->procedimentoplano->procedimentoporconvenioajustemedico($_GET['covenio']);
        } else {
            $result = $this->procedimentoplano->procedimentoporconvenioajustemedico();
        }
        echo json_encode($result);
    }

    function estoqueclasseportipo() {

        if (isset($_GET['tipo_id'])) {
            $result = $this->menu->listarautocompleteclasseportipo($_GET['tipo_id']);
        } else {
            $result = $this->menu->listarautocompleteclasseportipo();
        }
        echo json_encode($result);
    }

    function estoquesubclasseporclasse() {

        if (isset($_GET['classe_id'])) {
            $result = $this->menu->listarautocompletesubclasseporclasse($_GET['classe_id']);
        } else {
            $result = $this->menu->listarautocompletesubclasseporclasse();
        }
        echo json_encode($result);
    }

    function estoqueprodutosporsubclasse() {

        if (isset($_GET['subclasse_id'])) {
            $result = $this->menu->listarautocompleteprodutosporsubclasse($_GET['subclasse_id']);
        } else {
            $result = $this->menu->listarautocompleteprodutosporsubclasse();
        }
        echo json_encode($result);
    }

    function formapagamentoorcamento() {
        $forma = $_GET['formapamento1'];
        if (isset($forma)) {
            $result = $this->formapagamento->buscarformapagamentoorcamento($forma);
        }
        echo json_encode($result);
    }

    function formapagamento($forma) {

        if (isset($forma)) {
            $result = $this->formapagamento->buscarforma($forma);
        } else {
            $result = $this->formapagamento->buscarforma();
        }
        echo json_encode($result);
    }

    function classeportipo() {

        if (isset($_GET['tipo'])) {
            $result = $this->financeiro_classe->listarautocompleteclasse($_GET['tipo']);
        } else {
            $result = $this->financeiro_classe->listarautocompleteclasse();
        }
        echo json_encode($result);
    }

    function classeportiposaida() {

        if (isset($_GET['tipo'])) {
            $result = $this->financeiro_classe->listarautocompleteclassessaida($_GET['tipo']);
        } else {
            $result = $this->financeiro_classe->listarautocompleteclassessaida();
        }
        echo json_encode($result);
    }

    function medicoconveniogeral() {

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarautocompletemedicoconveniogeral($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconveniogeral();
        }
//        echo "<pre>";
//        var_dump($result); die;
        echo json_encode($result);
    }

    function medicoconvenio() {

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconveniojson() {

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenioencaixe($_GET['exame'], $_GET['empresa_id']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenioencaixe();
        }
        echo json_encode($result);
    }

    function medicoconvenio1() {

        if (isset($_GET['medico_id1'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id1']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio2() {

        if (isset($_GET['medico_id2'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id2']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio3() {

        if (isset($_GET['medico_id3'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id3']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio4() {

        if (isset($_GET['medico_id4'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id4']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio5() {

        if (isset($_GET['medico_id5'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id5']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio6() {

        if (isset($_GET['medico_id6'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id6']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio7() {

        if (isset($_GET['medico_id7'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id7']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio8() {

        if (isset($_GET['medico_id8'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id8']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio9() {

        if (isset($_GET['medico_id9'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id9']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio10() {

        if (isset($_GET['medico_id10'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id10']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio11() {

        if (isset($_GET['medico_id11'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id11']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio12() {

        if (isset($_GET['medico_id12'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id12']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio13() {

        if (isset($_GET['medico_id13'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id13']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio14() {

        if (isset($_GET['medico_id14'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id14']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio15() {

        if (isset($_GET['medico_id15'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id15']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function procedimentoformapagamento() {

        if (isset($_GET['txtpagamento'])) {
            $result = $this->procedimentoplano->listarautocompleteformapagamento($_GET['txtpagamento']);
        } else {
            $result = $this->procedimentoplano->listarautocompleteformapagamento();
        }
//        var_dump($result); die;
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->forma_pagamento_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimentoconveniomultiempresa() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosmultiempresa($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosmultiempresa();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio1'],@$_GET['empresa_id']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentoconveniofisioterapia() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosfisioterapia($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosfisioterapia();
        }
        echo json_encode($result);
    }

    function procedimentoconveniopsicologia() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentospsicologia($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentospsicologia();
        }
        echo json_encode($result);
    }

    function procedimentovalor() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento1'], @$_GET['valor_tcd']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalororcamento() {
        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor2($_GET['procedimento1'], $_GET['convenio']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor2();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia2() {

        if (isset($_GET['procedimento2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia3() {

        if (isset($_GET['procedimento3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia4() {

        if (isset($_GET['procedimento4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia5() {

        if (isset($_GET['procedimento5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia6() {

        if (isset($_GET['procedimento6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia7() {

        if (isset($_GET['procedimento7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia8() {

        if (isset($_GET['procedimento8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia9() {

        if (isset($_GET['procedimento9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia10() {

        if (isset($_GET['procedimento10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia11() {

        if (isset($_GET['procedimento11'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento11']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia12() {

        if (isset($_GET['procedimento12'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento12']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia13() {

        if (isset($_GET['procedimento13'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento13']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia14() {

        if (isset($_GET['procedimento14'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento14']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia15() {

        if (isset($_GET['procedimento15'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento15']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorpsicologia() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio2() {

        if (isset($_GET['convenio2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta2() {

        if (isset($_GET['convenio2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor2() {

        if (isset($_GET['procedimento2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio3() {

        if (isset($_GET['convenio3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta3() {

        if (isset($_GET['convenio3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor3() {

        if (isset($_GET['procedimento3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio4() {

        if (isset($_GET['convenio4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta4() {

        if (isset($_GET['convenio4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor4() {

        if (isset($_GET['procedimento4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio5() {

        if (isset($_GET['convenio5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta5() {

        if (isset($_GET['convenio5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor5() {

        if (isset($_GET['procedimento5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio6() {

        if (isset($_GET['convenio6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta6() {

        if (isset($_GET['convenio6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor6() {

        if (isset($_GET['procedimento6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio7() {

        if (isset($_GET['convenio7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta7() {

        if (isset($_GET['convenio7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor7() {

        if (isset($_GET['procedimento7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio8() {

        if (isset($_GET['convenio8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta8() {

        if (isset($_GET['convenio8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor8() {

        if (isset($_GET['procedimento8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio9() {

        if (isset($_GET['convenio9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta9() {

        if (isset($_GET['convenio9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor9() {

        if (isset($_GET['procedimento9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio10() {

        if (isset($_GET['convenio10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta10() {

        if (isset($_GET['convenio10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor10() {

        if (isset($_GET['procedimento10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento1() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma($_GET['procedimento1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento2() {

        if (isset($_GET['procedimento2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma($_GET['procedimento2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento3() {

        if (isset($_GET['procedimento3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma($_GET['procedimento3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento4() {

        if (isset($_GET['procedimento4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma($_GET['procedimento4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento5() {

        if (isset($_GET['procedimento5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma($_GET['procedimento5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento6() {

        if (isset($_GET['procedimento6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma($_GET['procedimento6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento7() {

        if (isset($_GET['procedimento7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma($_GET['procedimento7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento8() {

        if (isset($_GET['procedimento8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma($_GET['procedimento8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento9() {

        if (isset($_GET['procedimento9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma($_GET['procedimento9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento10() {

        if (isset($_GET['procedimento10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma($_GET['procedimento10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentoconvenioforma();
        }
        echo json_encode($result);
    }

    function verificaAjustePagamentoProcedimento() {

        if (isset($_GET['procedimento'])) {
            $result = $this->exametemp->verificaAjustePagamentoProcedimento($_GET['procedimento']);
        }
        echo json_encode($result);
    }

    function buscaValorAjustePagamentoProcedimento() {
        $result = array();
        if (isset($_GET['procedimento']) && isset($_GET['forma'])) {
            $result = $this->exametemp->buscaValorAjustePagamentoProcedimento($_GET['procedimento'], $_GET['forma']);
        }
//        var_dump($result); die;
        echo json_encode($result);
    }

    function buscaValorAjustePagamentoFaturar() {
        $result = array();
        if (isset($_GET['procedimento']) && isset($_GET['forma'])) {
            $result = $this->exametemp->buscaValorAjustePagamentoFaturar($_GET['procedimento'], $_GET['forma']);
        }
//        var_dump($result); die;
        echo json_encode($result);
    }

    function credordevedor() {

        if (isset($_GET['term'])) {
            $result = $this->contaspagar->listarautocompletecredro($_GET['term']);
        } else {
            $result = $this->contaspagar->listarautocompletecredro();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->razao_social;
            $retorno['id'] = $item->financeiro_credor_devedor_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function modeloslaudo() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelos($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelos();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelosgrupo() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->internacao_m->listarautocompletemodelosgrupo($_GET['exame']);
        } else {
            $result = $this->internacao_m->listarautocompletemodelosgrupo();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelosdeclaracao() {

        if (isset($_GET['modelo'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelosdeclaracao($_GET['modelo']);
        } else {
            $result = $this->exametemp->listarautocompletemodelosdeclaracao();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelosreceita() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelosreceita($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelosreceita();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelorotinamedico() {

        if (isset($_GET['medico'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelorotinamedico($_GET['medico']);
        } else {
            $result = $this->exametemp->listarautocompletemodelorotinamedico();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelosrotina() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelosrotina($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelosrotina();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function repetirreceituario() {

        if (isset($_GET['receita'])) {

            $result = $this->laudo->listarautocompleterepetirreceituario($_GET['receita']);
        } else {
            $result = $this->laudo->listarautocompleterepetirreceituario();
        }
        echo json_encode($result);
    }


    function repetirreceituariopormes() {

        if (isset($_GET['receita'])) {

            $result = $this->laudo->repetirreceituariopormes($_GET['receita'], $_GET['meses']);
        } else {
            $result = $this->laudo->repetirreceituariopormes();
        }
        echo json_encode($result);
    }

    function salvarreceita_rapido() {

        if (isset($_GET['ambulatorio_receituario_id'])) {

            $result = $this->laudo->salvarreceita_rapido($_GET['ambulatorio_receituario_id'], $_GET['texto']);
        } else {
            $result = $this->laudo->salvarreceita_rapido();
        }
        echo json_encode($result);
    }

    function salvarexames_rapido() {

        if (isset($_GET['ambulatorio_exame_id'])) {

            $result = $this->laudo->salvarexames_rapido($_GET['ambulatorio_exame_id'], $_GET['texto']);
        } else {
            $result = $this->laudo->salvarexames_rapido();
        }
        echo json_encode($result);
    }

    function salvarterapeuticas_rapido() {

        if (isset($_GET['ambulatorio_terapeutica_id'])) {

            $result = $this->laudo->salvarterapeuticas_rapido($_GET['ambulatorio_terapeutica_id'], $_GET['texto']);
        } else {
            $result = $this->laudo->salvarterapeuticas_rapido();
        }
        echo json_encode($result);
    }

    function salvarrelatorios_rapido() {

        if (isset($_GET['ambulatorio_relatorio_id'])) {

            $result = $this->laudo->salvarrelatorios_rapido($_GET['ambulatorio_relatorio_id'], $_GET['texto']);
        } else {
            $result = $this->laudo->salvarrelatorios_rapido();
        }
        echo json_encode($result);
    }

    function imprimirtudo(){
        print_r($_GET['impressoes']);
    }

    function repetirexame() {

        if (isset($_GET['exame_id'])) {

            $result = $this->laudo->listarautocompleterepetirexame($_GET['exame_id']);
        } else {
            $result = $this->laudo->listarautocompleterepetirexame();
        }
        echo json_encode($result);
    }

    function repetirrotina() {

        if (isset($_GET['rotina'])) {

            $result = $this->laudo->listarautocompleterepetirrotina($_GET['rotina']);
        } else {
            $result = $this->laudo->listarautocompleterepetirrotina();
        }
        echo json_encode($result);
    }

    function editarreceituario() {

        if (isset($_GET['receita'])) {

            $result = $this->laudo->listarautocompleteeditarreceituario($_GET['receita']);
        } else {
            $result = $this->laudo->listarautocompleteeditarreceituario();
        }
        echo json_encode($result);
    }

    function modelosatestado() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelosatestado($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelosatestado();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelossolicitarexames() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelossolicitarexames($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelossolicitarexames();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelossolicitarexamesPreenchido() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelossolicitarexames($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelossolicitarexames();
            //$result = 'oi nao';
        }
        if (count($result) > 0) {
            $laudo = $this->laudo->listarlaudo($_GET['ambulatorio_laudo_id']);


            if (file_exists("upload/1ASSINATURAS/" . $laudo[0]->medico_parecer1 . ".jpg")) {
                $assinatura = "<img src='" . base_url() . "./upload/1ASSINATURAS/" . $laudo[0]->medico_parecer1 . ".jpg'>";
            } else {
                $assinatura = "";
            }
            $corpo = $result[0]->texto;
            $corpo = str_replace("_paciente_", @$laudo['0']->paciente, $corpo);
            $corpo = str_replace("_sexo_", @$laudo['0']->sexo, $corpo);
            $corpo = str_replace("_nascimento_", date("d/m/Y", strtotime(@$laudo['0']->nascimento)), $corpo);
            $corpo = str_replace("_convenio_", @$laudo['0']->convenio, $corpo);
            $corpo = str_replace("_sala_", @$laudo['0']->sala, $corpo);
            $corpo = str_replace("_CPF_", @$laudo['0']->cpf, $corpo);
            $corpo = str_replace("_solicitante_", @$laudo['0']->solicitante, $corpo);
            $corpo = str_replace("_data_", substr(@$laudo['0']->data_cadastro, 8, 2) . '/' . substr(@$laudo['0']->data_cadastro, 5, 2) . '/' . substr(@$laudo['0']->data_cadastro, 0, 4), $corpo);
            $corpo = str_replace("_medico_", @$laudo['0']->medico, $corpo);
            $corpo = str_replace("_revisor_", @$laudo['0']->medicorevisor, $corpo);
            $corpo = str_replace("_procedimento_", @$laudo['0']->procedimento, $corpo);
            $corpo = str_replace("_laudo_", @$laudo['0']->texto, $corpo);
            $corpo = str_replace("_nomedolaudo_", @$laudo['0']->cabecalho, $corpo);
            $corpo = str_replace("_queixa_", @$laudo['0']->cabecalho, $corpo);
            $corpo = str_replace("_peso_", @$laudo['0']->peso, $corpo);
            $corpo = str_replace("_altura_", @$laudo['0']->altura, $corpo);
            $corpo = str_replace("_cid1_", @$laudo['0']->cid1, $corpo);
            $corpo = str_replace("_cid2_", @$laudo['0']->cid2, $corpo);
            $corpo = str_replace("_assinatura_", '', $corpo);

            $result[0]->texto = $corpo;
        }
        echo json_encode($result);
    }

    function medicamentounidade() {

        if (isset($_GET['unidade'])) {
            $result = $this->exametemp->listarautocompletemedicamentounidade($_GET['unidade']);
        } else {
            $result = $this->exametemp->listarautocompletemedicamentounidade();
        }
        foreach ($result as $item) {
            $retorno['id'] = $item->unidade_id;
            $retorno['value'] = $item->descricao;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function verificaremailpaciente(){
        $email = $_GET['email'];
        $mensagem = '';

        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $mensagem = '';
        }else{
            $mensagem = 'E-mail com Formato Invalido';
        }

        echo json_encode($mensagem);
    }

    function verificarcpfpaciente() {
        $cpf = $_GET['cpf'];
        $cpf_responsavel = $_GET['cpf_responsavel'];
        $paciente_id = $_GET['paciente_id'];
        $mensagem = '';
        if ($cpf != "" && $cpf != "000.000.000-00") {
            if ($this->utilitario->validaCPF($cpf)) {
                $contadorcpf = $this->paciente_m->contadorcpfautocomplete($cpf, $paciente_id);
                if ($cpf_responsavel == 'on') {
                    $contadorcpf = 0;
                }
                if ($contadorcpf > 0) {
                    $mensagem = 'CPF do paciente já cadastrado';
                }
            } else {
                $mensagem = 'Erro ao gravar paciente. CPF inválido';
            }
        }
        echo json_encode($mensagem);
    }

    function gerarSenha() {
        // http://ip do raspberry/painel-api/api/painel/senhas/chamarProximo
        $endereco_toten = $this->session->userdata('endereco_toten');
        $url = $endereco_toten . "/painel-api/api/painel/senhas";
        // var_dump($endereco_toten); die;
        $data = array("tipo_senha_id" => '1');
        $dataEND = array(
            "data" => http_build_query($data),
            "url" => $url,
            "tipo" => 'POST'
        );

        $response = $this->enviarRequisicaoPainel($dataEND);
        if (isset($response)) {
            return json_decode($response);
        } else {
            return false;
        }
    }

    function listarGuiche() {
        // http://ip do raspberry/painel-api/api/painel/senhas/chamarProximo
        $endereco_toten = $this->session->userdata('endereco_toten');
        $url = $endereco_toten . "/painel-api/api/painel/guiches/guichesDisponiveis";
        // var_dump($endereco_toten); die;
        $data = array();
        $dataEND = array(
            "data" => http_build_query($data),
            "url" => $url,
            "tipo" => 'GET'
        );

        $response = $this->enviarRequisicaoPainel($dataEND);
        if (isset($response)) {
            return json_decode($response);
        } else {
            return false;
        }
    }

    function listarSenhas() {
        // http://ip do raspberry/painel-api/api/painel/senhas/chamarProximo
        $endereco_toten = $this->session->userdata('endereco_toten');
        $url = $endereco_toten . "/painel-api/api/painel/senhas";
        // var_dump($endereco_toten); die;
        $data = array();
        $dataEND = array(
            "data" => http_build_query($data),
            "url" => $url,
            "tipo" => 'GET'
        );

        $response = $this->enviarRequisicaoPainel($dataEND);
        if (isset($response)) {
            $obj = json_decode($response);
            $json = json_encode($obj);
            echo $json;
        } else {
            echo json_encode('false');
        }
    }

    function chamarSenhas($guiche_id) {
        // http://ip do raspberry/painel-api/api/painel/senhas/chamarProximo
        $endereco_toten = $this->session->userdata('endereco_toten');
        $url = $endereco_toten . "/painel-api/api/painel/senhas/chamarProximo";
        // var_dump($endereco_toten); die;
        $data = array("guiche_id" => $guiche_id);
        $dataEND = array(
            "data" => http_build_query($data),
            "url" => $url,
            "tipo" => 'PUT'
        );

        $response = $this->enviarRequisicaoPainel($dataEND);
        // var_dump($response); die;
        if (isset($response)) {
            $obj = json_decode($response);
            if (isset($obj->error)) {
                $this->chamarUltimaSenha($guiche_id);
            } else {
                echo $response;
            }
        } else {
            echo json_encode('false');
        }
    }

    function chamarUltimaSenha($guiche_id) {
        // http://ip do raspberry/painel-api/api/painel/senhas/chamarProximo
        $endereco_toten = $this->session->userdata('endereco_toten');
        $url = $endereco_toten . "/painel-api/api/painel/senhas/chamarNovamente";

        $data = array("guiche_id" => $guiche_id);
        $dataEND = array(
            "data" => http_build_query($data),
            "url" => $url,
            "tipo" => 'PUT'
        );

        $response = $this->enviarRequisicaoPainel($dataEND);
        if (isset($response)) {
            echo $response;
        } else {
            echo json_encode('false');
        }
    }

    function chamarProximo($senha_id) {
        // http://ip do raspberry/painel-api/api/painel/senhas/chamarProximo
        $endereco_toten = $this->session->userdata('endereco_toten');
        $url = $endereco_toten . "/painel-api/api/painel/pacientes/chamarProximo";
        // var_dump($endereco_toten); die;
        $data = array("senha_id" => $senha_id);
        $dataEND = array(
            "data" => http_build_query($data),
            "url" => $url,
            "tipo" => 'GET'
        );

        $response = $this->enviarRequisicaoPainel($dataEND);
        if (isset($response)) {
            echo $response;
        } else {
            echo json_encode('false');
        }
    }

    function chamarPorSenha($senha_id) {
        // http://ip do raspberry/painel-api/api/painel/senhas/chamarProximo
        $endereco_toten = $this->session->userdata('endereco_toten');
        $url = $endereco_toten . "/painel-api/api/painel/pacientes/chamarPorSenha";
        // var_dump($endereco_toten); die;
        $data = array("senha_id" => $senha_id);
        $dataEND = array(
            "data" => http_build_query($data),
            "url" => $url,
            "tipo" => 'POST'
        );

        $response = $this->enviarRequisicaoPainel($dataEND);
        if (isset($response)) {
            echo $response;
        } else {
            echo json_encode('false');
        }
    }

    function listarSalasPainel() {
        // http://ip do raspberry/painel-api/api/painel/senhas/chamarProximo
        $endereco_toten = $this->session->userdata('endereco_toten');
        $url = $endereco_toten . "/painel-api/api/painel/salas";

        $data = array();
        $dataEND = array(
            "data" => http_build_query($data),
            "url" => $url,
            "tipo" => 'GET'
        );

        $response = $this->enviarRequisicaoPainel($dataEND);
        if (isset($response)) {
            echo $response;
        } else {
            echo json_encode('false');
        }
    }

    function atenderSenha($guiche_id, $agenda_exames_id) {
        // http://ip do raspberry/painel-api/api/painel/senhas/atenderSenha
        $endereco_toten = $this->session->userdata('endereco_toten');
        $url = $endereco_toten . "/painel-api/api/painel/senhas/atenderSenha";

        $paciente_id = $this->criarPacientePainel($agenda_exames_id);
        $medico_id = $this->criarMedicoPainel($agenda_exames_id);
        $sala_id = $this->retornoSalaPainel($agenda_exames_id);
        if (!$paciente_id > 0 || !$medico_id > 0 || !$sala_id > 0) {
            echo json_encode('false');
            return false;
        }

        // echo '<pre>';
        // var_dump($guiche_id); 
        // var_dump($agenda_exames_id); 
        // die;
        $data = array("guiche_id" => (int) $guiche_id,
            "paciente_id" => (int) $paciente_id,
            "medico_id" => (int) $medico_id,
            "sala_id" => (int) $sala_id,
        );
        $dataEND = array(
            "data" => http_build_query($data),
            "url" => $url,
            "tipo" => 'PUT'
        );

        $response = $this->enviarRequisicaoPainel($dataEND);

        // var_dump($data); 
        // die;
        $obj = json_decode($response);
        // echo '<pre>';
        // var_dump($obj);

        if (isset($obj->id)) {
            $gravar = $this->guia->gravarIDSenha($agenda_exames_id, $obj->id);
            echo json_encode('true');
        } else {
            echo json_encode('false');
        }
    }

    function criarPacientePainel($agenda_exames_id) {
        $endereco_toten = $this->session->userdata('endereco_toten');
        $url = $endereco_toten . "/painel-api/api/painel/pacientes";

        $exame = $this->guia->listarexamepainel($agenda_exames_id);
        $nome = $exame[0]->paciente;
        $cpf = $exame[0]->cpf;

        $data = array("nome" => $nome,
            "cpf" => $cpf
        );

        $dataEND = array(
            "data" => http_build_query($data),
            "url" => $url,
            "tipo" => 'POST'
        );
        // var_dump($endereco_toten); die;

        $response = $this->enviarRequisicaoPainel($dataEND);
        if (isset($response)) {
            $obj = json_decode($response);
            return $obj->id;
        } else {
            echo false;
        }
    }

    function criarMedicoPainel($agenda_exames_id) {
        $endereco_toten = $this->session->userdata('endereco_toten');
        $url = $endereco_toten . "/painel-api/api/painel/medicos";

        $exame = $this->guia->listarexamepainel($agenda_exames_id);
        $email = ($exame[0]->email != '') ? $exame[0]->email : 'teste@teste.com';
        $nome = $exame[0]->medico;
        $perfil_id = $exame[0]->perfil_id;
        $operador_id = $exame[0]->operador_id;
        $objeto = new stdClass;
        $objeto->name = $nome;
        $objeto->perfil_id = $perfil_id;
        $objeto->password = $nome . $operador_id;
        $objeto->email = $email;
        $objeto->medico = true;
        $json = json_encode($objeto);
        $data = array("name" => $nome,
            "perfil_id" => $perfil_id,
            "email" => $email,
            "medico" => true,
            "password" => $objeto->password,
        );

        // $data = array("json" => $json);

        $dataEND = array(
            "data" => http_build_query($data),
            "url" => $url,
            "tipo" => 'GET'
        );


        // $response = $this->enviarRequisicaoPainel($dataEND);
        // echo '<pre>';
        // var_dump($response); 
        // die;
        return $exame[0]->id;
    }

    function retornoSalaPainel($agenda_exames_id) {
        $exame = $this->guia->listarexamepainel($agenda_exames_id);
        return $exame[0]->sala_painel_id;
    }

    function enviarRequisicaoPainel($dataEND) {
        $data = $dataEND['data'];
        $tipo = $dataEND['tipo'];
        $url = $dataEND['url'];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $tipo);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);
        // echo '<pre>';
        // var_dump($response); die;
        return $response;
    }

    function modelosreceitaespecial() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelosreceitaespecial($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelosreceitaespecial();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function solicitarparecersubrotina() {

        if (isset($_GET['especialidade_parecer'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarsolicitarparecersubrotina($_GET['especialidade_parecer']);
        } else {
            $result = $this->exametemp->listarsolicitarparecersubrotina();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modeloslinhas() {

        if (isset($_GET['linha'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletelinha($_GET['linha']);
        } else {
            $result = $this->exametemp->listarautocompletelinha();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function carimbomedico() {

        if (isset($_GET['medico_id'])) {
            //$result = 'oi';
            $result = $this->operador_m->carimbomedico($_GET['medico_id']);
        } else {
            $result = $this->operador_m->carimbomedico();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function assinaturamedico() {
        $medico_id = $_GET['medico_id'];
        if (file_exists("upload/1ASSINATURAS/" . $medico_id . ".jpg")) {
            $assinatura = "<img src='" . base_url() . "./upload/1ASSINATURAS/" . $medico_id . ".jpg'>";

            $path = "./upload/1ASSINATURAS/" . $medico_id . ".jpg";
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            // var_dump($data); die;
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            //$assinatura = "<img style='display: block; margin-left: 40%;' src='$base64'>";

            $assinatura = "<img src='$base64'>";
        } else {
            $assinatura = "";
        }

        echo json_encode($assinatura);
    }

    function medicoespecialidadetodos() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['txtcbo'])) {
            $result = $this->operador_m->listarmedicosespecialidade($_GET['txtcbo']);
        } else {
            $result = $this->operador_m->listarmedicosespecialidade();
        }


        echo json_encode($result);
    }

    function medicoespecialidade() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['txtcbo'])) {
            $result = $this->exametemp->listarautocompletemedicoespecialidade($_GET['txtcbo']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoespecialidade();
        }


        echo json_encode($result);
    }

    function listarmedicotipoagenda() {
//        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['tipoagenda'])) {
            $result = $this->exametemp->listarautocompletemedicotipoagenda($_GET['tipoagenda']);
        } else {
            $result = $this->exametemp->listarautocompletemedicotipoagenda();
        }

        echo json_encode($result);
    }

    function grupoempresa() {
//        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['txtgrupo'])) {
            $result = $this->exametemp->listarautocompletegrupoempresa($_GET['txtgrupo']);
        } else {
            $result = $this->exametemp->listarautocompletegrupoempresa();
        }

        echo json_encode($result);
    }

    function agendaempresasala() {
        $result = array();
        if (isset($_GET['txtempresa'])) {
            $result = $this->exametemp->listarautocompleteagendaempresasala($_GET['txtempresa']);
        }

        echo json_encode($result);
    }

    function grupoempresasala() {
//        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['txtgrupo'])) {
            $result = $this->exametemp->listarautocompletegrupoempresasala($_GET['txtgrupo'], $_GET['txtempresa']);
        } else {
            $result = $this->exametemp->listarautocompletegrupoempresasala();
        }

        echo json_encode($result);
    }

    function grupoempresasalatodos() {
//        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['txtgrupo'])) {
            $result = $this->exametemp->listarautocompletegrupoempresasalatodos($_GET['txtgrupo'], $_GET['txtempresa']);
        } else {
            $result = $this->exametemp->listarautocompletegrupoempresasalatodos();
        }

        echo json_encode($result);
    }

    function cboprofissionaismultifuncao() {
        if (isset($_GET['term'])) {
            $result = $this->operador_m->listacboprofissionaisautocomplete($_GET['term']);
        } else {
            $result = $this->operador_m->listacboprofissionaisautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->cbo_ocupacao_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function linhas() {

        if (isset($_GET['term'])) {
            $result = $this->exametemp->listarautocompletelinha($_GET['term']);
        } else {
            $result = $this->exametemp->listarautocompletelinha();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . '-' . $item->texto;
            $retorno['id'] = $item->texto;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function medicamentolaudo() {
         $var  = Array(); 
        if (isset($_GET['term'])) {
            $result = $this->exametemp->listarautocompletemedicamentolaudo($_GET['term']);
        } else {
            $result = $this->exametemp->listarautocompletemedicamentolaudo();
        }
        foreach ($result as $item) { 
            $retorno['value'] = $item->nome . ' (' . $item->quantidade . ' - ' . $item->descricao . ') -> ' . $item->posologia;
                $texto  = $item->nome; 
            if ($item->quantidade != "") {
                $texto .= " ----- ".$item->quantidade;
            } 
            if($item->descricao != ""){
                $texto .=  " ----- ".$item->descricao;
            }    
            $retorno['id'] = '<br>'.$texto . '<br>' . $item->posologia."<br>";  
            $retorno['qtde'] = $item->quantidade;
            $var[] = $retorno;
        }
        
        echo json_encode($var);
    }

    function modeloslaudos() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelos($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelos();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function laudosanteriores() {

        if (isset($_GET['anteriores'])) {

            $result = $this->laudo->listarautocompletelaudos($_GET['anteriores']);
        } else {
            $result = $this->laudo->listarautocompletelaudos();
        }
        echo json_encode($result);
    }

    function cidade() {

        if (isset($_GET['term'])) {
            $result = $this->paciente_m->listarCidades($_GET['term']);
        } else {
            $result = $this->paciente_m->listarCidades();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . ' - ' . $item->estado;
            $retorno['id'] = $item->municipio_id;
            $retorno['codigo_ibge'] = $item->codigo_ibge;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cidadeibge() {

        if (isset($_GET['ibge'])) {
            $result = $this->paciente_m->listarCidadesibge($_GET['ibge']);
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . ' - ' . $item->estado;
            $retorno['id'] = $item->municipio_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function produto() {

        if (isset($_GET['term'])) {
            $result = $this->produto_m->autocompleteproduto($_GET['term']);
        } else {
            $result = $this->produto_m->autocompleteproduto();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->estoque_produto_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function nota() {

        if (isset($_GET['term'])) {
            $result = $this->nota->autocompletenota($_GET['term']);
        } else {
            $result = $this->nota->autocompletenota();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nota_fiscal;
            $retorno['id'] = $item->estoque_nota_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function fornecedor() {

        if (isset($_GET['term'])) {
            $result = $this->fornecedor_m->autocompletefornecedor($_GET['term']);
        } else {
            $result = $this->fornecedor_m->autocompletefornecedor();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->fantasia;
            $retorno['id'] = $item->estoque_fornecedor_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimentotuss() {

        if (isset($_GET['term'])) {
            $result = $this->procedimento->listarautocompletetuss($_GET['term']);
        } else {
            $result = $this->procedimento->listarautocompletetuss();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->codigo . ' - ' . $item->descricao . ' - ' . $item->ans;
            $retorno['id'] = $item->tuss_id;
            $retorno['codigo'] = $item->codigo;
            $retorno['descricao'] = $item->descricao . ' - ' . $item->ans;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimentotusspesquisa() {

        if (isset($_GET['term'])) {
            $result = $this->procedimento->listarautocompletetuss($_GET['term']);
        } else {
            $result = $this->procedimento->listarautocompletetuss();
        }
        foreach ($result as $item) {
            $retorno['value'] = "Código : " . $item->codigo . ' - Descrição :' . $item->descricao . ' - ' . $item->ans;
            $retorno['id'] = $item->tuss_id;
            $retorno['codigo'] = $item->codigo;
            $retorno['descricao'] = $item->descricao . ' - ' . $item->ans;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cbo() {

        if (isset($_GET['term'])) {
            $result = $this->operador_m->listarcbo($_GET['term']);
        } else {
            $result = $this->operador_m->listarcbo();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->cbo_grupo_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cargo() {
        if (isset($_GET['term'])) {
            $result = $this->cargo->listarautocomplete($_GET['term']);
        } else {
            $result = $this->cargo->listarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->cargo_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function motivo_atendimento() {
        if (isset($_GET['term'])) {
            $result = $this->solicita_acolhimento_m->listamotivoautocomplete($_GET['term']);
        } else {
            $result = $this->solicita_acolhimento_m->listamotivoautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->emergencia_motivoatendimento_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function medicosaida() {
        if (isset($_GET['term'])) {
            $result = $this->solicita_acolhimento_m->listarmedicosaida($_GET['term']);
        } else {
            $result = $this->solicita_acolhimento_m->listarmedicosaida();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->conselho . '-' . $item->nome;
            $retorno['id'] = $item->operador_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function medicosranqueado() {
        if (isset($_GET['term'])) {
            $result = $this->guia->listarmedicosranqueados($_GET['term']);
        } else {
            $result = $this->guia->listarmedicosranqueados();
        }
//        echo "<pre>";
//        var_dump($result); die; 
        foreach ($result as $item) {


            $retorno['value'] = $item->conselho . '-' . $item->nome . '-' . $item->cbo_ocupacao_id . '-' . $item->uf_profissional;
            $retorno['id'] = $item->operador_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function medicos() {
        if (isset($_GET['term'])) {
            $result = $this->guia->listarmedicos($_GET['term']);
        } else {
            $result = $this->guia->listarmedicos();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->conselho . '-' . $item->nome;
            $retorno['id'] = $item->operador_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function pacientes() {
        if (isset($_GET['term'])) {
            $result = $this->guia->listarpacientes($_GET['term']);
        } else {
            $result = $this->guia->listarpacientes();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->paciente_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function funcao() {
        if (isset($_GET['term'])) {
            $result = $this->funcao->listarautocomplete($_GET['term']);
        } else {
            $result = $this->funcao->listarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->funcao_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function ocorrenciatipo() {
        if (isset($_GET['term'])) {
            $result = $this->ocorrenciatipo->listarautocomplete($_GET['term']);
        } else {
            $result = $this->ocorrenciatipo->listarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->ocorrenciatipo_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function setor() {
        if (isset($_GET['term'])) {
            $result = $this->setor->listarautocomplete($_GET['term']);
        } else {
            $result = $this->setor->listarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->setor_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function horariostipo() {
        if (isset($_GET['term'])) {
            $result = $this->horariostipo->listarautocomplete($_GET['term']);
        } else {
            $result = $this->horariostipo->listarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->horariostipo_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function funcionario() {
        if (isset($_GET['term'])) {
            $result = $this->funcionario->listarautocomplete($_GET['term']);
        } else {
            $result = $this->funcionario->listarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->funcionario_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function unidade() {
        if (isset($_GET['term'])) {
            $result = $this->unidade_m->listaunidadeautocomplete($_GET['term']);
        } else {
            $result = $this->unidade_m->listaunidadeautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->internacao_unidade_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function operador() {
        if (isset($_GET['term'])) {
            $result = $this->operador_m->listaoperadorautocomplete($_GET['term']);
        } else {
            $result = $this->operador_m->listaoperadorautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->conselho . '-' . $item->nome;
            $retorno['id'] = $item->operador_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cboprofissionais() {
        if (isset($_GET['term'])) {
            $result = $this->operador_m->listacboprofissionaisautocomplete($_GET['term']);
        } else {
            $result = $this->operador_m->listacboprofissionaisautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->cbo_ocupacao_id . '-' . $item->descricao;
            $retorno['id'] = $item->cbo_ocupacao_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cep() {
        if (isset($_GET['term'])) {
            $cep = str_replace("-", "", $_GET['term']);
            $result = $this->paciente_m->cep($cep);
        } else {
            $result = $this->paciente_m->cep();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->cep . ' - ' . $item->tipo_logradouro . ' ' . $item->logradouro_nome;
            $retorno['cep'] = $item->cep;
            $retorno['logradouro_nome'] = $item->logradouro_nome;
            $retorno['tipo_logradouro'] = $item->tipo_logradouro;
            $retorno['localidade_nome'] = $item->localidade_nome;
            $retorno['nome_bairro'] = $item->nome_bairro;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function paciente() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['term'])) {
            $result = $this->exame->listarautocompletepaciente($_GET['term']);
        } else {
            $result = $this->exame->listarautocompletepaciente();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . " - " . substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4);
            $retorno['itens'] = $item->telefone;
            $retorno['sexo'] = $item->sexo;
            $retorno['sexo_real'] = $item->sexo_real;
            $retorno['celular'] = $item->celular;
            $retorno['cpf'] = substr($item->cpf,0,3).".".substr($item->cpf,3,3).".".substr($item->cpf,6,3)."-".substr($item->cpf,9,2);
            $retorno['email'] = $item->cns;
            $retorno['valor'] = substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4);
            $retorno['id'] = $item->paciente_id;
            $retorno['endereco'] = $item->logradouro . " - " . $item->numero;
            $retorno['nome'] = $item->nome;
            $retorno['whatsapp'] = $item->whatsapp;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function pacientecpf() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['term'])) {
            $result = $this->exame->listarautocompletepacientecpf($_GET['term']);
        } else {
            $result = $this->exame->listarautocompletepacientecpf();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['itens'] = $item->telefone;
            $retorno['celular'] = $item->celular;
            $retorno['valor'] = substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4);
            $retorno['id'] = $item->paciente_id;
            $retorno['endereco'] = $item->logradouro . " - " . $item->numero;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function pacienteunificar() {
        if (isset($_GET['term'])) {
            $result = $this->exame->listarautocompletepacienteunificar($_GET['term']);
        } else {
            $result = $this->exame->listarautocompletepacienteunificar();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->paciente_id . " - " . $item->nome . " - " . substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4);
            $retorno['itens'] = $item->telefone;
            $retorno['mae'] = $item->nome_mae;
            $retorno['valor'] = substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4);
            $retorno['id'] = $item->paciente_id;
            $retorno['endereco'] = $item->logradouro . " - " . $item->numero;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function pacientetransferircredito() {
        if (isset($_GET['term'])) {
            $result = $this->exame->listarautocompletepacienteunificar($_GET['term']);
        } else {
            $result = $this->exame->listarautocompletepacienteunificar();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['itens'] = $item->telefone;
            $retorno['mae'] = $item->nome_mae;
            $retorno['valor'] = substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4);
            $retorno['id'] = $item->paciente_id;
            $retorno['endereco'] = $item->logradouro . " - " . $item->numero;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function operadorunificar() {
        if (isset($_GET['term'])) {
            $result = $this->operador_m->listaoperadorunificarautocomplete($_GET['term']);
        } else {
            $result = $this->operador_m->listaoperadorunificarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['usuario'] = $item->usuario;
            $retorno['perfil'] = $item->perfil;
            $retorno['id'] = $item->operador_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function pacientenascimento() {
        $_GET['term'] = date("Y-m-d", strtotime(str_replace("/", "-", $_GET['term'])));
        if (isset($_GET['term'])) {
            $result = $this->exame->listarautocompletepacientenascimento($_GET['term']);
        } else {
            $result = $this->exame->listarautocompletepacientenascimento();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['itens'] = $item->telefone;
            $retorno['sexo'] = $item->sexo;
            $retorno['sexo_real'] = $item->sexo_real;                 
            $retorno['celular'] = $item->celular;
            $retorno['valor'] = substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4);
            $retorno['id'] = $item->paciente_id;
            $retorno['prontu_antigo'] = $item->prontuario_antigo;
            $retorno['cpf'] = substr($item->cpf,0,3).".".substr($item->cpf,3,3).".".substr($item->cpf,6,3)."-".substr($item->cpf,9,2);
            $retorno['whatsapp'] = $item->whatsapp;
            $var[] = $retorno;
        }
        echo json_encode($var);
//        echo json_encode('olaolaoa');
    }

    function cid1() {
        if (isset($_GET['term'])) {
            $result = $this->internacao_m->listacidautocomplete($_GET['term']);
        } else {
            $result = $this->internacao_m->listacidautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->co_cid . '-' . $item->no_cid;
            $retorno['id'] = $item->co_cid;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cid2() {
        if (isset($_GET['term'])) {
            $result = $this->internacao_m->listacidautocomplete($_GET['term']);
        } else {
            $result = $this->internacao_m->listacidautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->co_cid . '-' . $item->no_cid;
            $retorno['id'] = $item->co_cid;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimento() {
        if (isset($_GET['term'])) {
            $result = $this->internacao_m->listaprocedimentoautocomplete($_GET['term']);
        } else {
            $result = $this->internacao_m->listaprocedimentoautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->procedimento . '-' . $item->descricao;
            $retorno['id'] = $item->procedimento;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function enfermariaunidade() {

        if (isset($_GET['id'])) {
            $result = $this->enfermaria_m->listaenfermariajson($_GET['id']);
        } else {
            $result = $this->enfermaria_m->listaenfermariajson();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->internacao_enfermaria_id . ' - ' . $item->nome;
            $retorno['id'] = $item->internacao_enfermaria_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function leitoenfermaria() {

        if (isset($_GET['id'])) {
            $result = $this->enfermaria_m->listaleitojson($_GET['id']);
        } else {
            $result = $this->enfermaria_m->listaleitojson();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->internacao_leito_id . ' - ' . $item->nome;
            $retorno['id'] = $item->internacao_leito_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function enfermaria() {
        //  $nascimento_str = str_replace('-','', '1950-12-10');
        //  echo $nascimento_str; die;
        if (isset($_GET['term'])) {
            $result = $this->enfermaria_m->listaenfermariaautocomplete($_GET['term']);
        } else {
            $result = $this->enfermaria_m->listaenfermariaautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . ' - ' . $item->unidade;
            $retorno['id'] = $item->internacao_enfermaria_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function leito() {

        if (isset($_GET['term'])) {
            $result = $this->leito_m->listaleitoautocomplete($_GET['term']);
        } else {
            $result = $this->leito_m->listaleitoautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . ' - ' . $item->enfermaria . ' - ' . $item->unidade;
            $retorno['id'] = $item->internacao_leito_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function tamanhoconvenio() {

        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['txtcbo'])) {
            $result = $this->convenio->tamanhoconvenio($_GET['txtcbo']);
        } else {
            $result = $this->convenio->tamanhoconvenio();
        }


        echo json_encode($result);
    }

    function armazemsaidaproduto() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['produto'])) {
            $result = $this->armazem->armazemsaidaproduto($_GET['produto']);
        } else {
            $result = $this->armazem->armazemsaidaproduto();
        }
        echo json_encode($result);
    }

    function quantidadesaidaproduto() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['produto'])) {
            $result = $this->armazem->quantidadesaidaproduto($_GET['produto']);
        } else {
            $result = $this->armazem->quantidadesaidaproduto();
        }
        echo json_encode($result);
    }

    function lotesaidaproduto() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['produto'])) {
            $result = $this->armazem->lotesaidaproduto($_GET['produto']);
        } else {
            $result = $this->armazem->lotesaidaproduto();
        }
        echo json_encode($result);
    }

    function listarpoltronascomplete() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['data'])) {
            $result = $this->laudo->listarpoltronascomplete($_GET['data'], $_GET['medico_id']);
        } else {
            $result = $this->laudo->listarpoltronascomplete();
        }
        echo json_encode($result);
    }

    function listarpoltronascompletemanha() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['data'])) {
            $result = $this->laudo->listarpoltronascompletemanha($_GET['data'], $_GET['medico_id']);
        } else {
            $result = $this->laudo->listarpoltronascompletemanha();
        }
        echo json_encode($result);
    }

    function listarpoltronascompletetarde() {

//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['data'])) {
            $result = $this->laudo->listarpoltronascompletetarde($_GET['data'], $_GET['medico_id']);
        } else {
            $result = $this->laudo->listarpoltronascompletetarde();
        }
        echo json_encode($result);
    }

    function pacientepoltrona() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['term'])) {
            $result = $this->exame->listarautocompletepaciente($_GET['term']);
        } else {
            $result = $this->exame->listarautocompletepaciente();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . " - " . substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4) . " - " . $item->prontuario_antigo;
            $retorno['itens'] = $item->telefone;
            $retorno['celular'] = $item->celular;
            $retorno['cpf'] = $item->cpf;
            $retorno['email'] = $item->cns;

            $retorno['valor'] = substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4);
            $retorno['id'] = $item->paciente_id;
            $retorno['endereco'] = $item->logradouro . " - " . $item->numero;

            $retorno['prontuario_antigo'] = $item->prontuario_antigo;


            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function pacienteprotuarioantigo() {


        if (isset($_GET['term'])) {
            $result = $this->exame->listarautocompletepacienteprotuarioantigo($_GET['term']);
        } else {
            $result = $this->exame->listarautocompletepacienteprotuarioantigo();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->prontuario_antigo . " - " . $item->nome . " - " . $item->nascimento;
            $retorno['itens'] = $item->telefone;
            $retorno['valor'] = $item->prontuario_antigo;
            $retorno['id'] = $item->paciente_id;
            $retorno['nome'] = $item->nome;
            $retorno['nascimento'] = substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4);
            ;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function listarpoltronascompletehorasdia() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );

        if (isset($_GET['data'])) {
            $result = $this->laudo->listarpoltronascompletehorasdia($_GET['data'], $_GET['medico_id']);
        } else {
            $result = $this->laudo->listarpoltronascompletehorasdia();
        }
        echo json_encode($result);
    }

    function armazemtransferenciaentradaprodutofarmacia() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['produto'])) {
            $result = $this->armazem->armazemtransferenciaentradaprodutofarmacia($_GET['produto'], $_GET['armazem']);
        } else {
            $result = $this->armazem->armazemtransferenciaentradaprodutofarmacia();
        }
        echo json_encode($result);
//        $result = $this->armazem_farmacia->armazemtransferenciaentradaprodutofarmacia();
//        var_dump($result);
    }

    function armazemtransferenciaentradafarmacia() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['produto'])) {
            $result = $this->armazem->armazemtransferenciaentradajsonfarmacia($_GET['produto'], $_GET['armazem']);
        } else {
            $result = $this->armazem->armazemtransferenciaentradajsonfarmacia();
        }
        echo json_encode($result);
    }

    function armazemtransferenciaentradaquantidadefarmacia() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['produto'])) {
            $result = $this->armazem->armazemtransferenciaentradajsonquantidadefarmacia($_GET['produto'], $_GET['armazem']);
        } else {
            $result = $this->armazem->armazemtransferenciaentradajsonquantidadefarmacia();
        }
        echo json_encode($result);
    }
    
    
     function pacienteporcpf() {  
        $_GET['term'] = str_replace("-", "", str_replace(".", "", $_GET['term']));
        if (isset($_GET['term'])) {
            $result = $this->exame->listarautocompletepacienteporcpf($_GET['term']);
        } else {
            $result = $this->exame->listarautocompletepacienteporcpf();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['sexo'] = $item->sexo;
            $retorno['sexo_real'] = $item->sexo_real;
            $retorno['itens'] = $item->telefone;
            $retorno['celular'] = $item->celular;
            $retorno['valor'] = substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4);
            $retorno['id'] = $item->paciente_id;
            $retorno['prontu_antigo'] = $item->prontuario_antigo;
            $retorno['whatsapp'] = $item->whatsapp;
            $retorno['cpf'] = substr($item->cpf,0,3).".".substr($item->cpf,3,3).".".substr($item->cpf,6,3)."-".substr($item->cpf,9,2);
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

     function repetirreceituariotarefa() {

        if (isset($_GET['receita'])) {
            $result = $this->laudo->listarautocompleterepetirreceituariotarefa($_GET['receita']);
        } else {
            $result = $this->laudo->listarautocompleterepetirreceituariotarefa();
        }
        echo json_encode($result);
    }
    
                    
    
    function listarprocedimentogrupo() {
        if (isset($_GET['grupo'])) {
            $result = $this->procedimento->listarprocedimentogrupoautocomplete($_GET['grupo']);
        } else {
            $result = $this->procedimento->listarprocedimentogrupoautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->procedimento_tuss_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }
    
    function buscarsaldopacientetcd() { 
        if (isset($_GET['guia_id'])) {
            $paciente_id = $this->exametemp->listarpacienteporguia($_GET['guia_id']);
            $saldoTcd = $this->exametemp->listarsaldotcdpaciente($paciente_id);
        }

        echo json_encode(array("saldo" => $saldoTcd[0]->saldo, "paciente_id" => $paciente_id));
    }
    
    function procedimentomedico() { 
        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->procedimentomedico($_GET['convenio1'],@$_GET['medico_id'], @$_GET['grupo']);
        } else {
            $result = $this->exametemp->procedimentomedico();
        }
        echo json_encode($result);
    }     
    
    function buscarvalorpersonalizadomedico(){
        $result = array();
        if (isset($_GET['procedimento_id'])) {
            $result = $this->exametemp->valorpersonalizadomedico($_GET['convenio1'], $_GET['medico_id'], $_GET['procedimento_id']);
        }
        echo json_encode($result);
    }
     
     function listarmedicoempresa() {
//        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['empresa_id'])) {
            $result = $this->operador_m->listarmedicoempresa($_GET['empresa_id']);
        } else {
            $result = $this->operador_m->listarmedicoempresa();
        } 
        echo json_encode($result);
    }
    
    function verificarquantidaderetorno(){
       
       if(isset($_GET['empresa_id']) && $_GET['empresa_id'] != ""){
           $empresa_id = $_GET['empresa_id'];
       }else{
           $empresa_id = $this->session->userdata('empresa_id'); 
       } 
             
       $procedimentos = $this->procedimentoplano->procedimentoplanolog($_GET['procedimento_convenio_id']);
       $procedimento_tuss_id = $procedimentos[0]->procedimento_tuss_id; 
                    
       $re =  $this->exametemp->verificarlimiteprocedimento($procedimento_tuss_id, $_GET['medicoid'],$empresa_id);
                    
       $turno = ""; 
       if(strtotime($_GET['inicio']) >= strtotime('08:00:00') && strtotime($_GET['inicio']) <=  strtotime('12:00:00') ){
             $turno = "manha";
       }elseif(strtotime($_GET['inicio']) >= strtotime('13:00:00') && strtotime($_GET['inicio']) <= strtotime('19:00:01')){
             $turno = "tarde";
       }else{
             $turno = "noite";
       }   
       
        $retornos = $this->exame->listarexameshorarioretorno($_GET['data'],$_GET['medicoid'],$procedimento_tuss_id,$empresa_id,$turno);
                    
        if(count($re) > 0){       
               if(count($retornos) >= $re[0]->quantidade && $re[0]->quantidade > 0){
                  $mensagem = "O profissional selecionado ja atingiu o limite estabelecido para o dia:\n\n\n";
                  $mensagem .= "Procedimento: ".$re[0]->procedimento."\n\n\n";
                  $mensagem .= "Empresa: ".$re[0]->empresa."\n\n\n";
                  $mensagem .= "Quantidade limite: ".$re[0]->quantidade."\n\n";
               }else{
                  $mensagem = "ok";  
               }
        }else{
              $mensagem = "ok";  
        }
        
       echo json_encode($mensagem); 
                    
       
    }
                    
    
    function buscarfaixaetaria(){
                    
        $res = $this->paciente_m->pacientelog($_GET['paciente_id']);
        $faixa = $this->operador_m->listaroperador($_GET['medicoid']);
        $empresa = $this->operador_m->listarempresaconvenioorigem($_GET['empresa_id']);  
        $faixa_inicial = $faixa[0]->faixa_etaria;
        $faixa_final = $faixa[0]->faixa_etaria_final;  
        $dataFuturo2 = date("Y-m-d");
        $dataAtual2 = $res[0]->nascimento;
        $date_time2 = new DateTime($dataAtual2);
        $diff2 = $date_time2->diff(new DateTime($dataFuturo2)); 
        $teste2 = $diff2->format('%Y'); 
        if($faixa_final > 0 && $faixa_inicial > 0){
            if($teste2 <= $faixa_final && $teste2 >= $faixa_inicial){
               $mensagem = "";  
            }else{
               $mensagem = "Profissional só atende Idade nessa Faixa Etária\n";  
               $mensagem .=  $faixa_inicial." à ".$faixa_final." Anos\n" ;  
               $mensagem .=  "Empresa: ".$empresa[0]->nome;  
            }
        }else{
               $mensagem = ""; 
        }            
        echo json_encode($mensagem);
        
        
        
    }
    
    
    
    function carregarprocedimentoslimite() {  
        if(isset($_GET['grupo']) && $_GET['grupo'] != ""){
            $res = $this->exametemp->listarprocedimentosgrupo($_GET['grupo']);
        }else{
            $res = Array();
        } 
        echo json_encode($res);
    }
    
     function listarhorarioscalendariomultifuncao() {
                    
        if (count($_POST) > 0) {
            $result = $this->exametemp->listarhorarioscalendariovago($_POST['medico'], null, @$_POST['empresa'], @$_POST['sala'], @$_POST['grupo'], @$_POST['tipoagenda'], @$_POST['procedimento'], @$_POST['subgrupo'],@$_POST['paciente']);
//            $algo = 'asd';
        } else {
            $result = $this->exametemp->listarhorarioscalendariovago();
            $algo = 'dsa';
        }

        $var = Array();
        $i = 0;
//            $result2 = $this->exametemp->listarhorarioscalendarioocupado();
                    
     
                    
        
        foreach ($result as $item) {
                    
                    
            $i++;
            $retorno['id'] = $i;
            if ($item->situacao == 'LIVRE') {
                $retorno['title'] = 'V: ' . $item->contagem;
            } else {
                $retorno['title'] = 'M: ' . $item->contagem;
            } 
            
                    
            $retorno['start'] = $item->data;
            $retorno['end'] = $item->data;
            if ($item->situacao == 'LIVRE') {
                $retorno['color'] = '#62C462';
            } else {
                $retorno['color'] = '#B30802';
            }
            $situacao = $item->situacao;
            if (isset($item->medico)) {
                $medico = $item->medico;
            } else {
                $medico = "";
            }
            if (isset($_POST['tipoagenda'])) {
                $tipoagenda = $_POST['tipoagenda'];
            } else {
                $tipoagenda = null;
            }
            if (isset($_POST['subgrupo'])) {
                $subgrupo = $_POST['subgrupo'];
            } else {
                $subgrupo = null;
            }
            if (isset($_POST['paciente'])) {
                $nome = $_POST['paciente'];
            } else {
                $nome = null;
            }
            if (@$_POST['procedimento'] != '') {
                $procedimento = $_POST['procedimento'];
            } else {
                $procedimento = null;
            }
            if(isset($_POST['sala'])){
              $sala = $_POST['sala'];
            }else{
               $sala = null;  
            }
            if(isset($_POST['grupo'])){
               $grupo = $_POST['grupo'];
            }else{
               $grupo = null;  
            }
             if(isset($_POST['empresa'])){
             $empresa = $_POST['empresa'];
            }else{
                $empresa = null;  
            }


            $dia = date("d", strtotime($item->data));
            $mes = date("m", strtotime($item->data));
            $ano = date("Y", strtotime($item->data));

//            $medico = $item->medico;
            if ($this->session->userdata('calendario_layout') == 't') {
                $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaomedicogeral?empresa=$empresa&grupo=$grupo&sala=$sala&tipoagenda=$tipoagenda&medico=$medico&situacao=$situacao&data=$dia%2F$mes%2F$ano&nome=$nome&procedimento=$procedimento&subgrupo=$subgrupo&calendar=true";
            } else {
                $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaomedicogeral?empresa=$empresa&grupo=$grupo&sala=$sala&tipoagenda=$tipoagenda&medico=$medico&situacao=$situacao&data=$dia%2F$mes%2F$ano&nome=$nome&subgrupo=$subgrupo&calendar=true";
            }

            $var[] = $retorno;
        }
        echo json_encode($var);

//        foreach ($result2 as $value) {
//            $retorno['title'] =  'H: Ocupados: ' . $value->contagem_ocupado;
//            $retorno['start'] = $value->data;
//            $retorno['end'] = $value->data;
//            $retorno['color'] = '#0E9AA7';
//            $dia = date("d", strtotime($item->data));
//            $mes = date("m", strtotime($item->data));
//            $ano = date("Y", strtotime($item->data));
//            $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaoconsulta?empresa=&especialidade=&medico=&situacao=OK&data=$dia%2F$mes%2F$ano&nome=";
//            $var[] = $retorno;
//        }
    }
    
    function datashistoricopordia(){ 
        $paciente_id = $_GET['paciente'];
        $tipo = $_GET['tipo'];
        $res = $this->laudo->listardatashistoricotipo($paciente_id,$tipo); 
        echo json_encode($res);
        
    }
    
    
     function historicopordiatipo() {
        
        $_GET['dataescolhida'] = date("Y-m-d", strtotime(str_replace("/", "-", $_GET['dataescolhida'])));
        $tipo =  ""; 
        if(isset($_GET['tipo']) && $_GET['tipo'] != ""){
          $tipo =  $_GET['tipo'];   
        } 
        
        $data['result'] = $this->laudo->listardatashistoricopordia($_GET['paciente'], $_GET['dataescolhida'],$tipo); 
        $data['receita'] = $this->laudo->listarreceitatipo($_GET['paciente'],$_GET['dataescolhida'],$tipo);   
                    
        $html = $this->load->View('ambulatorio/historicopordiatipo-lista', $data, true);
                    
        echo json_encode($html);
        
        
    }
    
     function horariosambulatoriogeral2() {

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarhorariosgeral2($_GET['exame'], $_GET['teste'],$_GET['empresa_id']);
        } else {
            $result = $this->exametemp->listarhorariosgeral2();
        }
        echo json_encode($result);
    }
    
    function procedimentoconveniotodosempresa() { 
        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodosempresa($_GET['convenio1'],$_GET['empresa_id']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodosempresa();
        }
        echo json_encode($result);
    }
    
     function horariosambulatorioempresa() {
        $_GET['teste'] = date("Y-m-d", strtotime(str_replace("/", "-", $_GET['teste']))); 
        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarautocompletehorariosempresa($_GET['exame'], $_GET['teste'],$_GET['empresa_id']);
        } else {
            $result = $this->exametemp->listarautocompletehorariosempresa();
        }
        echo json_encode($result);
    }
    
    function infocomp($procedimento_tuss_id,$agenda_exames_id){
        $data['procedimento'] = $this->procedimento->listarprocedimentounico($procedimento_tuss_id); 
        $data['agenda'] = $this->exametemp->listaragendainfocomplementares($agenda_exames_id);  
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->load->View('ambulatorio/infocomp-lista', $data);
    }
    
    function preparo(){
        $procedimento = $this->procedimento->listarprocedimentounico($_GET['procedimento_tuss_id']);  
        $string = "Preparo: ".$procedimento[0]->descricao_preparo; 
        echo json_encode($string);
    }
    
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
