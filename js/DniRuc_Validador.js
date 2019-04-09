var provincia;
var digitos = [];
var consecutivo = [];
var resultado = 0;
var digitoVer = 0;
var digitoVerComparar = 0;
var expreg = /^[0-9]+$/i;
var expreg2 = /^[a-zA-Z0-9]+$/i;

function DniRuc_Validador(valor, tipo){
// ************Validar cédula*******************
	valor = $(valor).val();
	if(valor != "" || valor != null){
		if(tipo == 2){
			if(expreg.test(valor)){
				return validarCedulaEcuador(valor, tipo);
			}
		}

		if(tipo == 1){
			if(expreg.test(valor)){
				if(validarRucPersonaNatural(valor, tipo) 
					|| validarRucPersonaJuridica(valor)
					|| validarRucInstitucionPublica(valor)){
					return true;
				}
				else{
					return false;
				}
			}
		}

		if(tipo == 3){
			if(expreg2.test(valor) && valor.length >= 6){
				return true;
			}
			else{
				return false;
			}
		}
	}
}

function validarCedulaEcuador(valor, tipo){
	provincia = valor.substr(0,2);
	longitud = 10;
	if(tipo == 1){
		longitud = 13;
	}
	if(provincia >= 1 && provincia <= 24){
		if(valor.length == longitud){
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

			    consecutivo[0] = (digitos[0]) * 2; if(consecutivo[0] > 9) consecutivo[0] -= 9;       
			    consecutivo[1] = (digitos[1]) * 1;         
			    consecutivo[2] = (digitos[2]) * 2; if(consecutivo[2] > 9) consecutivo[2] -= 9;         
			    consecutivo[3] = (digitos[3]) * 1;         
			    consecutivo[4] = (digitos[4]) * 2; if(consecutivo[4] > 9) consecutivo[4] -= 9;         
			    consecutivo[5] = (digitos[5]) * 1;         
			    consecutivo[6] = (digitos[6]) * 2; if(consecutivo[6] > 9) consecutivo[6] -= 9;         
			    consecutivo[7] = (digitos[7]) * 1;        
			    consecutivo[8] = (digitos[8]) * 2; if(consecutivo[8] > 9) consecutivo[8] -= 9;
			    resultado = 0;
			    for (var i = 0; i < consecutivo.length; i++) {
			    	resultado += consecutivo[i];
			    }
			digitoVer = resultado%10;
			if(digitoVer == 0){
				digitoVerComparar = digitoVer;
			}
			else{
				digitoVerComparar = 10 - digitoVer;
			}
			if(digitoVerComparar == digitos[9]){
				return true;
			}
			else{
				return false;
			}
		}
	}
}

function validarRucPersonaNatural(valor, tipo){
	var sucursal = 0;
	if(validarCedulaEcuador(valor, tipo)){
		if(valor.length == 13){
			if(valor.substr(10, 12) == '001'){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	else{
		return false;
	}
}

function validarRucPersonaJuridica(valor){
	provincia = valor.substr(0,2);
	if(provincia > 1 && provincia < 24){
		digitos = [];consecutivo = [];
		if(valor.length == 13){
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

		    if(digitos[2] == 9){
		    	consecutivo[0] = (digitos[0]) * 4;       
			    consecutivo[1] = (digitos[1]) * 3;         
			    consecutivo[2] = (digitos[2]) * 2;         
			    consecutivo[3] = (digitos[3]) * 7;         
			    consecutivo[4] = (digitos[4]) * 6;         
			    consecutivo[5] = (digitos[5]) * 5;         
			    consecutivo[6] = (digitos[6]) * 4;         
			    consecutivo[7] = (digitos[7]) * 3;        
			    consecutivo[8] = (digitos[8]) * 2;
			    resultado = 0;
			    for (var i = 0; i < consecutivo.length; i++) {
			    	resultado += consecutivo[i];
			    }
			    digitoVer = resultado%11;
				if(digitoVer == 0){
					digitoVerComparar = digitoVer;
				}
				else{
					digitoVerComparar = 11 - digitoVer;
				}
				if(digitoVerComparar == digitos[9] && valor.substr(10, 3) == "001"){
					return true;
				}
				else{
					return false;
				}
		    }
		}
	}
}

function validarRucInstitucionPublica(valor){
	provincia = valor.substr(0,2);
	if(provincia > 1 && provincia < 24){
		digitos = [];consecutivo = [];
		if(valor.length == 13){
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

		    if(digitos[2] == 6){
		    	consecutivo[0] = (digitos[0]) * 3;       
			    consecutivo[1] = (digitos[1]) * 2;         
			    consecutivo[2] = (digitos[2]) * 7;         
			    consecutivo[3] = (digitos[3]) * 6;         
			    consecutivo[4] = (digitos[4]) * 5;         
			    consecutivo[5] = (digitos[5]) * 4;         
			    consecutivo[6] = (digitos[6]) * 3;         
			    consecutivo[7] = (digitos[7]) * 2;
			    resultado = 0;
			    for (var i = 0; i < consecutivo.length; i++) {
			    	resultado += consecutivo[i];
			    }
			    digitoVer = resultado%11;
				if(digitoVer == 0){
					digitoVerComparar = digitoVer;
				}
				else{
					digitoVerComparar = 11 - digitoVer;
				}
				if(digitoVerComparar == digitos[8] && valor.substr(10, 3) == "001" && digitos[9] == 0){
					return true;
				}
				else{
					return false;
				}
		    }
		}
	}
}