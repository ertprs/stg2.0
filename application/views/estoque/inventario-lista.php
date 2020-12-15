
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url() ?>estoque/inventario/carregarinventario/0">
            Novo Inventario
        </a>
        <?
        $perfil_id = $this->session->userdata('perfil_id');
        ?>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Inventario</a></h3>
        <div>
             <form method="get" action="<?= base_url() ?>estoque/inventario/pesquisar">
                 <fieldset>
                     <div class="row">
                         <div class="col-lg-2">
                             <div>
                                 <label>Produto</label>
                                 <input class="form-control" type="text" name="produto" value="<?php echo @$_GET['produto']; ?>" />
                             </div>
                         </div>
                         <div class="col-lg-2">
                             <div>
                                <label>Fornecedor</label>
                                 <input class="form-control" type="text" name="fornecedor" value="<?php echo @$_GET['fornecedor']; ?>" />
                             </div>
                         </div>
                         <div class="col-lg-2">
                             <div>
                                <label>Nota</label>
                                 <input class="form-control" type="text" name="nota" value="<?php echo @$_GET['nota']; ?>" colspan="2"/>
                             </div>
                         </div>
                     </div>
                 </fieldset><br>
                 <button class="btn btn-outline-success btn-sm" type="submit" id="enviar">Pesquisar</button>
                <br><br>
             </form>
            <div class="table-responsive">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <tr>
                        <th class="tabela_header">Produto</th>
                        <th class="tabela_header">Fornecedor</th>
                        <th class="tabela_header">Armazem</th>
                        <th class="tabela_header">Quantidade</th>
                        <th class="tabela_header">Nota</th>
                        <th class="tabela_header" width="70px;" colspan="3"><center>Detalhes</center></th>
                    </tr>

                    <?php
                    $url = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->inventario->listar($_GET);
                    $total = $consulta->count_all_results();
                    $limit = 10;
                    isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                        ?>
                        <tbody>
                            <?php
                            $lista = $this->inventario->listar($_GET)->limit($limit, $pagina)->get()->result();
                            $estilo_linha = "tabela_content01";
                            foreach ($lista as $item) {
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->produto; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->fantasia; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->armazem; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->quantidade; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->nota_fiscal; ?></td>
                                    <? if ($perfil_id != 10) { ?>


                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                                <a href="<?= base_url() ?>estoque/inventario/carregarinventario/<?= $item->estoque_entrada_id ?>">Editar</a></div>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"> <div class="bt_link">
                                                <a onclick="javascript: return confirm('Deseja realmente exlcuir esse Entrada?');" href="<?= base_url() ?>estoque/inventario/excluir/<?= $item->estoque_entrada_id ?>">Excluir</a></div>
                                        </td>
                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                                Editar</div>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"> <div class="bt_link">
                                                Excluir</div>
                                        </td>
                                    <? }
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                            <a href="<?= base_url() ?>estoque/inventario/anexarimagementrada/<?= $item->estoque_entrada_id ?>">Arquivos</a></div>
                                    </td>
                                </tr>

                            </tbody>
                            <?php
                        }
                    }
                    ?>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="8">
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
