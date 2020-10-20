<link href="<?= base_url() ?>css/ambulatorio/multifuncaoconsulta-lista.css" rel="stylesheet"/>
<div id="page-wrapper"> <!-- Inicio da DIV content -->
    <?
    $medicos = $this->operador_m->listarmedicos();
    $especialidade = $this->exame->listarespecialidade();
    $empresas = $this->exame->listarempresas();
    $empresa_logada = $this->session->userdata('empresa_id');
    $perfil_id = $this->session->userdata('perfil_id');
    ?>

    <!-- <div class="container"> -->
        <!-- <div class="col-lg-12"> -->
            <div class="panel panel-default">
                
                <form method="get" action="<?php echo base_url() ?>ambulatorio/exame/listarmultifuncaoconsulta">
                    <div class="container" >
                            <!-- <table width="100%" class="table " id="dataTables-example"> -->
                            <div class="labels">
                                <h6>Situação<br><br>
                                    Medico<br><br>
                                    Data<br><br>
                                    Ações
                                    </h6>
                            </div>
                            <div class="inputs">
                                <select name="situacao" id="situacao" class="form-control texto06">
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
                            <!-- <div class="especialidade" style="display:none;">
                                <select name="especialidade" id="especialidade" class="form-control texto06">
                                    <option value=""></option>
                                    <? foreach ($especialidade as $value) : ?>
                                        <option value="<?= $value->cbo_ocupacao_id; ?>"<?
                                        if (@$_POST['especialidade'] == $value->cbo_ocupacao_id):echo 'selected';
                                        endif;
                                        ?>><?php echo $value->descricao; ?></option>
                                            <? endforeach; ?>
                                </select>
                            </div> -->
                            
                                <br>
                           
                                <select name="medico" id="medico" class="form-control texto06">
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
                           
                                <br>
                            
                                    <div class="input-group-prepend">
                                    </div>
                                    <input type="text" id="data" alt="data" name="data" class="form-control datepicker texto06" placeholder="Select date" value="<?php echo @$_GET['data']; ?>">
                                    <!-- <input type="text"  id="data" alt="date" name="data" class="form-control"  value="<?php echo @$_GET['data']; ?>"/> -->
                                
                                <br>
                            
                                <button type="submit" class="btn btn-default btn-outline btn-danger btn-sm" name="enviar"><i class="fa fa-search fa-1x"></i></button>
                                <a class="btn btn-outline btn-danger btn-sm" href="<?php echo base_url() ?>ambulatorio/exametemp/novopacienteconsultaencaixe" target="_blank">
                                <i class="fa fa-plus fa-w"></i> Encaixar</a></td>
                            </div>
                            <div class="calendar">
                                    <div id="calendar"></div>
                            </div>
                    </div>
                </form>
                
                <!-- <style>

                    /*                    body {
                                            margin: 40px 10px;
                                            padding: 0;
                                            font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
                                            font-size: 14px;
                                        }*/

                    #calendar {
                        width: 1000px;
                        margin: 0 auto;
                    }
                    .tabela_acoes{
                        width: 150pt;
                    }
                    .desbloq{
                        width: 135pt;
                    }
                    .bloq{
                        width: 65pt;
                    }

                </style> -->
                <!--<div class="table-responsive text-right">-->
                <!-- <div class="row"> -->
                    <!-- <div class="col-lg-4"> -->
                        <div id="calendar"></div>
                    <!-- </div> -->
                <!-- </div> -->

                <!--</div>-->
                <div class="panel-heading ">
                    <h5><b>Agendamento</b></h5>
                </div>
                <!-- <a class="btn btn-outline btn-danger" href="<?php echo base_url() ?>ambulatorio/exametemp/novopacienteconsultaencaixe" target="_blank">
                    <i class="fa fa-plus fa-w"></i> Encaixar
                </a> -->
                <!-- /.panel-heading -->
                <div class="panel-body" >
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Situação</th>
                                    <th colspan="3">Paciente</th>
                                    <th>Data</th>
                                    <th>H.Agenda</th>
                                    <th>H.Autorização</th>
                                    <th>Médico</th>
                                    <th>Convênio</th>
                                    <th>Número</th>
                                    <th>Observações</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>


                            <?php
                            $url = $this->utilitario->build_query_params(current_url(), $_GET);
                            $consulta = $this->exame->listarexamemultifuncaoconsulta($_GET);
                            $total = $consulta->count_all_results();
                            $limit = 50;
                            isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                            $l = $this->exame->listarestatisticapacienteconsulta($_GET);
                            $p = $this->exame->listarestatisticasempacienteconsulta($_GET);

                            if ($total > 0) {
                                ?>

                                <?php
                                $lista = $this->exame->listarexamemultifuncaoconsulta2($_GET)->limit($limit, $pagina)->get()->result();
                                $estilo_linha = "tabela_content01";
                                $paciente = "";
                                foreach ($lista as $item) {
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
                                        $verifica = 7;
                                    } else {
                                        $paciente = "";

                                        if ($item->realizada == 't' && $item->situacaoexame == 'EXECUTANDO') {
                                            $situacao = "Aguardando";
                                            $verifica = 2;
                                        } elseif ($item->realizada == 't' && $item->situacaolaudo == 'FINALIZADO') {
                                            $situacao = "Finalizado";
                                            $verifica = 4;
                                        } elseif ($item->realizada == 't' && $item->situacaoexame == 'FINALIZADO') {
                                            $situacao = "Atendendo";
                                            $verifica = 5;
                                        } elseif ($item->confirmado == 'f' && $item->paciente_id == null) {
                                            $situacao = "Vago";
                                            $verifica = 1;
                                        } elseif ($item->confirmado == 'f' && $item->operador_atualizacao != null) {
                                            $verifica = 6;
                                            date_default_timezone_set('America/Fortaleza');
                                            $data_atual = date('Y-m-d');
                                            $hora_atual = date('H:i:s');
                                            if ($item->data < $data_atual && $item->paciente_id != null) {
                                                $situacao = "Faltou";
                                                $faltou = true;
                                            } elseif ($item->data < $data_atual && $item->paciente_id == null) {
                                          //    echo 'a';
                                                $situacao = 'Vago';
                                                $verifica = 1;
                                            } else {
                                                //echo 'a';
                                                $situacao = "Agendado";
                                            }
                                        } else {
                                            $situacao = "Aguardando";
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
                                    ?>
                                    <? if ($verifica == 1) { ?>
                                        <tr class="success2">
                                            <td><?= $situacao ?></td>
                                            <td colspan="3"><?= $item->paciente ?></td>
                                            <td><?= date("d/m/Y", strtotime($item->data)) ?></td>
                                            <td><?= date("H:i:s", strtotime($item->inicio)) ?></td>
                                            <td><? //=date("H:i:s", strtotime($item->data_autorizacao))    ?></td>
                                            <td><?= substr($item->medicoagenda, 0, 15); ?></td>
                                            <td><?= $item->convenio ?></td>
                                            <td><?= $item->celular ?></td>
                                            <td><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                                                                            width=550,height=330');">=><?= $item->observacoes; ?></a></td>
                                            <td class="tabela_acoes" >
                                                <? if ($item->bloqueado == 'f') { ?>
                                                    <p>
                                                        <a class="btn btn-success btn-sm bloq" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/bloquear/<?= $item->agenda_exames_id ?>/<?= $item->inicio; ?>');">Bloquear <i class="fa fa-lock" aria-hidden="true"></i>
                                                        </a>
                                                        <a class="btn btn-success btn-sm bloq" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarconsultatemp/<?= $item->agenda_exames_id ?>');">Agendar <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        </a>
                                                    </p>
                                                <? } else { ?>
                                                    <a class="btn btn-success btn-sm" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/desbloquear/<?= $item->agenda_exames_id ?>/<?= $item->inicio; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Desbloq.
                                                    </a>
                                      
                                                    <? } ?>
                                            </td>
                                        </tr>  
                                    <? } elseif ($verifica == 7) {
                                        ?>
                                        <tr class="success2">
                                            <td><?= $situacao ?></td>
                                            <td colspan="3"><?= $item->paciente ?></td>
                                            <td><?= date("d/m/Y", strtotime($item->data)) ?></td>
                                            <td><?= date("H:i:s", strtotime($item->inicio)) ?></td>
                                            <td><?= date("H:i:s", strtotime($item->data_autorizacao)) ?></td>
                                            <td><?= substr($item->medicoagenda, 0, 15); ?></td>
                                            <td><?= $item->convenio ?></td>
                                            <td><?= $item->celular ?></td>
                                            <td ><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                                                                            width=500,height=230');">=><?= $item->observacoes; ?></a></td>
                                            <td class="tabela_acoes">

                                                <a class="btn btn-success btn-sm desbloq" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/desbloquear/<?= $item->agenda_exames_id ?>/<?= $item->inicio; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Desbloq. <i class="fa fa-unlock" aria-hidden="true"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    <? } elseif ($verifica == 2) { ?>
                                        <tr class="alert alert-aguardando">
                                            <td><?= $situacao ?></td>
                                            <td colspan="3"><?= $item->paciente ?></td>
                                            <td><?= date("d/m/Y", strtotime($item->data)) ?></td>
                                            <td><?= date("H:i:s", strtotime($item->inicio)) ?></td>
                                            <td><?= date("H:i:s", strtotime($item->data_autorizacao)) ?></td>
                                            <td><?= substr($item->medicoagenda, 0, 15); ?></td>
                                            <td><?= $item->convenio ?></td>
                                            <td><?= $item->celular ?></td>
                                            <td "><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                                                                            width=500,height=230');">=><?= $item->observacoes; ?></a></td>
                                            <td class="tabela_acoes">
                                                <? if ($perfil_id == 1 || $perfil_id == 4) { ?>

                                                    <a class="btn btn-danger btn-sm" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/guiacancelamento/<?= $item->agenda_exames_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>');">Cancelar <i class="fa fa-times" aria-hidden="true"></i>

                                                    </a>

                                                <? } else { ?>
                                                    <button class="btn btn-danger btn-sm" disabled="">Cancelar <i class="fa fa-times" aria-hidden="true"></i> </button> 
                                                <? }
                                                ?>
                                                <a class="btn btn-primary btn-sm" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarpacienteconsultatemp/<?= $item->paciente_id ?>/<?= $faltou; ?>');">Consultas <i class="far fa-calendar-alt"></i></a>
                                            </td>
                                        </tr>

                                    <? } elseif ($verifica == 3) { ?>
                                        <tr class="info">
                                            <td><?= $situacao ?></td>
                                            <td colspan="3"><?= $item->paciente ?></td>
                                            <td><?= date("d/m/Y", strtotime($item->data)) ?></td>
                                            <td><?= date("H:i:s", strtotime($item->inicio)) ?></td>
                                            <td><?= date("H:i:s", strtotime($item->data_autorizacao)) ?></td>
                                            <td><?= substr($item->medicoagenda, 0, 15); ?></td>
                                            <td><?= $item->convenio ?></td>
                                            <td><?= $item->celular ?></td>
                                            <td "><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                                                                            width=500,height=230');">=><?= $item->observacoes; ?></a></td>
                                            <td class="tabela_acoes">
                                                <? if ($perfil_id == 1 || $perfil_id == 4) { ?>

                                                    <a class="btn btn-danger btn-sm" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/guiacancelamento/<?= $item->agenda_exames_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>');">Cancelar <i class="fa fa-times" aria-hidden="true"></i>

                                                    </a>

                                                <? } else { ?>
                                                    <button class="btn btn-danger btn-sm" disabled="">Cancelar <i class="fa fa-times" aria-hidden="true"></i> </button> 
                                                <? }
                                                ?>
                                                <a class="btn  btn-primary btn-sm" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarpacienteconsultatemp/<?= $item->paciente_id ?>/<?= $faltou; ?>');">Consultas</a>
                                            </td>
                                        </tr>
                                    <? } elseif ($verifica == 4) { ?>
                                        <tr class="finalizado">
                                            <td><?= $situacao ?></td>
                                            <td colspan="3"><?= $item->paciente ?></td>
                                            <td><?= date("d/m/Y", strtotime($item->data)) ?></td>
                                            <td><?= date("H:i:s", strtotime($item->inicio)) ?></td>
                                            <td><?= date("H:i:s", strtotime($item->data_autorizacao)) ?></td>
                                            <td><?= substr($item->medicoagenda, 0, 15); ?></td>
                                            <td><?= $item->convenio ?></td>
                                            <td><?= $item->celular ?></td>
                                            <td "><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                                                                            width=500,height=230');">=><?= $item->observacoes; ?></a></td>
                                            <td class="tabela_acoes">
                                                <? if ($perfil_id == 1 || $perfil_id == 4) { ?>

                                                    <a class="btn btn-danger btn-sm" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/guiacancelamento/<?= $item->agenda_exames_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>');">Cancelar <i class="fa fa-times" aria-hidden="true"></i>

                                                    </a>

                                                <? } else { ?>
                                                    <button disabled="" class="btn btn-danger btn-sm">Cancelar <i class="fa fa-times" aria-hidden="true"></i> </button> 
                                                <? }
                                                ?>
                                                <a class="btn btn-primary btn-sm" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarpacienteconsultatemp/<?= $item->paciente_id ?>/<?= $faltou; ?>');">Consultas <i class="far fa-calendar-alt"></i></a>
                                            </td>
                                        </tr>
                                    <? } elseif ($verifica == 5) { ?>
                                        <tr class="atendendo">
                                            <td><?= $situacao ?></td>
                                            <td colspan="3"><?= $item->paciente ?></td>
                                            <td><?= date("d/m/Y", strtotime($item->data)) ?></td>
                                            <td><?= date("H:i:s", strtotime($item->inicio)) ?></td>
                                            <td><?= date("H:i:s", strtotime($item->data_autorizacao)) ?></td>
                                            <td><?= substr($item->medicoagenda, 0, 15); ?></td>
                                            <td><?= $item->convenio ?></td>
                                            <td><?= $item->celular ?></td>
                                            <td ><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                                                                            width=500,height=230');">=><?= $item->observacoes; ?></a></td>
                                            <td class="tabela_acoes">
                                                <a class="btn btn-outline-danger btn-sm" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/guiacancelamento/<?= $item->agenda_exames_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>');">Cancelar
                                                </a>
                                                <a class="btn btn-outline-primary btn-sm" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarpacienteconsultatemp/<?= $item->paciente_id ?>/<?= $faltou; ?>');">Consultas
                                                </a>

                                            </td>
                                        </tr>

                                        <?
                                    } elseif ($verifica == 6) {
                                        if ($faltou) {
                                            ?>
                                            <tr class="alert alert-danger">
                                            <? } else { ?>
                                            <tr class="alert alert-agendado">    
                                            <? } ?>
                                            <td><?= $situacao ?></td>
                                            <td colspan="3"><?= $item->paciente ?> <? if ($item->encaixe == 't') { ?>
                                                    <span class="text-danger">(Encaixe)</span>
                                                <? } ?></td>
                                            <td><?= date("d/m/Y", strtotime($item->data)) ?></td>
                                            <td><?= date("H:i:s", strtotime($item->inicio)) ?></td>
                                            <td>&nbsp;</td>
                                            <td><?= substr($item->medicoagenda, 0, 15); ?></td>
                                            <td><?= $item->convenio ?></td>
                                            <td><?= $item->celular ?></td>
                                            <td ><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                                                                            width=600,height=330');">=><?= $item->observacoes; ?></a></td>
                                            <td class="tabela_acoes text-center" style="width: 150pt;">
                                                <? if (date("d/m/Y") == date("d/m/Y", strtotime($item->data))) { ?>
                                                    <a class="btn btn-info btn-sm" onclick="javascript:window.open('<?= base_url() ?>cadastros/pacientes/procedimentoautorizarconsulta/<?= $item->paciente_id ?>');">Autorizar <i class="fa fa-user-md" aria-hidden="true"></i>

                                                    </a>

                                                <? } ?>
                                                <a class="btn btn-primary btn-sm <?
                                                if (date("d/m/Y") != date("d/m/Y", strtotime($item->data))) {
                                                    echo 'desbloq';
                                                }
                                                ?>" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarpacienteconsultatemp/<?= $item->paciente_id ?>/<?= $faltou; ?>');">Consultas</a>


                                            </td>
                                        </tr>

                                    <? } ?>

                                    <?php
                                }
                            }
                            ?>
                            <tr>
                                <th class="tabela_footer  btn-info" colspan="12">
                                    <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>

                                </th>
                            </tr>
                            <tr>
                                <th class="tabela_footer  btn-info" colspan="12">

                                    Total de registros: <?php echo $total; ?>
                                </th>
                            </tr>

                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
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
    ?>
</div> <!-- Final da DIV page-wrapper -->
<!-- <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script> -->
<script type="text/javascript">
                                                    $(document).ready(function () {

                                                        $(function () {
                                                            $('#especialidade').change(function () {

                                                                if ($(this).val()) {

//                                                  alert('teste_parada');
                                                                    $('.carregando').show();
//                                                        alert('teste_parada');
                                                                    $.getJSON('<?= base_url() ?>autocomplete/medicoespecialidade', {txtcbo: $(this).val(), ajax: true}, function (j) {
                                                                        options = '<option value=""></option>';
                                                                        console.log(j);

                                                                        for (var c = 0; c < j.length; c++) {


                                                                            if (j[0].operador_id != undefined) {
                                                                                options += '<option value="' + j[c].operador_id + '">' + j[c].nome + '</option>';

                                                                            }
                                                                        }
                                                                        $('#medico').html(options).show();
                                                                        $('.carregando').hide();



                                                                    });
                                                                } else {
                                                                    $('.carregando').show();
//                                                        alert('teste_parada');
                                                                    $.getJSON('<?= base_url() ?>autocomplete/medicoespecialidadetodos', {txtcbo: $(this).val(), ajax: true}, function (j) {
                                                                        options = '<option value=""></option>';
                                                                        console.log(j);

                                                                        for (var c = 0; c < j.length; c++) {


                                                                            if (j[0].operador_id != undefined) {
                                                                                options += '<option value="' + j[c].operador_id + '">' + j[c].nome + '</option>';

                                                                            }
                                                                        }
                                                                        $('#medico').html(options).show();
                                                                        $('.carregando').hide();



                                                                    });

                                                                }
                                                            });
                                                        });



                                                        $(function () {
                                                            $("#data").datepicker({
                                                                autosize: true,
                                                                changeYear: true,
                                                                changeMonth: true,
                                                                monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                                                                dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                                                                buttonImage: '<?= base_url() ?>img/form/date.png',
                                                                dateFormat: 'dd/mm/yy'
                                                            });
                                                        });

                                                        setTimeout('delayReload()', 20000);
                                                        function delayReload()
                                                        {
                                                            if (navigator.userAgent.indexOf("MSIE") != -1) {
                                                                history.go(0);
                                                            } else {
                                                                window.location.reload();
                                                            }
                                                        }

                                                    });


//                                                     $('#calendar').fullCalendar({
//                                                         header: {
//                                                             left: 'prev,next',
//                                                             center: 'title',
//                                                             right: 'today'
//                                                         },
//                                                         height: 500,
//                                                         dayRender: function (date, cell) {
//                                                             if ($('#data').val() == '') {
//                                                                 var data_escolhida = moment(new Date()).format('YYYY-MM-DD');
//                                                             } else {
//                                                                 var data_escolhida = $('#data').val();
//                                                             }

//                                                             var today = moment(new Date()).format('YYYY-MM-DD');
//                                                             var check = moment(date).format('YYYY-MM-DD');
// //            alert(data_escolhida);
// //            var today = $.fullCalendar.formatDate(new Date(), 'yyyy-MM-dd');
//                                                             if (data_escolhida == check && data_escolhida != today) {
//                                                                 cell.css("background-color", "#BCD2EE");
//                                                             }
//                                                         },
//                                                         dayClick: function (date) {
//                                                             var data = date.format();

//                                                             window.open('<?= base_url() ?>ambulatorio/exame/listarmultifuncaoconsulta?empresa=&especialidade=&medico=&situacao=&data=' + moment(data).format('DD%2FMM%2FYYYY') + '&nome=', '_self');



//                                                         },
//                                                         showNonCurrentDates: false,
//                                                         defaultDate: '<?= $data ?>',

//                                                         locale: 'pt-br',
//                                                         editable: false,
//                                                         eventLimit: true, // allow "more" link when too many events
//                                                         schedulerLicenseKey: 'CC-Attribution-Commercial-NoDerivatives',

//                                                         eventSources: [

//                                                             {
//                                                                 url: '<?= base_url() ?>autocomplete/listarhorarioscalendario',
//                                                                 type: 'POST',
//                                                                 data: {
//                                                                     medico: $('#medico').val(),
//                                                                     especialidade: $('#especialidade').val()
//                                                                 },
//                                                                 error: function () {
//                                                                     alert('there was an error while fetching events!');
//                                                                 }

//                                                             }


//                                                         ]

//                                                     });


                                                        var calendarEl = document.getElementById('calendar');
                                                                var calendar = new FullCalendar.Calendar(calendarEl, {
                                                                    headerToolbar : {
                                                                    left: 'prev,next',
                                                                    center: 'title',
                                                                    right: 'dayGridMonth'
                                                                    },
                                                                    schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
                                                                    initialView: 'dayGridMonth',
                                                                    selectable: true,
                                                                    selectionInfo:'allDay',
                                                                                                                                        
                                                                    
                                                                        dayCellContent: function (selectionInfo, cell) {
                                                                            // console.log(date);
                                                                            if ($('#data').val() == '') {
                                                                                var data_escolhida = moment(new Date()).format('DD/MM/YYYY');
                                                                                
                                                                            } else {
                                                                                var data_escolhida = $('#data').val();
                                                                            }
                                                                            // console.log(data_escolhida);
                                                                            var today = moment(new Date()).format('DD/MM/YYYY');
                                                                            var check =moment(Object.values(selectionInfo)[0]).format('DD/MM/YYYY');
                                                                            // console.log(today);
                                                                            //            alert(data_escolhida);
                                                                            //            var today = $.fullCalendar.formatDate(new Date(), 'yyyy-MM-dd');
                                                                           
                                                                            if (data_escolhida == check && data_escolhida != today) {
                                                                                backgroundColor: {
                                                                                   'red'
                                                                            }

                                                                                //  info.dayEl.style.backgroundColor = 'red';
                                                                            }
                                                                            // console.log('PASSOU');
                                                                        },
                                                                        dateClick: function (selectionInfo) {
                                                                            var data = selectionInfo.dateStr;
                                                                            // info.dayEl.style.backgroundColor = 'red';
                                                                            window.open('<?= base_url() ?>ambulatorio/exame/listarmultifuncaoconsulta?empresa=&especialidade=&medico=&situacao=&data=' + moment(data).format('DD%2FMM%2FYYYY') + '&nome=', '_self');
                                                                            // console.log(info);


                                                                        },
                                                                        showNonCurrentDates: false,
                                                                        defaultDate: '<?= $data ?>',
                                                                        initialView: 'dayGridMonth',
                                                                        locale: 'pt-br',
                                                                        editable: false,
                                                                        eventLimit: true, // allow "more" link when too many events
                                                                       
                                                                        eventSources: [

                                                                            {
                                                                                url: '<?= base_url() ?>autocomplete/listarhorarioscalendario',
                                                                                type: 'POST',
                                                                                data: {
                                                                                    medico: $('#medico').val(),
                                                                                    // especialidade: $('#especialidade').val()
                                                                                },
                                                                                error: function () {
                                                                                    alert('there was an error while fetching events!');
                                                                                }

                                                                            }


                                                                        ]


                                                                    
                                                                });
                                                                calendar.render();

</script>
