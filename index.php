<?php

// ==========================================
date_default_timezone_set('Asia/Tehran'); // Change to your timezone
$target_date_string = "2030-4-8 03:30:00"; // Set you date

$timeheader = "This is The End"; // Your timer header
$finishalarm = "The Event has been started"; // Message to show after countdown finished
// ==========================================

$target_date = date("c", strtotime($target_date_string));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- site title -->
    <title>countdown</title>
    <style>
        :root {
            --bg-color: #050505;
            --bg-gradient: radial-gradient(circle at center, #1a1a1a 0%, #000000 100%);
            --glass-bg: rgba(212, 175, 55, 0.03);
            --glass-border: rgba(212, 175, 55, 0.15);
            --text-color: #ffffff;
            --accent-gold: #D4AF37;
            --accent-gold-glow: rgba(212, 175, 55, 0.4);
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: var(--bg-color);
            background-image: var(--bg-gradient);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .container {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 50px;
            text-align: center;
            box-shadow: 0 10px 40px 0 rgba(0, 0, 0, 0.8), inset 0 0 20px var(--glass-bg);
            max-width: 95%;
            width: 800px;
        }
        h1 {
            margin-bottom: 40px;
            font-weight: 600;
            letter-spacing: 4px;
            color: var(--accent-gold);
            text-shadow: 0 0 15px var(--accent-gold-glow);
            text-transform: uppercase;
        }
        .timer {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: nowrap;
            width: 100%;
        }
        .time-box {
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 25px 15px;
            flex: 1; 
            min-width: 0; 
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
            transition: transform 0.3s ease;
        }
        .time-box:hover {
            transform: translateY(-5px);
            border-color: rgba(212, 175, 55, 0.4);
            box-shadow: 0 8px 25px rgba(0,0,0,0.8), 0 0 15px var(--glass-bg);
        }
        .value {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Courier New", monospace;
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--accent-gold);
            line-height: 1;
            margin-bottom: 12px;
            text-shadow: 0 0 10px var(--accent-gold-glow);
        }
        .label {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #888888;
            font-weight: 400;
        }
        #message {
            margin-top: 40px;
            font-size: 1.8rem;
            color: var(--accent-gold);
            letter-spacing: 2px;
            text-shadow: 0 0 15px var(--accent-gold-glow);
            display: none;
        }
       
        @media (max-width: 650px) {
            .container { 
                padding: 30px 10px; 
            }
            .timer {
                gap: 8px;
            }
            .time-box { 
                padding: 15px 5px; 
                border-radius: 10px;
            }
            .value { 
                font-size: 1.8rem;
                margin-bottom: 8px;
            }
            .label { 
                font-size: 0.55rem; 
                letter-spacing: 0px;
            }
            h1 {
                font-size: 1.5rem;
                letter-spacing: 2px;
            }
        }
      
        @media (max-width: 360px) {
            .timer { gap: 4px; }
            .value { font-size: 1.5rem; }
            .label { font-size: 0.45rem; }
            .time-box { padding: 12px 2px; }
        }
    </style>
</head>
<body>

    <div class="container" id="timer-container" data-target-time="<?php echo $target_date; ?>">

        <h1><?php echo htmlspecialchars($timeheader); ?></h1>
        
        <div class="timer">
            <div class="time-box">
                <div class="value" id="days">00</div>
                <div class="label">Days</div>
            </div>
            <div class="time-box">
                <div class="value" id="hours">00</div>
                <div class="label">Hours</div>
            </div>
            <div class="time-box">
                <div class="value" id="minutes">00</div>
                <div class="label">Minutes</div>
            </div>
            <div class="time-box">
                <div class="value" id="seconds">00</div>
                <div class="label">Secs</div>
            </div>
        </div>

        <div id="message"><?php echo htmlspecialchars($finishalarm); ?>/div>
		
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const container = document.getElementById('timer-container');
            const targetString = container.getAttribute('data-target-time').replace(' ', 'T');
            const targetDate = new Date(targetString).getTime();
            const messageEl = document.getElementById('message');

            const countdownInterval = setInterval(() => {
                const now = new Date().getTime();
                
                const distance = targetDate - now;

                if (distance < 0) {
                    clearInterval(countdownInterval);
                    document.getElementById('days').innerText = "00";
                    document.getElementById('hours').innerText = "00";
                    document.getElementById('minutes').innerText = "00";
                    document.getElementById('seconds').innerText = "00";
                    messageEl.style.display = 'block';
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById('days').innerText = days < 10 ? "0" + days : days;
                document.getElementById('hours').innerText = hours < 10 ? "0" + hours : hours;
                document.getElementById('minutes').innerText = minutes < 10 ? "0" + minutes : minutes;
                document.getElementById('seconds').innerText = seconds < 10 ? "0" + seconds : seconds;

            }, 1000);
        });
    </script>
</body>
</html>
