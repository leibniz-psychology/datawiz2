import "tippy.js/dist/tippy.css";
import "tippy.js/themes/light-border.css";

import "./styles/codebook.scss";

import Alpine from "alpinejs";
import Tooltip from "@ryangjchandler/alpine-tooltip";
import Scroll from "@alpine-collective/toolkit-scroll";

import storeFunctions from "./codebook/storeFunctions.js";

import axios from "axios";

Alpine.plugin(Tooltip);
Alpine.plugin(Scroll);
Alpine.store("codebook", {
  activeTab: "codebook",
  currentVariableID: 1,
  filterText: "",
  variables: [],
  ...storeFunctions,
});

Alpine.store("codebookSettings", {
  showHelp: {
    sideBar: false,
  },
});

window.Alpine = Alpine;

Alpine.data("codebook", () => ({
  filteredVariables: [],
  measures: [],
  matrix: [],
  maxEntries: 20,
  entries: 0,
  showPage: 1,
  maxPages: 1,
  reloadingMatrix: true,

  init() {
    axios
      .get(this.url)
      .then(({ data, status, statusText }) => {
        Alpine.store("codebook").variables = data.variables;
        this.filteredVariables = Alpine.store("codebook").cloneVariables();
        this.$watch(
          'Alpine.store("codebook").filterText',
          () =>
            (this.filteredVariables = JSON.parse(
              JSON.stringify(Alpine.store("codebook").getFilteredVariables())
            ))
        );
      })
      .catch((error) => {
        console.log(error);
      });

    axios
      .get(this.measuresURL)
      .then(({ data, status, statusText }) => {
        this.measures = data.measures;
      })
      .catch((error) => {
        console.log(error);
      });

    this.$watch(
      'Alpine.store("codebook").filterText',
      () =>
        (this.filteredVariables =
          Alpine.store("codebook").getFilteredVariables())
    );
  },
  save() {
    axios({
      method: "post",
      url: this.url,
      data: {
        variables: JSON.parse(
          JSON.stringify(Alpine.store("codebook").variables),
          (key, value) => (value === null || value === "" ? undefined : value)
        ),
        id: this.id,
      },
    })
      .then(({ data, status, statusText }) => {
        Alpine.store("codebook").variables = data.variables;
      })
      .catch((error) => {
        console.log(error.toJSON());
      });
  },
  loadMatrix() {
    const url = `${this.matrixURL}?size=${this.maxEntries}&page=${this.showPage}`;
    axios
      .get(url)
      .then(({ data, status, statusText }) => {
        this.maxPages = data.pagination.max_pages;
        this.entries = data.pagination.max_items;
        this.matrix = data;
        this.reloadingMatrix = false;
      })
      .catch((error) => {
        console.log(error);
      });
  },
  isPageEnd() {
    return this.showPage >= this.maxPages;
  },
  isPageStart() {
    return this.showPage === 1;
  },
  scrollHorizontal(el) {
    el.scrollIntoView({ behavior: "smooth", inline: "center" });
  },
}));

Alpine.data("popup", (item, kind) => ({
  labels: {
    ["x-tooltip.html.theme.light-border.placement.left-start"]() {
      return `
        <ul>
          ${this.$store.codebook
            .getOriginalVariable(item.id)
            [kind].map((item) => {
              return (
                "<li>" +
                item.name +
                `${item.label ? " = " + item.label : ""}` +
                "<li>"
              );
            })
            .join("")}
        </ul>`;
    },
    ["@click"]() {
      document
        .querySelector(
          `.CodeInput_${kind}_${
            this.$store.codebook.getOriginalVariable(item.id)[kind].length - 1
          }`
        )
        .focus();
    },
    ["x-text"]() {
      return this.$store.codebook
        .getOriginalVariable(item.id)
        [kind].map((item) => {
          return item.name + `${item.label ? " = " + item.label : ""}`;
        })
        .join(", ");
    },
  },
}));

Alpine.data("copyValues", () => ({
  showCopyFrom: false,
  showCopyTo: false,
  copyTo: [],
  clearCopyTo() {
    this.showCopyTo = false;
    this.copyTo = [];
  },
  markForCopy(variable) {
    if (this.copyTo.some((item) => item === variable.id)) {
      this.copyTo = this.copyTo.filter((item) => item !== variable.id);
    } else {
      this.copyTo.push(variable.id);
    }
  },
  doCopyTo(propertyToCopy) {
    if (propertyToCopy === "measure")
      this.copyTo.map(
        (item) =>
          (this.$store.codebook.getOriginalVariable(item).measure = JSON.parse(
            JSON.stringify(this.$store.codebook.getCurrentVariable().measure)
          ))
      );
    else if (propertyToCopy === "values")
      this.copyTo.map(
        (item) =>
          (this.$store.codebook.getOriginalVariable(item).values = JSON.parse(
            JSON.stringify(this.$store.codebook.getCurrentVariable().values)
          ))
      );
    else if (propertyToCopy === "missings")
      this.copyTo.map(
        (item) =>
          (this.$store.codebook.getOriginalVariable(item).missings = JSON.parse(
            JSON.stringify(this.$store.codebook.getCurrentVariable().missings)
          ))
      );
    else {
      console.log("No property defined to copy to: ");
      console.log(propertyToCopy);
    }
  },
}));

Alpine.data("codebookHelp", (helpName) => ({
  helpButton: {
    ["@click"]() {
      this.$store.codebookSettings.showHelp.sideBar = true;
      document.getElementById(helpName).toggleAttribute("open");
      this.$store.codebook[helpName] = document
        .getElementById(helpName)
        .hasAttribute("open");
    },
    ["x-bind:class"]() {
      return this.$store.codebook[helpName] === true
        ? "!bg-zpid-blue text-white"
        : "";
    },
  },
}));

Alpine.start();
