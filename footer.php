  </main>

  <!-- Подвал сайта -->
  <footer class="footer">
    <div class="container">
      <p class="footer__text">
        &copy; <span class="footer__year"><?php echo date('Y'); ?></span>
        <!-- Текст копирайта: редактируется в админке (вкладка Footer),
             переключается по языку через data-i18n -->
        <span data-i18n="footer_text"><?php echo carbon_get_theme_option('footer_text_en'); ?></span>
      </p>
    </div>
  </footer>

  <?php wp_footer(); // обязательный хук: подключает скрипты темы перед </body> ?>
</body>
</html>
