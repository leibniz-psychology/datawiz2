import Alpine from "alpinejs";
import codebook from "./codebook";

window.Alpine = Alpine;

Alpine.data("codebook", codebook);

Alpine.store("app", { helpSelected: "" });

Alpine.start();
