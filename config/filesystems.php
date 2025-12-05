<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    */
    'default' => env('FILESYSTEM_DISK', 'oci'),

    /*
    |--------------------------------------------------------------------------
    | Cloud Disk
    |--------------------------------------------------------------------------
    */
    'cloud' => 'oci',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    */
    'disks' => [

        'local' => [
            'driver' => 'local',
            'root'   => storage_path('app'),
            'throw'  => false,
        ],

        'public' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public'),
            'url'        => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw'      => false,
        ],

        'oci' => [
            'driver'   => 's3',
            'key'      => env('OCI_ACCESS_KEY'),
            'secret'   => env('OCI_SECRET_KEY'),
            'region'   => env('OCI_REGION'),
            'bucket'   => env('OCI_BUCKET'),

            // Oracle S3 Compat Endpoint
            'endpoint' => sprintf(
                'https://%s.compat.objectstorage.%s.oraclecloud.com',
                env('OCI_NAMESPACE'),
                env('OCI_REGION')
            ),

            // Required for Oracle
            'use_path_style_endpoint' => true,
            'bucket_endpoint'         => false,

            'visibility' => 'public',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    */
    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
