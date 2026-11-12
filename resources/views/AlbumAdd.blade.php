<x-head />
<x-header />

<body>
    <div style="max-width: 600px; margin: 120px auto 50px; padding: 20px;">
        <h1 style="text-align: center; color: white; margin-bottom: 30px;">Добавление альбома</h1>

        @if(session('success'))
            <div style="text-align:center; color: #00ff88; background: rgba(0,255,136,0.1); padding: 12px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(0,255,136,0.3);">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('AlbumForm') }}" method="post" enctype="multipart/form-data" style="background: rgba(255,255,255,0.05); padding: 30px; border-radius: 15px; backdrop-filter: blur(10px);">
            @csrf

            <!-- Название альбома -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Название альбома *</label>
                <input type="text" name="name" placeholder="Например: Utopia" value="{{ old('name') }}" 
                       style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; font-size: 1em; box-sizing: border-box;">
                @error('name')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Выбор артиста -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Исполнитель *</label>
                <select name="artist_id" 
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

            <!-- Тип альбома -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Тип альбома *</label>
                <select name="type" 
                        style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; font-size: 1em; box-sizing: border-box;">
                    <option value="single" {{ old('type') == 'single' ? 'selected' : '' }}>Сингл</option>
                    <option value="ep" {{ old('type') == 'ep' ? 'selected' : '' }}>EP (мини-альбом)</option>
                    <option value="album" {{ old('type') == 'album' ? 'selected' : '' }}>Альбом</option>
                    <option value="compilation" {{ old('type') == 'compilation' ? 'selected' : '' }}>Сборник</option>
                    <option value="live" {{ old('type') == 'live' ? 'selected' : '' }}>Концертный альбом</option>
                </select>
                @error('type')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Год выпуска -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Год выпуска *</label>
                <input type="number" name="release_year" placeholder="Например: 2024" value="{{ old('release_year') }}" 
                       style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; font-size: 1em; box-sizing: border-box;" 
                       min="1900" max="{{ date('Y') }}">
                @error('release_year')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Описание -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Описание</label>
                <textarea name="description" placeholder="Описание альбома, треклист и т.д." rows="4" 
                          style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; font-size: 1em; box-sizing: border-box; resize: vertical;">{{ old('description') }}</textarea>
                @error('description')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Обложка -->
            <div style="margin-bottom: 20px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Обложка альбома</label>
                <input type="file" name="cover" accept="image/*" 
                       style="width: 100%; padding: 10px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; box-sizing: border-box;">
                @error('cover')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
                <div style="color: #888; font-size: 0.8em; margin-top: 5px;">Рекомендуемый размер: 1000x1000px, формат: JPG, PNG</div>
            </div>

            <input type="submit" value="Добавить альбом" 
                   style="width: 100%; padding: 14px; border-radius: 8px; background: red; color: white; border: none; font-size: 1.1em; font-weight: bold; cursor: pointer; transition: transform 0.2s;"
                   onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
        </form>
    </div>
</body>
</html>