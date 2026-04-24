    </main>

    <footer class="site-footer">
        <p>&copy; <?php echo date('Y'); ?> Yacine Tarzout &ndash; BTS SIO SISR &ndash; Lyc&eacute;e Algoud-Laffemas</p>
        <div class="footer-links">
            <a href="index.php">Accueil</a>
            <a href="#">Mentions l&eacute;gales</a>
            <a href="#">Contact</a>
        </div>
    </footer>

    <script>
        const canvas = document.getElementById("particles");
        const ctx = canvas.getContext("2d");
        let stars = [];
        const STAR_COUNT = 180;

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();

        class Star {
            constructor() { this.reset(); }
            reset() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.radius = Math.random() * 1.2 + 0.3;
                this.speed = Math.random() * 0.25 + 0.05;
                this.alpha = Math.random() * 0.5 + 0.1;
            }
            update() {
                this.y += this.speed;
                if (this.y > canvas.height) {
                    this.y = 0;
                    this.x = Math.random() * canvas.width;
                }
            }
            draw() {
                ctx.fillStyle = `rgba(255,255,255,${this.alpha})`;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        function initStars() {
            stars = [];
            for (let i = 0; i < STAR_COUNT; i++) stars.push(new Star());
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            stars.forEach(s => { s.update(); s.draw(); });
            requestAnimationFrame(animate);
        }

        initStars();
        animate();
    </script>
</body>
</html>
