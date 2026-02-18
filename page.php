<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

    <!-- 主要内容 -->
    <main class="main">
        <div class="container">
            <?php if ($this->fields->pageType == 'about' || $this->slug == 'about'): ?>
            <!-- 关于页面样式 -->
            <div class="page-content about-page">
                <div class="about-header">
                    <div class="about-avatar">
                        <?php if ($this->options->avatarUrl): ?>
                        <img src="<?php $this->options->avatarUrl(); ?>" alt="<?php $this->author(); ?>">
                        <?php else: ?>
                        <img src="<?php echo getCommentAvatar($this->author->mail, 240); ?>" alt="<?php $this->author(); ?>">
                        <?php endif; ?>
                    </div>
                    <h1 class="about-name"><?php $this->author(); ?></h1>
                    <p class="about-bio"><?php echo $this->options->aboutBio ? $this->options->aboutBio : '一个热爱生活、热爱技术的普通人'; ?></p>
                    <div class="about-social">
                        <?php if ($this->options->githubUrl): ?>
                        <a href="<?php $this->options->githubUrl(); ?>" class="social-link" title="GitHub" target="_blank" rel="noopener">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                        </a>
                        <?php endif; ?>
                        <?php if ($this->options->twitterUrl): ?>
                        <a href="<?php $this->options->twitterUrl(); ?>" class="social-link" title="Twitter" target="_blank" rel="noopener">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <?php endif; ?>
                        <?php if ($this->options->contactEmail): ?>
                        <a href="mailto:<?php $this->options->contactEmail(); ?>" class="social-link" title="邮箱">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="about-content article-content">
                    <?php $this->content(); ?>
                </div>
            </div>

            <?php elseif ($this->fields->pageType == 'links' || $this->slug == 'links'): ?>
            <!-- 友情链接页面 -->
            <div class="category-header">
                <h1 class="category-title"><?php $this->title(); ?></h1>
            </div>
            <div class="page-content article-content">
                <?php $this->content(); ?>
            </div>

            <?php elseif ($this->fields->pageType == 'archive' || $this->slug == 'archive'): ?>
            <!-- 归档页面 -->
            <div class="category-header">
                <h1 class="category-title"><?php $this->title(); ?></h1>
            </div>
            
            <?php $stats = getArchiveStats(); ?>
            <div class="archive-stats">
                <div class="archive-stat">
                    <div class="archive-stat-number"><?php echo $stats['posts']; ?></div>
                    <div class="archive-stat-label">篇文章</div>
                </div>
                <div class="archive-stat">
                    <div class="archive-stat-number"><?php echo $stats['categories']; ?></div>
                    <div class="archive-stat-label">个分类</div>
                </div>
                <div class="archive-stat">
                    <div class="archive-stat-number"><?php echo $stats['tags']; ?></div>
                    <div class="archive-stat-label">个标签</div>
                </div>
                <div class="archive-stat">
                    <div class="archive-stat-number"><?php echo $stats['years']; ?></div>
                    <div class="archive-stat-label">年</div>
                </div>
            </div>

            <?php $this->widget('Widget_Contents_Post_Date', 'type=year&format=Y')->to($archives); ?>
            <?php $currentYear = ''; ?>
            <?php while($archives->next()): ?>
                <?php $year = date('Y', $archives->created); ?>
                <?php if ($year != $currentYear): ?>
                    <?php if ($currentYear != ''): ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <?php $currentYear = $year; ?>
                    <div class="archive-year">
                        <h2 class="archive-year-title"><?php echo $year; ?></h2>
                        <ul class="archive-list">
                <?php endif; ?>
                    <li class="archive-item">
                        <span class="archive-date"><?php echo date('m-d', $archives->created); ?></span>
                        <span class="archive-title"><a href="<?php $archives->permalink(); ?>"><?php $archives->title(); ?></a></span>
                        <span class="archive-category"><?php $archives->category(','); ?></span>
                    </li>
            <?php endwhile; ?>
            <?php if ($currentYear != ''): ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php else: ?>
            <!-- 默认页面样式 -->
            <article class="article-detail">
                <header class="article-header">
                    <h1 class="article-title"><?php $this->title() ?></h1>
                </header>

                <div class="article-content">
                    <?php $this->content(); ?>
                </div>
            </article>

            <!-- 评论区 -->
            <?php $this->need('comments.php'); ?>
            <?php endif; ?>
        </div>
    </main>

<?php $this->need('footer.php'); ?>

