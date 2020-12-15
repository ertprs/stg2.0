<link href="<?= base_url() ?>css/entrada/fracionamento-form.css" rel="stylesheet"/>
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h6 class="singular ui-accordion-header ui-corner-top ui-state-default ui-accordion-header-active ui-state-active ui-accordion-icons">Fracionamento</h6>
        <div>
            <form name="form_entrada" id="form_entrada" action="<?= base_url() ?>estoque/entrada/gravarfracionamento" method="post">
                <fieldset>
                    <div class="row">
                        <div class="col-lg-5">
                            <div>
                                <label>Produto a ser Fracionado</label>
                                <select name="produto_id" id="produto_id" class="chosen form-control" required>
                                    <option value="">Selecione</option>
                                    <? foreach ($produtos as $value) : ?>
                                        <option value="<?= $value->estoque_produto_id; ?>"><?php echo $value->descricao; ?> - <?php echo $value->unidade; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Quantidade</label>
                                <input type="number" name="quantidade" id="quantidade" min="0" class="form-control" required/>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div>
                                <label>Produto de Entrada</label>
                                <select name="produto_entrada" id="produto_entrada" class="form-control chosen" tabindex="1" required data-placeholder="Selecione um Produto">
                                    <option value="">Selecione</option>
                                    <!-- <? foreach ($produtos as $value) : ?>
                            <option value="<?= $value->estoque_produto_id; ?>"><?php echo $value->descricao; ?></option>
                            <? endforeach; ?> -->
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Fornecedor</label>
                                <input type="hidden" name="txtfornecedor" id="txtfornecedor" />
                                <input type="text" name="txtfornecedorlabel" id="txtfornecedorlabel" class="form-control" value="<?= @$obj->_fornecedor; ?>" required/>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Armazem de Entrada</label>
                                <select name="txtarmazem" id="txtarmazem" class="form-control" required>
                                    <option value="">Selecione</option>
                                    <? foreach ($sub as $value) : ?>
                                        <option value="<?= $value->estoque_armazem_id; ?>"><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Quantidade Entrada</label>
                                <input type="number" name="quantidade_entrada" id="quantidade_entrada" min="0" class="form-control" required/>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
                <hr/>
                <button class="btn btn-outline-success btn-sm" type="submit" name="btnEnviar">Enviar</button>
                <button class="btn btn-outline-warning btn-sm" type="reset" name="btnLimpar">Limpar</button>
                <button class="btn btn-outline-default btn-sm" type="button" id="btnVoltar" name="btnVoltar">Voltar</button>

        </div>
    </div>
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<!-- <script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script> -->
<!-- <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script> -->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript">
    
    $(function() {
        $( "#txtfornecedorlabel" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=fornecedor",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtfornecedorlabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtfornecedorlabel" ).val( ui.item.value );
                $( "#txtfornecedor" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(function () {
        $('#produto_id').change(function () {
            if ($(this).val()) {

                $.getJSON('<?= base_url() ?>autocomplete/produtosaldofracionamento', {produto: $(this).val()}, function (j) {
                    // console.log(j);
                    if(j.length > 0){
                        if (j[0].total == null || j[0].total == undefined) {
                            alert('Sem saldo deste produto');
                            $("#quantidade").prop('max', '0');
                        }else{
                            // alert('asda');
                            $("#quantidade").prop('max', j[0].total);
                        }
                    }else{
                        alert('Sem saldo deste produto');
                        $("#quantidade").prop('max', '0');
                    }
                    

                });
            } else {

            }
        });
    });

    $(function () {
        $('#produto_id').change(function () {
            if ($(this).val()) {

                $.getJSON('<?= base_url() ?>autocomplete/produtofracionamentounidade', {produto: $(this).val()}, function (j) {
                    // alert(j[0].total);
                    var options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].estoque_produto_id + '">' + j[c].produto + ' - '+ j[c].unidade +'</option>';
                    }
//                    $('#procedimento1').html(options).show();
                    $('#produto_entrada option').remove();
                    $('#produto_entrada').append(options);
                    $("#produto_entrada").trigger("chosen:updated");
                    $('.carregando').hide();

                });
            } else {

            }
        });
    });

    $(function() {
        $( "#accordion" ).accordion();
    });
</script>