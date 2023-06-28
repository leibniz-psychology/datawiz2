import Alpine from "alpinejs";
import focus from '@alpinejs/focus'
import List from "list.js";

window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.store("app", { helpSelected: "" });
Alpine.store("import", {
  codebook: [],
});

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
