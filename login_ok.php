<?php
    $id   = $_POST['id'];
    $pass = $_POST['pass']; 
    
    $con = mysqli_connect("localhost", "root", "", "bbs");
    $sql = "SELECT * FROM user WHERE id='$id'";

    $result = mysqli_query($con, $sql);

    $num_match = mysqli_num_rows($result);

    if(!$num_match) {
        echo("
            <script>
                window.alert('등록되지 않은 아이디입니다!')
                history.go(-1)
            </script>
            ");
    } else {
        $row = mysqli_fetch_array($result);
        $db_pass = $row['pass'];

        // 수정된 부분 : $db -> $con
        mysqli_close($con);
        /* 로그인 화면에서 전송된 $pass와 DB의 $db_pass의 해쉬값 비교 */
        //echo("pass : ".$pass."<br>");
        //echo("db_pass : ".$db_pass."<br>");
        //$db_pass = password_hash($db_pass,PASSWORD_DEFAULT);
        //echo("hash_db_pass : ".$db_pass."<br>");
        //echo("password_verify : ".password_verify($pass, $db_pass)."<br>");
        //exit;

        if(!password_verify($pass, $db_pass)){
            echo("
                <script>
                    window.alert('비밀번호가 틀립니다!')
                    history.go(-1)
                </script>
                ");
            exit;
        } else {
            session_start();
            $_SESSION["userid"] = $row["id"];
            $_SESSION["username"] = $row["name"];        
            echo("
                <script>
                    location.href = 'list.php';
                </script>
            ");
        }
    }        
?>