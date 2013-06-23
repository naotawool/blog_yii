<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			/* テスト用のデータベース接続を提供するためには、コメントを外すこと
			'db'=>array(
				'connectionString'=>'テスト用データベースの DSN',
			),
			*/
			'db'=>array(
				'class' => 'system.db.CDbConnection',
				'connectionString' => 'mysql:host=localhost;dbname=test_blog',
				'emulatePrepare' => true,
				'username' => 'test_blog',
				'password' => 'test_blog',
				'charset' => 'utf8',
				'tablePrefix'=>'tbl_',
				'enableProfiling' => true,
				'schemaCachingDuration'=>3600,  // 読み取った DB のスキーマデータを 3600 秒間キャッシュする
			),
		),
	)
);
