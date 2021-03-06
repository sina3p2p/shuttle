/*
 * Slugify for Voyager v0.9.0
 *
 * Generates a slug for a given input element.
 * This script was created for Voyager, but works with any HTML structure.
 *
 * Default behavior is to auto generate a new slug, only if the input is empty.
 * If input isn't empty, the auto generation is disabled.
 * To force the auto generator, set the option "forceUpdate: true".
 *
 * Copyright 2017 Bruno Torrinha
 * License MIT
 *
 * Some credits:
 * Char map from: https://github.com/diegok/slugit-jquery
 */
;( function( $, window, document, undefined ) {

    "use strict";

        var pluginName = "slugify",
            defaults = {
                separator:   '-',
                input:       false, // The origin from where we generate the slug.
                forceUpdate: false, // Force update if input is not empty.
                map:         false  // Provide an extra character map translator.
            };

        function Plugin ( element, options ) {
            this.element   = $(element);  // The input where slug is placed.
            this.settings  = $.extend( {}, defaults, options );
            this._defaults = defaults;
            this.chars     = this._load_char_maps();
            if (this.settings.map) {      // Load extra character map translator
                $.extend(this.chars, this.settings.map);
            }
            this.init();
        }

        // Avoid Plugin.prototype conflicts
        $.extend( Plugin.prototype, {
            init: function() {
                this.input = this.settings.input
                             || $(this.element).closest('form').find('input[name="' + this.element.attr("data-slug-origin") + '"]');

                this.forceUpdate = (this.element.data('slug-forceupdate')) ? true : false;
                this.input.on('keyup change', $.proxy(this.onChange, this));

                this.refresh();
            },


            refresh: function() {
                this.element.update = this.element.val() === '';
            },


            /**
             * When input changes
             */
            onChange: function(ev) {
                var code = ev.keyCode ? ev.keyCode : ev.which;

                if (code > 34 && code < 41) {
                    return;
                }

                var strOrigin = $(ev.target).val(),
                    strTarget = this.element.val();

                if (
                    this.element.update
                    || strTarget === ''
                    || (strTarget != '' && this.forceUpdate)
                ){
                    this.element.val(this.slug(strOrigin));
                    this.element.update = true;
                }
                return;
            },


            /**
             * Generate a slug
             */
            slug: function(str) {
                str = str
                    .toString()
                    .toLowerCase();

                var _slug = '',
                    _sep = this.settings.separator;

                // Replace Char Map
                //
                for (var i=0, l=str.length ; i<l ; i++) {
                    _slug += (this.chars[str.charAt(i)])
                             ? this.chars[str.charAt(i)]
                             : str.charAt(i);
                }

                str = _slug
                .replace(/[^a-z0-9]/g, _sep)
                .replace(new RegExp('\\'+_sep+'\\'+_sep+'+', 'g'), _sep)
                .replace(new RegExp('^\\'+_sep+'+|\\'+_sep+'+$', 'g'), '');

                return str;
            },

            _load_char_maps: function() {
                return $.extend(
                            this._map_latin(),
                            this._map_arabic(),
                            this._map_greek(),
                            this._map_turkish(),
                            this._map_russian(),
                            this._map_ukranian(),
                            this._map_czech(),
                            this._map_polish(),
                            this._map_vietnam(),
                            this._map_latvian(),
                            this._map_lithuanian(),
                            this._map_currency(),
                            this._map_symbols(),
                            this._map_georgian()
                        );
            },
            _map_latin: function() {
                return {
                    '??': 'A', '??': 'A', '??': 'A', '??': 'A', '??': 'A', '??': 'A', '??': 'AE', '??':
                    'C', '??': 'E', '??': 'E', '??': 'E', '??': 'E', '??': 'I', '??': 'I', '??': 'I',
                    '??': 'I', '??': 'D', '??': 'N', '??': 'O', '??': 'O', '??': 'O', '??': 'O', '??':
                    'O', '??': 'O', '??': 'O', '??': 'U', '??': 'U', '??': 'U', '??': 'U', '??': 'U',
                    '??': 'Y', '??': 'TH', '??': 'ss', '??':'a', '??':'a', '??': 'a', '??': 'a', '??':
                    'a', '??': 'a', '??': 'ae', '??': 'c', '??': 'e', '??': 'e', '??': 'e', '??': 'e',
                    '??': 'i', '??': 'i', '??': 'i', '??': 'i', '??': 'd', '??': 'n', '??': 'o', '??':
                    'o', '??': 'o', '??': 'o', '??': 'o', '??': 'o', '??': 'o', '??': 'u', '??': 'u',
                    '??': 'u', '??': 'u', '??': 'u', '??': 'y', '??': 'th', '??': 'y'
                };
            },
            _map_arabic:  function() {
              return {
                '??': 'a',
                '??': 'a',
                '??': 'i',
                '??': 'aa',
                '??': 'u',
                '??': 'e',
                '??': 'a',
                '??': 'b',
                '??': 't',
                '??': 'th',
                '??': 'j',
                '??': 'h',
                '??': 'kh',
                '??': 'd',
                '??': 'th',
                '??': 'r',
                '??': 'z',
                '??': 's',
                '??': 'sh',
                '??': 's',
                '??': 'dh',
                '??': 't',
                '??': 'z',
                '??': 'a',
                '??': 'gh',
                '??': 'f',
                '??': 'q',
                '??': 'k',
                '??': 'l',
                '??': 'm',
                '??': 'n',
                '??': 'h',
                '??': 'w',
                '??': 'y',
                '??': 'a',
                '??': 'h',
                '???': 'la',
                '???': 'laa',
                '???': 'lai',
                '???': 'laa',
              };
            },
            _map_georgian:  function() {
                return {
                    '???': 'a',
                    '???': 'sh',
                    '???': 'ch',
                    '???': 'g',
                    '???': 'dz',
                    '???': 't',
                    '???': 'j',
                    '???': 'w',
                    '???': 'ch',
                    '???': 'b',
                    '???': 'c',
                    '???': 'd',
                    '???': 'e',
                    '???': 'f',
                    '???': 'g',
                    '???': 'h',
                    '???': 'i',
                    '???': 'j',
                    '???': 'k',
                    '???': 'l',
                    '???': 'm',
                    '???': 'n',
                    '???': 'o',
                    '???': 'p',
                    '???': 'q',
                    '???': 'r',
                    '???': 's',
                    '???': 't',
                    '???': 'u',
                    '???': 'v',
                    '???': 'x',
                    '???': 'y',
                    '???': 'z'
                };
            },
            _map_greek: function() {
                return {
                    '??':'a', '??':'b', '??':'g', '??':'d', '??':'e', '??':'z', '??':'h', '??':'8',
                    '??':'i', '??':'k', '??':'l', '??':'m', '??':'n', '??':'3', '??':'o', '??':'p',
                    '??':'r', '??':'s', '??':'t', '??':'y', '??':'f', '??':'x', '??':'ps', '??':'w',
                    '??':'a', '??':'e', '??':'i', '??':'o', '??':'y', '??':'h', '??':'w', '??':'s',
                    '??':'i', '??':'y', '??':'y', '??':'i',
                    '??':'A', '??':'B', '??':'G', '??':'D', '??':'E', '??':'Z', '??':'H', '??':'8',
                    '??':'I', '??':'K', '??':'L', '??':'M', '??':'N', '??':'3', '??':'O', '??':'P',
                    '??':'R', '??':'S', '??':'T', '??':'Y', '??':'F', '??':'X', '??':'PS', '??':'W',
                    '??':'A', '??':'E', '??':'I', '??':'O', '??':'Y', '??':'H', '??':'W', '??':'I',
                    '??':'Y'
                };
            },
            _map_turkish: function() {
                return {
                    '??':'s', '??':'S', '??':'i', '??':'I', '??':'c', '??':'C', '??':'u', '??':'U',
                    '??':'o', '??':'O', '??':'g', '??':'G'
                };
            },
            _map_russian: function() {
                return {
                    '??':'a', '??':'b', '??':'v', '??':'g', '??':'d', '??':'e', '??':'yo', '??':'zh',
                    '??':'z', '??':'i', '??':'j', '??':'k', '??':'l', '??':'m', '??':'n', '??':'o',
                    '??':'p', '??':'r', '??':'s', '??':'t', '??':'u', '??':'f', '??':'h', '??':'c',
                    '??':'ch', '??':'sh', '??':'sh', '??':'', '??':'y', '??':'', '??':'e', '??':'yu',
                    '??':'ya',
                    '??':'A', '??':'B', '??':'V', '??':'G', '??':'D', '??':'E', '??':'Yo', '??':'Zh',
                    '??':'Z', '??':'I', '??':'J', '??':'K', '??':'L', '??':'M', '??':'N', '??':'O',
                    '??':'P', '??':'R', '??':'S', '??':'T', '??':'U', '??':'F', '??':'H', '??':'C',
                    '??':'Ch', '??':'Sh', '??':'Sh', '??':'', '??':'Y', '??':'', '??':'E', '??':'Yu',
                    '??':'Ya'
                };
            },
            _map_ukranian: function() {
                return {
                    '??':'Ye', '??':'I', '??':'Yi', '??':'G', '??':'ye', '??':'i', '??':'yi', '??':'g'
                };
            },
            _map_czech: function() {
                return {
                    '??':'c', '??':'d', '??':'e', '??': 'n', '??':'r', '??':'s', '??':'t', '??':'u',
                    '??':'z', '??':'C', '??':'D', '??':'E', '??': 'N', '??':'R', '??':'S', '??':'T',
                    '??':'U', '??':'Z'
                };
            },
            _map_polish: function() {
                return {
                    '??':'a', '??':'c', '??':'e', '??':'l', '??':'n', '??':'o', '??':'s', '??':'z',
                    '??':'z', '??':'A', '??':'C', '??':'e', '??':'L', '??':'N', '??':'o', '??':'S',
                    '??':'Z', '??':'Z'
                };
            },
            _map_vietnam: function() {
                return {
                    '???': 'a','???': 'a','???': 'a','???': 'a','???': 'a','???': 'a','???': 'a','???': 'a',
                    '???': 'a','???': 'a','???': 'a','???': 'a','???': 'e','???': 'e','???': 'e','???': 'e',
                    '???': 'e','???': 'e','???': 'e','???': 'e','???': 'i','???': 'i','???': 'o','???': 'o',
                    '???': 'o','???': 'o','???': 'o','???': 'o','???': 'o','???': 'o','???': 'o','???': 'o',
                    '???': 'o','???': 'o','???': 'u','???': 'u','???': 'u','???': 'u','???': 'u','???': 'u',
                    '???': 'u','???': 'y','???': 'y','???': 'y','???': 'y','???': 'A','???': 'A','???': 'A',
                    '???': 'A','???': 'A','???': 'A','???': 'A','???': 'A','???': 'A','???': 'A','???': 'A',
                    '???': 'A','???': 'E','???': 'E','???': 'E','???': 'E','???': 'E','???': 'E','???': 'E',
                    '???': 'E','???': 'I','???': 'I','???': 'O','???': 'O','???': 'O','???': 'O','???': 'O',
                    '???': 'O','???': 'O','???': 'O','???': 'O','???': 'O','???': 'O','???': 'O','???': 'U',
                    '???': 'U','???': 'U','???': 'U','???': 'U','???': 'U','???': 'U','???': 'Y','???': 'Y',
                    '??': 'd','??': 'D','???': 'Y','???': 'Y','??': 'a','??': 'a','??': 'u','??': 'o',
                    '??': 'u','??': 'o'
                };
            },
            _map_latvian: function() {
                return {
                    '??':'a', '??':'c', '??':'e', '??':'g', '??':'i', '??':'k', '??':'l', '??':'n',
                    '??':'s', '??':'u', '??':'z', '??':'A', '??':'C', '??':'E', '??':'G', '??':'i',
                    '??':'k', '??':'L', '??':'N', '??':'S', '??':'u', '??':'Z'
                };
            },
            _map_lithuanian: function() {
                return {
                    '??':'a', '??':'c', '??':'e', '??':'e', '??':'i', '??':'s', '??':'u', '??':'u',
                    '??':'z', '??':'A', '??':'C', '??':'E', '??':'E', '??':'I', '??':'S', '??':'U',
                    '??':'U', '??':'Z',
                };
            },
            _map_currency: function() {
                return {
                    '???': 'euro', '$': 'dollar', '???': 'cruzeiro', '???': 'french franc', '??': 'pound',
                    '???': 'lira', '???': 'mill', '???': 'naira', '???': 'peseta', '???': 'rupee',
                    '???': 'won', '???': 'new shequel', '???': 'dong', '???': 'kip', '???': 'tugrik',
                    '???': 'drachma', '???': 'penny', '???': 'peso', '???': 'guarani', '???': 'austral',
                    '???': 'hryvnia', '???': 'cedi', '??': 'cent', '??': 'yen', '???': 'yuan',
                    '???': 'yen', '???': 'rial', '???': 'ecu', '??': 'currency', '???': 'baht'
                };
            },
            _map_symbols: function() {
                return {
                    '??':'(c)', '??': 'oe', '??': 'OE', '???': 'sum', '??': '(r)', '???': '+',
                    '???': '"', '???': '"', '???': "'", '???': "'", '???': 'd', '??': 'f', '???': 'tm',
                    '???': 'sm', '???': '...', '??': 'o', '??': 'o', '??': 'a', '???': '*',
                    '???': 'delta', '???': 'infinity', '???': 'love', '&': 'and'
                };
            }
        });

        $.fn[ pluginName ] = function( options ) {
            return this.each( function() {
                if ( !$.data( this, pluginName ) ) {
                    $.data( this, pluginName, new Plugin(this, options) );
                }
            } );
        };

} )( jQuery, window, document );
