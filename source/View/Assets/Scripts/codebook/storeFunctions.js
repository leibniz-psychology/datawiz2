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
  getPreviousVariableID() {
    const currentVariableIndex = this.variables.findIndex(
      (variable) => variable.id === this.currentVariableID
    );
    const previousVariableIndex =
      (currentVariableIndex + this.variables.length - 1) %
      this.variables.length;
    return this.variables[previousVariableIndex].id;
  },
  getNextVariableID() {
    const currentVariableIndex = this.variables.findIndex(
      (variable) => variable.id === this.currentVariableID
    );
    const nextVariableIndex =
      (currentVariableIndex + 1) % this.variables.length;
    return this.variables[nextVariableIndex].id;
  },
};
