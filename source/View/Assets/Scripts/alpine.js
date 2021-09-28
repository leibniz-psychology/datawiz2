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

Alpine.data("modal", () => ({
  showModal: false,

  show() {
    this.showModal = true;
    document.body.classList.add("overflow-hidden");
    this.setFocus();
  },
  hide() {
    this.showModal = false;
    document.body.classList.remove("overflow-hidden");
  },
  setFocus() {
    if (this.$refs.focusFirst) {
      this.$nextTick(() => {
        this.$refs.focusFirst.focus();
      });
    }
  },
  overlay: {
    ["x-show"]() {
      return this.showModal;
    },
    ["x-bind:x-ref"]() {
      return "overlay";
    },
    ["x-trap"]() {
      return this.showModal;
    },
    ["x-transition:enter"]() {
      return "transition ease-out duration-300";
    },
    ["x-transition:enter-start"]() {
      return "opacity-0";
    },
    ["x-transition:enter-end"]() {
      return "opacity-100";
    },
    ["x-transition:leave"]() {
      return "transition ease-in duration-300";
    },
    ["x-transition:leave-start"]() {
      return "opacity-100";
    },
    ["x-transition:leave-end"]() {
      return "opacity-0";
    },
  },
}));

Alpine.start();
