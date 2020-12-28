<?php
//Utilitario::pmf_mensagem($message);
//unset($message);
?>
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url() ?>ambulatorio/agenda/carregarmodelo2/0">
            Nova Agenda
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Agenda</a></h3>
        <div>
            <form method="get" action="<?= base_url() ?>ambulatorio/agenda/pesquisaragendamodelo2">
                <fieldset>
                    <div class="row">
                        <div class="col-lg-4">
                            <div>
                                <input type="text" name="nome" class="texto10 bestupper form-control" value="<?php echo @$_GET['nome']; ?>" />
                                <button class="btn btn-outline-primary btn-sm" type="submit" id="enviar">Pesquisar</button>
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
                            <!--<th class="tabela_header">Tipo</th>-->
                            <th class="tabela_header" colspan="4"><center>A&ccedil;&otilde;es</center></th>
                    </tr>
                    </thead>
                    <?php
                    $url = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->agenda->listar($_GET);
                    $total = $consulta->count_all_results();
                    $limit = $limite_paginacao;
                    isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                        ?>
                        <tbody>
                            <?php
                            if ($limit != "todos") {
                                $lista = $this->agenda->listar($_GET)->orderby('nome')->limit($limit, $pagina)->get()->result();
                            } else {
                                $lista = $this->agenda->listar($_GET)->orderby('nome')->get()->result();
                            }
                            $estilo_linha = "tabela_content01";
                            foreach ($lista as $item) {
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                    <!--<td class="<?php echo $estilo_linha; ?>"><?= $item->tipo; ?></td>-->

                                    <td class="<?php echo $estilo_linha; ?>" width="50px;">
                                        <div class="bt_link" onclick="javascript:window.open('<?= base_url(); ?>ambulatorio/agenda/auditoriaagenda/<?= $item->agenda_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=200');">
                                            <a class="btn btn-outline-default btn-sm" href="#!">
                                                Log
                                            </a>
                                        </div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;">
                                        <div class="bt_link">
                                            <a class="btn btn-outline-danger btn-sm" href="<?= base_url() ?>ambulatorio/agenda/carregarexclusaoagenda/<?= $item->agenda_id; ?>">
                                                Excluir
                                            </a>
                                        </div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;">
                                        <div class="bt_link">
                                            <a class="btn btn-outline-warning btn-sm" href="<?= base_url() ?>ambulatorio/agenda/novohorarioagendamodelo2/<?= $item->agenda_id ?>" target="_blank">
                                                Editar
                                            </a>
                                        </div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;">
                                        <? if ($item->tipo == "Fixo") { ?>
                                            <div class="bt_link">
                                                <a class="btn btn-outline-default btn-sm" href="<?= base_url() ?>ambulatorio/exame/calendariohorariosagenda?agenda_id=<?= $item->agenda_id ?>" target="_blank">
                                                    Horários
                                                </a>
                                            </div>
                                        <? } ?>
                                    </td>

                                    </td>
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
                                <div >
                                    <span> Limite: </span>
                                    <select style="width: 50px">
                                        <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/agenda/pesquisaragendamodelo2/10');" <?
                                        if ($limit == 10) {
                                            echo "selected";
                                        }
                                        ?>> 10 </option>
                                        <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/agenda/pesquisaragendamodelo2/50');" <?
                                        if ($limit == 50) {
                                            echo "selected";
                                        }
                                        ?>> 50 </option>
                                        <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/agenda/pesquisaragendamodelo2/100');" <?
                                        if ($limit == 100) {
                                            echo "selected";
                                        }
                                        ?>> 100 </option>
                                        <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/agenda/pesquisaragendamodelo2/todos');" <?
                                        if ($limit == "todos") {
                                            echo "selected";
                                        }
                                        ?>> Todos </option>
                                    </select>
                                </div>
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
