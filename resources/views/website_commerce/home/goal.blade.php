<!-- Shop by Goal Section -->
<section class="container">
    <h2 class="section-title">{{ __('f.shop_by_goal') }}</h2>
    <div class="goal-container">
        @foreach($goals as $goal)
            @php
                $translation = $goal->langs->where('language_id', $languageId)->first();
                $goalName = $translation ? $translation->name : ($goal->langs->first()->name ?? 'Goal');
            @endphp
            <div class="goal-card">
                <a href="{{ url('products?goal_id='.$goal->id) }}">
                    <img src="{{ asset($goal->image) }}" alt="{{ $goalName }}">
                    <div class="goal-text">{{ $goalName }}</div>
                </a>
            </div>
        @endforeach
    </div>
</section>


    <!-- Shop by Goal style -->
    <style>
        /* Shop by Goal */
        .section-title {
            font-size: 24px;
            margin: 30px 0 20px;
            color: #2c3e50;
            position: relative;
            padding-bottom: 10px;
            text-align: center;
        }

        .goal-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .goal-card {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .goal-card:hover {
            transform: translateY(-5px);
        }

        .goal-card img {
            width: 100%;
            display: block;
        }

        .goal-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            font-size: 24px;
            font-weight: 700;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 100%;
            padding: 0 20px;
        }
    </style>
