document.onkeydown = function()
{
  // a presonar el f5 se actuliza la misma pagina..
  if(window.event && window.event.keyCode == 116) 
  {    
    var URLactual = window.location.href;    
    window.location = URLactual;
    return false;
  }
 
  // cuando el usuario presione el boton retroce regrese url anterior (No sirve no deja borrar)
  // if(window.event && window.event.keyCode == 8)
  // { 
  //     var URLanterior = document.referrer; 
  //     window.location = URLactual;
  //     return false;
  // }  
}

$('input,button,select,password').bind('keypress', function(event) {
  //alert(event.which);
  if(event.which == 13) {
    cb = parseInt($(this).attr('tabindex'));
    
        if ($(':input[tabindex=\'' + (cb + 1) + '\']') != null) 
        {
            $(':input[tabindex=\'' + (cb + 1) + '\']').focus();
            $(':input[tabindex=\'' + (cb + 1) + '\']').select();
            e.preventDefault();
            return false;   
    }
    obj.focus();
  }
});

function ValidaSoloNumeros(e) 
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==8) return true;
  patron = /\d/;
  te = String.fromCharCode(tecla);
  return patron.test(te);
} 

function maximaLongitud(texto,maxlong) { 
  var tecla, in_value, out_value; 

  if (texto.value.length > maxlong) { 
    in_value = texto.value; 
    out_value = in_value.substring(0,maxlong); 
    texto.value = out_value; 
    return false; 
  } 
  return true; 
} 

function ValidaSoloLetras(e){
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toLowerCase();
  letras = " áéíóúabcdefghijklmnñopqrstuvwxyz\361";
  especiales = [8,37,39,46];
  
  tecla_especial = false;
  for(var i in especiales){
    if(key == especiales[i]){
      tecla_especial = true;
      break;
    } 
  } 
  
    if(letras.indexOf(tecla)==-1 && !tecla_especial)
  {
      return false;
  }
}

function validacorreo(email)
{  
  var miObjeto = new Object();

  //valida que el campo cedula no este vacio y que no tenga menos de 7 caracteres 
  if ((email.length < 0) || (email == ""))
  {
    miObjeto.resultado = "1";
    miObjeto.msn = "Ingrese el email";
    return(JSON.stringify(miObjeto)); 
  }
  else
  {
    //var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    //var regex = /^[\-.A-Za-z0-9_]*@[A-Za-z0-9_]+.[A-Za-z0-9_.]+[A-za-z]$/;    
    //var filter=/^[A-Za-z][A-Za-z0-9_]*@[A-Za-z0-9_]+.[A-Za-z0-9_.]+[A-za-z]$/;
    var filter = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i; 
    

    if (!filter.test(email))
    { 
      miObjeto.resultado = "2";
      miObjeto.msn = "Email incorrecto";
      return(JSON.stringify(miObjeto));
    } 
    else
    {
      miObjeto.resultado = "0";
      miObjeto.msn = "";
      return(JSON.stringify(miObjeto));
    }
  }
}

function validacedula(cedula)
{   
  var miObjeto = new Object();
  
  //********************************************************************//
  //*********************  VALIDACION DE CEDULA  ***********************//
  //********************************************************************//
  //valida que el campo cedula no este vacio y que no tenga menos de 7 caracteres 
  if (cedula.length < 7) 
  {
    miObjeto.resultado = "1";
    miObjeto.msn = "Ingrese el n\u00famero de c\u00e9dula con un minimo de 7 caracteres";
    return(JSON.stringify(miObjeto)); 
  }
  else
  {
    //valida que se ingresen solo numeros al campo cedula
    var checkOK = "1234567890";
    var checkStr = cedula;
    var allValid = true; 
    for (i = 0; i < checkStr.length; i++)
    {
      ch = checkStr.charAt(i); 
      for (j = 0; j < checkOK.length; j++)
        if (ch == checkOK.charAt(j))
          break;
        if (j == checkOK.length) 
        { 
          allValid = false; 
          break; 
        }
    }  
    if (!allValid) 
    { 
      miObjeto.resultado = "2";
      miObjeto.msn = "Ingrese sólo numeros en el campo \"C\u00e9dula\".";
      return(JSON.stringify(miObjeto)); 
    } 
    else
    {
      miObjeto.resultado = "0";
      miObjeto.msn = "";
      return(JSON.stringify(miObjeto)); 
    }
  }  
}

function validarif(rif)
{   
  var miObjeto = new Object();
  
  //********************************************************************//
  //*********************  VALIDACION DE CEDULA  ***********************//
  //********************************************************************//
  //valida que el campo rif no este vacio y que no tenga menos de 7 caracteres 
  if (rif.length < 9) 
  {
    miObjeto.resultado = "1";
    miObjeto.msn = "Ingrese el n\u00famero de RIF con un minimo de 9 caracteres";
    return(JSON.stringify(miObjeto)); 
  }
  else
  {
    //valida que se ingresen solo numeros al campo rif
    var checkOK = "1234567890";
    var checkStr = rif;
    var allValid = true; 
    for (i = 0; i < checkStr.length; i++)
    {
      ch = checkStr.charAt(i); 
      for (j = 0; j < checkOK.length; j++)
        if (ch == checkOK.charAt(j))
          break;
        if (j == checkOK.length) 
        { 
          allValid = false; 
          break; 
        }
    }  
    if (!allValid) 
    { 
      miObjeto.resultado = "2";
      miObjeto.msn = "Ingrese sólo numeros en el campo \"RIF\".";
      return(JSON.stringify(miObjeto)); 
    } 
    else
    {
      miObjeto.resultado = "0";
      miObjeto.msn = "";
      return(JSON.stringify(miObjeto)); 
    }
  }  
}

function addZ(n) {
  return (n<10? '0':'') + n;
}

function validarFormatoFecha(campo) {
      var RegExPattern = /^\d{1,2}\/\d{1,2}\/\d{2,4}$/;
      if ((campo.match(RegExPattern)) && (campo!='')) {
            return true;
      } else {
            return false;
      }
}

function existeFecha(fecha){
      var fechaf = fecha.split("/");
      var day = fechaf[0];
      var month = fechaf[1];
      var year = fechaf[2];
      var date = new Date(year,month,'0');
      if((day-0)>(date.getDate()-0)){
            return false;
      }
      return true;
}

function formatToDate(_date,_format,_delimiter)
{
  if((_format == 'DDMMYYYY') && (_delimiter == '/'))
  {
    return _date.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
  }

  if((_format == 'DDMMYYYY') && (_delimiter == '-'))
  {
    return _date.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3-$2-$1');
  }

  if((_format == 'MMDDYYYY') && (_delimiter == '/'))
  {
    return _date.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$2/$3/$1');
  }

  if((_format == 'MMDDYYYY') && (_delimiter == '-'))
  {
    return _date.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$2-$3-$1');
  }

  return "ERRORRRRRRRR"
}

function validarpeso(archivo, limite) 
{ 
  var input = archivo;  
  var file = input.files[0];

  //if(file.size > 30000000)
  if(file.size > limite)
  {
    return false; 
  }
  else
  {
    return true; 
  }
}

function validartipoarchivo_imagen(archivo) 
{ 
  var b = archivo.value.split('.');  
  if((b[b.length-1] == 'jpg')||(b[b.length-1] == 'JPG')||(b[b.length-1] == 'png')||(b[b.length-1] == 'PNG'))
  {
    return true;
  }
  else
  { 
    return false;
  }
}

function validartipoarchivo_video(archivo) 
{ 
  var b = archivo.value.split('.');  
  if((b[b.length-1] == 'mp4')||(b[b.length-1] == 'webm')||(b[b.length-1] == 'ogg')||(b[b.length-1] == 'ogv')||(b[b.length-1] == 'oga'))
  {
    return true;
  }
  else
  { 
    return false;
  }
}

function filterFloat(evt,input){  
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{       
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {     
              return true;              
          }else if(key == 46){
                if(filter(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
          }else{
              return false;
          }
    }
}
function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
}

function desconectar(fecha){   
  window.location.href = linksitioweb;
}












            // //******************************************************************
            // //DIFERENCIA DE FECHAS
            // //******************************************************************
            //var fecha1 = '2016-07-12 00:01:00';
            //var fecha2 = '2016-07-14 00:00:00';
            
            // var arreglofechatime_desde = fecha1.split(' ');
            // var arreglofecha_desde     = arreglofechatime_desde[0].split('-');
            // var arreglotiempo_desde    = arreglofechatime_desde[1].split(':');
            // //******************************************************************
            // var arreglofechatime_hasta = fecha2.split(' ');
            // var arreglofecha_hasta     = arreglofechatime_hasta[0].split('-');
            // var arreglotiempo_hasta    = arreglofechatime_hasta[1].split(':');
            // //******************************************************************
            // var t1 = new Date();
            // var t2 = new Date();

            // t1.setHours(arreglotiempo_desde[0], arreglotiempo_desde[1], arreglotiempo_desde[2]);
            // t2.setHours(arreglotiempo_hasta[0], arreglotiempo_hasta[1], arreglotiempo_hasta[2]);

            // //Aquí hago la resta
            // t1.setHours(t1.getHours() - t2.getHours(), t1.getMinutes() - t2.getMinutes(), t1.getSeconds() - t2.getSeconds());

            // //Imprimo el resultado
            // valor = "La diferencia es de: " + (t1.getHours() ? t1.getHours() + (t1.getHours() > 1 ? " horas" : " hora") : "") + (t1.getMinutes() ? ", " + t1.getMinutes() + (t1.getMinutes() > 1 ? " minutos" : " minuto") : "") + (t1.getSeconds() ? (t1.getHours() || t1.getMinutes() ? " y " : "") + t1.getSeconds() + (t1.getSeconds() > 1 ? " segundos" : " segundo") : "");
            // //******************************************************************








            // //******************************************************************
            // //DIFERENCIA DE FECHAS
            // //******************************************************************
            // var fecha1 = moment('2016-07-12 00:01:00');
            // var fecha2 = moment('2016-07-14 00:02:00');

            // //------------------------------------------------------------------------------
            // milliseconds = fecha2.diff(fecha1, 'milliseconds');            
            // var ms       = milliseconds % 1000;
            // milliseconds = (milliseconds - ms) / 1000;
            // var secs     = milliseconds % 60;
            // milliseconds = (milliseconds - secs) / 60;
            // var mins     = milliseconds % 60;
            // var hrs      = (milliseconds - mins) / 60;
            // //------------------------------------------------------------------------------
            // //return addZ(hrs) + ':' + addZ(mins) + ':' + addZ(secs)+ '.' + addZ(ms);

            // alert('Hace: ' + addZ(hrs) + 'horas, ' + addZ(mins) + 'minutos, ' + addZ(secs) + 'segundos, ' + addZ(ms) + 'milisegundos. ');
            // //******************************************************************