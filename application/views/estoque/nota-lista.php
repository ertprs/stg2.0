
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>
            <td style="width: 200px;">
                <div class="bt_link_new">
                    <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url() ?>estoque/nota/carregarnota/0">
                        Nova Nota Fiscal
                    </a>
                    <?
                    $perfil_id = $this->session->userdata('perfil_id');
                    ?>
                </div> 
            </td>

        </tr>
    </table>


    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Nota Fiscal</a></h3>
        <div>
            <form method="get" action="<?= base_url() ?>estoque/nota/pesquisar">
                <fieldset>
                    <div class="row">
                        <div class="col-lg-2">
                            <div>
                                <label>Nota</label>
                                <input type="text" name="nota" value="<?php echo @$_GET['nota']; ?>" class="form-control"/>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Fornecedor</label>
                                <input type="text" name="fornecedor" value="<?php echo @$_GET['fornecedor']; ?>" class="form-control"/>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Armazem</label>
                                <input type="text" name="armazem" value="<?php echo @$_GET['armazem']; ?>" class="form-control"/>
                            </div>
                        </div>
                    </div>
                </fieldset><br>
                            <th class="tabela_title">
                                <button class="btn btn-outline-success btn-sm" type="submit" id="enviar">Pesquisar</button>
                            </th>
                        </tr>
            </form>
            <br>
            <div class="table-responsive">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <tr>
                        <th class="tabela_header">Nota</th>
                        <th class="tabela_header">Fornecedor</th>
                        <th class="tabela_header">Armazem</th>
                        <th class="tabela_header">Data</th>
                        <th class="tabela_header" width="70px;" colspan="3"><center>Detalhes</center></th>
                    </tr>
                    <?php
                    $url = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->nota->listar($_GET);
                    $total = $consulta->count_all_results();
                    $limit = 10;
                    isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                        ?>
                        <tbody>
                            <?php
                            $lista = $this->nota->listar($_GET)->orderby('n.estoque_nota_id DESC, f.razao_social')->limit($limit, $pagina)->get()->result();
                            $estilo_linha = "tabela_content01";
                            foreach ($lista as $item) {
                            // var_dump($item);die;
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->nota_fiscal; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->fantasia; ?></td>

                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->armazem; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y", strtotime($item->data_cadastro)); ?></td>

                                    <?
                                    if ($perfil_id != 10) {
                                        if (date("Y-m-d", strtotime($item->data_cadastro)) == date("Y-m-d") && $item->situacao != 'FINALIZADA') {
                                            ?>
                                            <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                                    <a href="<?= base_url() ?>estoque/nota/carregarnota/<?= $item->estoque_nota_id ?>">Editar</a></div>
                                            </td>
                                        <? } else { ?>
                                            <td class="<?php echo $estilo_linha; ?>" width="70px;"></td>
                                        <? } ?>

                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"> <div class="bt_link">
                                                <a onclick="javascript: return confirm('Deseja realmente exlcuir essa Nota?');" href="<?= base_url() ?>estoque/nota/excluir/<?= $item->estoque_nota_id?>/<?= $item->nota_fiscal ?>">Excluir</a></div>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                                <a href="<?= base_url() ?>estoque/nota/alimentarnota/<?= $item->estoque_nota_id ?>">Entradas</a></div>
                                        </td>


                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                            </div>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"> <div class="bt_link">
                                            </div>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"> <div class="bt_link">
                                            </div>
                                        </td>

                                    <? }
                                    ?>
                                    <!--<td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                                    <a href="<?= base_url() ?>estoque/entrada/anexarimagementrada/<?= $item->estoque_nota_id ?>">Arquivos</a></div>
                                            </td>-->
                                </tr>

                            </tbody>
                            <?php
                        }
                    }
                    ?>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="10">
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
