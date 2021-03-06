<?php

  session_start();
  include('../conection.php');
  include('../verifica-login.php');

?>

<!DOCTYPE html>
<html lang="pt_br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>Sistema do <?php echo $_SESSION['nome']; ?></title>
    <link href="https://fonts.googleapis.com/css?family=Oxygen:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/reset.css">
    <link rel="stylesheet" href="style/registrosOrdens.css">
    <script type="text/javascript" src="../javascript/script.js"></script>
    <script type="text/javascript">
      window.onLoad = tamanho_menu();
    </script>
    <?php if(isset($_SESSION['deletado_com_sucesso'])): ?>
        <script type="text/javascript">
          alert("Deletado Com Sucesso!");
        </script>
    <?php endif; unset($_SESSION['deletado_com_sucesso']); ?>
  </head>
  <body>

          <div class="btn">
            <button type="button" id="btn_abrir" onclick="btn_menu()">Menu</button>
            <button type="button" name="btn_fechar" id="btn_fechar" onclick="btn_fechar()">Fechar</button>
          </div>

     <nav class="menu" id="menu">
       <div>

         <h1>Bem-vindo, <?php echo $_SESSION['nome']; ?></h1>

         <ul>
           <li><a href="index.php">Painel</a></li>
           <li><a href="createOrdem.php">Criar Ordem de Serviço</a></li>
           <li><a href="registrosOrdens.php">Registros de Ordens</a></li>
           <li><a href="perfil.php">Perfil</a></li>
           <li><a href="cadastrar.php">Casdastrar</a></li>
           <li><a href="gerenciarCadastros.php">Gerenciar Cadastros</a></li>
           <li><a href="../logout.php">Sair</a></li>
         </ul>
       </div>
     </nav>

     <main class="main container">
       <h1>Registros De Ordens</h1>

       <form class="form" action="<?php $_SERVER['PHP_SELF'] ?>?a=buscar" method="post">
         <label>Ordenar por:
          <select name="filter">
           <option value="cha_id">ID</option>
           <option value="cha_nome_admin">Adm</option>
           <option value="cha_nome_cliente">Cliente</option>
           <option value="cha_nome_funcionario">Funcionário</option>
           <option value="cha_data">Data</option>
           <option value="cha_valor">Valor</option>
          </select>
         </label>
         <input type="submit" name="enviar" value="Buscar">
       </form>

       <form class="form" action="<?php $_SERVER['PHP_SELF'] ?>?b=buscar" method="post">
         <label> Data:
            <input type="date" name="date" value="<?php date_default_timezone_set('America/Sao_Paulo'); echo date('Y-m-d'); ?>">
         </label>
         <input type="submit" name="enviar" value="Buscar">
       </form>

       <article class="box">
         <ul>
           <?php

              $a = @$_GET['a'];
              $b = @$_GET['b'];

              if($a or $b){

                $filter = @$_POST['filter'];
                $filterB = @$_POST['date'];

                if(!$filter){
                  $queryFilter = "SELECT * FROM chamadas WHERE cha_data = '$filterB'";
                  $resultFilter = mysqli_query($conn, $queryFilter);
                  echo "Ordenado por <u><b>" . $filterB . "</u></b>";
                }
                if(!$filterB){
                  $queryFilter = "SELECT * FROM chamadas ORDER BY $filter DESC";
                  $resultFilter = mysqli_query($conn, $queryFilter);
                  echo "Ordenado por <u><b>" . $filter . "</u></b>";
                }

              while($cow = mysqli_fetch_assoc($resultFilter)){
            ?>

            <div class="ordem">
                <span style="float: right; padding: 2%;"><?php echo "<form method='POST' action='php/registro/deletar_dados.php'><input type='submit' value='Deletar'></form>" ?></span>
              <li><?php echo "<span name='id'>Identificação da Ordem: </span>" . $cow['cha_id']; ?><li>
              <li><?php echo "<span>Valor da Ordem: </span>R$" . $cow['cha_valor'];  echo "<form method='POST' action='php/registro/editar_dados.php'><input type='submit' value='Editar'></form>"; ?></li>
              <li><?php echo "<span>Nome do Admin Criador: </span>" . $cow['cha_nome_admin']; ?></li>
              <li><?php echo "<span>Nome do Funcionário Prestador: </span>" . $cow['cha_nome_funcionario']; ?></li>
              <li><?php echo "<span>Nome do Cliente: </span>" . $cow['cha_nome_cliente']; ?></li>
              <li><?php echo "<span>Motivo da Chamada: </span>" . $cow['cha_motivo']; ?></li>
              <li><?php echo "<span>Data: </span>" . $cow['cha_data']; ?></li>
              <li><?php echo "<span>Hora: </span>" . $cow['cha_hora']; ?></li>
            </div>

          <?php }} ?>

         </ul>
       </article>

     </main>

</body>
</html>
