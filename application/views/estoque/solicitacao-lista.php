
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <button class="btn btn-outline-default btn-sm" href="<?php echo base_url() ?>estoque/solicitacao/criarsolicitacao/0">
            Novo Solicitacao
        </button>
    </div>
    <?
    $perfil_id = $this->session->userdata('perfil_id');
    ?>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Solicitacao</a></h3>
        <div>


                    <tr>
                        <form method="get" action="<?= base_url() ?>estoque/solicitacao/pesquisar">
                            <th>

                                    <input type="text" name="nome" class="texto10 bestupper form-control" value="<?php echo @$_GET['nome']; ?>" />
                            </th>
                            <th>
                                    <button class="btn btn-outline-success btn-sm" type="submit" id="enviar">Pesquisar</button>

                            </th>
                        </form>
                    </tr>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th class="tabela_header">Solicita&ccedil;&atilde;o</th>
                            <th class="tabela_header">Data</th>
                            <th class="tabela_header">Status</th>
                            <th class="tabela_header" width="70px;" colspan="3"><center>Detalhes</center></th>
                        </tr>
                    </thead>
                    <?php
                    $url = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->solicitacao->listar($_GET);
                    $total = $consulta->count_all_results();
                    $limit = 10;
                    isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                        ?>
                        <tbody>
                            <?php
                            $lista = $this->solicitacao->listar($_GET)->orderby('es.data_cadastro desc')->orderby('ec.nome')->orderby('es.estoque_solicitacao_setor_id desc')->limit($limit, $pagina)->get()->result();
                            $estilo_linha = "tabela_content01";
                            foreach ($lista as $item) {

                                if ($item->situacao == 'ABERTA') {
                                    $verifica = 2;
                                } elseif ($item->situacao == 'FECHADA') {
                                    $verifica = 1;
                                } elseif ($item->situacao == 'LIBERADA') {
                                    $verifica = 3;
                                }

                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->estoque_solicitacao_setor_id ?> - <?= $item->cliente; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?></td>
                                    <? if ($verifica == 1) { ?>
                                        <td class="<?php echo $estilo_linha; ?>"><font color="red"><b><?= $item->situacao; ?></b></td>
                                    <? }if ($verifica == 2) { ?>
                                        <td class="<?php echo $estilo_linha; ?>"><font color="blue"><b><?= $item->situacao; ?></b></td>
                                    <? }if ($verifica == 3) { ?>
                                        <td class="<?php echo $estilo_linha; ?>"><font color="green"><b><?= $item->situacao; ?></b></td>
                                    <?
                                    }
                                    if ($item->situacao == 'ABERTA') {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">  <div class="bt_link">
                                                <a href="<?= base_url() ?>estoque/solicitacao/carregarsolicitacao/<?= $item->estoque_solicitacao_setor_id ?>">Cadastrar</a>
                                            </div>
                                        </td>
                                    <?
                                    }
                                    if ($item->situacao == 'LIBERADA' && ($perfil_id == 1 || $perfil_id == 8)) {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a href="<?= base_url() ?>estoque/solicitacao/carregarsaida/<?= $item->estoque_solicitacao_setor_id ?>">Saida</a>
                                            </div>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a href="<?= base_url() ?>estoque/solicitacao/imprimirliberada/<?= $item->estoque_solicitacao_setor_id ?>">Imprimir</a>
                                            </div>
                                        </td>
                                    <?
                                    }
                                    if ($item->situacao != 'FECHADA' && ($perfil_id == 1 || $perfil_id == 8)) {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a onclick="javascript: return confirm('Deseja realmente exlcuir esse Solicitacao?');" href="<?= base_url() ?>estoque/solicitacao/excluir/<?= $item->estoque_solicitacao_setor_id ?>">Excluir</a>
                                            </div>
                                        </td>
                                        <?
                                        }
                                        if ($item->situacao == 'FECHADA') {
                                            ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a href="<?= base_url() ?>estoque/solicitacao/imprimir/<?= $item->estoque_solicitacao_setor_id ?>">Imprimir</a>
                                            </div>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                        </td>
                            <? } ?>
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
