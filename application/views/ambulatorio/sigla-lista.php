
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url() ?>ambulatorio/guia/carregararsigla/">
            Nova Sigla
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Sigla</a></h3>
        <div>
            <form method="get" action="<?= base_url() ?>ambulatorio/guia/listarsigla">
                <fieldset>
                    <div class="row">
                        <div class="col-lg-4">
                            <div>
                                <input type="text" name="nome" class="texto10 bestupper form-control" value="<?php echo @$_GET['nome']; ?>" />
                                <button class="btn btn-outline-success btn-sm" type="submit" id="enviar">Pesquisar</button>
                            </div>
                        </div>
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
                            <th class="tabela_header">Nome</th>
                            <th class="tabela_header" colspan="3"style="text-align:center;"  >Ações</th>
                        </tr>

                    </thead>
                    <?php
                    $url = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->guia->listarsigla($_GET);
                    $total = $consulta->count_all_results();
                    $limit = 10;
                    isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                    if ($total > 0) {
                        ?>
                        <tbody>
                            <?php
                            $lista = $this->guia->listarsigla($_GET)->limit($limit, $pagina)->get()->result();
                            ;
                            $estilo_linha = "tabela_content01";
                            foreach ($lista as $item) {
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"  width="50px" >
                                    <div class="bt_link" >
                                         <a href="<?= base_url() ?>ambulatorio/guia/carregararsigla/<?= $item->sigla_id; ?>" >Editar</a>
                                    </div>

                                    </td>

                                    <td class="<?php echo $estilo_linha; ?>"  width="50px" >
                                    <div class="bt_link">
                                         <a onclick="javascript: return confirm('Deseja realmente Excluir essa Sigla?');"  href="<?= base_url() ?>ambulatorio/guia/exlcuirsigla/<?= @$item->sigla_id; ?>" >Excluir</a>
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
                            <th class="tabela_footer" colspan="4">
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
