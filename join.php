<?php
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width" initial-scale="1">
		<!-- 스타일 시트 참조 / css폴더의 bootstrap.css 참조 -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<title>PHP 게시판 웹 사이트</title>
		<script src="https://code.jquery.com/jquery-2.2.4.js?v=<?=time()?>"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
		<script>
                        /* 입력 확인 */
			function check_input()
            {
                if (!$("#id").val()) {
                    alert("아이디를 입력하세요!");    
                    $("#id").focus();
                    return;
                    //return false;
                }
                if (!$("#pass").val()) {
                    alert("비밀번호를 입력하세요!");    
                    $("#pass").val().focus();
                    return;
                }
                if (!$("#pass_confirm").val()) {
                    alert("비밀번호확인을 입력하세요!");    
                    $("#pass_confirm").focus();
                    return;
                }
                if (!$("#name").val()) {
                    alert("이름을 입력하세요!");    
                    $("#name").focus();
                    return;
                }
                if (!$("#phone").val()) {
                    alert("전화번호를 입력하세요!");    
                    $("#phone").focus();
                    return;
                }
                if (!$("#email").val()) {
                    alert("이메일 주소를 입력하세요!");    
                    $("#email").focus();
                    return;
                }
                if ( $("#pass").val() != $("#pass_confirm").val()) {
                    alert("비밀번호가 일치하지 않습니다.\n다시 입력해 주세요!");
                    $("#pass").focus();
                    $("#pass").select();
                    return;
                }
                document.join.submit();
            }
            /* 초기화 */	
            function reset_form() {
                document.join.id.value = "";  
                document.join.pass.value = "";
                document.join.pass_confirm.value = "";
                document.join.name.value = "";
                document.join.gender.value = "";
                document.join.phone.value = "";
                document.join.email.value = "";
                $("#id_check_msg").html("");
                $("#pass_check_msg").html("");
                $("#pass_confirm_msg").html("");
                document.join.id.focus();
                return;
            }
            // new daum.Postcode({
            //     oncomplete: function(data) {
            //     // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분입니다.
            //     // 예제를 참고하여 다양한 활용법을 확인해 보세요.
            //     }
            // }).open();
        </script>
        <script>
        /* 아이디 존재 체크(비동기통신) */
        $(function(){/*문서가 로드되면 function을 실행하라  */
            $("#id").blur(function(){/*아이디가 id인것을 찾아 포커즈를 빠져나갈때 발생하는 이벤트  */                
                if($(this).val() == ""){
                    $("#id_check_msg").html("아이디를 입력하세요.").css("color","red").attr("data-check","0");//선택자를 .연사자추가해서 계속 사용가능  
                    $(this).focus();
                } else {
                    checkIdAjax();				
                }   
            });
        });
        /* 아이디 중복 체크(비동기통신) */
        function checkIdAjax(){//id값을 post로 전송해서 서버와 통신하여 중복 결과 json 형태로 받아오는 함수
            var id = $("#id").val();
            $.ajax({				//비동기통신방법, 객체로 보낼때{}사용
                url : "./id_check.php",
                type : "POST",
                dataType : "json",
                data : {
                    "id" : id
                },
                success : function(data){
                    if(data.check){			//json사용했기때문에 data.으로 접근가능
                        $("#id_check_msg").html("사용 가능한 아이디입니다.").css("color", "blue").attr("data-check","1");
                    } else {
                        $("#id_check_msg").html("중복된 아이디입니다.").css("color", "red").attr("data-check","0");
                        $("#id").focus();
                    }
                }
            });            
        }
        /* 패스워드 존재 체크(비동기통신) */
        $(function(){                    /*문서가 로드되면 function을 실행하라  */
            $("#pass").blur(function(){  /*패스워드가 pass인것을 찾아 포커즈를 빠져나갈때 발생하는 이벤트  */                
                if($(this).val() == ""){
                    $("#pass_check_msg").html("비밀번호를 입력하세요.").css("color","red").attr("data-check","0");//선택자를 .연사자추가해서 계속 사용가능  
                    $(this).focus();
                }   
            });
        });
        /* 패스워드 컨펌체크 동일한지 체크(비동기통신) */
        $(function(){                    /*문서가 로드되면 function을 실행하라  */
            $("#pass_confirm").blur(function(){  /*패스워드가 pass인것을 찾아 포커즈를 빠져나갈때 발생하는 이벤트  */                
                if($(this).val() == ""){
                    $("#pass_confirm_msg").html("비밀번호확인을 입력하세요.").css("color","red").attr("data-check","0");//선택자를 .연사자추가해서 계속 사용가능  
                    $(this).focus();
                }
                if($(this).val() != $("#pass").val()){
                    $("#pass_confirm_msg").html("비밀번호가 다릅니다.").css("color","red").attr("data-check","0");//
                    $(this).focus();
                } else {
                    $("#pass_confirm_msg").html("사용 가능한 비밀번호입니다.").css("color", "blue").attr("data-check","1");
                }
            });
        });
        </script>

	</head>
	<body>
		<!-- 표준 네비게이션 바 (화면 상단에 위치, 화면에 의존하여 확대 및 축소) -->
		<nav class="navbar navbar-default">
			<div class="navbar-header">
				<!-- Collapse : 제목을 클릭하면 해당내용이 펼쳐지고 다른내용은 접히는 특수 효과 -->
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
				aria-expanded="false">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="main.php">PHP 게시판 웹 사이트</a>
			</div>   
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="active"><a href="main.php">메인</a></li>
					<li><a href="list.php">게시판</a></li>
				</ul>  
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" 
						aria-haspopup="true" aria-expanded="false">접속하기<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="login.php">로그인</a></li>
							<li class="active"><a href="join.php">회원가입</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
		<div class="container"> 
			<div class="col-lg-4"></div>
			<div class="col-lg-4">
				<div class="jumbotron" style="padding-top: 20px;">
					<form name="join"  method="post" action="join_ok.php">
						<h3 style="text-align: center">회원가입 화면</h3>
						<div class="col-lg-4"></div>
						<div class="form-group">
                            <input type="text" class="form-control" placeholder="아이디" name="id" id="id" maxlength="15">
                            <span id="id_check_msg" data-check="0"></span>	<!--커스텀 속성:data-check="0"  -->
						</div>
						<div class="form-group">
                            <input type="password" class="form-control" placeholder="비밀번호" name="pass" id="pass" maxlength="20">
                            <span id="pass_check_msg" data-check="0"></span>	<!--커스텀 속성:data-check="0"  -->
						</div>
						<div class="form-group">
                            <input type="password" class="form-control" placeholder="비밀번호 확인" name="pass_confirm" id="pass_confirm" maxlength="20">
                            <span id="pass_confirm_msg" data-check="0"></span>	<!--커스텀 속성:data-check="0"  -->
						</div>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="이름" name="name" id="name" maxlength="20">
						</div>
						<div class="form-group" style="text-align: center">
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-primary active">
									<input type="radio" name="gender" id="gender1" autocomplete="off" value="남자" checked>남자
								</label>
								<label class="btn btn-primary">
									<input type="radio" name="gender" id="gender2" autocomplete="off" value="여자">여자
								</label>
							</div>
						</div>
						<div class="form-group">
							<input type="tel" class="form-control" placeholder="전화번호" name="phone" id="phone" maxlength="20">
						</div>	
						<div class="col-lg-4"></div>
						<div class="form-group">
							<input type="email" class="form-control" placeholder="이메일" name="email" id="email" maxlength="80">
                        </div>
                        
                        <div class="form-group">
                            <input type="text" id="sample3_postcode" name="sample3_postcode" class="d_form mini" placeholder="우편번호">
                            <input type="button" onclick="sample3_execDaumPostcode()" value="우편번호 찾기" class="d_btn"><br>
                            <input type="text" id="sample3_address" name="sample3_address" class="d_form large" placeholder="주소"><br>
                            <input type="text" id="sample3_detailAddress" name="sample3_detailAddress" class="d_form" placeholder="상세주소">
                            <input type="text" id="sample3_extraAddress" name="sample3_extraAddress" class="d_form" placeholder="참고항목">

                            <div id="wrap" style="display:none;border:1px solid;width:500px;height:300px;margin:5px 0;position:relative">
                                <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
                            </div>

                        <script>
                            // 우편번호 찾기 찾기 화면을 넣을 element
                            var element_wrap = document.getElementById('wrap');

                            function foldDaumPostcode() {
                            // iframe을 넣은 element를 안보이게 한다.
                                element_wrap.style.display = 'none';
                            }

                            function sample3_execDaumPostcode() {
                            // 현재 scroll 위치를 저장해놓는다.
                                var currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
                                new daum.Postcode({
                                oncomplete: function(data) {
                                    // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                                    // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                                    // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                                    var addr = ''; // 주소 변수
                                    var extraAddr = ''; // 참고항목 변수

                                    //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                                    if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                                        addr = data.roadAddress;
                                    } else { // 사용자가 지번 주소를 선택했을 경우(J)
                                        addr = data.jibunAddress;
                                    }
    
                                    // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                                    if(data.userSelectedType === 'R'){
                                        // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                                        // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                                        if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                                            extraAddr += data.bname;
                                        }
                                        // 건물명이 있고, 공동주택일 경우 추가한다.
                                        if(data.buildingName !== '' && data.apartment === 'Y'){
                                            extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                                        }
                                        // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                                        if(extraAddr !== ''){
                                            extraAddr = ' (' + extraAddr + ')';
                                        }
                                        // 조합된 참고항목을 해당 필드에 넣는다.
                                            document.getElementById("sample3_extraAddress").value = extraAddr;
                            
                                    } else {
                                        document.getElementById("sample3_extraAddress").value = '';
                                    }
    
                                    // 우편번호와 주소 정보를 해당 필드에 넣는다.
                                    document.getElementById('sample3_postcode').value = data.zonecode;
                                    document.getElementById("sample3_address").value = addr;
                                    // 커서를 상세주소 필드로 이동한다.
                                    document.getElementById("sample3_detailAddress").focus();
    
                                    // iframe을 넣은 element를 안보이게 한다.
                                    element_wrap.style.display = 'none';
    
                                    // 우편번호 찾기 화면이 보이기 이전으로 scroll 위치를 되돌린다.
                                    document.body.scrollTop = currentScroll;
                                },
                                // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
                                    onresize : function(size) {
                                        element_wrap.style.height = size.height+'px';
                                    },
                                        width : '100%',
                                        height : '100%'
                                    }).embed(element_wrap);

                                // iframe을 넣은 element를 보이게 한다.
                                element_wrap.style.display = 'block';
                            }
                        </script>						
                    </div>
                        <!--
                        <input type="submit" value="회원가입">
                        <button onclick="check_input()">회원가입</button> -->
						<span class="btn btn-primary form-control" onclick="check_input()">회원가입</span>&nbsp;
                        <span class="btn btn-primary form-control" onclick="reset_form()">초기화</span>
                        
					</form>
				</div>
			</div>
		</div>
	</body>
</html>