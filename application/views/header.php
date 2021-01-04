<?
//Da erro no home
if ($this->session->userdata('autenticado') != true) {
    redirect(base_url() . "login/index/login004", "refresh");
}
$perfil_id = $this->session->userdata('perfil_id');
$operador_id = $this->session->userdata('operador_id');

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

?>
<!DOCTYPE html PUBLIC "-//carreW3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pt-BR" >
<head><!--<meta charset="utf-8">-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STG - SISTEMA DE GESTAO DE CLINICAS v2.0</title>
    <!-- <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="content-type" content="text/html;charset=utf-8" /> -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<!--    <link src="http://maxcdn.bootstrapcdn.com/font-awesome/5.10.0/css/font-awesome.min.css" rel="stylesheet">-->
    <!-- Font Awesome Icons -->
    <link href="<?= base_url() ?>bootstrap/assets/css/all.css" rel="stylesheet" />
<!--    <link href="--><?//= base_url() ?><!--bootstrap/assets/css/fontawesome.css" rel="stylesheet" />-->
    <link href="<?= base_url() ?>bootstrap/assets/css/nucleo-svg.css" rel="stylesheet" />
    <link href="<?= base_url() ?>bootstrap/assets/less/fontawesome.less" rel="stylesheet/less" type="text/css" />
    <link href="<?= base_url() ?>bootstrap/assets/css/fontawesome.css" rel="stylesheet">
    <link href="<?= base_url() ?>bootstrap/assets/css/brands.css" rel="stylesheet">
    <link href="<?= base_url() ?>bootstrap/assets/css/solid.css" rel="stylesheet">

<!--    <script src="--><?//= base_url() ?><!--bootstrap/assets/js/all.js" type="text/javascript"></script>-->
    <script src="<?= base_url() ?>bootstrap/assets/js/brands.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>bootstrap/assets/js/solid.js" type="text/javascript"></script>
<!--    <script src="--><?//= base_url() ?><!--bootstrap/assets/js/fontawesome.js" type="text/javascript"></script>-->
    <!-- CSS Files -->
    <link href="<?= base_url() ?>bootstrap/vendor/bootstrap/css/bootstrap.css" rel="stylesheet"/>
    <link href="<?= base_url() ?>bootstrap/assets/css/argon-design-system.css?v=1" rel="stylesheet"/>

    <!-- <link href="<?= base_url() ?>css/header.css" rel="stylesheet"/> -->
    <link href="<?= base_url() ?>js/jquery-ui.css" rel="stylesheet"/>
    <link href="<?= base_url() ?>js/jquery-ui.structure.css" rel="stylesheet"/>
    <link href="<?= base_url() ?>js/jquery-ui.theme.css" rel="stylesheet"/>
    <link href="<?= base_url() ?>css/header1.css" rel="stylesheet"/>

    <!--CSS DO Calendário-->
    <link href="<?= base_url() ?>bootstrap/fullcalendar/main.css" rel="stylesheet" />
    <!--DEFINE TAMANHO MAXIMO DOS CAMPOS-->
    <link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
    <!--CSS DO ALERTA BONITINHO-->
    <link href="<?= base_url() ?>bootstrap/vendor/alert/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <!--   Core JS Files   -->
<!--    <script src="--><?//= base_url() ?><!--bootstrap/assets/js/all.js" type="text/javascript"></script>-->
    <script src="<?= base_url() ?>bootstrap/vendor/alert/dist/sweetalert.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>bootstrap/assets/js/core/jquery.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>bootstrap/assets/js/core/popper.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>bootstrap/assets/js/core/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>bootstrap/assets/js/plugins/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="<?= base_url() ?>bootstrap/assets/js/plugins/bootstrap-switch.js" type="text/javascript"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="<?= base_url() ?>bootstrap/assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>bootstrap/assets/js/plugins/moment.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>bootstrap/assets/js/plugins/datetimepicker.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>bootstrap/assets/js/plugins/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?= base_url() ?>bootstrap/vendor/autocomplete/jquery.easy-autocomplete.js" ></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery.maskMoney.js"></script>
    <script src="<?= base_url() ?>bootstrap/vendor/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>bootstrap/vendor/jquery/jquery.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui.js"></script>

    <script src="<?= base_url() ?>bootstrap/vendor/font-awesome/css/fonts.js" type="text/javascript"></script>

    <script  src="<?= base_url() ?>bootstrap/vendor/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script  src="<?= base_url() ?>bootstrap/vendor/metisMenu/metisMenu.min.js" type="text/javascript"></script>


    <script type="text/javascript" src="<?= base_url() ?>bootstrap/vendor/autocomplete/jquery.easy-autocomplete.js" ></script>

    <script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery.maskMoney.js"></script>
    <!-- Control Center for Argon UI Kit: parallax effects, scripts for the example pages etc -->
    <!--  Google Maps Plugin    -->
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
    <script src="<?= base_url() ?>bootstrap/assets/js/argon-design-system.min.js" type="text/javascript"></script>

    <!--Scripts necessários para o calendário-->
    <link href="<?= base_url() ?>bootstrap/fullcalendar-scheduler/main.css" rel='stylesheet'/>
    <script src="<?= base_url() ?>bootstrap/fullcalendar-scheduler/main.js"></script>
    <script src="<?= base_url() ?>bootstrap/fullcalendar/locales/pt-br.js"></script>
    
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bootstrap/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="<?= base_url() ?>bootstrap/DataTables/datatables.min.js"></script>


    <script>
        $(document).ready(function () {
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR'
            });
        });

    </script>

</head>

<body class="index-page">
<!--NAV BAR -->
<nav id="navbar-main" class="navbar navbar-light navbar-expand-lg">

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
                <a class="dropdown-toggle" href="#" id="navbarDropdown" data-toggle="dropdown" >
                    <i class="fa fa-address-book-o fa-fw"></i>Recepção</a>

                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-edit fa-fw"></i> Rotinas <span class="fa arrow"></span></a>
                        <? if (($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || ( $perfil_marketing_p == 't' && $perfil_id == 14) || $perfil_id == 5 || ($perfil_id == 18 || $perfil_id == 20) || $perfil_id == 6 || ($perfil_id == 11 || $perfil_id == 21) || $perfil_id == 12 || $perfil_id == 10 || ($perfil_id == 15 && $tecnico_acesso_acesso != 't') || $perfil_id == 19) || ( $financeiro_cadastro == 't' && $perfil_id == 13) || ( $medico_agenda == 't' && $perfil_id == 4)  || $perfil_id == 24 || $perfil_id == 25 || $perfil_id == 26) { ?>
                            <?php if ($perfil_id != 4) { ?>
                            <ul  class="dropdown-menu">
                                <li>
                                    <a href="<?= base_url() ?>cadastros/pacientes">Cadastro</a>
                                </li>
                               <?  if ($perfil_id != 4 && $perfil_id != 13 && $perfil_id != 24 || ( $perfil_marketing_p == 't' && $perfil_id == 14) || ($medico_agenda == 't' && $perfil_id == 4) ) { ?>
                                    <? if ($geral == 't') {
                                       if ($calendario_layout == 't') { ?>
                                            <li>
                                                <a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaocalendario2">Agendamento</a>
                                            </li>
                                       <? } else { ?>
                                           <li>
                                               <a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaocalendario">Agendamento</a>
                                           </li>
                                       <? } ?>
                                    <? } ?>
                                <? } ?>
                            </ul>
                            <? } ?>
                        <? } ?>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Relatorios <span class="fa arrow"></span></a>
                        <ul  class="dropdown-menu">
                            <li>
                                <a href="<?= base_url() ?>ambulatorio/guia/relatorioaniversariante">Relatorio Aniversariantes</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <? } ?>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user-md fa-fw"></i>Atendimento </a>

                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-edit fa-fw"></i> Rotinas <span class="fa arrow"></span></a>
                        <ul  class="dropdown-menu">
                            <li>
                                <a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicoconsulta">Atendimento Médico</a>
                            </li>
                            <li>
                                <a hidden class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/exame/relatorioteste">Relatório Teste</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-edit fa-fw"></i>Geral </a>

                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-x-ray fa-fw"></i> Imagem <span class="fa arrow"></span></a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-edit fa-fw"></i>Rotinas</a>
                                <ul  class="dropdown-menu">
                                    <li>
                                        <a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedico">Multifuncao Medico</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url() ?>ambulatorio/laudo">Manter Laudo</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url() ?>ambulatorio/laudo/pesquisardigitador">Manter Laudo Digitador</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url() ?>ambulatorio/laudo/pesquisarrevisor">Manter Revisor</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url() ?>ambulatorio/laudo/pesquisarlaudoantigo">Manter Antigo</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url() ?>ambulatorio/laudo/pesquisarconsultaantigo">Histórico de Atendimentos Antigos</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bar-chart-o fa-fw"></i> Relatorios</a>
                                <ul  class="dropdown-menu">
                                    <li>
                                        <a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconvenio">Relatorio de Produ&ccedil;&atilde;o</a>
                                    </li>

                                </ul>
                            </li>

                        </ul>

                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-first-aid"></i> Consultas </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-edit fa-fw"></i>Rotinas</a>
                                <ul  class="dropdown-menu">
                                    <li>
                                        <a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicoconsulta">Multifuncao Medico</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url() ?>ambulatorio/laudo/pesquisarconsulta">Manter Consulta</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url() ?>ambulatorio/laudo/pesquisarconsultaantigo">Histórico de Atendimentos Antigos</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url() ?>ambulatorio/laudo/pesquisarrevisor">Manter Revisor</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url() ?>ambulatorio/laudo/pesquisarlaudoantigo">Manter Antigo</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url() ?>ambulatorio/laudo/pesquisarconsultaantigo">Histórico de Atendimentos Antigos</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bar-chart-o fa-fw"></i> Relatorios</a>
                                <ul  class="dropdown-menu">
                                    <li>
                                        <a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconvenio">Relatorio de Produ&ccedil;&atilde;o</a>
                                    </li>

                                </ul>
                            </li>

                        </ul>

                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-notes-medical"></i> Especialidade </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-edit fa-fw"></i>Rotinas</a>
                                <ul  class="dropdown-menu">
                                    <li>
                                        <a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicofisioterapia">Multifuncao Especialidade</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicofisioterapiareagendar">Reagendar</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bar-chart-o fa-fw"></i> Relatorios</a>
                                <ul  class="dropdown-menu">
                                    <li>
                                        <a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconvenio">Relatorio de Produ&ccedil;&atilde;o</a>
                                    </li>

                                </ul>
                            </li>

                        </ul>

                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-tooth"></i> Odontologia </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-edit fa-fw"></i>Rotinas</a>
                                <ul  class="dropdown-menu">
                                    <li>
                                        <a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicoodontologia">Multifuncao Especialidade</a>
                                    </li>
                                    <li>
                                        <!--<a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicoodontologiareagendar">Reagendar</a>-->
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bar-chart-o fa-fw"></i> Relatorios</a>
                                <ul  class="dropdown-menu">
                                    <li>
                                        <a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconvenio">Relatorio de Produ&ccedil;&atilde;o</a>
                                    </li>

                                </ul>
                            </li>

                        </ul>

                    </li>
                </ul>

            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Relatorios <span class="fa arrow"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/guia/relatoriocaixa">Relatorio Caixa</a>
                            </li>
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconveniofinanceiro">Relatorio Produ&ccedil;&atilde;o M&eacute;dica</a>
                            </li>
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/guia/relatorioindicacaoexames">Relatorio Recomendação</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-cubes"></i>Estoque </a>

                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-edit fa-fw"></i> Rotinas <span class="fa arrow"></span></a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/solicitacao">Manter Solicitacao</a></li>
                            <li><a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/entrada">Manter Entrada</a></li>
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/nota">Manter Nota Fiscal</a>
                            </li>
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/inventario">Manter Inventar</a>
                            </li>
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/fornecedor">Manter Fornecedor</a>
                            </li>
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/produto">Manter Produto</a>
                            </li>
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/pedido">Manter Pedido Compra</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Relatorios <span class="fa arrow"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/entrada/relatoriosaldoproduto">Relatorio Saldo Produtos</a>
                            </li>
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/nota/relatorionotas">Relatorio Nota</a>
                            </li>
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/entrada/relatorioentradaarmazem">Relatorio Entrada Produtos</a>
                            </li>
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/entrada/relatoriosaidaarmazem">Relatorio Saida Produtos</a>
                            </li>
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/entrada/relatoriominimo">Relatorio Estoque Minimo</a>
                            </li>
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/entrada/relatorioprodutos">Relatorio Produtos</a>
                            </li>
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/entrada/relatoriofornecedores">Relatorio Fornecedores</a>
                            </li>
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/entrada/relatoriosaldo">Relatorio Saldo Produtos Por Fornecedor</a>
                            </li>
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>estoque/entrada/relatoriosaldoarmazem">Relatorio Saldo Produtos Por Entrada</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-line-chart"></i> Faturamento </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-edit fa-fw"></i> Rotinas <span class="fa arrow"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/exame/faturamentoexame">Faturar</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Relatorios <span class="fa arrow"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/guia/relatorioexame">Relatorio Conferencia</a>
                            </li>
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/guia/relatorioalteracaomedico">Relatorio Alteracao Medico</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-cogs fa-fw"></i>Configurações </a>

                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-address-book-o fa-fw"></i> Recepção <span class="fa arrow"></span></a>
                        <ul class="dropdown-menu">
                            <? if ($perfil_id == 1 || $perfil_id == 5 || ($perfil_id == 18 || $perfil_id == 20) || $perfil_id == 10  || $perfil_id == 25) { ?>

                                <li><a href="<?= base_url() ?>seguranca/operador">Listar Profissionais</a></li>
                                <li><a href="<?= base_url() ?>cadastros/grupomedico">Grupo Médico</a></li>
                                <li><a href="<?= base_url() ?>ambulatorio/motivocancelamento">Motivo cancelamento</a></li>
                                <li><a href="<?= base_url() ?>ambulatorio/tipoconsulta">Tipo Agenda</a></li>
                                <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/horario">Manter Horarios</a></span></ul>-->
                                <? if ($agenda_modelo2 == 'f' ) { ?>
                                    <li><a href="<?= base_url() ?>ambulatorio/agenda">Agenda Horarios</a></li>
                                <? } else { ?>
                                    <li><a href="<?= base_url() ?>ambulatorio/agenda/pesquisaragendamodelo2">Agenda Médica</a></li>
                                <? } ?>
                                <? if ($this->session->userdata('recomendacao_configuravel') == "t" || $perfil_id == 25) { ?>
                                    <li><a href="<?= base_url() ?>ambulatorio/indicacao">Manter Promotor</a></li>
                                    <li><a href="<?= base_url() ?>ambulatorio/indicacao/pesquisargrupoindicacao">Manter Grupo Promotor</a>></li>
                                <? } ?>

                                <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame">Agenda Manter</a></span></ul>-->
                            <? } ?>
                            <? if ($perfil_id != 9 && $perfil_id != 2 && $perfil_id != 13 && $perfil_id != 11 && $perfil_id != 12 && $perfil_id != 4 && $perfil_id != 7 && $perfil_id != 15) { ?>
                                <li><a href="<?= base_url() ?>ambulatorio/sala">Manter Salas</a></li>
                                <? if($setores == 't'){ ?>
                                    <li><a href="<?= base_url() ?>ambulatorio/sala/pesquisarsetores">Manter Setores</a></li>
                                <? } ?>
                                <? if ($endereco_toten != '') { ?>
                                    <li><a href="<?= base_url() ?>ambulatorio/exame/mantertabelastoten">Manter Totem</a></li>
                                <? } ?>
                            <? } ?>

                            <? if ($perfil_id != 11 && $perfil_id != 2 && $perfil_id != 13 && $perfil_id != 4 && $perfil_id != 7 && $perfil_id != 15) { ?>
                                <li><a href="<?= base_url() ?>ambulatorio/modelodeclaracao">Modelo Declara&ccedil;&atilde;o</a></li>
                            <? } ?>
                            <li><a href="<?= base_url() ?>seguranca/operador/relatorioemailoperador">Relatorio Operador</a></li>
                            <?
                            if (@$cirugico_manual == 't' || $perfil_id == 25) {
                                ?>
                                <li><a href="<?= base_url() ?>ambulatorio/guia/listarsigla">Manter Sigla</a></li>
                                <?
                            }
                            ?>
                            <li><a href="<?= base_url() ?>cadastros/pacientes/listarprecadastros"> Pré-cadastro</a></li>
                            <li><a href="<?= base_url() ?>cadastros/pacientes/listarocorrencia"> Campos Ocorrência </a></li>
                            <li><a href="<?= base_url() ?>ambulatorio/exame/listarfilaaparelho"> Listar Aparelhos </a></li>

                        </ul>
                    </li>
<!--                    <li class="dropdown">-->
<!--                        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
<!--                            <i class="fa fa-clone fa-fw"></i> Modelos</a>-->
<!--                        <ul class="dropdown-menu">-->
<!--                            <li>-->
<!--                                <a class="dropdown-item drop-head" href="--><?//= base_url() ?><!--ambulatorio/modelolaudo/pesquisar">Manter Modelo Laudo</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a class="dropdown-item drop-head" href="--><?//= base_url() ?><!--ambulatorio/modelolinha/pesquisar">Manter Modelo Linha</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a class="dropdown-item drop-head" href="--><?//= base_url() ?><!--ambulatorio/modeloreceita/pesquisar">Manter Modelo Receita</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a class="dropdown-item drop-head" href="--><?//= base_url() ?><!--ambulatorio/modeloatestado/pesquisar">Manter Modelo Atestado</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a class="dropdown-item drop-head" href="--><?//= base_url() ?><!--ambulatorio/modeloreceitaespecial/pesquisar">Manter Modelo R. Especial</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a class="dropdown-item drop-head" href="--><?//= base_url() ?><!--ambulatorio/modelodeclaracao/pesquisar">Modelo Declara&ccedil;&atilde;o</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a class="dropdown-item drop-head" href="--><?//= base_url() ?><!--ambulatorio/modelosolicitarexames/pesquisar">Manter Modelo S.Exames</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a class="dropdown-item drop-head" href="--><?//= base_url() ?><!--ambulatorio/modelomedicamento/pesquisar">Manter Medicamento</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a class="dropdown-item drop-head" href="--><?//= base_url() ?><!--ambulatorio/modelomedicamento/pesquisarunidade">Manter Medicamento Unidade</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a href="--><?//= base_url() ?><!--ambulatorio/modelolinha">Manter Modelo Linha</a>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                    </li>-->
                    <?php if($perfil_id != 23 && $perfil_id != 25){?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-medkit fa-fw"></i> Procedimentos <span class="fa arrow"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <? if ($perfil_id == 1 || $perfil_id == 3 || $perfil_id == 10) { ?>
                                    <li><a href="<?= base_url() ?>ambulatorio/procedimento">Manter Procedimentos</a></li>
                                    <? if ($perfil_id != 10) { ?>
                                        <li><a href="<?= base_url() ?>ambulatorio/procedimento/relatorioprocedimento">Relatório Procedimentos</a></li>
                                        <li><a href="<?= base_url() ?>ambulatorio/procedimento/pesquisartuss">Manter Procedimentos TUSS</a></span></li>
                                        <li><a href="<?= base_url() ?>ambulatorio/classificacao">Manter Classificação</a></span></li>
                                        <li><a href="<?= base_url() ?>ambulatorio/procedimento/gerarelatorioprocedimentotuss">Relatorio Procedimentos TUSS</a></span></li>
                                        <li><a href="<?= base_url() ?>cadastros/grupoconvenio">Manter grupo Convênio</a></span></li>
                                        <li><a href="<?= base_url() ?>cadastros/convenio">Manter Convênio</a></span></li>
                                        <li><a href="<?= base_url() ?>cadastros/laboratorio">Manter Laboratório Terceirizado</a></span></li>
                                    <? } if ($procedimento_multiempresa != 't') { ?>
                                        <li><a href="<?= base_url() ?>ambulatorio/procedimentoplano">Manter Procedimentos Convenio</a></li>
                                        <li><a href="<?= base_url() ?>ambulatorio/procedimentoplano/pesquisarvalorbaseconvenio">Manter Valor Base Convenio</a></li>
                                    <? } else { ?>
                                        <li><a href="<?= base_url() ?>ambulatorio/procedimentoplano/pesquisar2">Manter Procedimentos Convenio</a></li>
                                        <?
                                    }
                                    if ($perfil_id != 10) { ?>
                                            <li><a href="<?= base_url() ?>ambulatorio/procedimento/relatorioprocedimentoconvenio">Relatorio Procedimentos Convenio</a></li>
                                            <li><a href="<?= base_url() ?>ambulatorio/procedimentoplano/medicopercentual">Manter Percentual M&eacute;dico</a></li>
                                            <li><a href="<?= base_url() ?>ambulatorio/procedimentoplano/promotorpercentual">Manter Percentual Promotor</a></li>
                                            <li><a href="<?= base_url() ?>ambulatorio/procedimentoplano/laboratoriopercentual">Manter Percentual Terceirizado</a></li>
                                            <li><a href="<?= base_url() ?>ambulatorio/procedimentoplano/tecnicopercentual">Manter Percentual Técnico</a></li>
                                            <? if ($subgrupo_procedimento != 't') { ?>
                                                <li><a href="<?= base_url() ?>cadastros/grupoclassificacao">Manter Grupo Classificação</a></li>
                                            <? } else { ?>
                                                <li><a href="<?= base_url() ?>cadastros/grupoclassificacao/pesquisarsubgrupo">Manter Subgrupo</a></li>
                                                <!-- <ul><span class="file"><a href="<?= base_url() ?>cadastros/grupoclassificacao/pesquisarassociacaosubgrupo">Manter Associação Subgrupo</a></span></ul> -->
                                                <?
                                            }
                                    } ?>


                                <? } ?>
                            </ul>
                        </li>
                    <? } ?>

                    <? if ($medicinadotrabalho == 't' && $perfil_id != 23 && $perfil_id != 25) { ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-medkit fa-fw"></i> M. Trabalho <span class="fa arrow"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <? if ($perfil_id == 1 || $perfil_id == 3 || $perfil_id == 10) { ?>
                                    <li><a href="<?= base_url() ?>ambulatorio/saudeocupacional/pesquisarsituacao">Manter Situação</a></li>
                                    <li><a href="<?= base_url() ?>ambulatorio/saudeocupacional/pesquisarsetor">Manter Setor</a></li>
                                    <li><a href="<?= base_url() ?>ambulatorio/saudeocupacional/pesquisarfuncao">Manter Função</a></li>
                                    <li><a href="<?= base_url() ?>ambulatorio/saudeocupacional/pesquisarrisco">Manter Riscos OE.</a></li>
                                <? } ?>
                            </ul>
                        </li>
                    <? } ?>

                    <? if (($imagem == 't' || $geral == 't') && $perfil_id != 23 && $perfil_id != 25) { ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-image fa-fw"></i> Imagem    <span class="fa arrow"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <? if ($perfil_id == 1 || $perfil_id == 3 || /* $perfil_id == 4 || */ $perfil_id == 5 || ($perfil_id == 18 || $perfil_id == 20) || $perfil_id == 6 || $perfil_id == 10) { ?>
                                    <li><a href="<?= base_url() ?>ambulatorio/modelolaudo">Manter Modelo Laudo</a></li>
                                    <li><a href="<?= base_url() ?>ambulatorio/modelolinha">Manter Modelo Linha</a></li>
                                <? } ?>
                            </ul>
                        </li>
                    <? } ?>

                    <? if (($centrocirurgico == 't' && ($perfil_id != 11 && $perfil_id != 2 && $perfil_id != 7 && $perfil_id != 15) ) || $perfil_id == 23) { ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-nurse fa-fw"></i> Centro Cirurgico <span class="fa arrow"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <? if ($perfil_id == 1 || $perfil_id == 3 || /* $perfil_id == 4 || */ $perfil_id == 5 || ($perfil_id == 18 || $perfil_id == 20) || $perfil_id == 6 || $perfil_id == 10 || $perfil_id == 23 || $perfil_id == 25) { ?>
                                    <li><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/pesquisarhospitais">Manter Hospital</a></li>
                                    <li><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/pesquisarfornecedormaterial">Manter Fornecedor</a></li>
                                    <li><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/pesquisargrauparticipacao">Grau de Participação</a></li>
                                    <li><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/configurarpercentuais">Configurar Percentuais</a></li>
                                    <li><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/manterespecialidadeparecer">Manter Especialidade Parecer</a></li>
                                    <?
                                    if (@$cirugico_manual == 't' || $perfil_id == 25) {
                                        ?>
                                        <li><a href="<?= base_url() ?>ambulatorio/guia/listarinidicacaoacidente">Manter Indicação de Acidente</a></li>

                                        <li><a href="<?= base_url() ?>ambulatorio/guia/listartiposcirurgia">Manter Tipos de Cirurgia</a></li>
                                        <li><a href="<?= base_url() ?>ambulatorio/guia/listarcarater">Manter Caráter</a></li>
                                        <li><a href="<?= base_url() ?>ambulatorio/guia/listarrn">Manter RN</a></li>
                                    <?}?>
                                <? } ?>
                            </ul>
                        </li>
                    <? } ?>
                    <? if ($internacao == 't' || $perfil_id == 23 || $perfil_id == 23 || $perfil_id == 25) { ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-clinic-medical fa-fw"></i> Internação <span class="fa arrow"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a href="<?= base_url() ?>internacao/internacao/pesquisarunidade">Listar Unidades</a></li>
                                <li><a href="<?= base_url() ?>internacao/internacao/pesquisarenfermaria">Lista Enfermarias</a></li>
                                <li><a href="<?= base_url() ?>internacao/internacao/pesquisarleito">Listar Leitos</a></li>
                                <li><a href="<?= base_url() ?>internacao/internacao/pesquisarmotivosaida">Manter Motivo Saida</a></li>
                                <li><a href="<?= base_url() ?>internacao/internacao/mantermodelogrupo">Manter Modelo Grupo</a></li>
                                <li><a href="<?= base_url() ?>internacao/internacao/mantertipodependencia">Manter Tipo Depedência</a></li>
                                <li><a href="<?= base_url() ?>internacao/internacao/materalertainternacao">Manter Alertas</a></li>
                                <li><a href="<?= base_url() ?>ambulatorio/empresa/listarinternacaoconfig">Manter Impressões</a></li>
                            </ul>
                        </li>
                    <? } ?>
                    <? if (($consulta == 't' || $geral == 't') && $perfil_id != 23 && $perfil_id != 25 ) { ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-stethoscope fa-fw"></i> Consulta <span class="fa arrow"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <? if ($perfil_id == 1 || $perfil_id == 3 || $perfil_id == 5 || ($perfil_id == 18 || $perfil_id == 20) || $perfil_id == 6 || $perfil_id == 10) { ?>
                                    <li><a href="<?= base_url() ?>ambulatorio/modeloreceita">Manter Modelo Receita</a></li>
                                    <li><a href="<?= base_url() ?>ambulatorio/modeloatestado">Manter Modelo Atestado</a></li>
                                    <li><a href="<?= base_url() ?>ambulatorio/modeloreceitaespecial">Manter Modelo R. Especial</a></li>
                                    <li><a href="<?= base_url() ?>ambulatorio/modelosolicitarexames">Manter Modelo S.Exames</a></li>
                                    <? if ($integracaosollis != 't') { ?>
                                        <li><a href="<?= base_url() ?>ambulatorio/modelomedicamento">Manter Medicamento</a></li>
                                        <li><a href="<?= base_url() ?>ambulatorio/modelomedicamento/pesquisarunidade">Manter Medicamento Unidade</a></li>
                                    <? } ?>
                                    <li><a href="<?= base_url() ?>ambulatorio/modelooftamologia">Manter Campos Oftamologia</a></li>
                                    <li><a href="<?= base_url() ?>ambulatorio/empresa/listartemplatesconsulta">Manter Templates</a></li>
                                <? } ?>
                            </ul>
                        </li>
                    <? } ?>
                    <? if ($estoque == 't' && $perfil_id != 23 && $perfil_id != 25 ) { ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-box fa-fw"></i> Estoque <span class="fa arrow"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <? if ($perfil_id == 1 || $perfil_id == 8) { ?>
                                    <li><a href="<?= base_url() ?>estoque/menu">Manter Menu</a></li>
                                    <li><a href="<?= base_url() ?>estoque/tipo">Manter Tipo</a></li>
                                    <li><a href="<?= base_url() ?>estoque/classe">Manter Classe</a></li>
                                    <li><a href="<?= base_url() ?>estoque/subclasse">Manter Sub-Classe</a></li>
                                    <li><a href="<?= base_url() ?>estoque/unidade">Manter Medida</a></li>
                                    <li><a href="<?= base_url() ?>estoque/armazem">Manter Armazem</a></li>
                                    <li><a href="<?= base_url() ?>estoque/cliente">Manter Setor</a></li>
                                    <li><a href="<?= base_url() ?>seguranca/operador/operadorsetor">Listar Operadores</a></li>
                                <? } ?>
                            </ul>
                        </li>
                    <? } ?>
                    <? if ($financeiro == 't' && $perfil_id != 23 && $perfil_id != 25 ) { ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-money fa-fw"></i> Financeiro <span class="fa arrow"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <? if ($perfil_id == 1 || $perfil_id == 13 || $perfil_id == 10) { ?>
                                    <? if ($financ_4n == 't') { ?>
                                        <li><a href="<?= base_url() ?>cadastros/nivel1">Manter Nível 1</a></li>
                                        <li><a href="<?= base_url() ?>cadastros/nivel2">Manter Nível 2</a></li>
                                    <? } ?>
                                        <li><a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/tipo">Manter Tipo</a></li>
                                        <li><a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/classe">Manter Classe</a></li>
                                        <li><a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/grupoconta">Grupo Conta</a></li>
                                        <li><a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/forma">Manter Conta</a> </li>
                                    <? if ($perfil_id != 10) { ?>
                                        <li><a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/formapagamento">Manter Forma de Pagamento</a></li>
                                    <? } ?>

                                <? } ?>
                            </ul>
                        </li>
                    <? } ?>
                    <? if ($perfil_id == 1 ) { ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-desktop fa-fw"></i> Impressão <span class="fa arrow"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <? if ($perfil_id == 1 || $perfil_id == 13 || $perfil_id == 10) { ?>
                                    <li><a href="<?= base_url() ?>ambulatorio/empresa/listarcabecalho">Config.Cabeçalho</a></li>
                                    <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/listarcabecalho">Config.Recibo</a></span></ul>-->
                                    <!--                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/subclasse">Manter Sub-Classe</a></span></ul>-->
                                    <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/listarcabecalho">Config.Ficha</a></span></ul>-->
                                    <li><a href="<?= base_url() ?>ambulatorio/empresa/listarlaudoconfig">Config.Laudo</a></li>
                                    <li><a href="<?= base_url() ?>ambulatorio/empresa/listarorcamentoconfig">Config.Orçamento</a></li>
                                    <li><a href="<?= base_url() ?>ambulatorio/empresa/listarreciboconfig">Config.Recibo</a></li>
                                <? } ?>
                            </ul>
                        </li>
                    <? } ?>
                    <? if ($perfil_id == 1) { ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-print fa-fw"></i> Impressão receituário <span class="fa arrow"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <? if ($perfil_id == 1 || $perfil_id == 13 || $perfil_id == 10) { ?>
                                    <li><a href="<?= base_url() ?>ambulatorio/empresa/listarcabecalhoreceituario">Config.Cabeçalho</a></li>
                                    <li><a href="<?= base_url() ?>ambulatorio/empresa/listarlaudoconfigreceituario">Config.Laudo</a></li>
                                    <li><a href="<?= base_url() ?>ambulatorio/empresa/listarorcamentoconfigreceituario">Config.Orçamento</a></li>
                                    <li><a href="<?= base_url() ?>ambulatorio/empresa/listarreciboconfigreceituario">Config.Recibo</a></li>
                                <? } ?>
                            </ul>
                        </li>
                    <? } ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-mobile fa-fw"></i> Aplicativo <span class="fa arrow"></span></a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/empresa/listarpostsblog">Posts Blog</a>
                            </li>
                            <li>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/empresa/listarpesquisaSatisfacao">Pesquisa Satisfação</a>
                            </li>
                        </ul>
                    </li>
                    <?if($dashboard_administrativo == 't' && $perfil_id == 1){?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-suitcase"></i> Administrativo <span class="fa arrow"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a href="<?= base_url() ?>ambulatorio/exame/dashboardrecepcao">Dashboard Recepção</a></li>
                                <li><a href="<?= base_url() ?>home/">Dashboard Financeiro</a></li>
                                <li><a href="<?= base_url() ?>home/">Dashboard Faturamento</a></li>
                                <li><a href="<?= base_url() ?>home/">Dashboard Marketing</a></li>
                            </ul>
                        </li>
                    <? } ?>
                    <?php if($perfil_id != 23 && $perfil_id != 25 ){?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-gear fa-fw"></i> Administrativas <span class="fa arrow"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <? if ($perfil_id == 1) { ?>
                                    <li><a href="<?= base_url() ?>ambulatorio/agenda/pesquisarferiados">Manter Feriados</a></li>
                                    <? if ($perfil_id == 1) { ?>
                                        <li><a href="<?= base_url() ?>ambulatorio/empresa/pesquisarlembrete">Manter Lembretes</a></li>
                                    <? } ?>
                                    <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/pesquisartotensetor">Manter Setor Toten</a></span></ul>-->
                                    <?if($operador_id == 1){?>
                                        <li><a href="<?= base_url() ?>ambulatorio/grupos">Manter Grupos</a></li>
                                    <?}?>
                                    <li><a href="<?= base_url() ?>ambulatorio/empresa">Manter Empresa</a></li>
                                    <li><a href="<?= base_url() ?>ambulatorio/versao">Vers&atilde;o</a></li>
                                    <li>
                                        <a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/empresa/gerecianet">Manter Gerencia Net</a>
                                    </li>
                                <? } ?>
                            </ul>
                        </li>
                    <? } ?>
                </ul>
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
</nav>
</body>
<script>

    // $('.dropdown-menu a.removefromcart').click(function(e) {
    //     e.stopPropagation();
    // });

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

</script>
<!--    Aqui abaixo você encontra a função que chama a mensagem bonitinha, pessoa que estiver olhando.-->
<!--
PRA ALTERAR A MENSAGEM PADRÃO QUE APARECE E O ICONE A QUE É ATRIBUIDO, É SÓ ENTRAR NO UTILITARIO E PROCURAR A FUNÇÃO QUE ELE CHAMA
DAI TEM LÁ UM ARRAY ONDE EU PASSO DUAS COISAS, UMA É A MENSAGEM QUE VAI APARECER E A OUTRA É SE É 'WARNING' 'ERROR' OU 'SUCCESS'-->
<?php
$this->load->library('utilitario');
$mensagem = Utilitario::pmf_mensagem($this->session->flashdata('message'));
?>
