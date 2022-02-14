<?php

namespace App\ProductModel;

class ProductModel {
    public function genereate(): array {
        return array(
            0 => [
                'name' => 'iPhone X',
                'description' => '5,8 pouces, caméra avant 12 mégapixels, processeur Apple A11 Bionic',
                'dateReleased' => '2017-10-27',
                'productImage' => [
                    0 => [
                        'url' => 'https://d1eh9yux7w8iql.cloudfront.net/product_images/36833_4776bbd6-9959-4ea1-85e1-3214d47d481f.jpg'
                    ],
                    1 => [
                        'url' => 'https://assets.swappie.com/cdn-cgi/image/width=600,height=600,fit=contain,format=auto/swappie-iphone-x-silver.png'
                    ]
                ]
                    ],
            1 => [
                'name' => 'iPhone 11 Pro',
                'description' => '5,8 pouces, caméra avant 12 mégapixels, appareil grand angle, ultra grand angle & téléobjectif, processur Apple A13 Bionic',
                'dateReleased' => '2019-09-20',
                'productImage' => [
                    0 => [
                        'url' => 'https://m.media-amazon.com/images/I/81mxun+6pEL._AC_SX522_.jpg'
                    ],
                    1 => [
                        'url' => 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/refurb-iphone-11-pro-max-gold-2019?wid=1144&hei=1144&fmt=jpeg&qlt=80&.v=1611101589000'
                    ],
                    2 => [
                        'url' => 'https://images.frandroid.com/wp-content/uploads/2019/08/iphone-11-pro-2019-frandroid.png'
                    ],
                    3 => [
                        'url' => 'https://www.cdiscount.com/pdt2/g/o/r/4/550x550/iphone11pro64gor/rw/apple-iphone-11-pro-or-64-go.jpg'
                    ]
                ]
            ],
            2 => [
                'name' => 'iPhone 13 Pro',
                'description' => '6,1 pouces, caméra avant 12 mégapixels, appareil grand angle, ultra grand angle & téléobjectif avec capteur LIDAR, processur Apple A15 Bionic',
                'dateReleased' => '2021-09-14',
                'productImage' => [
                    0 => [
                        'url' => 'https://store.storeimages.cdn-apple.com/4668/as-images.apple.com/is/iphone-13-pro-blue-select?wid=470&hei=556&fmt=jpeg&qlt=95&.v=1631652954000'
                    ],
                    1 => [
                        'url' => 'https://store.storeimages.cdn-apple.com/4668/as-images.apple.com/is/iphone-13-pro-max-gold-select?wid=470&hei=556&fmt=jpeg&qlt=95&.v=1631652956000'
                    ],
                    2 => [
                        'url' => 'https://store.storeimages.cdn-apple.com/4668/as-images.apple.com/is/iphone-13-pro-silver-select?wid=470&hei=556&fmt=jpeg&qlt=95&.v=1631652954000'
                    ],
                    3 => [
                        'url' => 'https://www.cdiscount.com/pdt2/b/l/u/1/550x550/ip13promax128blu/rw/apple-iphone-13-pro-max-128go-sierra-blue.jpg'
                    ],
                    4 => [
                        'url' => 'https://media.gqmagazine.fr/photos/6149b7c09cdbb56dec63edfe/master/pass/Apple_iPhone-13-Pro_Colors_09142021.jpg'
                    ]
                ]
            ],
            3 => [
                'name' => 'Samsung Galaxy S8',
                'description' => '5,8 pouces, 4G, caméra avant 12 mégapixels',
                'dateReleased' => '2017-04-21',
                'productImage' => [
                    0 => [
                        'url' => 'https://www.samsung.com/global/galaxy/galaxy-s8/images/galaxy-s8-share-image.jpg'
                    ],
                    1 => [
                        'url' => 'https://www.mytrendyphone.co.uk/images2/Nillkin-Super-Frosted-Case-for-Samsung-Galaxy-S8-Black-27042017-01-p.jpg'
                    ]
                ]
            ],
            4 => [
                'name' => 'Samsung Galaxy Z Fold3',
                'description' => '5G, USB-C, 7,6 pouces, caméra 12 mégapixels',
                'dateReleased' => '2021-09-27',
                'productImage' => [
                    0 => [
                        'url' => 'https://images.samsung.com/sg/smartphones/galaxy-z-fold3-5g/buy/zfold3_carousel_mainsinglekv_mo.jpg'
                    ],
                    1 => [
                        'url' => 'https://m.media-amazon.com/images/I/71MmJNwZcML._AC_SX679_.jpg'
                    ],
                    2 => [
                        'url' => 'https://images.samsung.com/pk/smartphones/galaxy-z-fold3-5g/buy/zfold3_carousel_multitasking_kv_mo.jpgg'
                    ]
                ]
            ]
        );
    }
}