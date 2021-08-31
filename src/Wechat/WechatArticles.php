<?php
namespace Wechat;

class WechatArticles {

    public $content_url;

    public function index() {
        $html = file_get_contents($this->content_url);
        preg_match_all("/id=\"js_content\" style=\"visibility: hidden;\">(.*)<script/iUs",$html,$content,PREG_PATTERN_ORDER);
        $content = "<div id='js_content'>".$content[1][0];
        $content = str_replace("data-src","src",$content);
        $content = str_replace("preview.html","player.html",$content);

        preg_match_all('/var nickname = \"(.*?)\";/si',$html,$m);
        $nickname = $m[1][0];//公众号昵称
        preg_match_all('/var round_head_img = \"(.*?)\";/si',$html,$m);
        $head_img = $m[1][0];//公众号头像

        return [
            'content' => $content,
            'nickname' => $nickname,
            'head_img' => $head_img
        ];
    }
}
