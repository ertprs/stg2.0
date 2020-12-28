
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url() ?>ambulatorio/motivocancelamento/carregarmotivocancelamento/0">
            Novo Motivo
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Motivo Cancelamento</a></h3>
        <div>
            <form method="get" action="<?= base_url() ?>ambulatorio/motivocancelamento/pesquisar">
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
                            <th class="tabela_header">Nome</th>
                            <th class="tabela_header" width="70px;" colspan="2"><center>Detalhes</center></th>
                        </tr>
                    </thead>
                    <?php
                     $perfil_id = $this->session->userdata('perfil_id');
                        $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                        $consulta = $this->motivocancelamento->listar($_GET);
                        $total    = $consulta->count_all_results();
                        $limit    = 10;
                        isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                        if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                            $lista = $this->motivocancelamento->listar($_GET)->limit($limit, $pagina)->get()->result();
                            $estilo_linha = "tabela_content01";
                            foreach ($lista as $item) {
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                         ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>

                                    <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                        <a class="btn btn-outline-warning btn-sm" href="<?= base_url() ?>ambulatorio/motivocancelamento/carregarmotivocancelamento/<?= $item->ambulatorio_cancelamento_id ?>">Editar</a>
                                </td>
                                <?php if($perfil_id != 18 && $perfil_id != 20){ ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                        <a class="btn btn-outline-danger btn-sm" onclick="javascript: return confirm('Deseja realmente exlcuir esse Motivo?');" href="<?= base_url() ?>ambulatorio/motivocancelamento/excluir/<?= $item->ambulatorio_cancelamento_id ?>">Excluir</a>
                                    </td>
                                <?php }?>
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

    $(function() {
        $( "#accordion" ).accordion();
    });

</script>
