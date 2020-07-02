<?php
	include_once "config.php";
	include "db_con.php";
	include_once "login_check.php";
	
	$bno = $_GET['idx']; // $bno에 idx값을 받아와 넣음 
    
    /* 조회수 올리기  */
	$hit = mysqli_fetch_array(mq("select * from board where idx ='".$bno."'"));
	$hit = $hit['hit'] + 1;
	mq("update board 
        set hit = '".$hit."' 
        where idx = '".$bno."'
	");
	/* 조회수 올리기 끝 */
	
	/* 받아온 idx값을 선택해서 게시글 정보 가져오기 */
	$sql = mq("select * 
                from board 
                where idx='".$bno."'
			"); 
	$board = $sql->fetch_array();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width" initial-scale="1">
		<!-- 스타일 시트 참조 / css폴더의 bootstrap.css 참조 -->
		<title>PHP 게시판 웹 사이트</title>
		<!-- <link rel="stylesheet" href="css/reply.css"> -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	
		<script src="/js/login.js"></script>
		<!-- <script src="./js/event.js"></script> -->
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
			<?php 
				if(!$userid){
			?>    
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" 
						aria-haspopup="true" aria-expanded="false">접속하기<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li class="active"><a href="login.php">로그인</a></li>
							<li><a href="join.php">회원가입</a></li>
						</ul>
					</li>
				</ul>
			<?php 
				}else{	
					$logged = $username."(".$userid.")";
			?>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" 
						aria-haspopup="true" aria-expanded="false"><b><?=$logged ?></b>님의 회원관리<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="logout.php">로그아웃</a></li>
						</ul>
					</li>
				</ul>
			<?php
				}
			?>
			</div>
		</nav>
		<div class="container">
			<!-- 글 불러오기 -->
			<div id="board_read">
					<table class="table table-striped" style="text-align: center; border: 1px solid #ddddda">
						<thead>
							<tr>
								<th colspan="2" style="background-color: #eeeeee; text-align: center;"><h3>게시판 글읽기</h3></th>
							</tr>
						</thead>	
						<tbody>
							<tr>
								<td>글 제목</td>
								<td colspan="2"><?=$board['title']?></td>
							</tr>
							<tr>
								<td>작성자</td>
								<td colspan="2"><?=$board['name']?></td>
							</tr>
							<tr>
								<td>작성일자</td>
								<td colspan="2"><?=$board['date']?></td>
							</tr>
							<tr>
								<td>내용</td>
								<td colspan="2" style="min-height: 200px; text-align: left;"><?=$board['content']?></td>
							</tr>
						</tbody>
					</table>
					<!-- 목록, 수정, 삭제 -->
					<a href="list.php" class="btn btn-primary">목록</a>
					<?php 
						if($userid==$board['name']){
					?>
							<a href="update.php?idx=<?=$board['idx']?>" class="btn btn-primary">수정</a>
							<a href="delete.php?idx=<?=$board['idx']?>" class="btn btn-primary">삭제</a>
					<?php } ?>
			</div>
		</div>