<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\Cache;
use League\HTMLToMarkdown\HtmlConverter;
use QL\QueryList;

class QuerylistController extends Controller
{
    public function index(){
        $url = 'https://learnku.com/articles/38375';
        if (!$html = Cache::get($url)){
            $html = QueryList::get($url)->find('.markdown-body')->html();
            Cache::forever($url,$html);
        }
        $converter = new HtmlConverter(['header_style' => 'atx']);
        $converter->getConfig()->setOption('list_item_style', '*');
        $markdown = $converter->convert($html);
        print_r($markdown);
    }
}
