function checkAll(caja)
{
	var qEstado = false;
	var cantidad = caja.length;

	if (document.getElementById('check_todos').checked){
		qEstado = true;
	}
	for (i=0; i<cantidad; i++){caja[i].checked = qEstado;}
}
