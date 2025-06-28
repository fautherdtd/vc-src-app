<?php

namespace App\Console\Commands;

use App\Http\Controllers\Helpers\Images;
use App\Models\Category;
use App\Models\Postcards;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class YandexFeedYaml extends Command
{
    use Images;
    protected $signature = 'yandex:feed';

    public function handle()
    {
        // Основной XML-объект
        $yml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><yml_catalog></yml_catalog>');
        $yml->addAttribute('date', now()->format('Y-m-d\TH:i:sP'));

        // <shop>
        $shop = $yml->addChild('shop');
        $shop->addChild('name', 'Вальс Цветов');
        $shop->addChild('company', 'Вальс Цветов');
        $shop->addChild('url', 'https://valscvetov.ru/');
        $shop->addChild('platform', 'website');
        $shop->addChild('version', rand(1.0, 100.00));
        $shop->addChild('agency', 'Магазин цветов');
        $shop->addChild('email', 'vals.cvetov.derbent@gmail.com');

        // Категории
        $categoriesXml = $shop->addChild('categories');
        foreach (Category::all() as $category) {
            if ($category->is_visible && !$category->is_deactivation) {
                $categoryXml = $categoriesXml->addChild('category', $category->name);
                $categoryXml->addAttribute('id', $category->id);
            }
        }

        // Офферы (товары)
        $offersXml = $shop->addChild('offers');

        $products = Product::all();

        foreach ($products as $product) {
            if ($product->is_active && !$product->category->is_deactivation && $product->category->is_visible) {
                $offer = $offersXml->addChild('offer');
                $offer->addAttribute('id', $product->id);

                $offer->addChild('name', $product->name);
                $offer->addChild('categoryId', $product->category->id);
                $offer->addChild('picture', $this->getUrl($product->attachment('preview')->first()));
                $offer->addChild('url', 'https://valscvetov.ru/product/' . $product->slug);
                $offer->addChild('description', $product->description);
                $offer->addChild('currencyId', 'RUB');
                // Наличие
                $offer->addChild('available', $product->is_active === 'да' ? 'true' : 'false');
                $offer->addChild('price', $product->price);
                $offer->addChild('param', $product->qty)->addAttribute('name', 'Количество');
                $offer->addChild('param', 'грамм')->addAttribute('name', 'Единицы измерения');
            }
        }

        $postcards = Postcards::all();

        $ids = 91837;
        foreach ($postcards as $postcard) {
            if ($postcard->is_active) {
                $offer = $offersXml->addChild('offer');
                $offer->addAttribute('id', $postcard->id + $ids++);

                $offer->addChild('name', $postcard->name);
                $offer->addChild('categoryId', $postcard->category->id);
                $offer->addChild('description', $postcard->description);
                $offer->addChild('picture', $this->imagePostCard($postcard));
                $offer->addChild('currencyId', 'RUB');
                // Наличие
                $offer->addChild('available', $postcard->is_active === 'да' ? 'true' : 'false');
                $offer->addChild('price', $postcard->price);
                $offer->addChild('param', 1000)->addAttribute('name', 'Количество');
                $offer->addChild('param', 'грамм')->addAttribute('name', 'Единицы измерения');
            }
        }

        // Сохраняем файл
        $xmlString = $yml->asXML();
        if (!Storage::exists('yandex')) {
            Storage::makeDirectory('yandex');
        }

        Storage::put('yandex/yml_feed.xml', $xmlString);
        $publicUrl = rtrim(env('APP_URL'), '/') . '/storage/yandex/yml_feed.xml';
        $this->info("YML файл успешно создан! Прямая ссылка: $publicUrl");
    }


    protected function imagePostCard(Postcards $postcards): string
    {
        foreach ($postcards->attachment('postcards')->get() as $value) {
            return $this->getUrl($value);
        }
        return "";
    }
}

