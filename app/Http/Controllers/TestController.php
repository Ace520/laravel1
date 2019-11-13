<?php


namespace App\Http\Controllers;

use  FormBuilder\Factory\Elm;

class TestController extends Controller
{
    public function index()
    {
        $action = '/save.php';
        $method = 'POST';

        $input = Elm::input('goods_name', '商品名称')->required();
        $textarea = Elm::textarea('goods_info', '商品简介');
        $switch = Elm::switches('is_open', '是否开启')->activeText('开启')
            ->inactiveText('关闭');
        //创建表单
        $form = Elm::createForm($action)->setMethod($method);
        //添加组件
        $form->setRule([$input, $textarea]);
        $form->append($switch);
        //生成表单页面
        echo $data = $form->view();
    }
}
