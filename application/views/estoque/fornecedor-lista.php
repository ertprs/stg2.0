
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url() ?>estoque/fornecedor/carregarfornecedor/0">
            Novo Fornecedor
        </a>
        <?
        $perfil_id = $this->session->userdata('perfil_id');
        ?>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Fornecedor</a></h3>
        <div>
            <form method="get" action="<?= base_url() ?>estoque/fornecedor/pesquisar">
                <fieldset>
                    <div class="row">
                        <input type="text" name="nome" class="texto07 form-control" value="<?php echo @$_GET['nome']; ?>" />
                        <button class="btn btn-outline-success btn-sm" type="submit" id="enviar">Pesquisar</button>
                    </div>
                </fieldset>
            </form>
            <br>
            <div class="table-responsive">
                <table width="100%" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="tabela_header">Nome Fantasia</th>
                        <th class="tabela_header">Raz&atilde;o Social</th>
                        <th class="tabela_header">CNPJ</th>
                        <th class="tabela_header">CPF</th>
                        <th class="tabela_header" width="70px;" colspan="2"><center>Detalhes</center></th>
                    </tr>
                    </thead>
                    <?php
                    $url = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->fornecedor->listar($_GET);
                    $total = $consulta->count_all_results();
                    $limit = 10;
                    isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                        ?>
                        <tbody>
                        <?php
                        $lista = $this->fornecedor->listar($_GET)->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->fantasia; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->razao_social; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->cnpj; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->cpf; ?></td>
                                <?if($perfil_id != 10){?>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                        <a class="btn btn-outline-primary btn-sm" href="<?= base_url() ?>estoque/fornecedor/carregarfornecedor/<?= $item->estoque_fornecedor_id ?>">Editar</a>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                        <a class="btn btn-outline-danger btn-sm" onclick="javascript: return confirm('Deseja realmente exlcuir esse Fornecedor?');" href="<?= base_url() ?>estoque/fornecedor/excluir/<?= $item->estoque_fornecedor_id ?>">Excluir</a>
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
                    <tr>
                        <th class="tabela_footer" colspan="7">
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
