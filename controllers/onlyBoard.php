<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class onlyBoard extends CI_Controller
{
    // 처음 홈페이지가 열리면 실행되는 부분
    public function index()
    {
        $this->load->database();                            // 데이터베이스 로드
        $this->load->model('onlyBoard_model');              // 모델 로드
        $result = $this->onlyBoard_model->gets('board');    // 모델의 함수 호출
        $this->load->view('head');                          // 반복실행되는 머리 부분 떼놓은 것
        // 페이지 로드, 함수 호출 결과값$result를 넘겨준다.
        $this->load->view('board\onlyBoard_view.php', array('result' => $result));
        $this->load->view('footer');                        // 반복실행되는 다리 부분 떼놓은 것
    }

    public function login()     // 로그인 부분
    {
        $this->load->database();
        $this->load->model('onlyBoard_model');
        $result = $this->onlyBoard_model->gets('user');     // 모델의 함수 호출
        $this->load->view('head');
        $this->load->view('board\login.php', array('result' => $result));
        $this->load->view('footer');
    }

    public function logout()    // 로그아웃
    {
        $this->load->database();
        $this->load->model('onlyBoard_model');
        $this->load->view('head');
        $this->load->view('board\logout.php');
        $this->load->view('footer');
    }

    public function get($pageNum, $what)    // 페이지 번호를 누르면 실행
    {
        $this->load->database();
        $this->load->model('onlyBoard_model');
        if ($what == "search") {            // 만약 검색 한 상태이면
            $search = $this->input->post('search'); // 검색 하고자 하는 탭을 저장
            $search_input = $this->input->post('search_input'); // 검색 값 저장
            $result = $this->onlyBoard_model->search($search, "board", $search_input);  // 데이터 베이스에서 검색
            $show = "search";
        } else {
            $result = $this->onlyBoard_model->gets('board');    // 검색한 것이 아니면 그냥 출력
            $show = "modern";
        }
        $this->load->view('head');
        if ($show == 'search') {    // 검색 했으면 실행
            // 저장한 값을 넘겨준다.
            $this->load->view('board\onlyBoard_view_page.php', array('pageNum' => $pageNum, 'result' => $result, 'show' => $show, 'search' => $search, 'search_input' => $search_input));
        } else {                    // 검색 안했을 때
            $this->load->view('board\onlyBoard_view_page.php', array('pageNum' => $pageNum, 'result' => $result, 'show' => $show));
        }
        $this->load->view('footer');
    }

    public function write()                 // 글쓰기
    {
        $this->load->view('head');
        $this->load->view('board\onlyBoard_write.php');
        $this->load->view('footer');
    }

    public function writeSend()             // 글쓴 내용 저장
    {
        $this->load->database();
        $this->load->model('onlyBoard_model');
        $this->load->view('head');
        $this->load->view('board\onlyBoard_write_send.php');
        $this->load->view('footer');
    }

    public function show($id, $pageNum)             // 글 보기
    {
        $this->load->database();
        $this->load->model('onlyBoard_model');
        $result = $this->onlyBoard_model->get('board', $id);                            // 모델의 함수 호출
        $this->onlyBoard_model->modify_hits('board', $id);                              // 조회수 + 1
        $commend_result = $this->onlyBoard_model->commend_gets($id);                    // 댓글 부분 저장
        $commend_commend_result = $this->onlyBoard_model->commend_commend_gets($id);    // 댓글의 댓글 부분 저장
        $this->load->view('head');
        // 값들을 배열에 담아서 넘겨준다.
        $this->load->view('board\onlyBoard_show.php', array('id' => $id, 'commend_result' => $commend_result, 'commend_commend_result' => $commend_commend_result, 'pageNum' => $pageNum, 'result' => $result));
        $this->load->view('footer');
    }

    public function commend($id, $pageNum)          // 댓글 쓰면 실행
    {
        session_start();                            // 세션 시작
        $this->load->database();
        $this->load->model('onlyBoard_model');
        // 댓글을 쓰면 인설트 한다.
        $this->onlyBoard_model->commend_insert(1, $id, $this->session->userdata('id'), $_POST['commend_subject']);
        echo "<script>document.location.href='http://localhost/index.php/onlyBoard/show/$id/$pageNum'</script>";
    }

    public function commend_commend($id, $pageNum, $commend_commend_id) // 댓글의 댓글을 쓰면 실행
    {
        session_start();
        $this->load->database();
        $this->load->model('onlyBoard_model');
        // 댓글의 댓글을 인설트 한다.
        $this->onlyBoard_model->commend_commend_insert(2, $id, $commend_commend_id, $this->session->userdata('id'), $_POST['commend_commend_content']);
        echo "<script>document.location.href='http://localhost/index.php/onlyBoard/show/$id/$pageNum'</script>";
    }

    public function modify($id, $pageNum)       // 글 수정
    {
        $this->load->database();
        $this->load->model('onlyBoard_model');
        $result = $this->onlyBoard_model->get('board', $id);    // id에 맞는 행을 하나 가져온다.
        $this->load->view('head');
        $this->load->view('board\onlyBoard_modify.php', array('pageNum' => $pageNum, 'result' => $result));
        $this->load->view('footer');
    }

    public function modifySend($id, $pageNum)   // 글 수정 후
    {
        $this->load->database();
        $this->load->model('onlyBoard_model');
        if (isset($_POST['subject'])) {             // 수정한 제목이 있으면
            $subject = $this->input->post('subject', true);     // 저장
            $context = $this->input->post('context', true);     // 저장
        }
        $this->onlyBoard_model->modify("board", $subject, $context, $id);
        $this->load->view('head');
        echo "<script>document.location.href='http://localhost/index.php/onlyBoard/show/$id/$pageNum'</script>";
        $this->load->view('footer');
    }

    public function remove($id)             // 글 삭제
    {
        $this->load->database();
        $this->load->model('onlyBoard_model');
        $this->load->view('head');
        $this->load->view('board\onlyBoard_remove.php', array('id' => $id));
        $this->load->view('footer');
    }

}

?>