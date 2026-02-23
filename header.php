<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $this->archiveTitle(array(
        'category' => _t('%s'),
        'search'   => _t('搜索 %s'),
        'tag'      => _t('%s'),
        'author'   => _t('%s 的文章')
    ), '', ' - '); ?><?php $this->options->title(); ?></title>
    <meta name="description" content="<?php $this->options->description(); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/style.css'); ?>">
    <?php $this->header(); ?>
</head>
<body>
    <!-- 头部导航 -->
    <header class="header">
        <div class="header-inner">
            <a href="<?php $this->options->siteUrl(); ?>" class="logo">
                <?php if (!empty($this->options->logoUrl)): ?>
                <img src="<?php $this->options->logoUrl(); ?>" alt="<?php $this->options->title(); ?>" class="logo-img">
                <?php else: ?>
                <span class="logo-text"><?php $this->options->title(); ?></span>
                <?php endif; ?>
            </a>
            <nav class="nav">
                <?php 
                $customNavMenu = $this->options->navMenu;
                $navMenuItems = parseNavMenu($customNavMenu);
                
                if (!empty($navMenuItems)): 
                    // 使用自定义导航菜单
                    foreach ($navMenuItems as $menuItem): 
                        $currentUrl = $this->request->getRequestUrl();
                        $menuUrl = $menuItem['url'];
                        // 判断是否为当前页面
                        $isActive = false;
                        if ($menuUrl == '/' && $this->is('index')) {
                            $isActive = true;
                        } elseif ($menuUrl != '/' && strpos($currentUrl, $menuUrl) !== false) {
                            $isActive = true;
                        }
                ?>
                <a href="<?php echo $menuUrl; ?>" class="nav-link<?php if ($isActive): ?> active<?php endif; ?>"><?php echo $menuItem['name']; ?></a>
                <?php 
                    endforeach;
                endif; ?>
            </nav>
            <div class="header-actions">
                <button class="btn-icon" id="theme-toggle" title="切换主题">
                    <svg class="icon icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="5"></circle>
                        <line x1="12" y1="1" x2="12" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="23"></line>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                        <line x1="1" y1="12" x2="3" y2="12"></line>
                        <line x1="21" y1="12" x2="23" y2="12"></line>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                    </svg>
                    <svg class="icon icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                </button>
                <button class="btn-icon" id="search-toggle" title="搜索">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
                <button class="btn-icon mobile-menu-toggle" id="mobile-menu-toggle">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- 搜索弹窗 -->
    <div class="search-modal" id="search-modal">
        <div class="search-modal-content">
            <form class="search-input-wrapper" method="get" action="<?php $this->options->siteUrl(); ?>">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="s" class="search-input" placeholder="搜索文章..." id="search-input" autocomplete="off">
                <button type="button" class="search-close" id="search-close">&times;</button>
            </form>
        </div>
    </div>

    <!-- 移动端导航菜单 -->
    <div class="mobile-nav" id="mobile-nav">
        <?php 
        if (!empty($navMenuItems)): 
            // 使用自定义导航菜单
            foreach ($navMenuItems as $menuItem): 
                $currentUrl = $this->request->getRequestUrl();
                $menuUrl = $menuItem['url'];
                // 判断是否为当前页面
                $isActive = false;
                if ($menuUrl == '/' && $this->is('index')) {
                    $isActive = true;
                } elseif ($menuUrl != '/' && strpos($currentUrl, $menuUrl) !== false) {
                    $isActive = true;
                }
        ?>
        <a href="<?php echo $menuUrl; ?>" class="mobile-nav-link<?php if ($isActive): ?> active<?php endif; ?>"><?php echo $menuItem['name']; ?></a>
        <?php 
            endforeach;
        endif; ?>
    </div>

