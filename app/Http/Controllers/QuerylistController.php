<?php


namespace App\Http\Controllers;


use App\Libs\Converter\TableConverter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use League\HTMLToMarkdown\Converter\BlockquoteConverter;
use League\HTMLToMarkdown\Converter\CodeConverter;
use League\HTMLToMarkdown\Converter\CommentConverter;
use League\HTMLToMarkdown\Converter\DefaultConverter;
use League\HTMLToMarkdown\Converter\EmphasisConverter;
use League\HTMLToMarkdown\Converter\HardBreakConverter;
use League\HTMLToMarkdown\Converter\HeaderConverter;
use League\HTMLToMarkdown\Converter\HorizontalRuleConverter;
use League\HTMLToMarkdown\Converter\ImageConverter;
use League\HTMLToMarkdown\Converter\LinkConverter;
use League\HTMLToMarkdown\Converter\ListBlockConverter;
use League\HTMLToMarkdown\Converter\ListItemConverter;
use League\HTMLToMarkdown\Converter\ParagraphConverter;
use League\HTMLToMarkdown\Converter\PreformattedConverter;
use League\HTMLToMarkdown\Converter\TextConverter;
use League\HTMLToMarkdown\Environment;
use League\HTMLToMarkdown\HtmlConverter;
use QL\QueryList;

class QuerylistController extends Controller
{
    public function index(){
        $url = "https://learnku.com/?page=2";
        if (!$html = Cache::get($url)){
            $html =  QueryList::get($url)->getHtml();
        }
        $ql =  new QueryList();
        $ql->html($html);
        $list = $ql->find('.category-name a')->attrs('href');
        dd($list);
    }
    public function article(){
        $url = 'https://learnku.com/articles/38646';
        $converter = $this->getHtmlConverter();
        $ql =   QueryList::get($url);
        $data['title'] = $ql->find('.article-content .pull-left')->text();
        $data['time'] = $ql->find('.article-content .book-article-meta a:eq(2) span')->attr('title');
        $tags = $ql->find('.article-content .markdown-body .meta a')->getStrings();
        $data['tags'] = is_array($tags) && count($tags) > 0 ? implode(',', $tags):'';
        $content = $ql->rules(['content'=>['.article-content .markdown-body','html','-div']])->query()->getData()->first();
        $data['content'] = $converter->convert($content['content']);
        $data['url'] = $url;
        dd($data);
    }
    private function getHtmlConverter(){
        $environment = new Environment(array(
            'preserve_comments' => true
        ));
        $environment->addConverter(new BlockquoteConverter());
        $environment->addConverter(new CodeConverter());
        $environment->addConverter(new CommentConverter());
        $environment->addConverter(new DefaultConverter());
        $environment->addConverter(new EmphasisConverter());
        $environment->addConverter(new HardBreakConverter());
        $environment->addConverter(new HeaderConverter());
        $environment->addConverter(new HorizontalRuleConverter());
        $environment->addConverter(new ImageConverter());
        $environment->addConverter(new LinkConverter());
        $environment->addConverter(new ListBlockConverter());
        $environment->addConverter(new ListItemConverter());
        $environment->addConverter(new ParagraphConverter());
        $environment->addConverter(new PreformattedConverter());
        $environment->addConverter(new TextConverter());
        $environment->addConverter(new TableConverter());
        return new HtmlConverter($environment);
    }
}
