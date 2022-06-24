function valBusqueda(){
	if(checkEmptyData($("#busqueda").val())==false||checkEmptyData($("#fechaMin").val())==false|| checkEmptyData($("#fechaMax").val())==false){
		if(checkEmptyData($("#busqueda").val())&&(checkEmptyData($("#fechaMin").val())==false||checkEmptyData($("#fechaMax").val())==false)){
			window.location='news-searcher.php?fechaMin='+$("#fechaMin").val()+'&fechaMax='+$("#fechaMax").val()+'&Orden=1&Texto=1&query=';
		}else if(checkEmptyData($("#busqueda").val())==false &&(checkEmptyData($("#fechaMin").val())==false||checkEmptyData($("#fechaMax").val())==false)){
			//$("#formBusqueda").submit();  busqueda=&fechaMin=&fechaMax=
			// variables en searcher Estado=1&Orden=1&Texto=1&fechaMin=&fechaMax=&TypeDate=1&query_text=
			window.location='news-searcher.php?query='+$("#busqueda").val()+'&fechaMin='+$("#fechaMin").val()+'&fechaMax='+$("#fechaMax").val()+'&Orden=1&Texto=1';
		}else if(checkEmptyData($("#busqueda").val())==false){
			window.location='news-searcher.php?query='+$("#busqueda").val()+'&fechaMin=&fechaMax=&Orden=1&Texto=1';
		}else{
		Swal.fire(
		  'Error',
		  'Verifica que no hayas dejado campos en blanco, e intenta de nuevo',
		  'error'
		);
			
		}
	}else{
		Swal.fire(
			'Error',
			'Verifica que no hayas dejado campos en blanco, e intenta de nuevo',
			'error'
		  );
	}
	
}
function checkEmptyData(input){
	if(input==="" || input===null || input.lenght===0){
		return true;
	}else{
		return false;
	}
}