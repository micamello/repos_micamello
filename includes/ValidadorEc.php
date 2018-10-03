<?php
class ValidadorEc
{
    static public function validarCedula($numero)
    {
        // fuerzo parametro de entrada a string
        $numero = (string) $numero;

        // borro por si acaso errores de llamadas anteriores.
        self::setError('');

        // validaciones
        try {
            self::validarInicial($numero, '10');
            self::validarCodigoProvincia(substr($numero, 0, 2));
            self::validarTercerDigito($numero[2], 'cedula');
            self::algoritmoModulo10(substr($numero, 0, 9), $numero[9]);
        } catch (Exception $e) {
            self::setError($e->getMessage());

            return false;
        }

        return true;
    }

    /**
     * Validar RUC persona natural.
     *
     * @param string $numero Número de RUC persona natural
     *
     * @return bool
     */
    static public function validarRucPersonaNatural($numero)
    {
        // fuerzo parametro de entrada a string
        $numero = (string) $numero;

        // borro por si acaso errores de llamadas anteriores.
        self::setError('');

        // validaciones
        try {
            self::validarInicial($numero, '13');
            self::validarCodigoProvincia(substr($numero, 0, 2));
            self::validarTercerDigito($numero[2], 'ruc_natural');
            self::validarCodigoEstablecimiento(substr($numero, 10, 3), substr($numero, 12, 1));
            self::algoritmoModulo10(substr($numero, 0, 9), $numero[9]);
        } catch (Exception $e) {
            self::setError($e->getMessage());

            return false;
        }

        return true;
    }

    /**
     * Validar RUC sociedad privada.
     *
     * @param string $numero Número de RUC sociedad privada
     *
     * @return bool
     */
    static public function validarRucSociedadPrivada($numero)
    {
        // fuerzo parametro de entrada a string
        $numero = (string) $numero;

        // borro por si acaso errores de llamadas anteriores.
        self::setError('');

        // validaciones
        try {
            self::validarInicial($numero, '13');
            self::validarCodigoProvincia(substr($numero, 0, 2));
            self::validarTercerDigito($numero[2], 'ruc_privada');
            self::validarCodigoEstablecimiento(substr($numero, 10, 3), substr($numero, 12, 1));
            self::algoritmoModulo11(substr($numero, 0, 9), $numero[9], 'ruc_privada');
        } catch (Exception $e) {
            self::setError($e->getMessage());

            return false;
        }

        return true;
    }

    /**
     * Validar RUC sociedad publica.
     *
     * @param string $numero Número de RUC sociedad publica
     *
     * @return bool
     */
    static public function validarRucSociedadPublica($numero)
    {
        // fuerzo parametro de entrada a string
        $numero = (string) $numero;

        // borro por si acaso errores de llamadas anteriores.
        self::setError('');

        // validaciones
        try {
            self::validarInicial($numero, '13');
            self::validarCodigoProvincia(substr($numero, 0, 2));
            self::validarTercerDigito($numero[2], 'ruc_publica');
            self::validarCodigoEstablecimiento(substr($numero, 9, 4));
            self::algoritmoModulo11(substr($numero, 0, 8), $numero[8], 'ruc_publica');
        } catch (Exception $e) {
            self::setError($e->getMessage());

            return false;
        }

        return true;
    }

    /**
     * Validaciones iniciales para CI y RUC.
     *
     * @param string $numero     CI o RUC
     * @param int    $caracteres Cantidad de caracteres requeridos
     *
     * @throws exception Cuando valor esta vacio, cuando no es dígito y
     *                   cuando no tiene cantidad requerida de caracteres
     *
     * @return bool
     */
    static public function validarInicial($numero, $caracteres)
    {
        if (empty($numero)) {
            throw new Exception('Valor no puede estar vacio');
        }

        if (!ctype_digit($numero)) {
            throw new Exception('Valor ingresado solo puede tener dígitos');
        }

        if (strlen($numero) != $caracteres) {
            throw new Exception('Valor ingresado debe tener '.$caracteres.' caracteres');
        }

        return true;
    }

    /**
     * Validación de código de provincia (dos primeros dígitos de CI/RUC).
     *
     * @param string $numero Dos primeros dígitos de CI/RUC
     *
     * @throws exception Cuando el código de provincia no esta entre 00 y 24
     *
     * @return bool
     */
    static public function validarCodigoProvincia($numero)
    {
        if ($numero < 0 || $numero > 24) {
            throw new Exception('Codigo de Provincia (dos primeros dígitos) no deben ser mayor a 24 ni menores a 0');
        }

        return true;
    }

    /**
     * Validación de tercer dígito.
     *
     * Permite validad el tercer dígito del documento. Dependiendo
     * del campo tipo (tipo de identificación) se realizan las validaciones.
     * Los posibles valores del campo tipo son: cedula, ruc_natural, ruc_privada
     *
     * Para Cédulas y RUC de personas naturales el terder dígito debe
     * estar entre 0 y 5 (0,1,2,3,4,5)
     *
     * Para RUC de sociedades privadas el terder dígito debe ser
     * igual a 9.
     *
     * Para RUC de sociedades públicas el terder dígito debe ser
     * igual a 6.
     *
     * @param string $numero tercer dígito de CI/RUC
     * @param string $tipo   tipo de identificador
     *
     * @throws exception Cuando el tercer digito no es válido. El mensaje
     *                   de error depende del tipo de Idenficiación.
     *
     * @return bool
     */
    static public function validarTercerDigito($numero, $tipo)
    {
        switch ($tipo) {
            case 'cedula':
            case 'ruc_natural':
                if ($numero < 0 || $numero > 5) {
                    throw new Exception('Tercer dígito debe ser mayor o igual a 0 y menor a 6 para cédulas y RUC de persona natural');
                }
                break;
            case 'ruc_privada':
                if ($numero != 9) {
                    throw new Exception('Tercer dígito debe ser igual a 9 para sociedades privadas');
                }
                break;

            case 'ruc_publica':
                if ($numero != 6) {
                    throw new Exception('Tercer dígito debe ser igual a 6 para sociedades públicas');
                }
                break;
            default:
                throw new Exception('Tipo de Identificacion no existe.');
                break;
        }

        return true;
    }

    /**
     * Validación de código de establecimiento.
     *
     * @param string $numero tercer dígito de CI/RUC
     *
     * @throws exception Cuando el establecimiento es menor a 1
     *
     * @return bool
     */
    static public function validarCodigoEstablecimiento($numero, $numero2)
    {
        if ($numero < 1 || $numero2 != 1) {
            throw new Exception('Código de establecimiento no puede ser 0');
        }

        return true;
    }

    /**
     * Algoritmo Modulo10 para validar si CI y RUC de persona natural son válidos.
     *
     * Los coeficientes usados para verificar el décimo dígito de la cédula,
     * mediante el algoritmo “Módulo 10” son:  2. 1. 2. 1. 2. 1. 2. 1. 2
     *
     * Paso 1: Multiplicar cada dígito de los digitosIniciales por su respectivo
     * coeficiente.
     *
     *  Ejemplo
     *  digitosIniciales posicion 1  x 2
     *  digitosIniciales posicion 2  x 1
     *  digitosIniciales posicion 3  x 2
     *  digitosIniciales posicion 4  x 1
     *  digitosIniciales posicion 5  x 2
     *  digitosIniciales posicion 6  x 1
     *  digitosIniciales posicion 7  x 2
     *  digitosIniciales posicion 8  x 1
     *  digitosIniciales posicion 9  x 2
     *
     * Paso 2: Sí alguno de los resultados de cada multiplicación es mayor a o igual a 10,
     * se suma entre ambos dígitos de dicho resultado. Ex. 12->1+2->3
     *
     * Paso 3: Se suman los resultados y se obtiene total
     *
     * Paso 4: Divido total para 10, se guarda residuo. Se resta 10 menos el residuo.
     * El valor obtenido debe concordar con el digitoVerificador
     *
     * Nota: Cuando el residuo es cero(0) el dígito verificador debe ser 0.
     *
     * @param string $digitosIniciales  Nueve primeros dígitos de CI/RUC
     * @param string $digitoVerificador Décimo dígito de CI/RUC
     *
     * @throws exception Cuando los digitosIniciales no concuerdan contra
     *                   el código verificador.
     *
     * @return bool
     */
    static public function algoritmoModulo10($digitosIniciales, $digitoVerificador)
    {
        $arrayCoeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];

        $digitoVerificador = (int) $digitoVerificador;
        $digitosIniciales = str_split($digitosIniciales);

        $total = 0;
        foreach ($digitosIniciales as $key => $value) {
            $valorPosicion = ((int) $value * $arrayCoeficientes[$key]);

            if ($valorPosicion >= 10) {
                $valorPosicion = str_split($valorPosicion);
                $valorPosicion = array_sum($valorPosicion);
                $valorPosicion = (int) $valorPosicion;
            }

            $total = $total + $valorPosicion;
        }

        $residuo = $total % 10;

        $resultado = ($residuo == 0) ? 0 : 10 - $residuo;

        if ($resultado != $digitoVerificador) {
            throw new Exception('Dígitos iniciales no validan contra Dígito Idenficador');
        }

        return true;
    }

    /**
     * Algoritmo Modulo11 para validar RUC de sociedades privadas y públicas.
     *
     * El código verificador es el decimo digito para RUC de empresas privadas
     * y el noveno dígito para RUC de empresas públicas
     *
     * Paso 1: Multiplicar cada dígito de los digitosIniciales por su respectivo
     * coeficiente.
     *
     * Para RUC privadas el coeficiente esta definido y se multiplica con las siguientes
     * posiciones del RUC:
     *
     *  Ejemplo
     *  digitosIniciales posicion 1  x 4
     *  digitosIniciales posicion 2  x 3
     *  digitosIniciales posicion 3  x 2
     *  digitosIniciales posicion 4  x 7
     *  digitosIniciales posicion 5  x 6
     *  digitosIniciales posicion 6  x 5
     *  digitosIniciales posicion 7  x 4
     *  digitosIniciales posicion 8  x 3
     *  digitosIniciales posicion 9  x 2
     *
     * Para RUC privadas el coeficiente esta definido y se multiplica con las siguientes
     * posiciones del RUC:
     *
     *  digitosIniciales posicion 1  x 3
     *  digitosIniciales posicion 2  x 2
     *  digitosIniciales posicion 3  x 7
     *  digitosIniciales posicion 4  x 6
     *  digitosIniciales posicion 5  x 5
     *  digitosIniciales posicion 6  x 4
     *  digitosIniciales posicion 7  x 3
     *  digitosIniciales posicion 8  x 2
     *
     * Paso 2: Se suman los resultados y se obtiene total
     *
     * Paso 3: Divido total para 11, se guarda residuo. Se resta 11 menos el residuo.
     * El valor obtenido debe concordar con el digitoVerificador
     *
     * Nota: Cuando el residuo es cero(0) el dígito verificador debe ser 0.
     *
     * @param string $digitosIniciales  Nueve primeros dígitos de RUC
     * @param string $digitoVerificador Décimo dígito de RUC
     * @param string $tipo              Tipo de identificador
     *
     * @throws exception Cuando los digitosIniciales no concuerdan contra
     *                   el código verificador.
     *
     * @return bool
     */
    static public function algoritmoModulo11($digitosIniciales, $digitoVerificador, $tipo)
    {
        switch ($tipo) {
            case 'ruc_privada':
                $arrayCoeficientes = [4, 3, 2, 7, 6, 5, 4, 3, 2];
                break;
            case 'ruc_publica':
                $arrayCoeficientes = [3, 2, 7, 6, 5, 4, 3, 2];
                break;
            default:
                throw new Exception('Tipo de Identificacion no existe.');
                break;
        }

        $digitoVerificador = (int) $digitoVerificador;
        $digitosIniciales = str_split($digitosIniciales);

        $total = 0;
        foreach ($digitosIniciales as $key => $value) {
            $valorPosicion = ((int) $value * $arrayCoeficientes[$key]);
            $total = $total + $valorPosicion;
        }

        $residuo = $total % 11;

        $resultado = ($residuo == 0) ? 0 : 11 - $residuo;

        if ($resultado != $digitoVerificador) {
            throw new Exception('Dígitos iniciales no validan contra Dígito Idenficador');
        }

        return true;
    }

    /**
     * Get error.
     *
     * @return string Mensaje de error
     */
    static public function getError()
    {
        return $this->error;
    }

    /**
     * Set error.
     *
     * @param string $newError
     *
     * @return object $this
     */
    static public function setError($newError)
    {
        $error = $newError;

        return $error;
    }
}