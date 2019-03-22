	var tipo;
	var retorno = true;
	var provincia = "";
	var valor;
	var numeroProvincias = 24;
	var digitos = [];
	var decena_inmediata = 0;
	var consecutivo = [];
	var resultado = 0;
	var expreg = /^[0-9]+$/i;
	var expreg2 = /^[a-zA-Z0-9]+$/i;
	var decimo_digito = 0;

	function DniRuc_Validador(obj,tipo){

		var val_retorno = false;
			valor = $(obj).val();

			// codigo de provincia entre 0 y 24
			provincia = valor.substr(0,2);
				if(valor != "" || valor != null){

					if(tipo != 3){

						if(!expreg.test(valor) || (provincia < 1 || provincia > numeroProvincias)){
							val_retorno =  true;
							console.log(valor);
						}
						else{
								val_retorno =  false;
								console.log('entro');
						}
					}
			// ********************** validar tipo 2 == cedula************************
					if(tipo == 2){

						if(procesoValidacionPersonaNatural(tipo, valor) == 1){
								val_retorno =  false;
						}
						else{
							val_retorno =  true;
						}
					}
					if(tipo == 1){
						if(procesoValidacionPersonaNatural(tipo, valor) == 1 || procesoValidacionRucJuridicaPublico(tipo, valor) ==1){
								val_retorno =  false;
						}
						else{
							val_retorno =  true;
						}
					}
					if(tipo == 3){
						if(expreg2.test(valor) && valor.length >=6){
								val_retorno =  false;
						}
						else{
							val_retorno =  true;
						}
					}
				}
		return val_retorno;
	}


	function procesoValidacionPersonaNatural(tipo, valor){
		var retorno_val = 0;
		resultado = 0;
		digitos = [];
		consecutivo = [];
			if(valor.length >= 10 && valor.length <=13){
					digitos[0]  = valor.substr(0,1);         
				    digitos[1]  = valor.substr(1,1);         
				    digitos[2]  = valor.substr(2,1);         
				    digitos[3]  = valor.substr(3,1);         
				    digitos[4]  = valor.substr(4,1);         
				    digitos[5]  = valor.substr(5,1);         
				    digitos[6]  = valor.substr(6,1);         
				    digitos[7]  = valor.substr(7,1);         
				    digitos[8]  = valor.substr(8,1);         
				    digitos[9]  = valor.substr(9,1); 
				    // Se trabajan solo con los nueve digitos de la cedula mas no con el ultimo debido a que es el digito verificador
				    // cedula de ciudadania el tercer digito es menor a 6
				    // if(digitos[2] < 6){
				    	consecutivo[0] = (digitos[0]) * 2; if(consecutivo[0] > 9) consecutivo[0] -= 9;       
					    consecutivo[1] = (digitos[1]) * 1;         
					    consecutivo[2] = (digitos[2]) * 2; if(consecutivo[2] > 9) consecutivo[2] -= 9;         
					    consecutivo[3] = (digitos[3]) * 1;         
					    consecutivo[4] = (digitos[4]) * 2; if(consecutivo[4] > 9) consecutivo[4] -= 9;         
					    consecutivo[5] = (digitos[5]) * 1;         
					    consecutivo[6] = (digitos[6]) * 2; if(consecutivo[6] > 9) consecutivo[6] -= 9;         
					    consecutivo[7] = (digitos[7]) * 1;        
					    consecutivo[8] = (digitos[8]) * 2; if(consecutivo[8] > 9) consecutivo[8] -= 9;
					    for (var i = 0; i < consecutivo.length; i++) {
					    	resultado += consecutivo[i];
					    }
					  	// se le resta la decena inmediata al resultado
					  	decena_inmediata = (parseInt((resultado+"").substr(0,1)) + 1) * 10;
					  	decimo_digito = digitos[9];
					  	if((decena_inmediata - resultado) == decimo_digito){
					  		if(tipo == 2){
					  			if(valor.length == 10){
					  				retorno_val = 1;
					  			}
					  		}
					  		if(tipo == 1){
					  			if(valor.substr(10,3) == "001"){
					  				retorno_val = 1;
					  			}
					  		}
					  	}
				    // }
			}

	    return retorno_val;
	}

	function procesoValidacionRucJuridicaPublico(tipo, valor){
		var retorno_val = 0;
		var coeficientes = [];
		var modulo = 11;
		var digito;
		resultado = 0;
		digitos = [];
		consecutivo = [];
		if(valor.length >= 10 && valor.length <=13){
			digitos[0]  = valor.substr(0,1);         
		    digitos[1]  = valor.substr(1,1);         
		    digitos[2]  = valor.substr(2,1);         
		    digitos[3]  = valor.substr(3,1);         
		    digitos[4]  = valor.substr(4,1);         
		    digitos[5]  = valor.substr(5,1);         
		    digitos[6]  = valor.substr(6,1);         
		    digitos[7]  = valor.substr(7,1);         
		    digitos[8]  = valor.substr(8,1);         
		    digitos[9]  = valor.substr(9,1);
		    digitos[10]  = valor.substr(10,1);
		    digitos[11]  = valor.substr(11,1);
		    digitos[12]  = valor.substr(12,1);
		    // RUC instituciones publicas tercer digito == 6
		    if(digitos[2] == 6){
		    	digito = 0;
		    	coeficientes = [];
		    	coeficientes = [3,2,7,6,5,4,3,2];
		    	consecutivo[0] = (digitos[0]) * coeficientes[0];       
			    consecutivo[1] = (digitos[1]) * coeficientes[1];         
			    consecutivo[2] = (digitos[2]) * coeficientes[2];         
			    consecutivo[3] = (digitos[3]) * coeficientes[3];         
			    consecutivo[4] = (digitos[4]) * coeficientes[4];         
			    consecutivo[5] = (digitos[5]) * coeficientes[5];         
			    consecutivo[6] = (digitos[6]) * coeficientes[6];         
			    consecutivo[7] = (digitos[7]) * coeficientes[7];
			    for (var i = 0; i < consecutivo.length; i++) {
			    	resultado += consecutivo[i];
			    }
			   	digito = modulo - ((resultado%modulo));
			   	if(digito == digitos[8]){
			   		if(valor.substr(9,4) == "0001"){
			   			retorno_val = 1;
			   		}
			   	}
			}
			else
			if(digitos[2] == 9){
		    	digito = 0;
		    	coeficientes = [];
		    	coeficientes = [4,3,2,7,6,5,4,3,2];
		    	consecutivo[0] = (digitos[0]) * coeficientes[0];       
			    consecutivo[1] = (digitos[1]) * coeficientes[1];         
			    consecutivo[2] = (digitos[2]) * coeficientes[2];         
			    consecutivo[3] = (digitos[3]) * coeficientes[3];         
			    consecutivo[4] = (digitos[4]) * coeficientes[4];         
			    consecutivo[5] = (digitos[5]) * coeficientes[5];         
			    consecutivo[6] = (digitos[6]) * coeficientes[6];         
			    consecutivo[7] = (digitos[7]) * coeficientes[7];
			    consecutivo[8] = (digitos[8]) * coeficientes[8];
			    for (var i = 0; i < consecutivo.length; i++) {
			    	resultado += consecutivo[i];
			    }
			   	digito = modulo - ((resultado%modulo));
			   	if(digito == digitos[9]){
			   		if(valor.substr(10,3) == "001"){
			   			retorno_val = 1;
			   		}
			   	}
			}
		}
		return retorno_val;
	}

