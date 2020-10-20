<link href="<?= base_url() ?>css/estoqueentrada-lista.css" rel="stylesheet"/>
<div class="col-sm-12">
    <!-- <div class="content"> Inicio da DIV content -->
        <div class="bt_link_new">
            <a class="btn btn-outline-danger btn-round btn-sm" href="<?php echo base_url() ?>estoque/entrada/carregarentrada/0">
                Novo Entrada
            </a>
        </div>
        <div id="accordion">
            <h3 class="singular"><a href="#">Manter Entrada</a></h3>
            <div>
                <table>
                    <thead>
                        <tr>
                            <!-- <th colspan="5" class="tabela_title"> -->
                            <form method="get" action="<?= base_url() ?>estoque/entrada/pesquisar">
                                <div class="container">
                                    
                                    <div class="product">
                                        <h6><b>Produto</h6>
                                    </div>

                                    <div class="fornecedor">
                                        <h6>Fornecedor</h6>
                                    </div>

                                    <div class="armazen">
                                        <h6>Armazem</h6>
                                    </div>

                                    <div class="nota">
                                        <h6>Nota</b></h6>
                                    </div>

                                    <div class="iprod">
                                        <input type="text" name="produto" class="form-control" value="<?php echo @$_GET['produto']; ?>"/>
                                    </div>

                                    <div class="iforn">
                                        <input type="text" name="fornecedor" class="form-control" value="<?php echo @$_GET['fornecedor']; ?>"/>
                                    </div>

                                    <div class="iarmz">
                                        <input type="text" name="armazem" class="form-control" value="<?php echo @$_GET['armazem']; ?>"/>
                                    </div>

                                    <div class="inota">
                                        <input type="text" name="nota" class="form-control" value="<?php echo @$_GET['nota']; ?>"/>
                                    </div>

                                    <div class="iaction">
                                        <button class="btn btn-outline-default btn-round btn-sm" type="submit" id="enviar">Pesquisar</button>
                                    </div>
                                    
                                </div>
                            </form>
                        </tr>
                </table>
                <table>
                    <tr>
                        <th class="tabela_header">Produto</th>
                        <th class="tabela_header">Fornecedor</th>
                        <th class="tabela_header">Armazem</th>
                        <th class="tabela_header">Quantidade</th>
                        <th class="tabela_header">Nota</th>
                        <th class="tabela_header" width="70px;" colspan="3"><center>Detalhes</center></th>
                    </tr>
                    </thead>
                    <?php
                    $url = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->entrada->listar($_GET);
                    $total = $consulta->count_all_results();
                    $limit = 10;
                    isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                        ?>
                        <tbody>
                            <?php
                            $lista = $this->entrada->listar($_GET)->orderby('f.razao_social')->limit($limit, $pagina)->get()->result();
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
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">                                  
                                        <a href="<?= base_url() ?>estoque/entrada/carregarentrada/<?= $item->estoque_entrada_id ?>">Editar</a></div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"> <div class="bt_link">                                 
                                        <a onclick="javascript: return confirm('Deseja realmente exlcuir esse Entrada?');" href="<?= base_url() ?>estoque/entrada/excluir/<?= $item->estoque_entrada_id ?>">Excluir</a></div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                            <a href="<?= base_url() ?>estoque/entrada/anexarimagementrada/<?= $item->estoque_entrada_id ?>">Arquivos</a></div>
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

    </div> <!-- Final da DIV content -->
</div>
<script type="text/javascript">

                                $(function() {
                                    $("#accordion").accordion();
                                });

</script>
