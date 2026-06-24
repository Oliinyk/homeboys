/**
 * Home Boys 2 — Admin JS
 *
 * Fixes:
 * 1. Sorts media gallery selections by filename (natural/numeric sort)
 *    so photos come in filename order instead of random/date order.
 *    Runs before Carbon Fields processes the wp.media selection.
 */
;(function ($) {
    'use strict';

    /**
     * Patch wp.media to sort multi-select attachments by filename
     * before Carbon Fields receives them via selection.toJSON().
     */
    function patchWpMedia() {
        if (typeof wp === 'undefined' || typeof wp.media !== 'function') {
            return false;
        }

        var _orig = wp.media;

        wp.media = function (attrs) {
            var frame = _orig.apply(this, arguments);

            // Only intercept multi-select frames (used by cf-media-gallery)
            if (attrs && attrs.multiple) {
                frame.on('select', function () {
                    var selection = frame.state().get('selection');
                    if (!selection || !selection.models) return;

                    // Sort models by filename, numeric-aware
                    // e.g. IMG_9.jpg < IMG_10.jpg (not string-alphabetical)
                    selection.models.sort(function (a, b) {
                        var fa = (a.get('filename') || a.get('title') || '').toLowerCase();
                        var fb = (b.get('filename') || b.get('title') || '').toLowerCase();
                        return fa.localeCompare(fb, undefined, {
                            numeric: true,
                            sensitivity: 'base'
                        });
                    });
                });
            }

            return frame;
        };

        // Copy all static sub-properties (models, views, controllers, frames, …)
        Object.keys(_orig).forEach(function (key) {
            wp.media[key] = _orig[key];
        });

        return true;
    }

    // Try immediately (wp.media might already be loaded)
    if (!patchWpMedia()) {
        // Fallback: retry on DOM ready
        $(document).ready(patchWpMedia);
    }

})(jQuery);
