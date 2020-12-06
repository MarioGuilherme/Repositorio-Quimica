<?php

    include('../../banco/conexao.php');

    if($conexao){
        
        $sql = "SELECT DATE_FORMAT(data_hora, '%d/%m/%Y ás %H:%i:%s') as data_hora, titulo, 
        p.nome as nome_professor, l.nome AS laboratorio FROM relatorios r
        INNER JOIN professores p ON p.id_professor = r.id_professor
        INNER JOIN labs l ON l.id_lab = r.id_lab WHERE 1=1";
        $resultado = mysqli_query($conexao, $sql);
        $linha = mysqli_num_rows($resultado);

        if($linha == 0){

            $dados = array(
                'status' => 'nenhum',
                'sql' => $sql
            );  
        } else{

            while($linha = mysqli_fetch_assoc($resultado)){
                $dadosTipo[] = $linha;
            }

            $dados = array(
                'dados' => $dadosTipo,
                'status' => 'ok'
            );
        }

        mysqli_close($conexao);
    } else {
        $dados = array(
            'msg' => "Erro [042]" . "<br>" . "Ocorreu um erro interno no servidor 😕",
            'icone' => 'error',
            'causa' => $conexao
        );
    }

    echo json_encode($dados, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);