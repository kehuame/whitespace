<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

    <!-- 主要内容 -->
    <main class="main">
        <div class="container">
            <!-- 分类/标签/搜索 标题 -->
            <div class="category-header">
                <h1 class="category-title"><?php $this->archiveTitle(array(
                    'category' => _t('%s'),
                    'search'   => _t('搜索：%s'),
                    'tag'      => _t('%s'),
                    'author'   => _t('%s 的文章'),
                    'date'     => _t('%s')
                ), '', ''); ?></h1>
            </div>

            <?php if ($this->have()): ?>
            <!-- 文章列表 -->
            <div class="post-list">
                <?php while($this->next()): ?>
                <?php $thumb = getThumb($this); ?>
                <article class="post<?php if ($thumb): ?> post-with-thumb<?php endif; ?>">
                    <?php if ($thumb): ?>
                    <div class="post-thumb">
                        <a href="<?php $this->permalink(); ?>">
                            <img src="<?php echo $thumb; ?>" alt="<?php $this->title(); ?>" loading="lazy">
                        </a>
                    </div>
                    <div class="post-content">
                    <?php endif; ?>
                        <h2 class="post-title">
                            <a href="<?php $this->permalink(); ?>"><?php $this->title(); ?></a>
                        </h2>
                        <p class="post-excerpt">
                            <?php echo getExcerpt($this->content, 150); ?>
                        </p>
                        <div class="post-meta">
                            <span class="post-date"><?php echo getRelativeTime($this->created); ?></span>
                            <span class="post-meta-sep">·</span>
                            <span class="post-category"><?php $this->category(','); ?></span>
                            <span class="post-meta-sep">·</span>
                            <span class="post-views"><?php echo getViews($this); ?> 次浏览</span>
                        </div>
                    <?php if ($thumb): ?>
                    </div>
                    <?php endif; ?>
                </article>
                <?php endwhile; ?>
            </div>

            <!-- 分页 -->
            <?php $this->pageNav('← 上一页', '下一页 →', 2, '...', array(
                'wrapTag' => 'div',
                'wrapClass' => 'pagination',
                'itemTag' => 'a',
                'currentClass' => 'active',
                'prevClass' => 'pagination-item',
                'nextClass' => 'pagination-item pagination-next'
            )); ?>
            <?php else: ?>
            <div class="no-results">
                <p>没有找到相关内容</p>
            </div>
            <?php endif; ?>
        </div>
    </main>

<?php $this->need('footer.php'); ?>

