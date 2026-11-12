<!-- Отображение наград трека -->
@if($song->awards->count() > 0)
    <div style="background: rgba(255,215,0,0.1); padding: 15px; border-radius: 10px; margin-top: 20px;">
        <h3 style="color: gold;">🏆 Награды и достижения</h3>
        @foreach($song->awards as $awardable)
            <div style="display: flex; align-items: center; gap: 10px; margin-top: 5px;">
                @if($awardable->award->icon)
                    <img src="{{ $awardable->award->icon }}" width="24" height="24" alt="icon">
                @endif
                <span style="color: white;">{{ $awardable->award->name }}</span>
                @if($awardable->year)
                    <span style="color: #aaa;">({{ $awardable->year }}{{ $awardable->season ? ', ' . $awardable->season : '' }})</span>
                @endif
            </div>
        @endforeach
    </div>
@endif