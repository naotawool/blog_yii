<ul>
    <li><?php echo CHtml::link('新しい記事を作成',array('post/create')); ?></li>
    <li><?php echo CHtml::link('記事を管理',array('post/admin')); ?></li>
    <li><?php echo CHtml::link('コメントを承認',array('comment/index'))
        . ' (' . Comment::model()->pendingCommentCount . ')'; ?></li>
    <li><?php echo CHtml::link('ログアウト',array('site/logout')); ?></li>
</ul>