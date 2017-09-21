<?php session_start();
// 로그인 안되어 있으면 로그인 창 윗부분에 출력하는 부분
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
<?php } else { // 로그인 되면 정보 출력과 로그아웃 버튼 생성 ?>
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
        // 리스트 10개까지 출력 하는 반복문
        for ($i = 0; $i < count($result); $i++) { ?>
            <tr>
                <?php
                for ($j = 0; $j < 5; $j++) {
                    switch ($j) {
                        case 0: ?>
                            <td>
                                <?php
                                echo $result[$i]['id']; ?>
                            </td>
                            <?
                            break;
                        case 1: ?>
                            <td style='text-align: left;'>
                                <!-- 제목에 글 내용을 볼수 있는 링크를 걸어둔다. -->
                                <a href="http://localhost/index.php/onlyBoard/show/<?php echo $result[$i]['id']; ?>/1">
                                    <?php
                                    echo $result[$i]['subject']; ?>
                                </a>
                            </td>
                            <?php
                            break;
                        case 2: ?>
                            <td>
                                <?php
                                echo $result[$i]['user_id']; ?>
                            </td>
                            <?
                            break;
                        case 3: ?>
                            <td>
                                <?php
                                echo $result[$i]['date']; ?>
                            </td>
                            <?
                            break;
                        case 4: ?>
                            <td>
                                <?php
                                echo $result[$i]['hits']; ?>
                            </td>
                            <?
                            break;
                        default:
                            break;
                    } ?>

                <?php }
                if ($i == 9) {
                    break;
                } ?>
            </tr>
            <?php
        } ?>

        <tr class=''>
            <td colspan='5'>
                <?php
                // 페이지 네이션
                $totalPage = (int)(count($result) / 10 + 1);            // 총페이지
                if (count($result) != 0 && count($result) % 10 == 0)    // 10의 배수이면 총페이지 -1
                    $totalPage -= 1;

                if ($totalPage < 5)             // 총 페이지가 5보다 작으면
                    $lastPage = $totalPage;     // 마지막 페이지가 총 페이지랑 같다.
                else
                    $lastPage = 5;              // 아니면 마지막페이지는 5이다 (첫 페이지니깐 최고가 5이다)
                // 각 버튼에 링크를 걸어서 페이지 버튼을 생성한다.
                for ($i = 1; $i <= $lastPage; $i++) {
                    if ($i == 1) { ?>
                        <a href='http://localhost/index.php/onlyBoard/get/<?php echo $i ?>/list'><input type='button'
                                                                                                        class='btn btn-default active'
                                                                                                        value='<?php echo $i; ?>'></a>
                        <?php
                    } else { ?>
                        <a href='http://localhost/index.php/onlyBoard/get/<?php echo $i ?>/list'><input type='button'
                                                                                                        class='btn btn-default'
                                                                                                        value='<?php echo $i; ?>'></a>
                        <?php
                    }
                } ?>
            </td>
        </tr>
        <tr>
            <td colspan="5">
                <!-- 검색 부분 -->
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
        // 로그인 되어 있으면 글 쓰기 가능 하고 안되어 있으면 로그인 하라는 경고창 출력
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

