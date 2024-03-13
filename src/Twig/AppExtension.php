<?php

namespace App\Twig;

use App\Entity\Brand;
use App\Entity\ChildService;
use App\Entity\Model;
use App\Entity\Service;
use App\Entity\SubService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('ucfirst', [$this, 'ucfirst']),
            new TwigFunction('get_utp', [$this, 'get_utp']),
            new TwigFunction('price_calc', [$this, 'priceCalculation']),
            new TwigFunction('is_simple_page', [$this, 'is_simple_page']),
            new TwigFunction('get_description_simple_page', [$this, 'get_description_simple_page']),
            new TwigFunction('get_title_simple_page', [$this, 'get_title_simple_page']),
            new TwigFunction('get_title_basic_site', [$this, 'get_title_basic_site']),
            new TwigFunction('get_title_brand_page', [$this, 'get_title_brand_page']),
            new TwigFunction('get_title_model_page', [$this, 'get_title_model_page']),
            new TwigFunction('get_description_special_site', [$this, 'get_description_special_site']),
            new TwigFunction('get_description_basic_site', [$this, 'get_description_basic_site']),
            new TwigFunction('get_description_brand_page', [$this, 'get_description_brand_page']),
            new TwigFunction('get_description_model_page', [$this, 'get_description_model_page']),
            new TwigFunction('is_service_from_domain_special_site', [$this, 'is_service_from_domain_special_site']),
            new TwigFunction('get_title_h1', [$this, 'get_title_h1']),
            new TwigFunction('get_domain_zone', [$this, 'get_domain_zone']),
            new TwigFunction('get_all_services', [ServiceRuntime::class, 'get_all_services']),
            new TwigFunction('get_all_promo', [PromoRuntime::class, 'get_all_promo']),
            new TwigFunction('get_files_for_gallery', [$this, 'get_files_for_gallery']),
            new TwigFunction('get_current_service', [ServiceRuntime::class, 'get_current_service']),
            new TwigFunction('get_services_for_price_list', [ServiceRuntime::class, 'get_services_for_price_list']),
            new TwigFunction('get_service', [ServiceRuntime::class, 'get_service']),
            new TwigFunction('under_price_text', [$this, 'under_price_text']),
            new TwigFunction('get_service_title', [$this, 'get_service_title']),
            new TwigFunction('get_service_description', [$this, 'get_service_description']),
        ];
    }

    public function under_price_text(string $serviceSlug): string
    {
        return match ($serviceSlug) {
            'remont-rulevyh-reek' => '💰 Выгодно выкупим вашу неисправную рулевую рейку и сделаем скидку на замену новой.',
            'remont-turbiny' => '💰 Выгодно выкупим вашу неисправную турбину и сделаем скидку на замену новой.',
            default => '',
        };
    }

    /**
     * Подсчет работы норма часа
     */
    public function priceCalculation(float $hours): float
    {
        return 1500 * $hours;
    }

    /**
     * Преобразует первый символ строки в верхний регистр
     */
    public function ucfirst(string $string): string
    {
        $fc = mb_strtoupper(mb_substr($string, 0, 1));
        return $fc . mb_substr($string, 1);
    }

    /**
     * Поиск изображений примеров работ для услуг и дочерних услуг
     */
    public function get_files_for_gallery(): bool|array
    {
        $dir = getcwd() . '/img/our_works';

        $files = array_diff(scandir($dir), array('..', '.'));

        $f = [];
        foreach ($files as $k => $file) {
            $f[$k] = 'img/our_works' . '/' . $file;
        }

        return $f;
    }

    /**
     * Рендеринг УТП
     */
    public function get_utp(string $name = ''): array
    {
        return [
            'utp1' => 'Честно считаем стоимость ' . $name,
            'utp2' => 'Гарантия на ремонт 1 год ' . $name,
            'utp3' => 'Запчасти в наличии',
        ];
    }


    /**
     * Поверка является ли страница статичной
     */
    public function is_simple_page(string $page_name): bool
    {
        return match ($page_name) {
            '/services/', '/price_list/', '/contacts/', '/about/',
            '/pricing-coupons/', '/reviews/', '/certificates/', "/gallery/" => true,
            default => false,
        };
    }

    /**
     * Генерация мета-тегов description для статичных страниц
     */
    public function get_description_simple_page(string $page, ?Service $service): string
    {
        return match ($page) {
            '/services/' => "Услуги и цены по ремонту и обслуживанию авто - автосервис АМ+.",
            '/about/' => "О автосервисе АМ+. Полезная информация о нашей компании.",
            '/pricing-coupons/' => "Необходимая информация для корпоративных клиентов и юридических лиц",
            '/reviews/' => "Независимые отзывы от наших клиентов. Автосервис АМ+",
            '/certificates/' => "Наши сертификаты. Сертифицированный автосервис АМ+",
            "/gallery/" => "Примеры и фотографии выполненных работ - автосервис АМ+",
            '/price_list/' => ' Прайс лист на ремонт и обслуживание авто - автосервис АМ+',
            '/contacts/' => "Контакты и схема проезда - автосервис АМ+",
        };
    }

    /**
     * Генерация мета-тегов title для статичных страниц
     */
    public function get_title_simple_page(string $page, ?Service $service_from_domain): string
    {
        return match ($page) {
            '/services/' => "Услуги и цены | Автосервис АМ+",
            '/about/' => "О компании | Автосервис АМ+",
            '/pricing-coupons/' => "Корпоративным клиентам | Автосервис АМ+",
            '/reviews/' => "Отзывы | Автосервис АМ+",
            '/certificates/' => "Сертификаты | Автосервис АМ+",
            "/gallery/" => "Примеры выполненных работ | Автосервис АМ+",
            '/price_list/' => "Прайс лист | Автосервис АМ+",
            '/contacts/' => "Контакты | Автосервис АМ+",
        };
    }

    /**
     * Генерация мета-тегов description услуг и дочерних услуг базовых сайтов
     */
    public function get_description_basic_site(): string
    {
        return "Ремонт автомобиля цена. ⭐ Сервис АМ Плюс в Москве. ✔️ Бесплатная диагностика ходовой. ✔️ Бесплатная замена масла и фильтров  ⏩ Автосервис в ВАО Москвы.";
    }

    /**
     * Генерация мета-тегов title услуг и дочерних услуг базовых сайтов
     */
    public function get_title_basic_site(): string
    {
        return "Автосервис АМ+ — ремонт автомобиля в Москве. ВАО. Прайс лист";
    }

    /**
     * Генерация мета-тегов description для страниц марок
     */
    public function get_description_brand_page(Service|SubService|ChildService|null $service, Brand $brand): string
    {
        $serviceName = $this->get_service_name($service);

        if (!$serviceName) {
            return 'Ремонт ' . $brand->getName() . ' цена. ⭐ Сервис ' . $brand->getRusName() . ' АМ Плюс в Москве. ✔️ Бесплатная диагностика ходовой. ✔️ Бесплатная замена масла и фильтров  ⏩ Автосервис ' . preg_replace('/[(]|[)]/', '', $brand->getRusName()) . ' в ВАО Москвы.';
        } else {
            return $serviceName . ' ' . $brand->getName() . ' в Москве. ⭐ Автосервис ' . $brand->getRusName() . ' АМ Плюс. ✔️ Бесплатная диагностика подвески. ⏩ ' . $serviceName . ' ' . preg_replace('/[(]|[)]/', '', $brand->getRusName()) . ' цена.';
        }
    }

    /**
     * Генерация мета-тегов title для страниц марок
     */
    public function get_title_brand_page(Service|SubService|ChildService|null $service, Brand $brand): string
    {
        $serviceName = $this->get_service_name($service) ?? "Ремонт и сервис";
        $name = $this->ucfirst($serviceName);

        return $name . ' ' . $brand->getName() . ' ' . $brand->getRusName() . ' в Москве | АМ+';
    }

    public function get_service_title(Service|SubService|ChildService|null $service): string
    {
        $serviceName = $this->get_service_name($service);
        $name = $this->ucfirst($serviceName);

        if (str_contains('Электрооборудование', $name)) {
            $name = 'Ремонт электрооборудования';
        }

        return $name . ' цена в Москве | АМ+';
    }

    public function get_service_description(Service|SubService|ChildService|null $service): string
    {
        $serviceName = $this->get_service_name($service);
        $name = $this->ucfirst($serviceName);

        if (str_contains('Электрооборудование', $name)) {
            $name = 'Ремонт электрооборудования';
        }

        return $name . ' в Москве. ⭐ Автосервис АМ Плюс. ✔️ Бесплатная диагностика подвески. ⏩ ' . $name . ' цена.';
    }

    /**
     * Генерация мета-тегов description для страниц моделей
     */
    public function get_description_model_page(Service|SubService|ChildService|null $service, Model $model): string
    {
        $serviceName = $this->get_service_name($service);
        if (!$serviceName) {
            return 'Ремонт ' . $model->getBrand()->getName() . ' ' . $model->getName() . ' цена в Москве. ⭐ Автосервис ' . $model->getRusName() . ' АМ Плюс. ✔️ Бесплатная диагностика подвески. ✔️ Бесплатная замена масла и фильтров  ⏩ Сервис ' . preg_replace('/[(]|[)]/', '', $model->getRusName()) . ' в ВАО Москвы.';
        } else {
            return $serviceName . ' ' . $model->getBrand()->getName() . ' ' . $model->getName() . ' в Москве. ⭐ Автосервис ' . $model->getBrand()->getRusName() . ' АМ Плюс. ✔️ Бесплатная диагностика подвески. ⏩ ' . $serviceName . ' ' . preg_replace('/[(]|[)]/', '', $model->getRusName()) . ' цена.';
        }
    }

    /**
     * Генерация мета-тегов title для страниц моделей
     */
    public function get_title_model_page(Service|SubService|ChildService|null $service, Model $model): string
    {
        $serviceName = $this->get_service_name($service) ?? "Ремонт и сервис";

        return $this->ucfirst($serviceName) . ' ' . $model->getBrand()->getName() . ' ' . $model->getName() . ' ' . $model->getRusName() . ' Москве | АМ+';
    }

    /**
     * Генерация заголовков h1
     */
    public function get_title_h1(Service|SubService|ChildService|null $service, string $brand = '', string $model = ''): string
    {
        $serviceName = $this->get_service_name($service) ?? "Ремонт и сервис";
        $name = $this->ucfirst($serviceName);

        if (str_contains('Электрооборудование', $name)) {
            $name = 'Ремонт электрооборудования';
        }

        if ($brand) {
            $str = $name . ' ' . $brand . ' в Москве';
        } elseif ($model) {
            $str = $name . ' ' . $model . ' в Москве';
        } elseif ($serviceName && $_SERVER['REQUEST_URI'] !== '/') {
            $str = $name . ' в Москве';
        } else {
            $str = 'Автосервис «АМ+» — ремонт авто в Москве';
        }
        return $str;
    }

    /**
     * Получить имя услуги, дочерней услуги
     */
    private function get_service_name(Service|SubService|ChildService|null $service): ?string
    {
        return $service?->getName();
    }
}