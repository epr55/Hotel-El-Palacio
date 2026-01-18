@extends('layouts.master')

@section('title', 'Escribe tu opinión')

@section('content')
    <div style="
        padding: 40px 20px;
        background: linear-gradient(135deg, #f5f5f5 0%, #ffffff 100%);
        min-height: 80vh;
    ">
        <div style="
            max-width: 700px;
            margin: 0 auto;
        ">
            <div style="margin-bottom: 30px;">
                <a href="{{ route('opiniones.todas') }}" style="
                    color: #D39D55;
                    text-decoration: none;
                    font-size: 1rem;
                    display: inline-flex;
                    align-items: center;
                    gap: 5px;
                ">
                    ← Volver a opiniones
                </a>
            </div>

            <div style="
                background: white;
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            ">
                <h1 style="
                    color: #D39D55;
                    font-family: 'Mozilla Headline', sans-serif;
                    font-size: 2rem;
                    margin-bottom: 10px;
                ">
                    ✍️ Escribe tu opinión
                </h1>
                
                <p style="
                    color: #666;
                    margin-bottom: 30px;
                    font-size: 1rem;
                ">
                    Cuéntanos tu experiencia en Hotel El Palacio
                </p>

                @if($errors->any())
                    <div style="
                        background: #ffebee;
                        border-left: 4px solid #f44336;
                        padding: 15px;
                        margin-bottom: 20px;
                        border-radius: 4px;
                    ">
                        <ul style="margin: 0; padding-left: 20px; color: #c62828;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('opiniones.guardar') }}" method="POST">
                    @csrf
                    
                    @if(isset($reserva_id) && $reserva_id)
                        <input type="hidden" name="reserva_id" value="{{ $reserva_id }}">
                    @endif

                    <!-- Valoración con estrellas -->
                    <div style="margin-bottom: 30px;">
                        <label style="
                            display: block;
                            margin-bottom: 12px;
                            font-weight: 600;
                            color: #333;
                            font-size: 1.1rem;
                        ">
                            Valoración *
                        </label>
                        
                        <div class="rating-stars" style="
                            display: flex;
                            gap: 10px;
                            font-size: 2.5rem;
                        ">
                            <input type="radio" name="valoracion" value="1" id="star1" required style="display: none;">
                            <input type="radio" name="valoracion" value="2" id="star2" style="display: none;">
                            <input type="radio" name="valoracion" value="3" id="star3" style="display: none;">
                            <input type="radio" name="valoracion" value="4" id="star4" style="display: none;">
                            <input type="radio" name="valoracion" value="5" id="star5" style="display: none;">
                            
                            <label for="star1" class="star" data-value="1" style="cursor: pointer; color: #ddd; transition: color 0.2s;">★</label>
                            <label for="star2" class="star" data-value="2" style="cursor: pointer; color: #ddd; transition: color 0.2s;">★</label>
                            <label for="star3" class="star" data-value="3" style="cursor: pointer; color: #ddd; transition: color 0.2s;">★</label>
                            <label for="star4" class="star" data-value="4" style="cursor: pointer; color: #ddd; transition: color 0.2s;">★</label>
                            <label for="star5" class="star" data-value="5" style="cursor: pointer; color: #ddd; transition: color 0.2s;">★</label>
                        </div>
                        
                        <div id="rating-text" style="
                            margin-top: 10px;
                            color: #666;
                            font-size: 0.95rem;
                        ">
                            Selecciona una valoración
                        </div>
                    </div>

                    <!-- Comentario -->
                    <div style="margin-bottom: 30px;">
                        <label style="
                            display: block;
                            margin-bottom: 12px;
                            font-weight: 600;
                            color: #333;
                            font-size: 1.1rem;
                        ">
                            Tu opinión *
                        </label>
                        
                        <textarea 
                            name="descripcion" 
                            rows="6" 
                            placeholder="Comparte tu experiencia con otros huéspedes..."
                            required
                            maxlength="500"
                            style="
                                width: 100%;
                                padding: 15px;
                                border: 1px solid #ccc;
                                border-radius: 10px;
                                font-size: 1rem;
                                font-family: inherit;
                                resize: vertical;
                                box-sizing: border-box;
                            "
                        >{{ old('descripcion') }}</textarea>
                        
                        <div style="
                            text-align: right;
                            color: #999;
                            font-size: 0.85rem;
                            margin-top: 5px;
                        ">
                            Mínimo 10 caracteres, máximo 500
                        </div>
                    </div>

                    <!-- Botones -->
                    <div style="
                        display: flex;
                        gap: 15px;
                        justify-content: flex-end;
                    ">
                        <a href="{{ route('opiniones.todas') }}" style="
                            padding: 12px 30px;
                            background: #f5f5f5;
                            color: #333;
                            text-decoration: none;
                            border-radius: 10px;
                            font-weight: 600;
                            transition: background 0.3s;
                        ">
                            Cancelar
                        </a>
                        
                        <button type="submit" style="
                            padding: 12px 30px;
                            background: #E64A19;
                            color: white;
                            border: none;
                            border-radius: 10px;
                            font-weight: 600;
                            font-size: 1rem;
                            cursor: pointer;
                            transition: background 0.3s, transform 0.2s;
                        ">
                            Publicar opinión
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .star:hover,
        .star.active {
            color: #FFB900;
        }
        
        button[type="submit"]:hover {
            background: #D84315;
            transform: scale(1.02);
        }
        
        textarea:focus {
            outline: none;
            border-color: #D39D55;
        }
    </style>

    <script>
        // Sistema de calificación por estrellas
        const stars = document.querySelectorAll('.star');
        const ratingText = document.getElementById('rating-text');
        const ratingTexts = {
            1: '⭐ Muy malo',
            2: '⭐⭐ Malo',
            3: '⭐⭐⭐ Regular',
            4: '⭐⭐⭐⭐ Bueno',
            5: '⭐⭐⭐⭐⭐ Excelente'
        };
        
        let selectedRating = 0;
        
        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                selectedRating = index + 1;
                updateStars(selectedRating);
                ratingText.textContent = ratingTexts[selectedRating];
                document.getElementById('star' + selectedRating).checked = true;
            });
            
            star.addEventListener('mouseenter', () => {
                updateStars(index + 1);
            });
        });
        
        document.querySelector('.rating-stars').addEventListener('mouseleave', () => {
            updateStars(selectedRating);
        });
        
        function updateStars(rating) {
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }
    </script>
@endsection
