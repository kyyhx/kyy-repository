<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Live Search Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }

    .container {
      max-width: 800px;
      margin-top: 60px;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    #search {
      font-size: 1.1rem;
    }

    .spinner-border {
      width: 1.5rem;
      height: 1.5rem;
    }

    #loading {
      display: none;
      margin-bottom: 15px;
      animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    thead {
      background-color: #0d6efd;
      color: white;
    }

    table tr td {
      vertical-align: middle;
    }

    .form-title {
      font-size: 1.5rem;
      font-weight: bold;
      color: #0d6efd;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="form-title">Live Search Mahasiswa (AJAX + MySQL)</div>

    <!-- Input Pencarian -->
    <div class="input-group mb-3">
      <span class="input-group-text"><i class="bi bi-search"></i></span>
      <input type="text" id="search" class="form-control" placeholder="Cari berdasarkan NIM atau Nama...">
    </div>

    <!-- Loading Spinner -->
    <div id="loading" class="d-flex align-items-center text-primary">
      <div class="spinner-border me-2" role="status"></div>
      <strong>Mencari data...</strong>
    </div>

    <!-- Tabel Hasil -->
    <table class="table table-hover mt-3">
      <thead>
        <tr>
          <th>ID</th> <!-- Kolom ID ditambahkan -->
          <th>NIM</th>
          <th>Nama</th>
          <th>Jurusan</th>
        </tr>
      </thead>
      <tbody id="result"></tbody>
    </table>
  </div>

<script>
  const searchBox = document.getElementById("search");
  const result = document.getElementById("result");
  const loading = document.getElementById("loading");

  function fetchData(keyword = "", withLoading = false) {
    if (withLoading) {
      loading.style.display = "flex";
    }

    fetch("search.php?keyword=" + encodeURIComponent(keyword))
      .then(response => response.json())
      .then(data => {
        const delay = withLoading ? 1000 : 0;
        setTimeout(() => {
          if (withLoading) loading.style.display = "none";
          result.innerHTML = "";

          if (data.length === 0) {
            result.innerHTML = "<tr><td colspan='4' class='text-center text-muted'>Data tidak ditemukan.</td></tr>";
          } else {
            data.forEach(row => {
              result.innerHTML += `
                <tr>
                  <td>${row.id}</td>
                  <td>${row.nim}</td>
                  <td>${row.nama}</td>
                  <td>${row.jurusan}</td>
                </tr>`;
            });
          }
        }, delay);
      })
      .catch(error => {
        if (withLoading) loading.style.display = "none";
        result.innerHTML = "<tr><td colspan='4' class='text-center text-danger'>Terjadi kesalahan!</td></tr>";
        console.error(error);
      });
  }

  window.addEventListener("DOMContentLoaded", () => {
    fetchData("", false);
  });

  searchBox.addEventListener("keydown", function (event) {
    if (event.key === "Enter") {
      event.preventDefault();
      const keyword = searchBox.value.trim();
      if (keyword.length > 0) {
        fetchData(keyword, true);
      } else {
        fetchData("", false);
      }
    }
  });
</script>

</body>
</html>
