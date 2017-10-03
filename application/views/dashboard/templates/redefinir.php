<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIGov</title>
</head>
<body>
<p>Olá <?php echo $nomeUsuario ?>,</p>
<p>Você solicitou a mudança de senha da plaforma <strong>SIGov</strong>, acesse o link abaixo para concluir:</p>
<a href="<?php echo base_url().'registro?token='.$token?>">Redefinir Senha.</a>
<br>
<p>Contamos com sua colaboração!</p>
<br>
<p>Equipe SIGov</p>
</body>
</html>
