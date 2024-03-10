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
            new TwigFunction('get_title_special_site', [$this, 'get_title_special_site']),
            new TwigFunction('get_title_basic_site', [$this, 'get_title_basic_site']),
            new TwigFunction('get_title_brand_page', [$this, 'get_title_brand_page']),
            new TwigFunction('get_title_model_page', [$this, 'get_title_model_page']),
            new TwigFunction('is_special_site', [$this, 'is_special_site']),
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
            new TwigFunction('get_order_by_service', [ServiceRuntime::class, 'get_order_by_service']),
            new TwigFunction('get_service_from_domain', [ServiceRuntime::class, 'get_service_from_domain']),
            new TwigFunction('get_current_service', [ServiceRuntime::class, 'get_current_service']),
            new TwigFunction('get_services_for_price_list', [ServiceRuntime::class, 'get_services_for_price_list']),
            new TwigFunction('get_service', [ServiceRuntime::class, 'get_service']),
            new TwigFunction('under_price_text', [$this, 'under_price_text']),
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

    public function get_domain_zone(string $slug): string
    {
        return match ($slug) {
            'remont-avtokondicionerov', 'tehnicheskoe-obsluzhivanie' => '.ru',
            default => '.com',
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
    public function get_files_for_gallery(int $service_id): bool|array
    {
        $hostName = preg_replace('/\.[a-z]+/', '', $_SERVER['HTTP_HOST']);

        $dir = getcwd() . '/img/gallery/' . $hostName;

        $files = array_diff(scandir($dir), array('..', '.'));

        if (count($files) <= $service_id) {
            $num = round(($service_id - 127) / 2);
        } else {
            $num = $service_id;
        }

        settype($num, 'integer');

        if ($num % 2 == 0) {
            $offset = $num + 7;
        } else {
            $offset = $num - 7;
        }

        $f = [];
        foreach ($files as $k => $file) {
            $f[$k] = 'img/gallery/' . $hostName . '/' . $file;
        }

        return array_slice($f, $offset, 7);
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
     * Проверка принадлежности услуги для специализированного сайта из сетки сайтов
     */
    public function is_service_from_domain_special_site(?Service $service): bool
    {
        if (!$service) {
            return false;
        }

        return match ($service->getSlug()) {
            'remont-rulevyh-reek', 'remont-avtokondicionerov', 'tehnicheskoe-obsluzhivanie', 'remont-akpp-moskva' => true,
            default => false,
        };
    }

    /**
     * Проверка является ли сайт специализированным из сетки сайтов
     */
    public function is_special_site(): bool
    {
        $hostName = preg_replace('/\.[a-z]+/', '', $_SERVER['HTTP_HOST']);

        return match ($hostName) {
            'remont-rulevyh-reek', 'remont-avtokondicionerov', 'tehnicheskoe-obsluzhivanie', 'remont-akpp-moskva' => true,
            default => false,
        };
    }

    /**
     * Поверка является ли страница статичной
     */
    public function is_simple_page(string $page_name): bool
    {
        return match ($page_name) {
            '/services/', '/price_list/', '/promo/', '/contacts/' => true,
            default => false,
        };
    }

    /**
     * Генерация мета-тегов description для статичных страниц
     */
    public function get_description_simple_page(string $page, ?Service $service): string
    {
        $serviceName = $this->get_service_name($service);

        return match ($page) {
            '/services/' => "Услуги на " . mb_strtolower($serviceName) . ". Автосервис Моторист.",
            '/price_list/' => 'Прайс лист на ' . mb_strtolower($serviceName) . '. Автосервис Моторист',
            '/contacts/' => 'Контакты и схема проезда. Автосервис Моторист по ' . str_replace('ремонт', 'ремонту', mb_strtolower($serviceName)),
            '/promo/' => 'Акции на ' . mb_strtolower($serviceName) . '. Автосервис Моторист.'
        };
    }

    /**
     * Генерация мета-тегов title для статичных страниц
     */
    public function get_title_simple_page(string $page, ?Service $service_from_domain): string
    {
        $serviceName = $this->get_service_name($service_from_domain);

        return match ($page) {
            '/services/' => "Наши услуги  - Автосервис Моторист по " . str_replace('ремонт', 'ремонту', mb_strtolower($serviceName)),
            '/price_list/' => "Прайс лист - Автосервис Моторист по " . str_replace('ремонт', 'ремонту', mb_strtolower($serviceName)),
            '/contacts/' => "Наши контакты - Автосервис Моторист по " . str_replace('ремонт', 'ремонту', mb_strtolower($serviceName)),
            '/promo/' => "Наши акции - Автосервис Моторист по " . str_replace('ремонт', 'ремонту', mb_strtolower($serviceName)),
        };

    }

    /**
     * Генерация мета-тегов description услуг и дочерних услуг специализированных сайтов
     */
    public function get_description_special_site(Service|SubService|ChildService $service): string
    {
        $hostName = preg_replace('/\.[a-z]+/', '', $_SERVER['HTTP_HOST']);

        return match ($hostName) {
            'tehnicheskoe-obsluzhivanie', 'remont-akpp-moskva' => $service->getName() . ' ✅ Специализированный автосервис в Москве. ✅ Бесплатный эвакуатор. ✅ Гарантия 2 года. ⭐ ' . $service->getName() . ' ⏰ Записаться в техцентр «Моторист» ☎️ +7(499)288-76-91.',
            'remont-rulevyh-reek' => $service->getName() . ' ✅ Специализированный автосервис в Москве. ✅ Бесплатный эвакуатор при ремонте. ✅ Гарантия 1 год. ⭐ ' . $service->getName() . ' цена ⏰ Записаться в техцентр «Моторист» ☎️ +7(499)288-76-91.',
            'remont-avtokondicionerov' => $service->getName() . ' ✅ Специализированный автосервис в Москве. ✅ Качественное оборудование. ✅ Гарантия 1 год. ⭐ ' . $service->getName() . ' цена ⏰ Записаться в техцентр «Моторист» ☎️ +7(499)288-76-91.',
        };
    }

    /**
     * Генерация мета-тегов title услуг и дочерних услуг специализированных сайтов
     */
    public function get_title_special_site(Service|SubService|ChildService $service): string
    {
        $hostName = preg_replace('/\.[a-z]+/', '', $_SERVER['HTTP_HOST']);

        return match ($hostName) {
            'remont-rulevyh-reek', 'remont-avtokondicionerov', 'tehnicheskoe-obsluzhivanie', 'remont-akpp-moskva' => $service->getName() . ' цена в Москве - автосервис Моторист',
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
        $serviceName = $this->get_service_name($service) ?? "Ремонт";
        $name = $this->ucfirst($serviceName);

        return $name . ' ' . $brand->getName() . ' цена. ⭐ Сервис ' . $brand->getRusName() . ' АМ Плюс в Москве. ✔️ Бесплатная диагностика ходовой. ✔️ Бесплатная замена масла и фильтров  ⏩ Автосервис ' . preg_replace('/[(]|[)]/', '', $brand->getRusName()) . ' в ВАО Москвы.';
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

    /**
     * Генерация мета-тегов description для страниц моделей
     */
    public function get_description_model_page(Service|SubService|ChildService|null $service, Model $model): string
    {
        $serviceName = $this->get_service_name($service) ?? "Ремонт";

        return $this->ucfirst($serviceName) . ' ' . $model->getBrand()->getName() . ' ' . $model->getName() . ' цена в Москве. ⭐ Автосервис ' . $model->getRusName() . ' АМ Плюс. ✔️ Бесплатная диагностика подвески. ✔️ Бесплатная замена масла и фильтров  ⏩ Сервис ' . preg_replace('/[(]|[)]/', '', $model->getRusName()) . ' в ВАО Москвы.';
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

        if ($brand) {
            $str = $this->ucfirst($serviceName) . ' ' . $brand . ' в Москве';
        } elseif ($model) {
            $str = $this->ucfirst($serviceName) . ' ' . $model . ' в Москве';
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