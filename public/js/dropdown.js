
document.addEventListener('DOMContentLoaded', function () {
  const mainCategories = document.querySelectorAll('.dropdown-category');

  mainCategories.forEach(mainCat => {
    mainCat.addEventListener('click', function () {
      const subList = this.nextElementSibling; // 直下のサブカテゴリulを取得
      if (subList) {
        subList.classList.toggle('hidden'); // 表示/非表示を切り替え
      }

      // 矢印回転用クラス切り替え
      this.classList.toggle('active');
    });
  });
});
