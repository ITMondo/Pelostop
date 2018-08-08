/**
@author Matt Crinklaw-Vogt (tantaman)
*/
(function( $ ) {
	if (!$.event.special.destroyed) {
		$.event.special.destroyed = {
		    remove: function(o) {
		    	if (o.handler) {
		    		o.handler();
		    	}
		    }
		}
	}

	function ctrlPtComparator(l,r) {
		return l.position - r.position;
	}

	function bind(fn, ctx) {
		if (typeof fn.bind === "function") {
			return fn.bind(ctx);
		} else {
			return function() {
				fn.apply(ctx, arguments);
			}
		}
	}

	var browserPrefix = "";
	var agent = window.navigator.userAgent;
	if (agent.indexOf('WebKit') >= 0)
		browserPrefix = "-webkit-"
	else if (agent.indexOf('Mozilla') >= 0)
		browserPrefix = "-moz-"
	else if (agent.indexOf('Microsoft') >= 0)
		browserPrefix = "-ms-"
	else
		browserPrefix = ""

	function GradientSelection($el, opts) {
		this.$el = $el;
		this.$el.css("position", "relative");
		this.opts = opts;

		var $preview = $("<canvas class='gradientPicker-preview'></canvas>");
		this.$el.append($preview);
		var canvas = $preview[0];
        canvas.width = this.opts.previewWidth;
        canvas.height = this.opts.previewHeight;
		this.g2d = canvas.getContext("2d");

		var $ctrlPtContainer = $("<div class='gradientPicker-ctrlPts'></div>");
		$ctrlPtContainer.css("width", this.opts.previewWidth);
		this.$el.append($ctrlPtContainer)
		this.$ctrlPtContainer = $ctrlPtContainer;

		this.updatePreview = bind(this.updatePreview, this);
		this.controlPoints = [];
		this.ctrlPtConfig = new ControlPtConfig(this.$el, opts);
		for (var i = 0; i < opts.controlPoints.length; ++i) {
			var ctrlPt = this.createCtrlPt(opts.controlPoints[i]);
			this.controlPoints.push(ctrlPt);
		}
		this._maybeLockCtrlPoints();

		this.docClicked = bind(this.docClicked, this);
		this.destroyed = bind(this.destroyed, this);
		$(document).bind("click", this.docClicked);
		this.$el.bind("destroyed", this.destroyed);
		this.previewClicked = bind(this.previewClicked, this);
		$preview.click(this.previewClicked);

		this.updatePreview();
	}

	GradientSelection.prototype = {
		docClicked: function() {
			this.ctrlPtConfig.hide();
		},

		createCtrlPt: function(ctrlPtSetup) {
			return new ControlPoint(this.$ctrlPtContainer, ctrlPtSetup, this.opts.orientation, this, this.ctrlPtConfig)
		},

		destroyed: function() {
			$(document).unbind("click", this.docClicked);
		},

		updateOptions: function(opts) {
			$.extend(this.opts, opts);
			this.updatePreview();
		},

		updatePreview: function() {
			var result = [];
			this.controlPoints.sort(ctrlPtComparator);
			var grad = this.g2d.createLinearGradient(0, 0, this.g2d.canvas.width, 0);
			for (var i = 0; i < this.controlPoints.length; ++i) {
				var pt = this.controlPoints[i];
				grad.addColorStop(pt.position, pt.color);
				result.push({
					position: pt.position,
					color: pt.color
				});
			}

			this.g2d.fillStyle = grad;
			this.g2d.fillRect(0, 0, this.g2d.canvas.width, this.g2d.canvas.height);

			if (this.opts.generateStyles)
				var styles = this._generatePreviewStyles();

			this.opts.change(result, this.$el, styles);
		},

		removeControlPoint: function(ctrlPt) {
			if (this.ctrlPointsIsLocked) {
				return;
			}

			var cpidx = this.controlPoints.indexOf(ctrlPt);

			if (cpidx != -1) {
				this.controlPoints.splice(cpidx, 1);
				ctrlPt.$el.remove();
			}

			this._maybeLockCtrlPoints();
		},

		previewClicked: function(e) {
			var offset = $(e.target).offset();
			var x = e.pageX - offset.left;
			var y = e.pageY - offset.top;

			var imgData = this.g2d.getImageData(x,y,1,1);
			var colorStr = "rgb(" + imgData.data[0] + "," + imgData.data[1] + "," + imgData.data[2] + ")";

			var cp = this.createCtrlPt({
				position: x / this.g2d.canvas.width,
				color: colorStr
			});

			this.controlPoints.push(cp);
			this.controlPoints.sort(ctrlPtComparator);
			this._maybeLockCtrlPoints();
		},

		_generatePreviewStyles: function() {
			//linear-gradient(top, rgb(217,230,163) 86%, rgb(227,249,159) 9%)
			var str = this.opts.type + "-gradient(" + ((this.opts.type == "linear") ? (this.opts.fillDirection + ", ") : "");
			var first = true;
			for (var i = 0; i < this.controlPoints.length; ++i) {
				var pt = this.controlPoints[i];
				if (!first) {
					str += ", ";
				} else {
					first = false;
				}
				str += pt.color + " " + ((pt.position*100)|0) + "%";
			}

			str = str + ")"
			var styles = [str, browserPrefix + str];
			return styles;
		},

        _maybeLockCtrlPoints: function() {
            if (this.controlPoints.length <= this.opts.minCtrlPts) {
                this.ctrlPtConfig.lockCtrlPoints();
                this.ctrlPointsIsLocked = true;
            } else {
                this.ctrlPtConfig.unlockCtrlPoints();
                this.ctrlPointsIsLocked = false;
            }
        }
	};

	function ControlPoint($parentEl, initialState, orientation, listener, ctrlPtConfig) {
		this.$el = $("<div class='gradientPicker-ctrlPt'></div>");
		$parentEl.append(this.$el);
		this.$parentEl = $parentEl;
		this.configView = ctrlPtConfig;

		if (typeof initialState === "string") {
			initialState = initialState.split(" ");
			this.position = parseFloat(initialState[1])/100;
			this.color = initialState[0];
		} else {
			this.position = initialState.position;
			this.color = initialState.color;
		}

		this.listener = listener;
		this.outerWidth = this.$el.outerWidth();

		this.$el.css("background-color", this.color);
		if (orientation == "horizontal") {
			var pxLeft = ($parentEl.width() - this.$el.outerWidth()) * (this.position);
			this.$el.css("left", pxLeft);
		} else {
			var pxTop = ($parentEl.height() - this.$el.outerHeight()) * (this.position);
			this.$el.css("top", pxTop);
		}
		
		this.drag = bind(this.drag, this);
		this.stop = bind(this.stop, this);
		this.clicked = bind(this.clicked, this);
		this.colorChanged = bind(this.colorChanged, this);
		this.$el.draggable({
			axis: (orientation == "horizontal") ? "x" : "y",
			drag: this.drag,
			stop: this.stop,
			containment: $parentEl
		});
		this.$el.css("position", 'absolute');
		this.$el.click(this.clicked);
	}

	ControlPoint.prototype = {
		changePosition: function(position) {
			this.position = position;
			this.listener.updatePreview();
			this.$el.css('left', this.position * (this.$parentEl.width() - this.outerWidth));
		},

		drag: function(e, ui) {
			// convert position to a %
			var left = ui.position.left;
			this.position = (left / (this.$parentEl.width() - this.outerWidth));
			this.listener.updatePreview();
			this.configView.setPosition(this.position);
		},

		stop: function(e, ui) {
			this.listener.updatePreview();
			this.configView.show(this.$el.position(), this.color, this);
		},

		clicked: function(e) {
			this.configView.show(this.$el.position(), this.color, this);
			e.stopPropagation();
			return false;
		},

		colorChanged: function(c) {
			this.color = c;
			this.$el.css("background-color", this.color);
			this.listener.updatePreview();
		},

		removeClicked: function() {
			this.listener.removeControlPoint(this);
			this.listener.updatePreview();
		}
	};

	function ControlPtConfig($parent, opts) {
		//color-chooser
		this.$el = $('<div class="gradientPicker-ptConfig" style="visibility: hidden"></div>');
		$parent.append(this.$el);
		var $cpicker = $('<input class="color-chooser"></input>');
		this.$el.append($cpicker);
		var $rmEl = $("<div class='gradientPicker-close'></div>");
		this.$el.append($rmEl);

		this.colorChanged = bind(this.colorChanged, this);
		this.removeClicked = bind(this.removeClicked, this);
        $cpicker.alphaColorPicker();
        $cpicker.wpColorPicker("option", "clear", false);
		var $wpColorPickerInstance = $cpicker.wpColorPicker("instance");
		var originChangeCallback = $wpColorPickerInstance.options.change;
		var self = this;
		$cpicker.wpColorPicker("option", "change", function(event, ui) {
            originChangeCallback(event, ui);
            self.colorChanged(event, ui);
		})
		this.$cpicker = $cpicker;
		this.opts = opts;
		this.visible = false;

		$rmEl.click(this.removeClicked);

		this.$cpicker.parents(".wp-picker-container:first").find(".wp-color-result").off("click");

		this.onChangePosition = bind(this.onChangePosition, this);
		this.position = new ControlPtPositionUI();
		this.position.onChangePosition(this.onChangePosition);
		this.$cpicker.closest(".wp-picker-input-wrap").after(this.position.getControls());
	}

	ControlPtConfig.prototype = {
		show: function(position, color, listener) {
			this.listener = listener;
            this.$el.css("visibility", "visible");
            this.$cpicker.wpColorPicker("color", color);

			if (!this.visible) {
				this.$cpicker.wpColorPicker("open");
			}

            if (this.opts.orientation === "horizontal") {
				this.$el.css("left", 0);
			} else {
				this.$el.css("top", position.top);
			}

			this.visible = true;
			this.setPosition(listener.position);
		},

		hide: function() {
			if (this.visible) {
				this.$el.css("visibility", "hidden");
				this.visible = false;
			}
		},

		colorChanged: function(event, ui) {
			var color = ui.color.toString();
			this.listener.colorChanged(color);
		},

		removeClicked: function() {
			this.listener.removeClicked();
			this.hide();
		},

		lockCtrlPoints: function() {
			this.$el.addClass("gradientPicker-ctrlPointsLocked");
		},

		unlockCtrlPoints: function() {
            this.$el.removeClass("gradientPicker-ctrlPointsLocked");
		},

		setPosition: function(position) {
			this.position.setPosition(position);
		},

		onChangePosition: function(position) {
			position = parseInt(position);
			if (isNaN(position)) {
				return;
			}
			position = window.Math.max(0, position);
			position = window.Math.min(100, position);

			this.listener.changePosition(position/100);
		}
	};

	function ControlPtPositionUI() {
		this.$positionParent = $('<span class="wp-picker-input-wrap wp-picker-position"><label><span class="screen-reader-text">Control point position</span><input class="point-position" type="number" min="0" max="100" step="1" size="3">%</label></span>');
		this.$input = this.$positionParent.find('.point-position');
	}

	ControlPtPositionUI.prototype = {
		getControls: function() {
			return this.$positionParent;
		},

		setPosition: function(position) {
			this.$input.val(window.Math.round(position * 100));
		},

		getPosition: function() {
			return this.$input.val() | 0;
		},

		onChangePosition: function(callback) {
			this.$input.on('change', {'callback': callback}, this.changePosition);
		},

		changePosition: function(event) {
			event.data.callback($(this).val());
		}
	};

	var methods = {
		init: function(opts) {
			opts = $.extend({
				controlPoints: ["#FFF 0%", "#000 100%"],
                minCtrlPts: 2,
				orientation: "horizontal",
				type: "linear",
				fillDirection: "left",
				generateStyles: true,
                previewWidth: 200,
				previewHeight: 20,
				change: function() {}
			}, opts);

			this.each(function() {
				var $this = $(this);
				var gradSel = new GradientSelection($this, opts);
				$this.data("gradientPicker-sel", gradSel);
			});
		},

		update: function(opts) {
			this.each(function() {
				var $this = $(this);
				var gradSel = $this.data("gradientPicker-sel");
				if (gradSel != null) {
					gradSel.updateOptions(opts);
				}
			});
		}
	};

	$.fn.gradientPicker = function(method, opts) {
		if (typeof method === "string" && method !== "init") {
			methods[method].call(this, opts);
		} else {
			opts = method;
			methods.init.call(this, opts);
		}
	};
})( jQuery );