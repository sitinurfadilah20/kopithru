<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Menu | Bisnis Kopi Keliling</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      background-image: url('../../../assets/images/coffe.png'); 
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      font-family: 'Poppins', sans-serif;
      margin: 0;
    }

    .overlay {
      background: rgba(0, 0, 0, 0.6);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      animation: fadeIn 1.2s ease;
    }

    .card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(15px);
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.6);
      color: #fff;
      width: 480px;
      animation: slideUp 0.8s ease;
      overflow: hidden;
    }

    .card-header {
      background: linear-gradient(135deg, #6f4e37, #c69c6d);
      border: none;
      text-align: center;
      padding: 25px;
    }

    label {
      color: #f5deb3;
      font-weight: 600;
    }

    input {
      background-color: rgba(255, 255, 255, 0.9) !important;
      border-radius: 12px !important;
    }

    .btn-save {
      background: linear-gradient(135deg, #c69c6d, #a67c52);
      color: #fff;
      border-radius: 25px;
      transition: 0.3s;
      border: none;
      font-weight: 600;
    }
    .btn-save:hover {
      background: linear-gradient(135deg, #a67c52, #8b5e3c);
      transform: scale(1.05);
    }

    .btn-back {
      border-radius: 25px;
      background-color: rgba(255,255,255,0.2);
      color: #fff;
      border: none;
      transition: 0.3s;
      font-weight: 600;
    }
    .btn-back:hover {
      background-color: #6f4e37;
      transform: scale(1.05);
      color: #fff;
    }

    #preview {
      width: 100%;
      border-radius: 15px;
      margin-top: 10px;
      display: none;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideUp {
      from { transform: translateY(40px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
  </style>
</head>
<body>

<div class="overlay">
  <div class="card shadow-lg">
    <div class="card-header text-white">
      <h4 class="mb-0">☕ Tambah Menu Baru</h4>
    </div>

    <div class="card-body p-4">
      <form action="proses_tambah_menu.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label>Nama Menu</label>
          <input type="text" name="nama_menu" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Harga</label>
          <input type="number" name="harga" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Gambar Menu</label>
          <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewImage(event)" required>
          <small class="text-light">Ukuran maksimal 2MB</small>
          <img id="preview" alt="Preview Gambar">
        </div>

        <div class="d-flex justify-content-between mt-4">
          <a href="lihat_menu.php" class="btn btn-back">⬅️ Kembali</a>
          <button type="submit" class="btn btn-save">💾 Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function previewImage(event) {
  const imgPreview = document.getElementById('preview');
  const file = event.target.files[0];
  if (file) {
    imgPreview.style.display = 'block';
    imgPreview.src = URL.createObjectURL(file);
  }
}
</script>

</body>
</html>