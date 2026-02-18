let currentCategory = "food";

/* ---------------- グラフ ---------------- */
function drawCharts(records) {
  const categories = ["food", "sleep", "exercise", "study"];
  const charts = {};

  categories.forEach(cat => {
    const canvas = document.getElementById(cat + "Chart");
    if (!canvas) return;

    const list = records
      .filter(r => r.category === cat)
      .sort((a, b) => new Date(a.date) - new Date(b.date));

    const labels = list.map(r => r.date);
    const values = list.map(r => r.value);

    if (charts[cat]) charts[cat].destroy();

    charts[cat] = new Chart(canvas.getContext('2d'), {
      type: 'line',
      data: {
        labels,
        datasets: [{
          label: getCategoryName(cat),
          data: values,
          tension: 0.3
        }]
      }
    });
  });
}

function getCategoryName(cat) {
  return {
    food: "食事カロリー",
    sleep: "睡眠時間",
    exercise: "運動時間",
    study: "勉強時間"
  }[cat];
}

/* ---------------- タブ切り替え ---------------- */
function setupTabs() {
  document.querySelectorAll(".tab").forEach(tab => {
    tab.addEventListener("click", () => {
      document.querySelectorAll(".tab").forEach(t => t.classList.remove("active"));
      tab.classList.add("active");

      currentCategory = tab.dataset.category;

      filterTableByCategory();
    });
  });
}

/* ---------------- テーブル絞り込み ---------------- */
function filterTableByCategory() {
  const rows = document.querySelectorAll("#recordTable tr");
  rows.forEach(row => {
    if (row.dataset.category === currentCategory) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  });
}

/* ---------------- 検索 ---------------- */
function setupSearch() {
  const input = document.getElementById("searchInput");
  if (!input) return;

  input.addEventListener("input", () => {
    const keyword = input.value.toLowerCase();
    const rows = document.querySelectorAll("#recordTable tr");

    rows.forEach(row => {
      const content = row.querySelector("td:nth-child(3)").textContent.toLowerCase();
      row.style.display = content.includes(keyword) && row.dataset.category === currentCategory ? "" : "none";
    });
  });
}

/* ---------------- モーダル ---------------- */
window.openModal = function () {
  document.getElementById("modal").classList.remove("hidden");

  const labels = {
    food: "食事",
    sleep: "睡眠",
    exercise: "運動",
    study: "勉強"
  };

  document.getElementById("modalCategoryLabel").textContent = labels[currentCategory];
};

window.closeModal = function () {
  document.getElementById("modal").classList.add("hidden");
};

async function resetData() {
  const checkedRows = document.querySelectorAll(".recordCheck:checked");
  if (!checkedRows.length) return alert("削除するデータを選択してください");
  if (!confirm("選択したデータを削除しますか？")) return;

  const ids = Array.from(checkedRows).map(cb => cb.closest("tr").dataset.id);
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

  try {
    await fetch("/record/delete", {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": csrfToken
      },
      body: JSON.stringify({ ids })
    });

    location.reload();
  } catch {
    alert("削除に失敗しました");
  }
}

// Vite でもグローバルで呼べるように window にセット
window.resetData = resetData;




/* ---------------- 初期処理 ---------------- */
document.addEventListener("DOMContentLoaded", () => {

  // グラフ初期描画
  if (document.getElementById("foodChart")) {
    drawCharts(records);
  }

  // テーブル関連
  if (document.getElementById("recordTable")) {
    setupTabs();
    setupSearch();
    filterTableByCategory();
  }

  // フォーム登録処理
  const form = document.getElementById("recordForm");

  if (form) {

  form.addEventListener("submit", async function (e) {

    e.preventDefault();

    const date = document.getElementById("date").value;
    const content = document.getElementById("content").value;
    const value = document.getElementById("value").value;

    const csrfToken = document
      .querySelector('meta[name="csrf-token"]')
      .getAttribute("content");

    try {

      const response = await fetch("/record", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": csrfToken
        },
        body: JSON.stringify({
          category: currentCategory,
          date: date,
          content: content,
          value: value
        })
      });

      const newRecord = await response.json();

      // 画面にも追加
      records.push(newRecord);
      drawCharts(records);

      closeModal();
      form.reset();

    } catch (error) {
      alert("保存に失敗しました");
      console.error(error);
    }

  });

  }

});

document.addEventListener("DOMContentLoaded", () => {

  const checkAll = document.getElementById("checkAll");

  if (checkAll) {
    checkAll.addEventListener("change", () => {

      document.querySelectorAll(".recordCheck").forEach(cb => {
        cb.checked = checkAll.checked;
      });

    });
  }

});
