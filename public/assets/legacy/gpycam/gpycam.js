(function(window) {
// declare error types

// inheritance pattern here:
// https://stackoverflow.com/questions/783818/how-do-i-create-a-custom-error-in-javascript
    function FlashError() {
        var temp = Error.apply(this, arguments);
        temp.name = this.name = "FlashError";
        this.stack = temp.stack;
        this.message = temp.message;
    }

    function GpycamError() {
        var temp = Error.apply(this, arguments);
        temp.name = this.name = "GpycamError";
        this.stack = temp.stack;
        this.message = temp.message;
    }

    IntermediateInheritor = function() {};
    IntermediateInheritor.prototype = Error.prototype;

    FlashError.prototype = new IntermediateInheritor();
    GpycamError.prototype = new IntermediateInheritor();

    var Gpycam = {
        version: '0.0.1',

        // globals
        protocol: location.protocol.match(/https/i) ? 'https' : 'http',
        loaded: false,   // true when gpycam movie finishes loading
        live: false,     // true when gpycam is initialized and ready to snap

        params: {
            width: 0,
            height: 0,
            dest_width: 0,         // size of captured image
            dest_height: 0,        // these default to width/height
            image_format: 'jpeg',  // image format (may be jpeg or png)
            jpeg_quality: 90,      // jpeg image quality from 0 (worst) to 100 (best)
            flip_horiz: false,     // flip image horiz (mirror mode)
            fps: 30,               // camera frames per second
            resource_url: '',
            constraints: null,     // custom user media constraints,
            swfURL: '',            // URI to GpyWebCam.swf movie (defaults to the js location)
            cameraIdx: -1,
            flashNotDetectedText: '您的浏览器不支持flash player。'
        },

        errors: {
            FlashError: FlashError,
            GpycamError: GpycamError
        },

        hooks: {}, // callback hook functions

        init: function() {
            // initialize
        },

        attach: function(elem) {
            // create gpycam preview and attach to DOM element
            // pass in actual DOM reference, ID, or CSS selector
            if (typeof(elem) == 'string') {
                elem = document.getElementById(elem) || document.querySelector(elem);
            }
            if (!elem) {
                return this.dispatch('error', new GpycamError("Could not locate DOM element to attach to."));
            }
            this.container = elem;
            elem.innerHTML = ''; // start with empty element

            // insert "peg" so we can insert our preview canvas adjacent to it later on
            var peg = document.createElement('div');
            elem.appendChild( peg );
            this.peg = peg;

            // set width/height if not already set
            if (!this.params.width) this.params.width = elem.offsetWidth;
            if (!this.params.height) this.params.height = elem.offsetHeight;

            // make sure we have a nonzero width and height at this point
            if (!this.params.width || !this.params.height) {
                return this.dispatch('error', new GpycamError("No width and/or height for gpycam.  Please call set() first, or attach to a visible element."));
            }

            // set defaults for dest_width / dest_height if not set
            if (!this.params.dest_width) this.params.dest_width = this.params.width;
            if (!this.params.dest_height) this.params.dest_height = this.params.height;

            // check for default fps
            if (typeof this.params.fps !== "number") this.params.fps = 30;

            // adjust scale if dest_width or dest_height is different
            var scaleX = this.params.width / this.params.dest_width;
            var scaleY = this.params.height / this.params.dest_height;

            // flash fallback
            window.Gpycam = Gpycam; // needed for flash-to-js interface
            var div = document.createElement('div');
            div.innerHTML = this.getSWFHTML();
            elem.appendChild( div );

            // setup final crop for live preview
            if (this.params.crop_width && this.params.crop_height) {
                var scaled_crop_width = Math.floor( this.params.crop_width * scaleX );
                var scaled_crop_height = Math.floor( this.params.crop_height * scaleY );

                elem.style.width = '' + scaled_crop_width + 'px';
                elem.style.height = '' + scaled_crop_height + 'px';
                elem.style.overflow = 'hidden';

                elem.scrollLeft = Math.floor( (this.params.width / 2) - (scaled_crop_width / 2) );
                elem.scrollTop = Math.floor( (this.params.height / 2) - (scaled_crop_height / 2) );
            }
            else {
                // no crop, set size to desired
                elem.style.width = '' + this.params.width + 'px';
                elem.style.height = '' + this.params.height + 'px';
            }
        },

        reset: function() {
            // attempt to fix issue #64
            this.unflip();

            if (this.getMovie() && this.getMovie()._releaseCamera) {
                // call for turn off camera in flash
                this.getMovie()._releaseCamera();
            }

            if (this.container) {
                this.container.innerHTML = '';
                delete this.container;
            }

            this.loaded = false;
            this.live = false;
        },

        set: function() {
            // set one or more params
            // variable argument list: 1 param = hash, 2 params = key, value
            if (arguments.length == 1) {
                for (var key in arguments[0]) {
                    this.params[key] = arguments[0][key];
                }
            }
            else {
                this.params[ arguments[0] ] = arguments[1];
            }
        },

        on: function(name, callback) {
            // set callback hook
            name = name.replace(/^on/i, '').toLowerCase();
            if (!this.hooks[name]) this.hooks[name] = [];
            this.hooks[name].push( callback );
        },

        off: function(name, callback) {
            // remove callback hook
            name = name.replace(/^on/i, '').toLowerCase();
            if (this.hooks[name]) {
                if (callback) {
                    // remove one selected callback from list
                    var idx = this.hooks[name].indexOf(callback);
                    if (idx > -1) this.hooks[name].splice(idx, 1);
                }
                else {
                    // no callback specified, so clear all
                    this.hooks[name] = [];
                }
            }
        },

        dispatch: function() {
            // fire hook callback, passing optional value to it
            var name = arguments[0].replace(/^on/i, '').toLowerCase();
            var args = Array.prototype.slice.call(arguments, 1);

            if (this.hooks[name] && this.hooks[name].length) {
                for (var idx = 0, len = this.hooks[name].length; idx < len; idx++) {
                    var hook = this.hooks[name][idx];

                    if (typeof(hook) == 'function') {
                        // callback is function reference, call directly
                        hook.apply(this, args);
                    }
                    else if ((typeof(hook) == 'object') && (hook.length == 2)) {
                        // callback is PHP-style object instance method
                        hook[0][hook[1]].apply(hook[0], args);
                    }
                    else if (window[hook]) {
                        // callback is global function name
                        window[ hook ].apply(window, args);
                    }
                } // loop
                return true;
            }
            else if (name == 'error') {
                if ((args[0] instanceof FlashError) || (args[0] instanceof GpycamError)) {
                    message = args[0].message;
                } else {
                    message = "Could not access gpycam: " + args[0].name + ": " +
                        args[0].message + " " + args[0].toString();
                }

                // default error handler if no custom one specified
                alert("Gpycam.js Error: " + message);
            }

            return false; // no hook defined
        },

        setSWFLocation: function(value) {
            // for backward compatibility.
            this.set('swfURL', value);
        },

        detectFlash: function() {
            // return true if browser supports flash, false otherwise
            // Code snippet borrowed from: https://github.com/swfobject/swfobject
            var SHOCKWAVE_FLASH = "Shockwave Flash",
                SHOCKWAVE_FLASH_AX = "ShockwaveFlash.ShockwaveFlash",
                FLASH_MIME_TYPE = "application/x-shockwave-flash",
                win = window,
                nav = navigator,
                hasFlash = false;

            if (typeof nav.plugins !== "undefined" && typeof nav.plugins[SHOCKWAVE_FLASH] === "object") {
                var desc = nav.plugins[SHOCKWAVE_FLASH].description;
                if (desc && (typeof nav.mimeTypes !== "undefined" && nav.mimeTypes[FLASH_MIME_TYPE] && nav.mimeTypes[FLASH_MIME_TYPE].enabledPlugin)) {
                    hasFlash = true;
                }
            }
            else if (typeof win.ActiveXObject !== "undefined") {
                try {
                    var ax = new ActiveXObject(SHOCKWAVE_FLASH_AX);
                    if (ax) {
                        var ver = ax.GetVariable("$version");
                        if (ver) hasFlash = true;
                    }
                }
                catch (e) {;}
            }

            return hasFlash;
        },

        getSWFHTML: function() {
            // Return HTML for embedding flash based gpycam capture movie
            var html = '',
                swfURL = this.params.swfURL;

            // make sure we aren't running locally (flash doesn't work)
            if (location.protocol.match(/file/)) {
                this.dispatch('error', new FlashError("Flash does not work from local disk.  Please run from a web server."));
                return '<h3 style="color:red">ERROR: the Gpycam.js Flash fallback does not work from local disk.  Please run it from a web server.</h3>';
            }

            // make sure we have flash
            if (!this.detectFlash()) {
                this.dispatch('error', new FlashError("Adobe Flash Player not found.  Please install from get.adobe.com/flashplayer and try again."));
                return '<h3 style="color:red">' + this.params.flashNotDetectedText + '</h3>';
            }

            // set default swfURL if not explicitly set
            if (!swfURL) {
                // find our script tag, and use that base URL
                var base_url = '';
                var scpts = document.getElementsByTagName('script');
                for (var idx = 0, len = scpts.length; idx < len; idx++) {
                    var src = scpts[idx].getAttribute('src');
                    if (src && src.match(/\/gpycam(\.min)?\.js/)) {
                        base_url = src.replace(/\/gpycam(\.min)?\.js.*$/, '');
                        idx = len;
                    }
                }
                if (base_url) swfURL = base_url + '/GpyWebCam.swf';
                else swfURL = 'GpyWebCam.swf';
            }

            // if this is the user's first visit, set flashvar so flash privacy settings panel is shown first
            if (window.localStorage && !localStorage.getItem('visited')) {
                this.params.new_user = 1;
                localStorage.setItem('visited', 1);
            }

            // construct flashvars string
            var flashvars = '';
            for (var key in this.params) {
                if (flashvars) flashvars += '&';
                flashvars += key + '=' + escape(this.params[key]);
            }

            // construct object/embed tag
            html += '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" type="application/x-shockwave-flash" codebase="'+this.protocol+'://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="'+this.params.width+'" height="'+this.params.height+'" id="gpycam_movie_obj" align="middle"><param name="wmode" value="opaque" /><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="false" /><param name="movie" value="'+swfURL+'" /><param name="loop" value="false" /><param name="menu" value="false" /><param name="quality" value="best" /><param name="bgcolor" value="#ffffff" /><param name="flashvars" value="'+flashvars+'"/><embed id="gpycam_movie_embed" src="'+swfURL+'" wmode="opaque" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="'+this.params.width+'" height="'+this.params.height+'" name="gpycam_movie_embed" align="middle" allowScriptAccess="always" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="'+flashvars+'"></embed></object>';

            return html;
        },

        getMovie: function() {
            // get reference to movie object/embed in DOM
            if (!this.loaded) return this.dispatch('error', new FlashError("Flash Movie is not loaded yet"));
            var movie = document.getElementById('gpycam_movie_obj');
            if (!movie || !movie._snap) movie = document.getElementById('gpycam_movie_embed');
            if (!movie) this.dispatch('error', new FlashError("Cannot locate Flash movie in DOM"));
            return movie;
        },

        flip: function() {
            // flip container horiz (mirror mode) if desired
            if (this.params.flip_horiz) {
                var sty = this.container.style;
                sty.webkitTransform = 'scaleX(-1)';
                sty.mozTransform = 'scaleX(-1)';
                sty.msTransform = 'scaleX(-1)';
                sty.oTransform = 'scaleX(-1)';
                sty.transform = 'scaleX(-1)';
                sty.filter = 'FlipH';
                sty.msFilter = 'FlipH';
            }
        },

        unflip: function() {
            // unflip container horiz (mirror mode) if desired
            if (this.params.flip_horiz) {
                var sty = this.container.style;
                sty.webkitTransform = 'scaleX(1)';
                sty.mozTransform = 'scaleX(1)';
                sty.msTransform = 'scaleX(1)';
                sty.oTransform = 'scaleX(1)';
                sty.transform = 'scaleX(1)';
                sty.filter = '';
                sty.msFilter = '';
            }
        },

        savePreview: function(user_callback, user_canvas) {
            // save preview freeze and fire user callback
            var params = this.params;
            var canvas = this.preview_canvas;
            var context = this.preview_context;

            // render to user canvas if desired
            if (user_canvas) {
                var user_context = user_canvas.getContext('2d');
                user_context.drawImage( canvas, 0, 0 );
            }

            // fire user callback if desired
            user_callback(
                user_canvas ? null : canvas.toDataURL('image/' + params.image_format, params.jpeg_quality / 100 ),
                canvas,
                context
            );

        },

        rotateImage: function() {
            this.getMovie()._rotateImage();
        },

        editImage: function() {
            this.getMovie()._editImage();
        },

        clipImage: function() {
            this.getMovie()._clipImage();
        },

        zoomInImage: function() {
            this.getMovie()._zoomIn();
        },

        zoomOutImage: function() {
            this.getMovie()._zoomOut();
        },

        snap: function() {
            this.getMovie()._snap();
        },

        resetCamera: function() {
            this.getMovie()._resetCamera();
            if (this.container) {
                this.container.innerHTML = '';
                delete this.container;
            }

            this.loaded = false;
            this.live = false;
        },

        exportImageData: function(cb) {
            var b64_imgs = this.getMovie()._export();
            var prefix = 'data:image/'+this.params.image_format+';base64,';
            if (typeof b64_imgs == 'string') {
                cb(prefix + b64_imgs);
            } else {
                cb(prefix + b64_imgs[0], prefix + b64_imgs[1]);
            }
        },

        snapExport: function(user_callback, user_canvas) {
            // take snapshot and return image data uri
            var self = this;
            var params = this.params;

            if (!this.loaded) return this.dispatch('error', new GpycamError("Gpycam is not loaded yet"));
            // if (!this.live) return this.dispatch('error', new GpycamError("Gpycam is not live yet"));
            if (!user_callback) return this.dispatch('error', new GpycamError("Please provide a callback function or canvas to snap()"));

            // if we have an active preview freeze, use that
            if (this.preview_active) {
                this.savePreview( user_callback, user_canvas );
                return null;
            }

            // create offscreen canvas element to hold pixels
            var canvas = document.createElement('canvas');
            if (window.G_vmlCanvasManager)
                G_vmlCanvasManager.initElement(canvas);
            canvas.width = this.params.dest_width;
            canvas.height = this.params.dest_height;
            var context = canvas.getContext('2d');

            // flip canvas horizontally if desired
            if (this.params.flip_horiz) {
                context.translate( params.dest_width, 0 );
                context.scale( -1, 1 );
            }

            // create inline function, called after image load (flash) or immediately (native)
            var func = function() {
                // render image if needed (flash)
                if (this.src && this.width && this.height) {
                    context.drawImage(this, 0, 0, params.dest_width, params.dest_height);
                }

                // crop if desired
                if (params.crop_width && params.crop_height) {
                    var crop_canvas = document.createElement('canvas');
                    crop_canvas.width = params.crop_width;
                    crop_canvas.height = params.crop_height;
                    var crop_context = crop_canvas.getContext('2d');

                    crop_context.drawImage( canvas,
                        Math.floor( (params.dest_width / 2) - (params.crop_width / 2) ),
                        Math.floor( (params.dest_height / 2) - (params.crop_height / 2) ),
                        params.crop_width,
                        params.crop_height,
                        0,
                        0,
                        params.crop_width,
                        params.crop_height
                    );

                    // swap canvases
                    context = crop_context;
                    canvas = crop_canvas;
                }

                // render to user canvas if desired
                if (user_canvas) {
                    var user_context = user_canvas.getContext('2d');
                    user_context.drawImage( canvas, 0, 0 );
                }

                // fire user callback if desired
                user_callback(
                    user_canvas ? null : canvas.toDataURL('image/' + params.image_format, params.jpeg_quality / 100 ),
                    canvas,
                    context
                );
            };

            // flash fallback
            var raw_data = this.getMovie()._snap();
            // render to image, fire callback when complete
            var img = new Image();
            img.onload = func;
            img.src = 'data:image/'+this.params.image_format+';base64,' + raw_data;

            return null;
        },

        configure: function(panel) {
            // open flash configuration panel -- specify tab name:
            // "camera", "privacy", "default", "localStorage", "microphone", "settingsManager"
            if (!panel) panel = "camera";
            this.getMovie()._configure(panel);
        },

        flashNotify: function(type, msg) {
            // receive notification from flash about event
            switch (type) {
                case 'flashLoadComplete':
                    // movie loaded successfully
                    this.loaded = true;
                    this.dispatch('load');
                    break;

                case 'cameraLive':
                    // camera is live and ready to snap
                    this.live = true;
                    this.dispatch('live');
                    break;

                case 'error':
                    // Flash error
                    this.dispatch('error', new FlashError(msg));
                    break;

                default:
                    // catch-all event, just in case
                    // console.log("gpycam flash_notify: " + type + ": " + msg);
                    break;
            }
        },

        setCameras: function(cameraNames, selected) {
            var ele = document.getElementById('videoSource');
            if (ele && ele.options.length == 0) {
                var self = this;
                for(var i=0; i<cameraNames.length; i++){
                    var opt = new Option(cameraNames[i], i);
                    ele.options.add(opt);
                }
                ele.onchange = function(){
                    self.changeCamera(ele.value);
                }
            }
            console.log(cameraNames);
            console.log(selected);
        },

        changeCamera: function(selected) {
            this.getMovie()._selectCamera(selected);
        },

        b64ToUint6: function(nChr) {
            // convert base64 encoded character to 6-bit integer
            // from: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Base64_encoding_and_decoding
            return nChr > 64 && nChr < 91 ? nChr - 65
                : nChr > 96 && nChr < 123 ? nChr - 71
                : nChr > 47 && nChr < 58 ? nChr + 4
                : nChr === 43 ? 62 : nChr === 47 ? 63 : 0;
        },

        base64DecToArr: function(sBase64, nBlocksSize) {
            // convert base64 encoded string to Uintarray
            // from: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Base64_encoding_and_decoding
            var sB64Enc = sBase64.replace(/[^A-Za-z0-9\+\/]/g, ""), nInLen = sB64Enc.length,
                nOutLen = nBlocksSize ? Math.ceil((nInLen * 3 + 1 >> 2) / nBlocksSize) * nBlocksSize : nInLen * 3 + 1 >> 2,
                taBytes = new Uint8Array(nOutLen);

            for (var nMod3, nMod4, nUint24 = 0, nOutIdx = 0, nInIdx = 0; nInIdx < nInLen; nInIdx++) {
                nMod4 = nInIdx & 3;
                nUint24 |= this.b64ToUint6(sB64Enc.charCodeAt(nInIdx)) << 18 - 6 * nMod4;
                if (nMod4 === 3 || nInLen - nInIdx === 1) {
                    for (nMod3 = 0; nMod3 < 3 && nOutIdx < nOutLen; nMod3++, nOutIdx++) {
                        taBytes[nOutIdx] = nUint24 >>> (16 >>> nMod3 & 24) & 255;
                    }
                    nUint24 = 0;
                }
            }
            return taBytes;
        }

    };

    Gpycam.init();

    if (typeof define === 'function' && define.amd) {
        define( function() { return Gpycam; } );
    }
    else if (typeof module === 'object' && module.exports) {
        module.exports = Gpycam;
    }
    else {
        window.Gpycam = Gpycam;
    }

}(window));
