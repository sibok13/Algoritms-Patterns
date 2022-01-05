<?php 

// Реализовать построение и обход дерева для математического выражения.

// Это простой вариант решения, без учета приоритетности математических операторов.

class Root {

    public $value;
    public $left;
    public $right;

    public function __construct ($value){

        $this -> value = $value;
        $this -> left = null;
        $this -> right = null;
    }
}

function isOperator($c){
    if ($c == '+' || $c == '-' || $c == '*' || $c == '/' || $c == '^'){
        return true;
    } else {
        return false;
    }
}

function passTree($tree){
    if (!is_null($tree)){
        passTree($tree -> left);
        echo $tree -> value;
        passTree($tree -> right);
    }
}

function constructTree($postfix){
    $stack = new SplStack();
    $arrPostfix = str_split($postfix);

    for($i=0; $i <= count($arrPostfix); $i++){

        if(!isOperator($arrPostfix[$i]) && !is_null($arrPostfix[$i])){
            
            if($stack -> isEmpty()){
                $tree = new Root($arrPostfix[$i]);
                $stack -> push($tree);
            } else {
                $tree = $stack -> pop();
                $root = new Root($arrPostfix[$i]);
                $tree -> right = $root;
                $stack -> push($tree);
            }
        }

        elseif(!is_null($arrPostfix[$i])) {
            $tree = new Root($arrPostfix[$i]);
            $root = $stack -> pop();;
            $tree -> left = $root;
            $stack -> push($tree);
        }
    }

    $tree = $stack -> pop();
    return $tree;
}

$postfix = "z*a+b-c";
$r = constructTree($postfix);
passTree($r);