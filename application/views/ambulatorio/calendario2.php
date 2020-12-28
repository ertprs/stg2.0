<link href="<?= base_url() ?>bootstrap/vendor/bootstrap/css/bootstrap.css" rel="stylesheet"/>
<link href="<?= base_url() ?>bootstrap/assets/css/argon-design-system.css?v=1" rel="stylesheet"/>
<script  src="<?= base_url() ?>bootstrap/vendor/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<link href="<?= base_url() ?>bootstrap/fullcalendar/main.css" rel='stylesheet'/>
<script src="<?= base_url() ?>bootstrap/fullcalendar/main.js"></script>
<script src="<?= base_url() ?>bootstrap/fullcalendar/locales/pt-br.js"></script>
<script src="<?= base_url() ?>bootstrap/fullcalendar/interaction/main.min.js"></script>
<script src="<?= base_url() ?>bootstrap/fullcalendar/timegrid/main.js"></script>
<link src="<?= base_url() ?>bootstrap/fullcalendar/timegrid/main.min.css"/>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pt-BR">
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


    <div id="sala-de-espera" style="display: none;">

        <div id="sidebar-wrapper" class="sidebarteste">
            <div>
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

            <table>
                <tr>
                    <td>
                        <div class="btn_link_new">
                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/novopacienteencaixegeral');">
                                Encaixar Paciente
                            </a>
                        </div>
                        <? if (($perfil_id == 1 || $operador_id == 1) || $empresapermissoes[0]->btn_encaixe == 'f') { ?>
                        <div class="bt_link_new">
                            <button class="btn btn-outline-default btn-sm" id='btnEnaixe' class="btnTexto" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/novopacienteencaixegeral');">
                                Encaixar Paciente
                            </button>
                        </div>
                        <? } ?>

                    <? if($integrar_google == 't'){ ?>

                    <div class="bt_link_new">
                            <?if($logado_no_google == 0){?>
                                <button  onclick="javascript:window.location.href = '<?=$loginUrl?>' " class="btn btn-outline-default btn-sm">
                                    Sicronizar com Google
                                </button>
                            <?}else{?>
                                <button class="btn btn-outline-default btn-sm" href=''>
                                    Sicronizado Google
                                </button>
                            <?}?>
                        </div>
                    </td>

                    <? } ?>

            </table>

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
            <form method="get" action="<?= base_url() ?>ambulatorio/exame/listarmultifuncaocalendario2">
                <fieldset>
                    <br>
                    <div class="row">
                        <div class="col-lg-2">
                            <div>
                                <label>Grupo</label>
                                <select name="grupo" id="grupo" class="form-control" >
                                    <option value='' >TODOS</option>
                                    <? foreach ($grupos as $grupo) { ?>
                                        <option value='<?= $grupo->nome ?>' <?
                                        if (@$_GET['grupo'] == $grupo->nome):echo 'selected';
                                        endif;
                                        ?>><?= $grupo->nome ?></option>
                                    <? } ?>
                                </select>
                            </div>

                        </div>
                        <div class="col-lg-2">
                            <div>
                                <?php if($empresapermissoes[0]->filtrar_agenda_2 == "t") { ?>
                                    <label>Tipo Especialidade</label>
                                    <input type="hidden" id="medicoget" value="<?= ($this->session->userdata('perfil_id') == 4) ? $this->session->userdata('operador_id') : @$_GET['medico']  ?>">
                                    <select name="tipoagenda" id="tipoagenda" class="form-control">
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
                                <?php }else{?>
                                    <label>Sala</label>
                                    <select name="sala" id="sala" class="form-control">
                                        <option value="">TODOS</option>
                                        <? foreach ($salas as $value) : ?>
                                            <option value="<?= $value->exame_sala_id; ?>" <?
                                            if (@$_GET['sala'] == $value->exame_sala_id):echo 'selected';
                                            endif;
                                            ?>><?php echo $value->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Empresa</label>
                                <select name="empresa" id="empresa" class="form-control">
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
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div>
                                <label>Procedimento</label>
                                <select name="procedimento" id="procedimento" class="form-control" >
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
                            </div>
                        </div>
                        <? if ($empresapermissoes[0]->filtrar_agenda == 't') { ?>
                        <div class="col-lg-2">
                            <div>
                                <label>Situação</label>
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
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Status</label>
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
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label>Convênio</label>
                            <select name="convenio" id="convenio" class="size2">
                                <option value="">TODOS</option>
                                <? foreach ($convenio as $value) : ?>
                                    <option value="<?= $value->convenio_id; ?>" <?
                                    if (@$_GET['convenio'] == $value->convenio_id):echo 'selected';
                                    endif;
                                    ?>><?php echo $value->nome; ?></option>
                                <? endforeach; ?>
                            </select>
                        </div>
                        <? } ?>
                        <?php if($empresapermissoes[0]->filtrar_agenda_2 != "t"){?>
                        <div class="col-lg-4">
                            <div>
                                <label>Tipo Agenda</label>
                                <input type="hidden" id="medicoget" value="<?= ($this->session->userdata('perfil_id') == 4) ? $this->session->userdata('operador_id') : @$_GET['medico']  ?>">
                                <select name="tipoagenda" id="tipoagenda" class="form-control">
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
                            </div>
                        </div>
                        <? } ?>
                        <div class="col-lg-4">
                            <div>
                                <label>Médico</label>
                                <?php if ($this->session->userdata('perfil_id') == 4 && $medico_agenda_sessao == 't') { ?>
                                    <select name="medico" id="medico" class="form-control">
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
                                    <select name="medico" id="medico" class="form-control">
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
                            </div>
                        </div>
                        <?php if($empresapermissoes[0]->filtrar_agenda_2 == "t"){?>
                        <div class="col-lg-2">
                            <div>
                                <label>Status</label>
                                <select name="status" id="status" class="form-control">
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
                            </div>
                        </div>
                        <? } ?>
                        <?php if($empresapermissoes[0]->filtrar_agenda_2 == "t") {  ?>
                        <div class="col-lg-2">
                            <div>
                                <label>Convênio</label>
                                <select name="convenio" id="convenio" class="form-control">
                                    <option value="">TODOS</option>
                                    <? foreach ($convenio as $value) : ?>
                                        <option value="<?= $value->convenio_id; ?>" <?
                                        if (@$_GET['convenio'] == $value->convenio_id):echo 'selected';
                                        endif;
                                        ?>><?php echo $value->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Situação</label>
                                <select name="situacao" id="situacao" class="form-control">
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
                            </div>
                        </div>
                        <? } ?>
                        <div class="col-lg-4">
                            <div>
                                <label>Procurar por Mini-Curriculo</label>
                                <select name="curriculos" id="curriculos" class=" form-control chosen-select" data-placeholder="Selecione">
                                    <option value="">TODOS</option>
                                    <? foreach ($minicurriculos as $item) { ?>
                                        <option value='<?= $item->operador_id ?>' <?
                                        if(@$_GET['curriculos'] == $item->operador_id){ echo 'selected'; }
                                        ?>><?= $item->curriculo ?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div>
                                <label>Nome</label>
                                <input type="text" name="nome" id="nome" class="form-control bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <? if (@$_GET['data'] != '') { ?>
                                    <input type="hidden" name="data" id="data" class="form-control bestupper" value="<?php echo date("Y-m-d", strtotime(str_replace('/', '-', @$_GET['data']))); ?>" />
                                <? } else { ?>
                                    <input type="hidden" name="data" id="data" class="form-control bestupper" value="" />
                                <? } ?>
                            </div>
                        </div>
                        <?php if( $empresapermissoes[0]->filtrar_agenda_2 == 't'){?>
                        <div class="col-lg-2">
                            <div>
                                <label>Telefone</label>
                                <input type="text" name="txtTelefone" id="txtTelefone" class="form-control bestupper" value="<?= @$_GET['txtTelefone']; ?>" />
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Cpf</label>
                                <input type="text" name="txtCpf" id="txtCpf" class="form-control bestupper"  value="<?= @$_GET['txtCpf']; ?>"/>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Nascimento</label>
                                <input type="text" name="txtNascimento" id="txtNascimento" class="function bestupper" value="<?= @$_GET['txtNascimento']; ?>"/>
                            </div>
                        </div>

                        <? } ?>
                        <? if ($empresapermissoes[0]->filtrar_agenda == 't' ||  $empresapermissoes[0]->filtrar_agenda_2 == 't') { ?>
                            <div class="col-lg-4">
                                <label>Observação</label>
                                <input type="text" name="observacao" class="texto08 bestupper form-control" value="<?php echo @$_GET['observacao']; ?>" />
                            </div>
                        <? } ?>






                    </div>
                    <br>
                    <div class="btn-group-sm">
                        <button class="btn btn-outline-default" type="submit" id="enviar">Pesquisar</button>
                        <button class="btn btn-outline-default" id="botaosala">S/ de Espera</button>
                        <? if (($perfil_id == 1 || $operador_id == 1) || $empresapermissoes[0]->btn_encaixe == 'f') { ?>
                            <button class="btn btn-outline-default" value="encaixar" id="encaixar">Encaixar Horário</button>
                        <? } ?>
                    </div>
                </fieldset>

            </form>

<!--            <div id='calendar'></div>-->


                <div class="calendar">
                    <div id="calendar"></div>
                </div>
            <br><br>
            <table>
                <tr>
                    <td>
                        <table>
                            <thead>
                                <tr>
                                    <th class="tabela_header" width="80px;">Empresa</th>
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

                    <?php
//                        var_dump($item->situacaoexame);
//                        die;
                    $estilo_linha = "tabela_content01";
                    foreach ($lista as $item) {
                        
                        
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
                            <td class="<?php echo $estilo_linha; ?>">
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
                            <td class="<?php echo $estilo_linha; ?>"><font color="<?= $cor ?>"><b><?= $item->paciente; ?></b></td>
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
                                ?>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <div class="bt_link_new" style="width: 90px;">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarexamegeral/<?= $item->agenda_exames_id ?>/<?= $item->medico_agenda ?>');">Agendar
                                        </a>


                                    </div>
                                </td>
                                <?
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

                        </tbody>
                        <?php
                    }
                }
                ?>
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
<div class="modal fade" id="agendamentoModal" tabindex="-1" role="dialog" aria-labelledby="agendamentoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert alert-primary">
                <h5 class="modal-title" id="agendamentoModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row divError">
                    <div class="col">
                        <div class="alert alert-danger">
                            <strong>Opa!</strong> Tem um problema com os dados inseridos.<br>
                            <ul class="ulError">
                                <li class="liError">aaaa</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Paciente:</strong>
                            <input type="text" name="paciente" id="paciente" value="" class="form-control @error('paciente') is-invalid @enderror" placeholder="Paciente">
                            <input type="hidden" name="paciente_id" id="paciente_id" value="" class="">


                            <input type="hidden" name="id" id="id" value="" class="">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <strong>Início:</strong>
                        <div class="form-group">
                            <input type="datetime-local" name="start" id="start" value="" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <strong>Fim:</strong>
                        <div class="form-group">
                            <input type="datetime-local" name="end" id="end" value="" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Médico:</strong>
                            <select name="medico_id" id="medico_id" class="form-control">
                                <option value="">Selecione</option>
                                @foreach ($medicos as $item)
                                <option value="{{ $item->id }}" >{{ $item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Sala:</strong>
                            <select name="sala_id" id="sala_id" class="form-control">
                                <option value="">Selecione</option>
                                @foreach ($salas as $item)
                                <option value="{{ $item->id }}" >{{ $item->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Plano:</strong>
                            <select name="plano_id" id="plano_id" class="form-control">
                                <option value="">Selecione</option>
                                @foreach ($planos as $item)
                                <option value="{{ $item->id }}" >{{ $item->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Procedimento:</strong>
                            <select name="procedimento_id" id="procedimento_id" class="form-control">
                                <option value="">Selecione</option>
                                @foreach ($procedimentos as $item)
                                <option value="{{ $item->id }}" >{{ $item->nome_abr}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Ordenador:</strong>
                            <select name="prioridade" id="prioridade" class="form-control">
                                <option value="">Selecione</option>
                                <option value="1">Normal</option>
                                <option value="2">Prioridade</option>
                                <option value="3">Emergência</option>

                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary adicionarModal" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success adicionarModal"  onclick="newEvent();">Agendar</button>


                <button type="button" class="btn btn-secondary editarModal" data-dismiss="modal">Fechar</button>
                {{-- <button type="button" class="btn btn-info editarModal" onclick="historicoAtendimento();">Histórico</button> --}}
                <a id="botaoAtender" target="_blank" href="" class="editarModalAtendimento"><button type="button" class="btn btn-primary " onclick="editarAtendimento();">Atender</button></a>
                <button type="button" class="btn btn-success editarModal" onclick="editarEventoModal();">Salvar</button>
                <button type="button" class="btn btn-danger editarModal" data-dismiss="modal" onclick="deleteEvent()">Excluir</button>

            </div>
            <form id="editar_atendimento" action="{{ route('atendimento.create')}}" method="GET" target="_blank">
                {{-- <a class="btn btn-info" href="{{ route('sala.show',$item->id) }}">Show</a> --}}
                <input type="hidden" name="id_atender" id="id_atender" value="" class="">
            </form>

            <form id="historico_atendimento" action="{{ route('historicoAtendimento')}}" method="GET" target="_blank">
                {{-- <a class="btn btn-info" href="{{ route('sala.show',$item->id) }}">Show</a> --}}
                <input type="hidden" name="paciente_h_id" id="paciente_h_id" value="" class="">
            </form>
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
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script>
    function abrirModal(info){
        $('.divError').hide();
        $('.liError').remove();
        $('.editarModal').hide();
        $('.editarModalAtendimento').hide();

        $('.adicionarModal').show();
        var titulo = 'Agendar';
        var dataInicio = info.start.toLocaleDateString('pt-BR');
        var dataFim = info.end.toLocaleDateString('pt-BR');
        var horaInicio = info.start.toLocaleTimeString('pt-BR');
        var horaFim = info.end.toLocaleTimeString('pt-BR');
        var isoStart = new Date(info.start.getTime() - (info.start.getTimezoneOffset() * 60000)).toISOString().slice(0,16);
        var isoEnd = new Date(info.end.getTime() - (info.end.getTimezoneOffset() * 60000)).toISOString().slice(0,16);
        if(dataInicio == dataFim){
            titulo = dataInicio + ' : ' + horaInicio + ' - ' + horaFim;
        }else{
            titulo = dataInicio + ' - ' + dataFim;
        }
        $('#agendamentoModal').modal();
        $('#agendamentoModalLabel').text(titulo);
        $('#start').val(isoStart);
        $('#end').val(isoEnd);
        // console.log(info);
        // console.log(info.end.toISOString().slice(0,16));
    }

    $('#agendamentoModal').on('hidden.bs.modal', function () {
        $('#agendamentoModalLabel').text('Agendar');
        $('#start').val('');
        $('#end').val('');
        $('#paciente').val('');
        $('#paciente_id').val('');
        $('#sala_id').val('');
        $('#medico_id').val('');
        $('#plano_id').val('');
        $('#procedimento_id').val('');
        $('#id').val('');
        $('#prioridade').val('');
        // $('#color').val('#3490dc');
    });

    function moveEvent(info){

        var dataInicio = info.event.start.toLocaleDateString('pt-BR');
        var dataFim = info.event.end.toLocaleDateString('pt-BR');
        var horaInicio = info.event.start.toLocaleTimeString('pt-BR');
        var horaFim = info.event.end.toLocaleTimeString('pt-BR');
        var id = info.event.id;

        let route = "{{route('moveEvent')}}";
        let data = {
            _token: $('input[name=_token]').val(),
            start: dataInicio + ' ' + horaInicio,
            end: dataFim + ' ' + horaFim,
            id: id
        }
        sendRequest(route, data, 'POST');
    }

    function updateEvent(info){

        var dataInicio = info.event.start.toLocaleDateString('pt-BR');
        var dataFim = info.event.end.toLocaleDateString('pt-BR');
        var horaInicio = info.event.start.toLocaleTimeString('pt-BR');
        var horaFim = info.event.end.toLocaleTimeString('pt-BR');
        var id = info.event.id;

        let route = "{{route('updateEvent')}}";
        let data = {
            _token: $('input[name=_token]').val(),
            start: dataInicio + ' ' + horaInicio,
            end: dataFim + ' ' + horaFim,
            id: id
        }
        sendRequest(route, data, 'POST');
    }

    function deleteEvent(){
        let route = "{{route('deleteEvent')}}";
        let data = {
            _token: $('input[name=_token]').val(),
            id: $('#id').val()
        }
        swal({
            title: "Tem certeza?",
            text: 'Você está prestes a excluir um agendamento',
            icon: "warning",
            buttons: {
                cancel: {
                    text: "Cancelar",
                    value: false,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "Sim",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: true
                }
            },
            dangerMode: true,
        })
            .then((deletar) => {
                if (deletar) {
                    sendRequest(route, data, 'POST');
                }
            });
    }

    function newEvent(){
        let route = "{{route('agendamento.store')}}";
        let data = {
            _token: $('input[name=_token]').val(),
            start: $('#start').val(),
            end: $('#end').val(),
            paciente: $('#paciente').val(),
            paciente_id: $('#paciente_id').val(),
            sala_id: $('#sala_id').val(),
            medico_id: $('#medico_id').val(),
            plano_id: $('#plano_id').val(),
            procedimento_id: $('#procedimento_id').val(),
            id: $('#id').val(),
            // color: $('#color').val(),
            prioridade: $('#prioridade').val(),
        }
        sendRequest(route, data, 'POST');
    }

    function editarEventoModal(){
        let route = "{{route('updateEvent')}}";
        let data = {
            _token: $('input[name=_token]').val(),
            start: $('#start').val(),
            end: $('#end').val(),
            paciente: $('#paciente').val(),
            paciente_id: $('#paciente_id').val(),
            title: $('#paciente').val(),
            nome: $('#paciente').val(),
            sala_id: $('#sala_id').val(),
            medico_id: $('#medico_id').val(),
            plano_id: $('#plano_id').val(),
            procedimento_id: $('#procedimento_id').val(),
            id: $('#id').val(),
            // color: $('#color').val(),
            prioridade: $('#prioridade').val(),
        }
        sendRequest(route, data, 'POST');
    }


    function abrirEvento(info){
        $('.divError').hide();
        $('.liError').remove();
        $('.editarModal').show();

        var title = info.event.title
        console.log(title.length);
        if(title.length > 4){
            $('.editarModalAtendimento').show();
        }else{
            $('.editarModalAtendimento').hide();
        }

        $('.adicionarModal').hide();
        var id = info.event.id;

        let route = "{{route('getEvent')}}";
        let data = {
            _token: $('input[name=_token]').val(),
            id: id
        }
        sendRequest(route, data, 'GET');
    }

    function alterarModal(info){
        var start = new Date(info.start);
        var end = new Date(info.end);
        var isoStart = new Date(start.getTime() - (start.getTimezoneOffset() * 60000)).toISOString().slice(0,16);
        var isoEnd = new Date(end.getTime() - (end.getTimezoneOffset() * 60000)).toISOString().slice(0,16);
        var dataInicio = start.toLocaleDateString('pt-BR');
        var dataFim = end.toLocaleDateString('pt-BR');
        var horaInicio = start.toLocaleTimeString('pt-BR');
        var horaFim = end.toLocaleTimeString('pt-BR');
        if(dataInicio == dataFim){
            titulo = dataInicio + ' : ' + horaInicio + ' - ' + horaFim;
        }else{
            titulo = dataInicio + ' - ' + dataFim;
        }

        var url = '{{ route("atendimento.edit", ":id")}}';
        url = url.replace(':id', info.id);
        $('#botaoAtender').attr("href", url);
        $('#agendamentoModalLabel').text(titulo);
        $('#start').val(isoStart);
        $('#end').val(isoEnd);
        $('#paciente').val(info.title);
        $('#paciente_id').val(info.paciente_id);
        $('#sala_id').val(info.sala_id);
        $('#medico_id').val(info.medico_id);
        $('#plano_id').val(info.plano_id);
        $('#procedimento_id').val(info.procedimento_id);
        $('#id').val(info.id);
        $("#id_atender").val(info.id);
        $("#paciente_h_id").val(info.paciente_id);
        // $('#color').val(info.color);
        $('#prioridade').val(info.prioridade);
        $('#agendamentoModal').modal();
    }
</script>
<script>



    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            selectable: true,
            editable: true,
            weekNumbers: false,
            buttonIcons: false,
            locale: 'pt-br',
            dayMaxEvents: true, // allow "more" link when too many events
            slotMinTime: '06:00:00',
            showNonCurrentDates: false,
            headerToolbar : {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            initialView: 'timeGridWeek',
            events:"<? echo base_url() ?>ambulatorio/exame/listarmultifuncaoconsulta",
            eventColor: '#b5baff',
            nowIndicator: true,
            select: function(info) {
                // console.log(info);
                abrirModal(info);
            },
            dayCellContent: function (selectionInfo, cell) {

            },
            eventDrop: function(info) {
                // alert(info.event.title + " was dropped on " + info.event.start.toISOString());
                swal({
                    title: "Tem certeza?",
                    text: 'Você está prestes a mover um agendamento',
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "Cancelar",
                            value: false,
                            visible: true,
                            className: "",
                            closeModal: true,
                        },
                        confirm: {
                            text: "Sim",
                            value: true,
                            visible: true,
                            className: "",
                            closeModal: true
                        }
                    },
                    // dangerMode: true,
                })
                    .then((mover) => {
                        if (!mover) {
                            info.revert();
                        }else{
                            moveEvent(info);
                        }
                    });
            },
            eventResize: function(info) {
                // alert(info.event.title + " was dropped on " + info.event.start.toISOString());
                swal({
                    title: "Tem certeza?",
                    text: 'Você está prestes a alterar um agendamento',
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "Cancelar",
                            value: false,
                            visible: true,
                            className: "",
                            closeModal: true,
                        },
                        confirm: {
                            text: "Sim",
                            value: true,
                            visible: true,
                            className: "",
                            closeModal: true
                        }
                    },
                    // dangerMode: true,
                })
                    .then((mover) => {
                        if (!mover) {
                            info.revert();
                        }else{
                            moveEvent(info);
                        }
                    });
            },

            eventClick: function(info) {
                info.jsEvent.preventDefault(); // don't let the browser navigate
                info.dayEl.style.backgroundColor = 'lightblue';
                if (info.event.url) {
                    window.open(info.event.url);
                }
            },
            eventSources: [

                {
                    url: '<?= base_url() ?>autocomplete/listarhorarioscalendario',
                    type: 'POST',
                    error: function () {
                        alert('there was an error while fetching events!');
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
                                            if ($('#nome').val() != '') {
                                                var paciente = '<?= $nome ?>';
                                            } else {
                                                var paciente = '';
                                            }
//    alert('<?= $sala_atual ?>');


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


