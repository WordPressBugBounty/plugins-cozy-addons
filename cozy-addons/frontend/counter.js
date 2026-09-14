(function ($) {
	window["cozyBlockCounterInit"] = (e) => {
		const { createTimer, utils } = anime;

		const n = e.replace(/-/gi, "_");
		const blockOptions = window[`cozyCounter_${n}`];
		const counterClass = `#cozyBlock_${n}`;
		const $cozyCounter = $(counterClass);

		if (!$cozyCounter.length) return;

		function isElementInViewport() {
			if (!$cozyCounter || !$cozyCounter.length) return false;

			const rect = $cozyCounter[0].getBoundingClientRect();
			return (
				rect.top >= 0 &&
				rect.left >= 0 &&
				rect.bottom <=
					($(window).height() || document.documentElement.clientHeight) &&
				rect.right <=
					($(window).width() || document.documentElement.clientWidth)
			);
		}

		let animationTriggered = false;

		function addCounterAnimation() {
			if (!$cozyCounter.length) return;

			if (!animationTriggered && isElementInViewport($cozyCounter)) {
				animationTriggered = true;

				const duration = blockOptions.animationDuration
					? Math.abs(blockOptions.animationDuration)
					: 1000;

				const endTarget = blockOptions.endNumber
					? Math.abs(parseFloat(blockOptions.endNumber))
					: 0;
				const endNumberStr = blockOptions.endNumber;
				const decimalPlaces = endNumberStr.includes(".")
					? endNumberStr.split(".")[1].length
					: 0;

				const $counterEl = $(counterClass + " span");

				// ease-out: fast jump at the start, gentle settle at the end
				const easeOutExpo = (t) => (t === 1 ? 1 : 1 - Math.pow(2, -10 * t));

				createTimer({
					duration: duration,
					onUpdate: (self) => {
						const easedProgress = easeOutExpo(self.progress);
						const currentValue = easedProgress * endTarget;
						$counterEl.html(utils.round(currentValue, decimalPlaces));
					},
					onComplete: () => {
						$counterEl.html(utils.round(endTarget, decimalPlaces));
					},
				});
			}
		}

		addCounterAnimation();
		window.addEventListener("scroll", addCounterAnimation);
	};
})(jQuery);
