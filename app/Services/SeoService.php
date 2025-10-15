<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\SiteInformation;
use Illuminate\Support\Str;

class SeoService
{
    private string $title = 'Okyanus Yapı | Kaliteli Konut İnşaatı Hizmetleri';
    private ?string $description = null;
    private ?string $canonical = null;
    private string $robots = 'index,follow';
    private array $meta = [];
    private array $openGraph = [];
    private array $twitter = [];
    private array $schemas = [];

    public function title(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function description(?string $description): self
    {
        $this->description = $description ? trim($description) : null;
        return $this;
    }

    public function canonical(?string $url): self
    {
        $this->canonical = $url ? trim($url) : null;
        return $this;
    }

    public function robots(string $value): self
    {
        $this->robots = $value;
        return $this;
    }

    public function meta(string $name, string $content): self
    {
        $this->meta[$name] = $content;
        return $this;
    }

    public function og(string $property, string $content): self
    {
        $this->openGraph[$property] = $content;
        return $this;
    }

    public function twitter(string $name, string $content): self
    {
        $this->twitter[$name] = $content;
        return $this;
    }

    public function addSchema(array $schema): self
    {
        $this->schemas[] = $schema;
        return $this;
    }

    public function getData(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'canonical' => $this->canonical,
            'robots' => $this->robots,
            'meta' => $this->meta,
            'og' => $this->openGraph,
            'twitter' => $this->twitter,
            'schemas' => $this->schemas,
        ];
    }

    /**
     * TEK GLOBAL SEO METODU - Tüm sayfalar için
     */
    public function generateSeo($model = null, string $type = 'home'): array
    {
        $seo = new self();

        switch ($type) {
            case 'blog':
                return $this->generateBlogSeo($model, $seo);
            case 'blog-category':
                return $this->generateBlogCategorySeo($model, $seo);
            case 'blog-tag':
                return $this->generateBlogTagSeo($model, $seo);
            case 'blogs':
                return $this->generateBlogsListSeo($seo);
            case 'about':
                return $this->generateAboutSeo($seo);
            case 'contact':
                return $this->generateContactSeo($seo);
            case 'services':
                return $this->generateServicesSeo($seo);
            case 'service':
                return $this->generateServiceSeo($model, $seo);
            case 'privacy-policy':
                return $this->generatePrivacyPolicySeo($seo);
            case 'cookie-policy':
                return $this->generateCookiePolicySeo($seo);
            case 'terms-conditions':
                return $this->generateTermsConditionsSeo($seo);
            case 'home':
            default:
                return $this->generateHomeSeo($seo);
        }
    }

    /**
     * Blog detay sayfası için SEO
     */
    private function generateBlogSeo(Blog $blog, SeoService $seo): array
    {
        // Meta title - önce model'den, yoksa otomatik oluştur
        $title = $blog->meta_title ?: $blog->title . ' | Okyanus Yapı';

        // Meta description - önce model'den, yoksa excerpt'dan, yoksa content'den
        $description = $blog->meta_description ?: ($blog->excerpt ?: Str::limit(strip_tags($blog->content ?? ''), 160));

        $canonical = route('blogs.show', $blog->slug);
        $image = $blog->featured_image ? asset($blog->featured_image) : null;

        // Breadcrumb oluştur
        $breadcrumbs = [
            ['name' => 'Ana Sayfa', 'url' => route('home')],
            ['name' => 'Uygulamalar', 'url' => route('blogs')]
        ];

        // Add category to breadcrumb if exists
        if ($blog->category) {
            $breadcrumbs[] = ['name' => $blog->category->name, 'url' => route('blogs.category', $blog->category->slug)];
        }

        $breadcrumbs[] = ['name' => $blog->title, 'url' => $canonical];

        return $seo
            ->title($title)
            ->description($description)
            ->canonical($canonical)
            ->og('type', 'article')
            ->og('title', $title)
            ->og('description', $description)
            ->og('image', $image)
            ->og('url', $canonical)
            ->og('article:published_time', $blog->published_at?->toISOString())
            ->og('article:author', $blog->author?->name)
            ->og('article:section', $blog->category?->name)
            ->twitter('card', 'summary_large_image')
            ->twitter('title', $title)
            ->twitter('description', $description)
            ->twitter('image', $image)
            ->addSchema($this->generateBlogArticleSchema($blog))
            ->addSchema($this->generateBreadcrumbSchema($breadcrumbs))
            ->addSchema($this->generateOrganizationSchema())
            ->getData();
    }

    /**
     * Blog kategori sayfası için SEO
     */
    private function generateBlogCategorySeo(BlogCategory $category, SeoService $seo): array
    {
        // Meta title - önce model'den, yoksa otomatik oluştur
        $title = $category->meta_title ?: $category->name . ' Kategorisi | Okyanus Yapı';

        // Meta description - önce model'den, yoksa otomatik oluştur
        $description = $category->meta_description ?:
            'Okyanus Yapı ' . $category->name . ' kategorisindeki uygulamalar ve haberler. ' .
            ($category->description ?: 'İnşaat sektöründen güncel gelişmeler.');

        $canonical = route('blogs.category', $category->slug);

        // Breadcrumb oluştur
        $breadcrumbs = [
            ['name' => 'Ana Sayfa', 'url' => route('home')],
            ['name' => 'Uygulamalar', 'url' => route('blogs')],
            ['name' => $category->name, 'url' => $canonical]
        ];

        return $seo
            ->title($title)
            ->description($description)
            ->canonical($canonical)
            ->og('type', 'website')
            ->og('title', $title)
            ->og('description', $description)
            ->og('url', $canonical)
            ->twitter('card', 'summary')
            ->twitter('title', $title)
            ->twitter('description', $description)
            ->addSchema($this->generateBreadcrumbSchema($breadcrumbs))
            ->addSchema($this->generateOrganizationSchema())
            ->getData();
    }

    /**
     * Blog tag sayfası için SEO
     */
    private function generateBlogTagSeo(BlogTag $tag, SeoService $seo): array
    {
        // Meta title - önce model'den, yoksa otomatik oluştur
        $title = $tag->meta_title ?: $tag->name . ' Etiketi | Okyanus Yapı';

        // Meta description - önce model'den, yoksa otomatik oluştur
        $description = $tag->meta_description ?:
            'Okyanus Yapı ' . $tag->name . ' etiketiyle ilgili uygulamalar ve haberler. ' .
            ($tag->description ?: 'İnşaat sektöründen güncel gelişmeler.');

        $canonical = route('blogs.tag', $tag->slug);

        // Breadcrumb oluştur
        $breadcrumbs = [
            ['name' => 'Ana Sayfa', 'url' => route('home')],
            ['name' => 'Uygulamalar', 'url' => route('blogs')],
            ['name' => $tag->name, 'url' => $canonical]
        ];

        return $seo
            ->title($title)
            ->description($description)
            ->canonical($canonical)
            ->og('type', 'website')
            ->og('title', $title)
            ->og('description', $description)
            ->og('url', $canonical)
            ->twitter('card', 'summary')
            ->twitter('title', $title)
            ->twitter('description', $description)
            ->addSchema($this->generateBreadcrumbSchema($breadcrumbs))
            ->addSchema($this->generateOrganizationSchema())
            ->getData();
    }

    /**
     * Blog listesi sayfası için SEO
     */
    private function generateBlogsListSeo(SeoService $seo): array
    {
        $title = 'Uygulamalar | Okyanus Yapı';
        $description = 'Okyanus Yapı uygulamaları ve haberleri. İnşaat sektöründen güncel gelişmeler, uzman ipuçları, proje örnekleri ve sektör analizleri.';
        $canonical = route('blogs');

        // Breadcrumb oluştur
        $breadcrumbs = [
            ['name' => 'Ana Sayfa', 'url' => route('home')],
            ['name' => 'Uygulamalar', 'url' => $canonical]
        ];

        return $seo
            ->title($title)
            ->description($description)
            ->canonical($canonical)
            ->og('type', 'website')
            ->og('title', $title)
            ->og('description', $description)
            ->og('url', $canonical)
            ->twitter('card', 'summary')
            ->twitter('title', $title)
            ->twitter('description', $description)
            ->addSchema($this->generateBreadcrumbSchema($breadcrumbs))
            ->addSchema($this->generateOrganizationSchema())
            ->getData();
    }

    /**
     * Ana sayfa için SEO
     */
    private function generateHomeSeo(SeoService $seo): array
    {
        $siteInfo = SiteInformation::first();

        // Ana sayfa için özel slogan ile başlık oluştur
        $title = 'Okyanus Yapı | Isı ve Su Yalıtım Sistemleri';
        $description = 'Okyanus Yapı ile hayalinizdeki evi gerçekleştirin! Profesyonel konut inşaatı, ısı-su yalıtımı, çelik işleri ve daha fazlası. Kaliteli malzeme, uzman ekip, güvenilir hizmet.';
        $canonical = route('home');

        return $seo
            ->title($title)
            ->description($description)
            ->canonical($canonical)
            ->og('type', 'website')
            ->og('title', $title)
            ->og('description', $description)
            ->og('url', $canonical)
            ->twitter('card', 'summary_large_image')
            ->twitter('title', $title)
            ->twitter('description', $description)
            ->addSchema($this->generateOrganizationSchema())
            ->addSchema($this->generateWebSiteSchema())
            ->getData();
    }

    /**
     * Hakkımızda sayfası için SEO
     */
    private function generateAboutSeo(SeoService $seo): array
    {
        $title = 'Hakkımızda | Okyanus Yapı';
        $description = 'Okyanus Yapı hakkında bilgi edinin. 15+ yıllık deneyimimizle kaliteli konut inşaatı hizmetleri sunuyoruz. Müşteri memnuniyeti odaklı çalışma anlayışımız.';
        $canonical = route('about');

        // Breadcrumb oluştur
        $breadcrumbs = [
            ['name' => 'Ana Sayfa', 'url' => route('home')],
            ['name' => 'Hakkımızda', 'url' => $canonical]
        ];

        return $seo
            ->title($title)
            ->description($description)
            ->canonical($canonical)
            ->og('type', 'website')
            ->og('title', $title)
            ->og('description', $description)
            ->og('url', $canonical)
            ->twitter('card', 'summary')
            ->twitter('title', $title)
            ->twitter('description', $description)
            ->addSchema($this->generateBreadcrumbSchema($breadcrumbs))
            ->addSchema($this->generateOrganizationSchema())
            ->getData();
    }

    /**
     * İletişim sayfası için SEO
     */
    private function generateContactSeo(SeoService $seo): array
    {
        $title = 'İletişim | Okyanus Yapı';
        $description = 'Okyanus Yapı ile iletişime geçin! Konut inşaatı projeleriniz için ücretsiz keşif ve teklif alın. Uzman ekibimiz size en uygun çözümleri sunar.';
        $canonical = route('contact');

        // Breadcrumb oluştur
        $breadcrumbs = [
            ['name' => 'Ana Sayfa', 'url' => route('home')],
            ['name' => 'İletişim', 'url' => $canonical]
        ];

        return $seo
            ->title($title)
            ->description($description)
            ->canonical($canonical)
            ->og('type', 'website')
            ->og('title', $title)
            ->og('description', $description)
            ->og('url', $canonical)
            ->twitter('card', 'summary')
            ->twitter('title', $title)
            ->twitter('description', $description)
            ->addSchema($this->generateBreadcrumbSchema($breadcrumbs))
            ->addSchema($this->generateOrganizationSchema())
            ->addSchema($this->generateContactPageSchema())
            ->getData();
    }

    /**
     * Hizmetler listesi sayfası için SEO
     */
    private function generateServicesSeo(SeoService $seo): array
    {
        $title = 'Hizmetlerimiz | Okyanus Yapı';
        $description = 'Okyanus Yapı hizmetleri: Konut inşaatı, ısı-su yalıtımı, çelik işleri, tadilat ve renovasyon. Profesyonel ekip, kaliteli malzeme, güvenilir hizmet garantisi.';
        $canonical = route('services');

        // Breadcrumb oluştur
        $breadcrumbs = [
            ['name' => 'Ana Sayfa', 'url' => route('home')],
            ['name' => 'Hizmetlerimiz', 'url' => $canonical]
        ];

        return $seo
            ->title($title)
            ->description($description)
            ->canonical($canonical)
            ->og('type', 'website')
            ->og('title', $title)
            ->og('description', $description)
            ->og('url', $canonical)
            ->twitter('card', 'summary')
            ->twitter('title', $title)
            ->twitter('description', $description)
            ->addSchema($this->generateBreadcrumbSchema($breadcrumbs))
            ->addSchema($this->generateOrganizationSchema())
            ->getData();
    }

    /**
     * Hizmet detay sayfası için SEO
     */
    private function generateServiceSeo($service, SeoService $seo): array
    {
        $title = $service->meta_title ?: $service->name . ' | Okyanus Yapı';
        $description = $service->meta_description ?:
            Str::limit(strip_tags($service->description ?? ''), 160);
        $canonical = route('services.show', $service->slug);

        // Breadcrumb oluştur
        $breadcrumbs = [
            ['name' => 'Ana Sayfa', 'url' => route('home')],
            ['name' => 'Hizmetlerimiz', 'url' => route('services')],
            ['name' => $service->name, 'url' => $canonical]
        ];

        return $seo
            ->title($title)
            ->description($description)
            ->canonical($canonical)
            ->og('type', 'website')
            ->og('title', $title)
            ->og('description', $description)
            ->og('url', $canonical)
            ->twitter('card', 'summary')
            ->twitter('title', $title)
            ->twitter('description', $description)
            ->addSchema($this->generateBreadcrumbSchema($breadcrumbs))
            ->addSchema($this->generateOrganizationSchema())
            ->getData();
    }

    /**
     * Gizlilik politikası sayfası için SEO
     */
    private function generatePrivacyPolicySeo(SeoService $seo): array
    {
        $title = 'Gizlilik Politikası | Okyanus Yapı';
        $description = 'Okyanus Yapı gizlilik politikası. Kişisel verilerinizin korunması ve işlenmesi hakkında detaylı bilgiler.';
        $canonical = route('privacy-policy');

        return $seo
            ->title($title)
            ->description($description)
            ->canonical($canonical)
            ->robots('noindex,follow')
            ->og('type', 'website')
            ->og('title', $title)
            ->og('description', $description)
            ->og('url', $canonical)
            ->twitter('card', 'summary')
            ->twitter('title', $title)
            ->twitter('description', $description)
            ->getData();
    }

    /**
     * Çerez politikası sayfası için SEO
     */
    private function generateCookiePolicySeo(SeoService $seo): array
    {
        $title = 'Çerez Politikası | Okyanus Yapı';
        $description = 'Okyanus Yapı çerez politikası. Web sitemizde kullanılan çerezler ve bunların amaçları hakkında bilgiler.';
        $canonical = route('cookie-policy');

        return $seo
            ->title($title)
            ->description($description)
            ->canonical($canonical)
            ->robots('noindex,follow')
            ->og('type', 'website')
            ->og('title', $title)
            ->og('description', $description)
            ->og('url', $canonical)
            ->twitter('card', 'summary')
            ->twitter('title', $title)
            ->twitter('description', $description)
            ->getData();
    }

    /**
     * Kullanım şartları sayfası için SEO
     */
    private function generateTermsConditionsSeo(SeoService $seo): array
    {
        $title = 'Kullanım Şartları | Okyanus Yapı';
        $description = 'Okyanus Yapı kullanım şartları. Web sitemizi kullanırken uymanız gereken kurallar ve şartlar.';
        $canonical = route('terms-conditions');

        return $seo
            ->title($title)
            ->description($description)
            ->canonical($canonical)
            ->robots('noindex,follow')
            ->og('type', 'website')
            ->og('title', $title)
            ->og('description', $description)
            ->og('url', $canonical)
            ->twitter('card', 'summary')
            ->twitter('title', $title)
            ->twitter('description', $description)
            ->getData();
    }

    /**
     * Blog makalesi için JSON-LD Schema
     */
    private function generateBlogArticleSchema(Blog $blog): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $blog->title,
            'description' => $blog->excerpt ?: Str::limit(strip_tags($blog->content ?? ''), 160),
            'url' => route('blogs.show', $blog->slug),
            'datePublished' => $blog->published_at?->toISOString(),
            'dateModified' => $blog->updated_at?->toISOString(),
            'author' => [
                '@type' => 'Person',
                'name' => $blog->author?->name ?? 'Okyanus Yapı'
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Okyanus Yapı',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('favicon.png')
                ]
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => route('blogs.show', $blog->slug)
            ]
        ];

        if ($blog->featured_image) {
            $schema['image'] = [
                '@type' => 'ImageObject',
                'url' => asset($blog->featured_image),
                'width' => 1200,
                'height' => 630
            ];
        }

        if ($blog->category) {
            $schema['articleSection'] = $blog->category->name;
        }

        if ($blog->tags) {
            $schema['keywords'] = implode(', ', $blog->tags);
        }

        return $schema;
    }

    /**
     * Breadcrumb için JSON-LD Schema
     */
    private function generateBreadcrumbSchema(array $breadcrumbs): array
    {
        $items = [];
        foreach ($breadcrumbs as $index => $breadcrumb) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $breadcrumb['name'],
                'item' => $breadcrumb['url']
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items
        ];
    }

    /**
     * Organization için JSON-LD Schema
     */
    private function generateOrganizationSchema(): array
    {
        $siteInfo = SiteInformation::first();

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Okyanus Yapı',
            'url' => route('home'),
            'logo' => asset('favicon.png'),
            'description' => $siteInfo?->description ?: 'Kaliteli konut inşaatı hizmetleri',
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => $siteInfo?->phone ?? '+90-XXX-XXX-XXXX',
                'contactType' => 'customer service',
                'areaServed' => 'TR',
                'availableLanguage' => 'Turkish'
            ],
            'sameAs' => [
                // Sosyal medya hesapları buraya eklenebilir
            ]
        ];
    }

    /**
     * Website için JSON-LD Schema
     */
    private function generateWebSiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'Okyanus Yapı',
            'url' => route('home'),
            'description' => 'Kaliteli konut inşaatı hizmetleri',
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => route('blogs') . '?search={search_term_string}'
                ],
                'query-input' => 'required name=search_term_string'
            ]
        ];
    }

    /**
     * Contact Page için JSON-LD Schema
     */
    private function generateContactPageSchema(): array
    {
        $siteInfo = SiteInformation::first();

        return [
            '@context' => 'https://schema.org',
            '@type' => 'ContactPage',
            'name' => 'İletişim',
            'description' => 'Okyanus Yapı ile iletişime geçin',
            'url' => route('contact'),
            'mainEntity' => [
                '@type' => 'Organization',
                'name' => 'Okyanus Yapı',
                'telephone' => $siteInfo?->phone ?? '+90-XXX-XXX-XXXX',
                'email' => $siteInfo?->email ?? 'info@okyanusyapi.com',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $siteInfo?->address ?? 'Adres bilgisi',
                    'addressCountry' => 'TR'
                ]
            ]
        ];
    }
}
