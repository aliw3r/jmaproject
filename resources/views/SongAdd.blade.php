<x-head />
<x-header />

<body>
    <div style="max-width: 600px; margin: 120px auto 50px; padding: 20px;">
        <h1 style="text-align: center; color: white; margin-bottom: 30px;">Добавление трека</h1>

        @if(session('success'))
            <div style="text-align:center; color: #00ff88; background: rgba(0,255,136,0.1); padding: 12px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(0,255,136,0.3);">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('SongForm') }}" method="post" enctype="multipart/form-data" style="background: rgba(255,255,255,0.05); padding: 30px; border-radius: 15px; backdrop-filter: blur(10px);">
            @csrf

            <!-- Название трека -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Название трека *</label>
                <input type="text" name="name" placeholder="Например: Usseewa" value="{{ old('name') }}" 
                       style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; font-size: 1em; box-sizing: border-box;">
                @error('name')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Выбор артиста -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Исполнитель *</label>
                <select name="artist_id" id="artist_select" 
                        style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; font-size: 1em; box-sizing: border-box;">
                    <option value="">Выберите артиста</option>
                    @foreach($artists as $artist)
                        <option value="{{ $artist->id }}" {{ old('artist_id') == $artist->id ? 'selected' : '' }}>
                            {{ $artist->name }}
                        </option>
                    @endforeach
                </select>
                @error('artist_id')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Выбор альбома -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Альбом</label>
                <select name="album_id" id="album_select" 
                        style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; font-size: 1em; box-sizing: border-box;">
                    <option value="">Без альбома (сингл)</option>
                    @foreach($albums as $album)
                        <option value="{{ $album->id }}" data-artist="{{ $album->artist_id }}" {{ old('album_id') == $album->id ? 'selected' : '' }}>
                            {{ $album->name }} ({{ $album->artist->name }})
                        </option>
                    @endforeach
                </select>
                @error('album_id')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Жанр -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Жанр *</label>
                <input type="text" name="genre" placeholder="Например: J-Pop, J-Rock" value="{{ old('genre') }}" 
                       style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; font-size: 1em; box-sizing: border-box;">
                @error('genre')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Сезон -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Сезон выхода *</label>
                <select name="season" 
                        style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; font-size: 1em; box-sizing: border-box;">
                    <option value="">Выберите сезон</option>
                    <option value="Winter" {{ old('season') == 'Winter' ? 'selected' : '' }}>Зима</option>
                    <option value="Spring" {{ old('season') == 'Spring' ? 'selected' : '' }}>Весна</option>
                    <option value="Summer" {{ old('season') == 'Summer' ? 'selected' : '' }}>Лето</option>
                    <option value="Autumn" {{ old('season') == 'Autumn' ? 'selected' : '' }}>Осень</option>
                </select>
                @error('season')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Год выпуска -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Год выпуска</label>
                <input type="number" name="year" placeholder="Например: 2024" value="{{ old('year') }}" 
                       style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; font-size: 1em; box-sizing: border-box;" 
                       min="1900" max="{{ date('Y') }}">
                @error('year')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Длительность -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Длительность</label>
                <input type="text" name="duration" placeholder="Например: 3:45" value="{{ old('duration') }}" 
                       style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; font-size: 1em; box-sizing: border-box;">
                @error('duration')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Обложка -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Обложка трека *</label>
                <input type="file" name="oblozhka" accept="image/*" 
                       style="width: 100%; padding: 10px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; box-sizing: border-box;">
                @error('oblozhka')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
                <div style="color: #888; font-size: 0.8em; margin-top: 5px;">Рекомендуемый размер: 500x500px, формат: JPG, PNG</div>
            </div>

            <!-- Аудио файл -->
            <div style="margin-bottom: 20px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Аудио файл</label>
                <input type="file" name="audio_file" accept="audio/*" 
                       style="width: 100%; padding: 10px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; box-sizing: border-box;">
                @error('audio_file')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
                <div style="color: #888; font-size: 0.8em; margin-top: 5px;">Поддерживаемые форматы: MP3, WAV, FLAC. Макс. размер: 10MB</div>
            </div>

            <input type="submit" value="Добавить трек" 
                   style="width: 100%; padding: 14px; border-radius: 8px; background: red; color: white; border: none; font-size: 1.1em; font-weight: bold; cursor: pointer; transition: transform 0.2s;"
                   onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
        </form>
    </div>

    <!-- JavaScript для фильтрации альбомов по артисту -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const artistSelect = document.getElementById('artist_select');
            const albumSelect = document.getElementById('album_select');
            const allAlbums = albumSelect.querySelectorAll('option');

            function filterAlbums() {
                const selectedArtist = artistSelect.value;
                
                // Показываем/скрываем альбомы
                allAlbums.forEach(option => {
                    if (option.value === '') {
                        // Опция "Без альбома" всегда видна
                        option.style.display = 'block';
                        return;
                    }
                    
                    const albumArtist = option.getAttribute('data-artist');
                    if (selectedArtist === '' || albumArtist === selectedArtist) {
                        option.style.display = 'block';
                    } else {
                        option.style.display = 'none';
                    }
                });

                // Сбрасываем выбор, если текущий альбом скрыт
                if (albumSelect.value !== '') {
                    const selectedOption = albumSelect.options[albumSelect.selectedIndex];
                    if (selectedOption && selectedOption.style.display === 'none') {
                        albumSelect.value = '';
                    }
                }
            }

            artistSelect.addEventListener('change', filterAlbums);
            filterAlbums(); // Применяем при загрузке
        });
    </script>
</body>
</html>