
<div class="content"> <!-- Inicio da DIV content -->
    <div class="container">
        <div class="row">
            <div class="col">
                <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url() ?>ambulatorio/procedimento/carregarprocedimentotuss/0">
                    Novo Proc. Tuss
                </a>
            </div>
            <div class="col">
                <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url() ?>ambulatorio/procedimento/ajustarportetusschpm">
                    Ajustar PORTE
                </a>
            </div>
        </div>
    </div>




    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Procedimento</a></h3>
        <div>
            <form method="get" action="<?= base_url() ?>ambulatorio/procedimento/pesquisartuss">
                <fieldset>
                    <div class="row">
                        <div class="col-lg-4">
                            <input type="text" name="nome" class="form-control bestupper" value="<?php echo @$_GET['nome']; ?>" />
                        </div>
                        <div class="col-lg-2">
                            <button class="btn-outline-success btn-sm" type="submit" id="enviar">Pesquisar</button>
                        </div>
                    </div>
                </fieldset>
            </form>
            <br>
            <div class="table-responsive">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example"
                    <thead>
                        <tr>
                            <th colspan="5" class="tabela_title">

                    </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Descri&ccedil;&atilde;o</th>
                        <th class="tabela_header">Codigo</th>
                        <th class="tabela_header">Texto</th>
                        <th class="tabela_header" colspan="2" style="text-align: center">Detalhes</th>
                    </tr>
                    </thead>
                    <?php
                    $url = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->procedimento->listartuss($_GET);
                    $total = $consulta->count_all_results();
                    $limit = 10;
                    isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                        ?>
                        <tbody>
                            <?php
                            $lista = $this->procedimento->listartuss($_GET)->orderby('descricao')->limit($limit, $pagina)->get()->result();
                            $estilo_linha = "tabela_content01";
                            foreach ($lista as $item) {
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>">
                                        <a data-toggle="modal" data-target="#exampleModal">
                                            <?= $item->descricao; ?>
                                        </a>
                                    </td>

                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->codigo; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->ans; ?></td>

                                    <td class="<?php echo $estilo_linha; ?>" width="100px;"><div class="bt_link">
                                            <a href="<?= base_url() ?>ambulatorio/procedimento/carregarprocedimentotuss/<?= $item->tuss_id ?>">Editar
                                            </a>
                                        </div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="100px;"><div class="bt_link">
                                            <a href="<?= base_url() ?>ambulatorio/procedimento/excluirprocedimentotuss/<?= $item->tuss_id ?>"
                                               onclick="javascript: return confirm('Deseja realmente excluir esse procedimento?');">Excluir
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                            <?php
                        }
                    }
                    ?>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="6">
                                <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                                Total de registros: <?php echo $total; ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Procedimento TUSS</h5>
                </div>
                <div class="modal-body">
                    <fieldset id="listainfo">
                        <?php
                        $lista = $this->procedimento->listartuss($_GET)->orderby('descricao')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>

                            <td><?= $item->descricao; ?></td>
                            <td ><?= $item->codigo; ?></td>
                            <td><?= $item->ans; ?></td>

                            <td>
                                <a href="<?= base_url() ?>ambulatorio/procedimento/carregarprocedimentotuss/<?= $item->tuss_id ?>">Editar </a>
                            </td>
                            <td>
                                <a href="<?= base_url() ?>ambulatorio/procedimento/excluirprocedimentotuss/<?= $item->tuss_id ?>"
                                   onclick="javascript: return confirm('Deseja realmente excluir esse procedimento?');">Excluir
                                </a>
                            </td>

                        <?php }  ?>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->
</div> <!-- Final da DIV content -->
<script type="text/javascript">
    $(function (){

    }) ;

    $(function() {
        $("#accordion").accordion();
    });

</script>
