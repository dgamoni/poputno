<?php
/**
 * Template Name: Топ
 */

get_header(); ?>
    <section class="main">
        <div class="wrap">
            <div class="sort-block cf">
                <div class="date-sort">
                    <ins>Популярное за:</ins>
                    <br/>

                    <div class="ms_date ms_drop">
                        <div class="ms_trigger">Неделю</div>
                        <div>
                            <a href="#" onclick="top_posts.byyear(this); return false;">Год</a><span>/</span>
                            <a href="#" onclick="top_posts.bymonth(this); return false;">Месяц</a><span>/</span>
                            <a href="#" onclick="top_posts.byweek(this); return false;" class="active">Неделю</a>
                        </div>
                    </div>
                </div>
                <div class="p-sort">
                    <div class="ms_meta ms_drop">
                        <div class="ms_trigger">По просмотрам</div>
                        <div>
                            <a href="#" class="active" onclick="top_posts.byviews(this);return false;">По просмотрам</a>
                            <span>/</span>
                            <a href="#" onclick="top_posts.bylikes(this);return false;">По лайкам</a>
                            <span>/</span>
                            <a href="#" onclick="top_posts.bycomments(this); return false;">По комментариям</a>
                        </div>
                    </div>
                </div>

            </div>

            <ol class="last_post cf new_posts">
                <?php $response = get_top_posts_by_filters();
                echo $response['html'];
                ?>
            </ol>
        </div>

        <div <?php if ($response['hide_link'] == 'yes') {
            echo 'style="display:none;"';
        } ?>
            onclick="return false;" class="show_more_post"
            data-action="get_top_posts_by_filters"
            data-inner-class=".new_posts"
            data-max-pages="<?php echo $response['max_pages']; ?>"
            data-current-page="<?php echo $response['current_page']; ?>"
            data-filter-date="<?php echo $response['filter_date']; ?>"
            data-filter-soc="<?php echo $response['filter_soc']; ?>"
            data-next-page="<?php echo $response['next_page']; ?>">
            <a href="#" onclick="top_posts.more(this)">Загрузить еще</a>
        </div>
        <script>
            jQuery(document).ready(function ($) {
                $('.show_more_post').off();
            });
        </script>
        <?php //} ?>

    </section>
<?php get_footer(); ?>