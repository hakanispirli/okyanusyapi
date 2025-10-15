@php
    $title = $data['title'] ?? null;
    $description = $data['description'] ?? null;
    $canonical = $data['canonical'] ?? null;
    $robots = $data['robots'] ?? 'index,follow';
    $meta = $data['meta'] ?? [];
    $og = $data['og'] ?? [];
    $twitter = $data['twitter'] ?? [];
    $schemas = $data['schemas'] ?? [];
    $siteName = config('app.name', 'OkyanusYapı');
    $currentUrl = $canonical ?: request()->fullUrl();
@endphp

@if($title)
    <title>{{ $title }}</title>
@endif

@if($description)
    <meta name="description" content="{{ Str::limit($description, 160, '') }}">
@endif

<meta name="robots" content="{{ $robots }}">

@if($canonical)
    <link rel="canonical" href="{{ $canonical }}" />
@endif

{{-- Open Graph --}}
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:type" content="{{ $og['type'] ?? 'website' }}">
<meta property="og:title" content="{{ $og['title'] ?? $title }}">
@if($description)
<meta property="og:description" content="{{ Str::limit($description, 200, '') }}">
@endif
<meta property="og:url" content="{{ $currentUrl }}">
@if(isset($og['image']))
<meta property="og:image" content="{{ $og['image'] }}">
@endif

{{-- Twitter --}}
<meta name="twitter:card" content="{{ $twitter['card'] ?? 'summary_large_image' }}">
@if(isset($twitter['site']))
<meta name="twitter:site" content="{{ $twitter['site'] }}">
@endif
<meta name="twitter:title" content="{{ $twitter['title'] ?? $title }}">
@if($description)
<meta name="twitter:description" content="{{ Str::limit($description, 200, '') }}">
@endif
@if(isset($twitter['image']))
<meta name="twitter:image" content="{{ $twitter['image'] }}">
@endif

{{-- Extra meta --}}
@foreach($meta as $name => $content)
    <meta name="{{ $name }}" content="{{ $content }}">
@endforeach

{{-- Schemas --}}
@foreach($schemas as $schema)
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
@endforeach
