<?php

session_start();                        // 로그인

$subject = htmlspecialchars($_POST['subject'], ENT_QUOTES); // 제목의 특수 문자를 html 엔터티로 변환
$context = htmlspecialchars($_POST['context'], ENT_QUOTES); // 내용의 특수 문자를 html 엔터티로 변환

$context = str_replace("\r\n", "<br/>" , $context);// 엔터키를 html 태그로 변환

// insert 실행
$this->onlyBoard_model->insert($_SESSION['id'], $_SESSION['name'], $subject, $context);

echo "<script>document.location.href='http://localhost/index.php/onlyBoard'</script>";

?>