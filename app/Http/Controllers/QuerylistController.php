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
        $url = 'https://learnku.com/articles/38644';
        if (!$html = Cache::get($url)){
            $html = QueryList::get($url)->getHtml();
            Cache::forever($url,$html);
        }
        $rules = [
            'title'=> ['.article-content .pull-left','text'],
            'time'=> ['.article-content .book-article-meta a:eq(2) span','text'],
            'content' => ['.article-content .markdown-body','html','-.meta'],
            'topic_icon' => ['.article-content .book-article-meta a:eq(1) .image','src'],
            'topic_name' => ['.article-content .book-article-meta a:eq(1)','text'],
            'tags' => ['.article-content .markdown-body .meta','html'],
        ];
        $ql =  QueryList::html($html)->rules($rules)->query();
        $data = $ql->getData()->first();
        $data['url'] = $url;
        $data['content'] = $this->htmlToMarkdown($data['content']);
        $tags = QueryList::html($data['tags'])->find('a')->getString();
        $data['tags'] = is_array($tags) && count($tags) > 0 ? implode(',', $tags):'';
        dd($data);
    }
    private function htmlToMarkdown($html){
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
        $converter = new HtmlConverter($environment);
        $markdown = $converter->convert($html);
        return $markdown;
    }
}
