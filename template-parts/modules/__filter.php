<?php
$filter_exclude_fields = $args['exclude_fields'] ?? [];

$price_range            = hb2_get_all_homes_prices_range();
$size_range             = hb2_get_all_homes_sizes_range();
$beds_range             = hb2_get_all_homes_beds_range();
$baths_range            = hb2_get_all_homes_baths_range();
$width_options          = hb2_get_width_options();
$manufacturers_options  = hb2_get_manufacturers_options();
$series_options         = hb2_get_series_options();

$min_price   = $price_range['min'];
$max_price   = $price_range['max'];

$min_size    = $size_range['min'];
$max_size    = $size_range['max'];

$min_beds    = $beds_range['min'];
$max_beds    = $beds_range['max'];

$min_baths   = $baths_range['min'];
$max_baths   = $baths_range['max'];
?>
<!-- filter -->
<form class="filter-container" method="GET" action="">
    <div class="filter-grid">
        <div class="filter-row">
            <?php
            if ( ! in_array( 'price', $filter_exclude_fields, true ) ) :
                ?>
                <div class="filter-group">
                    <div class="filter-label">Price</div>
                    <div class="value-display">
                        <div class="value-box js-value-display">$ <?php echo number_format($min_price, 0, '.', ','); ?></div>
                        <div class="value-box js-value-display">$ <?php echo number_format($max_price, 0, '.', ','); ?></div>
                    </div>

                    <div class="slider-container">
                        <div class="slider-track"></div>
                        <div class="slider-range js-slider-range"></div>
                        <div class="filter-slider">
                            <input type="range" name="price_min" class="js-range-input" data-type="price" min="<?php echo $min_price; ?>" max="<?php echo $max_price; ?>" value="<?php echo $min_price; ?>" step="1000">
                            <input type="range" name="price_max" class="js-range-input" data-type="price" min="<?php echo $min_price; ?>" max="<?php echo $max_price; ?>" value="<?php echo $max_price; ?>" step="1000">
                        </div>
                    </div>
                </div>
                <?php
            endif;

            if ( ! in_array( 'size', $filter_exclude_fields, true ) ) :
                ?>
                <div class="filter-group">
                    <div class="filter-label">Size</div>
                    <div class="value-display">
                        <div class="value-box js-value-display"><?php echo $min_size; ?> ft²</div>
                        <div class="value-box js-value-display"><?php echo $max_size; ?> ft²</div>
                    </div>
                    <div class="slider-container">
                        <div class="slider-track"></div>
                        <div class="slider-range js-slider-range"></div>
                        <div class="filter-slider">
                            <input type="range" name="size_min" class="js-range-input" data-type="size" min="<?php echo $min_size; ?>" max="<?php echo $max_size; ?>" value="<?php echo $min_size; ?>" step="50">
                            <input type="range" name="size_max" class="js-range-input" data-type="size" min="<?php echo $min_size; ?>" max="<?php echo $max_size; ?>" value="<?php echo $max_size; ?>" step="50">
                        </div>
                    </div>
                </div>
                <?php
            endif;

            if ( ! in_array( 'beds', $filter_exclude_fields, true ) ) :
                ?>
                <div class="counter-group">
                    <div class="filter-label">Beds</div>
                    <div class="counter-container">
                         <button type="button" class="counter-btn arrow-left js-counter-down"></button>
                        <input type="number" name="beds" class="counter-value js-counter-input" max="<?php echo $max_beds; ?>" min="<?php echo $min_beds; ?>" value="<?php echo $min_beds; ?>" readonly>
                        <button type="button" class="counter-btn arrow-right js-counter-up"></button>
                    </div>
                </div>
                <?php
            endif;

            if ( ! in_array( 'baths', $filter_exclude_fields, true ) ) :
                ?>
                <div class="counter-group">
                    <div class="filter-label">Baths</div>
                    <div class="counter-container">
                        <button type="button" class="counter-btn arrow-left js-counter-down"></button>
                        <input type="number" name="baths" class="counter-value js-counter-input" max="<?php echo $max_baths; ?>" min="<?php echo $min_baths; ?>" value="<?php echo $min_baths; ?>" readonly>
                        <button type="button" class="counter-btn arrow-right js-counter-up"></button>
                    </div>
                </div>
                <?php
            endif;
            ?>
        </div>

        <div class="filter-row">
            <?php
            if ( ! in_array( 'width', $filter_exclude_fields, true ) ) :
                ?>
                <div class="filter-group">
                    <div class="filter-label">Wide</div>
                    <select name="width">
                        <?php
                        foreach ( $width_options as $key => $width ) :
                            if ( 0 > $key ) {
                                continue;
                            };
                            ?>
                            <option value="<?php echo esc_attr( $key ); ?>">
                                <?php echo $width; ?>
                            </option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <?php
            endif;

            if ( ! in_array( 'manufacturer', $filter_exclude_fields, true ) ) :
                ?>
                <div class="filter-group">
                    <div class="filter-label">Manufacturer</div>

                    <select name="manufacturer">
                        <?php
                        foreach ( $manufacturers_options as $key => $manufacturer ) :
                            if ( 0 > $key ) {
                                continue;
                            };
                            ?>
                            <option value="<?php echo esc_attr( $key ); ?>">
                                <?php echo $manufacturer; ?>
                            </option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <?php
            endif;

            if ( ! in_array( 'series', $filter_exclude_fields, true ) ) :
                ?>
                <div class="filter-group">
                    <div class="filter-label">Series</div>
                    <select name="series">
                        <?php
                        foreach ( $series_options as $key => $series ) :
                            if ( 0 > $key ) {
                                continue;
                            };
                            ?>
                            <option value="<?php echo esc_attr( $key ); ?>">
                                <?php echo $series; ?>
                            </option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <?php
            endif;

            if ( ! in_array( 'model', $filter_exclude_fields, true ) ) :
                ?>
                <div class="filter-group">
                    <div class="filter-label">Model Number/Name</div>
                    <input type="text" name="model" placeholder="Double" class="filer-input">
                </div>
                <?php
            endif;
            ?>
            <div class="btn-wrap">
                <button type="submit" class="btn submit-btn">Find Your Home</button>
            </div>
        </div>

    </div>
</form>
