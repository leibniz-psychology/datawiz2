const addButtons = document.querySelectorAll(".add-another-collection-widget");
const removeButtons = document.querySelectorAll(
  ".remove-another-collection-widget"
);

if (addButtons !== undefined) {
  addButtons.forEach((btn) => {
    btn.addEventListener("click", addItemToCollection);
  });
}

if (removeButtons !== undefined) {
  removeButtons.forEach((btn) => {
    btn.addEventListener("click", removeItemFromCollection);
  });
}

function addItemToCollection(elem) {
  let list = document.querySelector(
    elem.currentTarget.getAttribute("data-list-selector")
  );
  let counter = parseInt(list.getAttribute("data-widget-counter"));
  let newWidget = list.getAttribute("data-prototype");
  newWidget = newWidget.replace(/__name__/g, (++counter).toString());
  list.setAttribute("data-widget-counter", counter.toString());
  list.append(buildListElem(list, newWidget));
}

function removeItemFromCollection(elem) {
  let list = document.querySelector(
    elem.currentTarget.getAttribute("data-list-selector")
  );
  let parentLi = elem.currentTarget.closest("li");
  if (list.children.length > 1) {
    parentLi.remove();
  } else {
    let input = parentLi.querySelectorAll(
      'input[type="text"], input[type="email"], textarea'
    );
    if (input !== undefined && input !== null) {
      input.forEach((i) => {
        i.value = "";
      });
    }
  }
}

/**
 *
 * @param list
 * @param newWidget
 * @returns {Element}
 */
function buildListElem(list, newWidget) {
  let tags = list.getAttribute("data-widget-tags");
  let newElem = document.createElement("template");
  newElem.innerHTML = tags;
  newElem.content.firstElementChild.innerHTML = newWidget;
  newElem.content.firstElementChild.append(buildDeleteButton(list));

  return newElem.content.firstElementChild;
}

/**
 * Create a new delete Button using data-delete-prototype attribute from the passed list element.
 * @param list
 * @returns {Element}
 */
function buildDeleteButton(list) {
  let btnPrototype = list.getAttribute("data-delete-prototype");
  let btn = document.createElement("template");
  btn.innerHTML = btnPrototype;
  btn.content.firstElementChild.addEventListener(
    "click",
    removeItemFromCollection
  );

  return btn.content.firstElementChild;
}
