<?php
/**
 *PHP Trie树
 * 
 * @author iamlaobie@gmail.com
 * @since 2012-08-19
 */
class Trie
{  
    /**
     * 树的存储
     */
    private $_tree = array();

    /**
     * 插入一个新词
     * 
     * @param $word 词
     * @param $data 词附加属性
     */
    public function insert($word, $data = array())
    {
        $cur = & $this->_tree;
        for($i = 0, $len = strlen($word); $i < $len; $i++){
            $ascValue = ord($word[$i]);
            if(!isset($cur[$ascValue])){
                $cur[$ascValue] = array();
            }

            if($i == $len - 1){
                $data['text'] = $word;
                $cur[$ascValue]['$'] = $data;
                break;
            }else{
                $cur = & $cur[$ascValue];
            }
        }
    }
    
    /**
     * 查找词
     */
    public function find($word)
    {
        $cur = & $this->_tree;
        for($i = 0, $len = strlen($word); $i < $len; $i++){
            $ascValue = ord($word[$i]); 
            if(!isset($cur[$ascValue])){
                return null;
            }
            
            if($i == $len - 1){
                if(isset($cur[$ascValue]['$'])){
                    return $cur[$ascValue]['$'];
                }
            }else{
                $cur = $cur[$ascValue];
            }
        }
        return null;
    }

    /**
     * 获取以$word为前缀的词
     * 
     * @param $depth 后缀长度
     */
    public function suffixes($word, $depth = 1)
    {
        $cur = & $this->_tree;
        $words = array();
        for($i = 0, $len = strlen($word); $i < $len; $i++){
            $ascValue = ord($word[$i]);
            if(!isset($cur[$ascValue])){
                return null;
            }

            if($i == $len - 1){
                return $this->traverse($cur, $depth); 
            }else{
                $cur = $cur[$ascValue];
            }
        }
        return null; 
    }

    /**
     * 遍历
     */
    public function traverse($tree = null, $depth = 1, $words = array(), $recuDepth = 0)
    {
        if($tree === null){
            $tree = $this->_tree;
        }

        $recuDepth += 1;
        unset($tree['$']);
         
        //中文utf8编码长度为3
        $realDepth = $depth * 3;
        foreach($tree as $ascValue => $subTree){
            if(isset($subTree['$'])){
                $words[] = $subTree['$'];    
            }
            if(!empty($subTree) && $recuDepth <= $realDepth){
                $words = $this->traverse($subTree, $depth, $words, $recuDepth);
            }
        }
        return $words;
    }

    /**
     * 打印树
     */
    public function tree()
    {
        print_r($this->_tree);
    }
}

//测试
$trie = new Trie();

$trie->insert("中国人", array('a' => 1));
$trie->insert("中国通", array('a' => 1));
$trie->insert("中国人地", array('a' => 1));
$trie->insert("中国人民", array('a' => 1));
$trie->insert("中方通", array('a' => 2));
$trie->insert("abc", array('a' => 2));
$trie->insert("外方", array('a' => 2));

var_dump($trie->suffixes('中国人', 1));
