<center><br>
    <h1>hajae<br><br></h1>
    <?php session_start(); ?>

    <center>

        <table class='table' style='width: 40%; text-align: center; overflow: scroll'>
            <tr>
                <td style='width: 10%'>제목</td>
                <td style='text-align: left' colspan="2"><?php echo $result[0]['subject']; ?></td>
            </tr>
            <tr style='height: 300px'>
                <td>내용</td>
                <td style='text-align: left' colspan="2"><?php echo $result[0]['context']; ?></td>
            </tr>

            <?php
            if (isset($commend_result[0]['user_id'])) {
                // 댓글 출력하는 큰 반복문
                for ($i = 0;
                     $i < count($commend_result);
                     $i++) { ?>
                    <tr>
                    <?php for ($j = 0;
                               $j < 3;
                               $j++) {
                        if ($j == 0) { ?>
                            <td>
                                <?php echo $commend_result[$i]['user_id']; ?>
                            </td>
                        <?php } else if ($j == 1) { ?>
                            <td style="width: 70%;text-align: left">
                            <!--로그인 되어 있으면 답글을 달 수 있게-->
                            <?php echo $commend_result[$i]['subject']; ?>
                            <a onclick="document.getElementById('hidden<? echo $commend_result[$i]['commend_id'] ?>').style.display=''"
                               style="font-size: 5px; color: #D0D0D0;">&nbsp;&nbsp;답글</a>
                            <div id="hidden<? echo $commend_result[$i]['commend_id'] ?>" style="display:none;">
                                <?php if ($this->session->userdata('id')) { ?>
                                    <form action="http://localhost/index.php/onlyBoard/commend_commend/<?php echo $result[0]['id'] ?>/<?php echo $pageNum ?>/<?php echo $commend_result[$i]['commend_id'] ?>"
                                          method="post">
                                        <input type="text" class="form-control" name="commend_commend_content"
                                               style="width: 410px; display: inline">
                                        <input type="submit" value="작성" class="btn-default btn btn-s"
                                               style="display: inline">
                                    </form>
                                <?php } else { // 로그인 안되어 있으면 문장 출력 ?>
                                    로그인 해 주세요
                                <?php } ?>
                            </div>
                            </td>
                        <?php } else if ($j == 2) { ?>
                            <td style="font-size: smaller; color: #9d9d9d;">
                            <?php echo $commend_result[$i]['commend_date']; ?>
                            </td>
                            </tr>
                            <?php for ($k = 0;  // 댓글의 댓글이 있는지 확인 후 출력
                                       $k < count($commend_commend_result);
                                       $k++) {
                                // 댓글의 댓글이 있으면 실행
                                if ($commend_result[$i]['commend_id'] == $commend_commend_result[$k]['commend_commend_id']) { ?>
                                    <tr style="color: #9d9d9d">
                                    <?php for ($m = 0; $m < 3; $m++) {
                                        if ($m == 0) { ?>
                                            <td style='font-size: 13px'>
                                                <?php echo "↘ " . $commend_commend_result[$k]['user_id']; ?>
                                            </td>
                                        <?php } else if ($m == 1) { ?>
                                            <td style="width: 70%;text-align: left; font-size: 13px">
                                            <?php echo $commend_commend_result[$k]['subject']; ?>
                                            </td>
                                        <?php } else if ($m == 2) { ?>
                                            <td style="font-size: 11px; color: #9d9d9d;">
                                            <?php echo $commend_commend_result[$k]['commend_date']; ?>
                                            </td>
                                            </tr>
                                        <?php }
                                    }
                                }
                            }
                        }
                    }
                }
            } else { // 댓글이 없으면 문장 출력 ?>
                <tr>
                    <td colspan='3'>댓글이 없습니다.</td>
                </tr>
            <?php } ?>
            <tr>
                <td>댓글</td>
                <form action="http://localhost/index.php/onlyBoard/commend/<?php echo $result[0]['id'] ?>/<?php echo $pageNum ?>"
                      method="post">
                    <!-- 로그인 되어 있으면 실행 -->
                    <?php if ($this->session->userdata('id')) { ?>
                        <td><input type="text" class="form-control" name="commend_subject"></td>
                        <td><input type="submit" value="작성" class="btn btn-default"></td>
                    <?php } else { ?>
                        <!-- 로그인 안되어 있으면 문장 출력 -->
                        <td colspan="2">로그인 후 이용해 주세요</td>
                    <?php } ?>
                </form>
            </tr>
            <tr>
                <td colspan='3'>
                    <!-- 각자에 맞는 url 링크를 건다 -->
                    <a href='http://localhost/index.php/onlyBoard/get/<?php echo $pageNum; ?>/list'>
                        <button class='btn btn-default'>글목록</button>
                    </a>
                    <a href="http://localhost/index.php/onlyBoard/modify/<?php echo $result[0]['id'] ?>/<?php echo $pageNum ?>">
                        <button class='btn btn-default'>수정</button>
                    </a>
                    <a href="http://localhost/index.php/onlyBoard/remove/<?php echo $result[0]['id'] ?>">
                        <button class='btn btn-default'>삭제</button>
                    </a>
                </td>
            </tr>

        </table>
    </center>