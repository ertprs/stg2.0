<!DOCTYPE html>
<div >

    <?
    $valuecalculado = '';
    setcookie("TestCookie", $valuecalculado);
    $dataFuturo = date("Y-m-d");
    $dataAtual = @$obj->_nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');
    ?>

    <div class="container">
        <form name="form_laudo" id="form_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarlaudo/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>/<?= $paciente_id ?>/<?= $procedimento_tuss_id ?>/<?= @$obj->_sala_id ?>" method="post">
            <div >
                <fieldset>
                    <legend>Dados</legend>
                    <table> 

                        <tr>
                            <td width="400px;">Paciente:<?= @$obj->_nome ?></td>
                            <td width="400px;">Exame: <?= @$obj->_procedimento ?></td>
                            <td>Solicitante: <?= @$obj->_solicitante ?></td>
                            <td>&nbsp</td>
                            <td rowspan="3"><img src="<?= base_url() ?>upload/webcam/pacientes/<?= $paciente_id ?>.jpg"  height="120" width="100" /></td>
                        </tr>
                        <tr><td>Idade: <?= $teste ?></td>
                            <td>Nascimento:<?= substr(@$obj->_nascimento, 8, 2) . "/" . substr(@$obj->_nascimento, 5, 2) . "/" . substr(@$obj->_nascimento, 0, 4); ?></td>
                            <td>Sala:<?= @$obj->_sala ?></td>
                        </tr>
                        <tr>


                            <!-- <td width="40px;"><div class="bt_link_new">
                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/chamarpaciente/<?= $ambulatorio_laudo_id ?>');" >
                                        chamar</a></div> -->
                                <!--                                        impressaolaudo -->
                            <!-- </td> -->

                        </tr>
                    </table>
                </fieldset>
                <?
                $i = 0;
                if ($arquivo_pasta != false):
                    foreach ($arquivo_pasta as $value) {
                        $i++;
                    }
                endif
                ?>
                <fieldset>
                    <legend>Imagens :<b> <?= $i ?></b><? if ($i > 0) { ?> 
                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/laudo/limparnomes/" . $exame_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=400,height=200');">
                                    Limpar Nomes
                                </a>
                            </div><? } ?></legend>
                    <?
                    if ($arquivo_pasta != false):
                        foreach ($arquivo_pasta as $value) {
                            ?>
                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/laudo/alterarnomeimagem/" . $exame_id . "/" . $value ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=800');"><img  width="100px" height="100px" src="<?= base_url() . "upload/" . $exame_id . "/" . $value ?>"></a></li>
                            <?
                        }
                    endif
                    ?>
                    <!--                <ul id="sortable">
                                    </ul>-->
                </fieldset>
                <table>
                    <tr>
                        <td>
                            <div>
                                <button class="btn btn-outline-primary btn-sm" onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/galeria/" . $exame_id ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');">
                                    vizualizar imagem
                                </button>
                            </div>
                        </td>
                        <td>
                            <div>
                                <button class="btn btn-outline-primary btn-sm" onclick="javascript:window.open('<?= base_url() . "ambulatorio/exame/anexarimagemmedico/" . $exame_id . "/" . @$obj->_sala_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=yes,width=1200,height=400');">
                                    adicionar/excluir
                                </buttona>
                            </div>
                        </td>
                        <td>
                            <div>
                                <button class="btn btn-outline-primary btn-sm" onclick="javascript:window.open('<?= base_url() . "ambulatorio/laudo/carregarlaudoanterior/" . $paciente_id . "/" . $ambulatorio_laudo_id; ?> ');">
                                   Laudo anterior
                                </button>
                            </div>
                        </td>
                        <td>
                            <div>
                                <button class="btn btn-outline-primary btn-sm" onclick="javascript:window.open('<?= base_url() . "ambulatorio/modelolaudo"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650 ');">
                                    Laudo Modelo
                                </button>
                            </div>
                        </td>
                            <div>
                                <h5>Imagens por pagina</h5>
                                <?
//                    var_dump(@$obj->_quantidade);
//                    die;

                                if (@$obj->_imagens == "1") {
                                    ?>
                                    <label><input type="radio" value="1" name="imagem" class="radios3" checked ="true"/> 1</label>
                                <? } else { ?>
                                    <label><input type="radio" value="1" name="imagem" class="radios3" />1</label>
                                <? } ?>
                                <? if (@$obj->_imagens == "2") { ?>
                                    <label><input type="radio" value="2" name="imagem" class="radios3" checked ="true"/> 2</label>
                                <? } else { ?>
                                    <label><input type="radio" value="2" name="imagem" class="radios3" /> 2</label>
                                <? } ?>
                                <? if (@$obj->_imagens == "3") { ?>
                                    <label><input type="radio" value="3" name="imagem" class="radios3" checked ="true"/> 3</label>
                                <? } else { ?>
                                    <label><input type="radio" value="3" name="imagem" class="radios3" /> 3</label>
                                <? } ?>
                                <? if (@$obj->_imagens == "4") { ?>
                                    <label><input type="radio" value="4" name="imagem" class="radios3" checked ="true"/> 4</label>
                                <? } else { ?>
                                    <label><input type="radio" value="4" name="imagem" class="radios3" /> 4</label>
                                <? } ?>
                                <? if (@$obj->_imagens == "5") { ?>
                                    <label><input type="radio" value="5" name="imagem" class="radios3" checked ="true"/> 5</label>
                                <? } else { ?>
                                    <label><input type="radio" value="5" name="imagem" class="radios3" /> 5</label>
                                <? } ?>
                                <? if (@$obj->_imagens == "6") { ?>
                                    <label><input type="radio" value="6" name="imagem" class="radios3" checked ="true"/> 6</label>
                                <? } else { ?>
                                    <label><input type="radio" value="6" name="imagem" class="radios3" /> 6</label>
                                <? } ?>
                            </div>
                            </td>
                        <!-- <td>
                            <div class="bt_link_new">
                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/modelolaudo"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650 ');">
                                    <font size="-1">laudo Modelo</font>
                                </a>
                            </div>
                        </td> -->
                            <td>
                                <div>
                                    <button class="btn btn-outline-primary btn-sm" onclick="javascript:window.open('<?= base_url() . "ambulatorio/modelolinha"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');">
                                        Linha Modelo
                                    </button>
                                </div>
                            </td> 
                            &nbsp
                            <td >
                                <div>
                                    <button class="btn btn-outline-primary btn-sm" onclick="javascript:window.open('<?= base_url() . "ambulatorio/laudo/calculadora"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=400,height=450');">
                                        Calculadora
                                    </button>
                                </div>
                            </td>
                            </table>

                            </div>
                            <div>

                                <fieldset>
                                    <legend>Laudo</legend>
                                    <div>
                                        <?
                                        if (@$obj->_cabecalho == "") {
                                            $cabecalho = @$obj->_procedimento;
                                        } else {
                                            $cabecalho = @$obj->_cabecalho;
                                        }
                                        ?>
                                        <label>Nome do Laudo</label>
                                        <input class="size4" name="cabecalho" value="<?= $cabecalho ?>"/>
                                    </div>
                                    <div>
                                        <label>Laudo</label>
                                        <select name="exame" id="exame" class="size2" >
                                            <option value='' >selecione</option>
                                            <?php foreach ($lista as $item) { ?>
                                                <option value="<?php echo $item->ambulatorio_modelo_laudo_id; ?>" ><?php echo $item->nome; ?></option>
                                            <?php } ?>
                                        </select>

                                        <label>Linha</label>
                                        <input type="text" id="linha2" class="texto02" name="linha2"/>
                                        <!--<select name="linha" id="linha" class="size2" >
                                            <option value='' >selecione</option>
                                        <?php // foreach ($linha as $item) { ?>
                                                                                                                        <option value="<?php // echo $item->nome;  ?>" ><?php // echo $item->nome;  ?></option>
                                        <?php // } ?>
                                        </select>-->

                                        <div class="bt_link">
                                            <a class="btn btn-outline-primary btn-sm" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaolaudo/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>');">
                                                Imprimir</a>
                                        </div>
                                    </div>
                                    <div>
                                        <textarea id="laudo" name="laudo" rows="30" cols="80" style="width: 80%"><?= @$obj->_texto; ?></textarea>
                                    </div>
                                    <div>
                                        <label>M&eacute;dico respons&aacutevel</label>
                                        <select name="medico" id="medico" class="size2">
                                            <option value=0 >selecione</option>
                                            <? foreach ($operadores as $value) : ?>
                                                <option value="<?= $value->operador_id; ?>"<?
                                                if (@$obj->_medico_parecer1 == $value->operador_id):echo 'selected';
                                                endif;
                                                ?>><?= $value->nome; ?></option>
                                                    <? endforeach; ?>
                                        </select>
                                        <?php
                                        if (@$obj->_revisor == "t") {
                                            ?>
                                            <input type="checkbox" name="revisor" checked ="true" /><label>Revisor</label>
                                            <?php
                                        } else {
                                            ?>
                                            <input type="checkbox" name="revisor"  /><label>Revisor</label>
                                            <?php
                                        }
                                        ?>
                                        <select name="medicorevisor" id="medicorevisor" class="size2">
                                            <option value="">Selecione</option>
                                            <? foreach ($operadores as $valor) : ?>
                                                <option value="<?= $valor->operador_id; ?>"<?
                                                if (@$obj->_medico_parecer2 == $valor->operador_id):echo 'selected';
                                                endif;
                                                ?>><?= $valor->nome; ?></option>
                                                    <? endforeach; ?>
                                        </select>
                                        <?php
                                        if (@$obj->_assinatura == "t") {
                                            ?>
                                            <input type="checkbox" name="assinatura" checked ="true" /><label>Assinatura</label>
                                            <?php
                                        } else {
                                            ?>
                                            <input type="checkbox" name="assinatura"  /><label>Assinatura</label>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if (@$obj->_indicado == "t") {
                                            ?>
                                            <input type="checkbox" name="indicado" checked ="true" /><label>Indicado</label>
                                            <?php
                                        } else {
                                            ?>
                                            <input type="checkbox" name="indicado"  /><label>Indicado</label>
                                            <?php
                                        }
                                        ?>


                                        <label>situa&ccedil;&atilde;o</label>
                                        <select name="situacao" id="situacao" class="size2" onChange="muda(this)">
                                            <option value='DIGITANDO'<?
                                            if (@$obj->_status == 'DIGITANDO'):echo 'selected';
                                            endif;
                                            ?> >DIGITANDO</option>
                                            <option value='REVISAR' <?
                                            if (@$obj->_status == 'REVISAR'):echo 'selected';
                                            endif;
                                            ?> >REVISAR</option>
                                            <option value='FINALIZADO' <?
                                            if (@$obj->_status == 'FINALIZADO'):echo 'selected';
                                            endif;
                                            ?> >FINALIZADO</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label id="titulosenha">Senha</label>
                                        <input type="password" name="senha" id="senha" class="size1" />
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <? $operador_id = $this->session->userdata('operador_id'); ?>
                                    <legend>Impress&atilde;o</legend>
                                    <div>
                                        <table>
                                            <tr>
                                                <td >
                                                    <div>
                                                        <button class='btn btn-outline-default btn-sm' id="Imprimir" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaolaudo/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>');">
                                                            Imprimir
                                                        </button>
                                                    </div>
                                                </td>
                                                <td>
                                                   
                                                        <button class='btn btn-outline-default btn-sm' onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoimagem/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>');">
                                                        Fotos
                                                        </button>
                                                  
                                                </td>
                                                <!-- <td>
                                                    <div class="bt_link_new">
                                                        <button onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/pesquisarlaudoantigo');">
                                                            L. Antigo
                                                        </button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="bt_link_new">
                                                        <button onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/anexarimagem/<?= $ambulatorio_laudo_id ?>');" >
                                                            Arquivos
                                                        </button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="bt_link_new">
                                                        <button onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/oit/<?= $ambulatorio_laudo_id ?>');" >
                                                            OIT
                                                        </button>
                                                    </div>
                                                </td> -->
                                            </tr>
                                            <!-- <tr>
                                                <td >
                                                    <div class="bt_link_new">
                                                        <button onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaooit/<?= $ambulatorio_laudo_id ?>');" >
                                                            Imp. OIT</button></div></td>
                                                <td >
                                                    <div class="bt_link_new">
                                                        <button onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/gravordevoz/" ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');">
                                                            Gravador</button></div></td>
                                                <td >
                                                    <div class="bt_link_new">
                                                        <button onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregaratestado/<?= $ambulatorio_laudo_id ?>/<?= $paciente_id ?>/<?= $procedimento_tuss_id ?>');" >
                                                            Atestado</button></div></td>
                                                <td >
                                                    <div class="bt_link_new">
                                                        <button href="<?= base_url() ?>ambulatorio/laudo/vozemtexto/<?= $ambulatorio_laudo_id ?>/<?= $operador_id ?>">
                                                            Voz em Texto</button></div></td>
                                                <td >
                                                    <div class="bt_link_new">
                                                        <button onclick="javascript:window.open('<?= base_url() . "ambulatorio/laudo/carregaruploadcliente/" ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');" >
                                                            Upload de Imagens</button></div></td>
                                            </tr> -->
                                        </table>
                                    </div>

                                


                                                                <!--<input name="textarea" id="textarea"></input>
                                                        <!-- <input name="textarea" id="textarea" ></input>-->

                                        <br>
                                    <table>
                                        <tr>
                                            <td>
                                                <label>Situa&ccedil;&atilde;o</label>
                                                <select name="situacao" id="situacao" class="size2" onChange="muda(this)">
                                                    <option value='DIGITANDO'<?
                                                    if (@$obj->_status == 'DIGITANDO'):echo 'selected';
                                                    endif;
                                                    ?> >DIGITANDO</option>
                                                    <option value='REVISAR' <?
                                                    if (@$obj->_status == 'REVISAR'):echo 'selected';
                                                    endif;
                                                    ?> >REVISAR</option>
                                                    <option value='FINALIZADO' <?
                                                    if (@$obj->_status == 'FINALIZADO'):echo 'selected';
                                                    endif;
                                                    ?> >FINALIZADO</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            <button class="btn btn-success btn-sm" type="submit" name="btnEnviar">Salvar</button>
                                            </td>
                                        </tr>        
                                    </table>   
                                   
                                </fieldset>
                                <table border="1">
                                    <tr>
                                        <th>Tecla</th>
                                        <th>Bot&atilde;o Fun&ccedil;&atilde;o</th>
                                    </tr>
                                    <tr>
                                        <td>F8</td>
                                        <td>Bot&atilde;o Visualizar Impress&atilde;o</td>
                                    </tr>
                                    <tr>
                                        <td>F9</td>
                                        <td>Bot&atilde;o Finalizar</td>
                                    </tr>

                                </table>
                                </form>

                            </div> 
                            </div> 
                            </div> 
                            </div> <!-- Final da DIV content -->
                            <style>
                                .bt_link {width: 200pt;}

                                #sortable { list-style-type: none; margin: 0; padding: 0; width: 1300px; }
                                #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 100px; height: 90px; font-size: 4em; text-align: center; }
                            </style>

                            <meta http-equiv="content-type" content="text/html;charset=utf-8" />
                            <link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
                            <!-- <link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" /> -->
                            <link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
                            <!-- <link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" /> -->
                            <link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
                            <link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
                            <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
                            <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
                            <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
                            <script type="text/javascript" src="<?= base_url() ?>js/tinymce5/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
                            <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
                            <script  src="<?= base_url() ?>bootstrap/vendor/bootstrap/js/bootstrap.min.js"></script>
                            <link href="<?= base_url() ?>bootstrap/vendor/bootstrap/css/bootstrap.css" rel="stylesheet"/>
                            <link href="<?= base_url() ?>bootstrap/assets/css/argon-design-system.css?v=1.2.0" rel="stylesheet"/>
                        
                            <link href="<?= base_url() ?>css/laudo-form-1.css" rel="stylesheet"/>
                            <link href="<?= base_url() ?>js/jquery-ui.css" rel="stylesheet"/>
                            <link href="<?= base_url() ?>js/jquery-ui.structure.css" rel="stylesheet"/>
                            <link href="<?= base_url() ?>js/jquery-ui.theme.css" rel="stylesheet"/>
                            <link href="<?= base_url() ?>bootstrap/assets/css/font-awesome.css" rel="stylesheet" />
                            <link href="<?= base_url() ?>bootstrap/assets/css/nucleo-svg.css" rel="stylesheet" />
                            
                            <script type="text/javascript">

                                                            document.getElementById('titulosenha').style.display = "none";
                                                            document.getElementById('senha').style.display = "none";

                                                            $(document).ready(function () {
                                                                $("body").keypress(function (event) {

                                                                    if (event.keyCode == 119)   // se a tecla apertada for 13 (enter)
                                                                    {
                                                                        document.getElementById('Imprimir').click();
                                                                    }
                                                                    if (event.keyCode == 120)   // se a tecla apertada for 13 (enter)
                                                                    {
                                                                        var combosituacao = document.getElementById("situacao");
                                                                        combosituacao.selectedIndex = 2;
                                                                        document.getElementById('titulosenha').style.display = "block";
                                                                        document.getElementById('senha').style.display = "block";
                                                                        document.form_laudo.senha.focus()
                                                                    }
                                                                });
                                                            });
                                                            $(document).ready(function () {
                                                                $('#sortable').sortable();
                                                            });


                                                            $(document).ready(function () {
                                                                jQuery('#ficha_laudo').validate({
                                                                    rules: {
                                                                        imagem: {
                                                                            required: true
                                                                        }
                                                                    },
                                                                    messages: {
                                                                        imagem: {
                                                                            required: "*"
                                                                        }
                                                                    }
                                                                });
                                                            });



                                                            function muda(obj) {
                                                                if (obj.value == 'FINALIZADO') {
                                                                    document.getElementById('titulosenha').style.display = "block";
                                                                    document.getElementById('senha').style.display = "block";
                                                                } else {
                                                                    document.getElementById('titulosenha').style.display = "none";
                                                                    document.getElementById('senha').style.display = "none";
                                                                }
                                                            }



                                                            tinymce.init({
                                                                    selector: "#laudo",
                                                                            setup : function(ed)
                                                                            {
                                                                            ed.on('init', function()
                                                                            {
                                                                            this.getDoc().body.style.fontSize = '12pt';
                                                                            this.getDoc().body.style.fontFamily = 'Arial';
                                                                            });
                                                                            ed.on('SetContent', function (e) {
                                                                            this.getDoc().body.style.fontSize = '12pt';
                                                                            this.getDoc().body.style.fontFamily = 'Arial';
                                                                            });
                                                                            },
                                                                            language: 'pt_BR',
                                                                            // readonly : true,
                                                                            // lists_indent_on_tab : false,
                                                                            // forced_root_block : '',
<? if (@$empresa[0]->impressao_laudo == 33) { ?>
                                                                        forced_root_block : '',
<? } ?>
                                                                    //                                                            browser_spellcheck : true,
                                                                    //                                                            external_plugins: {"nanospell": "<?= base_url() ?>js/tinymce2/nanospell/plugin.js"},
                                                                    //                                                            nanospell_server: "php",
                                                                    //  
                                                                    width: 800,                                                          nanospell_dictionary: "pt_br" ,
                                                                    height: 450, // Pra tirar a lista automatica é só retirar o textpattern
                                                                            plugins: [
                                                                                    "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak",
                                                                                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking help",
                                                                                    "table directionality emoticons template textcolor paste fullpage colorpicker spellchecker"
                                                                            ],
                                                                            toolbar: "fontselect | fontsizeselect | bold italic underline strikethrough | link unlink anchor image | alignleft aligncenter alignright alignjustify | newdocument fullpage | styleselect formatselect | cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | media code | insertdatetime preview | forecolor backcolor | table |hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | visualchars visualblocks nonbreaking template pagebreak restoredraft help",
                                                                            // toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
                                                                            // toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor | table | removeformat",
                                                                            // toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | visualchars visualblocks nonbreaking template pagebreak restoredraft help",
                                                                            menubar: false,
                                                                            toolbar_items_size: 'small',
                                                                            style_formats: [{
                                                                            title: 'Bold text',
                                                                                    inline: 'b'
                                                                            }, {
                                                                            title: 'Red text',
                                                                                    inline: 'span',
                                                                                    styles: {
                                                                                    color: '#ff0000'
                                                                                    }
                                                                            }, {
                                                                            title: 'Red header',
                                                                                    block: 'h1',
                                                                                    styles: {
                                                                                    color: '#ff0000'
                                                                                    }
                                                                            }, {
                                                                            title: 'Example 1',
                                                                                    inline: 'span',
                                                                                    classes: 'example1'
                                                                            }, {
                                                                            title: 'Example 2',
                                                                                    inline: 'span',
                                                                                    classes: 'example2'
                                                                            }, {
                                                                            title: 'Table styles'
                                                                            }, {
                                                                            title: 'Table row 1',
                                                                                    selector: 'tr',
                                                                                    classes: 'tablerow1'
                                                                            }],
                                                                            fontsize_formats: 'xx-small x-small 8pt 10pt 12pt 14pt 18pt 24pt 36pt 48pt',
                                                                            templates: [{
                                                                            title: 'Test template 1',
                                                                                    content: 'Test 1'
                                                                            }, {
                                                                            title: 'Test template 2',
                                                                                    content: 'Test 2'
                                                                            }],
                                                                            init_instance_callback: function () {
                                                                            window.setTimeout(function () {
                                                                            $("#div").show();
                                                                            }, 1000);
                                                                            },
                                                                    });

                                                            $(function () {
                                                                $('#exame').change(function () {
                                                                    if ($(this).val()) {
                                                                        //$('#laudo').hide();
                                                                        $('.carregando').show();
                                                                        $.getJSON('<?= base_url() ?>autocomplete/modeloslaudo', {exame: $(this).val(), ajax: true}, function (j) {
                                                                            options = "";

                                                                            options += j[0].texto;
                                                                            //                                                document.getElementById("laudo").value = options

                                                                            $('#laudo').val(options)
                                                                            var ed = tinyMCE.get('laudo');
                                                                            ed.setContent($('#laudo').val());

                                                                            //$('#laudo').val(options);
                                                                            //$('#laudo').html(options).show();
                                                                            //                                                $('.carregando').hide();
                                                                            //history.go(0) 
                                                                        });
                                                                    } else {
                                                                        $('#laudo').html('value=""');
                                                                    }
                                                                });
                                                            });

                                                            $(function () {
                                                                $('#linha').change(function () {
                                                                    if ($(this).val()) {
                                                                        //$('#laudo').hide();
                                                                        $('.carregando').show();
                                                                        $.getJSON('<?= base_url() ?>autocomplete/modeloslinhas', {linha: $(this).val(), ajax: true}, function (j) {
                                                                            options = "";

                                                                            options += j[0].texto;
                                                                            //                                                document.getElementById("laudo").value = $('#laudo').val() + options
                                                                            $('#laudo').val() + options
                                                                            var ed = tinyMCE.get('laudo');
                                                                            ed.setContent($('#laudo').val());
                                                                            //$('#laudo').html(options).show();
                                                                        });
                                                                    } else {
                                                                        $('#laudo').html('value=""');
                                                                    }
                                                                });
                                                            });

                                                            $(function () {
                                                                $("#linha2").autocomplete({
                                                                    source: "<?= base_url() ?>index.php?c=autocomplete&m=linhas",
                                                                    minLength: 1,
                                                                    focus: function (event, ui) {
                                                                        $("#linha2").val(ui.item.label);
                                                                        return false;
                                                                    },
                                                                    select: function (event, ui) {
                                                                        $("#linha2").val(ui.item.value);
                                                                        tinyMCE.triggerSave(true, true);
                                                                        document.getElementById("laudo").value = $('#laudo').val() + ui.item.id
                                                                        $('#laudo').val() + ui.item.id
                                                                        var ed = tinyMCE.get('laudo');
                                                                        ed.setContent($('#laudo').val());
                                                                        //$( "#laudo" ).val() + ui.item.id;
                                                                        document.getElementById("linha2").value = ''
                                                                        return false;
                                                                    }
                                                                });
                                                            });

                                                            $(function (a) {
                                                                $('#anteriores').change(function () {
                                                                    if ($(this).val()) {
                                                                        //$('#laudo').hide();
                                                                        $('.carregando').show();
                                                                        $.getJSON('<?= base_url() ?>autocomplete/laudosanteriores', {anteriores: $(this).val(), ajax: true}, function (i) {
                                                                            option = "";

                                                                            option = i[0].texto;
                                                                            tinyMCE.triggerSave();
                                                                            document.getElementById("laudo").value = option
                                                                            //$('#laudo').val(options);
                                                                            //$('#laudo').html(options).show();
                                                                            $('.carregando').hide();
                                                                            history.go(0)
                                                                        });
                                                                    } else {
                                                                        $('#laudo').html('value="texto"');
                                                                    }
                                                                });
                                                            });
                                                            bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
                                                            $('.jqte-test').jqte();








                            </script>


                            <? if ($mensagem == 2) { ?>
                                <script type="text/javascript">
                                    alert("Sucesso ao finalizar Laudo");
                                </script>
                                <?
                            }
                            if ($mensagem == 1) {
                                ?>
                                <script type="text/javascript">
                                    alert("Erro ao finalizar Laudo");
                                </script>
                                <?
                            }