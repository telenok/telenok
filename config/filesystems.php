<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Default Filesystem Disk
	|--------------------------------------------------------------------------
	|
	| Here you may specify the default filesystem disk that should be used
	| by the framework. A "local" driver, as well as a variety of cloud
	| based drivers are available for your choosing. Just store away!
	|
	| Supported: "local", "s3", "rackspace"
	|
	*/

	'default' => 'local',

    'upload' => [
        'protected' => 'protected/upload',
        'public' => 'public/upload',
    ],

    'cache' => [
        'directory' => 'cache',
        'logic_storage' => function($filename) 
        {
            return \App\Telenok\Core\Support\File\Store::storageList(array_map("trim", explode(',', env('CACHE_STORAGES'))))->all();
        }
    ],
    
	/*
	|--------------------------------------------------------------------------
	| Default Cloud Filesystem Disk
	|--------------------------------------------------------------------------
	|
	| Many applications store files both locally and in the cloud. For this
	| reason, you may specify a default "cloud" driver here. This driver
	| will be bound as the Cloud disk implementation in the container.
	|
	*/

	'cloud' => 's3',

	/*
	|--------------------------------------------------------------------------
	| Filesystem Disks
	|--------------------------------------------------------------------------
	|
	| Here you may configure as many filesystem "disks" as you wish, and you
	| may even configure multiple disks of the same driver. Defaults have
	| been setup for each driver as an example of the required options.
	|
	*/

	'disks' => [

		'local' => [
			'driver' => 'local',
			'root'   => public_path(),
            'retrieve_url' => function($path, $width = 0, $height = 0, $action = '') 
                {
                    return \App\Telenok\Core\Support\File\StoreCache::pathCache($path, $width, $height, $action);
                }
		],

		's3' => [
			'driver' => 's3',
			'key'    => 'your-key',
			'secret' => 'your-secret',
			'region' => 'your-region',
			'bucket' => 'your-bucket',
            'retrieve_url' => 'http://s3.eu-central-1.amazonaws.com/<bucket-key>'
		],

		'rackspace' => [
			'driver'    => 'rackspace',
			'username'  => 'your-username',
			'key'       => 'your-key',
			'container' => 'your-container',
			'endpoint'  => 'https://identity.api.rackspacecloud.com/v2.0/',
			'region'    => 'IAD',
			'url_type'  => 'publicURL',
            'retrieve_url' => function($path, $width = 0, $height = 0, $action = '') 
                {
                    return \App\Telenok\Core\Support\File\StoreCache::pathCache($path, $width, $height, $action);
                }
        ],
	],
];