/**
 * 2016-07-13
 * VANILLA
*/
/**
 * Return the first match only, context object is optional.
 * Return object HTMLHeadingElement/null(?) if no selector found.
	*/
function $first(selector, context)
{
	return (context || document).querySelector(selector);
}

/**
 * Return a list of matching elements, context object is optional.
 * Return empty NodeList if no selectors found (length = 0).
	*/
function $all(selector, context)
{
	return (context || document).querySelectorAll(selector);
}

/**
 * Set a list of styles like {"width":10px, "height":50px}
 */
function setStyles(el, styles) {
	for (var property in styles)
	{
  	el.style[property] = styles[property];
	}
}

/**
 * Ermittelt aus Liste von DOM-Elementen höchste outer height.
 */
function getMaxOuterHeight(list)
{
	var maxHeight = 0;
	var len = list.length;
	while (len--)
	{
		if (maxHeight < list[len].offsetHeight)
		{
			maxHeight = list[len].offsetHeight;
		}
	}
	return maxHeight;
}

/**
 * Gleicht font-size, Höhe, .line-height des Teasers an Logo-Höhe an.
 * Sowie Teaserbreite an Logobreite.
 * 2021-03 Anpassung an BS5. Breakpoint width muss ab jetzt übergeben werden.
 * z.B. 575.98. Unterhalb wird NICHT angepasst bzw. zurückgesetzt.
 */
function teaserAutoheight(maximalWidth)
{
	if (typeof maximalWidth === "undefined" || maximalWidth === null)
	{
		console.log('function teaserAutoheight(): Error No maximalWidth provided!');
		return;
	}

	var isFloating = true;
	var Teaser = $first("header .div4headteaser");

	if (Teaser)
	{
		var teaser = $first(".teaserghsvs", Teaser);
		var logo = $first("#SITELOGO");

		if (teaser && logo)
		{
			var spans = $all("span", teaser), spanCount = spans.length;

			if (spanCount)
			{
// console.log('maximalWidth: ' + maximalWidth);
// console.log('window.innerWidth: ' + window.innerWidth);
				if (window.innerWidth < maximalWidth)
				{
					var isFloating = false;
				}

				// Falls nicht "floatend", entferne Inline-Stile..
				if (!isFloating)
				{
					setStyles(teaser, {
						"margin":"",
						"padding":"",
						"height":"",
						"width":""
					});

					len = spanCount;

					while (len--)
					{
						setStyles(spans[len], {
							"line-height":"",
							"font-size":"",
							"display":"inline",
							"margin":"",
							"padding":""
						});
					}
					return;
				}

				// Get height of logo image.
				var styleL = window.getComputedStyle
					? getComputedStyle(logo, null) : logo.currentStyle;

				// Adapt height to complete teaser block.
				setStyles(teaser, {
					"height": styleL.height,
					"width": styleL.width,
				});

    		var doHeight = parseInt(styleL.height) / spanCount;
				len = spanCount;

				while (len--)
				{
					setStyles(spans[len], {
						"line-height": doHeight + "px",
						"display": "block",
						"margin": "0"
					});
				}

				var i = 0;
				do
				{
					len = spanCount;

					while (len--) {
						setStyles(spans[len], {
							"font-size": (doHeight - 4 - i) + "px"
						});
					}
					maxHeight = getMaxOuterHeight(spans);
					i++;
					if (i > 2500)
					{
						break;
					}
				}
				while (maxHeight > (doHeight + 1));
			}
		}
	}
};

var ResizerGHSVS = function()
{
	// if (!HidePageHeader)
	{
		teaserAutoheight(575.98);
		jQuery.fn.addActiveStateToDivider();
	}
	jQuery.fn.stickyCompensation(
		"#CfButtonGruppe.sticky-top",
		".isATocId",
		30,
		"stickyCompensation"
	);
}

window.addEventListener("resize",
	function ()
	{
		waitForFinalEvent(function()
		{
    	ResizerGHSVS();
   	}, 500, "fn.ResizerGHSVS");
	}
);


;(function($){
	jQuery(window).on("load", function()
	{
		ResizerGHSVS();
	});
})(jQuery);

/*
// When the user scrolls the page, execute myFunction
// Get the header
var header = document.getElementById("CfMenueOben");

// Get the offset position of the navbar
var sticky = header.offsetTop;

// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
function makeFixed()
{
  if (window.pageYOffset > sticky)
	{
    header.classList.add("sticky");
  }
	else
	{
    header.classList.remove("sticky");
  }
}

window.addEventListener("scroll",
	function ()
	{
		waitForFinalEvent(function()
		{
    	makeFixed();
   	}, 500, "fn.makeFixed");
	}
);
*/
