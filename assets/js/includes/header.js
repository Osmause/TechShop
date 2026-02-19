export function initHeader() {
  let dropdownBtn = document.querySelector(".dropbtn");
  let dropdownContent = document.querySelector(".dropdown-content");
  let closeBtn = Array.from(document.querySelectorAll(".close"));
  let titleHeader = document.querySelector(".title-header");
  let searchBtn = document.querySelector(".search-drop");
  let searchBar = document.querySelector(".search-filter");
  let elementsDrop = [titleHeader, searchBtn];

  dropdownBtn.addEventListener("click", () => {
    dropdownContent.style.display = "block";
  });

  searchBtn.addEventListener("click", () => {
    elementsDrop.forEach((el) => (el.style.display = "none"));
    searchBar.style.display = "block";
    searchBtn.dataset.parent = "searchbar";
  });

  closeBtn.forEach((close) => {
    close.addEventListener("click", () => {
      if (searchBtn.getAttribute('data-parent') ===  'dropdown'){
        dropClose(close);
      } else if (searchBtn.getAttribute('data-parent') === 'searchbar'){
        searchFilter(close);
      }
    });
  });

  function searchFilter() {
    elementsDrop.forEach((el) => (el.style.display = "block"));
    searchBar.style.display = "none";
    searchBtn.dataset.parent = "dropdown";
  }

  function dropClose() {
    dropdownContent.style.display = "none";
  }
}
