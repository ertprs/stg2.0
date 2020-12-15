
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url() ?>estoque/pedido/manterpedido/0">
            Novo Pedido
        </a>
    </div>
    <?
    $perfil_id = $this->session->userdata('perfil_id');
    ?>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Pedido</a></h3>
        <div>
            <form method="get" action="<?= base_url() ?>estoque/pedido/pesquisar">
                <fieldset>
                    <div class="row">
                        <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                        <button class="btn btn-outline-success btn-sm" type="submit" id="enviar">Pesquisar</button>
                    </div>
                </fieldset>

            </form>
            <br>
            <div class="table-responsive">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">

                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Pedido</th>
                        <th class="tabela_header">Data</th>
                        <!--<th class="tabela_header">Status</th>-->
                        <th class="tabela_header" width="70px;" colspan="3"><center>Detalhes</center></th>
                    </tr>
                    </thead>
                    <?php
                    $url = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->pedido->listar($_GET);
                    $total = $consulta->count_all_results();
                    $limit = 10;
                    isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                        ?>
                        <tbody>
                        <?php
                        $lista = $this->pedido->listar($_GET)->orderby('ep.data_cadastro desc')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {

                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->estoque_pedido_id ?> - <?= $item->descricao; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?></td>
                                <!--<td class="<?php echo $estilo_linha; ?>"><?= $item->situacao ?></td>-->
                                <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                    <div class="bt_link">
                                        <a class="btn btn-outline-success btn-sm" target="_blank" href="<?= base_url() ?>estoque/pedido/imprimirpedido/<?= $item->estoque_pedido_id ?>">Imprimir</a>
                                    </div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                    <div class="bt_link">
                                        <a class="btn btn-outline-default btn-sm" href="<?= base_url() ?>estoque/pedido/carregarpedido/<?= $item->estoque_pedido_id ?>">Cadastrar</a>
                                    </div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                    <div class="bt_link">
                                        <a class="btn btn-outline-danger btn-sm" onclick="javascript: return confirm('Deseja realmente exlcuir esse Pedido?');" href="<?= base_url() ?>estoque/pedido/excluir/<?= $item->estoque_pedido_id ?>">Excluir</a>
                                    </div>
                                </td>
                            </tr>

                            </tbody>
                            <?php
                        }
                    }
                    ?>
                    <tfoot>
                    <tr class="text-center pag">
                        <th class="tabela_footer pagination-container" colspan="6">
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

    $(function () {
        $("#accordion").accordion();
    });

</script>
