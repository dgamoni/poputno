<?php



function manage_post_custom_field_columns($column_name, $id)
{
    switch ($column_name) {
        case 'image':
            echo '<a href="' . admin_url('post.php?post=' . $id . '&action=edit') . '">';

            $images = get_children(array('post_parent' => $id, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 1));
            if ($images) {
                $image = array_shift($images);
                $image_img_tag = wp_get_attachment_image_src($image->ID, 'unithumb-postthumb');
                $img = $image_img_tag[0];
            } else {
                ob_start();
                ob_end_clean();
                $p = get_post($id);
                $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $p->post_content, $matches);
                $img = $matches [1] [0];

            }
            echo '<img width="100" src="' . $img . '" alt="" />';
            echo '</a>';
            break;

    }
}

function add_post_custom_field_columns($columns)
{
    $new_columns['image'] = __('Фото', TEXTDOMAIN);
    return $new_columns + $columns;
}

/**
 * Setup sortable columns
 **/
function manage_post_custom_field_sortable_columns($columns)
{
    $columns['views'] = 'views';
    return $columns;
}

/**
 * Sortable by custom column, change request
 **/
function make_post_custom_field_sortable_request($vars)
{
    if (isset($vars['orderby']) && 'views' == $vars['orderby']) {
        $vars = array_merge($vars, array(
            'meta_key' => 'rc_views',
            'orderby' => 'meta_value_num'
        ));
    }
    return $vars;
}

/**
 * Query filter by category at admin screen
 **/
function add_posts_admin_query_filters($query)
{

    global $post;

    if (get_post_type($post) == 'post') {

        if (isset($_GET['custom_field']) && $_GET['custom_field'] == 'yes') {
            $query->set('meta_query', array(
                array(
                    'key' => 'custom_field',
                    'value' => 'yes'
                )
            ));
        }

    }

}

// Admin screen filters
add_filter('manage_edit-post_columns', 'add_post_custom_field_columns');
add_action('manage_post_posts_custom_column', 'manage_post_custom_field_columns', 10, 2);

// Add sortable columns
add_filter('manage_edit-post_sortable_columns', 'manage_post_custom_field_sortable_columns');
add_filter('request', 'make_post_custom_field_sortable_request');


/*
 * Регистрируем кастомную таксономию 
 * 
 */

    $args = array(

    

        array(
            'slug'       => 'region',
            'post_types' => array(
                'post',
            ),
            'args'       => array(
                'hierarchical'      => true, // false if use tag style
                'show_ui'           => true,
                'labels'            => array(
                    'name'          => __( 'Регион', 'joinup' ),
                    'singular_name' => __( 'Регион', 'joinup' ),
                    'search_items'  => __( 'Найти Вид отдыха', 'joinup' ),
                    'edit_item'     => __( 'Редактировать Регион', 'joinup' ),
                    'update_item'   => __( 'Обновить', 'joinup' ),
                    'add_new_item'  => __( 'Добавить', 'joinup' ),
                    'new_item_name' => __( 'Регион', 'joinup' ),
                    'menu_name'     => __( 'Регион', 'joinup' ),
                ),
                'query_var'         => true,
                'rewrite'           => true,
                'show_in_nav_menus' => true,
                'show_admin_column' => false,
            )
        ),

        array(
            'slug'       => 'budget',
            'post_types' => array(
                'post',
            ),
            'args'       => array(
                'hierarchical'      => true, // false if use tag style
                'show_ui'           => true,
                'labels'            => array(
                    'name'          => __( 'Бюджет', 'joinup' ),
                    'singular_name' => __( 'Бюджет', 'joinup' ),
                    'search_items'  => __( 'Найти', 'joinup' ),
                    'edit_item'     => __( 'Редактировать Бюджет', 'joinup' ),
                    'update_item'   => __( 'Обновить', 'joinup' ),
                    'add_new_item'  => __( 'Добавить', 'joinup' ),
                    'new_item_name' => __( 'Бюджет', 'joinup' ),
                    'menu_name'     => __( 'Бюджет', 'joinup' ),
                ),
                'query_var'         => true,
                //'rewrite'           => true,
                'show_in_nav_menus' => true,
                'show_admin_column' => false,
                'rewrite' => array(
                      'slug' => 'locations', // This controls the base slug that will display before each term
                      'with_front' => true, // Don't display the category base before "/locations/"
                      'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
                    ),
            )
        ),

        array(
            'slug'       => 'transport',
            'post_types' => array(
                'post',
            ),
            'args'       => array(
                'hierarchical'      => true, // false if use tag style
                'show_ui'           => true,
                'labels'            => array(
                    'name'          => __( 'Транспорт', 'joinup' ),
                    'singular_name' => __( 'Транспорт', 'joinup' ),
                    'search_items'  => __( 'Найти Транспорт', 'joinup' ),
                    'edit_item'     => __( 'Редактировать Транспорт', 'joinup' ),
                    'update_item'   => __( 'Обновить', 'joinup' ),
                    'add_new_item'  => __( 'Добавить', 'joinup' ),
                    'new_item_name' => __( 'Транспорт', 'joinup' ),
                    'menu_name'     => __( 'Транспорт', 'joinup' ),
                ),
                'query_var'         => true,
                'rewrite'           => true,
                'show_in_nav_menus' => true,
                'show_admin_column' => false,
            )
        ),

        array(
            'slug'       => 'topic',
            'post_types' => array(
                'post',
            ),
            'args'       => array(
                'hierarchical'      => true, // false if use tag style
                'show_ui'           => true,
                'labels'            => array(
                    'name'          => __( 'Темы', 'joinup' ),
                    'singular_name' => __( 'Темы', 'joinup' ),
                    'search_items'  => __( 'Найти Темы', 'joinup' ),
                    'edit_item'     => __( 'Редактировать Темы', 'joinup' ),
                    'update_item'   => __( 'Обновить', 'joinup' ),
                    'add_new_item'  => __( 'Добавить', 'joinup' ),
                    'new_item_name' => __( 'Темы', 'joinup' ),
                    'menu_name'     => __( 'Темы', 'joinup' ),
                ),
                'query_var'         => true,
                'rewrite'           => true,
                'show_in_nav_menus' => true,
                'show_admin_column' => false,
            )
        ),

    
    );

    $taxonomies = new AS_Taxonomies( $args );

    /**
     * Класс для работы со всеми кастомными пост тайпами темы
     *
     * 
     */
    class AS_Taxonomies {

        protected $taxonomies;

        function __construct( $args ) {

            $this->taxonomies = $args;

            $this->init();

        }

        public function init() {

            $taxonomies = $this->taxonomies;

            if ( is_array( $taxonomies ) && ! empty( $taxonomies ) ) {

                foreach ( $taxonomies as $taxonomy ) {

                    $this->register( $taxonomy['slug'], $taxonomy['post_types'], $taxonomy['args'] );

                }

            }

        }

        public function register(
            $slug,
            $post_types,
            $args
        ) {

            register_taxonomy( $slug, $post_types, $args );

        }

    }

 



