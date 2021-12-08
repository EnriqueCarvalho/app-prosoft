<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../model/css/reset.css">
    <link rel="stylesheet" href="../model/css/geral.css">
    <link rel="stylesheet" href="../model/css/consultarCliente.css">
   
    <title>Clientes</title>
</head>
    <?php
        include "../model/Cliente.php";
		session_start();
			if (isset($_SESSION['nomeFunc'])){
				
			}else {
				header("Location: index.php");
            }
            $nomeFunc = $_SESSION['nomeFunc'];
            $nomeEmpresa = $_SESSION['nomeEmpresa'];
            $codEmpresa = $_SESSION['codEmpresa'];
            $controlePesquisa = 0;

            $numReg = Cliente::numRegistros($codEmpresa); //calcula o total de registros na tabela
            $numReg = $numReg->fetchALL(PDO::FETCH_ASSOC);           
            $totalReg= $numReg[0]['numRegistros'];
            //recebe a pagina pela url 
                if (isset($_GET['pagina']))  { //verifica se o registro está vazio, caso sim, atribui o valor 1 (primeira página) 
                    $pagina = $_GET['pagina'];
                } else {                   
                    $pagina = 1;
                }

            $cliPorPagina = 1; //clientes por página
            $numPaginas = ceil($totalReg/$cliPorPagina);//nº total de páginas

            $inicio = ($cliPorPagina*$pagina)-$cliPorPagina; //para calcular qual página será mostrada


            if(isset($_GET['pesquisar'])){
                $controlePesquisa=1;
                    $valorPesquisa=$_GET['valorPesquisa'];
                    $codEmpresa = $_GET['codEmpresa'];
                   
                    $query = Cliente::pesquisarCliente($codEmpresa,$valorPesquisa);
                    $res = $query->fetchALL(PDO::FETCH_ASSOC);
            }else{
                $query = Cliente::sumCliente($codEmpresa,$inicio,$cliPorPagina);
                $res = $query->fetchALL(PDO::FETCH_ASSOC);
            }
            $pagina_anterior = $pagina-1;
            $pagina_posterior = $pagina+1;
		
                //      --> LINK DA PAGINAÇÃO https://www.youtube.com/watch?v=KvzqN6iSaSw <--
    ?>

<body>
    <div class="container-produtos">

        <div class="nav">
            <a href="./menu.php"><img src="../model/img/return.png" alt="Voltar"></a>
            <div>
                <h2 style='margin-bottom:0px;'>Enrique</h2> <sub
                    style='font-size:70%;padding-left:2%;'>Eustacio</sub><br>
            </div>
          
            <a href="../control/controleFuncionario.php?opcao=Sair"><img src="../model/img/logout.png"></a>
        </div>

        <div class="produtos">
            <div class="pesquisarCliente">
                <form action="./consultarCliente.php" method="get">
                    <input type="text" name="valorPesquisa" placeholder='Digite o nome da empresa' id="" class="inputPesquisar">
                    <?php 
                       echo " <input type='text' name='codEmpresa' value='$codEmpresa' style='display:none;'>";
                    ?>
                    <button type="submit" name="pesquisar" value="true" id=""><img  src="../model/img/search.png"></button>
                </form>
            </div>
            <?php
                    if ($res){ 
                        for($i=0;$i<count($res);$i++){
                            $nomeFantasia =$res[$i]['nomeFantasia'];
                            $razaoSocial =$res[$i]['razaoSocial'];
                            $cnpj =$res[$i]['cnpjCliente'];                          
                            $fone =$res[$i]['telefoneCliente'];
                            $codCliente =$res[$i]['codCliente'];

                            echo "<a href='./clienteMenu.php?codCliente=$codCliente&nomeCliente=$nomeFantasia'>
                                    <div class='prod'>
                                        <div class='nomeCli'>
                                            <h3>$nomeFantasia</h3>
                                            <h4 style='font-size:80%;margin-top:2px ;'>$razaoSocial</h4>
                                        </div>
                                        
                                        <div class='cnpj'>
                                            <div >CNPJ/CPF: <span class='cpfcnpj'>$cnpj</span>  </div> <div ></div>
                                            
                                        </div>
                                       
                                        <div class='fone'>
                                            <p>Fone: $fone</p>
                                        </div>
                                
                                    </div>
                                  </a>   
                                
                                ";
                           
                        }
                        echo "<div class='paginacao'>";
                        if($pagina_anterior!=0 && $controlePesquisa==0){
                            echo "<div><a style='color:#000;' href='consultarCliente.php?pagina=$pagina_anterior'>&laquo;</a></div>";
                        }else{
                            echo "<div><a style='visibility:hidden;' href='consultarCliente.php?pagina=$pagina_anterior'>&laquo;</a></div>";
                        }   
                         if($pagina_posterior<=$numPaginas && $controlePesquisa==0){
                            echo "<div><a style='color:#000;' href='consultarCliente.php?pagina=$pagina_posterior'>&raquo;</a></div>";
                        }
                       echo '</div>'; 
                    }else{
                        echo '<div>Nenhum resultado encontrado</div>';
                    }
                    ?>
                    



        </div>
  

    </div>
    <script type="text/javascript" src="../model/js/geral.js"></script>
</body>

</html>