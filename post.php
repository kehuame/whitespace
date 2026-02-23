<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php 
// 统计阅读次数
$views = getPostViews($this);
?>
<?php $this->need('header.php'); ?>

    <!-- 文章内容 -->
    <main class="main">
        <article class="article-detail">
            <header class="article-header">
                <h1 class="article-title"><?php $this->title() ?></h1>
                <div class="article-meta">
                    <span class="article-date"><?php echo getRelativeTime($this->created); ?></span>
                    <span class="article-meta-sep">·</span>
                    <span class="article-category"><?php $this->category(','); ?></span>
                    <?php if ($views > 0): ?>
                    <span class="article-meta-sep">·</span>
                    <span class="article-views"><?php echo number_format($views); ?> 次浏览</span>
                    <?php endif; ?>
                </div>
            </header>

            <?php $thumb = getThumb($this); ?>
            <?php if ($thumb): ?>
            <div class="article-cover">
                <img src="<?php echo $thumb; ?>" alt="<?php $this->title(); ?>">
            </div>
            <?php endif; ?>

            <div class="article-content">
                <?php $this->content(); ?>
            </div>

            <!-- 文章标签 -->
            <?php if ($this->tags): ?>
            <div class="article-tags">
                <span class="tag-label">标签：</span>
                <?php $this->tags(', ', true, 'none'); ?>
            </div>
            <?php endif; ?>

            <!-- 文章导航 -->
            <nav class="article-nav">
                <?php $this->thePrev('%s', '', array('tagClass' => 'article-nav-item article-nav-prev')); ?>
                <?php $this->theNext('%s', '', array('tagClass' => 'article-nav-item article-nav-next')); ?>
            </nav>
        </article>

        <!-- 评论区 -->
        <?php $this->need('comments.php'); ?>
    </main>

<?php $this->need('footer.php'); ?>

