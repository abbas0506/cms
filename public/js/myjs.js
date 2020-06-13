function isphone(str){
	var rgx=/^0[0-9]{10}$/i;
	if(rgx.test(str)) return true;
	else return false;
}
