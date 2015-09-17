<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){

    $('input').blur(function(){
        var field = $(this);
        var parent = field.parent().attr('id');
        field.css('background-color','#F3F3F3');

        if($('#'+parent).find(".ok").length){
            $('#'+parent+' .ok').remove();
            $('#'+parent+' .loader').remove();
            $('#'+parent).append('<div><img src="../images/loader.gif"/></div>').fadeIn('slow');
        }else{
           // $('#'+parent).append('<div><img src="../images/loader.gif"/></div>').fadeIn('slow');
        }

        var dataString = 'value='+$(this).val()+'&field='+$(this).attr('name'); 

       //alert(dataString);
        $.ajax({
            type: "POST",
            url: "edit.php",
            data: dataString,
            success: function(data) {
                field.val(data);
                $('#'+parent+' .loader').fadeOut(function(){
                	alert("hola");
                    $('#'+parent).append('<div><img src="../images/ok.png"/></div>').fadeIn('slow');
                });

            }
        });
    });
});
</script>

<?php
@require ("main_valida.php");


?>
<form id="ficha">
	<input type='text' id="idind_secretaria" name='idind_secretaria' value='10' />
    <div id="content_descripcion">
        <label>Nombre</label>
        <input type="text" id="descripcion" name="descripcion" value="asdasd" />
    </div>
    <div id="content_metodologia">
        <label>Apellidos</label>
           <input type="text" id="metodologia" name="metodologia" value="<?=$row['lastname']?>" />
    </div>
    <div id="content_fuente">
        <label>Email</label>
        <input type="text" id="fuente" name="fuente" value="<?=$row['email']?>" />
    </div>
    <div id="content_palabra">
        <label>Biografía</label>
        <textarea rows="7" cols="30" name="palabra"><?=$row['biography']?></textarea>
    </div>
</form>