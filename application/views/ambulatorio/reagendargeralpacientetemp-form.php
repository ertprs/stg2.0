<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>

    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravargeralpacientetempreagendar" method="post">

        <fieldset>
            <legend>Reagendar Geral</legend>

            <div>
                <label>Nome</label>
                <input type="text" name="txtNome" class="texto10 bestupper" value="<?= @$obj->_nome; ?>" readonly/>
            </div>
            <div>
                <label>Dt de nascimento</label>

                <input readonly type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr(@$obj->_nascimento, 8, 2) . '/' . substr(@$obj->_nascimento, 5, 2) . '/' . substr(@$obj->_nascimento, 0, 4); ?>"/>
            </div>
            <div>
                <label>Idade</label>
                <input type="text" name="idade2" id="idade2" class="texto01" readonly/>
            </div>
            <div>
                <input readonly type="hidden" name="idade" id="txtIdade" class="texto01" alt="numeromask" value="<?= @$obj->_idade; ?>"  />

            </div>
            <div>
                <label>Telefone</label>
                <input type="text" id="txtTelefone" class="texto02" readonly name="telefone"  value="<?= @$obj->_telefone; ?>" />
            </div>
            <div>
                <label>Celular</label>
                <input type="text" id="txtCelular" class="texto02" readonly name="celular" value="<?= @$obj->_celular; ?>" />
            </div>
            <div>
                <label>Convenio</label>
                <input type="text" id="txtconvenio" class="texto02" readonly name="convenio" value="<?= @$obj->_descricaoconvenio; ?>" readonly />
            </div>
        </fieldset>
        <fieldset>
            <div>
                <label>Data</label>
                <input type="text"  id="data_ficha" name="data_ficha" class="size1"  required/>
                <input type="hidden" name="txtpaciente_id" id="txtpaciente_id" value="<?= @$obj->_paciente_id; ?>" />
                <input type="hidden" name="agenda_exames_id" id="txtpaciente_id" value="<?= @$agenda_exames_id; ?>" />
                <input type="hidden" name="medico_consulta_id" id="txtpaciente_id" value="<?= @$medico_consulta_id; ?>" />
                <!--<input type="hidden" name="txtpaciente_id" id="txtpaciente_id" value="<?= @$medico_consulta_id; ?>" />-->
            </div>
            <legend>Novo Horário</legend>

            <div>
                <label>Medico</label>                 
                <?php
                if ($this->session->userdata('perfil_id') == 4 && $this->session->userdata('medico_agenda') == 't') {
                    ?>                
                    <select name="exame" id="exame" class="size4" onclick="BuscarDatasEmpresa()" required>                        
                        <? foreach ($medico as $item) : ?>
                            <?php if ($item->operador_id == $this->session->userdata('operador_id')) { ?>                        
                                <option value="<?= $item->operador_id; ?>" selected ><?= $item->nome; ?></option>
                            <?php } ?>
                        <? endforeach; ?>
                    </select>                   
                <?php } else { ?>                 
                    <select name="exame" id="exame" class="size4" onclick="BuscarDatasEmpresa()" required>
                        <option value="" >Selecione</option>
                        <? foreach ($medico as $item) : ?>
                            <option value="<?= $item->operador_id; ?>" <? if ($item->operador_id == $medico_consulta_id) echo "selected"; ?>>
                                <?= $item->nome; ?>
                            </option>
                        <? endforeach; ?>
                    </select>              
                <?php } ?>                  
            </div>
            <div>
                <label>Horarios</label>
                <select name="horarios" id="horarios" class="size2" required>
                    <option value="" >-- Escolha um exame --</option>
                </select>
            </div>
            <div>
                <label>Observa&ccedil;&otilde;es</label>
                <input type="text" id="observacoes" class="size3" name="observacoes" />
            </div>

            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
    </form>
</fieldset>

<fieldset>
    <legend>Horário Atual</legend>
    <?
    if ($contador > 0) {
        ?>
        <table id="table_agente_toxico" border="0">
            <thead>

                <tr>
                    <th class="tabela_header">Data</th>
                    <th class="tabela_header">Hora</th>
                    <th class="tabela_header">M&eacute;dico</th>
                    <th class="tabela_header">Observa&ccedil;&otilde;es</th>
                    <!--<th class="tabela_header" colspan="2">&nbsp;</th>-->
                </tr>
            </thead>
            <?
            $estilo_linha = "tabela_content01";
            foreach ($exames as $item) {
                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                ?>
                <tbody>
                    <tr>
                        <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . '/' . substr($item->data, 5, 2) . '/' . substr($item->data, 0, 4); ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->sala . "-" . $item->medico; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                        width=500,height=230');">=><?= $item->observacoes; ?></a></td>
                            <? if (empty($faltou)) { ?>
                                <? if ($item->encaixe == 't') { ?>

                            <? } else { ?>


                            <? } ?>
                        <? } ?>



                    </tr>

                </tbody>
                <?
            }
        }
        ?>
        <tfoot>
            <tr>
                <th class="tabela_footer" colspan="4">
                </th>
            </tr>
        </tfoot>
    </table> 
    <?
    if (count($consultasanteriores) > 0) {
        foreach ($consultasanteriores as $value) {

            $data_atual = date('Y-m-d');
            $data1 = new DateTime($data_atual);
            $data2 = new DateTime($value->data);

            $intervalo = $data1->diff($data2);
            ?>
            <h6><b><?= $intervalo->days ?> dia(s)</b>&nbsp;&nbsp;&nbsp;- ULTIMA ATENDIMENTO: <?= $value->procedimento; ?> - DATA: <b><?= substr($value->data, 8, 2) . '/' . substr($value->data, 5, 2) . '/' . substr($value->data, 0, 4); ?> </b> - M&eacute;dico: <b> <?= $value->medico; ?></b> - Convenio:  <?= $value->convenio; ?></h6>

            <?
        }
    } else {
        ?>
        <h6>NENHUMA CONSULTA ENCONTRADA</h6>
        <?
    }
    ?>


</fieldset>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script>
                    function mascaraTelefone(campo) {

                        function trata(valor, isOnBlur) {

                            valor = valor.replace(/\D/g, "");
                            valor = valor.replace(/^(\d{2})(\d)/g, "($1)$2");

                            if (isOnBlur) {

                                valor = valor.replace(/(\d)(\d{4})$/, "$1-$2");
                            } else {

                                valor = valor.replace(/(\d)(\d{3})$/, "$1-$2");
                            }
                            return valor;
                        }

                        campo.onkeypress = function (evt) {

                            var code = (window.event) ? window.event.keyCode : evt.which;
                            var valor = this.value

                            if (code > 57 || (code < 48 && code != 0 && code != 8 && code != 9)) {
                                return false;
                            } else {
                                this.value = trata(valor, false);
                            }
                        }

                        campo.onblur = function () {

                            var valor = this.value;
                            if (valor.length < 13) {
                                this.value = ""
                            } else {
                                this.value = trata(this.value, true);
                            }
                        }

                        campo.maxLength = 14;
                    }


</script>
<script type="text/javascript">
    jQuery("#txtTelefone")
            .mask("(99) 9999-9999?9")
            .focusout(function (event) {
                var target, phone, element;
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                phone = target.value.replace(/\D/g, '');
                element = $(target);
                element.unmask();
                if (phone.length > 10) {
                    element.mask("(99) 99999-999?9");
                } else {
                    element.mask("(99) 9999-9999?9");
                }
            });

    jQuery("#txtCelular")
            .mask("(99) 9999-9999?9")
            .focusout(function (event) {
                var target, phone, element;
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                phone = target.value.replace(/\D/g, '');
                element = $(target);
                element.unmask();
                if (phone.length > 10) {
                    element.mask("(99) 99999-999?9");
                } else {
                    element.mask("(99) 9999-9999?9");
                }
            });


    // $(function () {
    //     $("#data_ficha").datepicker({
    //         autosize: true,
    //         changeYear: true,
    //         changeMonth: true,
    //         monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    //         dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
    //         buttonImage: '<? base_url() ?>img/form/date.png',
    //         dateFormat: 'dd/mm/yy'
    //     });
    // });

    $(function () {
        $('#exame').change(function () {
            if ($(this).val()) {
//                $('#horarios').hide();
//                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/horariosambulatoriogeral', {exame: $('#exame').val(), teste: $("#data_ficha").val()}, function (j) {
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].agenda_exames_id + '">' + j[i].inicio + '</option>';
                    }
                    $('#horarios').html(options).show();
//                    $('.carregando').hide();
                });
            } else {
                $('#horarios').html('<option value="">-- Escolha um hora --</option>');
            }
        });
    });

    $(function () {
        $('#data_ficha').change(function () {
            if ($(this).val()) {
//                $('#horarios').hide();
//                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/horariosambulatoriogeral', {exame: $('#exame').val(), teste: $("#data_ficha").val()}, function (j) {
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].agenda_exames_id + '">' + j[i].inicio + '</option>';
                    }
                    $('#horarios').html(options).show();
//                    $('.carregando').hide();
                });
            } else {
                $('#horarios').html('<option value="">-- Escolha um hora --</option>');
            }
        });
    });





    //$(function(){     
    //    $('#exame').change(function(){
    //        exame = $(this).val();
    //        if ( exame === '')
    //            return false;
    //        $.getJSON( <?= base_url() ?>autocomplete/horariosambulatorio, exame, function (data){
    //            var option = new Array();
    //            $.each(data, function(i, obj){
    //                console.log(obl);
    //                option[i] = document.createElement('option');
    //                $( option[i] ).attr( {value : obj.id} );
    //                $( option[i] ).append( obj.nome );
    //                $("select[name='horarios']").append( option[i] );
    //            });
    //        });
    //    });
    //});





    $(function () {
        $("#accordion").accordion();
    });


    $(document).ready(function () {
        jQuery('#form_exametemp').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

//    function calculoIdade() {
//        var data = document.getElementById("txtNascimento").value;
//        var ano = data.substring(6, 12);
//        var idade = new Date().getFullYear() - ano;
//        document.getElementById("idade2").value = idade;
//    }
    
    function calculoIdade() {
        var data = document.getElementById("txtNascimento").value;

        if (data != '' && data != '//') {

            var ano = data.substring(6, 12);
            var idade = new Date().getFullYear() - ano;

            var dtAtual = new Date();
            var aniversario = new Date(dtAtual.getFullYear(), parseInt(data.substring(3, 5)) - 1, data.substring(0, 2));

            if (dtAtual < aniversario) {
                idade--;
            }

            document.getElementById("idade2").value = idade + " ano(s)";
        }
    }
    calculoIdade();


    BuscarDatasEmpresa();

    function BuscarDatasEmpresa() {
        var medico = $("#exame").val();
        $("#data_ficha").val("");
        console.log('Entrou aqui');
        console.log(medico);

        array_datas = [];
        $("#data_ficha").datepicker("destroy");
                                          
        $.getJSON('<?= base_url() ?>autocomplete/horariosdisponiveisorcamentoempresa', {medico: medico, ajax: true}, function (j) {
            
            if (j.length > 0) {                                                   
                var options = '<option value="">Selecione</option>';
                for (var c = 0; c < j.length; c++) {
                    if (j[c].data != null) {
//                                                        console.log(j[c].data);
                            var from = j[c].data.split("-");
                        var data_br =  from[2]+"/"+from[1]+"/"+from[0];
                        // if(data_br == $("#data_header").val()){ 
                        //         $("#data_ficha").val($("#data_header").val()); 
                        // }
                
                        
                        
                        array_datas.push(j[c].data_formatada_picker);
                        options += '<option value="' + j[c].data + '">' + j[c].data_formatada + '</option>';
                    }
                } 
            }else{ 
                // $("#data_ficha").val($("#data_header").val()); 
            }
            
            date_picker(array_datas); 
            $("#data_ficha").blur();
//           $("#txtdata"+index).trigger('focus');
            // $("#turno_preferencia"+index).hide();
            // $('select').trigger('click');
            // console.log(index);
                
        });
        
            // atualizarajuste();  
    }


    function date_picker(array_Dates) {
        console.log('passou aqui tbm');      
        $("#data_ficha").datepicker({
            beforeShowDay: function (d) {
                // normalize the date for searching in array
                var dmy = "";
                dmy += ("00" + d.getDate()).slice(-2) + "-";
                dmy += ("00" + (d.getMonth() + 1)).slice(-2) + "-";
                dmy += d.getFullYear();
                return [$.inArray(dmy, array_Dates) >= 0 ? true : false, ""];
            },
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    }
</script>