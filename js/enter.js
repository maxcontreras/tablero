// JavaScript Document
function intro (evt, next_id)
{
	
	switch (evt.keyCode) 
	{
        case 37: //left arrow
        case 39: //right arrow
        case 33: //page up  
        case 34: //page down  
        case 36: //home  
        case 35: //end
			break;
        case 13: //enter
			var id=document.getElementById(next_id);
			id.focus();
			break;
        case 9: //tab
			//var id=document.getElementById(next_id);
			//id.focus();
			break;
        case 27: //esc
        case 16: //shift  
        case 17: //ctrl  
        case 18: //alt  
        case 20: //caps lock
        case 8: //backspace  
        case 46: //delete 
        case 38: //up arrow 
        case 40: //down arrow
            return;
		default:
			//var id=document.getElementById(next_id);
			//id.focus();
        break;
	}
	//alert (evt.keyCode);
	if (evt.keyCode == undefined)
	{
		var id=document.getElementById(next_id);
		id.focus();
	}
}
function intro_valid (evt, field, next_id, type)
{
	switch (evt.keyCode) 
	{
        case 37: //left arrow
        case 39: //right arrow
        case 33: //page up  
        case 34: //page down  
        case 36: //home  
        case 35: //end
			break;
        case 13: //enter			
			if (Validator.field(type, field))
			{
				var id=document.getElementById(next_id);
				id.focus();
			}			
			break;
        case 9: //tab
			if (!Validator.field(type, field))
			{
				var id=document.getElementById(field);
				id.focus();
			}		
			break;
        case 27: //esc
        case 16: //shift  
        case 17: //ctrl  
        case 18: //alt  
        case 20: //caps lock
        case 8: //backspace  
        case 46: //delete 
        case 38: //up arrow 
        case 40: //down arrow
            return;
		default:
        break;
	}
}
function intro_fcn (evt, fcn, field, next_id, type)
{
	switch (evt.keyCode) 
	{
        case 37: //left arrow
        case 39: //right arrow
        case 33: //page up  
        case 34: //page down  
        case 36: //home  
        case 35: //end
			break;
        case 13: //enter
			if (Validator.fieldfcn(type, field, fcn))
			{
				var id=document.getElementById(next_id);
				id.focus();
			}
			//return val;
			break;
        case 9: //tab
			if (!Validator.fieldfcn(type, field, fcn))
			{
				var id=document.getElementById(field);
				id.focus();
			}
			alert (evt.keyCode);
			break;
        case 27: //esc
        case 16: //shift  
        case 17: //ctrl  
        case 18: //alt  
        case 20: //caps lock
        case 8: //backspace  
        case 46: //delete 
        case 38: //up arrow 
        case 40: //down arrow
            return;
		default:
	        break;
	}
}
function mouse_valid (field, next_id, type)
{		
	if (Validator.field(type, field))
	{
		var id=document.getElementById(next_id);
		id.focus();
	}
}
function mouse_fcn_combo (field, fcn2eval, type)
{		
	if (Validator.field(type, field))
	{
		eval(fcn2eval);
		//Ajax.send("combo_"+next_id, url, "data="+document.getElementById(field).value, true);
	}
}

function introajax (evt, next_id, url, vars, fcn)
{
	switch (evt.keyCode) 
	{
        case 37: //left arrow
        case 39: //right arrow
        case 33: //page up  
        case 34: //page down  
        case 36: //home  
        case 35: //end
			break;
        case 13: //enter
			//Ajax.send(next_id, url, vars, true);
			Ajax.receive(next_id, url, vars, fcn);
			//eval(fcn2eval);
			//var id=document.getElementById(next_id);
			//id.focus();
			break;
        case 9: //tab
			//Ajax.send(next_id, url, vars, true);
			Ajax.receive(next_id, url, vars, fcn);
			//eval(fcn2eval);
			//var id=document.getElementById(next_id);
			//id.focus();
			break;
        case 27: //esc
        case 16: //shift  
        case 17: //ctrl  
        case 18: //alt  
        case 20: //caps lock
        case 8: //backspace  
        case 46: //delete 
        case 38: //up arrow 
        case 40: //down arrow
            return;
		default:
			//Ajax.receive(next_id, url, vars, fcn);
        break;
	}
}