// Отримання елементів
const searchOverlay = document.getElementById("search-overlay");
const openSearchButton = document.getElementById("open-search");
const closeSearchButton = document.getElementById("close-search");
const searchInput = document.getElementById("search-input");
const searchButton = document.getElementById("search-button");
const searchResults = document.getElementById("search-results");

// Масив з даними для пошуку
const data = [
  { title: "Риболовля", link: "category-fishing.html" },
  { title: "Категорія 1", link: "category-1.html" },
  { title: "Категорія 2", link: "category-2.html" },
  { title: "Товар 1", link: "item-1.html" },
  { title: "Товар 2", link: "item-2.html" },
  { title: "Підкатегорія 1", link: "subcategory-1.html" },
  { title: "Підкатегорія 2", link: "subcategory-2.html" },
  // Додайте більше товарів або категорій
];

// Відкриття вікна пошуку
openSearchButton.addEventListener("click", function () {
  searchOverlay.style.visibility = "visible"; // Відкрити вікно
});

// Закриття вікна пошуку
closeSearchButton.addEventListener("click", function () {
  searchOverlay.style.visibility = "hidden"; // Закрити вікно
  searchResults.innerHTML = ""; // Очистити результати при закритті
});

// Виконання пошуку
searchButton.addEventListener("click", function () {
  const query = searchInput.value.toLowerCase(); // Отримати запит
  if (query) {
    performSearch(query); // Виконати пошук
  }
});

// Функція для виконання пошуку
function performSearch(query) {
  // Фільтрація даних
  const results = data.filter((item) =>
    item.title.toLowerCase().includes(query)
  );

  // Відображення результатів
  if (results.length > 0) {
    searchResults.innerHTML = results
      .map((item) => `<a href="${item.link}">${item.title}</a>`)
      .join("");
  } else {
    searchResults.innerHTML = "<p>Нічого не знайдено</p>"; // Якщо нічого не знайдено
  }
}
