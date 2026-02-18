<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

    <!-- 页脚 -->
    <footer class="footer">
        <div class="container">
            <?php if ($this->options->customCopyright): ?>
            <p class="footer-copyright"><?php echo $this->options->customCopyright; ?></p>
            <?php endif; ?>
            <p class="footer-theme">Theme by <a href="https://kehua.me" target="_blank" rel="noopener">kehua</a></p>
        </div>
    </footer>

    <!-- 回到顶部 -->
    <button class="back-to-top" id="back-to-top" title="回到顶部">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="18 15 12 9 6 15"></polyline>
        </svg>
    </button>

    <script src="<?php $this->options->themeUrl('js/main.js'); ?>"></script>
    <?php $this->footer(); ?>
</body>
</html>

