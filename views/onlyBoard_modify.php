<center><br>
    <h1>hajae<br><br></h1>

    <table>
        <!--글 수정-->
        <form action='http://localhost/index.php/onlyBoard/modifySend/<?php echo $result[0]['id'] ?>/<?php echo $pageNum ?>'
              method='post'>
            <tr>
                <td style='height:50px; width: 100px;'><h4>제목</h4></td> <!--원래 값을 적어준다.-->
                <td><input class='form-control' type='text' style='width: 700px' name='subject'
                           value="<?php echo $result[0]['subject']; ?>"></td>
            </tr>

            <tr>
                <td><h4>내용</h4></td>             <!--원래 값을 적어준다.-->
                <td><textarea class='form-control' cols='30' rows='10' style='width: 700px;height: 500px'
                              name='context'><?php echo $result[0]['context']; ?></textarea></td>
            </tr>
            <tr style='height: 100px'>
                <td></td>
                <td style='text-align: center'>
                    <input class='btn btn-default' type='submit' value='수정'>
                </td>
            </tr>
        </form>
    </table>
</center>
