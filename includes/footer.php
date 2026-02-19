    <footer class="footer">

        <div class="footer-container">

            <!-- for logo and about the websites in footer  -->
            <div class="footer-section">
                <h2>BabySafe</h2>
                <p>Trusted babysitters for your family. Safe, caring and reliable childcare services.</p>
            </div>

            <!-- for quicks links in footer -->
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="find_sitters.php">Find A Sitter</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li><a href="about.php">About Us</a></li>
                </ul>
            </div>

            <!-- for contact information-->
            <div class="footer-section">
                <h3>Contact</h3>
                <p>Email: info@babysafe.com</p>
                <p>Phone: +977 9804000857</p>
                <p>Biratnagar, Nepal</p>
            </div>

        </div>

        <div class="footer-bottom">
            <p>&copy; 2026 BabySafe. All rights reserved.</p>
        </div>

    </footer>
    <script>
        const slider = document.querySelector('.slider');
        const arrows = document.querySelectorAll('.arrow');
        const cards = document.querySelectorAll('.sitter-card');
        const seeMoreBtns = document.querySelectorAll('.qualification');

        /* === SLIDE FUNCTION === */
        arrows[0].addEventListener('click', () => {
            slider.scrollLeft -= 300;
        });

        arrows[1].addEventListener('click', () => {
            slider.scrollLeft += 300;
        });

        /* === SHOW MORE FUNCTION === */
        seeMoreBtns.forEach(btn => {
            btn.addEventListener('click', function(){
                const card = this.closest('.sitter-card');
                card.classList.toggle('active');

                this.textContent = 
                    card.classList.contains('active') 
                    ? "Show Less Details..." 
                    : "Show More Details...";
            });
        });

        /* === SHOW/HIDE ARROWS === */
        function updateArrows(){
            arrows[0].style.display = slider.scrollLeft <= 0 ? "none" : "block";
            arrows[1].style.display =
                slider.scrollLeft + slider.clientWidth >= slider.scrollWidth
                ? "none" : "block";
        }

        slider.addEventListener('scroll', updateArrows);
        window.addEventListener('load', updateArrows);
    </script>


</body>
</html>