<div class="sptitulo">Produtos</div>
<?php
$pagina = "admin_inicio.php?sp=" . $_REQUEST["sp"];
$btnnome = "cad";
$btnvalue = "Cadastrar";
$prodescricao = "";
$provalor = "";
$pronome = "";

//Cadastro
if (isset($_REQUEST["cad"])) {
    $pronome = $_REQUEST["pronome"];
    $prodescricao = $_REQUEST["prodescricao"];
    $provalor = $_REQUEST["provalor"];
    $procategoria = $_REQUEST["procategoria"];
    if (($pronome == "") || ($provalor == "") || ($procategoria == "") || ($prodescricao == "")) {
        echo "<div class='erro'>Campo obrigatório em branco</div>";
    } else {
        $sqlrpt = "select * from produto where pronome = '" . $pronome . "'";
        $qryrpt = mysqli_query($con, $sqlrpt);
        if (mysqli_num_rows($qryrpt) > 0) {
            echo "<div class='erro'>Dado já existe </div>";
        } else {
            //Formata valor de 1.580,95 para 1580.95 (brasil->americano)
            $provalor = str_replace(".", "", $provalor);
            $provalor = str_replace(",", ".", $provalor);

            $sqlins = "insert into produto (pronome, provalor, procategoria, prodescricao)
                            values('" . $pronome . "','" . $provalor . "','" . $procategoria . "','" . $prodescricao . "')";
            $qryins = mysqli_query($con, $sqlins);
            echo "<div class='ok'>Cadastro realizado</div>";
            $pronome = "";
            $provalor = "";
            $procategoria = "";
            $prodescricao = "";
        }
    }
}

//Seleçaõ de Dados
if (isset($_REQUEST["acao"])) {
    $sqlsel = "select * from produto where procod  = '" . $_REQUEST["id"] . "'";
    $qrysel = mysqli_query($con, $sqlsel);
    $ressel = mysqli_fetch_array($qrysel);
    $procod = $ressel["procod"];
    $pronome = $ressel["pronome"];
    $provalor = $ressel["provalor"];
    $procategoria = $ressel["procategoria"];
    $prodescricao = $ressel["prodescricao"];
    $btnnome = $_REQUEST["acao"];
    if ($_REQUEST["acao"] == "alt") {
        $btnvalue = "Salvar Alterações";
    } else {
        $btnvalue = "Excluir Definitivamente";
    }

    //Formata valor de 1,580.95 para 1.580,95 (americano->brasil)
    $provalor = number_format($provalor, "2", ",", ".");
}

//Alteração
if (isset($_REQUEST["alt"])) {
    $procod = $_REQUEST["procod"];
    $pronome = $_REQUEST["pronome"];
    $provalor = $_REQUEST["provalor"];
    $procategoria = $_REQUEST["procategoria"];
    $prodescricao = $_REQUEST["prodescricao"];
    if (($pronome == "") || ($provalor == "") || ($procategoria == "") || ($prodescricao == "")) {
        echo "<div class='erro'>Campo obrigatório em branco <div>";
    } else {
        $sqlrpt = "select * from produto where pronome = '" . $pronome . "' and   procod <>'" . $procod . "'";
        $qryrpt = mysqli_query($con, $sqlrpt);
        if (mysqli_num_rows($qryrpt) > 0) {
            echo "<div class = 'erro'>Dado jáexiste</div>";
        } else {
            //Formata valor de 1.580,95 para 1580.95 [brasil->americano)
            $provalor = str_replace(".", "", $provalor);
            $provalor = str_replace(",", ".", $provalor);

            $sqlins = "update produto
                        set pronome='" . $pronome . "', provalor='" . $provalor . "',
                            procategoria='" . $procategoria . "',prodescricao='" . $prodescricao . "'
                        where procod ='" . $procod . "'";
            $qryins = mysqli_query($con, $sqlins);
            echo "<div class= 'ok'> Alteração realizada</div>";
            $procod = "";
            $pronome = "";
            $provalor = "";
            $procategoria = "";
            $prodescricao = "";
        }
    }
}
//Exclusão
if (isset($_REQUEST["exc"])) {
    $procod = $_REQUEST["procod"];
    $sqlrpt = "select * from pedidos_itens where itmproduto = '" . $procod . "'";
    $qryrpt = mysqli_query($con, $sqlrpt);
    if (mysqli_num_rows($qryrpt) > 0) {
        echo "<div class = 'erro'> Dado em uso em outra tabela </div>";
    } else {
        echo $sqlins = "delete from produto where procod='" . $procod . "'";
        $qryins = mysqli_query($con, $sqlins);
        echo "<div class = 'ok'> Exclusão realisada</div>";
        $procod = "";
        $pronome = "";
        $provalor = "";
        $procategoria = "";
        $prodescricao = "";
    }
}
?>

<form method = "post" action="<?php echo $pagina ?>">
    <input type="hidden" name="procod" value="<?php echo $procod ?>"/>
    <div class="flinha">
        <div class="flabel"> Nome do produto*:</div>
        <div class="finput">
            <input type ="text" name ="pronome" value="<?php echo $pronome ?>"
                   maxlength="100" class="fcampo"/>
        </div>
        <div class="Limpar"></div>
    </div>
    <div class =" flinha">
        <div class="flabel">Valor de Venda*:</div>
        <div class="finput">
            <input type ="text" name="provalor" value="<?php echo $provalor ?>"
                   maxlength="10" class="fcampo"/>
        </div>
        <div class ="limpar"></div>
    </div>
    <div class ="flinha">
        <div class="flabel">Categoria*:</div>
        <div class="finput">
            <select name="procategoria" class=" fcampo" style="width:60%">
                <option value="">Selecione</option>
                <?php
                $sqlc = "select * from categoria order by catnome";
                $qryc = mysqli_query($con, $sqlc);
                while ($resc = mysqli_fetch_array($qryc)) {
                    $sel = "";
                    if ($procategoria == $resc["catcod"]) {
                        $sel = "selected";
                    }
                    ?>
                    <option value="<?php echo $resc["catcod"] ?>"<?php echo $sel; ?>>
                        <?php echo $resc["catnome"] ?></option>
                    <?php
                }
                ?>
            </select>   
        </div>
        <div class="limpar"></div>
    </div>
    <div class ="flinha">
        <div class="flabel ">Descrição*:</div>
        <div class="finput">
            <textarea class="fcampo" name="prodescricao" rows="4" cols="40">
                <?php echo $prodescricao; ?></textarea>
        </div>
        <div class="limpar"></div>
    </div>
    <div class="flinha">
        <input type="submit" name="<?php echo $btnnome ?>" value="<?php echo $btnvalue ?>" class="fbotao" />
    </div>
</form>
<table width="100%" cellpadding="3" cellspacing="0">
    <tr class="ltitulo">
        <td>Cód</td>
        <td>Produto</td>
        <td>Categoria</td>
        <td>Valor</td>
        <td width="16"></td>
        <td width="16"></td>
        <td width="16"></td>
    </tr>
    <?php
    $sqllst = "select * from produto, categoria where catcod = procategoria order by pronome";
    $qrylst = mysqli_query($con, $sqllst);
    $class = "llinha1";
    while ($reslst = mysqli_fetch_array($qrylst)) {
        ?>
        <tr class ="<?php echo $class ?>">
            <td><?php echo $reslst["procod"] ?></td>
            <td><?php echo $reslst["pronome"] ?></td>
            <td><?php echo $reslst["catnome"] ?></td>
            <td><?php echo number_format($reslst["provalor"], "2", ",", ".") ?></td>
            <td width ="16">
                <a href="admin_inicio.php?sp=produtos_fotos&produto= <?php echo $reslst["procod"] ?>">
                    <img src="img\fotos.png" border="0" width="16"/>
                </a>
            </td>
            <td width="16">
                <a href =" <?php echo $pagina ?>&acao=alt&id=<?php echo $reslst["procod"] ?>">
                    <img src="img\alterar.png" border="0" width="16"/>
                </a>
            </td>
            <td width="16">
                <a href="<?php echo $pagina ?>&acao=exc&id= <?php echo $reslst["procod"] ?>">
                    <img src="img\excluir.png" border="0" width="16"/>
                </a>
            </td>
        </tr>
        <?php
        if ($class == "llinha1") {
            $class = "llinha2";
        } else {
            $class = "llinha1";
        }
    }
    ?>
</table>
