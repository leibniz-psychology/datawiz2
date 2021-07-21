import "tippy.js/dist/tippy.css";
import "tippy.js/themes/light-border.css";

import "../Styles/codebook.scss";

import Alpine from "alpinejs";
import Tooltip from "@ryangjchandler/alpine-tooltip";
// import Fern from "@ryangjchandler/fern";
import storeFunctions from "./codebook/storeFunctions.js";

import axios from "axios";

Alpine.plugin(Tooltip);
// Alpine.plugin(Fern);
Alpine.store("codebook", {
  filterText: "",
  currentVariableID: "1",
  variables: [],
  ...storeFunctions,
});

Alpine.store("codebookSettings", {
  showHelp: {
    sideBar: true,
  },
});

window.Alpine = Alpine;

Alpine.data("codebook", () => ({
  filteredVariables: [],
  measures: [],

  init() {
    /*    axios
      .get(this.url)
      .then(({ data }) => {
        // console.log("Data from axios.get");
        // console.log(data.variables);
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
  */
    console.log(`Measures-URL: ${this.measuresURL}`);
    axios
      .get(this.measuresURL)
      .then(({ data }) => {
        // console.log("Data from axios.get measuresURL");
        // console.log(data.measures);
        this.measures = data.measures;
        // console.log("Measures");
        // console.log(this.measures);
      })
      .catch((error) => {
        console.log(error);
      });

    // console.log("Data from codebook php dump");
    // console.log(this.codebookDump.variables);
    Alpine.store("codebook").variables = this.codebookDump.variables;
    this.filteredVariables = Alpine.store("codebook").cloneVariables();
    this.$watch(
      'Alpine.store("codebook").filterText',
      () =>
        (this.filteredVariables =
          Alpine.store("codebook").getFilteredVariables())
    );
  },
  save() {
    // console.log(
    //   `Variables to send: ${JSON.stringify(
    //     Alpine.store("codebook").variables,
    //     null,
    //     2
    //   )}`
    // );
    axios({
      method: "post",
      url: this.url,
      data: {
        variables: Alpine.store("codebook").variables,
        id: this.id,
      },
    })
      .then(({ data }) => {
        Alpine.store("codebook").variables = data.variables;
      })
      .catch((error) => {
        console.log(error.toJSON());
      });
  },
}));

Alpine.start();
