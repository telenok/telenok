<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Default image library
	|--------------------------------------------------------------------------
	|
	| Supported: "gd", "imagick", "gmagick"
	|
	*/
	'library' => 'gd',
    'cache' => [
        // use queue for creating images cache
        'queue' => false,
        // in seconds for image processing once at time
        'lock_delay' => 60,
    ],
	'options' => 
	[
		'quality' => 85,
		'jpeg_quality' => 85, // [0 .. 100]
		'png_compression_level' => 5, // [0 ... 9]
		//'png_compression_filter' => PNG_FILTER_NONE, // [PNG_FILTER_NONE, PNG_FILTER_SUB, PNG_FILTER_UP, PNG_FILTER_AVG, PNG_FILTER_PAETH, ]
		// Other option please look at http://imagine.readthedocs.org/en/latest/index.html
	]
];