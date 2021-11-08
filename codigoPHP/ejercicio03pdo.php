<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Fernandez Ramirez">
        <title>Ejercicio 03 PDO</title>
        <style>
            form{
                margin-top: 15px;
                margin-bottom: 70px;
            }
            fieldset{
                border: 2px solid black;
                width: 700px;
                margin:auto;
            }
            ul{
                list-style: none;
            }
            ul li{
                padding-left: 15px;
                padding-bottom: 15px;
                padding-right: 15px;
            }
            span{
                font-size: 90%;
                color: red;
            }
            .enviar{
                width: 200px;
                font-size: 100%;
                padding: 5px;
                text-align: center;
                background-color: #252525;
                color: white;
                text-transform: uppercase;
                margin-left: 215px;
            }
            div input{
                width: 310px;
            }
            fieldset p:first-child{
                font-size: 190%;
                padding-top: 15px;
                padding-left: 15px;
                padding-bottom: 15px;
            }
            table{
                border-collapse: collapse;
            }
            th{
                border: 1px solid black;
            }
            td{
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
            <?php
            /*
             * @author: Alberto Fernandez Ramirez
             * @version: v1.Realizacion del ejercicio
             * Created on: 05-Noviembre-2021
             * Ejercicio 3. Formulario para añadir un departamento a la tabla Departamento con validación de entrada y control de errores.
             */
            //Incluyo las variables de la conexion
            require_once '../config/configDBPDO.php';
            require_once '../core/210322ValidacionFormularios.php';
            
            //Variable obligatorio inicializada a 1
            define("OBLIGATORIO", 1);
            
            //Variables maximos y minimos
            define("TAMANO_MAXIMO_COD",3);//Maximo del campo CodDepartamento
            define("TAMANO_MINIMO_COD",3);//Minimo del campo CodDepartamento
            define("TAMANO_MAXIMO_DESC",255);//Maximo del campo DescDepartamento
            define("TAMANO_MINIMO_DESC",0);//Minimo del campo DescDepartamento
            define("TAMANO_MAXIMO_VOLUMEN",3.402823466E+38);//Maximo del campo VolumenNegocio
            define("TAMANO_MINIMO_VOLUMEN",0);//Minimo del campo VolumenNegocio
            
            //Variable de entrada correcta inicializada a true
            $entradaOK = true;
            
            //Creo el array de errores y lo inicializo a null
            $aErrores = [
                'codDepartamento' => null,
                'descDepartamento' => null,
                'volumenNegocio' => null
            ];
            
            //Creo el array de respuestas y lo incializo a null
            $aRespuestas = [
                'codDepartamento' => null,
                'descDepartamento' => null,
                'volumenNegocio' => null
            ];
            
            //Comprobar si se ha pulsado el boton enviar en el formulario
            if (isset($_REQUEST['enviar'])) {
                //Comprobar si el campo CodDepartamento esta bien rellenado
                $aErrores['codDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['codDepartamento'], TAMANO_MAXIMO_COD, TAMANO_MINIMO_COD, OBLIGATORIO);
                if($aErrores['codDepartamento'] == null){
                    //Realizo la conexion
                    try{
                        echo 'Conexion realizada.';
                        //Hago la conexion con la base de datos
                        $DAW207DBDepartamentos = new PDO(HOST, USER, PASSWORD);
                        // Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
                        $DAW207DBDepartamentos -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                        $consulta = ('SELECT * FROM Departamento');//creo el select de la tabla departamento
                        $resultadoConsulta = $DAW207DBDepartamentos->prepare($consulta);//preparo la consulta
                        
                        $resultadoConsulta->execute();//ejecuto la consulta
                        
                        $registroConsulta = $resultadoConsulta->fetchObject();//Obtengo el primer registro de la consulta como objeto
                        while($registroConsulta){ // recorro los registros que devuelve la consulta de la consulta 
                            if($registroConsulta->CodDepartamento == strtoupper($_REQUEST['codDepartamento'])){ // si hay algun codigo de departamento que coincida con lo que ha introducido el usuario
                                $aErrores['codDepartamento']= "El código de Departamento introducido ya existe."; // meto un mensaje de error en el array de errores del codigo del departamento
                            }
                            $registroConsulta = $resultadoConsulta->fetchObject();  // guardo el registro actual como un objeto y avanzo el puntero al siguiente registro de la consulta
                        }
                    }catch(PDOException $excepcion){//Codigo que se ejecuta si hay algun error
                        $errorExcepcion = $excepcion->getCode();//Obtengo el codigo del error y lo almaceno en la variable errorException
                        $mensajeException = $excepcion->getMessage();//Obtengo el mensaje del error y lo almaceno en la variable mensajeException

                        echo "<span style='color: red'>Codigo del error: </span>" . $errorExcepcion;//Muestro el codigo del error
                        echo "<span style='color: red'>Mensaje del error: </span>" . $mensajeException;//Muestro el mensaje del error
                    }finally{
                        //Cierro la conexion
                        unset($DAW207DBDepartamentos);
                    }
                }
                //Comprobar si el campo DescDepartamento esta bien rellenado
                $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['descDepartamento'], TAMANO_MAXIMO_DESC, TAMANO_MINIMO_DESC, OBLIGATORIO);
                //Comprobar si el campo es un float
                $aErrores['volumenNegocio'] = validacionFormularios::comprobarFloat($_REQUEST['volumenNegocio'], TAMANO_MAXIMO_VOLUMEN, TAMANO_MINIMO_VOLUMEN, OBLIGATORIO);
                
                //Comprobar si algun campo del array de errores ha sido rellenado
                foreach ($aErrores as $campo => $error) {//recorro el array errores
                    if ($error != null) {//compruebo si hay algun error
                        $_REQUEST[$campo] = '';//limpio el campo
                        $entradaOK = false;//le doy el valor false a entradaOK
                    }
                }
            } else {//si el usuario no le ha dado a enviar
                $entradaOK = false;//le doy el valor false a entradaOK
            }
            
            if($entradaOK){ // si la entrada es true recojo los valores del array aRespuestas
                $aRespuestas['codDepartamento'] = strtoupper($_REQUEST['codDepartamento']); // strtoupper() transforma los caracteres de un string a mayuscula
                $aRespuestas['descDepartamento'] = $_REQUEST['descDepartamento']; 
                $aRespuestas['volumenNegocio'] = $_REQUEST['volumenNegocio'];
                    
                    
            echo "<h2>Contenido tabla Departamento</h2>";
                //Realizo la conexion
                try{
                    echo 'Conexion realizada.';
                    //Hago la conexion con la base de datos
                    $DAW207DBDepartamentos = new PDO(HOST, USER, PASSWORD);
                    // Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
                    $DAW207DBDepartamentos -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                           
                    //INSERCION DE DATOS EN DEPARTAMENTOS
                    //Creacion de la consulta que inserta los datos en Departamento
                    $consultaInsertar = <<<CONSULTA
                            INSERT INTO Departamento(CodDepartamento,DescDepartamento,VolumenNegocio) VALUES 
                            (:CodDepartamento, :DescDepartamento,:VolumenNegocio);
                            CONSULTA;
                    $ejecutarConsulta=$DAW207DBDepartamentos->prepare($consultaInsertar); // Preparo la consulta antes de ejecutarla
                    //Creo un array con los parametros que hay que insertar obtenidos del array de respuestas
                    $parametros = [ ":CodDepartamento" => $aRespuestas['codDepartamento'],
                                    ":DescDepartamento" => $aRespuestas['descDepartamento'],
                                    ":VolumenNegocio" => $aRespuestas['volumenNegocio'] ];
                    
                    $ejecutarConsulta->execute($parametros); // Ejecuto la consulta pasando los parametros del array de parametros
                    
                    //MUESTRA DE LA TABLA DEPARTAMENTOS
                    $sqlmostrar="SELECT * FROM Departamento";
                    $resultadoConsulta2=$DAW207DBDepartamentos->prepare($sqlmostrar); // preparo la consulta
                    $resultadoConsulta2->execute(); // ejecuto la consulta    
                    
                    ?>
                    <table>
                        <tr>
                            <th>CodDepartamento</th>
                            <th>DescDepartamento</th>
                            <th>FechaBaja</th>
                            <th>VolumenNegocio</th>
                        </tr>
                        <?php 
                            $oDepartamento = $resultadoConsulta2->fetchObject(); // Obtengo el primer registro de la consulta como un objeto
                            while($oDepartamento) { // recorro los registros que devuelve la consulta de la consulta ?>
                        <tr>
                            <td><?php echo $oDepartamento->CodDepartamento; // obtengo el valor del codigo del departamento del registro actual ?></td>
                            <td><?php echo $oDepartamento->DescDepartamento; // obtengo el valor de la descripcion del departamento del registro actual ?></td>
                            <td><?php echo $oDepartamento->FechaBaja; // obtengo el valor de la fecha de baja del departamento del registro actual ?></td>
                            <td><?php echo $oDepartamento->VolumenNegocio; // obtengo el valor de la fecha de baja del departamento del registro actual ?></td>
                        </tr>
                        <?php 
                            $oDepartamento = $resultadoConsulta2->fetchObject(); // guardo el registro actual como un objeto y avanzo el puntero al siguiente registro de la consulta 
                        }
                        ?>
                    </table>    
                    <?php
                }catch(PDOException $excepcion){//Codigo que se ejecuta si hay algun error
                    $errorExcepcion = $excepcion->getCode();//Obtengo el codigo del error y lo almaceno en la variable errorException
                    $mensajeException = $excepcion->getMessage();//Obtengo el mensaje del error y lo almaceno en la variable mensajeException

                    echo "<span style='color: red'>Codigo del error: </span>" . $errorExcepcion;//Muestro el codigo del error
                    echo "<span style='color: red'>Mensaje del error: </span>" . $mensajeException;//Muestro el mensaje del error
                }finally{
                    //Cierro la conexion
                    unset($DAW207DBDepartamentos);
                }
            }else{// si hay algun campo de la entrada que este mal muestro el formulario hasta que esten bien todos los campos
            ?> 
            
            <form name="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form">
                    <fieldset>
                        <p>Formulario de Nuevo Departamento<p>
                        <ul>
                            <!--Campo Alfabetico CodDepartamento OBLIGATORIO -->
                            <li>
                                <div>
                                    <label for="codDepartamento"><strong>Codigo Departamento*</strong></label>
                                    <input name="codDepartamento" id="codDepartamento" type="text" value="<?php echo isset($_REQUEST['codDepartamento']) ? $_REQUEST['codDepartamento'] : ''; ?>" placeholder="Introduzca el Codidog del Departamento">
                                    <?php echo '<span>' . $aErrores['codDepartamento'] . '</span>' ?>
                                </div>
                            </li>
                            <!--Campo Alfabetico DescDepartamento OBLIGATORIO-->
                            <li>
                                <div>
                                    <label for="descDepartamento"><strong>Descripcion Departamento*</strong></label>
                                    <input name="descDepartamento" id="descDepartamento" type="text" value="<?php echo isset($_REQUEST['descDepartamento']) ? $_REQUEST['descDepartamento'] : ''; ?>" placeholder="Introduzca la Descripcion del Departamento">
                                    <?php echo '<span>' . $aErrores['descDepartamento'] . '</span>' ?>
                                </div>
                            </li>
                            <!--Campo Float VolumenNegocio OBLIGATORIO-->
                            <li>
                                <div>
                                    <label for="volumenNegocio"><strong>Volumen Negocio*</strong></label>
                                    <input name="volumenNegocio" id="volumenNegocio" type="text" value="<?php echo isset($_REQUEST['volumenNegocio']) ? $_REQUEST['volumenNegocio'] : ''?>" placeholder="Introduzca el Volumen del Negocio del Departamento">
                                    <?php echo '<span>' . $aErrores['volumenNegocio'] . '</span>' ?>
                                </div>
                            </li>
                            <!--Campo Boton Enviar-->
                            <li>
                                <input class="enviar" id="enviar" type="submit" name="enviar" value="Enviar"/>
                            </li>
                        </ul>
                    </fieldset>
                </form>
            <?php
            }
            ?>
    </body>
</html>

