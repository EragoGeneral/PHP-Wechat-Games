<?php  
  
/* * *********************************************  
 * @����:   page  
 * @����:   $myde_total - �ܼ�¼��  
 *          $myde_size - һҳ��ʾ�ļ�¼��  
 *          $myde_page - ��ǰҳ  
 *          $myde_url - ��ȡ��ǰ��url  
 * @����:   ��ҳʵ��  
 */  
  
class page {  
  
    private $myde_total;          //�ܼ�¼��  
    private $myde_size;           //һҳ��ʾ�ļ�¼��  
    private $myde_page;           //��ǰҳ  
    private $myde_page_count;     //��ҳ��  
    private $myde_i;              //��ͷҳ��  
    private $myde_en;             //��βҳ��  
    private $myde_url;            //��ȡ��ǰ��url  
    /*  
     * $show_pages  
     * ҳ����ʾ�ĸ�ʽ����ʾ���ӵ�ҳ��Ϊ2*$show_pages+1��  
     * ��$show_pages=2��ôҳ������ʾ����[��ҳ] [��ҳ] 1 2 3 4 5 [��ҳ] [βҳ]   
     */  
    private $show_pages;  
  
    public function __construct($myde_total = 1, $myde_size = 1, $myde_page = 1, $myde_url, $show_pages = 2) {  
        $this->myde_total = $this->numeric($myde_total);  
        $this->myde_size = $this->numeric($myde_size);  
        $this->myde_page = $this->numeric($myde_page);  
        $this->myde_page_count = ceil($this->myde_total / $this->myde_size);  
        $this->myde_url = $myde_url;  
        if ($this->myde_total < 0)  
            $this->myde_total = 0;  
        if ($this->myde_page < 1)  
            $this->myde_page = 1;  
        if ($this->myde_page_count < 1)  
            $this->myde_page_count = 1;  
        if ($this->myde_page > $this->myde_page_count)  
            $this->myde_page = $this->myde_page_count;  
        $this->limit = ($this->myde_page - 1) * $this->myde_size;  
        $this->myde_i = $this->myde_page - $show_pages;  
        $this->myde_en = $this->myde_page + $show_pages;  
        if ($this->myde_i < 1) {  
            $this->myde_en = $this->myde_en + (1 - $this->myde_i);  
            $this->myde_i = 1;  
        }  
        if ($this->myde_en > $this->myde_page_count) {  
            $this->myde_i = $this->myde_i - ($this->myde_en - $this->myde_page_count);  
            $this->myde_en = $this->myde_page_count;  
        }  
        if ($this->myde_i < 1)  
            $this->myde_i = 1;  
    }  
  
    //����Ƿ�Ϊ����  
    private function numeric($num) {  
        if (strlen($num)) {  
            if (!preg_match("/^[0-9]+$/", $num)) {  
                $num = 1;  
            } else {  
                $num = substr($num, 0, 11);  
            }  
        } else {  
            $num = 1;  
        }  
        return $num;  
    }  
  
    //��ַ�滻  
    private function page_replace($page) {  
        return str_replace("{page}", $page, $this->myde_url);  
    }  
  
    //��ҳ  
    private function myde_home() {  
        if ($this->myde_page != 1) {  
            return "<a href='" . $this->page_replace(1) . "' title='��ҳ'>��ҳ</a>";  
        } else {  
            return "<p>��ҳ</p>";  
        }  
    }  
  
    //��һҳ  
    private function myde_prev() {  
        if ($this->myde_page != 1) {  
            return "<a href='" . $this->page_replace($this->myde_page - 1) . "' title='��һҳ'>��һҳ</a>";  
        } else {  
            return "<p>��һҳ</p>";  
        }  
    }  
  
    //��һҳ  
    private function myde_next() {  
        if ($this->myde_page != $this->myde_page_count) {  
            return "<a href='" . $this->page_replace($this->myde_page + 1) . "' title='��һҳ'>��һҳ</a>";  
        } else {  
            return"<p>��һҳ</p>";  
        }  
    }  
  
    //βҳ  
    private function myde_last() {  
        if ($this->myde_page != $this->myde_page_count) {  
            return "<a href='" . $this->page_replace($this->myde_page_count) . "' title='βҳ'>βҳ</a>";  
        } else {  
            return "<p>βҳ</p>";  
        }  
    }  
  
    //���  
    public function myde_write($id = 'page') {  
        $str = "<div id=" . $id . ">";  
        $str.=$this->myde_home();  
        $str.=$this->myde_prev();  
        if ($this->myde_i > 1) {  
            $str.="<p class='pageEllipsis'>...</p>";  
        }  
        for ($i = $this->myde_i; $i <= $this->myde_en; $i++) {  
            if ($i == $this->myde_page) {  
                $str.="<a href='" . $this->page_replace($i) . "' title='��" . $i . "ҳ' class='cur'>$i</a>";  
            } else {  
                $str.="<a href='" . $this->page_replace($i) . "' title='��" . $i . "ҳ'>$i</a>";  
            }  
        }  
        if ($this->myde_en < $this->myde_page_count) {  
            $str.="<p class='pageEllipsis'>...</p>";  
        }  
        $str.=$this->myde_next();  
        $str.=$this->myde_last();  
        $str.="<p class='pageRemark'>��<b>" . $this->myde_page_count .  
                "</b>ҳ<b>" . $this->myde_total . "</b>������</p>";  
        $str.="</div>";  
        return $str;  
    }  
  
}  
  
?>