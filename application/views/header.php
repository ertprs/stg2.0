<?
//Da erro no home
if ($this->session->userdata('autenticado') != true) {
    redirect(base_url() . "login/index/login004", "refresh");
}

$empresa_id = $this->session->userdata('empresa_id');
$this->db->select('e.*, ep.*');
$this->db->from('tb_empresa e');
$this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
$this->db->where('e.empresa_id', $empresa_id);
$retorno_header = $this->db->get()->result();


$this->db->select('o.operador_id,
                    o.perfil_id,
                    o.profissional_agendar_o,
                    p.nome as perfil,
                    a.modulo_id,
                    oe.operador_empresa_id,
                    o.medico_agenda');
$this->db->from('tb_operador o');
$this->db->join('tb_perfil p', 'p.perfil_id = o.perfil_id');
$this->db->join('tb_acesso a', 'a.perfil_id = o.perfil_id','left');
$this->db->join('tb_operador_empresas oe', 'oe.operador_id = o.operador_id', 'left');
$this->db->where('o.operador_id', $this->session->userdata('operador_id'));
$this->db->where('oe.empresa_id', $empresa_id);
$this->db->where('oe.ativo = true');
$this->db->where('o.ativo = true');
$retorno_paciente = $this->db->get()->result();

$chat = @$retorno_header[0]->chat;
$geral = @$retorno_header[0]->geral;
$ponto = @$retorno_header[0]->ponto;
$caixa = @$retorno_header[0]->caixa;
$imagem = @$retorno_header[0]->imagem;
$estoque = @$retorno_header[0]->estoque;
$consulta = @$retorno_header[0]->consulta;
$farmacia = @$retorno_header[0]->farmacia;
$uso_salas = @$retorno_header[0]->uso_salas;
$perfil_id = $this->session->userdata('perfil_id');
$marketing = @$retorno_header[0]->marketing;
$enfermagem = @$retorno_header[0]->enfermagem;
$internacao = @$retorno_header[0]->internacao;
$financeiro = @$retorno_header[0]->financeiro;
$empresa_id = $this->session->userdata('empresa_id');
$calendario = @$retorno_header[0]->calendario;
$manternota = @$retorno_header[0]->manternota;
$operador_id = $this->session->userdata('operador_id');
$relatoriorm = @$retorno_header[0]->relatoriorm;
$odontologia = @$retorno_header[0]->odontologia;
$laboratorio = @$retorno_header[0]->laboratorio;
$faturamento =  @$retorno_header[0]->faturamento;
$relatorio_rm = @$retorno_header[0]->relatorio_rm;
$logo_clinica = $this->session->userdata('logo_clinica');
$especialidade =  @$retorno_header[0]->especialidade;
$endereco_toten = $this->session->userdata('endereco_toten');
$dashboard_administrativo = @$retorno_header[0]->dashboard_administrativo;
$financ_4n = @$retorno_header[0]->financ_4n;
$agenda_modelo2 = @$retorno_header[0]->agenda_modelo2;
$faturamento_novo = @$retorno_header[0]->faturamento_novo;
$medico_estoque = @$retorno_header[0]->medico_estoque;
$relatorio_dupla = @$retorno_header[0]->relatorio_dupla;
$hora_agendamento = @$retorno_header[0]->hora_agendamento;
$historico_antigo_administrador = @$retorno_header[0]->historico_antigo_administrador;
$orcamento_multiplo = @$retorno_header[0]->orcamento_multiplo;
$relatorio_caixa_antigo = @$retorno_header[0]->relatorio_caixa_antigo;
$limitar_acesso = @$retorno_header[0]->limitar_acesso;
$fila_impressao = @$retorno_header[0]->fila_impressao;
$relatorio_caixa = @$retorno_header[0]->relatorio_caixa;
$centrocirurgico = @$retorno_header[0]->centrocirurgico;
$relatorio_ordem = @$retorno_header[0]->relatorio_ordem;
$integracaosollis = @$retorno_header[0]->integracaosollis;
$manter_indicacao = @$retorno_header[0]->manter_indicacao;
$calendario_layout = @$retorno_header[0]->calendario_layout;
$sala_de_espera = $this->session->userdata('autorizar_sala_espera');
$perfil_marketing_p = @$retorno_header[0]->perfil_marketing_p;
$medicinadotrabalho = @$retorno_header[0]->medicinadotrabalho;
$medico_solicitante = @$retorno_header[0]->medico_solicitante;
$orcamento_recepcao = @$retorno_header[0]->orcamento_recepcao;
$relatorio_producao = @$retorno_header[0]->relatorio_producao;
$relatorio_operadora = @$retorno_header[0]->relatorio_operadora;
$relatorios_recepcao = @$retorno_header[0]->relatorios_recepcao;
$financeiro_cadastro = @$retorno_header[0]->financeiro_cadastro;
$caixa_personalizado = @$retorno_header[0]->caixa_personalizado;
$profissional_agendar = @$retorno_header[0]->profissional_agendar;
$profissional_agendar_o = @$retorno_paciente[0]->profissional_agendar_o;
$gerente_contasapagar = @$retorno_header[0]->gerente_contasapagar;
$subgrupo_procedimento = $this->session->userdata('subgrupo_procedimento');
$relatorios_clinica_med = @$retorno_header[0]->relatorios_clinica_med;
$relatorio_demandagrupo = @$retorno_header[0]->relatorio_demandagrupo;
$procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
$gerente_recepcao_top_saude = @$retorno_header[0]->gerente_recepcao_top_saude;
$gerente_relatorio_financeiro = @$retorno_header[0]->gerente_relatorio_financeiro;
$retirar_preco_procedimento = @$retorno_header[0]->retirar_preco_procedimento;
$aparecer_orcamento = @$retorno_header[0]->aparecer_orcamento;
$cirugico_manual = @$retorno_header[0]->cirugico_manual;
$tecnico_acesso_acesso = @$retorno_header[0]->tecnico_acesso_acesso;
$desativarelatend = @$retorno_header[0]->desativarelatend;
$convenio_padrao = @$retorno_header[0]->convenio_padrao;
@$tarefa_medico = @$retorno_header[0]->tarefa_medico;
@$valores_recepcao = @$retorno_header[0]->valores_recepcao;
@$filaaparelho = @$retorno_header[0]->filaaparelho;
@$setores = @$retorno_header[0]->setores;
@$bardeira_status = @$retorno_header[0]->bardeira_status;
@$manter_gastos = @$retorno_header[0]->manter_gastos;
$medico_agenda = $this->session->userdata('medico_agenda');

function alerta($valor) {
    echo "<script>alert('$valor');</script>";
}

function debug($object) {
    
}

//echo $valor;
?>
<!DOCTYPE html PUBLIC "-//carreW3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pt-BR" >
    <head>
    
    <!--<meta charset="utf-8">-->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STG - SISTEMA DE GESTAO DE CLINICAS v2.0</title>
<!-- <meta http-equiv="Content-Style-Type" content="text/css" /> 
    <meta http-equiv="content-type" content="text/html;charset=utf-8" /> -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet"> -->
    <!-- Font Awesome Icons -->
    <link href="<?= base_url() ?>bootstrap/assets/css/font-awesome.css" rel="stylesheet" />
    <link href="<?= base_url() ?>bootstrap/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="<?= base_url() ?>bootstrap/vendor/bootstrap/css/bootstrap.css" rel="stylesheet"/>
    <link href="<?= base_url() ?>bootstrap/assets/css/argon-design-system.css" rel="stylesheet"/>
 
    <!-- <link href="<?= base_url() ?>css/header.css" rel="stylesheet"/> -->
    <link href="<?= base_url() ?>js/jquery-ui.css" rel="stylesheet"/>
    <link href="<?= base_url() ?>js/jquery-ui.structure.css" rel="stylesheet"/>
    <link href="<?= base_url() ?>js/jquery-ui.theme.css" rel="stylesheet"/>
    <link href="<?= base_url() ?>css/header1.css?v=2.1" rel="stylesheet"/>
    
    <!--CSS DO Calendário-->
    <link href="<?= base_url() ?>bootstrap/fullcalendar/main.css" rel="stylesheet" />
    <!--DEFINE TAMANHO MAXIMO DOS CAMPOS-->
    <link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
     <!--CSS DO ALERTA BONITINHO-->
    <link href="<?= base_url() ?>bootstrap/vendor/alert/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <!--   Core JS Files   -->
    <script src="<?= base_url() ?>bootstrap/vendor/alert/dist/sweetalert.min.js"></script>
    <script src="<?= base_url() ?>bootstrap/assets/js/core/jquery.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>bootstrap/assets/js/core/popper.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>bootstrap/assets/js/core/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>bootstrap/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="<?= base_url() ?>bootstrap/assets/js/plugins/bootstrap-switch.js"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="<?= base_url() ?>bootstrap/assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>bootstrap/assets/js/plugins/moment.min.js"></script>
    <script src="<?= base_url() ?>bootstrap/assets/js/plugins/datetimepicker.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>bootstrap/assets/js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>bootstrap/vendor/autocomplete/jquery.easy-autocomplete.js" ></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery.maskMoney.js"></script>
    <script src="<?= base_url() ?>bootstrap/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui.js"></script>

    <script src="<?= base_url() ?>bootstrap/vendor/font-awesome/css/fonts.js"></script>

    <script  src="<?= base_url() ?>bootstrap/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script  src="<?= base_url() ?>bootstrap/vendor/metisMenu/metisMenu.min.js"></script>


    <script type="text/javascript" src="<?= base_url() ?>bootstrap/vendor/autocomplete/jquery.easy-autocomplete.js" ></script>

    <script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery.maskMoney.js"></script>
    <!-- Control Center for Argon UI Kit: parallax effects, scripts for the example pages etc -->
    <!--  Google Maps Plugin    -->
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
    <script src="<?= base_url() ?>/bootstrap/assets/js/argon-design-system.min.js" ></script>
    <!--Scripts necessários para o calendário-->
    
    <!-- <script src="<?= base_url() ?>bootstrap/fullcalendar/main.js"></script> -->
    <!-- <script src="<?= base_url() ?>bootstrap/fullcalendar/main.css"></script> -->
    <link href="<?= base_url() ?>bootstrap/fullcalendar-scheduler/main.css" rel='stylesheet'/>
    <script src="<?= base_url() ?>bootstrap/fullcalendar-scheduler/main.js"></script>
    <script src="<?= base_url() ?>bootstrap/fullcalendar/locales/pt-br.js"></script>
    <!-- <script src="<?= base_url() ?>node_modules/@fullcalendar/daygrid/main.js"></script> -->
    <!-- <link href="<?= base_url() ?>node_modules/@fullcalendar/daygrid/main.css" rel='stylesheet'/> -->
    <!-- <script src="<?= base_url() ?>node_modules/moment/moment.js"></script> -->
    <script src='https://cdn.jsdelivr.net/npm/moment@2.27.0/min/moment.min.js'></script>
    <!-- <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@5.3.1/main.js'></script> -->
    <!-- <script src="<?= base_url() ?>node_modules/pivottable/dist/pivot.pt.min.js"></script> -->
</head>

    <audio src="<?=base_url()?>clinicas/upload/menssagealert/alert.mp3">
    </audio>

<!--    <div class="header">-->
<!--        <div id="imglogo">-->
<!---->
<!--            <img src="--><?//= base_url(); ?><!--img/stg - logo.jpg" alt="Logo"-->
<!--                 title="Logo" height="70" id="Insert_logo"-->
<!--                 style="display:block;" />-->
<!--        </div>-->
<!---->
<!--        <div id="login">-->
<!--            <div id="user_info">-->
<!--                <label style='font-family: serif; font-size: 8pt;'>Seja bem vindo --><?//= $this->session->userdata('login'); ?><!--! </label>-->
<!--                --><?//
//                $numLetras = strlen($this->session->userdata('empresa'));
//                $css = ($numLetras > 20) ? 'font-size: 7pt' : '';
//                ?>
<!--                <label style='font-family: serif; font-size: 8pt;'>Empresa: <span style="--><?//= $css ?><!--">--><?//= $this->session->userdata('empresa'); ?><!--</span></label>-->
<!--            </div>-->
<!--            <div id="login_controles">-->
<!---->
<!--                <!--<a href="#" alt="Alterar senha" id="login_pass">Alterar Senha</a>-->
<!---->
<!--                <a id="login_sair" title="Sair do Sistema" onclick="javascript: return confirm('Deseja realmente sair da aplicação?');"-->
<!--                   href="--><?//= base_url() ?><!--login/sair">Sair</a>-->
<!---->
<!---->
<!---->
<!--                --><?// if ($chat == 't') { ?>
<!---->
<!--                    <div class="batepapo_div">-->
<!--                        <a id="contatos_chat_lista" href="#" class="nao_clicado">-->
<!--                            <img src="--><?//= base_url(); ?><!--img/chat_icon.png" alt="Batepapo"-->
<!--                                 title="Batepapo"/></a>-->
<!--                    </div>-->
<!--                --><?// } ?>
<!--            </div>-->
<!--            <!--<div id="user_foto">Imagem</div>-->
<!---->
<!--        </div>-->
<!---->
<!---->
<!--        --><?// if ($logo_clinica == 't') { ?>
<!---->
<!--            <div id="imgLogoClinica" style="">-->
<!--                <img src="--><?//= base_url(); ?><!--upload/logomarca/--><?//= $empresa_id; ?><!--/logomarca.jpg" alt="Logo Clinica"-->
<!--                     title="Logo Clinica" height="70" id="Insert_logo" />-->
<!--            </div>-->
<!--            <div style="float:right; margin-right: 20px; color: darkorange;">-->
<!--                <div id="sis_info" style="margin-top: 0px;">-->
<!--                    <a href="#" id="suportelink"   onclick="functionAlert();"> <b>SUPORTE</b>   </a>-->
<!--                </div>-->
<!--            </div>-->
<!--        --><?// } ?>
<!--        --><?php //if ($chat == 't') { ?>
<!--            <!--                <div style="float:right;">-->
<!--                    <a href="--><?//= base_url(); ?><!--seguranca/operador/entrarnochat" style="color:white; font-weight: normal; text-decoration: none;" target="_blank">IR P/ CHAT</a>-->
<!--                    &nbsp;&nbsp;-->
<!--                </div> -->
<!--        --><?php //}?>
<!--    </div>-->

<body class="index-page">
    <!--NAV BAR -->
    <nav id="navbar-main" class="navbar navbar-light navbar-expand-lg mainmenu">

          <a class="navbar-brand" href="<?= base_url() ?>home">
                <img src="<?= base_url() ?>img/logo.png"  alt="stg - logo">
            </a>
          
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

          <div class="navbar-collapse collapse" id="navbar_global">
            <div class="navbar-collapse-header">
              <div class="row">
                <div class="col-6 collapse-brand">
                  <a href="<?= base_url() ?>home">
                    <img src="<?= base_url() ?>img/logo.png"  alt="stg - logo">
                  </a>
                </div>
                <div class="col-6 collapse-close">
                  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                  </button>
                </div>
              </div>
            </div>
            
            <ul class="navbar-nav mr-auto">
            <!-- MENUS START -->
                <? if ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || ( $perfil_marketing_p == 't' && $perfil_id == 14) || $perfil_id == 5 || ($perfil_id == 18 || $perfil_id == 20) || $perfil_id == 6 || ($perfil_id == 11 || $perfil_id == 21) || $perfil_id == 12 || $perfil_id == 10 || $perfil_id == 15 || $perfil_id == 19 || ( $financeiro_cadastro == 't' && $perfil_id == 13) || ($perfil_id == 7 && $tecnico_acesso_acesso == 't')|| ($perfil_id == 4 && $medico_agenda == 't') || $perfil_id == 24 || $perfil_id == 25 || $perfil_id == 26) { ?>
                <li class="dropdown">
                    <a href="#" id="menu" data-toggle="dropdown" class="nav-link dropdown-toggle w-100">
                            <i class="fa fa-address-book-o fa-fw"></i>Recepção</a>

                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-edit fa-fw"></i> Rotinas <span class="fa arrow"></span></a>
                                    <ul  class="dropdown-menu">
                                        <?
                                        if (($perfil_id == 7 && $tecnico_acesso_acesso == 't') || ($perfil_id == 15 && $tecnico_acesso_acesso == 't')  ) {
                                        ?>
                                        <li>
                                            <a class="dropdown-item  drop-head" href="<?= base_url() ?>cadastros/pacientes">Cadastro</a>
                                        </li>
                                        <? { ?>
                                        <li>
                                            <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaoconsultacalendario">Agendamento</a>
                                        </li>
                                        <!-- <a class="dropdown-item" href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaoconsulta">Agendamento</a> -->
                                    </ul>
                                <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bar-chart-o fa-fw"></i> Relatorios <span class="fa arrow"></span></a>
                                    <ul  class="dropdown-menu">
                                        <li class="dropdown-item p-0">
                                            <a class="dropdown-item drop-head"  href="<?= base_url() ?>ambulatorio/guia/relatorioaniversariante">Relatorio Aniversariantes</a>
                                        </li>
                                    </ul>
                            </li>
                        </ul>
                </li>
                <? } ?>
                
                <li class="nav-item dropdown">
                    <a href="#" id="menu" data-toggle="dropdown" class="nav-link dropdown-toggle w-100">
                        <i class="fa fa-user-md fa-fw"></i>Atendimento </a>

                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-edit fa-fw"></i> Rotinas <span class="fa arrow"></span></a>
                                <ul  class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicoconsulta">Atendimento Médico</a>
                                    </li>
                                    <li>
                                        <a hidden class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/exame/relatorioteste">Relatório Teste</a>
                                    </li>
                                </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbar-primary_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-edit fa-fw"></i>Geral </a>

                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-edit fa-fw"></i> Imagem <span class="fa arrow"></span></a>

                        </li>
                    </ul>
                    
                </li>

                <li class="nav-item dropdown">
                    <a href="#" id="menu" data-toggle="dropdown" class="nav-link dropdown-toggle w-100">
                        <i class="fa fa-university fa-fw"></i> Financeiro </a>

                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-edit fa-fw"></i> Rotinas <span class="fa arrow"></span></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/caixa">Entradas</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/caixa/pesquisar2">Saidas</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/contaspagar">Contas a Pagar</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/contasreceber">Contas a Receber</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/fornecedor">Credor/Devedor</a>
                                    </li>

                                </ul>
                            <a class="title"><i class="fa fa-bar-chart-o fa-fw"></i> Relatorios <span class="fa arrow"></span></a>
                                <ul class="dropdown-menu">
                                    <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/guia/relatoriocaixa">Relatorio Caixa</a>
                                    <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconveniofinanceiro">Relatorio Produ&ccedil;&atilde;o M&eacute;dica</a>
                                    <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/guia/relatorioindicacaoexames">Relatorio Recomendação</a>
                                </ul>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbar-primary_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cubes"></i>Estoque </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-primary_dropdown_1">
                        <a class="title"><i class="fa fa-edit fa-fw"></i> Rotinas <span class="fa arrow"></span></a>
                            <ul>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/solicitacao">Manter Solicitacao</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/entrada">Manter Entrada</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/nota">Manter Nota Fiscal</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/inventario">Manter Inventar</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/fornecedor">Manter Fornecedor</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/produto">Manter Produto</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/pedido">Manter Pedido Compra</a>
                            </ul>
                        <a class="title"><i class="fa fa-bar-chart-o fa-fw"></i> Relatorios <span class="fa arrow"></span></a>
                            <ul>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/entrada/relatoriosaldoproduto">Relatorio Saldo Produtos</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/nota/relatorionotas">Relatorio Nota</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/entrada/relatorioentradaarmazem">Relatorio Entrada Produtos</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/entrada/relatoriosaidaarmazem">Relatorio Saida Produtos</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/entrada/relatoriominimo">Relatorio Estoque Minimo</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/entrada/relatorioprodutos">Relatorio Produtos</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/entrada/relatoriofornecedores">Relatorio Fornecedores</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/entrada/relatoriosaldo">Relatorio Saldo Produtos Por Fornecedor</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/entrada/relatoriosaldoarmazem">Relatorio Saldo Produtos Por Entrada</a>
                            </ul>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbar-primary_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-line-chart"></i> Faturamento </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-primary_dropdown_1">
                        <a class="title"><i class="fa fa-edit fa-fw"></i> Rotinas <span class="fa arrow"></span></a>
                            <ul>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/exame/faturamentoexame">Faturar</a>
                            </ul>
                        <a class="title"><i class="fa fa-bar-chart-o fa-fw"></i> Relatorios <span class="fa arrow"></span></a>
                        <ul>
                            <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/guia/relatorioexame">Relatorio Conferencia</a>
                        </ul>
                        <ul>
                            <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/guia/relatorioalteracaomedico">Relatorio Alteracao Medico</a>
                        </ul>
                    </div>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbar-primary_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cogs fa-fw"></i> Configurações </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-primary_dropdown_1">
                        <a class="title"><i class="fa fa-address-book-o fa-fw"></i> Recepção</a>
                            <ul>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>seguranca/operador">Listar Profissionais</a>
                                <!--<a href="<?= base_url() ?>ambulatorio/tipoconsulta">Tipo consulta</a>-->
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/agenda">Criação de Agenda</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/agenda/medicoagendaconsulta">Excluir/Alterar Agenda</a>
                                <!--<a href="<?= base_url() ?>ambulatorio/exame">Agenda Manter</a>-->
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/motivocancelamento">Motivo cancelamento</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/indicacao">Manter Indicação</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/guia/configurarimpressao">Configurar Impressão</a>
                                <!--<a href="<?= base_url() ?>ambulatorio/modelodeclaracao">Modelo Declara&ccedil;&atilde;o</a>-->
                            </ul>
                        <a class="title"><i class="fa fa-clone fa-fw"></i> Modelos</a>
                            <ul>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/modelolaudo/pesquisar">Manter Modelo Laudo</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/modelolinha/pesquisar">Manter Modelo Linha</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/modeloreceita/pesquisar">Manter Modelo Receita</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/modeloatestado/pesquisar">Manter Modelo Atestado</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/modeloreceitaespecial/pesquisar">Manter Modelo R. Especial</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/modelodeclaracao/pesquisar">Modelo Declara&ccedil;&atilde;o</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/modelosolicitarexames/pesquisar">Manter Modelo S.Exames</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/modelomedicamento/pesquisar">Manter Medicamento</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/modelomedicamento/pesquisarunidade">Manter Medicamento Unidade</a>
                                <!--<a href="<?= base_url() ?>ambulatorio/modelolinha">Manter Modelo Linha</a>-->
                            </ul>
                        <a class="title"><i class="fa fa-medkit fa-fw"></i> Procedimentos <span class="fa arrow"></span></a>
                            <ul>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/procedimento/pesquisartuss">Manter Procedimentos TUSS</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/procedimento">Manter Procedimentos</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/procedimentoplano">Manter Procedimentos Convenio</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/convenio">Manter Convenio</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/procedimentoplano/procedimentopercentualpromotor">Manter Percentual Recomendação</a>
                            </ul>
                        <a class="title"><i class="fa fa-money fa-fw"></i> Financeiro <span class="fa arrow"></span></a>
                            <ul>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/tipo">Manter Tipo</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/classe">Manter Classe</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/forma">Manter Conta</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/formapagamento">Manter Forma de Pagamento</a>
                            </ul>
                        <a class="title"><i class="fa fa-gear fa-fw"></i> Aplicativo <span class="fa arrow"></span></a>
                            <ul>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/empresa/listarpostsblog">Posts Blog</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/empresa/listarpesquisaSatisfacao">Pesquisa Satisfação</a>
                            </ul>
                        <a class="title"><i class="fa fa-gear fa-fw"></i> Configuração <span class="fa arrow"></span></a>
                            <ul>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/empresa/gerecianet">Manter Gerencia Net</a>
                            </ul>
                    </div>
                </li>
                <li class="nav-item nav-item-user dropdown">
                    <a class="dropdown-toggle" href="#" id="navbar-primary_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Seja bem-vindo, <?= $this->session->userdata('login'); ?>
                        <i class="fa fa-user fa-fw"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-primary_dropdown_1">
                        <ul>
                            <a href="<?= base_url() ?>seguranca/operador/alterarheader/<?=$operador_id?>"><i class="fa fa-user fa-fw"></i> Perfil</a>
                            <a class="dropdown-item drop-head" href="<?= base_url() ?>seguranca/operador"><i class="fa fa-gear fa-fw"></i> Configurações</a>
                            <div class="dropdown-divider"></div>
                            <a onclick="confirmacao()" style="cursor: pointer;"><i class="fa fa-sign-out fa-fw"></i> Sair</a>
                        </ul>
                    </div>
                </li>
            </ul>
          </div>
        </div>  
    </nav>
    <nav class="navbar navbar-light navbar-expand-lg mainmenu">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown2</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                                <li class="dropdown">
                                    <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown3</a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                    </ul>
                                </li>
                                </ul>
                            </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
    
    
</body>

<script>
    $('.dropdown-menu a.removefromcart').click(function(e) {
        e.stopPropagation();
    });

(function($){
	$('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
	  if (!$(this).next().hasClass('show')) {
		$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
	  }
	  var $subMenu = $(this).next(".dropdown-menu");
	  $subMenu.toggleClass('show');

	  $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
		$('.dropdown-submenu .show').removeClass("show");
	  });

	  return false;
	});
})(jQuery)

    $(document).ready(function () {
        $('#txtNascimento').mask('99/99/9999');
        $("#valor").maskMoney();
        $('#txtCpf').mask('999.999.999-99');
        $('.data').mask('99/99/9999');
        $('.cnpj').mask('99.999.999/9999-99');
        $('.cpf').mask('999.999.999-99');
        $('.celular').mask('(99) 99999-9999');
        $('.telefone').mask('(99) 9999-9999');
        $('.hora').mask('99:99');
        $(".integer").maskMoney({allowNegative: false, decimal: '.', affixesStay: false, precision: 2});
        $(".percentual").maskMoney({allowNegative: true, decimal: '.', affixesStay: false, precision: 3});
        $(".dinheiro").maskMoney({allowNegative: false, thousands: '.', decimal: ',', affixesStay: false, precision: 2});

    });

    function confirmacao() {
        swal({
            title: "Tem certeza?",
            text: "Você está prestes a sair do sistema!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#337ab7",
            confirmButtonText: "Sim, quero sair!",
            cancelButtonText: "Não, cancele!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
                function (isConfirm) {
                    if (isConfirm) {
                        window.open('<?= base_url() ?>login/sair', '_self');
                    } else {
                        swal("Cancelado", "Você desistiu de sair do sistema", "error");
                    }
                });

    }

    function acao(){
        const audio = document.querySelector('audio');

        audio.play();


    }
    //            var jQuery = jQuery.noConflict();

    (function ($) {
        $(function () {
            $('input:text').setMask();
        });
    })(jQuery);

    // Fazendo atualização da tabela de SMS
    jQuery(function () {
        jQuery.ajax({
            type: "GET",
            url: "<?= base_url(); ?>" + "login/verificasms",
            dataType: "json"
        });
    });

    function functionAlert(msg, myYes) {
        var confirmBox = $("#confirm");
        confirmBox.find(".message").text(msg);
        confirmBox.find(".yes").unbind().click(function () {
            confirmBox.hide();
        });
        confirmBox.find(".yes").click(myYes);
        confirmBox.show();
        $("#inforstg").show();
    }

    // Checando lembretes
    jQuery(function () {
        jQuery.ajax({
            type: "GET",
            url: "<?= base_url(); ?>ambulatorio/empresa/checandolembrete",
            dataType: "json",
            success: function (retorno) {
//                        alert('ola');
                for (var i = 0; i < retorno.length; i++) {
                    if (retorno[i].visualizado == 0) {
                        alert(retorno[i].texto);
                        jQuery.ajax({type: "GET", data: "lembretes_id=" + retorno[i].empresa_lembretes_id,
                            url: "<?= base_url(); ?>ambulatorio/empresa/visualizalembrete"});
                    }
                }
            }
        });
    });

    // Checando lembretes aniversário
    jQuery(function () {
        jQuery.ajax({
            type: "GET",
            url: "<?= base_url(); ?>ambulatorio/empresa/checandolembreteaniversario",
            dataType: "json",
            success: function (retorno) {
                //    alert('ola');
                //    console.log(retorno);
                if (retorno != null) {
                    alert(retorno[0]);
                    jQuery.ajax({type: "GET", data: "lembretes_id=" + retorno[1],
                        url: "<?= base_url(); ?>ambulatorio/empresa/visualizalembreteaniv"});
                }
            },
            error: function () {
//                        alert('Error');
            }
        });
    });


    <? if ($chat == 't') { ?>


    var chatsAbertos = new Array();

    function mensagensnaolidas() {
        jQuery.ajax({
            type: "GET",
            url: "<?= base_url(); ?>" + "batepapo/totalmensagensnaolidas",
            dataType: "json",
            success: function (retorno) {

                if (jQuery(".batepapo_div #contatos_chat_lista span").length > 0) {
                    const audio = document.querySelector('audio');
                    audio.play();
                    jQuery(".batepapo_div #contatos_chat_lista span").remove();
                }

                if (retorno != 0) {
                    jQuery(".batepapo_div #contatos_chat_lista").append("<span class='total_mensagens'>+" + retorno + "</span>");
                    abrindomensagensnaolidas();
                }
            }
        });
    }


    function abrindomensagensnaolidas() {
        jQuery.ajax({
            type: "GET",
            url: "<?= base_url(); ?>" + "batepapo/abrindomensagensnaolidas",
            dataType: "json",
            success: function (retorno) {

                if (retorno.length > 0) {
                    for (var obj in retorno) {
                        var id = "<?= $operador_id ?>:" + retorno[obj].operador_id;
                        var nome = retorno[obj].usuario;
                        var status = null;
                        var aberta = false;
                        for (var i = 0; i < chatsAbertos.length; i++) {
                            if (retorno[obj].operador_id == chatsAbertos[i]) {
                                aberta = true;
                            }
                        }
                        if (!aberta) {
                            adicionarJanela(id, nome, status);
                        }
                    }
                }

            }
        });
    }

    //carrega a lista de contatos ao clicar no icone do batepapo
    function carregacontatos() {
        jQuery.ajax({
            type: "GET",
            url: "<?= base_url(); ?>" + "batepapo/pesquisar",
            dataType: "json",
            success: function (retorno) {
                //traz uma lista com todos os operadores cadastrados, exceto a pessoa que esta logada
                jQuery.each(retorno, function (i, usr) {
                    var tags = null;
                    if (usr.operador_id != <? echo $operador_id ?> && usr.usuario != 0) {
                        // Toda item da lista e construido da seguinte maneira:
                        // TAG <li> com o id do operador correspondente aquele item
                        // TAG <div> dentro de <li> com o classe imgPerfil (onde ficara a foto de perfil do usuario)
                        // TAG <a> dentro de <li> que ira servir de link para iniciar a janela de batepapo. Esta estruturada da seguinte forma:
                        //     href com endereco cego
                        //     id com id do operador logado e do operador clicado, separado por ':'. Exemplo id="1:4327";
                        //     class com o valor "comecarChat", que ira servir para impedir que o usuario abra duas vezes o mesmo contato.
                        //          quando é clicado em um item o valor da class automaticamente é removido
                        // TAG <span> com class='total_mensagens' mostrando o numero de mensagens nao lidas daquele contato
                        // TAG <span> que futuramente indicara se o uusuario esta online ou offline
                        tags = "<li id='" + usr.operador_id + "'><div class='imgPerfil'></div>";
                        tags += "<a href='#' id='<? echo $operador_id ?>:" + usr.operador_id + "' class='comecarChat'>" + usr.usuario + "</a>";
                        if (usr.num_mensagens != 0) {
                            tags += "<span class='total_mensagens'> +" + usr.num_mensagens + " </span>";
                        }
                        if (usr.status == 't') {
                            var status = 'on';
                        } else {
                            var status = 'off';
                        }
                        tags += "<span id='" + usr.operador_id + "' class='status " + status + "'></span></li>";

                        //apos criar o item, adciona ele a lista e cria-se o item seguinte
                        jQuery("#principalChat #usuarios_online ul").append(tags);
                    }
                });
            }
        });
        //                    verifica(0, 0,<? echo $operador_id ?>);
    }


    //abri uma nova janela de batepapo
    function adicionarJanela(id, nome, status) {
        //o parametro ID diz respeito ao operador_id que mandou a mensagem
        //o parametro NOME diz respeito ao nome de usuario de quem mandou a mensagem
        //o parametro STATUS e para saber se quem mandou a mensagem esta online no momento



        //o numero maximo de janelas permitido sao cinco
        var numeroJanelas = Number(jQuery("#chats .janela_chat").length);
        if (numeroJanelas < 5) {

            //atribui dinamicamente a posicao da janela na pagina
            var posicaoJanela = (270 + 15) * numeroJanelas;
            var estiloJanela = 'float:none; position: absolute; bottom:0; right:' + posicaoJanela + 'px';

            //pega o id do operador origem e do operador destino
            var splitOperadores = id.split(':');
            var operadorDestino = Number(splitOperadores[1]);


            // CRIANDO A JANELA DE BATEPAPO
            // Toda janela de batepapo e construida da seguinte maneira:
            // TAG <div> class='janela_chat' (serve para estilizar via CSS) e id que contera o id do contado aberto
            //           tornando diferente cada janela aberta e auxiliando em alguns eventos.
            //           (tais como fechar o chat e atualizar na lista de chatsAbertos). Todas as divs abaixos estao contidas nessa.
            // TAG <div> dentro da principal com class='cabecalho_janela_chat'(estilizacao via CSS). Essa contera o cabecalho da
            //           janela. Exemplo: icone de fechar, nome, status (futuramente)
            //              TAG <span> com class='fechar' para fecchar janela
            //              TAG <span> com class='nome_chat' para mostrar o nome do usuario
            //              TAG <span> que futuramente mostrara status
            // TAG <div> com class='corpo_janela_chat' que contera as mensagens deste contato e o input para enviar mensagens.
            //           TAG <div> com class='mensagens_chat' que dentro tera uma lista <ul> mostrando as mensagens
            //                  cada mensagem em uma janela aberta esta dentro de uma <li>, nesta <ul>
            //           TAG <div> com class='enviar_mensagens_chat' que tera o input para enviar as mensagens
            //                  essa div tera um id com o id do operador logado e do operador qe ela esta dialogando
            //                  para ajudar em eventos do javascript.
            //                  o INPUT tem um valor maximo de 300 caracteres
            var janela;
            janela = "<div class='janela_chat' id='janela_" + operadorDestino + "' style='" + estiloJanela + "'>";
            janela += "<div class='cabecalho_janela_chat'> <a href='#' class='fechar'>X</a>";
            janela += "<span class='nome_chat'>" + nome + "</span><span id='" + operadorDestino + "' class='" + status + "'></span></div>";
            janela += "<div class='corpo_janela_chat'><div class='mensagens_chat'><ul></ul></div>";
            janela += "<div class='enviar_mensagens_chat' id='" + id + "'>";
            janela += "<input type='text' maxlength='300' name='mensagem_chat' class='mensagem_chat' id='" + id + "' /></div></div></div>";
            //acrescenta a janela ao aside chats
            jQuery("#chats").append(janela);
            //adiciona a janela criada na lista de janelas abertas
            chatsAbertos.push(operadorDestino);
            //retorna o historico de mensagens e faz a pagina se atualizar novamente
            retorna_historico(operadorDestino);
            //                        verifica(0, 0,<? // echo $operador_id                                                                                        ?>);

        }
    }




    //retornando historico de conversas
    function retorna_historico(idJanela) {
        //                    console.log('teste');
        var operadorOrigem = <? echo $operador_id; ?>;

        jQuery.ajax({
            type: "GET",
            url: "<?= base_url(); ?>" + "batepapo/historicomensagens",
            data: "operador_origem=" + operadorOrigem + "&operador_destino=" + idJanela,
            dataType: 'json',
            success: function (retorno) {
                jQuery.each(retorno, function (i, msg) {
                    if (jQuery('#janela_' + msg.janela).length > 0) {

                        if (operadorOrigem == msg.id_origem) {
                            jQuery("#janela_" + msg.janela + " .corpo_janela_chat .mensagens_chat ul").append("<li class='eu' id='" + msg.chat_id + "'><p>" + msg.mensagem + "</p><div class='data_envio'>" + msg.data_envio + "</div></li>");
                        } else {
                            jQuery("#janela_" + msg.janela + " .corpo_janela_chat .mensagens_chat ul").append("<li id='" + msg.chat_id + "'><p>" + msg.mensagem + "</p><div class='data_envio'>" + msg.data_envio + "</div></li>");
                        }
                    }
                });
                var altura = jQuery("#janela_" + idJanela + " .corpo_janela_chat .mensagens_chat").height();
                jQuery("#janela_" + idJanela + " .corpo_janela_chat .mensagens_chat").animate({scrollTop: 1000000}, '500');

            }
        });
        //                    verifica(0, 0,<? // echo $operador_id                                                                                          ?>);
    }

    <? } ?>

</script>


<!--    Aqui abaixo você encontra a função que chama a mensagem bonitinha, pessoa que estiver olhando.-->
<!--
PRA ALTERAR A MENSAGEM PADRÃO QUE APARECE E O ICONE A QUE É ATRIBUIDO, É SÓ ENTRAR NO UTILITARIO E PROCURAR A FUNÇÃO QUE ELE CHAMA
DAI TEM LÁ UM ARRAY ONDE EU PASSO DUAS COISAS, UMA É A MENSAGEM QUE VAI APARECER E A OUTRA É SE É 'WARNING' 'ERROR' OU 'SUCCESS'-->
<?php
$this->load->library('utilitario');
@$mensagem = Utilitario::pmf_mensagem($this->session->flashdata('message'));
?>





