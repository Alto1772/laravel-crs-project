// Password input functionality
document.querySelectorAll("[data-peek]").forEach((parentEl) => {
    let passwordInputEl = parentEl.querySelector("input");
    let iconEl = parentEl.querySelector("label > *");

    function removeIconifyClass() {
        let classList = iconEl.classList;
        for (const className of classList) {
            if (className.match(/^icon-/)) {
                classList.remove(className);
                break;
            }
        }
    }

    function changeIcon() {
        removeIconifyClass();
        if (passwordInputEl.value.length > 0) {
            iconEl.classList.add(
                parentEl.dataset.peek === "true"
                    ? "icon-[ion--eye-off-outline]"
                    : "icon-[ion--eye-outline]",
            );
        } else {
            iconEl.classList.add("icon-[ion--lock-closed-outline]");
        }
    }

    parentEl.querySelector("label").addEventListener("click", (event) => {
        event.preventDefault();
        parentEl.dataset.peek = parentEl.dataset.peek === "true" ? false : true;
        passwordInputEl.type =
            parentEl.dataset.peek === "true" ? "text" : "password";
        changeIcon();
    });

    passwordInputEl.addEventListener("input", (event) => {
        changeIcon();
    });
});

// Login tab functionality
let parentTabEl = document.querySelector("[data-current-tab]");
let tabItems = Array.from(parentTabEl.querySelector("nav").children);
let loginContainer = document.querySelector("#login-container");

function updateTabs() {
    tabItems.map((el) => {
        if (el.dataset.tab === parentTabEl.dataset.currentTab) {
            el.classList.remove("bg-gray-800");
            el.classList.add("bg-fuchsia-900");
        } else {
            el.classList.remove("bg-fuchsia-900");
            el.classList.add("bg-gray-800");
        }
    });
}

tabItems.map((el, i) => {
    el.addEventListener("click", () => {
        history.pushState(null, "", el.href);
        parentTabEl.dataset.currentTab = el.dataset.tab;
        loginContainer.style.transform = `translateX(${-(i * 100)}%)`;
        updateTabs();
    });
});
