<?php
// Phase 1 taxonomy only; product/blog datasets belong to stage 2.
$scotch = [];
foreach (['campbeltown', 'highland', 'islay', 'lowland', 'speyside', 'islands'] as $region) {
    $scotch[] = ['label' => ucfirst($region), 'url' => '/danh-muc/scotch-whisky/whisky-' . $region];
}
$world = [];
foreach (['cognac'=>'Cognac','whisky-ireland'=>'Whisky Ireland','whisky-nhat'=>'Whisky Nhật','whisky-the-lakes'=>'Whisky The Lakes','gin'=>'Gin','rum'=>'Rum','calvados'=>'Calvados','ruou-trung-quoc'=>'Rượu Trung Quốc','bourbon-whiskey'=>'Bourbon Whiskey'] as $slug=>$label) {
    $world[] = ['label'=>$label, 'url'=>'/danh-muc/world-whisky/' . $slug];
}
$products = [
    ['label'=>'Scotch Whisky','url'=>'/danh-muc/scotch-whisky','children'=>$scotch],
    ['label'=>'World Whisky','url'=>'/danh-muc/world-whisky','children'=>$world],
];
foreach (['old-rare'=>'Old & Rare','armagnac'=>'Armagnac','wine'=>'Wine','signatory-vintage'=>'Signatory Vintage','bo-qua-tang'=>'Bộ quà tặng'] as $slug=>$label) {
    $products[] = ['label'=>$label, 'url'=>'/danh-muc/' . $slug];
}
$blogs = [];
foreach (['distilleries'=>'Distilleries','news'=>'News','spirits'=>'Spirits','whisky-basics'=>'Whisky Basics','whisky-review'=>'Whisky review'] as $slug=>$label) {
    $blogs[] = ['label'=>$label, 'url'=>'/kien-thuc-whisky/' . $slug];
}
return ['products'=>$products, 'blogs'=>$blogs, 'pages'=>[
    ['label'=>'Về chúng tôi','url'=>'/ve-dangtau-whisky','children'=>[
        ['label'=>'Về Dangtau Whisky','url'=>'/ve-dangtau-whisky'],
        ['label'=>'Về nhà sáng lập','url'=>'/ve-nha-sang-lap'],
    ]],
    ['label'=>'Kiến thức Whisky','url'=>'/kien-thuc-whisky','children'=>$blogs],
    ['label'=>'Dịch vụ/Cá nhân hóa','url'=>'/dich-vu-ca-nhan-hoa'],
]];
