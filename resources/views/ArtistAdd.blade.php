<x-head />
<x-header />

<body>
    <div style="max-width: 600px; margin: 120px auto 50px; padding: 20px;">
        <h1 style="text-align: center; color: white; margin-bottom: 30px;">Добавление артиста</h1>

        @if(session('success'))
            <div style="text-align:center; color: #00ff88; background: rgba(0,255,136,0.1); padding: 12px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(0,255,136,0.3);">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('ArtistForm') }}" method="post" enctype="multipart/form-data" style="background: rgba(255,255,255,0.05); padding: 30px; border-radius: 15px; backdrop-filter: blur(10px);">
            @csrf

            <!-- Имя артиста -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Имя артиста *</label>
                <input type="text" name="name" placeholder="Например: Ado" value="{{ old('name') }}" 
                       style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; font-size: 1em; box-sizing: border-box;">
                @error('name')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Страна -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Страна</label>
                <input type="text" name="country" placeholder="Например: Япония" value="{{ old('country') }}" 
                       style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; font-size: 1em; box-sizing: border-box;">
                @error('country')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Год дебюта -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Год дебюта</label>
                <input type="number" name="debut_year" placeholder="Например: 2020" value="{{ old('debut_year') }}" 
                       style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; font-size: 1em; box-sizing: border-box;">
                @error('debut_year')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Описание -->
            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Описание</label>
                <textarea name="description" placeholder="Краткая биография артиста..." rows="4" 
                          style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; font-size: 1em; box-sizing: border-box; resize: vertical;">{{ old('description') }}</textarea>
                @error('description')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Фото артиста -->
            <div style="margin-bottom: 20px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Фото артиста</label>
                <input type="file" name="photo" accept="image/*" 
                       style="width: 100%; padding: 10px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; box-sizing: border-box;">
                @error('photo')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
                <div style="color: #888; font-size: 0.8em; margin-top: 5px;">Рекомендуемый размер: 500x500px, формат: JPG, PNG</div>
            </div>

            <input type="submit" value="Добавить артиста" 
                   style="width: 100%; padding: 14px; border-radius: 8px; background: red; color: white; border: none; font-size: 1.1em; font-weight: bold; cursor: pointer; transition: transform 0.2s;"
                   onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
        </form>
    </div>
</body>
</html>