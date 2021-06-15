/**
 * See https://stackoverflow.com/a/57991537
 */

const stickySaveBar = document.querySelector(".WizNavBar");

if (stickySaveBar) {
  const observer = new IntersectionObserver(
    ([e]) =>
      e.target.classList.toggle("WizNavBar_isSticky", e.intersectionRatio < 1),
    { threshold: [1] }
  );

  observer.observe(stickySaveBar);
}
