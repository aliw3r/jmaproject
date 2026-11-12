<x-head />
<x-header />

@guest
<p style="grid-column: 1/-1; text-align: center; color: red;">Сайт находится в активной разработке.</p>
<p style="grid-column: 1/-1; text-align: center; color: red;">Заявки на регистрацию пока подавать не имеет смысла.</p>
<p style="grid-column: 1/-1; text-align: center; color: red;">Разработка мобильной версии сайта пока отложена.</p>
<div class="glav-nadpis text-center">
    <h2>Скоро вы сможете:</h2>
</div>
<p style="grid-column: 1/-1; text-align: center;">Выставлять свои оценки добавленным трекам и альбомам по нашей формуле,</p>
<p style="grid-column: 1/-1; text-align: center;">а также писать к ним рецензии или просто обсуждать релизы и самих артистов в комментариях.</p>
<p style="grid-column: 1/-1; text-align: center;">Добавлять контент к себе в профиль через "избранное".</p>
<p style="grid-column: 1/-1; text-align: center;">Следить за итогами премии JMA в более удобном формате.</p>
<p style="grid-column: 1/-1; text-align: center;">Находить треки, альбомы и артистов через поиск на сайте.</p>
@endguest
@auth
<div class="glav-nadpis text-center">
    <h2>Недавние релизы</h2>
</div>
<div class="forkatalog" style="margin-top: 20px;">

    @foreach ($songs as $song)
    <div class="track-card">
        <div class="track-cover">
            <img src="{{ asset($song->oblozhka) }}" alt="{{ $song->name }}">

            <div class="track-overlay">
                <div class="track-title">{{ $song->name }}</div>
                <div class="track-artist">{{ $song->artist->name }}</div>
                <div class="track-meta">
                    <span>⭐ 99</span>
                    <span>📅 {{ $song->year }}</span>
                </div>
            </div>
        </div>
    </div>
    @endforeach


</div>@endauth

<x-scripts />
</body>

</html>