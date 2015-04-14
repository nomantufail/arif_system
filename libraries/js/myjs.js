function confirm_deleting()
{
    var d = confirm("Alert!\nAre you sure you want to delete this record?");
    if(d == true){
        return true;
    }
    return false;
}

function check_boxes(){
    var is_checcked = $('#parent_checkbox').is(":checked");
    if(is_checcked == true){
        var boxes = document.getElementsByClassName('filter_check_box');
        for(var count = 0; count < boxes.length; count++){
            boxes[count].checked = true;
        }
    }else{
        var boxes = document.getElementsByClassName('filter_check_box');
        for(var count = 0; count < boxes.length; count++){
            boxes[count].checked = false;
        }
    }
}

function remove_element(id)
{
    var elem = document.getElementById(id);
    elem.parentNode.removeChild(elem);
}

function limit_number(number)
{
    number = Math.round(number * 1000)/1000;
    return number;
}
function showDiv(id)
	{
		var myform = document.getElementById(id);
     	//myform.style.display = "block";
        var id = "#"+id;
        $(id).fadeIn();

	}
	function hideDiv(id)
	{
		var myform = document.getElementById(id);
		//myform.style.display = "none";
        var id = "#"+id;
        //alert(id);
        $(id).fadeOut();
	
	}

	function appendInput(location,type,name,id,className,value)
	{
		var foo = document.getElementById(location);
		var input=document.createElement("input");
		input.type = type;
		input.className=className;
		input.name = name;
		input.value = value;
		foo.appendChild(input);
	}
	function setCookie(cname,cvalue,exdays)
	{
		var d = new Date();
		d.setTime(d.getTime()+(exdays*24*60*60*1000));
		var expires = "expires="+d.toGMTString();
		document.cookie = cname + "=" + cvalue + "; " + expires;
	}
	
	function getCookie(cname)
	{
		
		
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for(var i=0; i<ca.length; i++)
		  {
		  var c = ca[i].trim();
		  if (c.indexOf(name)==0) return c.substring(name.length,c.length);
		}
		return "";
	}

	function myfunction()
	{
		var inputNumber = document.myform.inputNumber.value;
		inputNumber = Number(inputNumber)+1;
		document.myform.inputNumber.value = inputNumber;
		appendInput("properties","text",inputNumber,"myid","dText","hello");
		var submitContainer = document.getElementById("submit");
		submitContainer.innerHTML = "";
		appendInput("submit","submit","submitProperties","submitProperties","submitProperties","Go");
		
	}
function testAlert(){
    alert();
}