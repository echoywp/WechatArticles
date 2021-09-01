<?php
namespace Wechat;

class WechatArticles {

    public $content_url;

    protected $html;

    public function index() {
        $this->html = file_get_contents($this->content_url);
        return [
            'title' => $this->getTitle(),
            'publish_date' => $this->getPublishDate(),
            'content' => $this->getContent(),
            'nickname' => $this->getNickname(),
            'head_img' => $this->getHeadImg()
        ];
    }

    //文章内容
    protected function getContent() {
        preg_match_all("/id=\"js_content\" style=\"visibility: hidden;\">(.*)<script/iUs", $this->html, $content, PREG_PATTERN_ORDER);
        $content = "<div id='js_content'>".$content[1][0];
        $content = str_replace("data-src","src",$content);
        $content = str_replace("preview.html","player.html",$content);
        return $content;
    }

    // 文章标题
    protected function getTitle() {
        preg_match_all('/twitter:title" content=\"(.*?)\" \/>/si', $this->html, $m);
        return array_key_exists(1, $m)? $m[1][0] : '';
    }

    protected function getPublishDate(){
        preg_match_all('/var ct = \"(.*?)\";/si', $this->html, $m);
        return array_key_exists(1, $m)? $m[1][0] : '';
    }

    //公众号头像
    protected function getHeadImg() {
        preg_match_all('/var round_head_img = \"(.*?)\";/si', $this->html, $m);
        return array_key_exists(1, $m)? $m[1][0] : '';
    }

    //公众号昵称
    protected function getNickname() {
        preg_match_all('/var nickname = \"(.*?)\";/si', $this->html, $m);
        return array_key_exists(1, $m)? $m[1][0] : '';
    }
}
