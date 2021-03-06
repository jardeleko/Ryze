<link rel="stylesheet" href="visualizar.css">
<?php include("../includes/header.php") ?>
<?php

    require_once ("../classes/Tarefa.php");
    $tarefa = new Tarefa();
    $tarefas = $tarefa->buscarTarefas();
    ?>

    <main class="tela">
        <div class="tarefas">
            <h1 class="titulo">Tarefas do dia</h1>
            <ul class="lista">
                <?php 
                    foreach ($tarefas as $id=>$value) {
						$today = new DateTime(date('Y-m-d'));
						$limit = $value['data_limite'] != NULL? new DateTime(date($value['data_limite'])) : NULL;

						if ( $limit != NULL && ($today != $limit) || isset($value['repete']) && array_filter($value['repete'], function($valor) { 
							return $valor != date('l'); 
						}) == [] || $value['data_limite'] != NULL && $value['data_fim'] != NULL ) { 
							continue; 
						}

						$tmp = array_filter($value, function($valor) {
                            return $valor == '';
                        });
                        foreach ($tmp as $key=>$val){
                            $value[$key] = "null";
                        }             

                        echo ("<li><h3>".$value['nome']."</h3>");
                        echo ("<p>".$value['descricao']."</p>");    

                        if (isset($value['data_limite']) && $value['data_limite'] != 'null') {
                            echo ("<p>Data limite: ".date("d/m/Y", strtotime($value['data_limite']))."</p>");
                        }
                        if (isset($value['data_fim']) && $value['data_fim'] != 'null') {
                            echo ("<p>Data finalização: ".date("d/m/Y",  strtotime($value['data_fim']))."</p>");
                        }
                        if (isset($value['repete']) && $value['repete'] != 'null'){ 
                            $tmp = '["'.$id.'","'.$value['nome'].'","'.$value['descricao'].'","'.$value['data_limite'].'","'.$value['data_fim'].'"'; 
                            $var = ',["';
                            $cont = 1;
                            foreach ($value['repete'] as $dia){
                                $var .= $dia;
                                $var .= $cont < count($value['repete'])? '","' : '"]';
                                $cont++;
                                echo ("<p>".$dia."</p>");
                            }
                            $tmp .= $var;
                        }else{
                            $tmp = '["'.$id.'","'.implode('","', $value).'"'; 
                        }
                        $tmp .= ']';

                        echo ("<div class='icon'>");
                            echo ("<button class='button' id='edit' onclick='editar($tmp)'><i class='material-icons'>edit</i></button>");
                            echo ("<button class='button' id='del'><i class='material-icons'>delete</i></button"); 
                        echo ("</div>");
                        echo ("</li>");
                    }
                ?>  
            </ul>
        </div>

        <div class="tarefas">

            <h1 class="titulo">Tarefas Gerais</h1>
            
            <ul class="lista">
                <?php
                    foreach ($tarefas as $id=>$value) {
						$today = new DateTime(date('Y-m-d'));
						$limit = $value['data_limite'] != NULL? new DateTime(date($value['data_limite'])) : NULL;

						if ( $limit != NULL && ($today == $limit) || isset($value['repete']) && array_filter($value['repete'], function($valor) { 
							return $valor != date('l'); 
						}) != [] || $value['data_limite'] == NULL && $value['data_fim'] == NULL ) { 
							continue; 
						}

						$tmp = array_filter($value, function($valor) {
                            return $valor == '';
                        });
                        foreach ($tmp as $key=>$val){
                            $value[$key] = "null";
                        }             

                        echo ("<li><h3>".$value['nome']."</h3>");
                        echo ("<p>".$value['descricao']."</p>");    

                        if (isset($value['data_limite']) && $value['data_limite'] != 'null') {
                            echo ("<p>Data limite: ".date("d/m/Y", strtotime($value['data_limite']))."</p>");
                        }
                        if (isset($value['data_fim']) && $value['data_fim'] != 'null') {
                            echo ("<p>Data finalização: ".date("d/m/Y",  strtotime($value['data_fim']))."</p>");
                        }
                        if (isset($value['repete']) && $value['repete'] != 'null'){ 
                            $tmp = '["'.$id.'","'.$value['nome'].'","'.$value['descricao'].'","'.$value['data_limite'].'","'.$value['data_fim'].'"'; 
                            $var = ',["';
                            $cont = 1;
                            foreach ($value['repete'] as $dia){
                                $var .= $dia;
                                $var .= $cont < count($value['repete'])? '","' : '"]';
                                $cont++;
                                echo ("<p>".$dia."</p>");
                            }
                            $tmp .= $var;
                        }else{
                            $tmp = '["'.$id.'","'.implode('","', $value).'"'; 
                        }
                        $tmp .= ']';

                        echo ("<div class='icon'>");
                            echo ("<button class='button' id='edit' onclick='editar($tmp)'><i class='material-icons'>edit</i></button>");
                            echo ("<button class='button' id='del'><i class='material-icons'>delete</i></button"); 
                        echo ("</div>");
                        echo ("</li>");
                    }
                ?>  
            </ul>
        </div>
    </main>
<script src="visualizar.js"></script>
<?php include("../includes/footer.php") ?>