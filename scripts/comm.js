var http_config = {
    headers: {'Content-Type' : 'application/x-www-form-urlencoded'}
}

function ms_success(json, status) {
	if ( json.msg && json.msg.length > 4 ) { alert(json.msg); }
   	if ( json.url && json.url.length > 4 ) { window.location = json.url; }
    if ( json.url && json.func.length > 2 ) { var myfunc = eval(json.func) ; myfunc(json); }
}

function ms_error() {
	alert('網路狀況不明，無法執行程式!!');
}


Array.prototype.toObject = function() {
	var Obj={};

	for(var i in this) {
		if(typeof this[i] != "function") {
			Obj[i]=this[i];
		}
	}
   
	return Obj;
}
