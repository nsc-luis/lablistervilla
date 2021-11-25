$(function(){
	$(".btnBuscarPaciente")
		.button({
			icons: { primary: "ui-icon-search" }
		})
		.css({
			"font-size": "initial !important",
		})
		.click(function(){
			$( "#dlgBuscarPaciente" ).dialog( "open" )
		});
		
	$("#btnAddEstudio")
		.button({
			icons: { primary: "ui-icon-plus" }
		})
		.click(function(){
			$( "#dlgAddEstudio" ).dialog( "open" );
		});
		
	$("#btnAddPaquete")
		.button({
			icons: { primary: "ui-icon-plus" }
		})
		.click(function(){
			$("#dlgAddPaquete").dialog("open");
		});
	
	$("#btnGuardarCaptura")
		.button({
			icons: { primary: "ui-icon-disk" }
		});
		
	$("#btnBorrarCaptura")
		.button({
			icons: { primary: "ui-icon-trash" }
		});
		
	$(".btnBorrarPartida")
		.button({
			icons: { primary: "ui-icon-trash" },
			text: false
		})
		.css({
			"font-size": "10px"
		});
		
	$("#btnBuscarPaciente")
		.button({
			icons: { primary: "ui-icon-search" }
		});
		
	$("#dlgBuscarPaciente").dialog({
		height: "auto",
		width: "auto",
		modal: true,
		autoOpen: false,
		buttons : {
			Aceptar : function() { alert("Hi") },
			Cancelar : function() { $( this ).dialog( "close" ) }
		}
	});
	
	$("#dlgAddEstudio").dialog({
		height: "auto",
		width: "auto",
		modal: true,
		autoOpen: false,
		buttons : {
			Aceptar : function() { alert("Hi") },
			Cancelar : function() { $( this ).dialog( "close" ) }
		}
	});
	
	$("#dlgAddPaquete").dialog({
		height: "auto",
		width: "auto",
		modal: true,
		autoOpen: false,
		buttons : {
			Aceptar : function() { alert("Hi") },
			Cancelar : function() { $( this ).dialog( "close" ) }
		}
	});
});