<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<!-- 侧边栏 - 如需使用可在模板中引入 -->
<aside class="sidebar">
    <!-- 最新文章 -->
    <div class="sidebar-widget">
        <h3 class="sidebar-widget-title">最新文章</h3>
        <ul class="sidebar-list">
            <?php $this->widget('Widget_Contents_Post_Recent', 'pageSize=5')->to($recentPosts); ?>
            <?php while($recentPosts->next()): ?>
            <li>
                <a href="<?php $recentPosts->permalink(); ?>"><?php $recentPosts->title(); ?></a>
            </li>
            <?php endwhile; ?>
        </ul>
    </div>
    
    <!-- 分类 -->
    <div class="sidebar-widget">
        <h3 class="sidebar-widget-title">分类</h3>
        <ul class="sidebar-list">
            <?php $this->widget('Widget_Metas_Category_List')->to($categoriesSidebar); ?>
            <?php while($categoriesSidebar->next()): ?>
            <li>
                <a href="<?php $categoriesSidebar->permalink(); ?>"><?php $categoriesSidebar->name(); ?></a>
                <span class="count">(<?php $categoriesSidebar->count(); ?>)</span>
            </li>
            <?php endwhile; ?>
        </ul>
    </div>
    
    <!-- 标签云 -->
    <div class="sidebar-widget">
        <h3 class="sidebar-widget-title">标签</h3>
        <div class="sidebar-tags">
            <?php $this->widget('Widget_Metas_Tag_Cloud', 'sort=count&ignoreZeroCount=1&desc=1&limit=20')->to($tags); ?>
            <?php while($tags->next()): ?>
            <a href="<?php $tags->permalink(); ?>" class="tag"><?php $tags->name(); ?></a>
            <?php endwhile; ?>
        </div>
    </div>
    
    <!-- 归档 -->
    <div class="sidebar-widget">
        <h3 class="sidebar-widget-title">归档</h3>
        <ul class="sidebar-list">
            <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y年m月')->parse('<li><a href="{permalink}">{date}</a></li>'); ?>
        </ul>
    </div>
</aside>

<style>
.sidebar {
    width: 280px;
    flex-shrink: 0;
}

.sidebar-widget {
    margin-bottom: var(--spacing-xl);
    padding: var(--spacing-lg);
    background-color: var(--color-bg);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-lg);
}

.sidebar-widget-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: var(--spacing-md);
    padding-bottom: var(--spacing-sm);
    border-bottom: 2px solid var(--color-primary);
}

.sidebar-list {
    list-style: none;
    padding: 0;
}

.sidebar-list li {
    padding: var(--spacing-sm) 0;
    border-bottom: 1px solid var(--color-border-light);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.sidebar-list li:last-child {
    border-bottom: none;
}

.sidebar-list a {
    color: var(--color-text-secondary);
    font-size: 0.9375rem;
    transition: color var(--transition-fast);
}

.sidebar-list a:hover {
    color: var(--color-primary);
}

.sidebar-list .count {
    font-size: 0.8125rem;
    color: var(--color-text-muted);
}

.sidebar-tags {
    display: flex;
    flex-wrap: wrap;
    gap: var(--spacing-sm);
}

.sidebar-tags .tag {
    display: inline-block;
    padding: var(--spacing-xs) var(--spacing-sm);
    font-size: 0.8125rem;
    color: var(--color-text-secondary);
    background-color: var(--color-bg-secondary);
    border-radius: var(--radius-sm);
    transition: color var(--transition-fast), background-color var(--transition-fast);
}

.sidebar-tags .tag:hover {
    color: var(--color-primary);
    background-color: rgba(229, 57, 53, 0.1);
}

@media (max-width: 960px) {
    .sidebar {
        width: 100%;
    }
}
</style>

