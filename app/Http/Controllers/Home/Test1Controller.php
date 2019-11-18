<?php

namespace App\Http\Controllers\Home;

use App\Test1;
use Illuminate\Http\Request;
use Foryoufeng\Generator\Message;
use App\Http\Controllers\Controller;
/**
 * 测试
 */
class Test1Controller extends Controller
{
    use Message;
    
    public function index(Request $request)
    {
        if($request->expectsJson()){
           $name=$request->get('content');
            $title=$request->get('title');
            $query=Test1::orderByDesc('id');
            if($name){
                $query=$query->where('content','like','%'.$name.'%');
            }
            if($title){
                $query=$query->where('title','like','%'.$title.'%');
            }
            return $this->success($query->paginate()->toArray());
        }
        return view('home.test1.index');
    }

    public function show(Request $request)
    {
        $test1=Test1::find(1);

        return view('home.test1.show',[
            'item'=>$test1
        ]);
    }
    
    public function update(Request $request)
    {
        $id=(int)$request->get('id');
        $test1=null;
        if($id){
            $test1=Test1::whereId($id)->first();
        }
        if($request->expectsJson()){
            $data=$request->validate([
                'id' => 'required|int',
                'name'=>'required',
            ]);

            if(!$test1){
                $test1=new Test1();
            }
            $test1->fill($data);
            if($test1->save()){
                return $this->success('保存成功');
            }
            return $this->error('保存失败');
        }

        if(!$test1){
            $test1=[
                'id'=>0,
                'name'=>''
            ];
        }
        return view('home.test1.update',compact('test1'));
    }
    
    public function delete(Request $request)
    {
        $id=(int)$request->get('id');
        $test1=Test1::whereId($id)->first();
        if($test1 && $test1->delete()){
            return $this->success('删除成功');
        }
        return $this->error('删除失败');
    }
}