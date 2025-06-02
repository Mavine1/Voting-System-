<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text Book Centre - 60 Awards of Excellence</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            background: linear-gradient(135deg, #1a237e 0%, #3949ab 100%);
        }

        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background: linear-gradient(135deg, #d32f2f 0%, #1976d2 100%);
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            position: relative;
            z-index: 2;
        }

        .hero-content {
            text-align: center;
            color: white;
            animation: fadeInUp 1s ease-out;
        }

        .logo-container {
            display: inline-block;
            margin-bottom: 3rem;
            position: relative;
        }

        .tbc-logo {
            background: linear-gradient(45deg, #d32f2f, #f44336);
            padding: 2rem;
            border-radius: 20px;
            display: inline-block;
            position: relative;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            animation: float 3s ease-in-out infinite;
        }

        .logo-text {
            font-size: 4rem;
            font-weight: 900;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            letter-spacing: -0.1em;
        }

        .tagline {
            background: #1976d2;
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            display: inline-block;
            margin-top: 1rem;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .awards-section {
            margin-top: 4rem;
            animation: slideInUp 1s ease-out 0.5s both;
        }

        .awards-number {
            font-size: 8rem;
            font-weight: 900;
            background: linear-gradient(45deg, #ffd700, #ffeb3b, #ff9800);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 30px rgba(255, 215, 0, 0.5);
            animation: glow 2s ease-in-out infinite alternate;
            margin-bottom: 1rem;
        }

        .awards-text {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .awards-subtitle {
            font-size: 1.5rem;
            opacity: 0.9;
            margin-bottom: 3rem;
            font-weight: 300;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 4rem;
            animation: fadeIn 1s ease-out 1s both;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .feature-description {
            opacity: 0.9;
            line-height: 1.6;
        }

        .cta-section {
            margin-top: 5rem;
            text-align: center;
            animation: fadeInUp 1s ease-out 1.5s both;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(45deg, #ff6b35, #f7931e);
            color: white;
            padding: 1.5rem 3rem;
            border-radius: 50px;
            text-decoration: none;
            font-size: 1.3rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.4);
            position: relative;
            overflow: hidden;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 107, 53, 0.6);
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .cta-button:hover::before {
            left: 100%;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-logo {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .header-logo-icon {
            background: linear-gradient(45deg, #d32f2f, #f44336);
            padding: 0.5rem;
            border-radius: 8px;
            margin-right: 0.75rem;
            font-weight: 900;
            font-size: 1.2rem;
        }

        .login-button {
            background: linear-gradient(45deg, #ffffff, #f5f5f5);
            color: #1976d2;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
            background: linear-gradient(45deg, #f8f9fa, #ffffff);
        }

        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s;
        }

        .login-button:hover::before {
            left: 100%;
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .floating-book {
            position: absolute;
            color: rgba(255, 255, 255, 0.1);
            font-size: 2rem;
            animation: floatAround 15s linear infinite;
        }

        .floating-book:nth-child(1) { top: 20%; left: 10%; animation-delay: 0s; }
        .floating-book:nth-child(2) { top: 60%; right: 15%; animation-delay: -5s; }
        .floating-book:nth-child(3) { bottom: 30%; left: 20%; animation-delay: -10s; }
        .floating-book:nth-child(4) { top: 40%; right: 25%; animation-delay: -7s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(100px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes glow {
            from { text-shadow: 0 0 30px rgba(255, 215, 0, 0.5); }
            to { text-shadow: 0 0 50px rgba(255, 215, 0, 0.8), 0 0 70px rgba(255, 215, 0, 0.6); }
        }

        @keyframes floatAround {
            0% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(100px, -50px) rotate(90deg); }
            50% { transform: translate(50px, -100px) rotate(180deg); }
            75% { transform: translate(-50px, -75px) rotate(270deg); }
            100% { transform: translate(0, 0) rotate(360deg); }
        }

        @media (max-width: 768px) {
            .header-content {
                padding: 0 1rem;
            }
            
            .header-logo {
                font-size: 1.2rem;
            }
            
            .login-button {
                padding: 0.6rem 1.5rem;
                font-size: 0.9rem;
            }
            
            .logo-text {
                font-size: 2.5rem;
            }
            
            .awards-number {
                font-size: 5rem;
            }
            
            .awards-text {
                font-size: 2rem;
            }
            
            .awards-subtitle {
                font-size: 1.2rem;
            }
            
            .features {
                grid-template-columns: 1fr;
            }
            
            .container {
                padding: 0 1rem;
            }
        }
    </style>
</head>
<body>

    <div class="hero">
        <div class="floating-elements">
            <div class="floating-book">📚</div>
            <div class="floating-book">📖</div>
            <div class="floating-book">📕</div>
            <div class="floating-book">📘</div>
        </div>
        
        <div class="container">
            <div class="hero-content">
                
                <div class="awards-section">
                    <div class="awards-number">60</div>
                    <div class="awards-text">Text Book Centre@60 <br>Annual Awards</br></div>
                    <div class="awards-subtitle">Recognizing Outstanding Employee Performance</div>
                </div>
                
                <div class="features">
                    <div class="feature-card">
                        <div class="feature-icon">🏆</div>
                        <div class="feature-title">Employee Excellence</div>
                        <div class="feature-description">60 awards celebrating exceptional performance, dedication, and outstanding contributions by our valued team members</div>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">⭐</div>
                        <div class="feature-title">Recognition Program</div>
                        <div class="feature-description">Comprehensive awards system acknowledging hard work, innovation, and commitment to excellence across all departments</div>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">🎯</div>
                        <div class="feature-title">Team Achievement</div>
                        <div class="feature-description">Celebrating individual and team accomplishments that drive our success in educational excellence and customer service</div>
                    </div>
                </div>
                
                <div class="cta-section">
                    <a href="signin.php" class="cta-button">Login To Vote</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 50) {
                header.style.background = 'rgba(26, 35, 126, 0.95)';
                header.style.backdropFilter = 'blur(30px)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.1)';
                header.style.backdropFilter = 'blur(20px)';
            }
        });

        // Login button interaction
        document.querySelector('.login-button').addEventListener('click', function(e) {
            e.preventDefault();
            // Add ripple effect
            const ripple = document.createElement('div');
            ripple.style.position = 'absolute';
            ripple.style.borderRadius = '50%';
            ripple.style.background = 'rgba(25, 118, 210, 0.6)';
            ripple.style.transform = 'scale(0)';
            ripple.style.animation = 'ripple 0.6s linear';
            ripple.style.left = '50%';
            ripple.style.top = '50%';
            ripple.style.width = '20px';
            ripple.style.height = '20px';
            ripple.style.marginLeft = '-10px';
            ripple.style.marginTop = '-10px';
            
            this.style.position = 'relative';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
            
            // Here you would typically redirect to login page
            console.log('Login clicked');
        });

        // Add ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Add interactive hover effects
        document.querySelectorAll('.feature-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-15px) scale(1.05)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Parallax effect for floating elements
        document.addEventListener('mousemove', function(e) {
            const mouseX = e.clientX / window.innerWidth;
            const mouseY = e.clientY / window.innerHeight;
            
            document.querySelectorAll('.floating-book').forEach((book, index) => {
                const speed = (index + 1) * 0.5;
                const x = (mouseX - 0.5) * speed * 20;
                const y = (mouseY - 0.5) * speed * 20;
                book.style.transform = `translate(${x}px, ${y}px)`;
            });
        });

        // Smooth scroll animation on load
        window.addEventListener('load', function() {
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                document.body.style.overflow = 'auto';
            }, 2000);
        });
    </script>
</body>
</html>