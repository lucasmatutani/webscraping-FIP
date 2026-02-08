<style>
.footer-component { width:100%; background-color:#000; color:#fff; padding:2rem 1rem; margin-top:auto; font-family:'Montserrat',sans-serif; box-sizing:border-box; }
.footer-component__container { max-width:1200px; margin:0 auto; text-align:center; }
.footer-component__nav { margin-bottom:1rem; }
.footer-component__link { color:#fff; text-decoration:none; font-weight:300; font-size:0.8rem; }
.footer-component__link:hover { color:#ff6161; }
.footer-component__nav { display:flex; flex-wrap:wrap; justify-content:center; align-items:center; gap:.5rem 1rem; }
.footer-component__separator { color:rgba(255,255,255,.5); font-weight:400; }
.footer-component__copyright { font-size:.9rem; margin:0 0 .5rem 0; color:rgba(255,255,255,.9); }
.footer-component__disclaimer { font-size:.75rem; margin:0; color:rgba(255,255,255,.6); line-height:1.4; max-width:600px; margin-left:auto; margin-right:auto; }
</style>
<footer class="footer footer-component" role="contentinfo">
    <div class="footer__container footer-component__container">
        <nav class="footer__nav footer-component__nav" aria-label="Links do rodapé">
            <a href="{{ url('/') }}" class="footer__link footer-component__link">Consulta Tabela FIPE</a>
            <span class="footer-component__separator" aria-hidden="true">|</span>
            <a href="{{ route('politica-privacidade') }}" class="footer__link footer-component__link">Política de Privacidade</a>
        </nav>
        <p class="footer__copyright footer-component__copyright">
            &copy; {{ date('Y') }} Carros do Brasil - Tabela FIPE. Valores de referência.
        </p>
        <p class="footer__disclaimer footer-component__disclaimer">
            Os valores exibidos têm caráter unicamente informativo e não substituem consulta oficial à Fundação Instituto de Pesquisas Econômicas (FIPE).
        </p>
    </div>
</footer>
