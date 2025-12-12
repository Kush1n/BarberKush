</main>

<footer class="footer-dark mt-5 py-4">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
        
        <p class="footer-text mb-2 mb-md-0">
            &copy; 2025 <strong>BarberKush</strong> — Sistema de Barbearia
        </p>

        <div class="d-flex flex-column flex-md-row footer-links">
            <a href="#" class="footer-link me-md-3 mb-2 mb-md-0">Política de Privacidade</a>
            <a href="#" class="footer-link">Contato</a>
        </div>

    </div>
</footer>

<style>
    .footer-dark {
        background: #141414;
        border-top: 3px solid #ffc107;
        color: #e0e0e0;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.35);
    }

    .footer-text {
        font-size: 0.95rem;
        opacity: 0.9;
    }

    .footer-link {
        color: #e0e0e0;
        text-decoration: none;
        font-weight: 500;
        transition: color .2s ease, opacity .2s ease;
    }

    .footer-link:hover {
        color: #ffc107;
        opacity: 1;
        text-decoration: underline;
    }

    .footer-links {
        gap: 0.4rem;
    }

    @media (max-width: 768px) {
        .footer-dark .container {
            text-align: center;
        }

        .footer-links {
            flex-direction: column;
            gap: 0.6rem;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
