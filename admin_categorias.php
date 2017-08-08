<div class="sptitulo">Categorias</div>
<?php
$pagina = "admin_inicio.php?sp=".$_REQUEST["sp"];
$btnnome = "cad";
$btnvalue = "Cadastrar";
$catnome = "";
//Cadastro
if (isset($_REQUEST["cad"])) {
    $catnome = $_REQUEST["catnome"];
    if ($catnome == "") {
        echo "<div class'erro'>Campo obrigatório em branco</div>";
    } else {
        $sqlrpt = "select * from categoria where catnome=' " . $catnome . "'";
        $qryrpt = mysqli_query($con, $sqlrpt);
        if (mysqli_num_rows($qryrpt) > 0) {
            echo "<div class = 'erro'>Dado já existe</div>";
        } else {
            $sqlins = "insert into categoria (catnome) values ('" . $catnome . "')";
            $qryins = mysqli_query($con,$sqlins);
            echo "<div class='ok'>Cadastro realizado</div>";
            $catnome = "";
        }
    }
}

//Seleção de Dados
if (isset($_REQUEST["acao"])) {
    $sqlsel = "select * from categoria where catcod = '" . $_REQUEST["id"] . "'";
    $qrysel = mysqli_query($sqlsel, $con);
    $ressel = mysqli_fetch_array(($qrysel));
    $catcod = $ressel["catcod"];
    $catnome = $ressel["catnome"];
    $btnnome = $_REQUEST["acao"];
    if ($_REQUEST["acao"] == "alt") {
        $btnvalue = "Salvar Alterações";
    } else {
        $btnvalue = "Excluir Definitivamente";
    }
}

//Alteração
if (isset($_REQUEST["alt"])) {
    $catcod = $_REQUEST["catcod"];
    $catnome = $_REQUEST["catnome"];
    if ($catnome == "") {
        echo "<div class='erro'>Campo obrigatório em branco</div>";
    } else {
        $sqlrpt = "select * from categoria where catnome = '" . $catnome . "' and catcod <> '" . $catcod . "'";
        $sqlrpt = mysqli_query($sqlrpt, $con);
        if (mysqli_num_rows($qryrpt) > 0) {
            echo "<div class='erro'>Dado já existe</div>";
        } else {

            $sqlins = "update categoria set catnome='" . $catnome . "'where catcod ='" . $catcod . "'";
            $qryins = mysqli_query($sqlins,$con);
            echo "<div class='ok'>Alteração realizada </div>";
            $catcod = "";
            $catnome = "";
        }
    }
}

//Exclusão
if (isset($_REQUEST["exc"])) {
    $catcod = $_REQUEST["catcod"];
    $sqlrpt = "select * from produto where procategoria = '" . $catcod . "'";
    $qryrpt = mysqli_query($sqlrpt, $con);
    if (mysqli_num_rows($qryrpt) > 0) {
        echo "<div class='erro'>Dado em uso em outra tabela</div>";
    } else {
        $sqlins = "delete from categoria where catcod = '" . $catcod . "'";
        $qryins = mysqli_query($sqlins, $con);
        echo "<div class='ok'>Exclusão realizada</div>";
        $catcod = "";
        $catnome = "";
    }
}
?>
<form method="post" action="<?php echo $pagina ?>">
    <input type="hidden" name="catcod" value="<?php echo $catcod ?>"/>
    <div class="flinha">
        <div class="flable">Nome da Categoria*:</div>
        <div class="finput">
            <input type="text" name="catnome" value="<?php echo $catnome ?>" maxlength="100" class="fcampo"/>
        </div>
        <div class="limpar"></div>
    </div>
    <div class="flinha">
        <input type="submit" name="<?php echo $btnnome ?>" value="<?php echo $btnvalue ?>" class="fbotao"/>
    </div>
</form>

<table width="100%" cellpadding="3" cellspacing="0"> 
    <tr class="ltitulo">
        <td>Cód</td>
        <td>Categoria</td>
        <td width="24"></td>
        <td width="24"></td>
    </tr>
    <?php
    $sqllst = "select * from categoria order by catnome";
    $qrylst = mysqli_query($con,$sqllst);
    $class = "llinhal";
    while ($reslst = mysqli_fetch_array($qrylst)) {
        ?>
        <tr class="<?php echo $class ?>">
            <td><?php echo $reslst["catcod"] ?></td>
            <td><?php echo $reslst["catnome"] ?></td>
            <td width="24">
                <a href="<?php echo $pagina ?> &acao=alt&id=<?php echo $reslst["catcod"] ?>">
                    <img src="img\alterar.png" boder="0" width="16" />
                </a>
            </td>
            <td width="24">
                <a href="<?php echo $pagina ?> &acao=exc&id=<?php echo $reslst["catcod"] ?>">
                    <img src="img\excluir.png" boder="0" width="16" />
                </a>
            </td>
        </tr>
        <?php
            if ($class == "llinhal") {
                $class = "llinha2";
            } else {
                $class = "llinhal";
            }
        }
    ?>
</table>