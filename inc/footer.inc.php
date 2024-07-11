</main>

<footer>
    <div class="footer-content">
        <p>Kunden-ID: <?= isset($kunden_id) ? htmlspecialchars($kunden_id) : 'Nicht verfügbar'; ?></p>
        <p>Pay-ID: <?= isset($pay_id) ? htmlspecialchars($pay_id) : 'Nicht verfügbar'; ?></p>
    </div>
</footer>

</body>
</html>