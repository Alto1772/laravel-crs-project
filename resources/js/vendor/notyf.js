import { Notyf } from "notyf";

const notyfInstance = new Notyf({
    duration: 3000,
    position: {
        x: "right",
        y: "top",
    },
});

window.Notyf = Notyf;
window.Notyf.instance = notyfInstance;
