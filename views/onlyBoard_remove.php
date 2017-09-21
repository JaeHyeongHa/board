<?php

$this->onlyBoard_model->remove('commend', $id);     // 댓글 먼저 삭제
$this->onlyBoard_model->remove('board', $id);       // 글 삭제

echo "<script>document.location.href='http://localhost/index.php/onlyBoard'</script>";

?>