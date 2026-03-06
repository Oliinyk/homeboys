<?php
$block_title       = isset( $args['title'] ) ? $args['title'] : '';
$block_description = isset( $args['description'] ) ? $args['description'] : '';

add_filter('posts_clauses', 'process_order_sorting', 10, 2);

function process_order_sorting($clauses, $query) {
    if ( ! is_admin() && $query->get('post_type') === 'process' ) {
        global $wpdb;
        $clauses['join'] .= "
            LEFT JOIN {$wpdb->postmeta} AS pm_order
            ON ({$wpdb->posts}.ID = pm_order.post_id
            AND pm_order.meta_key = '_process_order')
        ";

        $clauses['orderby'] = "
            COALESCE(pm_order.meta_value+0, 999999) ASC,
            {$wpdb->posts}.post_title ASC
        ";
    }

    return $clauses;
}

$query_args = [
    'post_type'      => 'process',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
];

$processes = new WP_Query( $query_args );

if ( ! $processes->have_posts() ) {
    return;
};

?>
<section class="financing-section dark-section">
    <div class="container">
        <ul class="breadcrumbs">
            <li class="crumb-item">
                <a href="#">PROCESS</a>
            </li>

            <li class="crumb-item">
                <span>
                    <?php echo esc_html( get_the_title() ); ?>
                </span>
            </li>
        </ul>

        <?php
        if ( ! empty( $block_title ) ) :
            ?>
            <h1 class="title-section">
                <?php echo $block_title?>
            </h1>
            <?php
        endif;

        if ( ! empty( $block_description ) ) :
            ?>
            <div class="section-description text-center">
                <?php echo $block_description ?>
            </div>
            <?php
        endif;
        ?>
        <div class="financing-list card-list sm-col-2 md-col-3">
            <?php
            while( $processes->have_posts() ) :
                $processes->the_post();

                $process_Id   = get_the_ID();
                $contacts     = carbon_get_post_meta( $process_Id, 'process_contacts' );
                $process_desc = carbon_get_post_meta( $process_Id, 'process_description' );
                ?>
                <div class="financing-item">
                    <h3 class="item-title"><?php the_title()?></h3>

                    <div class="contact-info">
                        <?php
                        foreach ( $contacts as $contact ) :
                            $name   = $contact['p_contact_name'];
                            $phones = $contact['p_contact_phones'];
                            $emails = $contact['p_contact_emails'];
                            ?>
                            <div class="single-contact-item">
                                <?php
                                if ( ! empty( $name ) ) :
                                    ?>
                                    <span><?php echo $name?></span>
                                    <?php
                                endif;

                                foreach( $phones as $key => $phone ) :
                                    $ph_separate = 0 < $key ? ' or ' : '';
                                    ?>
                                        <?php echo $ph_separate;?>

                                        <a href="tel:<?php echo $phone['pcp_number']?>">
                                            <?php echo $phone['pcp_number']?>
                                        </a>
                                    <?php
                                    if ( ! empty( $phone['pcp_number_postfix'] ) ) :
                                        ?>
                                        <span class="postfix-text">
                                            <?php echo $phone['pcp_number_postfix']?>
                                        </span>
                                        <?php
                                    endif;    
                                endforeach;

                                foreach( $emails as $key => $email ) :
                                    $e_separate = 0 < $key ? ' or ' : '';
                                    
                                    $href_before = $email['pcp_is_site'] ? 'https://' : 'mailto:';
                                    ?>
                                        <?php echo $e_separate;?>

                                        <a href="<?php echo $href_before . $email['pcp_email']?>">
                                            <?php echo $email['pcp_email']?>
                                        </a>

                                        <?php
                                        if ( ! empty( $email['pcp_email_postfix'] ) ) :
                                            ?>
                                            <span class="postfix-text">
                                                <?php echo $email['pcp_email_postfix']?>
                                            </span>
                                            <?php
                                        endif;
                                        ?>
                                    <?php
                                endforeach;
                                ?>
                            </div>
                            <?php
                        endforeach;
                        ?>
                    </div>

                    <div class="contact-description">
                        <?php echo $process_desc?>
                    </div>
                </div>
                <?php
            endwhile;
            ?>
        </div>
    </div>
</section>
<?php
wp_reset_postdata();

