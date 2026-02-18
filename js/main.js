/**
 * 刻画博客主题 for Typecho - JavaScript
 */

(function() {
    'use strict';

    // ========================================
    // DOM 元素
    // ========================================
    
    const themeToggle = document.getElementById('theme-toggle');
    const searchToggle = document.getElementById('search-toggle');
    const searchModal = document.getElementById('search-modal');
    const searchInput = document.getElementById('search-input');
    const searchClose = document.getElementById('search-close');
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileNav = document.getElementById('mobile-nav');
    const backToTop = document.getElementById('back-to-top');

    // ========================================
    // 主题切换
    // ========================================
    
    function initTheme() {
        const savedTheme = localStorage.getItem('theme');
        
        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
        } else {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (prefersDark) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        }
    }

    function toggleTheme() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
    }

    function watchSystemTheme() {
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        
        mediaQuery.addEventListener('change', (e) => {
            if (!localStorage.getItem('theme')) {
                document.documentElement.setAttribute('data-theme', e.matches ? 'dark' : 'light');
            }
        });
    }

    // ========================================
    // 搜索功能
    // ========================================
    
    function openSearch() {
        if (!searchModal) return;
        searchModal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        setTimeout(() => {
            if (searchInput) searchInput.focus();
        }, 100);
    }

    function closeSearch() {
        if (!searchModal) return;
        searchModal.classList.remove('active');
        document.body.style.overflow = '';
        if (searchInput) searchInput.value = '';
    }

    function handleSearchKeydown(e) {
        if (e.key === 'Escape') {
            closeSearch();
        }
    }

    // ========================================
    // 移动端导航
    // ========================================
    
    function toggleMobileNav() {
        if (!mobileNav) return;
        mobileNav.classList.toggle('active');
        
        const icon = mobileMenuToggle.querySelector('.icon');
        if (mobileNav.classList.contains('active')) {
            icon.innerHTML = `
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            `;
        } else {
            icon.innerHTML = `
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            `;
        }
    }

    function closeMobileNav() {
        if (!mobileNav) return;
        if (mobileNav.classList.contains('active')) {
            mobileNav.classList.remove('active');
            const icon = mobileMenuToggle.querySelector('.icon');
            icon.innerHTML = `
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            `;
        }
    }

    // ========================================
    // 回到顶部
    // ========================================
    
    function handleScroll() {
        const scrollY = window.scrollY;
        
        if (backToTop) {
            if (scrollY > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        }
    }

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // ========================================
    // 图片懒加载
    // ========================================
    
    function initLazyImages() {
        const images = document.querySelectorAll('img[loading="lazy"]');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.classList.add('loaded');
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px 0px'
            });

            images.forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    // ========================================
    // 代码块复制
    // ========================================
    
    function initCodeCopy() {
        const codeBlocks = document.querySelectorAll('.article-content pre');
        
        codeBlocks.forEach(pre => {
            const copyBtn = document.createElement('button');
            copyBtn.className = 'code-copy-btn';
            copyBtn.textContent = '复制';
            copyBtn.style.cssText = `
                position: absolute;
                top: 8px;
                right: 8px;
                padding: 4px 8px;
                font-size: 12px;
                color: var(--color-text-muted);
                background: var(--color-bg);
                border: 1px solid var(--color-border);
                border-radius: 4px;
                cursor: pointer;
                opacity: 0;
                transition: opacity 0.2s;
            `;
            
            pre.style.position = 'relative';
            pre.appendChild(copyBtn);
            
            pre.addEventListener('mouseenter', () => {
                copyBtn.style.opacity = '1';
            });
            
            pre.addEventListener('mouseleave', () => {
                copyBtn.style.opacity = '0';
            });
            
            copyBtn.addEventListener('click', async () => {
                const code = pre.querySelector('code');
                const text = code ? code.textContent : pre.textContent;
                
                try {
                    await navigator.clipboard.writeText(text);
                    copyBtn.textContent = '已复制';
                    setTimeout(() => {
                        copyBtn.textContent = '复制';
                    }, 2000);
                } catch (err) {
                    console.error('复制失败:', err);
                }
            });
        });
    }

    // ========================================
    // 平滑滚动
    // ========================================
    
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    
                    const header = document.querySelector('.header');
                    const headerHeight = header ? header.offsetHeight : 0;
                    const targetPosition = target.getBoundingClientRect().top + window.scrollY - headerHeight - 20;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    // ========================================
    // 外部链接处理
    // ========================================
    
    function initExternalLinks() {
        const links = document.querySelectorAll('.article-content a');
        
        links.forEach(link => {
            const href = link.getAttribute('href');
            if (href && href.startsWith('http') && !href.includes(window.location.hostname)) {
                link.setAttribute('target', '_blank');
                link.setAttribute('rel', 'noopener noreferrer');
            }
        });
    }

    // ========================================
    // 阅读进度条
    // ========================================
    
    function initReadingProgress() {
        const article = document.querySelector('.article-content');
        if (!article) return;
        
        const progressBar = document.createElement('div');
        progressBar.className = 'reading-progress';
        progressBar.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: var(--color-primary);
            z-index: 101;
            transition: width 0.1s linear;
        `;
        document.body.appendChild(progressBar);
        
        function updateProgress() {
            const articleTop = article.offsetTop;
            const articleHeight = article.offsetHeight;
            const windowHeight = window.innerHeight;
            const scrollY = window.scrollY;
            
            const start = articleTop - windowHeight;
            const end = articleTop + articleHeight;
            const current = scrollY;
            
            let progress = ((current - start) / (end - start)) * 100;
            progress = Math.max(0, Math.min(100, progress));
            
            progressBar.style.width = progress + '%';
        }
        
        window.addEventListener('scroll', updateProgress, { passive: true });
        updateProgress();
    }

    // ========================================
    // 键盘快捷键
    // ========================================
    
    function initKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                if (searchModal && searchModal.classList.contains('active')) {
                    closeSearch();
                } else {
                    openSearch();
                }
            }
            
            if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
                e.preventDefault();
                toggleTheme();
            }
        });
    }

    // ========================================
    // 事件绑定
    // ========================================
    
    function bindEvents() {
        if (themeToggle) {
            themeToggle.addEventListener('click', toggleTheme);
        }
        
        if (searchToggle) {
            searchToggle.addEventListener('click', openSearch);
        }
        
        if (searchClose) {
            searchClose.addEventListener('click', closeSearch);
        }
        
        if (searchModal) {
            searchModal.addEventListener('click', (e) => {
                if (e.target === searchModal) {
                    closeSearch();
                }
            });
        }
        
        if (searchInput) {
            searchInput.addEventListener('keydown', handleSearchKeydown);
        }
        
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', toggleMobileNav);
        }
        
        if (backToTop) {
            backToTop.addEventListener('click', scrollToTop);
        }
        
        window.addEventListener('scroll', handleScroll, { passive: true });
        
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                closeMobileNav();
            }
        });
        
        document.addEventListener('click', (e) => {
            if (mobileNav && mobileMenuToggle && !mobileNav.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                closeMobileNav();
            }
        });
    }

    // ========================================
    // 初始化
    // ========================================
    
    function init() {
        initTheme();
        watchSystemTheme();
        bindEvents();
        initLazyImages();
        initCodeCopy();
        initSmoothScroll();
        initExternalLinks();
        initKeyboardShortcuts();
        
        if (document.querySelector('.article-content')) {
            initReadingProgress();
        }
        
        handleScroll();
        
        console.log('刻画博客主题');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

