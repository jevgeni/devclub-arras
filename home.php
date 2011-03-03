<?php get_header(); ?>

<?php
$stickies = get_option('sticky_posts');
rsort($stickies);

$slideshow_cat	= arras_get_option('slideshow_cat');
$featured1_cat 	= arras_get_option('featured1_cat');
$featured2_cat 	= arras_get_option('featured2_cat');
$news_cat 		= arras_get_option('news_cat');

$slideshow_count	= (int)arras_get_option('slideshow_count');
$featured1_count 	= (int)arras_get_option('featured1_count');
$featured2_count 	= (int)arras_get_option('featured2_count');

$post_blacklist = array();
?>


<div id="important" class="section">
    <?php $sticky = get_option('sticky_posts');
        $args = array(
            'posts_per_page' => 1,
            'post__in' => $sticky
        );

        query_posts($args);
        
        if ($sticky[0]) : the_post(); ?>

        <ul class="xoxo">
            <li class="widgetcontainer clearfix">
                <h5 class="widgettitle">ВАЖНОЕ</h5>
                <div class="widgetcontent">
                    <div class="textwidget">
                        <div id="post-<?php the_ID(); ?>" class="post<?php sticky_class(); ?> posts-quick" >
                            <div class="entry-thumbnails">
                                <a href="<?php echo the_permalink(); ?>" class="entry-thumbnails-link">
                                    <?php echo arras_get_thumbnail() ?>
                                </a>
                            </div>
                            <h3 class="entry-title"><?php the_title(); ?></h3>
                            <div class="entry-summary">
                                <div class="entry-info">
                                    <abbr class="published" title="<?php the_time('c') ?>"><?php printf( __('Posted on %s', 'arras'), get_the_time(get_option('date_format')) ) ?></abbr> | <span><?php comments_number() ?></span>
                                </div>
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>

        <?php endif; ?>
        <?php wp_reset_query(); ?>
</div>

<div id="meeting" class="section">
    <ul class="xoxo">
        <li class="widgetcontainer clearfix">
            <h5 class="widgettitle">Анонс/Отчет</h5>
            <?php
            query_posts( 'category_name=meetings&posts_per_page=1' );

            if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="widgetcontent">
                    <div class="textwidget">
                        <?php $bag = wp_get_attachment_image_src( arras_get_first_post_image_id(), array(650,650)); ?>
                        <div id="post-<?php the_ID(); ?>" class="posts-quick" style="background:url('<?php echo $bag[0]; ?>') no-repeat left top;">
                            <h3 class="entry-title"><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="side-links">
                                <ul>
                                    <?php
                                            $key="quick-links";
                                            $meta = get_post_meta($post->ID, $key, true);
                                            preg_match_all("((?P<label>[^=\n\r]+)=(?P<url>[^=\n\r]+))",
                                                           $meta, $out, PREG_SET_ORDER);
                                            foreach($out as $link): ?>
                                    <li>
                                        <a href="<?php echo $link['url']; ?>"><?php echo $link['label'] ?></a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="buttons">

                                <a href="<?php echo the_permalink(); ?>" class="megabutton left">Прочитать ...</a>
                                <?php
                                $meetings_category = get_category_by_slug("meetings");
                                $meetings_link = get_category_link($meetings_category->term_id);

                                ?>
                                <a href="<?php echo $meetings_link ?>" class="megabutton right">Остальные ...</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; endif; ?>
            <?php wp_reset_query(); ?>
        </li>
    </ul>
</div>

<div id="jobs" class="section">

    <ul class="xoxo">
        <li class="widgetcontainer clearfix">
            <h5 class="widgettitle">Работа</h5>

            <div class="widgetcontent">
                <div class="textwidget">
                    <div class="posts-quick">
                        <ul class="half left">
                        <?php
                            $sticky = get_option('sticky_posts');
                            $i = 0;
                            query_posts( 'category_name=jobs&posts_per_page=8' );
                            if (have_posts()) : while (have_posts()) : the_post();

                            if($i == 4):
                        ?>
                        </ul>
                        <ul class="half right">
                        <?php endif; ?>
                            <li>
                                <div class="date"><?php echo get_the_time("d.m.Y"); ?></div>
                                <a href="#"><?php the_title(); ?></a>
                            </li>
                        <?php $i++; endwhile; endif; ?>
                        </ul>
                        <div class="clear"></div>
                        <?php wp_reset_query(); ?>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>

<div id="news" class="section">
    <?php $sticky = get_option('sticky_posts');
    query_posts( 'category_name=news&posts_per_page=10' ); ?>

    <ul class="xoxo">
        <li class="widgetcontainer clearfix">
            <h5 class="widgettitle">Новости</h5>
            <div class="widgetcontent">
                <div class="textwidget">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                    <div id="post-<?php the_ID(); ?>" class="post<?php sticky_class(); ?> posts-quick" >
                        <div class="entry-thumbnails">
                            <a href="<?php echo the_permalink(); ?>" class="entry-thumbnails-link">
                                <?php echo arras_get_thumbnail() ?>
                            </a>
                        </div>
                        <h3 class="entry-title"><?php the_title(); ?></h3>
                        <div class="entry-summary">
                            <div class="entry-info">
                                <abbr class="published" title="<?php the_time('c') ?>">
                                    <?php echo get_the_time("d.m.Y"); ?></abbr> |
                                <abbr title="tags">
                                <?php $posttags = get_the_tags(); if ($posttags): foreach($posttags as $tag): ?>
                                <a href="#<?php echo $tag->slug;?>"><?php echo $tag->name; ?></a>
                                <?php endforeach; endif; ?>
                                    </abbr> |
                                <abbr title="category">
                                    <?php $postcats = get_the_category(); if ($postcats): foreach($postcats as $cat): ?>
                                <a href="#<?php echo $cat->cat_ID;?>"><?php echo $cat->cat_name; ?></a>
                                <?php endforeach; endif; ?>
                                    </abbr>
                            </div>
                            <?php the_excerpt(); ?>
                            <a href="<?php echo the_permalink(); ?>" class="megabutton">Далее ... </a> <a href="#"  class="megabutton"><?php comments_number() ?></a>
                        </div>
                    </div>
                    <?php endwhile; endif; ?>
                </div>
            </div>
        </li>
    </ul>
    <?php wp_reset_query(); ?>
</div>

<!-- end of devclub customization -->


<?php arras_below_content() ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>