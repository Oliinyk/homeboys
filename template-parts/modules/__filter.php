<?php
$filter_exclude_fields = $args['exclude_fields'] ?? [];
?>
<!-- filter -->
<div class="filter-container">
    <div class="filter-grid">
        <div class="filter-row">
            <?php
            if ( ! in_array( 'price', $filter_exclude_fields, true ) ) :
                ?>
                <div class="filter-group">
                    <div class="filter-label">Price</div>
                    <div class="value-display">
                        <div class="value-box" id="priceMin">$ 76,391</div>
                        <div class="value-box" id="priceMax">$ 235,867</div>
                    </div>

                    <div class="slider-container">
                        <div class="slider-track"></div>
                        <div class="slider-range" id="priceRange"></div>
                        <div class="filter-slider">
                            <input type="range" id="priceMinSlider" min="0" max="500000" value="76391" step="1000">
                            <input type="range" id="priceMaxSlider" min="0" max="500000" value="235867" step="1000">
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
                        <div class="value-box" id="sizeMin">800 ft²</div>
                        <div class="value-box" id="sizeMax">2 999 ft²</div>
                    </div>
                    <div class="slider-container">
                        <div class="slider-track"></div>
                        <div class="slider-range" id="sizeRange"></div>
                        <div class="filter-slider">
                            <input type="range" id="sizeMinSlider" min="0" max="5000" value="800" step="50">
                            <input type="range" id="sizeMaxSlider" min="0" max="5000" value="2999" step="50">
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
                        <button class="counter-btn arrow-left" id="bedsDown"></button>
                        <div class="counter-value" id="bedsValue">2</div>
                        <button class="counter-btn arrow-right" id="bedsUp"></button>
                    </div>
                </div>
                <?php
            endif;

            if ( ! in_array( 'baths', $filter_exclude_fields, true ) ) :
                ?>
                <div class="counter-group">
                    <div class="filter-label">Baths</div>
                    <div class="counter-container">
                        <button class="counter-btn arrow-left" id="bathsDown"></button>
                        <div class="counter-value" id="bathsValue">2</div>
                        <button class="counter-btn arrow-right" id="bathsUp"></button>
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
                        <option value="0">Single</option>
                        <option value="1">Double</option>
                        <option value="2">Triple</option>
                    </select>
                </div>
                <?php
            endif;

            if ( ! in_array( 'manufacturer', $filter_exclude_fields, true ) ) :
                ?>
                <div class="filter-group">
                    <div class="filter-label">Manufacturer</div>
                    <select name="manufacturer">
                        <option value="0">Cavco Millersburg (Palm Harbor)</option>
                        <option value="1">Cavco Montevideo (Friendship)</option>
                        <option value="2">Cavco Nampa (Fleetwood)</option>
                        <option value="3">Clayton Homes</option>
                        <option value="4">Golden West</option>
                        <option value="5">Karsten Homes</option>
                        <option value="5">Marlette Homes</option>
                        <option value="6">Schult Homes</option>
                    </select>
                </div>
                <?php
            endif;

            if ( ! in_array( 'series', $filter_exclude_fields, true ) ) :
                ?>
                <div class="filter-group">
                    <div class="filter-label">Series</div>
                    <select name="series">
                        <option value="0">400 Series</option>
                        <option value="1">5000 Series</option>
                        <option value="2">Alpha</option>
                        <option value="3">American Dream</option>
                        <option value="4">Broadmore</option>
                        <option value="5">Canyon View</option>
                        <option value="5">Columbia River</option>
                        <option value="6">Dream Silver</option>
                        <option value="7">Imagine</option>
                        <option value="8">Independence Series</option>
                        <option value="9">Inspiration (Cavco)</option>
                        <option value="10">Insipration Gold</option>
                        <option value="11">Majestic Series</option>
                        <option value="12">Marlette Special</option>
                        <option value="13">McKenzie</option>
                        <option value="14">Olympic Range</option>
                        <option value="15">Patriot</option>
                        <option value="16">Platinum Series</option>
                        <option value="17">Pure Series</option>
                        <option value="18">Rhythm Series</option>
                        <option value="19">Schult Series</option>
                        <option value="20">Siskyou Series</option>
                        <option value="21">Special Series</option>
                        <option value="22">Summit View</option>
                        <option value="23">Tempo</option>
                        <option value="24">Vista (Cavco)</option>
                        <option value="25">Waverly Crest Prestige</option>
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
                <button class="btn submit-btn" id="submitBtn">
                    Find Your Home
                    <svg width="17" height="11" viewBox="0 0 17 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7848 5.09934L6.89478e-08 5.02649L5.60551e-08 6.14349L14.5359 6.16777L10.4788 10.1258L11.3748 11L17 5.51214L17 5.48786L16.104 4.63797L11.3499 -2.71811e-07L10.4539 0.874172L14.7848 5.09934Z" fill="white"></path>
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>
