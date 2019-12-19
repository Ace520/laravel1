<?php


namespace App\Http\Controllers;


use Phpml\Association\Apriori;

class PhpMlController extends Controller
{
    public function index(){
        $samples = [['衣服', '鞋子', '苹果'], ['苹果', '面条', '席子'], ['衣服','席子', '面条'], ['衣服','面条','鞋子'],['衣服', '面条', '苹果'],['衣服', '鞋子', '苹果']];
        $labels  = [];
        $associator = new Apriori($support = 0.5, $confidence = 0.5);
        $associator->train($samples, $labels);
        print_r($associator->predict(['衣服']));
    }
}
