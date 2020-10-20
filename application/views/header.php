<?
//Da erro no home
if ($this->session->userdata('autenticado') != true) {
    redirect(base_url() . "login/index/login004", "refresh");
}
$perfil_id = $this->session->userdata('perfil_id');
$operador_id = $this->session->userdata('operador_id');

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
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="<?= base_url() ?>bootstrap/assets/css/font-awesome.css" rel="stylesheet" />
    <link href="<?= base_url() ?>bootstrap/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="<?= base_url() ?>bootstrap/vendor/bootstrap/css/bootstrap.css" rel="stylesheet"/>
    <link href="<?= base_url() ?>bootstrap/assets/css/argon-design-system.css?v=1.2.0" rel="stylesheet"/>
 
    <link href="<?= base_url() ?>css/header.css" rel="stylesheet"/>
    <link href="<?= base_url() ?>js/jquery-ui.css" rel="stylesheet"/>
    <link href="<?= base_url() ?>js/jquery-ui.structure.css" rel="stylesheet"/>
    <link href="<?= base_url() ?>js/jquery-ui.theme.css" rel="stylesheet"/>
    
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
    <script src="/bootstrap/assets/js/argon-design-system.min.js" ></script>
    <!--Scripts necessários para o calendário-->
    
    <script src="<?= base_url() ?>bootstrap/fullcalendar/main.js"></script>
    <script src="<?= base_url() ?>bootstrap/fullcalendar/main.css"></script>
    <link href="<?= base_url() ?>bootstrap/fullcalendar-scheduler/main.css" rel='stylesheet'/>
    <script src="<?= base_url() ?>bootstrap/fullcalendar-scheduler/main.js"></script>
    <script src="<?= base_url() ?>bootstrap/fullcalendar/locales/pt-br.js"></script>
    <script src="<?= base_url() ?>node_modules/@fullcalendar/daygrid/main.js"></script>
    <link href="<?= base_url() ?>node_modules/@fullcalendar/daygrid/main.css" rel='stylesheet'/>
    <!-- <script src="<?= base_url() ?>node_modules/moment/moment.js"></script> -->
    <script src='https://cdn.jsdelivr.net/npm/moment@2.27.0/min/moment.min.js'></script>
    <!-- <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@5.3.1/main.js'></script> -->
    <script src="<?= base_url() ?>node_modules/pivottable/dist/pivot.pt.min.js"></script>




    
</head>
<body class="index-page">
    <!--NAV BAR -->
    <nav id="navbar-main" class="navbar navbar-expand-lg navbar-light ">
      
          <a class="navbar-brand mr-lg-5" href="<?= base_url() ?>home">
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
              
            <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <i class="fa fa-address-book-o fa-fw"></i>Recepção</a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-primary_dropdown_1">
                      <a class="title"><i class="fa fa-edit fa-fw"></i> Rotinas <span class="fa arrow"></span></a>
                        <ul>
                            <a class="dropdown-item  drop-head" href="<?= base_url() ?>cadastros/pacientes">Cadastro</a>
                            <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaoconsultacalendario">Agendamento</a>
                            <!-- <a class="dropdown-item" href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaoconsulta">Agendamento</a> -->
                        </ul>
                        <a class="title"><i class="fa fa-bar-chart-o fa-fw"></i> Relatorios <span class="fa arrow"></span></a>
                        <ul>
                            <a class="dropdown-item drop-head"  href="<?= base_url() ?>ambulatorio/guia/relatorioaniversariante">Relatorio Aniversariantes</a>
                        </ul>
                    </div>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbar-primary_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user-md fa-fw"></i>Atendimento </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-primary_dropdown_1">
                        <a class="title"><i class="fa fa-edit fa-fw"></i> Rotinas <span class="fa arrow"></span></a>
                            <ul>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicoconsulta">Atendimento Médico</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/exame/relatorioteste">Relatório Teste</a>
                            </ul>
                    </div>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbar-primary_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-university fa-fw"></i> Financeiro </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-primary_dropdown_1">
                        <a class="title"><i class="fa fa-edit fa-fw"></i> Rotinas <span class="fa arrow"></span></a>
                            <ul>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/caixa">Entradas</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/caixa/pesquisar2">Saidas</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/contaspagar">Contas a Pagar</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/contasreceber">Contas a Receber</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>cadastros/fornecedor">Credor/Devedor</a>
                            </ul>
                        <a class="title"><i class="fa fa-bar-chart-o fa-fw"></i> Relatorios <span class="fa arrow"></span></a>
                            <ul>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/guia/relatoriocaixa">Relatorio Caixa</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconveniofinanceiro">Relatorio Produ&ccedil;&atilde;o M&eacute;dica</a>
                                <a class="dropdown-item drop-head" href="<?= base_url() ?>ambulatorio/guia/relatorioindicacaoexames">Relatorio Recomendação</a>
                            </ul>
                    </div>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbar-primary_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cubes"></i>Estoque </a>
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
        
    </nav>
</body>

<script>
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





