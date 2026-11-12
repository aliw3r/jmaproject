<x-head />
<x-header />

<body>
    <div style="max-width: 600px; margin: 120px auto 50px; padding: 20px;">
        <h1 style="text-align: center; color: white; margin-bottom: 30px;">Присвоение награды</h1>

        @if(session('success'))
            <div style="text-align:center; color: #00ff88; background: rgba(0,255,136,0.1); padding: 12px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(0,255,136,0.3);">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="text-align:center; color: #ff4444; background: rgba(255,68,68,0.1); padding: 12px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(255,68,68,0.3);">
                {{ session('error') }}
            </div>
        @endif

        <!-- Информация о текущем объекте -->
        <div style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 10px; margin-bottom: 25px;">
            <h3 style="color: #ddd; margin-bottom: 10px;">Объект для награждения:</h3>
            <div style="display: flex; align-items: center; gap: 15px;">
                @if($type == 'song')
                    <div style="color: #f5576c; font-size: 2em;">🎵</div>
                    <div>
                        <div style="color: white; font-size: 1.2em; font-weight: bold;">{{ $entity->name }}</div>
                        <div style="color: #aaa;">{{ $entity->artist->name }}</div>
                    </div>
                @elseif($type == 'artist')
                    <div style="color: #4facfe; font-size: 2em;">👤</div>
                    <div>
                        <div style="color: white; font-size: 1.2em; font-weight: bold;">{{ $entity->name }}</div>
                        <div style="color: #aaa;">{{ $entity->country ?? 'Страна не указана' }}</div>
                    </div>
                @elseif($type == 'album')
                    <div style="color: #00f2fe; font-size: 2em;">💿</div>
                    <div>
                        <div style="color: white; font-size: 1.2em; font-weight: bold;">{{ $entity->name }}</div>
                        <div style="color: #aaa;">{{ $entity->artist->name }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Список уже имеющихся наград -->
        @if($entity->awards->count() > 0)
            <div style="background: rgba(255,215,0,0.05); padding: 15px; border-radius: 10px; margin-bottom: 25px; border: 1px solid rgba(255,215,0,0.2);">
                <h4 style="color: gold; margin-bottom: 10px;">🏆 Текущие награды:</h4>
                @foreach($entity->awards as $awardable)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 12px; background: rgba(255,255,255,0.05); border-radius: 6px; margin-bottom: 5px;">
                        <div style="display: flex; align-items: center; gap: 10px; color: white;">
                            @if($awardable->award->icon)
                                <span>{{ $awardable->award->icon }}</span>
                            @endif
                            <span>{{ $awardable->award->name }}</span>
                            @if($awardable->year)
                                <span style="color: #888; font-size: 0.85em;">({{ $awardable->year }})</span>
                            @endif
                        </div>
                        <form action="{{ route('AwardRemove', $awardable->id) }}" method="POST" onsubmit="return confirm('Удалить эту награду?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: rgba(255,0,0,0.2); color: #ff4444; border: 1px solid rgba(255,0,0,0.3); border-radius: 5px; padding: 4px 10px; cursor: pointer; font-size: 0.85em;">
                                ✕
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Форма назначения новой награды -->
        <form action="{{ route('AwardStore') }}" method="post" style="background: rgba(255,255,255,0.05); padding: 30px; border-radius: 15px; backdrop-filter: blur(10px);">
            @csrf

            <!-- Скрытые поля -->
            <input type="hidden" name="awardable_id" value="{{ $entity->id }}">
            <input type="hidden" name="awardable_type" value="App\Models\{{ ucfirst($type) }}">

            <!-- Выбор награды -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Выберите награду *</label>
                <select name="award_id" 
                        style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; font-size: 1em; box-sizing: border-box;">
                    <option value="">Выберите награду</option>
                    @foreach($awards->where('category', $type) as $award)
                        <option value="{{ $award->id }}" {{ old('award_id') == $award->id ? 'selected' : '' }}>
                            {{ $award->icon ?? '🏆' }} {{ $award->name }}
                        </option>
                    @endforeach
                </select>
                @error('award_id')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Год награждения -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Год награждения</label>
                <input type="number" name="year" placeholder="Например: 2024" value="{{ old('year', date('Y')) }}" 
                       style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; font-size: 1em; box-sizing: border-box;" 
                       min="2000" max="{{ date('Y') }}">
                @error('year')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Сезон -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Сезон</label>
                <select name="season" 
                        style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; font-size: 1em; box-sizing: border-box;">
                    <option value="">Не указано</option>
                    <option value="Winter" {{ old('season') == 'Winter' ? 'selected' : '' }}>Зима</option>
                    <option value="Spring" {{ old('season') == 'Spring' ? 'selected' : '' }}>Весна</option>
                    <option value="Summer" {{ old('season') == 'Summer' ? 'selected' : '' }}>Лето</option>
                    <option value="Autumn" {{ old('season') == 'Autumn' ? 'selected' : '' }}>Осень</option>
                </select>
                @error('season')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <input type="submit" value="Присвоить награду" 
                   style="width: 100%; padding: 14px; border-radius: 8px; background: linear-gradient(135deg, #f7971e, #ffd200); color: #1a1a1a; border: none; font-size: 1.1em; font-weight: bold; cursor: pointer; transition: transform 0.2s;"
                   onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
        </form>
    </div>
</body>
</html>