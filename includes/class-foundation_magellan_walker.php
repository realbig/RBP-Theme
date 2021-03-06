<?php

if ( ! class_exists( 'Foundation_Magellan_Walker' ) ) {

    class Foundation_Magellan_Walker extends Walker_Page {
        
        /**
         * Outputs the beginning of the current level in the tree before elements are output.
         *
         * @since 2.1.0
         * @access public
         *
         * @see Walker::start_lvl()
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int    $depth  Optional. Depth of page. Used for padding. Default 0.
         * @param array  $args   Optional. Arguments for outputing the next level.
         *                       Default empty array.
         */
        public function start_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class='vertical menu expanded'>\n";
        }

        /**
         * Outputs the beginning of the current element in the tree.
         *
         * @see Walker::start_el()
         * @since 2.1.0
         * @access public
         *
         * @param string  $output       Used to append additional content. Passed by reference.
         * @param WP_Post $page         Page data object.
         * @param int     $depth        Optional. Depth of page. Used for padding. Default 0.
         * @param array   $args         Optional. Array of arguments. Default empty array.
         * @param int     $current_page Optional. Page ID. Default 0.
         */
        public function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
            
            if ( $depth ) {
                $indent = str_repeat( "\t", $depth );
            } else {
                $indent = '';
            }

            $css_class = array( 'page_item', 'page-item-' . $page->ID );

            if ( isset( $args['pages_with_children'][ $page->ID ] ) ) {
                $css_class[] = 'page_item_has_children';
            }

            if ( ! empty( $current_page ) ) {
                $_current_page = get_post( $current_page );
                if ( $_current_page && in_array( $page->ID, $_current_page->ancestors ) ) {
                    $css_class[] = 'current_page_ancestor';
                }
                if ( $page->ID == $current_page ) {
                    $css_class[] = 'current_page_item';
                } elseif ( $_current_page && $page->ID == $_current_page->post_parent ) {
                    $css_class[] = 'current_page_parent';
                }
            } elseif ( $page->ID == get_option('page_for_posts') ) {
                $css_class[] = 'current_page_parent';
            }

            /**
             * Filter the list of CSS classes to include with each page item in the list.
             *
             * @since 2.8.0
             *
             * @see wp_list_pages()
             *
             * @param array   $css_class    An array of CSS classes to be applied
             *                              to each list item.
             * @param WP_Post $page         Page data object.
             * @param int     $depth        Depth of page, used for padding.
             * @param array   $args         An array of arguments.
             * @param int     $current_page ID of the current page.
             */
            $css_classes = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

            if ( '' === $page->post_title ) {
                /* translators: %d: ID of a post */
                $page->post_title = sprintf( __( '#%d (no title)' ), $page->ID );
            }

            $args['link_before'] = empty( $args['link_before'] ) ? '' : $args['link_before'];
            $args['link_after'] = empty( $args['link_after'] ) ? '' : $args['link_after'];

            $output .= $indent . sprintf(
                '<li class="%s"><a href="%s">%s%s%s</a>',
                $css_classes,
                '#' . Foundation_Magellan_Walker::magellan_target( $page->post_title ),
                $args['link_before'],
                /** This filter is documented in wp-includes/post-template.php */
                apply_filters( 'the_title', $page->post_title, $page->ID ),
                $args['link_after']
            );

            if ( ! empty( $args['show_date'] ) ) {
                if ( 'modified' == $args['show_date'] ) {
                    $time = $page->post_modified;
                } else {
                    $time = $page->post_date;
                }

                $date_format = empty( $args['date_format'] ) ? '' : $args['date_format'];
                $output .= " " . mysql2date( $date_format, $time );
            }
        }
        
        public static function magellan_target( $post_title ) {
            
            $target = preg_replace( '/^([0-9]|[a-z])+\./i', '', $post_title );
        
            $target = trim( $target ); // Ensure all extra spaces are out before our replacements
            
            $target = str_replace( ' ', '-', strtolower( $target ) );
            
            return $target;
            
        }

    }

}