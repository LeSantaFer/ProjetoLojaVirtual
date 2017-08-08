<?php include "conexao.php"; ?>
<link href="estilo.css" rel="stylesheet" type="text/css"/>
<div class="pagina">
    <div class="menu">
        <?php include "admin_menu.php"; ?>
    </div>
    <div class="subpagina">
        <?php
        if (!isset($_REQUEST["sp"])) {
            include "admin_paginicial.php";
        } else {
            include "admin_" . $_REQUEST["sp"] . ".php";
        }
        ?>
    </div>
    <div class="limpar"></div>
</div>
