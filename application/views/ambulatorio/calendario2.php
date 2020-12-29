
<head>
    <title>STG - SISTEMA DE GESTAO DE CLINICAS v2.0</title>
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link href="<?= base_url() ?>bootstrap/vendor/bootstrap/css/bootstrap.css" rel="stylesheet"/>
    <link href="<?= base_url() ?>bootstrap/assets/css/argon-design-system.css?v=1" rel="stylesheet"/>
    <script  src="<?= base_url() ?>bootstrap/vendor/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    <link href="<?= base_url() ?>bootstrap/fullcalendar/main.css" rel='stylesheet'/>
    <script src="<?= base_url() ?>bootstrap/fullcalendar/main.js"></script>
    <script src="<?= base_url() ?>bootstrap/fullcalendar/locales/pt-br.js"></script>

    <script src="<?= base_url() ?>bootstrap/fullcalendar/timegrid/main.js"></script>
    <link src="<?= base_url() ?>bootstrap/fullcalendar/timegrid/main.min.css"/>

    <script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
    <!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
    <link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
    <script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
    <link href="<?= base_url() ?>js/fullcalendar/lib/cupertino/jquery-ui.min.css" rel="stylesheet" />
    <script type="text/javascript" src="<?= base_url() ?>js/fullcalendar/lib/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/fullcalendar/lib/jquery-ui.min.js"></script>
</head>
<!--<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pt-BR" >-->
<?

if (@$_GET['data'] != '' && date("Y-m-d", strtotime(str_replace('/', '-', @$_GET['data']))) == '1969-12-31') {
    $_GET['data'] = date("Y-m-d");
}

if($this->session->userdata('medico_agenda')){
    $medico_agenda_sessao = $this->session->userdata('medico_agenda');
}else{
    $medico_agenda_sessao = 'f';
}


if(isset($_GET['medico']) && (@$_GET['medico'] != '' || @$_GET['medico'] != NULL)){
    $id_medico_por_get = $_GET['medico'];
}else{
    $id_medico_por_get = "$('#medico').val()";
}
$operador_id = $this->session->userdata('operador_id');
$perfil_id = $this->session->userdata('perfil_id');
?>



<div class="content">



    <style>
        #sidebar-wrapper{
            z-index: 100;
            position: fixed;
            margin-top: 50px;
            margin-left: 37%;
            list-style-type: none; /* retira o marcador de listas*/
            overflow-y: scroll;
            overflow-x: auto;
            /*height: 900px;*/
            /*width: 500px;*/
            max-height: 900px;

        }

        #sidebar-wrapper ul {
            padding:0px;
            margin:0px;
            background-color: #ebf7f9;
            list-style:none;
            margin-bottom: 30px;

        }
        #sidebar-wrapper ul li a {
            color: #ff004a;
            border: 20px;
            text-decoration: none;
            /*padding: 3px;*/
            /*border: 2px solid #00BDFF;*/
            margin-bottom: 20px;
        }

        #botaosalaesconder {
            border: 1px solid #8399f6
        }
        #botaosala {
            border: 1px solid #8399f6;
            width: 80pt;
        }
        .vermelho{
            color: red;
        }

        tr.corcinza td{
            color:gray;
        }

        .tabela_content03 {
            /* background-color: #E0EEEE; */
            background-color: #d3c2c2;
            color: #000000;
            padding-left: 3px;
            height: 30px;
            vertical-align: middle;
        }


        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 10000; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            position: relative;
            position: relative;
            background-color: #fefefe;
            margin: auto;
            padding: 0;
            border: 1px solid #888;
            width: 50%;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
            -webkit-animation-name: animatetop;
            -webkit-animation-duration: 0.4s;
            animation-name: animatetop;
            animation-duration: 0.4s
        }

        /* Add Animation */
        @-webkit-keyframes animatetop {
            from {top:-300px; opacity:0}
            to {top:0; opacity:1}
        }

        @keyframes animatetop {
            from {top:-300px; opacity:0}
            to {top:0; opacity:1}
        }

        /* The Close Button */
        .close {
            color: white;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-header {
            padding: 2px 16px;
            background-color: #5cb85c;
            /* background-color: #0066b8; */
            color: white;
        }

        .modal-body {padding: 2px 16px;}

        .modal-footer {
            padding: 2px 16px;
            background-color: #5cb85c;
            /* background-color: #0066b8; */
            color: white;
        }

        h2{
            display: block;
            font-size: 20px;
            margin-top: 0.67em;
            margin-bottom: 0.67em;
            margin-left: 0;
            margin-right: 0;
            font-weight: bold;
        }

        .tablemodal{
            /* display: block; */
            font-size: 17px;
            margin-top: 0.67em;
            margin-bottom: 0.67em;
            margin-left: 0;
            margin-right: 0;
            font-weight: bold;
        }

        .titulo_table{
            font-size: 15px;
            font-weight: bold;
        }

    </style>
    <div id="sala-de-espera" style="display: none;">

        <div id="sidebar-wrapper" class="sidebarteste">
            <div style="margin-left: 35%;">
                <button id="botaosalaesconder">Esconder</button>
            </div>
            <div>
                <ul class="sidebar-nav">

                    <li class="tabela_content01">
                        <span> Agenda</span> - <span style="color:#ff004a">Paciente - <span style="color: #5659C9">Procedimento</span> - <span style="color: black"> Tempo de Espera</span>

                    </li>
                    <?
                    $empresa_id = $this->session->userdata('empresa_id');
                    $empresapermissoes = $this->guia->listarempresapermissoes($empresa_id);
                    $integrar_google = $empresapermissoes[0]->integrar_google;
                    if ($empresapermissoes[0]->filtrar_agenda == 't') {
                        $listaespera = $this->exame->listarexameagendaconfirmada2geral($_GET)->get()->result();
                    } else {
                        $listaespera = $this->exame->listarexameagendaconfirmada2geral()->get()->result();
                    }
                    if (count($listaespera) > 0) {
                        $estilo_linha = null;
                        @$estilo_linha == "tabela_content01";
                        foreach ($listaespera as $item) {
                            $dataFuturo = date("Y-m-d H:i:s");
                            $dataAtual = $item->data_autorizacao;
                            $date_time = new DateTime($dataAtual);
                            $diff = $date_time->diff(new DateTime($dataFuturo));
                            $teste = $diff->format('%H:%I:%S');

                            (@$estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <li class="<?= $estilo_linha ?>">
                                <a href="<?= base_url() ?>ambulatorio/exame/examesala/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->guia_id ?>/<?= $item->agenda_exames_id; ?>" target="_blank">
                                    <span style="color: black"><?= $item->inicio; ?></span> - <span> <?= $item->paciente ?></span> - <span style="color: #5659C9"><?= $item->procedimento ?></span> - <span style="color: black"><?= $teste ?></span> -
                                </a>
                            </li>


                            <?
                        }
                    }
                    ?>


                </ul>
            </div>
        </div>
    </div>
    <style>

        body {
            /*margin: 40px 10px;*/
            padding: 0;
            font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
            background-color: white;
        }
        .content{
            margin-left: 0px;
        }

        .bt_link_new_pequeno{
            background: url(<?=base_url()?>css/images/bg_buttons.png);
            width: 28px;
            height: 28px;
            border: 1px solid;
            border-top-color: #eee;
            border-right-color: #ccc;
            border-bottom-color: #ccc;
            border-left-color: #eee;
            -moz-border-radius:4px;
            margin-bottom: 4px;
        }

        .bt_link_new_pequeno a {
            display:block;
            width:150px;
            height:5px;
            padding:5px 5px 5px 5px;
            color: #900;
            font-weight: bold;
            text-decoration: none;
        }

        .bt_link_new_pequeno a:hover {
            color: #f00;
        }

        .singular table div.bt_link_new .btnTexto {color: #2779aa; }
        .singular table div.bt_link_new .btnTexto:hover{ color: red; font-weight: bolder;}

        .singular table div.bt_link_new_pequeno .btnTexto2 {color: red; }
        .singular table div.bt_link_new_pequeno .btnTexto2:hover{ color: #2779aa; font-weight: bolder;}

        .singular table div.bt_link_new .btnTexto2 {color: red; }
        .singular table div.bt_link_new .btnTexto2:hover{ color: #2779aa; font-weight: bolder;}

        .vermelho{
            color: red;
        }
        /*#pop{display:none;position:absolute;top:50%;left:50%;margin-left:-150px;margin-top:-100px;padding:10px;width:300px;height:200px;border:1px solid #d0d0d0}*/

    </style>

    <?
    if($integrar_google == 't'){
        $logado_no_google = $this->auth->logingoogle();

        if($logado_no_google == 0){
            $loginUrl = $this->googlecalendar->loginUrl();
        }


        if($logado_no_google == 1){

            // $code = $this->input->get('code', true);
            // $this->googlecalendar->login($code);
            $use = $this->googlecalendar->getUserInfo();
            $events = $this->googlecalendar->getEvents();
            $todayEventsCount = count($events);
        }

    }
    ?>

    <div id="accordion">
        <h3 class="singular">
            <table>
                <tr>
                    <th>
                        Multifuncao Geral Recep&ccedil;&atilde;o
                    </th>
                    <th>
                        <? if (($perfil_id == 1 || $operador_id == 1) || $empresapermissoes[0]->btn_encaixe == 'f') { ?>
                            <div class="bt_link_new">
                                <a id='btnEnaixe' class="btnTexto" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/novopacienteencaixegeral');">
                                    Encaixar Paciente
                                </a>
                            </div>
                        <? } ?>
                    </th>
                    <? if($integrar_google == 't'){ ?>
                        <th>
                            <div class="bt_link_new">
                                <?if($logado_no_google == 0){?>
                                    <a onclick="javascript:window.location.href = '<?=$loginUrl?>' " class="btnTexto">
                                        Sicronizar com Google
                                    </a>
                                <?}else{?>
                                    <a class="btnTexto2" href=''>
                                        Sicronizado Google
                                    </a>
                                <?}?>
                            </div>
                        </th>

                        <?if($logado_no_google != 0){?>
                            <!-- <th>
                            <div class="bt_link_new_pequeno">
                                <a id='btnEnaixe' title="Importar Agenda do Dia Anterior" class="btnTexto2" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/importaragendagoogles');">
                                   @
                                </a>
                            </div>
                        </th> -->
                        <?}?>


                    <? } ?>
                    <!--                    <th>
                        <div class="bt_link_new">
                            <a class="btnTexto" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/novohorarioencaixegeral');">
                                Encaixar Horario
                            </a>
                        </div>
                    </th>-->
                </tr>


            </table>
        </h3>
        <div>
            <?
            $medicos = $this->operador_m->listarmedicos();
            $salas = $this->exame->listartodassalasgrupos();
            $especialidade = $this->exame->listarespecialidade();
            $grupos = $this->procedimento->listargrupos();
            $convenio = $this->convenio->listardados();
            $procedimento = $this->procedimento->listarprocedimentos();
            $empresas = $this->exame->listarempresas();
            $empresa_logada = $this->session->userdata('empresa_id');
            $tipo_consulta = $this->tipoconsulta->listarcalendario();
            $minicurriculos = $this->exame->listarmedicocurriculo();
            //          echo'<pre>';
            //          var_dump($minicurriculos);

            if (@$_GET['medico'] != '') {
                $medico_atual = $_GET['medico'];
            } else {
                $medico_atual = 0;
            }
            if (isset($_GET['empresa'])) {
                if (@$_GET['empresa'] != '') {
                    $empresa_atual = $_GET['empresa'];
                } else {
                    $empresa_atual = '';
                }
            } else {
                $empresa_atual = $empresa_id;
            }
            // var_dump(isset($empresa_atual)); die;

            if (@$_GET['sala'] != '') {
                $sala_atual = $_GET['sala'];
            } else {
                $sala_atual = 0;
            }
            if (@$_GET['tipoagenda'] != '') {
                $tipoagenda = $_GET['tipoagenda'];
            } else {
                $tipoagenda = 0;
            }
            ?>
            <table>

                <form method="get" action="<?= base_url() ?>ambulatorio/exame/listarmultifuncaocalendario2">

                    <tr>
                        <th>
                            <div class="panel panel-default">
                                <div class="panel-heading ">
                                    <!--                                Calendário-->
                                </div>
                                <div class="row" style="width: 100%; ">
                                    <div class="col-lg-12">



                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <div id='calendar'></div>
                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                    <!-- /.panel -->
                                </div>
                            </div>
                        </th>
                        <th onclick="filtrolivre()" style="width: 150px;">

                        </th>
                        <th>
                            <div style="border: 1pt dotted #444; border-radius: 10pt;">

                                <table border="1" style="border">
                                    <tr>
                                        <th class="tabela_title">Grupo</th>
                                        <th class="tabela_title">Empresa</th>

                                    </tr>
                                    <tr>
                                        <th class="tabela_title">
                                            <select name="grupo" id="grupo" class="size2" >
                                                <option value='' >TODOS</option>
                                                <? foreach ($grupos as $grupo) { ?>
                                                    <option value='<?= $grupo->nome ?>' <?
                                                    if (@$_GET['grupo'] == $grupo->nome):echo 'selected';
                                                    endif;
                                                    ?>><?= $grupo->nome ?></option>
                                                <? } ?>
                                            </select>

                                        </th>
                                        <th class="tabela_title">
                                            <select name="empresa" id="empresa" class="size2">
                                                <option value="">TODOS</option>
                                                <?
                                                $selected = false;
                                                foreach ($empresas as $value) :
                                                    ?>
                                                    <option value="<?= $value->empresa_id; ?>" <?
                                                    if ($empresa_atual == $value->empresa_id) {
                                                        echo 'selected';
                                                        $selected = true;
                                                    } else {
                                                        if ($empresa_logada == $value->empresa_id && $selected == false) {
                                                            // echo 'selected';
                                                            // $selected = true;
                                                        }
                                                    }
                                                    ?>><?php echo $value->nome; ?></option>
                                                <? endforeach; ?>
                                            </select>

                                        </th>

                                    </tr>
                                </table>

                                <table border="1">
                                    <tr>
                                        <?php if($empresapermissoes[0]->filtrar_agenda_2 == "t"){?>
                                            <th class="tabela_title">Tipo Especialidade</th>
                                        <?php }else{?>
                                            <th class="tabela_title">Sala</th>
                                        <?php }?>
                                        <th class="tabela_title">Procedimento</th>

                                    </tr>
                                    <tr>
                                        <?php if($empresapermissoes[0]->filtrar_agenda_2 == "t"){?>
                                            <th class="tabela_title">
                                                <input type="hidden" id="medicoget" value="<?= ($this->session->userdata('perfil_id') == 4) ? $this->session->userdata('operador_id') : @$_GET['medico']  ?>">
                                                <select name="tipoagenda" id="tipoagenda" class="size2">
                                                    <!--<option value=""></option>-->
                                                    <option value="">TODOS</option>
                                                    <? foreach ($tipo_consulta as $value) : ?>
                                                        <option value="<?= $value->ambulatorio_tipo_consulta_id; ?>" <?
                                                        if (@$_GET['tipoagenda'] == $value->ambulatorio_tipo_consulta_id):echo 'selected';
                                                        endif;
                                                        ?>>  <?php echo $value->descricao; ?>
                                                        </option>
                                                    <? endforeach; ?>
                                                </select>
                                            </th>

                                        <?php }else{?>
                                            <th class="tabela_title">
                                                <select name="sala" id="sala" class="size2">
                                                    <option value="">TODOS</option>
                                                    <? foreach ($salas as $value) : ?>
                                                        <option value="<?= $value->exame_sala_id; ?>" <?
                                                        if (@$_GET['sala'] == $value->exame_sala_id):echo 'selected';
                                                        endif;
                                                        ?>><?php echo $value->nome; ?></option>
                                                    <? endforeach; ?>
                                                </select>

                                            </th>
                                        <?php }?>

                                        <th class="tabela_title">
                                            <select name="procedimento" id="procedimento" class="size2" >
                                                <option value=''>TODOS</option>
                                                <?php
                                                foreach ($procedimento as $item) {
                                                    ?>
                                                    <option value ="<?php echo $item->procedimento_tuss_id; ?>" <?
                                                    if (@$_GET['procedimento'] == $item->procedimento_tuss_id):echo 'selected';
                                                    endif;
                                                    ?>>
                                                        <?php echo $item->nome; ?>
                                                    </option>

                                                <? } ?>

                                            </select>

                                        </th>
                                        <? if ($empresapermissoes[0]->filtrar_agenda == 't') { ?>

                                        <? } ?>
                                    </tr>
                                </table>
                                <? if ($empresapermissoes[0]->filtrar_agenda == 't') { ?>
                                    <table border="1">
                                        <tr>
                                            <th class="tabela_title">Situação</th>
                                            <th class="tabela_title">Status</th>

                                        </tr>
                                        <tr>
                                            <th class="tabela_title">
                                                <select name="situacao" id="situacao" class="size2">
                                                    <option value=""></option>

                                                    <option value="BLOQUEADO" <?
                                                    if (@$_GET['situacao'] == "BLOQUEADO") {
                                                        echo 'selected';
                                                    }
                                                    ?>>BLOQUEADO</option>

                                                    <option value="FALTOU" <?
                                                    if (@$_GET['situacao'] == "FALTOU") {
                                                        echo 'selected';
                                                    }
                                                    ?>>FALTOU</option>
                                                    <option value="OK" <?
                                                    if (@$_GET['situacao'] == "OK") {
                                                        echo 'selected';
                                                    }
                                                    ?>>OCUPADO</option>
                                                    <option value="LIVRE" <?
                                                    if (@$_GET['situacao'] == "LIVRE") {
                                                        echo 'selected';
                                                    }
                                                    ?>>VAGO</option>
                                                </select>

                                            </th>
                                            <th class="tabela_title">
                                                <select name="status" id="status" class="size2">
                                                    <option value=""></option>
                                                    <option value="AGENDADO" <?
                                                    if (@$_GET['status'] == "AGENDADO") {
                                                        echo 'selected';
                                                    }
                                                    ?>>AGENDADO</option>
                                                    <option value="AGUARDANDO" <?
                                                    if (@$_GET['status'] == "AGUARDANDO") {
                                                        echo 'selected';
                                                    }
                                                    ?>>AGUARDANDO</option>
                                                    <option value="ATENDIDO" <?
                                                    if (@$_GET['status'] == "ATENDIDO") {
                                                        echo 'selected';
                                                    }
                                                    ?>>ATENDIDO</option>

                                                    <option value="ESPERA" <?
                                                    if (@$_GET['status'] == "ESPERA") {
                                                        echo 'selected';
                                                    }
                                                    ?>>ESPERA</option>

                                                </select>

                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="tabela_title">Convênio</th>
                                        </tr>
                                        <tr>
                                            <th class="tabela_title">
                                                <select name="convenio" id="convenio" class="size2">
                                                    <option value="">TODOS</option>
                                                    <? foreach ($convenio as $value) : ?>
                                                        <option value="<?= $value->convenio_id; ?>" <?
                                                        if (@$_GET['convenio'] == $value->convenio_id):echo 'selected';
                                                        endif;
                                                        ?>><?php echo $value->nome; ?></option>
                                                    <? endforeach; ?>
                                                </select>

                                            </th>
                                        </tr>
                                    </table>
                                <? } ?>
                            </div>

                            <div style="border: 1pt dotted #444; border-radius: 10pt;">
                                <table border="1">
                                    <tr>
                                        <?php if($empresapermissoes[0]->filtrar_agenda_2 != "t"){?>
                                            <th class="tabela_title">Tipo Agenda</th>
                                        <?php } ?>
                                        <th class="tabela_title" colspan="2">Medico</th>
                                        <?php if($empresapermissoes[0]->filtrar_agenda_2 == "t"){?>
                                            <th class="tabela_title">Status</th>
                                        <?php }?>

                                    </tr>
                                    <tr>
                                        <?php if($empresapermissoes[0]->filtrar_agenda_2 != "t"){?>
                                            <th class="tabela_title">
                                                <input type="hidden" id="medicoget" value="<?= ($this->session->userdata('perfil_id') == 4) ? $this->session->userdata('operador_id') : @$_GET['medico']  ?>">
                                                <select name="tipoagenda" id="tipoagenda" class="size2">
                                                    <!--<option value=""></option>-->
                                                    <option value="">TODOS</option>
                                                    <? foreach ($tipo_consulta as $value) : ?>
                                                        <option value="<?= $value->ambulatorio_tipo_consulta_id; ?>" <?
                                                        if (@$_GET['tipoagenda'] == $value->ambulatorio_tipo_consulta_id):echo 'selected';
                                                        endif;
                                                        ?>>
                                                            <?
                                                            //                                                if (@$_GET['especialidade'] == $value->cbo_ocupacao_id):
                                                            //                                                    echo '<script>carregaMedicoEspecialidade();</script>';
                                                            //                                                endif;
                                                            ?>
                                                            <?php echo $value->descricao; ?>
                                                        </option>
                                                    <? endforeach; ?>
                                                </select>
                                            </th>
                                        <?php }?>


                                        <th class="tabela_title" colspan="2">
                                            <?php
                                            if ($this->session->userdata('perfil_id') == 4 && $medico_agenda_sessao == 't') {
                                                ?>
                                                <select name="medico" id="medico" class="size2">
                                                    <option value=""> </option>
                                                    <? foreach ($medicos as $value) : ?>
                                                        <?php if ($value->operador_id == $this->session->userdata('operador_id')) { ?>
                                                            <option value="<?= $value->operador_id; ?>" selected >

                                                                <?php echo $value->nome . ' - CRM: ' . $value->conselho; ?>

                                                            </option>
                                                        <?php } ?>
                                                    <? endforeach; ?>

                                                </select>
                                            <?php } else { ?>
                                                <select name="medico" id="medico" class="size2">
                                                    <option value=""> </option>
                                                    <? foreach ($medicos as $value) : ?>
                                                        <option value="<?= $value->operador_id; ?>"<?
                                                        if (@$_GET['medico'] == $value->operador_id):echo 'selected';
                                                        endif;
                                                        ?>>

                                                            <?php echo $value->nome . ' - CRM: ' . $value->conselho; ?>


                                                        </option>
                                                    <? endforeach; ?>

                                                </select>

                                            <?php } ?>
                                        </th>
                                        <?php if($empresapermissoes[0]->filtrar_agenda_2 == "t"){  ?>
                                            <th class="tabela_title">
                                                <select name="status" id="status" class="size2">
                                                    <option value=""></option>
                                                    <option value="AGENDADO" <?
                                                    if (@$_GET['status'] == "AGENDADO") {
                                                        echo 'selected';
                                                    }
                                                    ?>>AGENDADO</option>
                                                    <option value="AGUARDANDO" <?
                                                    if (@$_GET['status'] == "AGUARDANDO") {
                                                        echo 'selected';
                                                    }
                                                    ?>>AGUARDANDO</option>
                                                    <option value="ATENDIDO" <?
                                                    if (@$_GET['status'] == "ATENDIDO") {
                                                        echo 'selected';
                                                    }
                                                    ?>>ATENDIDO</option>

                                                    <option value="ESPERA" <?
                                                    if (@$_GET['status'] == "ESPERA") {
                                                        echo 'selected';
                                                    }
                                                    ?>>ESPERA</option>

                                                </select>

                                            </th>
                                        <? } ?>




                                    </tr>

                                </table>

                                <?php if($empresapermissoes[0]->filtrar_agenda_2 == "t"){  ?>
                                    <table>
                                        <tr>
                                            <th class="tabela_title">Convênio</th>
                                            <th class="tabela_title">Situação</th>
                                        </tr>
                                        <tr>
                                            <th class="tabela_title">
                                                <select name="convenio" id="convenio" class="size2">
                                                    <option value="">TODOS</option>
                                                    <? foreach ($convenio as $value) : ?>
                                                        <option value="<?= $value->convenio_id; ?>" <?
                                                        if (@$_GET['convenio'] == $value->convenio_id):echo 'selected';
                                                        endif;
                                                        ?>><?php echo $value->nome; ?></option>
                                                    <? endforeach; ?>
                                                </select>
                                            </th>
                                            <th class="tabela_title">
                                                <select name="situacao" id="situacao" class="size2">
                                                    <option value=""></option>

                                                    <option value="BLOQUEADO" <?
                                                    if (@$_GET['situacao'] == "BLOQUEADO") {
                                                        echo 'selected';
                                                    }
                                                    ?>>BLOQUEADO</option>

                                                    <option value="FALTOU" <?
                                                    if (@$_GET['situacao'] == "FALTOU") {
                                                        echo 'selected';
                                                    }
                                                    ?>>FALTOU</option>
                                                    <option value="OK" <?
                                                    if (@$_GET['situacao'] == "OK") {
                                                        echo 'selected';
                                                    }
                                                    ?>>OCUPADO</option>
                                                    <option value="LIVRE" <?
                                                    if (@$_GET['situacao'] == "LIVRE") {
                                                        echo 'selected';
                                                    }
                                                    ?>>VAGO</option>
                                                </select>

                                            </th>
                                        </tr>
                                    </table>
                                <?php }?>

                                <table border="1">
                                    <tr>
                                        <td  colspan="1" class="tabela_title">Procurar por Mini-Curriculo</td><br>

                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="curriculos" id="curriculos" class="texto08  chosen-select" size="2" tabindex="1" data-placeholder="Selecione">
                                                <option value="">TODOS</option>
                                                <? foreach ($minicurriculos as $item) { ?>
                                                    <option value='<?= $item->operador_id ?>' <?
                                                    if(@$_GET['curriculos'] == $item->operador_id){ echo 'selected'; }
                                                    ?>><?= $item->curriculo ?></option>
                                                <? } ?>
                                            </select>
                                        </td> <td>&nbsp;</td>
                                    </tr>
                                </table>
                                <br>
                            </div>





                            <table border="1" >
                                <tr>

                                    <th colspan="2" class="tabela_title">Nome</th>
                                </tr>

                                <tr>

                                    <th colspan="2" class="tabela_title">
                                        <input type="text" name="nome" id="nome" class="texto08 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                        <? if (@$_GET['data'] != '') { ?>
                                            <input type="hidden" name="data" id="data" class="texto04 bestupper" value="<?php echo date("Y-m-d", strtotime(str_replace('/', '-', @$_GET['data']))); ?>" />
                                        <? } else { ?>
                                            <input type="hidden" name="data" id="data" class="texto04 bestupper" value="" />
                                        <? } ?>
                                    </th>
                                </tr>

                                <?php if( $empresapermissoes[0]->filtrar_agenda_2 == 't'){?>
                                    <tr>
                                        <td colspan="3">
                                            <table>
                                                <tr>
                                                    <th  class="tabela_title">Telefone</th>
                                                    <th  class="tabela_title">Cpf</th>
                                                    <th  class="tabela_title">Nascimento</th>
                                                </tr>
                                                <tr>
                                                    <th  class="tabela_title"><input type="text" name="txtTelefone" id="txtTelefone" class="texto02 bestupper" value="<?= @$_GET['txtTelefone']; ?>" /></th>
                                                    <th  class="tabela_title"><input type="text" name="txtCpf" id="txtCpf" class="texto02 bestupper"  value="<?= @$_GET['txtCpf']; ?>"/></th>
                                                    <th  class="tabela_title"><input type="text" name="txtNascimento" id="txtNascimento" class="texto02 bestupper" value="<?= @$_GET['txtNascimento']; ?>" /></th>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                <?php }?>


                                <? if ($empresapermissoes[0]->filtrar_agenda == 't' ||  $empresapermissoes[0]->filtrar_agenda_2 == 't') { ?>
                                    <tr>

                                        <th colspan="2" class="tabela_title">Observação</th>
                                    </tr>

                                    <tr>

                                        <th colspan="2" class="tabela_title">
                                            <input type="text" name="observacao" class="texto08 bestupper" value="<?php echo @$_GET['observacao']; ?>" />
                                        </th>
                                    </tr>
                                <? } ?>



                                <tr>
                                    <th colspan="1" class="tabela_title">
                                        <button type="submit" id="enviar">Pesquisar</button>
                                    </th>
                                    <!--                               O FORM FECHA AQUI-->     </form>
                <th colspan="1" class="tabela_title">
                    <button id="botaosala">S/ de Espera</button>
                </th>
                </tr>


            </table>

            </th>


            </tr>

            <!--</form>-->
            <tr>

            </tr>
            </thead>

            </table>
            <!-- Comentei essa parte só pra publicar -->
            <table>
                <tr>
                    <? if (($perfil_id == 1 || $operador_id == 1) || $empresapermissoes[0]->btn_encaixe == 'f') { ?>
                        <th style="padding-left:88%" class="tabela_title">
                            <button value="encaixar" id="encaixar">Encaixar Horário</button>
                        </th>
                    <? } ?>
                </tr>
            </table>

            <table>
                <tr>
                    <td colspan="2">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <!--                    <td rowspan="2">
                                        </td>-->
                    <!--                    <td>
                                            <div style="width: 10px;">

                                            </div>
                                        </td>-->
                    <td>
                        <table>
                            <thead>
                            <tr>
                                <th class="tabela_header" width="80px;" colspan="2">Empresa</th>
                                <th class="tabela_header" width="80px;">Operador Responsavel</th>
                                <th class="tabela_header" width="70px;" title="LOG DA AGENDA É MOSTRADO AO CLICAR NO STATUS 'agenda'">Status</th>
                                <th class="tabela_header" width="100px;">Data</th>
                                <!--<th class="tabela_header" width="100px;">Log</th>-->
                                <th class="tabela_header" width="70px;" title="LOG DA AGENDA É MOSTRADO AO CLICAR NO STATUS DO HORÁRIO">Agenda</th>
                                <th class="tabela_header" width="250px;">Nome</th>
                                <!--<th class="tabela_header" width="70px;">Resp.</th>-->
                                <!--<th class="tabela_header" width="50px;">Dia</th>-->
                                <th class="tabela_header" width="70px;">    </th>
                                <th class="tabela_header" width="150px;">Telefone</th>
                                <th class="tabela_header" width="150px;">Celular</th>
                                <th class="tabela_header" width="150px;">Idade</th>
                                <th class="tabela_header" width="150px;">Convenio</th>
                                <th class="tabela_header">Sala</th>
                                <th class="tabela_header">Médico</th>
                                <th class="tabela_header" width="250px;">Observa&ccedil;&otilde;es</th>
                                <th class="tabela_header" colspan="5"><center>A&ccedil;&otilde;es</center></th>
                            </tr>
                            </thead>
                            <?php
                            $url = $this->utilitario->build_query_params(current_url(), $_GET);
                            isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                            $contadorDia = count($this->exame->listarexamemultifuncaogeral2ContadorDia($_GET));
                            $limit = $contadorDia + 50;
                            $lista = $this->exame->listarexamemultifuncaogeral2($_GET)->limit($limit, $pagina)->get()->result();
                            //                $consulta = $this->exame->listarexamemultifuncaogeral($_GET);
                            $total = count($lista);

                            $l = $this->exame->listarestatisticapaciente($_GET);
                            $p = $this->exame->listarestatisticasempaciente($_GET);

                            // echo '<pre>';
                            // print_r($lista);
                            // die;
                            if ($total > 0) {
                            ?>
                            <tbody>
                            <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravarhorarioexameencaixegeral2/<?= $lista[0]->agenda_exames_id; ?>/" method="post">
                                <tr id="encaixe" height="50px" style="display:none">
                                    <td class="<?php echo $estilo_linha; ?>"><div style="font-size: 8pt; margin-left: 2pt"><?= $lista[0]->empresa; ?></div></td>

                                    <td class="<?php echo $estilo_linha; ?>"><b>agenda</b></td>

                                    <td class="<?php echo $estilo_linha; ?>"><?= substr($lista[0]->data, 8, 2) . "/" . substr($lista[0]->data, 5, 2) . "/" . substr($lista[0]->data, 0, 4); ?></td>
                                    <td     class="<?php echo $estilo_linha; ?>"   ><input type="text" id="horarios" alt="time"  class="size1" name="horarios" required="" /></td>
                                    <td class="<?php echo $estilo_linha; ?>"><b><?= $lista[0]->paciente; ?></b></td>

                                    <td class="<?php echo $estilo_linha; ?>"><span class="vermelho">Encaixe H.</span></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $lista[0]->telefone; ?></td>

                                    <? if ($lista[0]->convenio != "") { ?>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $lista[0]->convenio . " - " . $lista[0]->procedimento . " - " . $lista[0]->codigo; ?></td>
                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $lista[0]->convenio_paciente . " - " . $lista[0]->procedimento . " - " . $lista[0]->codigo; ?></td>
                                    <? } ?>

                                    <td class="<?php echo $estilo_linha; ?>" style="color:green"><?= $lista[0]->sala; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>" style="color:green"><?= $lista[0]->medicoagenda; ?></td>
                                    <td colspan="2" class="<?php echo $estilo_linha; ?>"><input type="text" id="obs" class="size2" name="obs"/></td>

                                    <td colspan="2" class="<?php echo $estilo_linha; ?>"><button type="submit" id="enviar">Encaixar</button></td>
                                    <td colspan="2" class="<?php echo $estilo_linha; ?>"></td>
                                </tr>
                            </form>
                            <?php
                            //                        var_dump($item->situacaoexame);
                            //                        die;
                            $estilo_linha = "tabela_content01";
                            foreach ($lista as $item) {
                                // echo '<pre>';
                                // print_r($item);
                                // die;

                                $dataFuturo2 = date("Y-m-d");
                                $dataAtual2 = $item->nascimento;
                                $date_time2 = new DateTime($dataAtual2);
                                $diff2 = $date_time2->diff(new DateTime($dataFuturo2));
                                $teste2 = $diff2->format('%Ya %mm %dd');



                                $dataFuturo = date("Y-m-d H:i:s");
                                $dataAtual = $item->data_atualizacao;

                                if ($item->celular != "") {
                                    $telefone = $item->celular;
                                } elseif ($item->telefone != "") {
                                    $telefone = $item->telefone;
                                } else {
                                    $telefone = "";
                                }

                                $date_time = new DateTime($dataAtual);
                                $diff = $date_time->diff(new DateTime($dataFuturo));
                                $teste = $diff->format('%H:%I:%S');
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";

                                $faltou = false;
                                if ($item->paciente == "" && $item->bloqueado == 't') {
                                    $situacao = "Bloqueado";
                                    $paciente = "Bloqueado";
                                    $verifica = 5;
                                } else {
                                    $paciente = "";

                                    if ($item->realizada == 't' && $item->situacaoexame == 'EXECUTANDO') {
                                        $situacao = "Atendendo";
                                        $verifica = 2;
                                    } elseif ($item->realizada == 't' && $item->situacaoexame == 'FINALIZADO') {
                                        $situacao = "Finalizado";
                                        $verifica = 4;
                                    } elseif ($item->confirmado == 'f' && $item->operador_atualizacao == null) {
                                        $situacao = "agenda";
                                        $verifica = 1;
                                    } elseif ($item->confirmado == 'f' && $item->operador_atualizacao != null) {
                                        $verifica = 6;
                                        date_default_timezone_set('America/Fortaleza');
                                        $data_atual = date('Y-m-d');
                                        $hora_atual = date('H:i:s');

                                        if($empresapermissoes[0]->status_faltou_manual == 't'){
                                            if($item->faltou_manual == 't'){
                                                $situacao = "<font color='gray'>faltou";
                                                $faltou = true;
                                            }else{
                                                $situacao = "agendado";
                                            }
                                        }else{
                                            if($empresapermissoes[0]->horario_para_informar_faltas > 0){
                                                $minutos = $empresapermissoes[0]->horario_para_informar_faltas;

                                                $tempo_faltou = date("H:i:s", strtotime("-".$minutos." minutes", strtotime($hora_atual)));
                                                if(($item->data < $data_atual) || ($item->data <= $data_atual && $item->inicio <= $tempo_faltou)){
                                                    $situacao = "<font color='gray'>faltou";
                                                    $faltou = true;
                                                }else{
                                                    $situacao = "agendado";
                                                }

                                            }elseif ($item->data < $data_atual) {
                                                $situacao = "<font color='gray'>faltou";
                                                $faltou = true;
                                            } else {
                                                $situacao = "agendado";
                                            }
                                        }
                                    } else {
                                        $situacao = "espera";
                                        $verifica = 3;
                                    }
                                }
                                if ($item->paciente == "" && $item->bloqueado == 'f') {
                                    $paciente = "vago";
                                }
                                $data = $item->data;
                                $dia = strftime("%A", strtotime($data));

                                switch ($dia) {
                                    case"Sunday": $dia = "Domingo";
                                        break;
                                    case"Monday": $dia = "Segunda";
                                        break;
                                    case"Tuesday": $dia = "Terça";
                                        break;
                                    case"Wednesday": $dia = "Quarta";
                                        break;
                                    case"Thursday": $dia = "Quinta";
                                        break;
                                    case"Friday": $dia = "Sexta";
                                        break;
                                    case"Saturday": $dia = "Sabado";
                                        break;
                                }
                                $cor = '';
                                if ($verifica == 1) {
                                    $cor = '';
                                }
                                if ($verifica == 2) {
                                    $cor = 'green';
                                }
                                if ($verifica == 3) {
                                    $cor = 'red';
                                }
                                if ($verifica == 4) {
                                    $cor = 'blue';
                                }
                                if ($verifica == 5) {
                                    $cor = 'gray';
                                }
                                ?>

                                <?if($item->profissional_aluguel == 't'){
                                    $cor = 'gray';
                                    ?>

                                    <tr class="corcinza">
                                <?}else{?>
                                    <tr>
                                <?}?>

                                <? $colpan = 2;
                                if($item->agenda_id_multiprocedimento != '' && $item->agenda_id_multiprocedimento != null){?>
                                    <td class="<?php echo $estilo_linha; ?>">
                                        <div  class="item flex flex-wrap" style="font-size: 8pt; margin-left: 2pt float left;">
                                            <button  type="button" id="mostrarmultiplosagendamentos_<?=$item->agenda_exames_id?>" onclick="mostrarmultiplosagendamentos(<?=$item->agenda_exames_id?>)">+</button>
                                        </div>
                                    </td>
                                    <? $colpan = 1;
                                }?>

                                <td class="<?php echo $estilo_linha; ?>" colspan="<?=$colpan?>">
                                    <div style="font-size: 8pt; margin-left: 2pt"><?= $item->empresa; ?></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <div style="font-size: 8pt; margin-left: 2pt"><?= @$item->nome_responsavel; ?></div>
                                </td>
                                <?
                                if ($verifica == 1) {
                                    if ($item->ocupado == 't') {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>"><b><strike><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><font color="<?= @$cor ?>"><?= $situacao; ?></strike></b></td>

                                    <? } else {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><font color="<?= @$cor ?>"><?= $situacao; ?></b></td>

                                        <?
                                    }
                                }

                                if ($verifica == 2) {
                                    ?>

                                    <td class="<?php echo $estilo_linha; ?>"><font color="<?= @$cor ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>

                                    <?
                                }


                                if ($verifica == 3) {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="<?= @$cor ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>

                                    <?
                                }

                                if ($verifica == 4) {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="<?= @$cor ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>

                                    <?
                                }

                                if ($verifica == 5) {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="<?= @$cor ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>

                                    <?
                                }


                                if ($verifica == 6) {
                                    if ($item->ocupado == 't') {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>"><b><strike><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=200');"><font color="<?= @$cor ?>"><?= $situacao; ?></strike></b></td>

                                    <? } else {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=200');"><font color="<?= @$cor ?>"><?= $situacao; ?></b></td>

                                        <?
                                    }
                                }
                                ?>
                                <?
                                //  echo "<pre>";
//                                    var_dump($lista);die;
                                ?>
                                <!-- RESPONSAVEL -->
                                <!--<td class="<?php echo $estilo_linha; ?>"><?= substr($item->secretaria, 0, 9); ?></td>-->

                                <!-- DATA, DIA E AGENDA -->
                                <? if ($item->ocupado == 't') { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><strike><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></strike></td>


                                    <td class="<?php echo $estilo_linha; ?>" title="LOG DA AGENDA É MOSTRADO AO CLICAR NO STATUS DO HORÁRIO"><strike><?= $item->inicio; ?></strike></td>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="<?= $cor ?>"><b><?= $item->paciente; ?></b></td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>



                                    <!--<td class="<?php echo $estilo_linha; ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/acoesagendamento/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Log</b></td>-->


                                    <td class="<?php echo $estilo_linha; ?>" title="LOG DA AGENDA É MOSTRADO AO CLICAR NO STATUS DO HORÁRIO"><?= $item->inicio; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/trocarpacienteconsulta/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=700,height=500');"><font color="<?= $cor ?>"><b><?= $item->paciente; ?></b></td>
                                <? } ?>
                                <!-- EMPRESA -->


                                <td class="<?php echo $estilo_linha; ?>"><?
                                    if ($item->encaixe == 't') {
                                        if ($item->paciente == '') {
                                            echo '<span class="vermelho">Encaixe H.</span>';
                                        } else {
                                            echo '<span class="vermelho">Encaixe</span>';
                                        }
                                    }
                                    ?>
                                </td>
                                <!-- TELEFONE -->
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->telefone; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->celular; ?></td>

                                <td class="<?php echo $estilo_linha; ?>"><?
                                    if($item->paciente != ""){
                                        echo  $teste2;
                                    }
                                    ?></td>

                                <!-- CONVENIO -->
                                <?
                                if ($item->convenio != "") { ?>
                                    <?php if($item->paciente != ""){ ?>
                                        <td class="<?php echo $estilo_linha; ?>"  onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/trocarprocedimentoconsulta/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=700,height=500');"   ><?= $item->convenio . " - " . $item->procedimento . " - " . $item->codigo; ?></td>
                                    <?php }else{?>
                                        <td class="<?php echo $estilo_linha; ?>" ><?= $item->convenio . " - " . $item->procedimento . " - " . $item->codigo; ?></td>
                                    <?php }?>

                                <? } else { ?>

                                    <?php if($item->paciente != ""){ ?>
                                        <td class="<?php echo $estilo_linha; ?>" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/trocarprocedimentoconsulta/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=700,height=500');"  ><?= $item->convenio_paciente . " - " . $item->procedimento . " - " . $item->codigo; ?></td>
                                    <?php }else{?>
                                        <td class="<?php echo $estilo_linha; ?>"   ><?= $item->convenio_paciente . " - " . $item->procedimento . " - " . $item->codigo; ?></td>
                                    <?php }?>

                                <? } ?>

                                <!-- SALA -->
                                <?
                                if ($verifica = 2) {
                                    $cor = "green";
                                } else if ($verifica = 3) {
                                    $cor = "red";
                                } else if ($verifica = 4) {
                                    $cor = "blue";
                                } else if ($verifica = 5) {
                                    $cor = "gray";
                                } else {
                                    $cor = "black";
                                }

                                $title = $item->medicoagenda;
                                $corMedico = $cor;
                                if ($item->confirmacao_medico != '') {
                                    if ($item->confirmacao_medico == 'f') {
                                        $corMedico = "#ff8c00";
                                        $title .= ". Não comparecerá na clinica.";
                                    } else {
                                        $corMedico = "green";
                                        $title .= ". Comparecerá na clinica.";
                                    }
                                }

                                if($item->profissional_aluguel == 't'){
                                    $cor = "gray";
                                    $corMedico = "gray";
                                }
                                if ($situacao == 'espera' || $situacao == 'agendado' || $situacao == "<font color='gray'>faltou") {
                                    ?>
                                    <td style="cursor: pointer; color: <?= $cor ?>;" class="<?php echo $estilo_linha; ?>" width="150px;" title="<?= $item->sala; ?>"><b><a style="color:<?= $cor ?>;" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/trocarmedicoconsulta/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');" /><?= $item->sala; ?></b></td>
                                    <td style="cursor: pointer; color: <?= $corMedico; ?>" class="<?php echo $estilo_linha; ?>" width="150px;" title="<?= $title; ?>"><b><a style="color:<?= $corMedico ?>;" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendamedicocurriculo/<?= $item->medico_agenda; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');" /><?= $item->medicoagenda ?></b></td>
                                <? } else { ?>
                                    <td style="cursor: pointer; color: <?= $cor ?>;" class="<?php echo $estilo_linha; ?>" width="150px;" title="<?= $item->sala ?>"><?= $item->sala ?></td>
                                    <td style="cursor: pointer; color: <?= $corMedico; ?>" class="<?php echo $estilo_linha; ?>" width="150px;" title="<?= $title; ?>"><a style="cursor: pointer; color: <?= $corMedico; ?>" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendamedicocurriculo/<?= $item->medico_agenda; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=800,height=700');"> <?= $item->medicoagenda ?> </a></td>

                                <? } ?>
                                <!-- OBSERVAÇOES -->
                                <!--<td class="<?php // echo $estilo_linha;                                   ?>"><?= $item->observacoes; ?></td>-->

                                <td class="<?php echo $estilo_linha; ?>"><a title="<?= $item->observacoes; ?>" style=" cursor: pointer;" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                                                                                                                                                                                                                                                                                                        width=500,height=400');">=><?= $item->observacoes; ?></td>
                                <? if ($item->paciente_id != "") { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() ?>cadastros/pacientes/carregar/<?= $item->paciente_id ?>/1');">Editar
                                            </a></div>
                                    </td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>">&nbsp;</td>
                                    <?
                                }
                                if ($item->paciente_id == "" && $item->bloqueado == 'f') {
                                    if ($item->medicoagenda == "") {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" ><div class="bt_link_new" style="width: 90px;">
                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarexamegeral3/<?= $item->agenda_exames_id ?>');">Agendar
                                                </a>


                                            </div>
                                        </td>
                                    <? } else {
                                        if($item->tipo == 'FISIOTERAPIA' || $item->tipo == 'ESPECIALIDADE'){
                                            ?>

                                            <td class="<?php echo $estilo_linha; ?>">
                                                <div class="bt_link_new" style="width: 90px;">
                                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarexamegeralespecialidade/<?= $item->agenda_exames_id ?>/<?= $item->medico_agenda ?>');">Agendar
                                                    </a>
                                                </div>
                                            </td>

                                            <?
                                        }else{
                                            ?>
                                            <td class="<?php echo $estilo_linha; ?>">
                                                <div class="bt_link_new" style="width: 90px;">
                                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarexamegeral/<?= $item->agenda_exames_id ?>/<?= $item->medico_agenda ?>');">Agendar
                                                    </a>


                                                </div>
                                            </td>
                                            <?
                                        }
                                    }
                                } elseif ($item->bloqueado == 'f') {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>" ><div class="bt_link_new" style="width: 90px;">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarpacientetempgeral/<?= $item->paciente_id ?>/<?= $faltou; ?>');">Atendimento
                                            </a>


                                        </div>
                                    </td>
                                <? } elseif ($item->bloqueado == 't') { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"> Bloqueado</td>
                                    <?
                                }
                                if ($paciente == "Bloqueado" || $paciente == "vago") {
                                    if ($item->bloqueado == 'f') {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a title="<?= $item->operador_desbloqueio ?>" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/bloquear/<?= $item->agenda_exames_id ?>/<?= $item->inicio; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Bloquear
                                                </a></div>
                                        </td>
                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a title="<?= $item->operador_bloqueio ?>"  onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/desbloquear/<?= $item->agenda_exames_id ?>/<?= $item->inicio; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Desbloq.
                                                </a></div>
                                        </td>
                                        <?
                                    }
                                } else {
                                    ?>
                                    <? if ($item->telefonema == 't') { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><font color="green" title="<?= $item->telefonema_operador; ?>"><b>Confirmado</b></td>
                                    <? } elseif ($item->confirmacao_por_sms == 't') {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><font color="ff8c00" title="<?= $item->telefonema_operador; ?>"><b>Confirmado&nbsp;(SMS)</b></td>
                                    <? } elseif (@$item->confirmacao_por_whatsapp == 't') {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><font color="ff8c00" title="Confirmado por whatsapp"><b>Confirmado&nbsp;(Whatsapp)</b></td>
                                        <?
                                    } else {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/telefonema/<?= $item->agenda_exames_id ?>/<?= $item->paciente; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Confirma
                                                </a></div>
                                        </td>
                                        <?
                                    }
                                }
                                ?>
                                <!-- <td id="encaixarlateral" class="<?php echo $estilo_linha; ?>" width="60px;">
                <div class="bt_link">
                        <b>Encaixar</b>      </div>
                </td> -->


                                </tr>
                                <?php

                                if($item->agenda_id_multiprocedimento != '' && $item->agenda_id_multiprocedimento != null){
                                    $array_lista_agenda = json_decode($item->agenda_id_multiprocedimento);
                                    $lista_multipla = $this->exame->listarexamemultifuncaogeral2multipla($array_lista_agenda);

                                    // echo '<pre>';
                                    // print_r($lista_multipla);
                                    // die;

                                    foreach($lista_multipla as $value){

                                        $dataFuturo2 = date("Y-m-d");
                                        $dataAtual2 = $value->nascimento;
                                        $date_time2 = new DateTime($dataAtual2);
                                        $diff2 = $date_time2->diff(new DateTime($dataFuturo2));
                                        $teste2 = $diff2->format('%Ya %mm %dd');
                                        $estilo_linha = 'tabela_content03';


                                        $dataFuturo = date("Y-m-d H:i:s");
                                        $dataAtual = $value->data_atualizacao;

                                        if ($value->celular != "") {
                                            $telefone = $value->celular;
                                        } elseif ($value->telefone != "") {
                                            $telefone = $value->telefone;
                                        } else {
                                            $telefone = "";
                                        }

                                        $date_time = new DateTime($dataAtual);
                                        $diff = $date_time->diff(new DateTime($dataFuturo));
                                        $teste = $diff->format('%H:%I:%S');
                                        // ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";

                                        $faltou = false;
                                        if ($value->paciente == "" && $value->bloqueado == 't') {
                                            $situacao = "Bloqueado";
                                            $paciente = "Bloqueado";
                                            $verifica = 5;
                                        } else {
                                            $paciente = "";

                                            if ($value->realizada == 't' && $value->situacaoexame == 'EXECUTANDO') {
                                                $situacao = "Atendendo";
                                                $verifica = 2;
                                            } elseif ($value->realizada == 't' && $value->situacaoexame == 'FINALIZADO') {
                                                $situacao = "Finalizado";
                                                $verifica = 4;
                                            } elseif ($value->confirmado == 'f' && $value->operador_atualizacao == null) {
                                                $situacao = "agenda";
                                                $verifica = 1;
                                            } elseif ($value->confirmado == 'f' && $value->operador_atualizacao != null) {
                                                $verifica = 6;
                                                date_default_timezone_set('America/Fortaleza');
                                                $data_atual = date('Y-m-d');
                                                $hora_atual = date('H:i:s');

                                                if($empresapermissoes[0]->status_faltou_manual == 't'){
                                                    if($value->faltou_manual == 't'){
                                                        $situacao = "<font color='gray'>faltou";
                                                        $faltou = true;
                                                    }else{
                                                        $situacao = "agendado";
                                                    }
                                                }else{
                                                    if($empresapermissoes[0]->horario_para_informar_faltas > 0){
                                                        $minutos = $empresapermissoes[0]->horario_para_informar_faltas;

                                                        $tempo_faltou = date("H:i:s", strtotime("-".$minutos." minutes", strtotime($hora_atual)));
                                                        if(($value->data < $data_atual) || ($value->data <= $data_atual && $value->inicio <= $tempo_faltou)){
                                                            $situacao = "<font color='gray'>faltou";
                                                            $faltou = true;
                                                        }else{
                                                            $situacao = "agendado";
                                                        }

                                                    }elseif ($value->data < $data_atual) {
                                                        $situacao = "<font color='gray'>faltou";
                                                        $faltou = true;
                                                    } else {
                                                        $situacao = "agendado";
                                                    }
                                                }
                                            } else {
                                                $situacao = "espera";
                                                $verifica = 3;
                                            }
                                        }
                                        if ($value->paciente == "" && $value->bloqueado == 'f') {
                                            $paciente = "vago";
                                        }
                                        $data = $value->data;
                                        $dia = strftime("%A", strtotime($data));

                                        switch ($dia) {
                                            case"Sunday": $dia = "Domingo";
                                                break;
                                            case"Monday": $dia = "Segunda";
                                                break;
                                            case"Tuesday": $dia = "Terça";
                                                break;
                                            case"Wednesday": $dia = "Quarta";
                                                break;
                                            case"Thursday": $dia = "Quinta";
                                                break;
                                            case"Friday": $dia = "Sexta";
                                                break;
                                            case"Saturday": $dia = "Sabado";
                                                break;
                                        }
                                        $cor = '';
                                        if ($verifica == 1) {
                                            $cor = '';
                                        }
                                        if ($verifica == 2) {
                                            $cor = 'green';
                                        }
                                        if ($verifica == 3) {
                                            $cor = 'red';
                                        }
                                        if ($verifica == 4) {
                                            $cor = 'blue';
                                        }
                                        if ($verifica == 5) {
                                            $cor = 'gray';
                                        }
                                        ?>

                                        <?if($value->profissional_aluguel == 't'){
                                            $cor = 'gray';
                                            ?>

                                            <tr class="corcinza atendimentomultiplo_<?=$item->agenda_exames_id?>" hidden>
                                        <?}else{?>
                                            <tr class="atendimentomultiplo_<?=$item->agenda_exames_id?>" hidden>
                                        <?}?>


                                        <td class="<?php echo $estilo_linha; ?>" colspan="2">
                                            <div style="font-size: 8pt; margin-left: 2pt"></div>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>">
                                            <div style="font-size: 8pt; margin-left: 2pt"></div>
                                        </td>
                                        <?
                                        if ($verifica == 1) {
                                            if ($value->ocupado == 't') {
                                                ?>
                                                <td class="<?php echo $estilo_linha; ?>"><b><strike><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $value->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><font color="<?= @$cor ?>"><?= $situacao; ?></strike></b></td>

                                            <? } else {
                                                ?>
                                                <td class="<?php echo $estilo_linha; ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $value->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><font color="<?= @$cor ?>"><?= $situacao; ?></b></td>

                                                <?
                                            }
                                        }

                                        if ($verifica == 2) {
                                            ?>

                                            <td class="<?php echo $estilo_linha; ?>"><font color="<?= @$cor ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $value->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>

                                            <?
                                        }


                                        if ($verifica == 3) {
                                            ?>
                                            <td class="<?php echo $estilo_linha; ?>"><font color="<?= @$cor ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $value->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>

                                            <?
                                        }

                                        if ($verifica == 4) {
                                            ?>
                                            <td class="<?php echo $estilo_linha; ?>"><font color="<?= @$cor ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $value->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>

                                            <?
                                        }

                                        if ($verifica == 5) {
                                            ?>
                                            <td class="<?php echo $estilo_linha; ?>"><font color="<?= @$cor ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $value->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>

                                            <?
                                        }


                                        if ($verifica == 6) {
                                            if ($value->ocupado == 't') {
                                                ?>
                                                <td class="<?php echo $estilo_linha; ?>"><b><strike><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $value->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=200');"><font color="<?= @$cor ?>"><?= $situacao; ?></strike></b></td>

                                            <? } else {
                                                ?>
                                                <td class="<?php echo $estilo_linha; ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $value->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=200');"><font color="<?= @$cor ?>"><?= $situacao; ?></b></td>

                                                <?
                                            }
                                        }
                                        ?>
                                        <?
                                        //  echo "<pre>";
                                        //                                    var_dump($lista);die;
                                        ?>
                                        <!-- RESPONSAVEL -->
                                        <!--<td class="<?php echo $estilo_linha; ?>"><?= substr($value->secretaria, 0, 9); ?></td>-->

                                        <!-- DATA, DIA E AGENDA -->
                                        <? if ($value->ocupado == 't') { ?>
                                            <td class="<?php echo $estilo_linha; ?>"><strike><?// substr($value->data, 8, 2) . "/" . substr($value->data, 5, 2) . "/" . substr($value->data, 0, 4); ?></strike></td>


                                            <td class="<?php echo $estilo_linha; ?>" title="LOG DA AGENDA É MOSTRADO AO CLICAR NO STATUS DO HORÁRIO"><strike><?// $value->inicio; ?></strike></td>
                                            <td class="<?php echo $estilo_linha; ?>"><font color="<?= $cor ?>"><b><?// $value->paciente; ?></b></td>
                                        <? } else { ?>
                                            <td class="<?php echo $estilo_linha; ?>"><?// substr($value->data, 8, 2) . "/" . substr($value->data, 5, 2) . "/" . substr($value->data, 0, 4); ?></td>



                                            <!--<td class="<?php echo $estilo_linha; ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/acoesagendamento/<?= $value->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Log</b></td>-->


                                            <td class="<?php echo $estilo_linha; ?>" title="LOG DA AGENDA É MOSTRADO AO CLICAR NO STATUS DO HORÁRIO"><?// $value->inicio; ?></td>
                                            <td class="<?php echo $estilo_linha; ?>" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/trocarpacienteconsulta/<?= $value->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=700,height=500');"><font color="<?= $cor ?>"><b><?// $value->paciente; ?></b></td>
                                        <? } ?>
                                        <!-- EMPRESA -->


                                        <td class="<?php echo $estilo_linha; ?>"><?
                                            if ($value->encaixe == 't') {
                                                if ($value->paciente == '') {
                                                    echo '<span class="vermelho">Encaixe H.</span>';
                                                } else {
                                                    echo '<span class="vermelho">Encaixe</span>';
                                                }
                                            }
                                            ?>
                                        </td>
                                        <!-- TELEFONE -->
                                        <td class="<?php echo $estilo_linha; ?>"><?// $value->telefone; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>"><?// $value->celular; ?></td>

                                        <td class="<?php echo $estilo_linha; ?>"><?
                                            if($value->paciente != ""){
                                                //echo  $teste2;
                                            }
                                            ?></td>

                                        <!-- CONVENIO -->
                                        <?
                                        if ($value->convenio != "") { ?>
                                            <?php if($value->paciente != ""){ ?>
                                                <td class="<?php echo $estilo_linha; ?>"  onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/trocarprocedimentoconsulta/<?= $value->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=700,height=500');"   ><?= $value->convenio . " - " . $value->procedimento . " - " . $value->codigo; ?></td>
                                            <?php }else{?>
                                                <td class="<?php echo $estilo_linha; ?>" ><?= $value->convenio . " - " . $value->procedimento . " - " . $value->codigo; ?></td>
                                            <?php }?>

                                        <? } else { ?>

                                            <?php if($value->paciente != ""){ ?>
                                                <td class="<?php echo $estilo_linha; ?>" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/trocarprocedimentoconsulta/<?= $value->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=700,height=500');"  ><?= $value->convenio_paciente . " - " . $value->procedimento . " - " . $value->codigo; ?></td>
                                            <?php }else{?>
                                                <td class="<?php echo $estilo_linha; ?>"   ><?= $value->convenio_paciente . " - " . $value->procedimento . " - " . $value->codigo; ?></td>
                                            <?php }?>

                                        <? } ?>

                                        <!-- SALA -->
                                        <?
                                        if ($verifica = 2) {
                                            $cor = "green";
                                        } else if ($verifica = 3) {
                                            $cor = "red";
                                        } else if ($verifica = 4) {
                                            $cor = "blue";
                                        } else if ($verifica = 5) {
                                            $cor = "gray";
                                        } else {
                                            $cor = "black";
                                        }

                                        $title = $value->medicoagenda;
                                        $corMedico = $cor;
                                        if ($value->confirmacao_medico != '') {
                                            if ($value->confirmacao_medico == 'f') {
                                                $corMedico = "#ff8c00";
                                                $title .= ". Não comparecerá na clinica.";
                                            } else {
                                                $corMedico = "green";
                                                $title .= ". Comparecerá na clinica.";
                                            }
                                        }

                                        if($value->profissional_aluguel == 't'){
                                            $cor = "gray";
                                            $corMedico = "gray";
                                        }
                                        if ($situacao == 'espera' || $situacao == 'agendado' || $situacao == "<font color='gray'>faltou") {
                                            ?>
                                            <td style="cursor: pointer; color: <?= $cor ?>;" class="<?php echo $estilo_linha; ?>" width="150px;" title="<?= $value->sala; ?>"><b><a style="color:<?= $cor ?>;" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/trocarmedicoconsulta/<?= $value->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');" /><?= $value->sala; ?></b></td>
                                            <td style="cursor: pointer; color: <?= $corMedico; ?>" class="<?php echo $estilo_linha; ?>" width="150px;" title="<?= $title; ?>"><b><a style="color:<?= $corMedico ?>;" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendamedicocurriculo/<?= $value->medico_agenda; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');" /><?= $value->medicoagenda ?></b></td>
                                        <? } else { ?>
                                            <td style="cursor: pointer; color: <?= $cor ?>;" class="<?php echo $estilo_linha; ?>" width="150px;" title="<?= $value->sala ?>"><?= $value->sala ?></td>
                                            <td style="cursor: pointer; color: <?= $corMedico; ?>" class="<?php echo $estilo_linha; ?>" width="150px;" title="<?= $title; ?>"><a style="cursor: pointer; color: <?= $corMedico; ?>" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendamedicocurriculo/<?= $value->medico_agenda; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=800,height=700');"> <?= $value->medicoagenda ?> </a></td>

                                        <? } ?>
                                        <!-- OBSERVAÇOES -->
                                        <!--<td class="<?php // echo $estilo_linha;                                   ?>"><?= $value->observacoes; ?></td>-->

                                        <td class="<?php echo $estilo_linha; ?>"><a title="<?= $value->observacoes; ?>" style=" cursor: pointer;" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $value->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                                                                                                                                                                                                                                                                                                            width=500,height=400');">=><?= $value->observacoes; ?></td>
                                        <? if ($value->paciente_id != "") { ?>
                                            <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                                <!-- <div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>cadastros/pacientes/carregar/<?= $value->paciente_id ?>/1');">Editar
                                        </a></div> -->
                                            </td>
                                        <? } else { ?>
                                            <td class="<?php echo $estilo_linha; ?>">&nbsp;</td>
                                            <?
                                        }
                                        if ($value->paciente_id == "" && $value->bloqueado == 'f') {
                                            if ($value->medicoagenda == "") {
                                                ?>
                                                <td class="<?php echo $estilo_linha; ?>" >
                                                    <!-- <div class="bt_link_new" style="width: 90px;">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarexamegeral3/<?= $value->agenda_exames_id ?>');">Agendar
                                            </a>
                                        </div> -->
                                                </td>
                                            <? } else {
                                                if($value->tipo == 'FISIOTERAPIA' || $value->tipo == 'ESPECIALIDADE'){
                                                    ?>

                                                    <td class="<?php echo $estilo_linha; ?>">
                                                        <!-- <div class="bt_link_new" style="width: 90px;">
                                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarexamegeralespecialidade/<?= $value->agenda_exames_id ?>/<?= $value->medico_agenda ?>');">Agendar
                                                    </a>
                                                </div> -->
                                                    </td>

                                                    <?
                                                }else{
                                                    ?>
                                                    <td class="<?php echo $estilo_linha; ?>">
                                                        <!-- <div class="bt_link_new" style="width: 90px;">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarexamegeral/<?= $value->agenda_exames_id ?>/<?= $value->medico_agenda ?>');">Agendar
                                            </a>
                                        </div> -->
                                                    </td>
                                                    <?
                                                }
                                            }
                                        } elseif ($value->bloqueado == 'f') {
                                            ?>
                                            <td class="<?php echo $estilo_linha; ?>" >
                                                <!-- <div class="bt_link_new" style="width: 90px;">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarpacientetempgeral/<?= $value->paciente_id ?>/<?= $faltou; ?>');">Atendimento
                                        </a>
                                    </div> -->
                                            </td>
                                        <? } elseif ($value->bloqueado == 't') { ?>
                                            <td class="<?php echo $estilo_linha; ?>" width="60px;"> Bloqueado</td>
                                            <?
                                        }
                                        if ($paciente == "Bloqueado" || $paciente == "vago") {
                                            if ($value->bloqueado == 'f') {
                                                ?>
                                                <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                                    <!-- <div class="bt_link">
                                            <a title="<?= $value->operador_desbloqueio ?>" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/bloquear/<?= $value->agenda_exames_id ?>/<?= $value->inicio; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Bloquear
                                            </a></div> -->
                                                </td>
                                            <? } else { ?>
                                                <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                                    <!-- <div class="bt_link">
                                            <a title="<?= $value->operador_bloqueio ?>"  onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/desbloquear/<?= $value->agenda_exames_id ?>/<?= $value->inicio; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Desbloq.
                                            </a></div> -->
                                                </td>
                                                <?
                                            }
                                        } else {
                                            ?>
                                            <? if ($value->telefonema == 't') { ?>
                                                <!-- <td class="<?php echo $estilo_linha; ?>" width="60px;"><font color="green" title="<?= $value->telefonema_operador; ?>"><b>Confirmado</b></td> -->
                                            <? } elseif ($value->confirmacao_por_sms == 't') {
                                                ?>
                                                <!-- <td class="<?php echo $estilo_linha; ?>" width="60px;"><font color="ff8c00" title="<?= $value->telefonema_operador; ?>"><b>Confirmado&nbsp;(SMS)</b></td> -->
                                            <? } elseif (@$value->confirmacao_por_whatsapp == 't') {
                                                ?>
                                                <!-- <td class="<?php echo $estilo_linha; ?>" width="60px;"><font color="ff8c00" title="Confirmado por whatsapp"><b>Confirmado&nbsp;(Whatsapp)</b></td> -->
                                                <?
                                            } else {
                                                ?>
                                                <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                                    <!-- <div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/telefonema/<?= $value->agenda_exames_id ?>/<?= $value->paciente; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Confirma
                                            </a></div> -->
                                                </td>
                                                <?
                                            }
                                        }
                                        ?>
                                        <!-- <td id="encaixarlateral" class="<?php echo $estilo_linha; ?>" width="60px;">
                    <div class="bt_link">
                            <b>Encaixar</b>      </div>
                    </td> -->


                                        </tr>

                                        <?
                                    }
                                }
                            }
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="tabela_footer" colspan="15">
                                    <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>

                                </th>
                            </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
            </table>

            <div id="myModal" class="modal" hidden>
            </div>
        </div>
    </div>
</div>
<?
if (@$_GET['data'] != '') {
    $data = date("Y-m-d", strtotime(str_replace('/', '-', $_GET['data'])));
} else {
    $data = date('Y-m-d');
}
if (@$_GET['nome'] != '') {
    $nome = $_GET['nome'];
} else {
    $nome = "";
}
if (@$_GET['sala'] != '') {
    $sala = "";
}
$feriado = $this->agenda->listarferiadosagenda();
//var_dump(date($feriado[0]->data));die;
?>


<script>

    if ($('#nome').val() != '') {
        var paciente = '<?= $nome ?>';
    } else {
        var paciente = '';
    }
    //    alert('<?= $sala_atual ?>');
    document.addEventListener('DOMContentLoaded', function() {

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            header: {
                left: 'prev,next',
                center: 'title',
                right: 'today'
            },
            height: 300,
//        theme: true,
            dayRender: function (date, cell) {
                if ($('#data').val() == '') {
                    var data_escolhida = moment(new Date()).format('YYYY-MM-DD');
                } else {
                    var data_escolhida = $('#data').val();
                }

                var today = moment(new Date()).format('YYYY-MM-DD');
                var check = moment(date).format('YYYY-MM-DD');
//            alert(data_escolhida);
//            var today = $.fullCalendar.formatDate(new Date(), 'yyyy-MM-dd');
                if (data_escolhida == check && data_escolhida != today) {
                    cell.css("background-color", "#BCD2EE");
                }
            },
            dayClick: function (date) {
                var data = date.format();
                var empresa =  $('#empresa').val();
                window.open('<?= base_url() ?>ambulatorio/exame/listarmultifuncaoconsultacalendario?empresa='+empresa+'&especialidade=&medico=&situacao=&data=' + moment(data).format('DD%2FMM%2FYYYY') + '&nome=' + paciente + '', '_self');



            },
//        eventDragStop: function (date, jsEvent, view) {
////            alert(date.format());
//        },
//        navLinks: true,
            showNonCurrentDates: false,
//            weekends: false,

//                navLinks: true, // can click day/week names to navigate views
            defaultDate: '<?= $data ?>',
            locale: 'pt-br',
            editable: false,
            eventLimit: false, // allow "more" link when too many events
            schedulerLicenseKey: 'CC-Attribution-Commercial-NoDerivatives',
            eventSources: [
                {
                    url: '<?= base_url() ?>autocomplete/listarhorarioscalendario',
                    type: 'POST',
                    data: {
                        medico: <?=$id_medico_por_get?>,
                        nome: $('#nome').val(),
                        tipoagenda: $('#tipoagenda').val(),
                        empresa: $('#empresa').val(),
                        procedimento: $('#procedimento').val(),
                        sala: sala_atual,
                        grupo: $('#grupo').val(),
                        paciente: paciente,
                        minicurriculo_id: $('#curriculos').val()

                    },
                    error: function (data) {
//                    alert(data);
                        console.log(data);
                    }
                }
            ]
        });

        calendar.render();
    });


    function filtrolivre(){
        $("#data").val("");
        location.reload();
    }


    function mostrarmultiplosagendamentos(agenda_exames_id){
        var botao = $("#mostrarmultiplosagendamentos_"+agenda_exames_id).text();

        if (botao == '+') {
            $("#mostrarmultiplosagendamentos_"+agenda_exames_id).text('-');
        } else {
            $("#mostrarmultiplosagendamentos_"+agenda_exames_id).text('+');
        }
        $(".atendimentomultiplo_"+agenda_exames_id).toggle();
    }

    $(".chosen-select").chosen({width: "95%"});

    //alert();
    <? if ($sala_atual != 0) { ?>
    var sala_atual = <?= $sala_atual ?>;
    <? } else { ?>
    var sala_atual = '';
    <? } ?>

    if ($('#grupo').val()) {

//        alert($('#grupo').val());
        $('.carregando').show();
//                                                        alert('teste_parada');
        $.getJSON('<?= base_url() ?>autocomplete/grupoempresasala', {txtgrupo: $('#grupo').val(), txtempresa: $('#empresa').val(), ajax: true}, function (j) {
            options = '<option value=""></option>';
//                    alert(j);
            sala_atual = <?= $sala_atual ?>;
            for (var c = 0; c < j.length; c++) {
                if (sala_atual == j[c].exame_sala_id) {
                    options += '<option selected value="' + j[c].exame_sala_id + '">' + j[c].nome + '</option>';
                } else {
                    options += '<option value="' + j[c].exame_sala_id + '">' + j[c].nome + '</option>';
                }

            }

            $('#sala').html(options).show();
            $('.carregando').hide();



        });
    }

    if ($('#grupo').val()) {

//        alert($('#grupo').val());
        $('.carregando').show();
//                                                        alert('teste_parada');
        $.getJSON('<?= base_url() ?>autocomplete/grupoempresa', {txtgrupo: $('#grupo').val(), txtempresa: $('#empresa').val(), ajax: true}, function (j) {
            options = '<option value=""></option>';
            var empresa_atual = '<?= ($empresa_atual != '' ? $empresa_atual : '') ?>';
            for (var c = 0; c < j.length; c++) {
                if (empresa_atual == j[c].empresa_id) {
                    options += '<option selected value="' + j[c].empresa_id + '">' + j[c].nome + '</option>';
                } else {
                    options += '<option value="' + j[c].empresa_id + '">' + j[c].nome + '</option>';
                }

            }
            $('#empresa').html(options).show();
            $('.carregando').hide();



        });
    }

    //alert($('#medico').val());
    $(function () {
        $("#accordion").accordion();
    });
    $("#botaosala").click(function () {
        $("#sala-de-espera").toggle("fast", function () {
            // Animation complete.
        });
    });

    $("#botaosalaesconder").click(function () {
        $("#sala-de-espera").hide("fast", function () {
            // Animation complete.
        });
    });


    //    function date() {

    $(function () {
        $('#grupo').change(function () {

            if ($(this).val()) {
//                alert($(this).val());
                $('.carregando').show();
//                                                        alert('teste_parada');
                $.getJSON('<?= base_url() ?>autocomplete/grupoempresasala', {txtgrupo: $('#grupo').val(), txtempresa: $('#empresa').val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
//                    alert(j);
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].exame_sala_id + '">' + j[c].nome + '</option>';
                    }
                    $('#sala').html(options).show();
                    $('.carregando').hide();
                });

            } else {
                $('.carregando').show();
//                                                        alert('teste_parada');
                $.getJSON('<?= base_url() ?>autocomplete/grupoempresasalatodos', {txtgrupo: $('#grupo').val(), txtempresa: $('#empresa').val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
//                    alert(j);
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].exame_sala_id + '">' + j[c].nome + '</option>';
                    }
                    $('#sala').html(options).show();
                    $('.carregando').hide();
                });
            }

        });
    });

    $(function () {
        $('#empresa').change(function () {

            if ($(this).val()) {
//                alert($(this).val());
                $('.carregando').show();
//                                                        alert('teste_parada');
                $.getJSON('<?= base_url() ?>autocomplete/grupoempresasala', {txtgrupo: $('#grupo').val(), txtempresa: $('#empresa').val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
//                    alert(j);
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].exame_sala_id + '">' + j[c].nome + '</option>';
                    }
                    $('#sala').html(options).show();
                    $('.carregando').hide();
                });


            } else {
                $('.carregando').show();
//                                                        alert('teste_parada');
                $.getJSON('<?= base_url() ?>autocomplete/grupoempresasalatodos', {txtgrupo: $('#grupo').val(), txtempresa: $('#empresa').val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
//                    alert(j);
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].exame_sala_id + '">' + j[c].nome + '</option>';
                    }
                    $('#sala').html(options).show();
                    $('.carregando').hide();
                });
            }

        });
    });

    $(function () {
        $('#tipoagenda').change(function () {
            $('.carregando').show();
//            alert('teste_parada');
            $.getJSON('<?= base_url() ?>autocomplete/listarmedicotipoagenda', {tipoagenda: $(this).val(), ajax: true}, function (j) {
                options = '<option value=""></option>';
                for (var c = 0; c < j.length; c++) {
                    options += '<option value="' + j[c].operador_id + '">' + j[c].nome + '</option>';
                }
//                console.log(options);
                $('#medico').html(options).show();
                $('.carregando').hide();

            });
        });
    });

    <? if (@$_GET['tipoagenda'] != '') { ?>
    $.getJSON('<?= base_url() ?>autocomplete/listarmedicotipoagenda', {tipoagenda: $('#tipoagenda').val(), ajax: true}, function (j) {
        options = '<option value=""></option>';

        for (var c = 0; c < j.length; c++) {
            options += '<option value="' + j[c].operador_id + '">' + j[c].nome + '</option>';
        }
        //                console.log(options);
        $('#medico').html(options).show();
        $('.carregando').hide();

    });
    <? } ?>

    $(function () {
        $('#grupo').change(function () {

//            if ($(this).val()) {

//                alert($(this).val());
            $('.carregando').show();
//                                                        alert('teste_parada');
            $.getJSON('<?= base_url() ?>autocomplete/grupoempresa', {txtgrupo: $(this).val(), ajax: true}, function (j) {
                options = '<option value=""></option>';
//                    alert(j);

                for (var c = 0; c < j.length; c++) {
                    options += '<option value="' + j[c].empresa_id + '">' + j[c].nome + '</option>';
                }
                $('#empresa').html(options).show();
                $('.carregando').hide();



            });
//            }
        });
    });


    $('#encaixar').click(function () {

        $('#encaixe').toggle();
        $('#horarios').mask("99:99");

    });




    $(function () {

        listarmedicoempresa();
        $('#empresa').change(function () {

            $.getJSON('<?= base_url() ?>autocomplete/listarmedicoempresa', {empresa_id: $('#empresa').val(), ajax: true}, function (j) {
                var options = '<option value=""></option>';
                for (var c = 0; c < j.length; c++) {
                    if(<?= $this->session->userdata('perfil_id') ?> == 4 && <?= $medico_agenda_sessao  ?> == 't'){
                        if($("#medicoget").val() == j[c].operador_id){
                            options += '<option  value="' + j[c].operador_id + '" selected>' + j[c].nome + '- CRM:'+ j[c].conselho +'</option>';
                        }
                    }else{
                        if($("#medicoget").val() == j[c].operador_id){
                            options += '<option  value="' + j[c].operador_id + '" selected>' + j[c].nome + '- CRM:'+ j[c].conselho +'</option>';
                        }else{
                            options += '<option value="' + j[c].operador_id + '">' + j[c].nome + '- CRM:'+ j[c].conselho +'</option>';
                        }
                    }
                }
                $('#medico').html(options).show();
                $('.carregando').hide();

            });

        });


    });

    function listarmedicoempresa(){
        $.getJSON('<?= base_url() ?>autocomplete/listarmedicoempresa', {empresa_id: $('#empresa').val(), ajax: true}, function (j) {
            var options = '<option value=""></option>';
            for (var c = 0; c < j.length; c++) {
                if(<?= $this->session->userdata('perfil_id') ?> == 4 && <?= $medico_agenda_sessao  ?> == 't'){
                    if($("#medicoget").val() == j[c].operador_id){
                        options += '<option  value="' + j[c].operador_id + '" selected>' + j[c].nome + '- CRM:'+ j[c].conselho +'</option>';
                    }
                }else{
                    if($("#medicoget").val() == j[c].operador_id){
                        options += '<option  value="' + j[c].operador_id + '" selected>' + j[c].nome + '- CRM:'+ j[c].conselho +'</option>';
                    }else{
                        options += '<option value="' + j[c].operador_id + '">' + j[c].nome + '- CRM:'+ j[c].conselho +'</option>';
                    }
                }
            }
            $('#medico').html(options).show();
            $('.carregando').hide();

        });
    }

    jQuery("#txtTelefone")
        .mask("(99) 9999-9999?9")
        .focusout(function (event) {
            var target, phone, element;
            target = (event.currentTarget) ? event.currentTarget : event.srcElement;
            phone = target.value.replace(/\D/g, '');
            element = $(target);
            element.unmask();
            if (phone.length > 10) {
                element.mask("(99) 99999-999?9");
            } else {
                element.mask("(99) 9999-9999?9");
            }
        });

    jQuery("#txtCpf")
        .mask("999.999.999-99")
        .focusout(function (event) {
            var target, phone, element;
            target = (event.currentTarget) ? event.currentTarget : event.srcElement;
            phone = target.value.replace(/\D/g, '');
            element = $(target);
            element.unmask();
            if (phone.length > 10) {
                element.mask("999.999.999-99");
            } else {
                element.mask("999.999.999-99");
            }
        });
    jQuery("#txtTelefone")
        .mask("(99) 9999-9999?9")
        .focusout(function (event) {
            var target, phone, element;
            target = (event.currentTarget) ? event.currentTarget : event.srcElement;
            phone = target.value.replace(/\D/g, '');
            element = $(target);
            element.unmask();
            if (phone.length > 10) {
                element.mask("(99) 99999-999?9");
            } else {
                element.mask("(99) 9999-9999?9");
            }
        });
    jQuery("#txtNascimento")
        .mask("99/99/9999")
        .focusout(function (event) {
            var target, phone, element;
            target = (event.currentTarget) ? event.currentTarget : event.srcElement;
            phone = target.value.replace(/\D/g, '');
            element = $(target);
            element.unmask();
            if (phone.length > 10) {
                element.mask("99/99/9999");
            } else {
                element.mask("99/99/9999");
            }
        });


    <?
    if(empty($_GET)){
    if($empresapermissoes[0]->informar_faltas == 't'){
    if($empresapermissoes[0]->horario_para_informar_faltas > 0){
    $minutos = $empresapermissoes[0]->horario_para_informar_faltas
    ?>
    $(document).ready(function () {
        var tempo = <?=$minutos?>;
        $.getJSON('<?= base_url() ?>autocomplete/informarpacientesfaltou', {tempo: tempo, ajax: true}, function (j) {
            var table_faltas = '';
            var ativa_modal = false;
            table_faltas += "<table>";
            for (var c = 0; c < j.length; c++) {
                ativa_modal = true;
                // table_faltas += "<table>";
                table_faltas += "<tr class='tablemodal'><td colspan='3'> Paciente: "+j[c].paciente+" - "+j[c].telefone+"</td></tr>";
                table_faltas += "<tr>";
                table_faltas += "<td class='titulo_table'>Horario</td>";
                table_faltas += "<td class='titulo_table'>Procedimento</td>";
                table_faltas += "<td class='titulo_table'>Médico</td>";
                table_faltas += "</tr>";

                table_faltas += "<tr>";
                table_faltas += "<td>"+j[c].inicio+"</td>";
                table_faltas += "<td>"+j[c].procedimento+"</td>";
                table_faltas += "<td>"+j[c].medico+"</td>";
                table_faltas += "</tr>";
                // table_faltas += "</table>";

                table_faltas += "<tr><td><br></td></tr>";

            }
            table_faltas += "</table>";

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = dd + '/' + mm + '/' + yyyy;

            if(ativa_modal){
                $("#myModal").append(
                    "<div class='modal-content' id='removemodal'>"+
                    "<div class='modal-header'>"+
                    "<span class='close'>&times;</span>"+
                    "<h2>Pacientes Que Faltaram "+today+"</h2>"+
                    "</div>"+
                    "<div class='modal-body'>"+
                    table_faltas+
                    "</div>"+
                    "<div class='modal-footer'>"+
                    "</div>"+
                    "</div>");

                $("#myModal").toggle();

                var modal = document.getElementById("myModal");
                var span = document.getElementsByClassName("close")[0];

                span.onclick = function() {
                    modal.style.display = "none";
                }

                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                        $("html,body").css({"overflow":"auto"});
                    }
                }

                $("html,body").css({"overflow":"hidden"});

            }
        });
    });
    <?
    }
    }
    }
    ?>

</script>


