
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url() ?>ambulatorio/sala/carregarsala/0">
            Nova Sala
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Salas de Exames</a></h3>
        <div>
            <form method="get" action="<?= base_url() ?>ambulatorio/sala/pesquisar">
                <fieldset>
                    <div class="row">
                        <div class="col-lg-4">
                            <input type="text" name="nome" class="texto10 bestupper form-control" value="<?php echo @$_GET['nome']; ?>" />
                            <button class="btn btn-outline-success btn-sm" type="submit" id="enviar">Pesquisar</button>
                        </div>
                    </div>
                </fieldset>
            </form>
            <div class="table-responsive">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th class="tabela_header">Nome</th>
                            <!--<th class="tabela_header">Tipo</th>-->
                            <th class="tabela_header" colspan="8">Detalhes</th>
                        </tr>
                    </thead>
                    <?php
                        $empresapermissoes = $this->guia->listarempresapermissoes();
                        $botao_ativar_sala = $empresapermissoes[0]->botao_ativar_sala;
                        $perfil_id = $this->session->userdata('perfil_id');
                        $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                        $consulta = $this->sala->listar($_GET);
                        $total    = $consulta->count_all_results();
                        $limit    = 10;
                        isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                        if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                            $lista = $this->sala->listar($_GET)->limit($limit, $pagina)->orderby("nome")->get()->result();
                            $estilo_linha = "tabela_content01";
                            foreach ($lista as $item) {
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                         ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <!--<td class="<?php echo $estilo_linha; ?>"><?= $item->tipo; ?></td>-->

                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                    <a class="btn btn-outline-warning btn-sm" href="<?= base_url() ?>ambulatorio/sala/carregarsala/<?= $item->exame_sala_id ?>">Editar</a></div>
                                </td>
                                <?if ($botao_ativar_sala == "t"){?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a class="btn btn-outline-default btn-sm" href="<?= base_url() ?>ambulatorio/sala/ativar/<?= $item->exame_sala_id ?>">Ativar</a></div>
                                    </td>
                                <?}?>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                    <a class="btn btn-outline-default btn-sm" href="<?= base_url() ?>ambulatorio/sala/carregarsalagrupo/<?= $item->exame_sala_id ?>">Grupo</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                    <a class="btn btn-outline-info btn-sm" href="<?= base_url() ?>ambulatorio/sala/carregarsalapainel/<?= $item->exame_sala_id ?>">Painel</a></div>
                                </td>
                                <?php if($perfil_id != 18 && $perfil_id != 20){ ?>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                    <a class="btn btn-outline-danger btn-sm" href="<?= base_url() ?>ambulatorio/sala/excluirsala/<?= $item->exame_sala_id ?>">Excluir</a></div>
                                </td>
                                <?}?>
                            </tr>
                            </tbody>
                            <?php
                                    }
                                }
                            ?>
                            <tfoot>
                                <tr class="text-center pag">
                                    <th class="tabela_footer pagination-container" colspan="7">
                                       <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                                Total de registros: <?php echo $total; ?>
                                    </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
    });

</script>
