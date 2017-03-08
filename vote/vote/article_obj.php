<?php
class Article{
    private $index;
    private $path;
    
    public function getIndex()
    {
        return $this->index;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setIndex($index)
    {
        $this->index = $index;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }
}

?>