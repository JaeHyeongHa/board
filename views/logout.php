<?php
    session_start();        // 로그아웃 누르면
    session_destroy();      // 세션 삭제 후 돌아가기
echo "<script>document.location.href='http://localhost/index.php/onlyBoard'</script>";


?>