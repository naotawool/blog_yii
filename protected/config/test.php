<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			/* �e�X�g�p�̃f�[�^�x�[�X�ڑ���񋟂��邽�߂ɂ́A�R�����g���O������
			'db'=>array(
				'connectionString'=>'�e�X�g�p�f�[�^�x�[�X�� DSN',
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
				'schemaCachingDuration'=>3600,  // �ǂݎ���� DB �̃X�L�[�}�f�[�^�� 3600 �b�ԃL���b�V������
			),
		),
	)
);
