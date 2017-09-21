<?php
    session_start();            // 세션 시작

    if ($this->session->userdata('id') != true) {   // 로그인 안되어 있으면 실행
        // 반복문 돌면서 아이디 비밀번호 확인
        for ($i = 0 ; $i < count($result) ; $i++) {
            if ($result[$i]['user_id'] == $_POST['id'] &&
                $result[$i]['user_passwd'] == $_POST['passwd']) {
                $login = array(
                    'id'=>$_POST['id'],
                    'name'=>$result[$i]['user_name']
                );
                $this->session->set_userdata($login);
                break;
            }
        }
        // 위에 실행 했는데 로그인 안되어 있으면
        if ($this->session->userdata('id') != true) {
            echo "<script>    // 로그인 실패 후 뒤로가기
                        alert('로그인 실패');
                        history.go(-1);
                  </script>";
        } else {
            echo "<script>document.location.href='http://localhost/index.php/onlyBoard'</script>";
        }
    }

?>