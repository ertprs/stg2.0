
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>farmacia/entrada/carregarfracionamento/0">
            Novo Fracionamento
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Fracionamento</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                <form method="get" action="<?= base_url() ?>farmacia/fracionamento/pesquisar">
                    <tr>
                        <th class="tabela_title">Produto Fracionado</th>
                        <th class="tabela_title">Fornecedor</th>
                        <th class="tabela_title">Armazem</th>
                        <!-- <th class="tabela_title">Nota</th> -->
                    </tr>
                    <tr>
                        <th class="tabela_title">
                            <input type="text" name="produto" value="<?php echo @$_GET['produto']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <input type="text" name="fornecedor" value="<?php echo @$_GET['fornecedor']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <input type="text" name="armazem" value="<?php echo @$_GET['armazem']; ?>" colspan="2"/>
                        </th>
                        
                        <th class="tabela_title">
                            <button type="submit" id="enviar">Pesquisar</button>
                        </th>
                    </tr>
                </form>
            </table>
            <table>
                <tr>
                    <th class="tabela_header">Produto Fracionado</th>
                    <th class="tabela_header">Quantidade Fracionada</th>
                    <th class="tabela_header">Produto Entrada</th>
                    <th class="tabela_header">Quantidade Entrada</th>
                    <th class="tabela_header">Data Fracionamento</th>
                    <th class="tabela_header">Armazem</th>
                    <th class="tabela_header">Fornecedor</th>
                    <!-- <th class="tabela_header">Nota</th> -->
                    <!-- <th class="tabela_header" width="70px;" colspan="3"><center>Detalhes</center></th> -->
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->fracionamento->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->fracionamento->listar($_GET)->limit($limit, $pagina)->orderby('p.descricao, a.descricao, f.fantasia')->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
//                            echo '<pre>';
//                            var_dump($lista); die;
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->produto; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->quantidade; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->produto_entrada; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->quantidade_entrada; ?></td>
                               
                                <td class="<?php echo $estilo_linha; ?>"><?=($item->data_fracionamento != '')? date("d/m/Y",strtotime($item->data_fracionamento)): ''; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->armazem; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->fantasia; ?></td>
                                <!-- <td class="<?php echo $estilo_linha; ?>"></td> -->
                                <!-- <td class="<?php echo $estilo_linha; ?>"></td> -->
                                
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
<script type="text/javascript">

                                $(function() {
                                    $("#accordion").accordion();
                                });

</script>
