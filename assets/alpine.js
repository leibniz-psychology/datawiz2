import Alpine from "alpinejs";
import focus from '@alpinejs/focus'
import List from "list.js";

window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.store("app", { helpSelected: "" });
Alpine.store("import", {
  codebook: [],
});

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

const listOptions = {
  valueNames: ["ExperimentName", "ExperimentTitle"],
  searchDelay: 250,
};

Alpine.data("experimentsList", () => ({
  filterText: "",
  myList: new List("ExperimentsList", listOptions),
  clear() {
    this.myList.search("");
    this.filterText = "";
  },
}));

Alpine.data("helpButton", () => ({
  helpEls: document.querySelectorAll("[id*=details_]"),
  showHelp(formID) {
    const isHighlighted =
      document.getElementById(formID).hasAttribute("open") &&
      this.$store.app.helpSelected;
    this.helpEls.forEach(function (userItem) {
      userItem.removeAttribute("open");
    });
    if (!isHighlighted) {
      document.getElementById(formID).setAttribute("open", "");
      this.$store.app.helpSelected = formID;
    } else {
      document.getElementById(formID).removeAttribute("open");
      this.$store.app.helpSelected = "";
    }
  },
}));

Alpine.start();
