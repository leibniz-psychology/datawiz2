export default {
  setFilterText(text) {
    this.filterText = text;
  },
  getOriginalVariable(id) {
    return this.variables.filter((variable) => variable.id === id)[0];
  },
  cloneVariables() {
    return JSON.parse(JSON.stringify(this.variables));
  },
  getFilteredVariables() {
    return this.cloneVariables().filter((variable) => {
      return (
        variable.name
          .toLowerCase()
          .includes(this.filterText.toLowerCase().trim()) ||
        variable.label
          .toLowerCase()
          .includes(this.filterText.toLowerCase().trim()) ||
        variable.itemText
          .toLowerCase()
          .includes(this.filterText.toLowerCase().trim())
      );
    });
  },
  getCurrentVariable() {
    let currVar = {};
    if (this.variables.length > 0)
      currVar = this.variables.filter(
        (variable) => variable.id === this.currentVariableID
      )[0];
    return currVar;
  },
};
