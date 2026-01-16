<?php
$block_title       = isset( $args['title'] ) ? $args['title'] : '';
$block_description = isset( $args['description'] ) ? $args['description'] : '';

$query_args = [
    'post_type'      => 'process',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'meta_query'     => [
        [
            'key' => '_process_contacts',
            'compare' => 'EXISTS',
        ],
    ],
];

$processes = new WP_Query( $query_args );

if ( ! $processes->have_posts() ) {
    return;
};

?>
<section class="financing-section dark-section">
    <div class="container">
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
                                        <p class="postfix-text">
                                            <?php echo $phone['pcp_number_postfix']?>
                                        </p>
                                        <?php
                                    endif;    
                                endforeach;

                                foreach( $emails as $key => $email ) :
                                    $e_separate = 0 < $key ? ' or ' : '';
                                    ?>
                                        <?php echo $e_separate;?>

                                        <a href="<?php echo $email['pcp_email']?>">
                                            <?php echo $email['pcp_email']?>
                                        </a>

                                        <?php
                                        if ( ! empty( $email['pcp_email_postfix'] ) ) :
                                            ?>
                                            <p class="postfix-text"><?php echo $email['pcp_email_postfix']?></p>
                                            <?php
                                        endif;
                                        ?>
                                    <?php
                                endforeach;
                                ?>
                            </div><!-- .single-contact-item -->
                            <?php
                        endforeach;
                        ?>
                    </div><!-- .contact-info -->

                    <div class="contact-description">
                        <?php echo $process_desc?>
                    </div><!-- .contact-description -->
                </div><!-- .financing-item -->
                <?php
            endwhile;
            ?>
        </div><!-- .financing-list -->
    </div><!-- .container -->
</section>
<?
wp_reset_postdata();

