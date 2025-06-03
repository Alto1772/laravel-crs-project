/**
 * Hides the loading overlay
 * @param {HTMLElement} parentEl
 */
const hideLoadingOverlay = function (parentEl) {
    parentEl.querySelector("#loading-overlay").style.display = "none";
};

/**
 * Updates the loading overlay
 * @param {HTMLElement} parentEl
 * @param {string} type
 */
const updateLoadingOverlay = function (parentEl, type = "loading") {
    let overlayEl = parentEl.querySelector("#loading-overlay");

    overlayEl.classList.remove("bg-error/70");

    switch (type) {
        case "error":
            overlayEl.classList.add("bg-error/70");
            overlayEl.innerHTML = `<span class="icon-[tabler--alert-triangle-filled] size-10 text-error-content"></span>
    <p class="text-lg font-semibold text-error-content">An error occured...</p>`;
            break;
        case "loading":
            overlayEl.innerHTML = `<span class="loading loading-spinner loading-lg text-primary"></span>
    <p class="text-lg font-semibold text-primary">Loading...</p>`;
            break;
    }
};

/**
 * Shows loading overlay
 * @param {HTMLElement} parentEl
 */
const showLoadingOverlay = function (parentEl) {
    parentEl.querySelector("#loading-overlay").style.display = "block";
    updateLoadingOverlay(parentEl);
};

export { showLoadingOverlay, updateLoadingOverlay, hideLoadingOverlay };
