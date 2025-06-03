import Dropzone from "dropzone";
import merge from "lodash/merge";

window.Dropzone = Dropzone;

if (!window._ || typeof window._ !== "object") {
    window._ = {};
}
Object.assign(window._, { merge });
