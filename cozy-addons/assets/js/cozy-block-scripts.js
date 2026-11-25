(() => {
	const init = () => {
		// Initialize AOS library.
		setTimeout(() => {
			if (typeof AOS !== "undefined") {
				AOS.init({
					once: true,
				});
			}
		}, 100);
	};

	if (document.readyState === "loading") {
		document.addEventListener("DOMContentLoaded", init);
	} else {
		init();
	}
})();
