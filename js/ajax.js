// JavaScript Document
var Ajax = {
	data : null,
	ajaxObject : function ()
	{
		var ajaxml=false;
		try {
			ajaxml = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e) {
			try {
				ajaxml= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) { ajaxml= false; }
		}
		if (!ajaxml && typeof XMLHttpRequest!='undefined') {
			ajaxml = new XMLHttpRequest(); }
		return ajaxml;
	},
	send : function (id, url, vars, modify)
	{
		var ajax = this.ajaxObject();
		ajax.open("POST", url, true);	
		ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		ajax.send(vars);
		this.process(ajax, id, modify);
	},
	receive : function (url, vars, fcn)
	{
		var ajax = this.ajaxObject();
		ajax.open("POST", url, true);
		ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		ajax.send(vars);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				if (ajax.status == 200)
				{
					Ajax.data = ajax.responseText;
					//var data =  ajax.responseText;
					eval(fcn);
				}
				if (ajax.status == 404)
				{
					alert ("El archivo buscado no existe\nContacte con su administrador");
				}
			}
		}
	},
	returnData : function (data)
	{
		Ajax.data=data;
		//alert (Ajax.receive.data);
	},
	receivefcn : function (id, url, vars, fcn)
	{
		var ajax = this.ajaxObject();
		ajax.open("POST", url, true);	
		ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		ajax.send(vars);
		this.resultback(ajax, id, fcn);
	},
	process : function (ajax, id, modify)
	{
		if (modify)
		{
			var content = document.getElementById(id);
			content.innerHTML="Cargando Información <img src=\"img/loader.gif\" />"
		}
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				var content = document.getElementById(id);
				if (ajax.status == 200)
				{
					try
					{
						if (modify)
							content.innerHTML = ajax.responseText;
					}
					catch(e)
					{
						if (modify)
							content.innerHTML = String("&nbsp;"+ajax.responseText);
					}
				}
				if (ajax.status == 404)
				{
					var txt = "";
					txt = "<div class=\"forbidden\">";
					txt+= "<div style=\"width:100%\">Error: 404 ";
					txt+= "<img src=\"../icon/page_error.png\" title=\"Error 404\"";
					txt+= "align=\"Error 404\"</div>";
					txt+= "<div style=\"width:100%\">Contacte con su administrador</div></div>";
					content.innerHTML = txt;
					//alert ("El archivo buscado no existe\nContacte con su administrador");
				}
			}
		}
	},
	resultback : function (ajax, id, fcn2eval)
	{
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				if (ajax.status == 200)
				{
					var content = document.getElementById(id);
					content.innerHTML = ajax.responseText;
					eval(fcn2eval);
				}
			}
		}
	},
	returnback : function (ajax)
	{
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				if (ajax.status == 200)
				{
					//return ajax.responseText;
					return ("HOLA");
				}
				if (ajax.status == 404)
				{
					alert ("El archivo buscado no existe\nContacte con su administrador");
				}
			}
		}
	}
}