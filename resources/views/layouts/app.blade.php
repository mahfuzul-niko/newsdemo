@php
    $title =
        'NewsBrief: Global News Aggregation, Summarization, Translation & Personalized Feed with Engagement | 闪讯：全球新闻聚合、摘要、翻译及个性化资讯与互动 | 閃訊：全球新聞聚合、摘要、翻譯及個性化資訊與互動 | 閃訊: グローバルニュース集約、要約、翻訳とパーソナライズフィード及びエンゲージメント | 뉴스브리프: 글로벌 뉴스 집계, 요약, 번역 및 개인화된 피드와 참여 | NewsBrief: Agregación de Noticias Globales, Resúmenes, Traducción y Feed Personalizado con Compromiso | NewsBrief: Globale Nachrichtenaggregation, Zusammenfassung, Übersetzung & Personalisierter Feed mit Engagement | NewsBrief: Agregação Global de Notícias, Resumos, Tradução e Feed Personalizado com Engajamento | NewsBrief : Agrégation Mondiale de Nouvelles, Résumés, Traduction et Fil Personnalisé avec Engagement | ข่าวสั้น: การรวบรวมข่าวทั่วโลก, การสรุป, การแปล และฟีดที่ปรับแต่งตามความสนใจพร้อมการมีส่วนร่วม | Tin Tức Ngắn: Tổng hợp Tin tức Toàn cầu, Tóm tắt, Dịch thuật & Dòng tin Cá nhân hóa với Sự Tham gia | BeritaSingkat: Agregasi Berita Global, Ringkasan, Terjemahan & Umpan Personalisasi dengan Keterlibatan | НовостиКратко: Глобальная Агрегация Новостей, Сводки, Перевод и Персонализированная Лента с Вовлечением |';
    $description =
    'NewsBrief: Global News Aggregation, Summarization, Translation & Personalized Feed with Engagement | 闪讯：全球新闻聚合、摘要、翻译及个性化资讯与互动 | 閃訊：全球新聞聚合、摘要、翻譯及個性化資訊與互動 | 閃訊: グローバルニュース集約、要約、翻訳とパーソナライズフィード及びエンゲージメント | 뉴스브리프: 글로벌 뉴스 집계, 요약, 번역 및 개인화된 피드와 참여 | NewsBrief: Agregación de Noticias Globales, Resúmenes, Traducción y Feed Personalizado con Compromiso | NewsBrief: Globale Nachrichtenaggregation, Zusammenfassung, Übersetzung & Personalisierter Feed mit Engagement | NewsBrief: Agregação Global de Notícias, Resumos, Tradução e Feed Personalizado com Engajamento | NewsBrief : Agrégation Mondiale de Nouvelles, Résumés, Traduction et Fil Personnalisé avec Engagement | ข่าวสั้น: การรวบรวมข่าวทั่วโลก, การสรุป, การแปล และฟีดที่ปรับแต่งตามความสนใจพร้อมการมีส่วนร่วม | Tin Tức Ngắn: Tổng hợp Tin tức Toàn cầu, Tóm tắt, Dịch thuật & Dòng tin Cá nhân hóa với Sự Tham gia | BeritaSingkat: Agregasi Berita Global, Ringkasan, Terjemahan & Umpan Personalisasi dengan Keterlibatan | НовостиКратко: Глобальная Агрегация Новостей, Сводки, Перевод и Персонализированная Лента с Вовлечением |';
    $keywords =
        'equal coverage, global stories, diverse reporting, fair reporting, all perspectives, journalism, truth, voices, untold stories, impactful journalism';
    $og_image = asset('assets/logo.jpg');
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('meta_title', $title)</title>
    <meta name="description" content="@yield('meta_description', $description)" />
    <meta name="keywords" content="@yield('meta_keyowrds', $keywords)">
    <meta name="author" content="{{ env('APP_NAME') }}">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">


    <meta property="og:title" content="@yield('og_title', $title)" />
    <meta property="og:description" content="@yield('og_desc', $description)" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="@yield('og_url', url()->current())" />
    <meta property="og:image" content="@yield('og_image', $og_image)" />

    <meta name="twitter:title" content="@yield('og_title', $title) ">
    <meta name="twitter:description" content="@yield('og_desc', $description)">
    <meta name="twitter:image" content="@yield('og_image',$og_image)">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('favicon/android-chrome-512x512.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">
    @yield('css')
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

</head>

<body>
    <div id="preloader">
        <div class="spinner"></div>
    </div>
    @yield('content')
    @yield('js')

    <script>
        window.addEventListener("load", (event) => {
            document.getElementById('preloader').style.display = 'none';
            @if (session()->has('errors'))
                @foreach ($errors->all() as $error)
                    window.toast('error', '{{ $error }}')
                @endforeach
            @endif
            @if (session()->has('success'))
                window.toast('success', "{{ session('success') }}")
            @endif
        });
    </script>
    <script>
        function share(el) {
            const title = el.getAttribute('data-title');
            const url = el.getAttribute('data-url');
            const share = el.getAttribute('data-share');

            if (navigator.share) {
                navigator.share({
                    title: title,
                    url: url
                }).then(() => {
                    // el.querySelectorAll('.share-count')[0].innerText = parseInt(el.querySelectorAll('.share-count')[
                    //     0].innerText) + 1
                    console.log('Thanks for sharing!');
                    fetch(share);
                }).catch(err => {
                    console.error('Error sharing:', err);
                });
            } else {
                alert('Share feature is not supported in your browser.');
            }
        }

        function bookmark(el) {

            fetch(el.dataset.save)
            if (el.dataset.saved == 'true') {
                el.dataset.saved = 'false'
                el.innerHTML = '<i class="fa-regular fa-bookmark"></i>'
                window.toast('success', 'Unsaved');

            } else {
                el.dataset.saved = 'true'
                el.innerHTML = '<i class="fa-solid fa-bookmark fs-normal"></i>'
                window.toast('success', 'Saved');

            }

        }
    </script>

</body>

</html>
