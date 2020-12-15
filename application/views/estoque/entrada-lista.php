<link href="<?= base_url() ?>css/estoque/entrada-lista.css" rel="stylesheet"/>
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>
            <td>
                <div class="bt_link_new">
                    <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url() ?>estoque/entrada/carregarentrada/0">
                        Novo Entrada
                    </a>
                    <?
                    $perfil_id = $this->session->userdata('perfil_id');
                    ?>
                </div> 
            </td>
            <td>
                <div class="bt_link_new">
                    <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url() ?>estoque/entrada/carregarfracionamento/0">
                        Fracionamento
                    </a>
                    <?
                    $perfil_id = $this->session->userdata('perfil_id');
                    ?>
                </div>
            </td>
        </tr>
    </table>
    
    
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Entrada</a></h3>
        <div>
            <form method="get" action="<?= base_url() ?>estoque/entrada/pesquisar">
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
                                <label>Armazem</label>
                                <input class="form-control" type="text" name="armazem" value="<?php echo @$_GET['armazem']; ?>" colspan="2"/>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div>
                                <label>Nota</label>
                                <input class="form-control" type="text" name="nota" value="<?php echo @$_GET['nota']; ?>" colspan="2"/>
                            </div>
                        </div>
                        <div class="col-lg-2 btnsend">
                            <button class="btn btn-outline-success" type="submit" id="enviar">Pesquisar</button>
                        </div>
                    </div>
                </fieldset>
            </form>
            <br>
            <div class="table-responsive">
                <table width="100%" class="table table-striped table-bordered table-hover">
                    <tr>
                        <th class="tabela_header">Produto</th>
                        <th class="tabela_header">Data</th>
                        <th class="tabela_header">Fornecedor</th>
                        <th class="tabela_header">Armazem</th>
                        <th class="tabela_header">Armazem de Saida</th>
                        <th class="tabela_header">Qtde</th>
                        <th class="tabela_header">Nota</th>
                        <th class="tabela_header" width="70px;" colspan="3"><center>Detalhes</center></th>
                    </tr>

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
                            $lista = $this->entrada->listar($_GET)->orderby('e.estoque_entrada_id DESC, p.descricao, f.razao_social')->limit($limit, $pagina)->get()->result();
                            $estilo_linha = "tabela_content01";
                            foreach ($lista as $item) {
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->produto; ?> <?if($item->transferencia == 't'){
                                        echo " <span style='color:red;'>(Transferência)</span>";

                                    }?><?if($item->fracionamento_id > 0){
                                        echo " <span style='color:red;'>(Fracionamento)</span>";

                                    }?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y",strtotime($item->data_cadastro)); ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->fantasia; ?></td>

                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->armazem; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->armazem_transferencia; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->quantidade; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->nota_fiscal; ?></td>
                                    <?
                                    if ($perfil_id != 10) {
                                        if (date("Y-m-d", strtotime($item->data_cadastro)) == date("Y-m-d")) {
                                            ?>
                                            <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                                    <a class="btn btn-outline-warning btn-sm" href="<?= base_url() ?>estoque/entrada/carregarentrada/<?= $item->estoque_entrada_id ?>">Editar</a></div>
                                            </td>
                                        <? } else { ?>
                                            <td class="<?php echo $estilo_linha; ?>" width="70px;"></td>
                                        <? } ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"> <div class="bt_link">
                                                <a class="btn btn-outline-danger btn-sm" onclick="javascript: return confirm('Deseja realmente exlcuir esse Entrada?');" href="<?= base_url() ?>estoque/entrada/excluir/<?= $item->estoque_entrada_id ?>">Excluir</a></div>
                                        </td>


                            <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                                <a class="btn btn-outline-default btn-sm">Editar</a></div>
                                        </td>
                                        <td  class="<?php echo $estilo_linha; ?>" > <div class="bt_link">
                                                <a class="btn btn-outline-default btn-sm" href="">Excluir</a></div>
                                        </td>

                                    <? }
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                            <a class="btn btn-outline-default btn-sm" href="<?= base_url() ?>estoque/entrada/anexarimagementrada/<?= $item->estoque_entrada_id ?>">Arquivos</a></div>
                                    </td>
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
