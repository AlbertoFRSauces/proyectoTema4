<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Fernandez Ramirez">
        <title>Ejercicio 04 PDO</title>
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
            a{
                color: green;
            }
        </style>
    </head>
    <body>
        <main>
            <?php
            /*
             * @author: Alberto Fernandez Ramirez
             * @version: v1.Realizacion del ejercicio
             * Created on: 08-Noviembre-2021
             * Ejercicio 4. Formulario de búsqueda de departamentos por descripción (por una parte del campo DescDepartamento, 
             * si el usuario no pone nada deben aparecer todos los departamentos).
             */
            //Incluyo las variables de la conexion
            require_once '../config/configDBPDO.php';
            //Incluyo la libreria de validacion
            require_once '../core/210322ValidacionFormularios.php';
            
            //Variable OPCIONAL inicializada a 0
            define("OPCIONAL", 0);
            
            //Variables maximos y minimos
            define("TAMANO_MAXIMO_DESCDEPARTAMENTO",255);//Maximo del campo DescDepartamento
            
            //Variable de entrada correcta inicializada a true
            $entradaOK = true;
            
            //Creo el array de errores y lo inicializo a null
            $aErrores = [
                'descDepartamento' => null
            ];
            
            //Creo el array de respuestas y lo incializo a null
            $aRespuestas = [
                'descDepartamento' => null
            ];
            
            //Comprobar si se ha pulsado el boton enviar en el formulario
            if (isset($_REQUEST['enviar'])) {
                //Comprobar si el campo DescDepartamento esta bien rellenado
                $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['descDepartamento'], TAMANO_MAXIMO_DESCDEPARTAMENTO, OPCIONAL);
                
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
                $aRespuestas['descDepartamento'] = $_REQUEST['descDepartamento'];
            
                echo "<h2>Datos introducidos</h2>";
                echo "<p>Descripcion departamento a buscar: " . $aRespuestas['descDepartamento'] . "</p>";
                
                echo "<h2>Contenido tabla Departamento</h2>";
                //Realizo la conexion
                try{
                    echo '<a>Conexion realizada.</a>';
                    //Hago la conexion con la base de datos
                    $DAW207DBDepartamentos = new PDO(HOST, USER, PASSWORD);
                    // Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
                    $DAW207DBDepartamentos -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                           
                    //INSERCION DE DATOS EN DEPARTAMENTOS
                    //Creacion de la consulta que inserta los datos en Departamento
                    $consulta = "SELECT * FROM Departamento WHERE DescDepartamento LIKE '%{$_REQUEST['descDepartamento']}%';";
                            
                    $resultadoConsulta=$DAW207DBDepartamentos->prepare($consulta); // Preparo la consulta antes de ejecutarla
                    
                    $parametros = [":DescDepartamento" => $aRespuestas['descDepartamento']];
                    
                    $resultadoConsulta->execute($parametros); // Ejecuto la consulta pasando los parametros del array de parametros
                    
                       
                    if($resultadoConsulta->rowCount() > 0){ //Si la consulta devuelve algun registro
                        ?>
                        <table>
                            <tr>
                                <th>CodDepartamento</th>
                                <th>DescDepartamento</th>
                                <th>FechaBaja</th>
                                <th>VolumenNegocio</th>
                            </tr>
                            <?php 
                                $oDepartamento = $resultadoConsulta->fetchObject(); // Obtengo el primer registro de la consulta como un objeto
                                while($oDepartamento) { // recorro los registros que devuelve la consulta de la consulta ?>
                            <tr>
                                <td><?php echo $oDepartamento->CodDepartamento; // obtengo el valor del codigo del departamento del registro actual ?></td>
                                <td><?php echo $oDepartamento->DescDepartamento; // obtengo el valor de la descripcion del departamento del registro actual ?></td>
                                <td><?php echo $oDepartamento->FechaBaja; // obtengo el valor de la fecha de baja del departamento del registro actual ?></td>
                                <td><?php echo $oDepartamento->VolumenNegocio; // obtengo el valor de la fecha de baja del departamento del registro actual ?></td>
                            </tr>
                            <?php 
                                $oDepartamento = $resultadoConsulta->fetchObject(); // guardo el registro actual como un objeto y avanzo el puntero al siguiente registro de la consulta 
                            }
                            ?>
                        </table>
                        <?php
                    }else{
                        echo "<p>No se ha encontrado ningun departamento con esa descripcion.</p>";
                        
                        if(empty($aRespuestas['descDepartamento'])){
                            //MUESTRA DE LA TABLA DEPARTAMENTOS SI NO SE HA INTRODUCIDO NADA
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
                        }
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
            }else{// si hay algun campo de la entrada que este mal muestro el formulario hasta que esten bien todos los campos
            ?>
            
            <form name="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form">
                    <fieldset>
                        <p>Formulario de busqueda de un departamento<p>
                        <ul>
                            <!--Campo Alfabetico DescDepartamento OBLIGATORIO para realizar la busqueda-->
                            <li>
                                <div>
                                    <label for="descDepartamento"><strong>Descripcion Departamento</strong></label>
                                    <input name="descDepartamento" id="descDepartamento" type="text" value="<?php echo isset($_REQUEST['descDepartamento']) ? $_REQUEST['descDepartamento'] : ''; ?>" placeholder="Introduzca la Descripcion del Departamento">
                                    <?php echo '<span>' . $aErrores['descDepartamento'] . '</span>' ?>
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
        </main>
    </body>
</html>

