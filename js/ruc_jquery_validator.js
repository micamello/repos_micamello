function validarDocumento(numero,tipo,campoErr,campoSeccion,btn){  
  
  var suma = 0;      
  var residuo = 0;      
  var pri = false;      
  var pub = false;            
  var nat = false;      
  var numeroProvincias = 22;                  
  var modulo = 11;
  var error = 0;
 
  if (numero.length == 0){
    colocaError(campoErr, campoSeccion,"El campo no puede ser vacío",btn);
    return error = 1;
  } 
  
  var expregLN = /[a-zA-Z0-9]{7,}$/i;
  if ((!expregLN.test(numero) && tipo == 3) ){

    colocaError(campoErr, campoSeccion,"Pasaporte inválido",btn);                 
    return error = 1;
  }
  else if (tipo == 2 && numero.length > 10){ 

    colocaError(campoErr, campoSeccion,"Cédula inválida",btn);                 
    return error = 1;

  }else if (numero.length < 13 && tipo == 1){ 
    colocaError(campoErr, campoSeccion,"RUC inválido",btn);                 
    return error = 1;
  }

  /* Verifico que el campo no contenga letras */                    
  if (tipo == 1 || tipo == 2){
    var expreg = /^[0-9]+$/i;
    provincia = numero.substr(0,2); 
    if(!expreg.test(numero) || (provincia < 1 || provincia > numeroProvincias)){
      colocaError(campoErr, campoSeccion,"Formato inválido",btn);    
      return error = 1;
    }
  }

  if(tipo != 3)
  {
    /* Aqui almacenamos los digitos de la cedula en variables. */
    d1  = numero.substr(0,1);         
    d2  = numero.substr(1,1);         
    d3  = numero.substr(2,1);         
    d4  = numero.substr(3,1);         
    d5  = numero.substr(4,1);         
    d6  = numero.substr(5,1);         
    d7  = numero.substr(6,1);         
    d8  = numero.substr(7,1);         
    d9  = numero.substr(8,1);         
    d10 = numero.substr(9,1);                
           
    /* El tercer digito es: */                           
    /* 9 para sociedades privadas y extranjeros   */         
    /* 6 para sociedades publicas */         
    /* menor que 6 (0,1,2,3,4,5) para personas naturales */ 
    if (d3==7 || d3==8){    
      colocaError(campoErr, campoSeccion,"Formato inválido",btn);           
      return error = 1;
    }       
           
    /* Solo para personas naturales (modulo 10) */         
    if (d3 < 6){           
      nat = true;            
      p1 = d1 * 2;  if (p1 >= 10) p1 -= 9;
      p2 = d2 * 1;  if (p2 >= 10) p2 -= 9;
      p3 = d3 * 2;  if (p3 >= 10) p3 -= 9;
      p4 = d4 * 1;  if (p4 >= 10) p4 -= 9;
      p5 = d5 * 2;  if (p5 >= 10) p5 -= 9;
      p6 = d6 * 1;  if (p6 >= 10) p6 -= 9; 
      p7 = d7 * 2;  if (p7 >= 10) p7 -= 9;
      p8 = d8 * 1;  if (p8 >= 10) p8 -= 9;
      p9 = d9 * 2;  if (p9 >= 10) p9 -= 9;             
      modulo = 10;
    }         
    /* Solo para sociedades publicas (modulo 11) */                  
    /* Aqui el digito verficador esta en la posicion 9, en las otras 2 en la pos. 10 */
    else if(d3 == 6){           
      pub = true;             
      p1 = d1 * 3;
      p2 = d2 * 2;
      p3 = d3 * 7;
      p4 = d4 * 6;
      p5 = d5 * 5;
      p6 = d6 * 4;
      p7 = d7 * 3;
      p8 = d8 * 2;            
      p9 = 0;            
    }         
           
    /* Solo para entidades privadas (modulo 11) */         
    else if(d3 == 9) {           
      pri = true;                                   
      p1 = d1 * 4;
      p2 = d2 * 3;
      p3 = d3 * 2;
      p4 = d4 * 7;
      p5 = d5 * 6;
      p6 = d6 * 5;
      p7 = d7 * 4;
      p8 = d8 * 3;
      p9 = d9 * 2;            
    }
                  
    suma = p1 + p2 + p3 + p4 + p5 + p6 + p7 + p8 + p9;                
    residuo = suma % modulo;                                         
    /* Si residuo=0, dig.ver.=0, caso contrario 10 - residuo*/
    digitoVerificador = residuo==0 ? 0: modulo - residuo;                
    /* ahora comparamos el elemento de la posicion 10 con el dig. ver.*/                         
    if (pub==true){           
      if (digitoVerificador != d9){
        colocaError(campoErr, campoSeccion,"Formato inválido",btn);                                
        return error = 1;
      }                  
      /* El ruc de las empresas del sector publico terminan con 0001*/         
      if ( numero.substr(9,4) != '0001' ){
        colocaError(campoErr, campoSeccion,"Formato inválido",btn);                          
        return error = 1;
      }
    }        
    else if(pri == true){         
      if (digitoVerificador != d10){ 
        colocaError(campoErr, campoSeccion,"Formato inválido",btn);                                
        return error = 1;
      }         
      if (numero.substr(10,3) != '001' ){ 
        colocaError(campoErr, campoSeccion,"Formato inválido",btn);                          
        return error = 1;
      }
    }      
    else if(nat == true){         
      if (digitoVerificador != d10){ 
        colocaError(campoErr, campoSeccion,"Formato inválido",btn);                                 
        return error = 1;
      }         
      if (numero.length >10 && numero.substr(10,3) != '001' ){
        colocaError(campoErr, campoSeccion,"Formato inválido",btn);                           
        return error = 1;
      }
    }
  }

  return error;
}  

