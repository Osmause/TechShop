export function initHero() {
  let hero = document.querySelector(".hero");
  if (!hero) return;
  hero.addEventListener("click", () => {
    window.location.href = "./pages/product-detail.php";
  });
}
