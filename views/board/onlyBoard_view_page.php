<?php session_start();
// 전체 적으로 onlyBoard_view.php와 닮아있다. 페이지 네이션 이랑 리스트 출력 부분이 조금 다르다.
if (!isset($this->session->id)) { ?>
    <br>
    <div class='row'>
        <div class='col-md-8'></div>
        <div class='col-md-4'>
            <form action='http://localhost/index.php/onlyBoard/login' method='post'>
                ID : <input class='form-control' name='id' type='text' style='width: 150px; display: inline'>&nbsp;&nbsp;&nbsp;
                passwd : <input class='form-control' name='passwd' type='password'
                                style='width: 150px; display: inline;'>&nbsp;&nbsp;&nbsp;
                <input type='submit' class='btn btn-default' value='로그인'>
            </form>
        </div>
    </div>
<?php } else { ?>
    <br>
    <div class='row'>
        <div class='col-md-8'></div>
        <div class='col-md-4'>
            <?php echo $this->session->userdata('id') . "님 환영합니다"; ?>
            <a href='http://localhost/index.php/onlyBoard/logout'>&nbsp;&nbsp;&nbsp;<button class='btn btn-default'>
                    로그아웃
                </button>
            </a>
        </div>
    </div>
<?php } ?>

<center><br>
    <h1>hajae<br><br></h1>

    <table class='table' style='text-align: center; width: 90%;'>
        <tr style='background-color: #bbbbbb'>
            <td style='width: 10%'>글번호</td>
            <td style='width: 60%'>제목</td>
            <td style='width: 12%;'>작성자</td>
            <td style='width: 18%'>작성시간</td>
            <td>조회수</td>
        </tr>

        <?php
        $page = ($pageNum - 1) * 10;
        // 1페이지면 10번째까지 2페이지면 11번째 부터 20번째 까지 출력 하는 반복문
        for ($i = $page; $i < count($result); $i++) { ?>
            <tr>
                <?php
                for ($j = 0; $j < 5; $j++) {
                    switch ($j) {
                        case 0: ?>
                            <td>
                            <?php
                            echo $result[$i]['id'];
                            break;
                        case 1: ?>
                            <td style='text-align: left;'>
                            <a href="http://localhost/index.php/onlyBoard/show/<?php echo $result[$i]['id']; ?>/<?php echo $pageNum ?>">
                                <?php
                                echo $result[$i]['subject']; ?>
                            </a>
                            <?php
                            break;
                        case 2: ?>
                            <td>
                            <?php
                            echo $result[$i]['user_id'];
                            break;
                        case 3: ?>
                            <td>
                            <?php
                            echo $result[$i]['date'];
                            break;
                        case 4: ?>
                            <td>
                            <?php
                            echo $result[$i]['hits'];
                            break;
                        default:
                            break;
                    } ?>
                    </td>
                <?php }
                if ($i == $pageNum * 10 - 1) {
                    break;
                } ?>
            </tr>
            <?php
        } ?>

        <tr class=''>
            <td colspan='5'>
                <?php
                $totalPage = (int)(count($result) / 10 + 1);            // 총 페이지
                if (count($result) != 0 && count($result) % 10 == 0)    // 10의 배수이면 총 페이지 -1
                    $totalPage -= 1;

                if ($pageNum <= 2) {                // 현 페이지가 1, 2 이면
                    $firstPage = 1;                 // 시작페이지가 1
                    if ($totalPage < 5)             // 총 페이지가 5보다 작으면
                        $lastPage = $totalPage;     // 마지막 페이지는 총 페이지와 같다.
                    else
                        $lastPage = 5;              // 총 페이지가 5를 넘으면 마지막 페이지는 5이다.
                } else if ($pageNum >= $totalPage - 1) {        // 현 페이지가 총 페이지, 총 페이지-1, 총 페이지-2 이면
                    if ($pageNum == 3 || $pageNum == 4) // 만약 총페이지가 5이하 이면
                        $firstPage = 1;                 // 시작 페이지는 1
                    else
                        $firstPage = $totalPage - 4;    // 아니면 시작은 총 페이지 -4

                    $lastPage = $totalPage;             // 마지막 페이지는 총 페이지와 같다.
                } else {
                    $firstPage = $pageNum - 2;          // 아니면 시작은 현페이지 -2
                    $lastPage = $pageNum + 2;           // 마지막은 현페이지 +2
                }
                // 페이지 버튼 출력
                for ($i = $firstPage; $i <= $lastPage; $i++) {
                    if ($i == $pageNum) { ?>
                        <?php
                        // 검색 했으면 실행되는 페이지 네이션
                        if ($show == 'search') { ?>
                            <form action="http://localhost/index.php/onlyBoard/get/<?php echo $i ?>/search"
                                  style="display: inline" method="post">
                                <input type="text" hidden name="search" value="<? echo $search ?>">
                                <input type="text" hidden name="search_input" value="<? echo $search_input ?>">
                                <input type='submit' class='btn btn-default active' value='<?php echo $i; ?>'>
                            </form>                        <?php } else { ?>
                            <a href='http://localhost/index.php/onlyBoard/get/<?php echo $i ?>/list'><input
                                        type='button' class='btn btn-default active' value='<?php echo $i; ?>'></a>
                        <?php }
                    } else { ?>
                        <?php if ($show == 'search') { ?>
                            <form action="http://localhost/index.php/onlyBoard/get/<?php echo $i ?>/search"
                                  style="display: inline" method="post">
                                <input type="text" hidden name="search" value="<? echo $search ?>">
                                <input type="text" hidden name="search_input" value="<? echo $search_input ?>">
                                <input type='submit' class='btn btn-default' value='<?php echo $i; ?>'></form>
                        <?php } else { ?>
                            <a href='http://localhost/index.php/onlyBoard/get/<?php echo $i ?>/list'><input
                                        type='button' class='btn btn-default' value='<?php echo $i; ?>'></a>
                        <?php }
                    }
                } ?>
            </td>
        </tr>
        <tr>
            <td colspan="5">
                <form action="http://localhost/index.php/onlyBoard/get/1/search" method="post">
                    <select name="search" id="search" style="display: inline">
                        <option value="user_id">작성자</option>
                        <option value="subject">제목</option>
                        <option value="context">내용</option>
                    </select>
                    <input type="text" class="form-control" name="search_input" style="width: 150px; display: inline">
                    <input type="submit" value="검색" class="btn btn-default">
                </form>
            </td>
        </tr>
        <?php
        if (isset($_SESSION['id'])) { ?>
            <tr>
                <td colspan='4'></td>
                <td><a href='http://localhost/index.php/onlyBoard/write'><input type='button' class='btn btn-default'
                                                                                value='글쓰기'></a></td>
            </tr>
            <?php
        } else { ?>
            <tr>
                <td colspan='4'></td>
                <td><input type='button' class='btn btn-default' value='글쓰기' onclick='alert("로그인 먼저 하세요.")'></td>
            </tr>
            <?php
        } ?>
    </table>
</center>

