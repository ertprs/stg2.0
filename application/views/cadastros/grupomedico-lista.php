
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url() ?>cadastros/grupomedico/carregargrupomedico/0">
            Novo Grupo Profissional
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Grupo Profissionais</a></h3>
        <div>
            <form method="get" action="<?= base_url() ?>cadastros/grupomedico/pesquisar">
                <fieldset>
                    <div class="row">
                        <div class="col-lg-4">
                            <input type="text" name="nome" class="texto10 bestupper form-control" value="<?php echo @$_GET['nome']; ?>" />
                            <button class="btn btn-outline-success btn-sm" type="submit" id="enviar">Pesquisar</button>
                        </div>
                    </div>
                </fieldset>
            </form>
            <br>
            <div class="table-responsive">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th colspan="10" class="tabela_title">

                            </th>
                        </tr>
                        <tr>
                            <th class="tabela_header">Nome</th>
                            <th class="tabela_header" colspan="2"><center>Detalhes</center></th>
                        </tr>
                    </thead>
                    <?php
                    $url = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->grupomedico->listar($_GET);
                    $total = $consulta->count_all_results();
                    $limit = 10;
                    $perfil_id = $this->session->userdata('perfil_id');
                    isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                        ?>
                        <tbody>
                            <?php
                            $lista = $this->grupomedico->listar($_GET)->limit($limit, $pagina)->orderby("nome")->get()->result();
                            $estilo_linha = "tabela_content01";
                            foreach ($lista as $item) {
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>

                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>cadastros/grupomedico/carregargrupomedicoadicionar/<?= $item->operador_grupo_id ?>">Editar</a></div>
                                    </td>
                                    <?php if($perfil_id != 18 && $perfil_id != 20){ ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                            <a href="<?= base_url() ?>cadastros/grupomedico/excluir/<?= $item->operador_grupo_id ?>">Excluir</a></div>
                                        </td>
                                    <?php }?>
                                </tr>

                            </tbody>
                            <?php
                        }
                    }
                    ?>
                    <tfoot>
                        <tr class="text-center pag">
                            <th class="tabela_footer pagination-container" colspan="6">
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
