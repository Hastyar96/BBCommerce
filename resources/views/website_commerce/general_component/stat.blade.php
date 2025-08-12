    <section class="stats-section">
        <div class="container">
            <div class="stats-header">
                <h2>{{ __('f.stat_text') }}</h2>
            </div>
            <div class="stats-container">
                <div class="stat-item">
                    <div class="stat-number">150K+</div>
                    <div class="stat-label">{{ __('f.visitors') }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">150K+</div>
                    <div class="stat-label">{{ __('f.orders') }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">150K+</div>
                    <div class="stat-label">{{ __('f.rating') }}</div>
                </div>
            </div>
        </div>
    </section>

        <!-- stats-section style -->
    <style>
        /* Responsive for Stats Section */

        @media (max-width: 768px) {
            .stats-header h2 {
                font-size: 22px;
                padding: 0 15px;
            }

            .stats-container {
                justify-content: center;
                gap: 20px;
            }

            .stat-item {
                min-width: 140px;
                flex: 0 1 45%;
                /* 2 per row on tablets */
                margin: 10px 5px;
            }

            .stat-number {
                font-size: 36px;
            }

            .stat-label {
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            .stats-header h2 {
                font-size: 18px;
            }

            .stat-item {
                flex: 0 1 100%;
                /* full width on small phones */
                margin: 8px 0;
            }

            .stat-number {
                font-size: 28px;
            }

            .stat-label {
                font-size: 14px;
            }
        }


        /* Stats Section Styles */
        .stats-section {
            background-color: #2c3e50;
            color: white;
            padding: 60px 0;
            text-align: center;
            margin-bottom: 10px;
        }

        .stats-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #fff;
        }

        .stats-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .stat-item {
            padding: 20px;
            margin: 10px;
            flex: 1;
            min-width: 200px;
        }

        .stat-number {
            font-size: 42px;
            font-weight: 700;
            color: #e74c3c;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 18px;
            color: #ecf0f1;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
