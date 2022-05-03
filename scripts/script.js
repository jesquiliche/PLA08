//listener estático sobre la tabla 
 

document.querySelector('table#listapersonas').onclick = function(ev) {
	//comprobar cuando hemos pulsado sobre una etiqueta <td>
	
	if (ev.target.nodeName == 'TD') {
		
		consultaPersona(ev.target)
	}
}

function consultaPersona(td) {

	//necesito localizar la etiqueta <tr> de la fila que contiene la celda pulsada
	let tr = td.closest('tr')

	//recuperar el atributo data-id de la <tr>
	let idpersona = tr.getAttribute('data-id')


	//trasladar el id al formulario oculto
	document.querySelector('#idpersona').value = idpersona

	//submit del formulario oculto
	document.querySelector('#consulta').value = idpersona
	document.querySelector('#formconsulta').submit()
}