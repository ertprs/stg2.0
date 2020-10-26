
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/empresa/configurartemplateconsulta/0">
            Novo Template
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Templates</a></h3>
        <div>
            <table>
                <thead>
<!--                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/empresa/listarcabecalho">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>-->
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Grupo</th>
                        <!--<th class="tabela_header">Raz&atilde;o social</th>-->
                        <th class="tabela_header" colspan="2"><center>Detalhes</center></th>
                </tr>
                </thead>
                <?php
                $perfil_id = $this->session->userdata('perfil_id');
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->empresa->listartemplateanamnese($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->empresa->listartemplateanamnese($_GET)->limit($limit, $pagina)->orderby("nome_template")->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome_template; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td>

                                <td style="width: 120px;" class="<?php echo $estilo_linha; ?>"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/empresa/configurartemplateconsulta/<?= $item->template_anamnese_id; ?>">Editar</a></div>
                                </td>
                              <?php if($perfil_id != 18 && $perfil_id != 20){?>  
                                <td style="width: 120px;" class="<?php echo $estilo_linha; ?>"><div class="bt_link">
                                        <a onclick="javascript: return confirm('Você deseja realmente excluir o template?');" href="<?= base_url() ?>ambulatorio/empresa/excluirtemplateconsulta/<?= $item->template_anamnese_id; ?>">Excluir</a></div>
                                </td>
                              <?php }?>
                                <?
                               
                                $operador_id = $this->session->userdata('operador_id');
                                if ($perfil_id == 1):
                                    ?>
                                    
                               <? endif; ?>
                                <?
//                                $perfil_id = $this->session->userdata('perfil_id');
                                if ($operador_id == 1):
                                    ?>
                                    
                               <? endif; ?>
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

    $(function () {
        $("#accordion").accordion();
    });

</script>
