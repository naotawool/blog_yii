<?php
class PostTest extends WebTestCase
{
    public $fixtures=array(
            'posts'=>'Post',
    );

    public function testShow() {
        //         $this->open('post/1');
        $this->open('post/view?id=1');
        // サンプルの記事のタイトルが存在することを確認
        $this->assertTextPresent($this->posts['sample1']['title']);
        // コメントフォームが存在することを確認
        $this->assertTextPresent('コメントをどうぞ');
    }

}
