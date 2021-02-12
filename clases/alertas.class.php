<?php
  class alertas{

    function success($titulo){
        return "
        <script>
             alertify.notify('$titulo', 'success', 5, function(){  console.log('dismissed'); });
        </script>
        ";
    }

    function error($titulo){
      return "
      <script>
           alertify.notify('$titulo', 'error', 5, function(){  console.log('dismissed'); });
      </script>
      ";
    }

    function alerta($titulo,$cuerpo){
      return "
          <script>
             var closable = alertify.alert().setting('closable');
            alertify.alert()
              .setting({
                'title' : '$titulo',
                'label':'Ok',
                'message': '$cuerpo' ,
                'onok': function(){ alertify.success('Correcto');}
              }).show();
          </script>  
       ";

  }
}
?>