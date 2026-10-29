<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Open+Sans:wght@400;600;700&display=swap',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css',
        'css/bootstrap.min.css',   // bootstrap do template Hotelier
        'css/informuseus.css',     // estilos do InforMuseus (vem depois para sobrepor)
    ];

    public $js = [
        'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js',
    ];

    // Só jQuery/YiiAsset. NÃO usar yii\bootstrap5\BootstrapAsset: carregava um 2.º bootstrap.
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
