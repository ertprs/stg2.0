<div class="content"> <!-- Inicio da DIV content -->
    <?
    $empresa_id = $this->session->userdata('empresa_id');
    $perfil_id = $this->session->userdata('perfil_id');
    $operador_id = $this->session->userdata('operador_id');
    $empresapermissoes = $this->guia->listarempresapermissoes($empresa_id);
    $filtro_exame = @$empresapermissoes[0]->filtro_exame_cadastro;
    $tecnico_recepcao_editar = @$empresapermissoes[0]->tecnico_recepcao_editar;
    $valores_recepcao = @$empresapermissoes[0]->valores_recepcao;
    ?>
    <table>
        <tr> 
            <?
            if (!(($empresapermissoes[0]->tecnico_acesso_acesso == 't' && $this->session->userdata('perfil_id') == 7) || ($empresapermissoes[0]->tecnico_acesso_acesso == 't' && $this->session->userdata('perfil_id') == 15) || $this->session->userdata('perfil_id') == 24 )) {
                ?>
                <td width="20px;">
                    <div class="bt_link" style="width: 110pt">
                        <a href="<?php echo base_url() ?>cadastros/pacientes/novo" style="width: 100pt">
                            Novo Cadastro
                        </a>
                    </div>
                </td>
            <?
            }  
            ?> 
            <!--            
                        <td width="100px;"><center>
                            <div class="bt_link_new">
                                <a href="<?php echo base_url() ?>ambulatorio/exametemp/novopaciente">
                                    Agendar Exame
                                </a>
                            </div>
                            </td>
                            <td width="100px;"><center>
                                <div class="bt_link_new">
                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/novopacienteexameencaixe');">
                                        Encaixar Exame
                                    </a>
                                </div>
                                </td>
                                <td width="100px;"><center>
                                    <div class="bt_link_new">
                                        <a href="<?php echo base_url() ?>ambulatorio/exametemp/novopacienteconsulta">
                                            Agendar Consulta
                                        </a>
                                    </div>
                                    </td>
            
                                    <td width="100px;"><center>
                                        <div class="bt_link_new">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/novopacienteconsultaencaixe');">
                                                Encaixar Consulta
                                            </a>
                                        </div>
                                        </td>-->

    </table>

    <div id="accordion">
        <h3><a href="#">Manter pacientes</a></h3>
        <div>

            <table >
                <thead>
                    <tr>



                        <th class="tabela_title" >Nome</th>
                        <?php
                        if (@$empresapermissoes[0]->pesquisar_responsavel == "t") {
                            ?>
                            <th class="tabela_title" >Nome da Mãe </th>
                            <th class="tabela_title" >Nome do Pai </th>
                            <?php
                        }
                        ?>



                        <? if ($filtro_exame == 't') { ?>
                            <th class="tabela_title" >Exame</th>
                        <? } ?>
                        <th class="tabela_title" >CPF</th>
                        <th class="tabela_title" >Nascimento</th>
                        <th class="tabela_title" >Telefone</th>                        
                        <th class="tabela_title" >Prontuario</th>

                        <?
                        $data['retorno_permissao'] = $this->guia->listarpermissaopoltrona();
                        if ($data['retorno_permissao'][0]->prontuario_antigo == 't') {
                            ?>

                            <th class="tabela_title" >Prontuario Antigo</th>

                            <?
                        } else {
                            
                        }
                        ?>

                        <th class="tabela_title" colspan ="3" ></th>


                    </tr>
                    <tr>
                <form method="get" action="<?php echo base_url() ?>cadastros/pacientes/pesquisar">

                    <th class="tabela_title" colspan="">
                        <input type="text" name="nome" class="texto03" value="<?php echo @$_GET['nome']; ?>" />
                    </th>

                    <?php
                    if (@$empresapermissoes[0]->pesquisar_responsavel == "t") {
                        ?>
                        <th class="tabela_title" colspan="">
                            <input type="text" name="nome_mae" class="texto03" value="<?php echo @$_GET['nome_mae']; ?>" />
                        </th>
                        <th class="tabela_title" colspan="">
                            <input type="text" name="nome_pai" class="texto03" value="<?php echo @$_GET['nome_pai']; ?>" />
                        </th>  
                        <?php
                    }
                    ?>


                    <? if ($filtro_exame == 't') { ?>
                        <th class="tabela_title" colspan="">
                            <input type="text" name="guia_id" class="texto02" value="<?php echo @$_GET['guia_id']; ?>" />
                        </th>
                    <? } ?>
                    <th class="tabela_title" colspan="">
                        <input type="text" name="cpf" class="texto02" value="<?php echo @$_GET['cpf']; ?>" />
                    </th>
                    <th class="tabela_title" colspan="">
                        <input type="text" name="nascimento" class="texto02" alt="date" value="<?php echo @$_GET['nascimento']; ?>" />
                    </th>
                    <th class="tabela_title" colspan="">
                        <input type="text" name="telefone" class="texto02" value="<?php echo @$_GET['telefone']; ?>" />
                    </th>
                    <th class="tabela_title" colspan="">
                        <input type="text" name="prontuario" class="texto01" value="<?php echo @$_GET['prontuario']; ?>" />
                    </th>

                    <?
                    if ($data['retorno_permissao'][0]->prontuario_antigo == 't') {
                        ?>
                        <th class="tabela_title" colspan="">
                            <input type="text" name="prontuario_antigo" class="texto01" value="<?php echo @$_GET['prontuario_antigo']; ?>" />
                        </th>
                        <?
                    } else {
                        
                    }
                    ?>
                    <th class="tabela_title" colspan="">
                        <button type="submit" name="enviar">Pesquisar</button>
                    </th>




                </form>
                </th>
                </tr>

                <tr>

                    <th class="tabela_header" colspan="2">Nome</th>
                    <? if ($filtro_exame == 't') { ?>
                        <th class="tabela_header"></th>
                    <? } ?>
                    <th class="tabela_header">CPF</th>
                    <th class="tabela_header" width="100px;">Nascimento</th>
                    <th class="tabela_header" width="100px;">Telefone</th>
                    <th class="tabela_header">Prontuario</th>
                    <th class="tabela_header" colspan="4"  width="70px;"><center>A&ccedil;&otilde;es</center></th>

                </tr>
                </thead>
                <?php
                $imagem = $empresapermissoes[0]->imagem;
                $consulta = $empresapermissoes[0]->consulta;

                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->paciente->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->paciente->listar($_GET)->orderby('nome')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            if ($item->celular == "") {
                                $telefone = $item->telefone;
                            } else {
                                $telefone = $item->celular;
                            }
                            ?>
                            <tr>

                                <td class="<?php echo $estilo_linha; ?>" colspan="2"><?php echo $item->nome; ?></td>
                                <? if ($filtro_exame == 't') { ?>
                                    <td class="<?php echo $estilo_linha; ?>"></td>
                                <? } ?>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->cpf; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><?php echo substr($item->nascimento, 8, 2) . '/' . substr($item->nascimento, 5, 2) . '/' . substr($item->nascimento, 0, 4); ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><?php echo $telefone; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->paciente_id; ?></td>


                                <?
                                if (($empresapermissoes[0]->tecnico_acesso_acesso == 't' && $this->session->userdata('perfil_id') == 7) || ($empresapermissoes[0]->tecnico_acesso_acesso == 't' && $this->session->userdata('perfil_id') == 15)) {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;" colspan="2" >

                                    <? } else {
                                        ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;" colspan="0" >  
                                        <?
                                    }
                                    ?>
                                    <?
                                    if (($empresapermissoes[0]->tecnico_acesso_acesso == 't' && $this->session->userdata('perfil_id') == 7) || ($empresapermissoes[0]->tecnico_acesso_acesso == 't' && $this->session->userdata('perfil_id') == 15)) {
                                        ?>
                                        <div class="bt_link" >
                                            <a href="<?= base_url() ?>cadastros/pacientes/visualizarcarregar/<?= $item->paciente_id ?>">
                                                <b>Visualizar</b>
                                            </a>
                                        </div> 

                                        <?
                                    } else {
                                        ?>                     

                                        <? if (($tecnico_recepcao_editar == 't' || $perfil_id != 15) && $perfil_id != 24) { ?>
                                            <div class="bt_link">
                                                <a href="<?= base_url() ?>cadastros/pacientes/carregar/<?= $item->paciente_id ?>">
                                                    <b>Editar</b>
                                                </a>
                                            </div>
                                        <? } else { ?>
                                            <div class="bt_link">
                                                <a href="<?= base_url() ?>cadastros/pacientes/visualizarcarregar/<?= $item->paciente_id ?>">
                                                    <b>Visualizar</b>
                                                </a>
                                            </div>
                                        <? } ?>

                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                            <a href="<?= base_url() ?>emergencia/filaacolhimento/novo/<?= $item->paciente_id ?>">
                                                <b>Op&ccedil;&otilde;es</b>
                                            </a></div>
                                    </td>

                                        
                                    <?php 
                                    if($valores_recepcao == 't' || $operador_id == 1 ){
                                    if($this->session->userdata('perfil_id') != 24){?>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                            <a href="<?= base_url() ?>ambulatorio/guia/orcamento/<?= $item->paciente_id ?>">
                                                <b>Or&ccedil;amento</b>
                                            </a></div>
                                    </td>
                                                <?php }
                                                
                                    }?>

                                    <?
                                }
                                ?>


                                                        <!--                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                                                <a href="<?= base_url() ?>cadastros/pacientes/procedimentoautorizar/<?= $item->paciente_id ?>">
                                                                    <b>Autorizar</b>
                                                                </a></div>
                                                        </td>-->
                                                        <!--                                                                <td class="<?php echo $estilo_linha; ?>" width="50px;" ><div class="bt_link">
                                                                <a href="<?= base_url() ?>cadastros/pacientes/carregar/<?= $item->paciente_id ?>">
                                                                    <b>Autorizar</b>
                                                                </a></div>
                                                        </td>-->
                            </tr>
                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="9">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


</div>





<!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

</script>