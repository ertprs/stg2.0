
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a class="btn btn-outline-danger btn-round btn-sm" href="<?php echo base_url() ?>ambulatorio/empresa/carregarempresa/0">
            Nova Empresa
        </a>
    </div>
    <div >
        <h3 class="singular"><a href="#">Manter Empresa</a></h3>
        <tr>
                            <th>
                                <form method="get" action="<?= base_url() ?>ambulatorio/empresa/pesquisar">
                                    <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                    <button type="submit" id="enviar">Pesquisar</button>
                                </form>
                            </th>
                        </tr>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CNPJ</th>
                            <th">Raz&atilde;o social</th>
                            <th>Detalhes</th>
                        </tr>
                        
                    </thead>
                    <?php
                    $url = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->empresa->listar($_GET);
                    $total = $consulta->count_all_results();
                    $limit = 10;
                    isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                    if ($total > 0) {
                        ?>
                        <tbody>
                            <?php
                            $lista = $this->empresa->listar($_GET)->limit($limit, $pagina)->orderby("nome")->get()->result();
                            $estilo_linha = "tabela_content01";
                            foreach ($lista as $item) {
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                ?>
                                <tr>
                                    <td class=""><?= $item->nome; ?></td>
                                    <td class="texto08"><?= $item->cnpj; ?></td>
                                    <td class=""><?= $item->razao_social; ?></td>

                                    <td class="tabela_acoes">
                                            <a class="btn btn-outline-primary btn-round btn-sm" href="<?= base_url() ?>ambulatorio/empresa/carregarempresa/<?= $item->empresa_id ?>">Editar</a>
                                    
                                    <? $operador_id = $this->session->userdata('operador_id');
                                    
                                    if ($operador_id == 1):?>
                                                <a class="btn btn-outline-primary btn-round btn-sm" style="width: 100pt" href="<?= base_url() ?>ambulatorio/empresa/configurarsms/<?= $item->empresa_id ?>">Configurar SMS</a></div>
                                    </td>
                                    <? endif; ?>
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

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

</script>
