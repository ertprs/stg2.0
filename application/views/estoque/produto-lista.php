
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url() ?>estoque/produto/carregarproduto/0">
            Novo Produto
        </a>
        <?
        $perfil_id = $this->session->userdata('perfil_id');
        ?>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Produto</a></h3>
        <div>
            <form method="get" action="<?= base_url() ?>estoque/produto/pesquisar">
                <fieldset>
                    <div class="row">
                        <input type="text" name="nome" class="texto07 bestupper form-control" value="<?php echo @$_GET['nome']; ?>" />
                        <button class="btn btn-outline-success btn-sm" type="submit" id="enviar">Pesquisar</button>
                    </div>
                </fieldset>
            </form>
            <br>
            <div class="table-responsive">
                <table width="100%" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Unidade</th>
                        <th class="tabela_header">Sub-classe</th>
                        <th class="tabela_header">Valor</th>
                        <th class="tabela_header" width="70px;" colspan="2"><center>Detalhes</center></th>
                    </tr>
                    </thead>
                    <?php
                    $url = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->produto->listar($_GET);
                    $total = $consulta->count_all_results();
                    $limit = 10;
                    isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                        ?>
                        <tbody>
                        <?php
                        $lista = $this->produto->listar($_GET)->orderby('p.descricao')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->unidade; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->sub_classe; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor_compra, 2, ',', '.'); ?></td>
                                <?if($perfil_id != 10){?>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                        <a class="btn btn-outline-default btn-sm" href="<?= base_url() ?>estoque/produto/carregarproduto/<?= $item->estoque_produto_id ?>">Editar</a>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                        <a class="btn btn-outline-danger btn-sm" onclick="javascript: return confirm('Deseja realmente exlcuir esse Produto?');" href="<?= base_url() ?>estoque/produto/excluir/<?= $item->estoque_produto_id ?>">Excluir</a>
                                    </td>
                                <?}else{?>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                        Editar
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                        Excluir
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
                        <th class="tabela_footer pagination-containerpagination-container" colspan="6">
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
