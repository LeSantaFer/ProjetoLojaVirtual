<div class="sptitulo">Produtos</div>
<?php
    $pagina = "admin_inicio.php?sp=".$_REQUEST["sp"];
    $btnnome = "cad";
    $btnvalue = "Cadastrar";
    
    //Cadastro
    if(isset($_REQUEST["cad"])){
        $pronome = $_REQUEST["pronome"];
        $prodescricao = $_REQUEST["prodescricao"];
        $provalor = $_REQUEST["provalor"];
        $procategoria = $_REQUEST["procategoria"];
        if(($pronome=="")||($provalor=="")||($procategoria=="")||($prodescricao=="")){
            echo "<div class='erro'>Campo obrigatório em branco</div>";
        }
        else{
            $sqlrpt = "select * from produto where pronome = '".$pronome."'";
            $qryrpt = mysqli_query($sqlrpt,$con);
            if(mysql_query($qryrpt)>0) echo "<div class='erro'>Dado já existe </div>";
            else{
                //Formata valor de 1.580,95 para 1580.95 (brasil->americano)
                $provalor = str_replace(".","",$provalor);
                $provalor = str_replace(",",".",$provalor);
                
                $sqlins = "insert into produto (pronome, provalor, procategoria, prodescricao)
                            values('".$pronome."','".$provalor."','".$procategoria."','".$prodescricao."')";
                $qryins = mysqli_query($sqlins,$con);
                echo "<div class='ok'>Cadastro realizado</div>";
                $pronome = "";
                $provalor = "";
                $procategoria = "";
                $prodescricao = "";
            }
        }
    }
    
    //Seleçaõ de Dados
    if(isset($_REQUEST["acao"])){
        $sqlsel = "select * from produto where procod  = '".$_REQUEST["id"]."'";
        $qrysel = mysql_query($sqlsel,$con);
        $ressel = mysql_fetch_array($qrysel);
        $procod = $ressel["procod"];
        $pronome = $ressel["pronome"];
        $provalor = $ressel["provalor"];
        $procategoria = $ressel["procategoria"];
        $prodescricao = $ressel["prodescricao"];
        $btnnome = $_REQUEST["acao"];
        if($_REQUEST["acao"]=="alt") $btnvalue = "Salvar Alterações";
        else $btnvalue = "Excluir Definitivamente";
        
        //Formata valor de 1,580.95 para 1.580,95 (americano->brasil)
        $provalor = number_format($provalor,"2",",",".");
    }
    
    //Alteração
    if(isset($_REQUEST["alt"])){
        
    }
?>
