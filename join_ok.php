<?php
    include_once "./db_con.php";

    $id   = $_POST['id'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT); // 입력받은 패스워드를 해쉬값으로 암호화
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email  = $_POST['email'];
    $postcode = $_POST['sample3_postcode'];
    $address = $_POST['sample3_address'];
    $detailAddress = $_POST['sample3_detailAddress'];
    $extraAddress = $_POST['sample3_extraAddress'];

    // echo("id: ".$id."<br>");
    // echo("pass: ".$pass."<br>");
    // echo("name: ".$name."<br>");
    // echo("gender: ".$gender."<br>");
    // echo("phone: ".$phone."<br>");
    // echo("email: ".$email."<br>");
    // echo("postcode: ".$postcode."<br>");
    // echo("address: ".$address."<br>");
    // echo("detailAddress: ".$detailAddress."<br>");
    // echo("extraAddress: ".$extraAddress."<br>");
    // exit;

    mq("set names utf8");
    
    mq("INSERT user SET id = '{$id}', pass = '{$pass}', name = '{$name}', gender = '{$gender}', phone = '{$phone}', email = '{$email}', postcode = '{$postcode}', address = '{$address}', detailAddress = '{$detailAddress}', extraAddress = '{$extraAddress}' ");    
    echo "
    <script>
        alert('회원가입이 완료 되었습니다. Login해주세요.');
        location.href = 'login.php';
    </script>
    ";
?>