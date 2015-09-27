{{-- Assumes there is an $item present --}}
<meta property="og:title" content="{{ $item->present->metaOgTitle }}" />
<meta property="og:url" content="{{ $item->present->metaOgUrl }}" />
<meta property="og:image" content="{{ $item->present->metaOgImage }}" />
<meta property="og:description" content="{{ $item->present->metaOgDescription }}" />
<meta property="og:type" content="{{ $item->present->metaOgType }}" />
<meta property="og:updated_time" content="{{ $item->present->metaOgUpdated }}" />