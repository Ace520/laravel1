<?php


namespace App\Http\Controllers;


use App\User;
use Spatie\QueryBuilder\QueryBuilder;

class TestController extends Controller
{
    public function index(){
        $users = QueryBuilder::for(User::class)
            ->allowedFields(['id', 'name'])
            ->toSql();
        dd($users);
    }
}
