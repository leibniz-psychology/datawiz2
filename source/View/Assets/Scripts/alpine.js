import Alpine from "alpinejs";
import trap from "@alpinejs/trap";

window.Alpine = Alpine;

Alpine.plugin(trap);

Alpine.store("app", { helpSelected: "" });

Alpine.data("fileManagement", () => ({
  showInput: false,
  descriptionText: "",

  saveDescription(url, descriptionText) {
    fetch(url, {
      method: "POST",
      body: descriptionText,
    })
      .then(function (response) {
        if (response.ok) return response.json();
        else throw new Error("Hell no! What happened?");
      })
      .then((data) => {
        console.log(data);
      })
      .catch((error) => {
        console.log(error);
      });
  },

  focusInput(inputID) {
    setTimeout(function () {
      document.querySelector(inputID).focus();
    }, 0);
  },
}));

Alpine.start();
