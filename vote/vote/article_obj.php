<?php
class Article{
    private $index;
    private $path;
    private $name;
    
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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}

?>