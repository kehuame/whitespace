<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

    <!-- 404 内容 -->
    <main class="main">
        <div class="container">
            <div class="error-page">
                <div class="error-code">404</div>
                <h1 class="error-title">页面未找到</h1>
                <p class="error-message">抱歉，您访问的页面不存在或已被删除。</p>
                <div class="error-actions">
                    <a href="<?php $this->options->siteUrl(); ?>" class="error-btn">返回首页</a>
                    <a href="javascript:history.back();" class="error-btn error-btn-secondary">返回上页</a>
                </div>
            </div>
        </div>
    </main>

    <style>
        .error-page {
            text-align: center;
            padding: var(--spacing-2xl) 0;
            min-height: 60vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .error-code {
            font-size: 8rem;
            font-weight: 700;
            color: var(--color-primary);
            line-height: 1;
            margin-bottom: var(--spacing-md);
            text-shadow: 4px 4px 0 var(--color-border);
        }
        
        .error-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: var(--spacing-md);
        }
        
        .error-message {
            color: var(--color-text-secondary);
            margin-bottom: var(--spacing-xl);
        }
        
        .error-actions {
            display: flex;
            gap: var(--spacing-md);
        }
        
        .error-btn {
            display: inline-block;
            padding: var(--spacing-sm) var(--spacing-xl);
            background-color: var(--color-primary);
            color: white;
            border-radius: var(--radius-sm);
            font-weight: 500;
            transition: background-color var(--transition-fast);
        }
        
        .error-btn:hover {
            background-color: var(--color-primary-hover);
            color: white;
        }
        
        .error-btn-secondary {
            background-color: var(--color-bg-secondary);
            color: var(--color-text);
            border: 1px solid var(--color-border);
        }
        
        .error-btn-secondary:hover {
            background-color: var(--color-border-light);
            color: var(--color-text);
        }
        
        @media (max-width: 480px) {
            .error-code {
                font-size: 5rem;
            }
            
            .error-title {
                font-size: 1.5rem;
            }
            
            .error-actions {
                flex-direction: column;
                width: 100%;
            }
            
            .error-btn {
                text-align: center;
            }
        }
    </style>

<?php $this->need('footer.php'); ?>

