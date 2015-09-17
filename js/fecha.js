   mesarray=new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
   diaarray=new Array( "Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
   hoy = new Date();
   dias = hoy.getDate();
   dia = hoy.getDay();
   mes = hoy.getMonth();
   mes=mesarray[mes];
   dia =diaarray[dia];
   anno = hoy.getYear();
   document.write(dia+", "+dias+" "+" de "+mes+" de "+anno+"</b></font><br>")
